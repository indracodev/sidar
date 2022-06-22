<?php
include "auth.php";
$do = $_GET["do"];
$status = "failed";
$pesan = "";
$daJson = array();

if($do == "minsert"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! security key not found!";
  } else if(!isset($_POST["id"])){
    $pesan = "Error! product not found!";
  } else if(!isset($_POST["qty"])){
    $pesan = "Error! quantity not found!";
  } else {
    $hash = $_POST["hash"];
    $productID = $_POST["id"];
    $qty = $_POST["qty"];
    if($hash == ""){
      $pesan = "Sorry! security key cannot be empty!";
    } else if($productID == ""){
      $pesan = "Sorry! product cannot be empty!";
    } else if($qty == ""){
      $pesan = "Sorry! quantity cannot be empty!";
    } else if($qty <= 0){
      $pesan = "Sorry! quantity minimum 1pcs";
    } else {
      include "config.php";
      //Hash checking
      $getHashData = $conn->query("SELECT * FROM apihash WHERE apihash_hash = '".$hash."' ");
      $countHashData = $getHashData->num_rows;
      $getProductData = $conn->query("SELECT * FROM masterproduk WHERE idproduk = '".$productID."' AND status = 'aktif' ");
      $countProductData = $getProductData->num_rows;
      //Data Checking
      if($countHashData != 1){
        $pesan = "Sorry! User not found!";
      } else if($countProductData != 1){
        $pesan = "Sorry! Product not found or inactive!";
      } else {
        //Quantity checking
        $fetchProductData = $getProductData->fetch_assoc();
        $thisProductQty = $fetchProductData["jumlahstock"];
        if($qty > $thisProductQty){
          $pesan = "Sorry! not enough stock, please lower your quantity";
        } else {
          //User role Checking
          $fetchHashData = $getHashData->fetch_assoc();
          $idUserActive = $fetchHashData["iduser"];
          if($idUserActive == ""){
            //User is a Guest
            $userCallData = $hash;
          } else {
            //User is a member
            $userCallData = $idUserActive;
          }
          //Checking cart availability
          $getCartIsset = $conn->query("SELECT * FROM draftcart WHERE iduser = '".$userCallData."' AND idproduk = '".$productID."' ");
          $countCartIsset = $getCartIsset->num_rows;
          if($countCartIsset == 0){
            //Insert
            $productNamaProduk        = $fetchProductData["namaproduk"];
            $productShortDesc         = $fetchProductData["shortdescription"];
            $productGambar            = $fetchProductData["gambar"];
            $productHarga             = $fetchProductData["harga"];
            $productQty               = $qty;
            $productDiskons           = $fetchProductData["hargadiskon"];
            if($productDiskons > 0 || $productDiskons != ""){
              $productDiskon = $fetchProductData["hargadiskon"];
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
            $productBawahNama         = $fetchProductData["bawahnama"];
            $productIDproductStripe   = "N/A";
            $productIDpriceStripe     = "N/A";
            $productBerat             = $fetchProductData["berat"];
            $productPanjang           = $fetchProductData["panjang"];
            $productLebar             = $fetchProductData["lebar"];
            $productTinggi            = $fetchProductData["tinggi"];
            $productNote              = "-";
            //Query Insert
            $conn->query("INSERT INTO draftcart VALUES(
              NULL,
              '".$userCallData."',
              '".$userCallData."',
              '".$productID."',
              '".$productNamaProduk."',
              '".$productShortDesc."',
              '".$productGambar."',
              '".$productHarga."',
              '".$productQty."',
              '".$productDiskon."',
              '".$productTax."',
              '".$productSubtotal."',
              '".$productBawahNama."',
              '".$productIDproductStripe."',
              '".$productIDpriceStripe."',
              '".$productBerat."',
              '".$productPanjang."',
              '".$productLebar."',
              '".$productTinggi."',
              '".$productNote."'
            )");
            $status = "Success";
          } else {
            //Update
            $fetchCartIsset = $getCartIsset->fetch_assoc();
            $cartProdID = $fetchCartIsset["idproduk"];
            $cartIDs = $fetchCartIsset["idcart"];
            $getcartProductData = $conn->query("SELECT * FROM masterproduk WHERE idproduk = '".$cartProdID."' ");
            //get Product
            $fetchProductData         = $getcartProductData->fetch_assoc();
            $productHarga             = $fetchProductData["harga"];
            $productDiskons           = $fetchProductData["hargadiskon"];
            if($productDiskons > 0 || $productDiskons != ""){
              $productDiskon = $fetchProductData["hargadiskon"];
            } else {
              $productDiskon = 0;
            }
            $productTax               = 0;
            if($productDiskon > 0){
              $productSubtotal1      = $productDiskon + $productTax;
              $productSubtotal       = $productSubtotal1 * $qty;
            } else {
              $productSubtotal1      = $productHarga + $productTax;
              $productSubtotal       = $productSubtotal1 * $qty;
            }
            $conn->query("UPDATE draftcart SET
              qty = '".$qty."',
              diskon = '".$productDiskon."',
              tax = '".$productTax."',
              subtotal = '".$productSubtotal."'
              WHERE idcart = '".$cartIDs."'
              ");
            $status = "Success";
          }
        }
      }
    }
  }
} else if($do == "sumcart"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! no security key detected!";
  } else {
    $hash = $_POST["hash"];
    if($hash == ""){
      $pesan = "Sorry! security key cannot be empty!";
    } else {
      include "config.php";
      $getHashData = $conn->query("SELECT * FROM apihash WHERE apihash_hash = '".$hash."' ");
      $countHashData = $getHashData->num_rows;
      if($countHashData != 1){
        $pesan = "Sorry! no user found";
      } else {
        $fetchHashData = $getHashData->fetch_assoc();
        $idUser = $fetchHashData["iduser"];
        if($idUser == ""){
          //Guest
          $idUserIs = $hash;
        } else {
          //Member
          $idUserIs = $idUser;
        }
        //get Cart Data
        $getCartData = $conn->query("SELECT * FROM draftcart WHERE iduser = '".$idUserIs."' ");
        $totalcart = 0;
        $qtycart = 0;
        while($fetchCartData = $getCartData->fetch_assoc()){
          $subtotal = $fetchCartData["subtotal"];
          $totalcart = $totalcart + $subtotal;
          $prdqtytot = $fetchCartData["qty"];
          $qtycart = $qtycart + $prdqtytot;
        }
        $daJson["carttotal"] = $totalcart;
        $daJson["qtytotal"] = $qtycart;
        $daJson["status"] = "Success";
        $printJson = json_encode($daJson);
        echo $printJson;
        exit();
      }
    }
  }

} else if($do == "showcart"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! security code is not found!";
  } else {
    $hash = $_POST["hash"];
    if($hash == ""){
      $pesan = "Error! security code is empty!";
    } else {
      include "config.php";
      $getApiHash = $conn->query("SELECT * FROM apihash WHERE apihash_hash = '".$hash."' ");
      $countApiHash = $getApiHash->num_rows;
      if($countApiHash == 1){
        $fetchApiHash = $getApiHash->fetch_assoc();
        $iduser = $fetchApiHash["iduser"];
        if($iduser != ""){
          //Member
          $idUserIs = $iduser;
        } else {
          //Visitor
          $idUserIs = $hash;
        }

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

        //Write Array
        $getCart = $conn->query("SELECT * FROM draftcart WHERE iduser = '".$idUserIs."' ");
        $pid = 0;
        while($fetchCart = $getCart->fetch_assoc()){
          $fcrtProdId = $fetchCart["idproduk"];
          $activeVal = "aktif";
          $getStock = $conn->query("SELECT jumlahstock FROM masterproduk WHERE idproduk = '".$fcrtProdId."' AND status = '".$activeVal."' ");
          $countStock = $getStock->num_rows;
          if($countStock == 1){
            $fcrtStatVal = "active";
            $fetchStock = $getStock->fetch_assoc();
            $fcrtProdStock = $fetchStock["jumlahstock"];
          } else {
            $fcrtStatVal = "inactive";
            $fcrtProdStock = 0;
          }

          $daJson[$pid]["cartid"] = $fetchCart["idcart"];
          $daJson[$pid]["id"] = $fcrtProdId;
          $daJson[$pid]["status"] = $fcrtStatVal;
          $daJson[$pid]["stock"] = $fcrtProdStock;
          $daJson[$pid]["productname"] = $fetchCart["namaproduk"];
          $daJson[$pid]["stock"] = $fcrtProdStock;
          $daJson[$pid]["shortdesc"] = $fetchCart["shortdescription"];
          $daJson[$pid]["img"] = $fetchCart["gambar"];
          $daJson[$pid]["price"] = $fetchCart["harga"];
          $daJson[$pid]["qty"] = $fetchCart["qty"];
          $daJson[$pid]["disc"] = $fetchCart["diskon"];
          $daJson[$pid]["tax"] = $fetchCart["tax"];
          $daJson[$pid]["subtotal"] = $fetchCart["subtotal"];
          $daJson[$pid]["subname"] = $fetchCart["bawahnama"];
          $daJson[$pid]["weight"] = $fetchCart["berat"];
          $daJson[$pid]["lenght"] = $fetchCart["panjang"];
          $daJson[$pid]["width"] = $fetchCart["lebar"];
          $daJson[$pid]["height"] = $fetchCart["tinggi"];
          $daJson[$pid]["note"] = $fetchCart["note"];

          $pid++;
        }
        $status = "Success";
        $printJson = json_encode($daJson);
        echo $printJson;
        exit();
      } else {
        $pesan = "Sorry! no hash found!";
      }
    }
  }
} else if($do == "insert"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! theres no security key found!";
  } else if(!isset($_POST["id"])){
    $pesan = "Error! no product found!";
  } else if(!isset($_POST["qty"])){
    $pesan = "Error! No quantity found!";
  } else {
    $hash = $_POST["hash"];
    $prdID = $_POST["id"];
    $qty = $_POST["qty"];
    if($hash == ""){
      $pesan = "Sorry! Hash cannot be empty!";
    } else if($prdID == ""){
      $pesan = "Sorry! Product cannot be empty!";
    } else if($qty == ""){
      $pesan = "Sorry! Quantity cannot be empty!";
    } else if($qty == 0){
      $pesan = "Sorry! quantity must be at least 1 item!";
    } else {
      include "config.php";
      $getHashdata = $conn->query("SELECT * FROM apihash WHERE apihash_hash = '".$hash."' ");
      $countHashdata = $getHashdata->num_rows;
      $aktifVal = "aktif";
      $getProductData = $conn->query("SELECT * FROM masterproduk WHERE idproduk = '".$prdID."' AND status = '".$aktifVal."' ");
      $countProductData = $getProductData->num_rows;
      if($countHashdata != 1){
        $pesan = "Sorry, action cannot be perform. User data is not found";
      } else if($countProductData != 1){
        $pesan = "Sorry, action cannot be perform. Product data is not found or product is inactive";
      } else {
        //Login User Check
        $fetchHashdata = $getHashdata->fetch_assoc();
        $idUser = $fetchHashdata["iduser"];
        if($idUser != ""){
          $useris = $idUser;
        } else {
          $useris = $hash;
        }

        //Checking Isset cart
        $issetCart = $conn->query("SELECT * FROM draftcart WHERE iduser = '".$useris."' AND idproduk = '".$prdID."' ");
        $countIssetCart = $issetCart->num_rows;
        if($countIssetCart == 0){
          //Add Product To Cart
          $fetchProductData = $getProductData->fetch_assoc();
          $productNamaProduk        = $fetchProductData["namaproduk"];
          $productShortDesc         = $fetchProductData["shortdescription"];
          $productGambar            = $fetchProductData["gambar"];
          $productHarga             = $fetchProductData["harga"];
          $productQty               = $qty;
          $productDiskons            = $fetchProductData["hargadiskon"];
          if($productDiskons > 0 || $productDiskons != ""){
            $productDiskon = $fetchProductData["hargadiskon"];
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
          $productBawahNama         = $fetchProductData["bawahnama"];
          $productIDproductStripe   = "N/A";
          $productIDpriceStripe     = "N/A";
          $productBerat             = $fetchProductData["berat"];
          $productPanjang           = $fetchProductData["panjang"];
          $productLebar             = $fetchProductData["lebar"];
          $productTinggi            = $fetchProductData["tinggi"];
          $productNote              = "-";
          //Query Insert
          $conn->query("INSERT INTO draftcart VALUES(
            NULL,
            '".$useris."',
            '".$useris."',
            '".$prdID."',
            '".$productNamaProduk."',
            '".$productShortDesc."',
            '".$productGambar."',
            '".$productHarga."',
            '".$productQty."',
            '".$productDiskon."',
            '".$productTax."',
            '".$productSubtotal."',
            '".$productBawahNama."',
            '".$productIDproductStripe."',
            '".$productIDpriceStripe."',
            '".$productBerat."',
            '".$productPanjang."',
            '".$productLebar."',
            '".$productTinggi."',
            '".$productNote."'
          )");
          $status = "Success";
        } else {
          //Modify Cart
          $fetchIssetCart = $issetCart->fetch_assoc();
          $thisCartID = $fetchIssetCart["idcart"];
          $oldqty                   = $fetchIssetCart["qty"];
          //get Product
          $fetchProductData         = $getProductData->fetch_assoc();
          $productHarga             = $fetchProductData["harga"];
          $productDiskons           = $fetchProductData["hargadiskon"];

          $newqty                   = $oldqty + $qty;
          if($productDiskons > 0 || $productDiskons != ""){
            $productDiskon = $fetchProductData["hargadiskon"];
          } else {
            $productDiskon = 0;
          }
          $productTax               = 0;
          if($productDiskon > 0){
            $productSubtotal1      = $productDiskon + $productTax;
            $productSubtotal       = $productSubtotal1 * $newqty;
          } else {
            $productSubtotal1      = $productHarga + $productTax;
            $productSubtotal       = $productSubtotal1 * $newqty;
          }

          $conn->query("UPDATE draftcart SET
            qty = '".$newqty."',
            diskon = '".$productDiskon."',
            tax = '".$productTax."',
            subtotal = '".$productSubtotal."'
            WHERE idcart = '".$thisCartID."'
          ");
          $status = "Success";
        }

      }
    }
  }
} else if($do == "update"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! no security key found!";
  } else if(!isset($_POST["cartid"])){
    $pesan = "Error! no cart detected!";
  } else if(!isset($_POST["qty"])){
    $pesan = "Error! no quantity found!";
  } else {
    $hash = $_POST["hash"];
    $cartid = $_POST["cartid"];
    $qty = $_POST["qty"];
    if($hash == ""){
      $pesan = "Sorry! no security key found!";
    } else if($cartid == ""){
      $pesan = "Sorry! no cart found!";
    } else if($qty == ""){
      $pesan = "Sorry! no quantity found!";
    } else if($qty <= 0){
      $pesan = "Sorry! quantity cannot be zero value!";
    } else {
      include "config.php";
      $getHashdata = $conn->query("SELECT * FROM apihash WHERE apihash_hash = '".$hash."' ");
      $countHashdata = $getHashdata->num_rows;
      $getCart = $conn->query("SELECT * FROM draftcart WHERE idcart = '".$cartid."' ");
      $countCartData = $getCart->num_rows;
      if($countCartData != 1){
        $pesan = "Sorry! user is not exist";
      } else if($countCartData != 1){
        $pesan = "Sorry! cart is not exist";
      } else {
        //Check Ownership
        $fetchHashdata = $getHashdata->fetch_assoc();
        $hashidUser = $fetchHashdata["iduser"];
        if($hashidUser == ""){
          $hashActive = $hash;
        } else {
          $hashActive = $hashidUser;
        }
        //Cart Data
        $fetchCart = $getCart->fetch_assoc();
        $cartOwner = $fetchCart["iduser"];
        //Check Ownership
        if($hashActive != $cartOwner){
          $pesan = "Sorry! access denied";
        } else {
          //Get Cart Data
          $cartProdID = $fetchCart["idproduk"];
          $getcartProductData = $conn->query("SELECT * FROM masterproduk WHERE idproduk = '".$cartProdID."' ");
          //get Product
          $fetchProductData         = $getcartProductData->fetch_assoc();
          $productHarga             = $fetchProductData["harga"];
          $productDiskons           = $fetchProductData["hargadiskon"];
          if($productDiskons > 0 || $productDiskons != ""){
            $productDiskon = $fetchProductData["hargadiskon"];
          } else {
            $productDiskon = 0;
          }
          $productTax               = 0;
          if($productDiskon > 0){
            $productSubtotal1      = $productDiskon + $productTax;
            $productSubtotal       = $productSubtotal1 * $qty;
          } else {
            $productSubtotal1      = $productHarga + $productTax;
            $productSubtotal       = $productSubtotal1 * $qty;
          }
          $conn->query("UPDATE draftcart SET
            qty = '".$qty."',
            diskon = '".$productDiskon."',
            tax = '".$productTax."',
            subtotal = '".$productSubtotal."'
            WHERE idcart = '".$cartid."'
            ");
          $status = "Success";
        }
      }
    }
  }
} else if($do == "delete"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! no security key found!";
  } else if(!isset($_POST["cartid"])){
    $pesan = "Error! no cart detected!";
  } else {
    $hash = $_POST["hash"];
    $cartid = $_POST["cartid"];
    if($hash == ""){
      $pesan = "Sorry! no security key found!";
    } else if($cartid == ""){
      $pesan = "Sorry! no cart found!";
    } else {
      include "config.php";
      $getHashdata = $conn->query("SELECT * FROM apihash WHERE apihash_hash = '".$hash."' ");
      $countHashdata = $getHashdata->num_rows;
      $getCart = $conn->query("SELECT * FROM draftcart WHERE idcart = '".$cartid."' ");
      $countCartData = $getCart->num_rows;
      if($countHashdata != 1){
        $pesan = "Sorry! user is not exist";
      } else if($countCartData != 1){
        $pesan = "Sorry! cart is not exist";
      } else {
        //Check Ownership
        $fetchHashdata = $getHashdata->fetch_assoc();
        $hashidUser = $fetchHashdata["iduser"];
        if($hashidUser == ""){
          $hashActive = $hash;
        } else {
          $hashActive = $hashidUser;
        }
        //Cart Data
        $fetchCart = $getCart->fetch_assoc();
        $cartOwner = $fetchCart["iduser"];
        //Check Ownership
        if($hashActive != $cartOwner){
          $pesan = "Sorry! access denied";
        } else {
          $conn->query("DELETE FROM draftcart WHERE idcart = '".$cartid."' ");
          $status = "Success";
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
