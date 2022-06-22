<?php
include "auth.php";
$do = $_GET["do"];
$status = "failed";
$pesan = "";
$daJson = array();
if($do == "list"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! no security found!";
  } else {
    $hashsend = $_POST["hash"];
    if($hashsend == ""){
      $pesan = "Sorry! security poin is null!";
    } else {
      include "config.php";
      $getCust = $conn->query("SELECT * FROM apihash WHERE apihash_hash = '".$hashsend."' ");
      $countCust = $getCust->num_rows;
      if($countCust != 1){
        $pesan = "Sorry! no profile found";
      } else {
        $fetchCust = $getCust->fetch_assoc();
        $idUser = $fetchCust["iduser"];
        if($idUser == ""){
          $hashOwn = $hashsend;
        } else {
          $hashOwn = $idUser;
        }
        $getTrans = $conn->query("SELECT * FROM daftarorder WHERE iduser = '".$hashOwn."' ");
        $countTrans = $getTrans->num_rows;
        if($countTrans == 0){
          $pesan = "No transaction from this customer";
          $status = "Success";
        } else {
          $pid = 0;
          while($fetchTrans = $getTrans->fetch_assoc()){
            $daJson[$pid]["orderid"] = $fetchTrans["nomerorder"];
            $daJson[$pid]["orderdate"] = $fetchTrans["tanggalorder"];
            $daJson[$pid]["ordertime"] = $fetchTrans["jamorder"];
            $daJson[$pid]["orderstatus"] = $fetchTrans["status"];
            $daJson[$pid]["ordertotal"] = $fetchTrans["ordertotal"];
            $daJson[$pid]["orderexpedition"] = $fetchTrans["pengiriman"];
            $pid++;
          }
          $status = "Success";
          $daJson["pesan"] = $pesan;
          $daJson["status"] = $status;
          $printJson = json_encode($daJson);
          echo $printJson;
          exit();
        }
      }
    }
  }
} else if($do == "detail"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! no security key found!";
  } else {
    $hashsend = $_POST["hash"];
    $transsend = $_POST["transid"];
    if($hashsend == ""){
      $pesan = "Sorry! security poin is null!";
    } else if($transsend == ""){
      $pesan = "Sorr! transaction id is null!";
    } else {
      include "config.php";
      $getCust = $conn->query("SELECT iduser FROM apihash WHERE apihash_hash = '".$hashsend."' ");
      $countCust = $getCust->num_rows;
      if($countCust != 1){
        $pesan = "Sorry! no profile found";
      } else {
        $fetchCust = $getCust->fetch_assoc();
        $idUser = $fetchCust["iduser"];
        $getTransdata = $conn->query("SELECT * FROM daftarorder WHERE iduser = '".$idUser."' ");
        $countTransdata = $getTransdata->num_rows;
        if($countTransdata != 1){
          $pesan = "Sorry! this transaction doesnt exist";
        } else {
          $fetchTransdata = $getTransdata->fetch_assoc();
          $noOrder = $fetchTransdata["nomerorder"];
          $pid = 0;
          $getTransList = $conn->query("SELECT * FROM daftarorderdetail WHERE nomerorder = '".$noOrder."' ");
          while($fetchTransList = $getTransList->fetch_assoc()){
            $daJson[$pid]["productid"] = $fetchTransList["idproduct"];
            $daJson[$pid]["productname"] = $fetchTransList["namaproduk"];
            $daJson[$pid]["productimg"] = $fetchTransList["gambar"];
            $daJson[$pid]["productdiscount"] = $fetchTransList["discon"];
            $daJson[$pid]["producttxtdiscount"] = $fetchTransList["txtdiscount"];
            $daJson[$pid]["producttax"] = $fetchTransList["tax"];
            $daJson[$pid]["productpriceproduct"] = $fetchTransList["hargaproduck"];
            $daJson[$pid]["productpriceoriginal"] = $fetchTransList["hargabelumdiskon"];
            $daJson[$pid]["productqty"] = $fetchTransList["qty"];
            $daJson[$pid]["productsubtotal"] = $fetchTransList["subtotalproduk"];
            $daJson[$pid]["productnote"] = $fetchTransList["note"];
            $pid++;
          }
          $status = "Success";
        }
      }
    }
  }
} else {
  $pesan = "Error! action not detected!";
}
$daJson["pesan"] = $pesan;
$daJson["status"] = $status;
$printJson = json_encode($daJson);
echo $printJson;
exit();
?>
