<?php
include "auth.php";
$do = $_GET["do"];
$status = "failed";
$pesan = "";
$daJson = array();

if($do == "get"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! security key cannot be found!";
  } else if(!isset($_POST["voucher"])){
    $pesan = "Error! voucher code cannot be found!";
  } else {
    $hash = $_POST["hash"];
    $voucher = strtoupper($_POST["voucher"]);
    if($hash == ""){
      $pesan = "Sorry! security key cannot be empty!";
    } else if($voucher == ""){
      $pesan = "Sorry! vocuher cannot be null!";
    } else {
      include "config.php";
      //Hash checking
      $getHashData = $conn->query("SELECT * FROM apihash WHERE apihash_hash = '".$hash."' ");
      $countHashData = $getHashData->num_rows;
      if($countHashData != 1){
        $pesan = "Sorry! no hash detected";
      } else {
        //Checking Member Type
        $fetchHashData = $getHashData->fetch_assoc();
        $hashID = $fetchHashData["iduser"];
        if($hashID == ""){
          $hashType = "Guest";
        } else {
          $hashType = "Member";
        }
        //Skema Voucher
        if($voucher == "KUDAPONI666"){
          //Skema Voucher 1
          $vouchMem = "Member";
          $vouchName = "KUDAPONI 6%";
          $vouchNominal = 0;
          $vouchPersen = 6;
          if($vouchMem != $hashType){
            $pesan = "Sorry! This voucher is valid for member only";
          } else {
            $daJson["vouchname"] = $vouchName;
            $daJson["vouchnominal"] = $vouchNominal;
            $daJson["vouchpersen"] = $vouchPersen;
            $pesan = "Congratulation! This voucher activated";
            $status = "Success";
          }
        } else if($voucher == "TOLAKBALA69"){
          //Skema Voucher 2
          $vouchMem = "Guest";
          $vouchName = "TOLAKBALA 69";
          $vouchNominal = floatval(6.9);
          $vouchPersen = 0;
          if($hashType == "Guest" || $hashType == "Member"){
            $daJson["vouchname"] = $vouchName;
            $daJson["vouchnominal"] = $vouchNominal;
            $daJson["vouchpersen"] = $vouchPersen;
            $pesan = "Congratulation! This voucher activated";
            $status = "Success";
          } else {
            $pesan = "Sorry! This voucher is valid for member only";
          }
        } else {
          $pesan = "Invalid voucher code";
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
