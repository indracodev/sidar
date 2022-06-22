<?php
include "auth.php";
$do = $_GET["do"];
$status = "failed";
$pesan = "";
$daJson = array();

if($do == "category"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! no security key found!";
  } else {
    $hash = $_POST["hash"];
    if($hash == ""){
      $pesan = "Sorry! security key cannot be empty!";
    } else {
      include "config.php";
      //Hash Checking
      $getHashData = $conn->query("SELECT * FROM apihash WHERE apihash_hash = '".$hash."' ");
      $countHashData = $getHashData->num_rows;
      if($countHashData != 1){
        $pesan = "Sorry! no user found";
      } else {
        $pid = 0;
        $getCategory = $conn->query("SELECT * FROM artikel_kategori WHERE artikel_kategori_status = 'Aktif' ");
        while($fetchCategory = $getCategory->fetch_assoc()){
          $daJson[$pid]["catid"] = $fetchCategory["artikel_kategori_id"];
          $daJson[$pid]["catname"] = $fetchCategory["artikel_kategori_judul"];
          $pid++;
        }
        $status = "Success";
        $printJson = json_encode($daJson);
        echo $printJson;
        exit();
      }
    }
  }
} else if($do == "list"){
  $hash = $_POST["hash"];
  $catID = $_POST["catid"];
  if($hash == ""){
    $pesan = "Sorry! security key cannot be empty!";
  } else {
    //Hash Checking
    include "config.php";
    $getHashData = $conn->query("SELECT * FROM apihash WHERE apihash_hash = '".$hash."' ");
    $countHashData = $getHashData->num_rows;
    if($countHashData != 1){
      $pesan = "Sorry! no user found";
    } else {
      if($catID == ""){
        $getList = $conn->query("SELECT * FROM artikel WHERE artikel_static = 'Blogpost' AND artikel_status = 'Terbit' ORDER BY artikel_time DESC ");
      } else {
        $getList = $conn->query("SELECT * FROM artikel WHERE artikel_static = 'Blogpost' AND artikel_status = 'Terbit' AND artikel_kategori_id = '".$catID."' ORDER BY artikel_time DESC ");
      }
      $pid = 0;
      while($fetchList = $getList->fetch_assoc()){
        $daJson[$pid]["articlecode"] = $fetchList["artikel_kode"];
        $daJson[$pid]["articlelang"] = $fetchList["artikel_lang"];
        $daJson[$pid]["articlejudul"] = $fetchList["artikel_judul"];
        $daJson[$pid]["articleshort"] = $fetchList["artikel_short"];
        $daJson[$pid]["articlecover"] = $fetchList["artikel_cover"];
        $daJson[$pid]["articletime"] = $fetchList["artikel_time"];
        $pid++;
      }
      $status = "Success";
      $printJson = json_encode($daJson);
      echo $printJson;
      exit();
    }
  }
} else if($do == "detail"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! security code not found!";
  } else if(!isset($_POST["articlecode"])){
    $pesan = "Error! article code not found!";
  } else {
    $hash = $_POST["hash"];
    $articleCode = $_POST["articlecode"];
    if($hash == ""){
      $pesan = "Sorry! security code cannot be empty!";
    } else if($articleCode == ""){
      $pesan = "Sorry! article code cannot be empty!";
    } else {
      include "config.php";
      $getArticle = $conn->query("SELECT * FROM artikel WHERE artikel_static = 'Blogpost' AND artikel_status = 'Terbit' AND artikel_kode = '".$articleCode."' ");
      $countArticle = $getArticle->num_rows;
      if($countArticle != 1){
        $pesan = "Sorry! article not found or inactive";
      } else {
        $fetchArticle = $getArticle->fetch_assoc();
        $daJson["articlecode"] = $fetchArticle["artikel_kode"];
        $daJson["articlelang"] = $fetchArticle["artikel_lang"];
        $daJson["articlejudul"] = $fetchArticle["artikel_judul"];
        $daJson["articlecontent"] = $fetchArticle["artikel_konten"];
        $daJson["articlecover"] = $fetchArticle["artikel_cover"];
        $daJson["articletime"] = $fetchArticle["artikel_time"];
        $status = "Success";
        $printJson = json_encode($daJson);
        echo $printJson;
        exit();
      }
    }
  }
} else {
  $pesan = "Error! no action found";
}
$daJson["pesan"] = $pesan;
$daJson["status"] = $status;
$printJson = json_encode($daJson);
echo $printJson;
exit();
?>
