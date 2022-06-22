<?php
include "auth.php";
$do = $_GET["do"];
$status = "failed";
$pesan = "";
$daJson = array();
if($do == "viewall"){
  include "config.php";
  $statusVal = "aktif";
  $pid = 0;
  $getProduct = $conn->query("SELECT * FROM masterproduk WHERE status = '".$statusVal."' ");
  while($fetchProduct = $getProduct->fetch_assoc()){
    $daJson[$pid]["id"] = $fetchProduct["idproduk"];
    $daJson[$pid]["img"] = $fetchProduct["gambar"];
    $daJson[$pid]["name"] = $fetchProduct["namaproduk"];
    $daJson[$pid]["bawahnama"] = $fetchProduct["bawahnama"];
    $daJson[$pid]["price"] = $fetchProduct["harga"];
    $daJson[$pid]["discount"] = $fetchProduct["hargadiskon"];
    $daJson[$pid]["stock"] = $fetchProduct["jumlahstock"];
    $pid++;
  }
  $printJson = json_encode($daJson);
  echo $printJson;
  exit();
} else if($do == "category"){
  include "config.php";
  $statusVal = "aktif";
  $pid = 0;
  if(!isset($_POST["filter"])){
    echo "No Filter detected";
    exit();
  }
  $filterVal = $_POST["filter"];
  if(isset($_POST["sort"])){
    $sortADSC = $_POST["sort"];
    if($sortADSC != ""){
      $sortSQL = "ORDER BY namaproduk ".$sortADSC;
    } else {
      $sortSQL = "";
    }
  } else {
    $sortSQL = "";
  }
  $getProduct = $conn->query("SELECT * FROM masterproduk WHERE status = '".$statusVal."' AND categoryname LIKE '%".$filterVal."%' ".$sortSQL);
  while($fetchProduct = $getProduct->fetch_assoc()){
    $daJson[$pid]["id"] = $fetchProduct["idproduk"];
    $daJson[$pid]["img"] = $fetchProduct["gambar"];
    $daJson[$pid]["name"] = $fetchProduct["namaproduk"];
    $daJson[$pid]["bawahnama"] = $fetchProduct["bawahnama"];
    $daJson[$pid]["price"] = $fetchProduct["harga"];
    $daJson[$pid]["discount"] = $fetchProduct["hargadiskon"];
    $daJson[$pid]["stock"] = $fetchProduct["jumlahstock"];
    $daJson[$pid]["package"] = $fetchProduct["kemasan"];
    $daJson[$pid]["categoryname"] = $fetchProduct["categoryname"];
    $daJson[$pid]["coffeetype"] = $fetchProduct["tipekopi"];
    $daJson[$pid]["kind"] = $fetchProduct["kind"];
    $daJson[$pid]["gramature"] = $fetchProduct["gramature"];
    $pid++;
  }
  $printJson = json_encode($daJson);
  echo $printJson;
  exit();
} else if($do == "type"){
  include "config.php";
  $statusVal = "aktif";
  $pid = 0;
  if(!isset($_POST["filter"])){
    echo "No Filter detected";
    exit();
  }
  $filterVal = $_POST["filter"];
  if(isset($_POST["sort"])){
    $sortADSC = $_POST["sort"];
    if($sortADSC != ""){
      $sortSQL = "ORDER BY namaproduk ".$sortADSC;
    } else {
      $sortSQL = "";
    }
  } else {
    $sortSQL = "";
  }
  $getProduct = $conn->query("SELECT * FROM masterproduk WHERE status = '".$statusVal."' AND kind LIKE '%".$filterVal."%' ".$sortSQL);
  while($fetchProduct = $getProduct->fetch_assoc()){
    $daJson[$pid]["id"] = $fetchProduct["idproduk"];
    $daJson[$pid]["img"] = $fetchProduct["gambar"];
    $daJson[$pid]["name"] = $fetchProduct["namaproduk"];
    $daJson[$pid]["bawahnama"] = $fetchProduct["bawahnama"];
    $daJson[$pid]["price"] = $fetchProduct["harga"];
    $daJson[$pid]["discount"] = $fetchProduct["hargadiskon"];
    $daJson[$pid]["stock"] = $fetchProduct["jumlahstock"];
    $daJson[$pid]["package"] = $fetchProduct["kemasan"];
    $daJson[$pid]["categoryname"] = $fetchProduct["categoryname"];
    $daJson[$pid]["coffeetype"] = $fetchProduct["tipekopi"];
    $daJson[$pid]["kind"] = $fetchProduct["kind"];
    $daJson[$pid]["gramature"] = $fetchProduct["gramature"];
    $pid++;
  }
  $printJson = json_encode($daJson);
  echo $printJson;
  exit();
} else if($do == "detail"){
  if(!isset($_GET["id"])){
    $pesan = "Error! theres no product detected";
  } else if(!isset($_POST["hash"])){
    $pesan = "Error! theres no security code found";
  } else {
    $prodID = $_GET["id"];
    $hash = $_POST["hash"];
    if($prodID == ""){
      $pesan = "Sorry! product cannot be empty!";
    } else if($hash == ""){
      $pesan = "Sorry! hash cannot be empty!";
    } else {
      include "config.php";
      $statusVal = "aktif";
      $getProduct = $conn->query("SELECT * FROM masterproduk WHERE idproduk = '".$prodID."' AND status = '".$statusVal."' ");
      $countProduct = $getProduct->num_rows;
      if($countProduct != 0){
        $fetchProduct = $getProduct->fetch_assoc();

        //get Wishlist Data
        $wishlistVal = false;
        $getHash = $conn->query("SELECT * FROM apihash WHERE apihash_hash = '".$hash."' ");
        $countHash = $getHash->num_rows;
        if($countHash == 1){
          $fetchHash = $getHash->fetch_assoc();
          $custID = $fetchHash["iduser"];
          if($custID != ""){
            $checkWish = $conn->query("SELECT * FROM apiwishlist WHERE idproduk = '".$prodID."' AND iduser = '".$custID ."' ");
            $contWish = $checkWish->num_rows;
            $callCartInit = $custID;
            if($contWish == 1){
              $wishlistVal = true;
            }
          } else {
            $callCartInit = $hash;
          }
        }
        //Cart Checking
        $getCart = $conn->query("SELECT * FROM draftcart WHERE iduser = '".$callCartInit."' AND idproduk = '".$prodID."' ");
        $countCart = $getCart->num_rows;
        if($countCart == 1){
          $fetchCart = $getCart->fetch_assoc();
          $cartQty = $fetchCart["qty"];
        } else {
          $cartQty = 0;
        }

        $pid = 0;
        $daJson[$pid]["id"] = $fetchProduct["idproduk"];
        $daJson[$pid]["name"] = $fetchProduct["namaproduk"];
        $daJson[$pid]["bawahnama"] = $fetchProduct["bawahnama"];
        $daJson[$pid]["price"] = $fetchProduct["harga"];
        $daJson[$pid]["discount"] = $fetchProduct["hargadiskon"];
        $daJson[$pid]["stock"] = $fetchProduct["jumlahstock"];
        $daJson[$pid]["kind"] = $fetchProduct["kind"];
        $daJson[$pid]["shortdescription"] = $fetchProduct["shortdescription"];
        $daJson[$pid]["bodydesc"] = ucwords($fetchProduct["bodydesc"]);
        $daJson[$pid]["coffeetype"] = $fetchProduct["tipekopi"];
        $daJson[$pid]["variant"] = $fetchProduct["variants"];
        $daJson[$pid]["weight"] = $fetchProduct["berat"];
        $daJson[$pid]["packaging"] = $fetchProduct["kemasan"];
        $daJson[$pid]["categoryname"] = $fetchProduct["categoryname"];
        $daJson[$pid]["collection"] = $fetchProduct["collection"];
        $daJson[$pid]["gambar1"] = $fetchProduct["gambar1"];
        $daJson[$pid]["gambar2"] = $fetchProduct["gambar2"];
        $daJson[$pid]["gambar3"] = $fetchProduct["gambar3"];
        $daJson[$pid]["gambar4"] = $fetchProduct["gambar4"];
        $daJson[$pid]["gramature"] = $fetchProduct["gramature"];
        $daJson[$pid]["acidity"] = ucwords($fetchProduct["acidity"]);
        $daJson[$pid]["body"] = ucwords($fetchProduct["body"]);
        $daJson[$pid]["keywords"] = $fetchProduct["keywords"];
        $daJson[$pid]["aciditydesc"] = ucwords($fetchProduct["aciditydesc"]);
        $daJson[$pid]["wishlist"] = $wishlistVal;
        $daJson[$pid]["cartqty"] = $cartQty;
        $printJson = json_encode($daJson);
        echo $printJson;
        exit();
      } else {
        $pesan = "Sorry no item found";
      }
    }
  }
} else {
  $pesan = "Error! no action";
}
$daJson["pesan"] = $pesan;
$daJson["status"] = $status;
$printJson = json_encode($daJson);
echo $printJson;
exit();
?>
