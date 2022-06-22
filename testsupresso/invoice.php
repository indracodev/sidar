<?php
include "auth.php";
$do = $_GET["do"];
$status = "failed";
$pesan = "";
$daJson = array();

if($do == "info"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! no security key detected!";
  } else if(!isset($_POST["invoice"])){
    $pesan = "Error! no invoice key detected!";
  } else {
    $hash = $_POST["hash"];
    $invoiceKode = $_POST["invoice"];
    if($hash == ""){
      $pesan = "Sorry! security key cannot be empty!";
    } else if($invoiceKode == ""){
      $pesan = "Sorry! invoice key cannot be empty!";
    } else {
      include "config.php";
      $getCust = $conn->query("SELECT iduser FROM apihash WHERE apihash_hash = '".$hash."' ");
      $countCust = $getCust->num_rows;
      if($countCust != 1){
        $pesan = "Sorry! user not found";
      } else {
        $fetchCust = $getCust->fetch_assoc();
        $idUser = $fetchCust["iduser"];
        if($idUser == ""){
          //Guest
          $hashType = "Guest";
          $idUserIs = $hash;
        } else {
          //Member
          $hashType = "Member";
          $idUserIs = $idUser;
        }
        //Get Invoice
        $getInvoice = $conn->query("SELECT * FROM daftarorder WHERE iduser = '".$idUserIs."' AND nomerorder = '".$invoiceKode."'  ");
        $countInvoice = $getInvoice->num_rows;
        if($countInvoice != 1){
          $pesan = "Sorry! no invoice found or this user is not owner of this invoice!";
        } else {
          $fetchInvoice = $getInvoice->fetch_assoc();

          $thisInvNoOrder = $fetchInvoice["nomerorder"];
          $getSubInvoice = $conn->query("SELECT * FROM apimethod WHERE nomerorder = '".$thisInvNoOrder."' ");
          $countSubInvoice = $getSubInvoice->num_rows;
          if($countSubInvoice != 1){
            $methodVal = "";
            $resiVal = "";
          } else {
            $fetchSubInvoice = $getSubInvoice->fetch_assoc();
            $methodVal = $fetchSubInvoice["apimethod_transmethod"];
            $resiVal = $fetchSubInvoice["apimethod_resi"];
          }
          //Get Transaction method
          $getTransMethod = $conn->query("SELECT * FROM apimethod WHERE nomerorder = '".$thisInvNoOrder."' ");
          $countTransMethod = $getTransMethod->num_rows;
          if($countTransMethod != 1){
            $transMethod = "No data found";
          } else {
            $fetchTransMethod = $getTransMethod->fetch_assoc();
            $transMethod = $fetchTransMethod["apimethod_transmethod"];
          }

          $daJson["code"] = $thisInvNoOrder;
          $daJson["date"] = $fetchInvoice["tanggalorder"];
          $daJson["time"] = $fetchInvoice["jamorder"];
          $daJson["invstatus"] = $fetchInvoice["status"];
          $daJson["itemssubtotal"] = $fetchInvoice["itemsubtotal"];
          $daJson["discounttotal"] = $fetchInvoice["discon"];
          $daJson["coupon"] = $fetchInvoice["coupon"];
          $daJson["discountvalue"] = $fetchInvoice["persdiskon"];
          $daJson["tax"] = $fetchInvoice["tax"];
          $daJson["shippingprice"] = $fetchInvoice["shippingprice"];
          $daJson["grandtotal"] = $fetchInvoice["ordertotal"];
          $daJson["payment"] = $fetchInvoice["payment"];
          $daJson["transmethod"] = $transMethod;
          $daJson["courier"] = $fetchInvoice["pengiriman"];
          $daJson["fullname"] = $fetchInvoice["namalengkap"];
          $daJson["firstname"] = $fetchInvoice["firtsname"];
          $daJson["lastname"] = $fetchInvoice["lastname"];
          $daJson["country"] = $fetchInvoice["negara"];
          $daJson["province"] = $fetchInvoice["provinsi"];
          $daJson["city"] = $fetchInvoice["kota"];
          $daJson["district"] = $fetchInvoice["kecamatan"];
          $daJson["address"] = $fetchInvoice["alamat"];
          $daJson["address2"] = $fetchInvoice["alamatdua"];
          $daJson["postal"] = $fetchInvoice["kodepos"];
          $daJson["company"] = $fetchInvoice["company"];
          $daJson["email"] = $fetchInvoice["email"];
          $daJson["phone"] = $fetchInvoice["phone"];
          $daJson["note"] = $fetchInvoice["addcatatan"];
          $daJson["transmethod"] = $methodVal;
          $daJson["transresi"] = $resiVal;

          $pesan = "Sucessfully recieve invoice data";
          $status = "Success";
          $daJson["status"] = $status;
          $daJson["message"] = $pesan;
          $printJson = json_encode($daJson);
          echo $printJson;
          exit();
        }
      }
    }
  }
} else if($do == "details"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! Security key not found";
  } else if(!isset($_POST["invoice"])){
    $pesan = "Error! Invoice key not found";
  } else {
    $hash = $_POST["hash"];
    $invoiceKode = $_POST["invoice"];
    if($hash == ""){
      $pesan = "Sorry! security key cannot be empty!";
    } else if($invoiceKode == ""){
      $pesan = "Sorry! invoice number cannot be empty!";
    } else {
      include "config.php";
      $getCust = $conn->query("SELECT iduser FROM apihash WHERE apihash_hash = '".$hash."' ");
      $countCust = $getCust->num_rows;
      if($countCust != 1){
        $pesan = "Sorry! user not found";
      } else {
        $fetchCust = $getCust->fetch_assoc();
        $idUser = $fetchCust["iduser"];
        if($idUser == ""){
          //Guest
          $hashType = "Guest";
          $idUserIs = $hash;
        } else {
          //Member
          $hashType = "Member";
          $idUserIs = $idUser;
        }
        //Get invoice
        $getInvoice = $conn->query("SELECT * FROM daftarorder WHERE iduser = '".$idUserIs."' AND nomerorder = '".$invoiceKode."'  ");
        $countInvoice = $getInvoice->num_rows;
        if($countInvoice != 1){
          $pesan = "Sorry! invoice not found or this user is not the owner of this invoice";
        } else {
          //Get Invoice list
          $getInvoiceList = $conn->query("SELECT * FROM daftarorderdetail WHERE nomerorder = '".$invoiceKode."' ");
          $pid = 0;
          while($fetchInvoiceList = $getInvoiceList->fetch_assoc()){
            $daJson[$pid]["productname"]    = $fetchInvoiceList["namaproduk"];
            $daJson[$pid]["originalprice"]  = $fetchInvoiceList["hargabelumdiskon"];
            $daJson[$pid]["discount"]       = $fetchInvoiceList["discon"];
            $daJson[$pid]["discountprice"]  = $fetchInvoiceList["hargaproduk"];
            $daJson[$pid]["quantity"]       = $fetchInvoiceList["qty"];
            $daJson[$pid]["subtotal"]       = $fetchInvoiceList["subtotalproduk"];
            $pid++;
          }
          $printJson = json_encode($daJson);
          echo $printJson;
          exit();
        }
      }

    }
  }
} else {
  $pesan = "Error! theres no action detected!";
}

$daJson["message"] = $pesan;
$daJson["status"] = $status;
$printJson = json_encode($daJson);
echo $printJson;
exit();
?>
