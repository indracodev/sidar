<?php
include "auth.php";
$do = $_GET["do"];
$status = "failed";
$pesan = "";
$daJson = array();

if($do == "expedition"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! no security key found";
  } else {
    $hash = $_POST["hash"];
    if($hash == ""){
      $pesan = "Sorry! security key cannot be null!";
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
          $idUserIs = $hash;
          $getDestination = $conn->query("SELECT * FROM apicacheaddr WHERE apihash_hash = '".$idUserIs."' ");
          $fetchDestination = $getDestination->fetch_assoc();
          $address      = $fetchDestination["apicacheaddr_address"];
          $district     = $fetchDestination["apicacheaddr_district"];
          $city         = $fetchDestination["apicacheaddr_city"];
          $province     = $fetchDestination["apicacheaddr_province"];
          $country      = $fetchDestination["apicacheaddr_country"];
          $postalcode   = $fetchDestination["apicacheaddr_postalcode"];
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
          $idUserIs = $idUser;
          $getDestination = $conn->query("SELECT * FROM masterpelanggan WHERE iduser = '".$idUserIs."' ");
          $fetchDestination = $getDestination->fetch_assoc();
          $address      = $fetchDestination["alamat"];
          $district     = $fetchDestination["kecamatan"];
          $city         = $fetchDestination["kota"];
          $province     = $fetchDestination["provinsi"];
          $country      = $fetchDestination["negara"];
          $postalcode   = $fetchDestination["kodepos"];

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

          $getCountryCode = $conn->query("SELECT * FROM countries WHERE name LIKE '%".$countrycode."%' LIMIT 1 ");
          $countCountryCode = $getCountryCode->num_rows;
          if($countCountryCode == 0){
            $pesan = "Sorry! no country detected for shipping";
            $daJson["message"] = $pesan;
            $daJson["status"] = $status;
            $printJson = json_encode($daJson);
            echo $printJson;
            exit();
          }
        }
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
          //Count Berat
          $getCartData = $conn->query("SELECT * FROM draftcart WHERE iduser = '".$idUserIs."' ");
          $beratDB = 0;
          while($fetchCartData = $getCartData->fetch_assoc()){
            $thisBeratDB = $fetchCartData["berat"];
            $thisQty = $fetchCartData["qty"];
            $thisTotalBerat = $thisBeratDB * $thisQty;
            $beratDB = $beratDB + $thisTotalBerat;
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
            //Write Json
            $daJson[$pid]["no"] = $pid;
            $daJson[$pid]["courierid"] = $dataJson['rates'][$pid]["courier_id"];
            $daJson[$pid]["couriername"] = $dataJson['rates'][$pid]["courier_display_name"];
            $daJson[$pid]["totalcharge"] = $shippingRateView;
            $daJson[$pid]["currency"] = $dataJson['rates'][$pid]["currency"];
            $daJson[$pid]["deliverymin"] = $dataJson['rates'][$pid]["min_delivery_time"];
            $daJson[$pid]["deliverymax"] = $dataJson['rates'][$pid]["max_delivery_time"];
          }
          $status = "Success";
          $printJson = json_encode($daJson);
          echo $printJson;
          exit();
        }
      }
    }
  }
} else {
  $pesan = "Error! No action found!";
}

$daJson["message"] = $pesan;
$daJson["status"] = $status;
$printJson = json_encode($daJson);
echo $printJson;
exit();
?>
