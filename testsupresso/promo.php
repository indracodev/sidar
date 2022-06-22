<?php
include "auth.php";
$do = $_GET["do"];
$status = "failed";
$pesan = "";
$daJson = array();

if($do == "product"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! no security key found!";
  } else {
    $hash = $_POST["hash"];
    if($hash == ""){
      $pesan = "Sorry! security key cannot be empty!";
    } else {
      include "config.php";
      //Hash checking
      $getHashData = $conn->query("SELECT * FROM apihash WHERE apihash_hash = '".$hash."' ");
      $countHashData = $getHashData->num_rows;
      if($countHashData != 1){
        $pesan = "Sorry! no hash detected";
      } else {
        $pid = 0;
        $notLike = "Gift Set";
        $getProduct = $conn->query("SELECT * FROM masterproduk WHERE hargadiskon IS NOT NULL AND status = 'aktif' AND namaproduk NOT LIKE '%".$notLike."%' ");
        while($fetchProduct = $getProduct->fetch_assoc()){
          $thisItemPack = $fetchProduct["kemasan"];
          if($thisItemPack == "Can Drip Capsule"){
            $viewThisItemPack = "";
          } else {
            $viewThisItemPack = $thisItemPack;
          }
          $daJson[$pid]["id"] = $fetchProduct["idproduk"];
          $daJson[$pid]["img"] = $fetchProduct["gambar"];
          $daJson[$pid]["name"] = $fetchProduct["namaproduk"];
          $daJson[$pid]["bawahnama"] = $fetchProduct["bawahnama"];
          $daJson[$pid]["price"] = $fetchProduct["harga"];
          $daJson[$pid]["discount"] = $fetchProduct["hargadiskon"];
          $daJson[$pid]["stock"] = $fetchProduct["jumlahstock"];
          $daJson[$pid]["package"] = $viewThisItemPack;
          $daJson[$pid]["categoryname"] = $fetchProduct["categoryname"];
          $daJson[$pid]["coffeetype"] = $fetchProduct["tipekopi"];
          $daJson[$pid]["kind"] = $fetchProduct["kind"];
          $daJson[$pid]["gramature"] = $fetchProduct["gramature"];
          $pid++;
        }
        $printJson = json_encode($daJson);
        echo $printJson;
        exit();
      }
    }
  }
} else if($do == "article"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! no security key found!";
  } else {
    $hash = $_POST["hash"];
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
        $getList = $conn->query("SELECT * FROM artikel WHERE artikel_status = 'Terbit' AND artikel_kategori_id = '1' ORDER BY artikel_time DESC");
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
