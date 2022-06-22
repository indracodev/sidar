<?php
include "auth.php";
$do = $_GET["do"];
$status = "failed";
$pesan = "";
$daJson = array();

if($do == "makeinvoice"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! security key not detected!";
  } else if(!isset($_POST["voucher"])){
    $pesan = "Error! voucher not detected!";
  } else if(!isset($_POST["couriergw"])){
    $pesan = "Error! courier gateway not detected!";
  } else if(!isset($_POST["paymentgw"])){
    $pesan = "Error! payment gateway not detected!";
  } else if(!isset($_POST["note"])){
    $pesan = "Error! note not detected!";
  } else {
    $hash = $_POST["hash"];
    $voucher = $_POST["voucher"];
    $couriergw = $_POST["couriergw"];
    $paymentgw = $_POST["paymentgw"];
    $note = addslashes($_POST["note"]);
    if($hash == ""){
      $pesan = "Sorry! security key cannot be null";
    } else if($couriergw == ""){
      $pesan = "Sorry! courier id cannot be null";
    } else if($paymentgw == ""){
      $pesan = "Sorry! payment ID cannot be null";
    } else {
      include "config.php";
      //Hash checking
      $getHashData = $conn->query("SELECT * FROM apihash WHERE apihash_hash = '".$hash."' ");
      $countHashData = $getHashData->num_rows;
      if($countHashData != 1){
        $pesan = "Sorry! User not found!";
      } else {
        $fetchHashData = $getHashData->fetch_assoc();
        $idUser = $fetchHashData["iduser"];
        if($idUser == ""){
          //Guest
          $hashType = "Guest";
          $idUserIs = $hash;
          $getDestination = $conn->query("SELECT * FROM apicacheaddr WHERE apihash_hash = '".$idUserIs."' ");
          $fetchDestination = $getDestination->fetch_assoc();
          $name         = $fetchDestination["apicacheaddr_name"];
          $address      = $fetchDestination["apicacheaddr_address"];
          $district     = $fetchDestination["apicacheaddr_district"];
          $city         = $fetchDestination["apicacheaddr_city"];
          $province     = $fetchDestination["apicacheaddr_province"];
          $country      = $fetchDestination["apicacheaddr_country"];
          $postalcode   = $fetchDestination["apicacheaddr_postalcode"];

          $firstname = "-";
          $lastname = "-";

          $destCompany  = "";
          $destEmail    = $fetchDestination["apicacheaddr_email"];

          //Generate Email Tanpa Titik
          $emailNoDotPecah = explode("@", $destEmail);
          $emailNoDotHasil = $emailNoDotPecah[0];
          $emailNoDotHasilbelakang = $emailNoDotPecah[1];
          $emailNoDotHasil = str_replace(".", "", $emailNoDotHasil);
          $inputEmailNoDot = $emailNoDotHasil.'@'.$emailNoDotHasilbelakang;

          $destEmaildt  = $inputEmailNoDot;
          $destPhone    = $fetchDestination["apicacheaddr_phone"];
          $notifnews    = "news";

          $getCountryCode = $conn->query("SELECT * FROM countries WHERE name LIKE '%".$country."%' LIMIT 1 ");
          $countCountryCode = $getCountryCode->num_rows;
          if($countCountryCode == 0){
            $pesan = "Sorry! no country detected for shipping";
            $daJson["message"] = $pesan;
            $daJson["status"] = $status;
            $printJson = json_encode($daJson);
            echo $printJson;
            exit();
          }
          $fetchCountryCode = $getCountryCode->fetch_assoc();
          $countrycode = $fetchCountryCode["alpha_2"];
        } else {
          //Member
          $hashType = "Member";
          $idUserIs = $idUser;
          $getDestination = $conn->query("SELECT * FROM masterpelanggan WHERE iduser = '".$idUserIs."' ");
          $fetchDestination = $getDestination->fetch_assoc();
          $name         = $fetchDestination["fullname"];
          $address      = $fetchDestination["alamat"];
          $district     = $fetchDestination["kecamatan"];
          $city         = $fetchDestination["kota"];
          $province     = $fetchDestination["provinsi"];
          $country      = $fetchDestination["negara"];
          $postalcode   = $fetchDestination["kodepos"];

          $firstname    = $fetchDestination["firstname"];
          $lastname     = $fetchDestination["lastname"];

          $destCompany  = $fetchDestination["company"];
          $destEmail    = $fetchDestination["email"];
          $destEmaildt  = $fetchDestination["emailtanpatitik"];
          $destPhone    = $fetchDestination["notelp"];
          $notifnews    = $fetchDestination["setujunews"];
          if($notifnews != ""){
            $notifnews = "news";
          }

          $getCountryCode = $conn->query("SELECT * FROM countries WHERE name LIKE '%".$country."%' LIMIT 1 ");
          $countCountryCode = $getCountryCode->num_rows;
          if($countCountryCode == 0){
            $pesan = "Sorry! no country detected for shipping";
            $daJson["message"] = $pesan;
            $daJson["status"] = $status;
            $printJson = json_encode($daJson);
            echo $printJson;
            exit();
          }
          $fetchCountryCode = $getCountryCode->fetch_assoc();
          $countrycode = $fetchCountryCode["alpha_2"];
        }
        //Address value Checker
        if($address == ""){
          $pesan = "Sorry! address must be filled!";
        } else if($district == ""){
          $pesan = "Sorry! district must be filled!";
        } else if($city == ""){
          $pesan = "Sorry! city must be filled!";
        } else if($province == ""){
          $pesan = "Sorry! province must be filled!";
        } else if($country == ""){
          $pesan = "Sorry! country must be filled!";
        } else if($postalcode == ""){
          $pesan = "Sorry! postal code must be filled!";
        } else {

          //Recheck Price
          $getCheckData = $conn->query("SELECT * FROM draftcart WHERE iduser = '".$idUserIs."' ");
          while($fetchCheckData = $getCheckData->fetch_assoc()){
            $checkCartID = $fetchCheckData["idcart"];
            $checkItemID = $fetchCheckData["idproduk"];
            $checkItemQty = $fetchCheckData["qty"];
            $getRealItem = $conn->query("SELECT * FROM masterproduk WHERE idproduk = '".$checkItemID."' ");
            $countRealItem = $getRealItem->num_rows;
            if($countRealItem != 1){
              //Product Not Isset
              $conn->query("DELETE FROM draftcart WHERE idcart = '".$checkCartID."' ");
            } else {
              $fetchRealItem = $getRealItem->fetch_assoc();
              //Status checker
              $realItemStatus = $fetchRealItem["status"];
              if($realItemStatus != 'aktif'){
                $conn->query("DELETE FROM draftcart WHERE idcart = '".$checkCartID."' ");
              } else {
                //get Real Price
                $productNamaProduk        = $fetchRealItem["namaproduk"];
                $productShortDesc         = $fetchRealItem["shortdescription"];
                $productGambar            = $fetchRealItem["gambar"];
                $productHarga             = $fetchRealItem["harga"];
                $productQty               = $checkItemQty;
                $productDiskons           = $fetchRealItem["hargadiskon"];
                if($productDiskons > 0 || $productDiskons != ""){
                  $productDiskon = $fetchRealItem["hargadiskon"];
                } else {
                  $productDiskon = 0;
                }
                $productTax               = 0;
                if($productDiskon > 0){
                  $productSubtotal1      = $productDiskon + $productTax;
                  $productSubtotal       = $productSubtotal1 * $productQty;
                } else {
                  $productSubtotal1      = $productHarga + $productTax;
                  $productSubtotal       = $productSubtotal1 * $productQty;
                }
                $productBawahNama         = $fetchRealItem["bawahnama"];
                $productBerat             = $fetchRealItem["berat"];
                $productPanjang           = $fetchRealItem["panjang"];
                $productLebar             = $fetchRealItem["lebar"];
                $productTinggi            = $fetchRealItem["tinggi"];
                //Query Update
                $conn->query("UPDATE draftcart SET
                namaproduk = '".$productNamaProduk."',
                shortdescription = '".$productShortDesc."',
                gambar = '".$productGambar."',
                harga = '".$productHarga."',
                diskon = '".$productDiskon."',
                tax = '".$productTax."',
                subtotal = '".$productSubtotal."',
                bawahnama = '".$productBawahNama."',
                berat = '".$productBerat."',
                panjang = '".$productPanjang."',
                lebar = '".$productLebar."',
                tinggi = '".$productTinggi."'
                WHERE cartid = '".$checkCartID."' ");
              }
            }
          }

          //Count Berat
          $getCartData = $conn->query("SELECT * FROM draftcart WHERE iduser = '".$idUserIs."' ");
          $beratDB = 0;
          $cartSubtotal = 0;
          while($fetchCartData = $getCartData->fetch_assoc()){
            //Count Berat

            $thisBeratDB = $fetchCartData["berat"];
            $thisQty = $fetchCartData["qty"];
            $thisTotalBerat = $thisBeratDB * $thisQty;
            $beratDB = $beratDB + $thisTotalBerat;

            //Count Subtotal
            $thisSubtotal = $fetchCartData["subtotal"];
            $cartSubtotal = $cartSubtotal + $thisSubtotal;
          }
          if($beratDB > 1){
          $panjangPaket = 75;
          }else{
          $panjangPaket = 30;
          }
          //API start
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, "https://api.easyship.com/rate/v1/rates");
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
          curl_setopt($ch, CURLOPT_HEADER, FALSE);
          curl_setopt($ch, CURLOPT_POST, TRUE);
          curl_setopt($ch, CURLOPT_POSTFIELDS, "{
            \"origin_country_alpha2\": \"sg\",
            \"origin_postal_code\": \"238897\",
            \"destination_country_alpha2\": \"$countrycode\",
            \"destination_postal_code\": \"$postalcode\",
            \"taxes_duties_paid_by\": \"Sender\",
            \"is_insured\": false,
            \"items\": [
              {
                \"actual_weight\": $beratDB,
                \"sku\": \"test\",
                \"height\": 30,
                \"width\": 30,
                \"length\": $panjangPaket,
                \"category\": \"Dry Food & Supplements\",
                \"declared_currency\": \"SGD\",
                \"declared_customs_value\": 10
              }
            ]
          }");
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer prod_bbzjPNveJC+gSLXI24f+oVEMMmyzO+LW2OWokIBqPhw="
          ));
          $response = curl_exec($ch);
          curl_close($ch);
          if($response){
            $dataJson = json_decode($response, true);
            if(!isset($dataJson['rates'])){
              $pesan = "Sorry! rates not found";
              $daJson["message"] = $pesan;
              $daJson["status"] = $status;
              $printJson = json_encode($daJson);
              echo $printJson;
              exit();
            }
            $countJson = count($dataJson['rates']);
          } else {
            $pesan = "Sorry! connection problem";
            $daJson["message"] = $pesan;
            $daJson["status"] = $status;
            $printJson = json_encode($daJson);
            echo $printJson;
            exit();
          }
          //Loop while
          for($pid = 0; $pid < $countJson; $pid++){
            $shippingRate = $dataJson['rates'][$pid]["total_charge"];
            $courierName = $dataJson['rates'][$pid]["courier_name"];
            //Exeptions
            if($courierName == "Ninja Van - Express"){
              $shippingRateView = $shippingRate + 5;
            } else if($courierName == "DHL eCommerce - Packet International" || $courierName == "DHL eCommerce - Packet Plus" || $courierName == "DHL eCommerce - Packet International Direct" || $courierName == "DHL eCommerce - Parcel Direct US"){
              $shippingRateView = $shippingRate + 4;
            } else {
              $shippingRateView = $shippingRate;
            }
            //Init Shipping
            $checkoutCourierID    = $dataJson['rates'][$pid]["courier_id"];
            if($couriergw == $checkoutCourierID){
              //Found Shipping
              $checkoutDisplayName  = $dataJson['rates'][$pid]["courier_display_name"];
              $checkoutShipTotal    = $shippingRateView;
              $checkoutCurrency     = $dataJson['rates'][$pid]["currency"];
            }
          }
          //Shipping result check
          if($checkoutDisplayName == ""){
            $pesan = "Sorry! checkout shipping name not found";
          } else if($checkoutShipTotal == ""){
            $pesan = "Sorry! checkout shipping shipment total not found";
          } else if($checkoutCurrency == ""){
            $pesan = "Sorry! checkout shipping currency not found";
          } else {
            //Generate Order Code
            $plusplus = 1;
            $genNomerOrder = $plusplus."/".date("Ymd");
            $getNomerOrder = $conn->query("SELECT * FROM daftarorder WHERE nomerorder = '".$genNomerOrder."' ");
            $countNomerOrder = $getNomerOrder->num_rows;
            while($countNomerOrder != 0){
              $plusplus++;
              $genNomerOrder = $plusplus."/".date("Ymd");
              $getNomerOrder = $conn->query("SELECT * FROM daftarorder WHERE nomerorder = '".$genNomerOrder."' ");
              $countNomerOrder = $getNomerOrder->num_rows;
            }

            //Check Voucher INI WAJIB DIEDIT
            $discountVoucher = 0;
            $vouchName = NULL;
            $couponKode = NULL;
            $persdiskon = NULL;
            $resultDiscount = 0;
            $vouchTerbilang = NULL;
            if($voucher == "KUDAPONI666"){
              //Skema Voucher 1
              $vouchMem = "Member";
              $vouchName = "KUDAPONI 6%";
              $vouchNominal = 0;
              $vouchPersen = 6;
              $vouchTerbilang = "6%";
              if($vouchMem != $hashType){
                $pesan = "Sorry! This voucher is valid for member only";
              } else {
                if($vouchPersen != 0 && $vouchNominal == 0){
                  //If Persen
                  $diskonCount1 = $cartSubtotal * $vouchPersen;
                  $diskonCount2 = $diskonCount1 / 100;
                  $resultDiscount = $diskonCount2;
                  $persdiskon = $vouchPersen;
                } else if($vouchPersen == 0 && $vouchNominal != 0){
                  //If Nominal
                  $persdiskon = $vouchNominal;
                } else {
                  //No Disc
                  $resultDiscount = 0;
                  $persdiskon = 0;
                }
              }
            } else if($voucher == "TOLAKBALA69"){
              //Skema Voucher 2
              $vouchMem = "Guest";
              $vouchName = "TOLAKBALA 69";
              $vouchNominal = floatval(6.9);
              $vouchPersen = 0;
              $vouchTerbilang = "$6.9";
              if($hashType == "Guest" || $hashType == "Member"){
                if($vouchPersen != 0 && $vouchNominal == 0){
                  //If Persen
                  $diskonCount1 = $cartSubtotal * $vouchPersen;
                  $diskonCount2 = $diskonCount1 / 100;
                  $resultDiscount = $diskonCount2;
                  $persdiskon = $resultDiscount;
                } else if($vouchPersen == 0 && $vouchNominal != 0){
                  //If Nominal
                  $persdiskon = $vouchNominal;
                } else {
                  //No Disc
                  $resultDiscount = 0;
                  $persdiskon = $resultDiscount;
                }
              } else {
                $pesan = "Sorry! This voucher is valid for member only";
              }
            }

            //Payment Gateway Filter
            if($paymentgw == "paypal"){
              $paymentgwdb = "paypal";
            } else if($paymentgw == "alipay" || $paymentgw == "googlepay" || $paymentgw == "applepay" || $paymentgw == "creditcard"){
              $paymentgwdb = "stripe";
            } else {
              $paymentgwdb = "error";
            }

            //Count Order Total
            $grandTotal1 = $cartSubtotal - $persdiskon;
            $grandTotal2 = $grandTotal1 + $shippingRateView;
            $grandTotal = $grandTotal2;

            //Init Order Parameter
            $dateNow = date("Y-m-d");
            $timeNow = date("h:i:s");
            $statusNow = "onhold";
            $taxNow = 0;
            $alamatdua = "-";
            $destnote = $note;

            //Write to DB Invoice
            $conn->query("INSERT INTO daftarorder VALUES(
              NULL,
              '".$genNomerOrder."',
              '".$idUserIs."',
              '".$dateNow."',
              '".$timeNow."',
              '".$statusNow."',
              '".$cartSubtotal."',
              '".$persdiskon."',
              '".$vouchName."',
              '".$voucher."',
              '".$vouchTerbilang."',
              '".$taxNow."',
              '".$shippingRateView."',
              '".$grandTotal."',
              '".$paymentgwdb."',
              '".$checkoutDisplayName."',
              '".$name."',
              '".$firstname."',
              '".$lastname."',
              '".$countrycode."',
              '".$province."',
              '".$city."',
              '".$district."',
              '".$address."',
              '".$alamatdua."',
              '".$postalcode."',
              '".$destCompany."',
              '".$destEmail."',
              '".$destEmaildt."',
              '".$destPhone."',
              '".$destnote."',
              '".$notifnews."'
            )");

            //transaction method
            $conn->query("INSERT INTO apimethod VALUES (NULL, '".$genNomerOrder."', '".$paymentgw."', NULL)");


            //Detail cart
            $drawOrderDetail = $conn->query("SELECT * FROM draftcart WHERE iduser = '".$idUserIs."' ");
            while($fetchOrderDetail = $drawOrderDetail->fetch_assoc()){
              $detailID = $fetchOrderDetail["idproduk"];
              $detailNama = $fetchOrderDetail["namaproduk"];
              $detailGambar = $fetchOrderDetail["gambar"];
              $detailDiskon = $fetchOrderDetail["diskon"];
              $detailTxtDiskon = "-";
              $detailTax = $fetchOrderDetail["tax"];
              $detailHarga = $fetchOrderDetail["harga"];
              $detailQty = $fetchOrderDetail["qty"];
              $detailSubTotal = $fetchOrderDetail["subtotal"];
              $detailNote = "-";
              $detailReview = "";

              $getOrderOrigin = $conn->query("SELECT harga FROM masterproduk WHERE idproduk = '".$detailID."' ");
              $fetchOrderOrigin = $getOrderOrigin->fetch_assoc();
              $orderOriginHarga = $fetchOrderOrigin["harga"];

              $conn->query("INSERT INTO daftarorderdetail VALUES(
                NULL,
                '".$genNomerOrder."',
                '".$detailID."',
                '".$idUserIs."',
                '".$detailNama."',
                '".$detailGambar."',
                '".$detailDiskon."',
                '".$vouchName."',
                '".$detailTax."',
                '".$detailHarga."',
                '".$orderOriginHarga."',
                '".$detailQty."',
                '".$detailSubTotal."',
                '".$detailNote."',
                '".$detailReview."'
              )");

            }
            //Deleting Cart
            $conn->query("DELETE FROM draftcart WHERE iduser = '".$idUserIs."' ");

            //Done
            $status = "Success";
            $pesan = "Invoice has been created";
            $daJson["invoice"] = $genNomerOrder;
          }
        }
      }
    }
  }

} else {
  $pesan = "Error! No action detected!";
}
$daJson["message"] = $pesan;
$daJson["status"] = $status;
$printJson = json_encode($daJson);
echo $printJson;
exit();
?>
