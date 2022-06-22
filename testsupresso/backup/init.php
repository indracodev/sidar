<?php
include "auth.php";
$daJson = array();
$do = $_GET["do"];
$pesan = "";
$status = "failed";

if($do == "first"){
  if(!isset($_GET["isguest"])){
    $pesan = "Error! no guest parameter!";
    echo $pesan;
    exit();
  } else if(!isset($_POST["hash"])){
    $pesan = "Error! no hash data!";
    echo $pesan;
    exit();
  } else if(!isset($_POST["model"])){
    $pesan = "Error! no model data!";
    echo $pesan;
    exit();
  } else if(!isset($_POST["uuid"])){
    $pesan = "Error! no uuid found!";
    echo $pesan;
    exit();
  } else if(!isset($_POST["os"])){
    $pesan = "Error! no os found!";
    echo $pesan;
    exit();
  } else if(!isset($_POST["ip"])){
    $pesan = "Error! no ip found!";
    echo $pesan;
    exit();
  }
  $sendGuest = $_GET["isguest"];
  $sendHash = $_POST["hash"];
  $sendModel = $_POST["model"];
  $sendUuid = $_POST["uuid"];
  $sendOS = $_POST["os"];
  $sendIP = $_POST["ip"];
  if($sendGuest == ""){
    $pesan = "Error! guest cannot be empty!";
  } else {
    include "config.php";
    if($sendGuest == "guest"){
      if($sendHash == ""){
        $hashsend = "request".$sendUuid.date("Ymdhisu");
        $hashesend = hash('sha256', $hashsend);
        $guestStatus = "Guest Access";
        $guestVal = "guest";
        $conn->query("INSERT INTO apihash VALUES(NULL, NULL, '".$hashesend."', NOW(), '".$guestStatus."', '".$guestVal."' )");
        $conn->query("INSERT INTO apimobilelog VALUES(NULL, '".$hashesend."', '".$sendModel."', '".$sendUuid."', '".$sendOS."', '".$sendIP."' )");
        $status = "Success";
        $pesan = "Welcome";
        $daJson["hash"] = $hashesend;
      } else {
        $getDeviceInfo = $conn->query("SELECT * FROM apimobilelog WHERE apihash_hash = '".$sendHash."' ");
        $countDeviceInfo = $getDeviceInfo->num_rows;
        if($countDeviceInfo == 0){
          $conn->query("INSERT INTO apimobilelog VALUES(NULL, '".$sendHash."', '".$sendModel."', '".$sendUuid."', '".$sendOS."', '".$sendIP."' )");
          $pesan = "Welcome";
        } else {
          $conn->query("UPDATE apimobilelog SET apimobilelog_model = '".$sendModel."', apimobilelog_uuid = '".$sendUuid."', apimobilelog_os = '".$sendOS."', apimobilelog_ip = '".$sendIP."' WHERE apihash_hash = '".$sendHash."' ");
          $pesan = "Welcome";
        }
        $status = "Success";
        $daJson["hash"] = $sendHash;
      }
    } else if($sendGuest == "login"){
      if($sendHash == ""){
        $pesan = "Unauthorized access";
      } else {
        $getUserData = $conn->query("SELECT * FROM apihash WHERE apihash_hash = '".$sendHash."' ");
        $countUserData = $getUserData->num_rows;
        if($countUserData == 0){
          $pesan = "No user list found";
        } else {
          $getDeviceInfo = $conn->query("SELECT * FROM apimobilelog WHERE apihash_hash = '".$sendHash."' ");
          $countDeviceInfo = $getDeviceInfo->num_rows;
          if($countDeviceInfo == 0){
            $conn->query("INSERT INTO apimobilelog VALUES(NULL, '".$sendHash."', '".$sendModel."', '".$sendUuid."', '".$sendOS."', '".$sendIP."' )");
            $status = "Success";
            $pesan = "Welcome";
          } else {
            $conn->query("UPDATE apimobilelog SET apimobilelog_model = '".$sendModel."', apimobilelog_uuid = '".$sendUuid."', apimobilelog_os = '".$sendOS."', apimobilelog_ip = '".$sendIP."' WHERE apihash_hash = '".$sendHash."' ");
            $status = "Success";
            $pesan = "Welcome";
          }
          $daJson["hash"] = $sendHash;
        }
      }
    } else {
      $pesan = "Error! there was an error with guest parameter!";
    }
  }
  $daJson["status"] = $status;
  $daJson["message"] = $pesan;
} else {
  $pesan = "Error! No action detected!";
  $daJson["status"] = $status;
  $daJson["message"] = $pesan;
}
$printJson = json_encode($daJson);
echo $printJson;
exit();
?>
