<?php
include "auth.php";
$do = $_GET["do"];
$status = "failed";
$pesan = "";
$daJson = array();

if($do == "toggle"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! theres no security key detected!";
  } else if(!isset($_POST["id"])){
    $pesan = "Error! thaeres no product detected!";
  } else {
    $hash = $_POST["hash"];
    $prodID = $_POST["id"];
    if($hash == ""){
      $pesan = "Sorry! security key cannot be null!";
    } else if($prodID == ""){
      $pesan = "Sorry! product cannot be null!";
    } else {
      include "config.php";
      $getHash = $conn->query("SELECT * FROM apihash WHERE apihash_hash = '".$hash."' ");
      $countHash = $getHash->num_rows;
      $getProd = $conn->query("SELECT * FROM masterproduk WHERE idproduk = '".$prodID."' ");
      $countProd = $getProd->num_rows;
      if($countHash != 1){
        $pesan = "Sorry! user not found!";
      } else if($countProd != 1){
        $pesan = "Sorry! cannot find product!";
      } else {
        $fetchHash = $getHash->fetch_assoc();
        $custID = $fetchHash["iduser"];
        if($custID == ""){
          $pesan = "Sorry! this user is not logged in!";
        } else {
          $checkWish = $conn->query("SELECT * FROM apiwishlist WHERE idproduk = '".$prodID."' AND iduser = '".$custID ."' ");
          $contWish = $checkWish->num_rows;
          if($contWish == 0){
            $conn->query("INSERT INTO apiwishlist VALUES(NULL, '".$custID."', '".$prodID."', NOW()) ");
            $status = "Success";
            $pesan = "wishlist";
          } else if($contWish == 1){
            $conn->query("DELETE FROM apiwishlist WHERE idproduk = '".$prodID."' AND iduser = '".$custID ."' ");
            $status = "Success";
            $pesan = "unwishlist";
          } else {
            $conn->query("DELETE FROM apiwishlist WHERE iduser = '".$custID ."' ");
            $pesan = "Sorry! there was an error with this item, all wishlist deleted for security reason";
          }
        }
      }
    }
  }
} else if($do == "all"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! no security key detected!";
  } else {
    $hash = $_POST["hash"];
    if($hash == ""){
      $pesan = "Sorry! security key cannot be empty!";
    } else {
      include "config.php";
      $getHash = $conn->query("SELECT * FROM apihash WHERE apihash_hash = '".$hash."' ");
      $countHash = $getHash->num_rows;
      if($countHash != 1){
        $pesan = "Sorry! no user found";
      } else {
        $fetchHash = $getHash->fetch_assoc();
        $custID = $fetchHash["iduser"];
        if($custID == ""){
          $pesan = "Sorry! this feature is not available for guest users";
        } else {
          $checkWish = $conn->query("SELECT * FROM apiwishlist WHERE iduser = '".$custID ."' ");
          $pid = 0;
          while($fetchWish = $checkWish->fetch_assoc()){
            $idProduk = $fetchWish["idproduk"];
            $getProduct = $conn->query("SELECT * FROM masterproduk WHERE idproduk = '".$idProduk."' ");
            $fetchProduct = $getProduct->fetch_assoc();
            $thisProductStat = $fetchProduct["status"];
            if($thisProductStat == "aktif"){
              $prdStat = "Active";
            } else {
              $prdStat = "Inactive";
            }
            $daJson[$pid]["id"] = $fetchProduct["idproduk"];
            $daJson[$pid]["status"] = $prdStat;
            $daJson[$pid]["img"] = $fetchProduct["gambar"];
            $daJson[$pid]["name"] = $fetchProduct["namaproduk"];
            $daJson[$pid]["bawahnama"] = $fetchProduct["bawahnama"];
            $daJson[$pid]["price"] = $fetchProduct["harga"];
            $daJson[$pid]["discount"] = $fetchProduct["hargadiskon"];
            $daJson[$pid]["stock"] = $fetchProduct["jumlahstock"];
            $pid++;
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
  $pesan = "Error! theres no action detected";
}
$daJson["pesan"] = $pesan;
$daJson["status"] = $status;
$printJson = json_encode($daJson);
echo $printJson;
exit();
?>
