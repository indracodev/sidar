<?php
include "auth.php";
$do = $_GET["do"];
$status = "failed";
$pesan = "";
$daJson = array();

if($do == "recommend"){
  if(!isset($_POST["input"])){
    $pesan = "Error! input not found";
  } else {
    $input = $_POST["input"];
    include "config.php";
    //Result
    $pid = 0;
    $getSearch = $conn->query("SELECT DISTINCT idproduk, namaproduk, bawahnama FROM masterproduk WHERE namaproduk LIKE '%".$input."%' AND status = 'aktif' LIMIT 10 ");
    while($fetchSearch = $getSearch->fetch_assoc()){
      $daJson[$pid]["id"] = $fetchSearch["idproduk"];
      $daJson[$pid]["name"] = $fetchSearch["namaproduk"];
      $daJson[$pid]["under"] = $fetchSearch["bawahnama"];
      $pid++;
    }
    $printJson = json_encode($daJson);
    echo $printJson;
    exit();
  }
} else if($do == "topsearch"){
  include "config.php";
  $pid = 0;
  $getIsset = $conn->query("SELECT apisearch_text FROM apisearch ORDER BY apisearch_times DESC LIMIT 5 ");
  while($fetchIsset = $getIsset->fetch_assoc()){
    $daJson[$pid]["name"] = $fetchIsset["apisearch_text"];
    $pid++;
  }
  $status = "Success";
  $printJson = json_encode($daJson);
  echo $printJson;
  exit();
} else if($do == "result"){
  if(!isset($_POST["input"])){
    $pesan = "Error! input not found";
  } else {
    $input = $_POST["input"];
    include "config.php";
    $countInput = strlen($input);
    if($countInput >= 3){
      //Insert Engagement
      $getIsset = $conn->query("SELECT * FROM apisearch WHERE apisearch_text = '".$input."' ");
      $countIsset = $getIsset->num_rows;
      if($countIsset == 0){
        $conn->query("INSERT INTO apisearch VALUES(NULL, '".$input."', '1', NOW())");
      } else {
        $fetchIsset = $getIsset->fetch_assoc();
        $timesIsset = $fetchIsset["apisearch_times"];
        $idIsset = $fetchIsset["apisearch_id"];
        $timesPlus = $timesIsset + 1;
        $conn->query("UPDATE apisearch SET apisearch_times = '".$timesPlus."', apisearch_last = NOW() WHERE apisearch_id = '".$idIsset."' ");
      }
    }
    //Result
    $pid = 0;
    $getSearch = $conn->query("SELECT * FROM masterproduk WHERE namaproduk LIKE '%".$input."%' AND status = 'aktif' ");
    while($fetchSearch = $getSearch->fetch_assoc()){
      $daJson[$pid]["id"] = $fetchSearch["idproduk"];
      $daJson[$pid]["img"] = $fetchSearch["gambar"];
      $daJson[$pid]["name"] = $fetchSearch["namaproduk"];
      $daJson[$pid]["under"] = $fetchSearch["bawahnama"];
      $daJson[$pid]["price"] = $fetchSearch["harga"];
      $daJson[$pid]["discount"] = $fetchSearch["hargadiskon"];
      $daJson[$pid]["stock"] = $fetchSearch["jumlahstock"];
      $pid++;
    }
    $printJson = json_encode($daJson);
    echo $printJson;
    exit();
  }
} else if($do == "sorted"){
  if(!isset($_POST["input"])){
    $pesan = "Error! no input detected";
  } else if(!isset($_POST["sortby"])){
    $pesan = "Error! no sort by detected";
  } else {
    $input = $_POST["input"];
    $sortby = $_POST["sortby"];
    if($input == ""){
      $pesan = "Sorry! input cannot be empty!";
    } else if($sortby == ""){
      $pesan = "Sorry! sort by cannot be empty!";
    } else {
      //input convert
      if($sortby == "shiprcs"){
        $sortVal = "ORDER BY harga DESC";
      } else if($sortby == "slowprcs"){
        $sortVal = "ORDER BY harga ASC";
      } else if($sortby == "slatestprod"){
        $sortVal = "ORDER BY idproduk DESC";
      } else if($sortby == "spopularprod"){
        $sortVal = "ORDER BY popular DESC";
      } else {
        $pesan = "Sorry! sort value is incorect";
        $daJson["message"] = $pesan;
        $daJson["status"] = $status;
        $printJson = json_encode($daJson);
        echo $printJson;
        exit();
      }

      include "config.php";
      //Result
      $pid = 0;
      $getSearch = $conn->query("SELECT * FROM masterproduk WHERE namaproduk LIKE '%".$input."%' AND status = 'aktif' ".$sortVal);
      while($fetchSearch = $getSearch->fetch_assoc()){
        $daJson[$pid]["id"] = $fetchSearch["idproduk"];
        $daJson[$pid]["img"] = $fetchSearch["gambar"];
        $daJson[$pid]["name"] = $fetchSearch["namaproduk"];
        $daJson[$pid]["under"] = $fetchSearch["bawahnama"];
        $daJson[$pid]["price"] = $fetchSearch["harga"];
        $daJson[$pid]["discount"] = $fetchSearch["hargadiskon"];
        $daJson[$pid]["stock"] = $fetchSearch["jumlahstock"];
        $pid++;
      }
      $printJson = json_encode($daJson);
      echo $printJson;
      exit();
    }
  }
} else {
  $pesan = "Error! No action detected";
}
$daJson["message"] = $pesan;
$daJson["status"] = $status;
$printJson = json_encode($daJson);
echo $printJson;
exit();
?>
