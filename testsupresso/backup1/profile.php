<?php
include "auth.php";
$do = $_GET["do"];
$status = "failed";
$pesan = "";
$daJson = array();

if($do == "view"){
  if(!isset($_POST["hash"])){
    echo "Error! Theres no security key detected!";
    exit();
  }
  $hashSend = $_POST["hash"];
  if($hashSend == ""){
    $pesan = "Error! hash cannot be null";
  } else {
    include "config.php";
    $getIDuser = $conn->query("SELECT iduser FROM apihash WHERE apihash_hash = '".$hashSend."' ");
    $countIDuser = $getIDuser->num_rows;
    if($countIDuser != 1){
      echo "Sorry! no profile found";
      exit();
    } else {
      $fetchIDuser = $getIDuser->fetch_assoc();
      $idUser = $fetchIDuser["iduser"];
      $getCust = $conn->query("SELECT * FROM masterpelanggan WHERE iduser = '".$idUser."' ");
      $countCust = $getCust->num_rows;
      if($countCust != 1){
        echo "Sorry! customer not found";
      } else {
        $fetchCust = $getCust->fetch_assoc();
        $daJson["fullname"] = $fetchCust["fullname"];
        $daJson["address"] = $fetchCust["alamat"];
        $daJson["district"] = $fetchCust["kecamatan"];
        $daJson["city"] = $fetchCust["kota"];
        $daJson["province"] = $fetchCust["provinsi"];
        $daJson["country"] = $fetchCust["negara"];
        $daJson["postal"] = $fetchCust["kodepos"];

        $daJson["firstname"] = $fetchCust["firstname"];
        $daJson["lastname"] = $fetchCust["lastname"];
        $daJson["company"] = $fetchCust["company"];
        $daJson["phone"] = $fetchCust["notelp"];
        $daJson["email"] = $fetchCust["email"];
        $daJson["datebirth"] = $fetchCust["lahirtgl"];
        $daJson["newsletter"] = $fetchCust["setujunews"];
        $status = "Success";
      }
    }

  }
} else if($do == "update"){
  if(!isset($_GET["side"])){
    $pesan = "Error! No side parameter!";
  }
  $side = $_GET["side"];
  if($side == ""){
    $pesan = "Sorry! side cannot be empty!";
  } else {
    if($side == "address"){
      //Address Config
      if(!isset($_POST["hash"])){
        $pesan = "Sorry! no hash found!";
      } else if(!isset($_POST["address"])){
        $pesan = "Sorry! no address found!";
      } else if(!isset($_POST["district"])){
        $pesan = "Sorry! no district found!";
      } else if(!isset($_POST["city"])){
        $pesan = "Sorry! no city found!";
      } else if(!isset($_POST["province"])){
        $pesan = "Sorry! no province found!";
      } else if(!isset($_POST["country"])){
        $pesan = "Sorry! no country found!";
      } else if(!isset($_POST["postal"])){
        $pesan = "Sorry! no postal found!";
      } else {
        $hashSend = $_POST["hash"];
        $addressSend = $_POST["address"];
        $addressDistrict = $_POST["district"];
        $addressCity = $_POST["city"];
        $addressProvince = $_POST["province"];
        $addressCountry = $_POST["country"];
        $addressPostal = $_POST["postal"];
        if($hashSend == ""){
          $pesan = "Sorry! hash error!";
        } else {
          include "config.php";
          $getIDuser = $conn->query("SELECT iduser FROM apihash WHERE apihash_hash = '".$hashSend."' ");
          $countIDuser = $getIDuser->num_rows;
          if($countIDuser != 1){
            $pesan = "Sorry! no profile found";
            $daJson["pesan"] = $pesan;
            $daJson["status"] = $status;
            $printJson = json_encode($daJson);
            echo $printJson;
            exit();
          } else {
            $fetchIDuser = $getIDuser->fetch_assoc();
            $idUser = $fetchIDuser["iduser"];
            $conn->query("UPDATE masterpelanggan SET
            alamat = '".$addressSend."',
            kecamatan = '".$addressDistrict."',
            kota = '".$addressCity."',
            provinsi = '".$addressProvince."',
            negara = '".$addressCountry."',
            kodepos = '".$addressPostal."'
            WHERE iduser = '".$idUser."' ");
            $pesan = "Successfully update user data";
            $status = "Success";
          }
        }
      }
    } else if($side == "account"){
      //Account Config
      if(!isset($_POST["hash"])){
        $pesan = "Sorry! no hash found!";
      } else if(!isset($_POST["hash"])){
        $pesan = "Error! security key not found!";
      } else if(!isset($_POST["lastname"])){
        $pesan = "Error! lastname not found!";
      } else if(!isset($_POST["company"])){
        $pesan = "Error! company not found!";
      } else if(!isset($_POST["phone"])){
        $pesan = "Error! phone not found!";
      } else if(!isset($_POST["email"])){
        $pesan = "Error! email not found!";
      } else if(!isset($_POST["birthdate"])){
        $pesan = "Error! birthdate not found!";
      } else if(!isset($_POST["newsletter"])){
        $pesan = "Error! newsletter not found!";
      } else {
        $hashSend           = $_POST["hash"];
        $accountFirstName   = $_POST["firstname"];
        $accountLastName    = $_POST["lastname"];
        $accountCompany     = $_POST["company"];
        $accountPhone       = $_POST["phone"];
        $accountEmail       = $_POST["email"];
        $accountBirthDate   = $_POST["birthdate"];
        $accountNewsletter  = $_POST["newsletter"];
        if($hashSend == ""){
          $pesan = "Sorry! security key is empty!";
        } else if($accountFirstName == ""){
          $pesan = "Sorry! first name cannot be empty!";
        } else if($accountLastName == ""){
          $pesan = "Sorry! last name cannot be empty!";
        } else if($accountPhone == ""){
          $pesan = "Sorry! Phone cannot be empty!";
        } else if($accountEmail == ""){
          $pesan = "Sorry! email cannot be empty!";
        } else {
          include "config.php";
          $getIDuser = $conn->query("SELECT iduser FROM apihash WHERE apihash_hash = '".$hashSend."' ");
          $countIDuser = $getIDuser->num_rows;
          if($countIDuser == 0){
            $pesan = "Sorry! no profile found";
            $daJson["pesan"] = $pesan;
            $daJson["status"] = $status;
            $printJson = json_encode($daJson);
            echo $printJson;
            exit();
          } else {
            $fetchIDuser = $getIDuser->fetch_assoc();
            $idUser = $fetchIDuser["iduser"];
            //Email Tanpa Titik
            $emailNoDotPecah = explode("@", $accountEmail);
            $emailNoDotHasil = $emailNoDotPecah[0];
            $emailNoDotHasilbelakang = $emailNoDotPecah[1];
            $emailNoDotHasil = str_replace(".", "", $emailNoDotHasil);
            $inputEmailNoDot = $emailNoDotHasil.'@'.$emailNoDotHasilbelakang;
            $fullnameupdate = $accountFirstName." ".$accountLastName;
            $getCheckEmail = $conn->query("SELECT * FROM masterpelanggan WHERE emailtanpatitik = '".$inputEmailNoDot."' ");
            $countCheckEmail = $getCheckEmail->num_rows;
            if($countCheckEmail == 0){
              //Querying
              $conn->query("UPDATE masterpelanggan SET
              firstname = '".$accountFirstName."',
              lastname = '".$accountLastName."',
              fullname = '".$fullnameupdate."',
              company = '".$accountCompany."',
              notelp = '".$accountPhone."',
              email = '".$accountEmail."',
              emailtanpatitik = '".$inputEmailNoDot."',
              lahirtgl = '".$accountBirthDate."',
              setujunews = '".$accountNewsletter."'
              WHERE iduser = '".$idUser."' ");
              $pesan = "Successfully update user data";
              $status = "Success";
            } else if($countCheckEmail == 1){
              $fetchCheckEmail = $getCheckEmail->fetch_assoc();
              $checkEmailID = $fetchCheckEmail["iduser"];
              if($checkEmailID == $idUser){
                $conn->query("UPDATE masterpelanggan SET
                firstname = '".$accountFirstName."',
                lastname = '".$accountLastName."',
                fullname = '".$fullnameupdate."',
                company = '".$accountCompany."',
                notelp = '".$accountPhone."',
                email = '".$accountEmail."',
                emailtanpatitik = '".$inputEmailNoDot."',
                lahirtgl = '".$accountBirthDate."',
                setujunews = '".$accountNewsletter."'
                WHERE iduser = '".$idUser."' ");
                $pesan = "Successfully update user data";
                $status = "Success";
              } else {
                $pesan = "Sorry! this email is already exists!";
              }
            } else {
              $pesan = "Sorry! there was an error with email";
            }
          }
        }
      }
    } else {
      $pesan = "Sorry! there was an error with side parameter!";
    }
  }
} else if($do == "pass"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! hash is null";
  } else if(!isset($_POST["password"])){
    $pesan = "Error! password is null";
  } else {
    $hashsend = $_POST["hash"];
    $pwd = $_POST["password"];
    if($hashsend == ""){
      $pesan = "Sorry! hash cannot be empty!";
    } else if($pwd == ""){
      $pesan = "Sorry! password cannot be empty!";
    } else {
      include "config.php";
      $getIDuser = $conn->query("SELECT iduser FROM apihash WHERE apihash_hash = '".$hashsend."' ");
      $countIDuser = $getIDuser->num_rows;
      if($countIDuser != 1){
        $pesan = "Sorry! no profile found";
        $daJson["pesan"] = $pesan;
        $daJson["status"] = $status;
        $printJson = json_encode($daJson);
        echo $printJson;
        exit();
      } else {
        $fetchIDuser = $getIDuser->fetch_assoc();
        $idUser = $fetchIDuser["iduser"];
        $pwdhashed = hash('sha256', $pwd);
        $setPassword = $conn->query("UPDATE masterpelanggan SET password = '".$pwdhashed."' WHERE iduser = '".$idUser."' ");
        $pesan = "Successfully update password";
        $status = "Success";
      }
    }
  }
} else {
  $pesan = "Error! there was an error";
}
$daJson["pesan"] = $pesan;
$daJson["status"] = $status;
$printJson = json_encode($daJson);
echo $printJson;
exit();
?>
