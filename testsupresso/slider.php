<?php
include "auth.php";
$do = $_GET["do"];
$status = "failed";
$pesan = "";
$daJson = array();

if($do == "all"){
  include "config.php";
  $pid = 0;
  $nowTime = date("Y-m-d H:i:s");
  $getSlider = $conn->query("SELECT * FROM apislider WHERE apislider_status = 'active' AND apislider_timestart < '".$nowTime."' AND apislider_timeend > '".$nowTime."' ");
  while($fetchSlider = $getSlider->fetch_assoc()){
    $daJson[$pid]["tittle"] = $fetchSlider["apislider_tittle"];
    $daJson[$pid]["type"] = $fetchSlider["apislider_type"];
    $daJson[$pid]["img"] = $fetchSlider["apislider_img"];
    $daJson[$pid]["html"] = $fetchSlider["apislider_html"];
    $daJson[$pid]["url"] = $fetchSlider["apislider_url"];
    $daJson[$pid]["internalurl"] = $fetchSlider["apislider_urlinternal"];
    $pid++;
  }
  $status = "Success";
  $printJson = json_encode($daJson);
  echo $printJson;
  exit();
} else {
  $pesan = "Error! no action found!";
}
$daJson["pesan"] = $pesan;
$daJson["status"] = $status;
$printJson = json_encode($daJson);
echo $printJson;
exit();
?>
