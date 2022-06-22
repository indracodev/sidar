<?php
include "auth.php";
$daJson = array();

$do = $_GET["do"];
if($do == "in"){
  if(!isset($_POST["email"])){
    echo "Error! Email is null";
    exit();
  } else if(!isset($_POST["password"])){
    echo "Error! Password is null";
    exit();
  }
  $status = "failed";
  $email = $_POST["email"];
  $password = $_POST["password"];
  if($email == ""){
    $pesan = "Email cannot be empty!";
  } else if($password == ""){
    $pesan = "Password cannot be empty!";
  } else {
    $passhash = hash('sha256', $password);
    include "config.php";
    $getUser = $conn->prepare("SELECT * FROM masterpelanggan WHERE email = ? AND password = ? ");
    $getUser->bind_param("ss", $email, $passhash);
    $getUser->execute();
    $resUser = $getUser->get_result();
    $countUser = $resUser->num_rows;
    if($countUser == 1){
      $hashsend = "supsend".$email.date("Ymdhisu");
      $hashesend = hash('sha256', $hashsend);
      $getDatauser = $conn->query("SELECT * FROM masterpelanggan WHERE email = '".$email."' AND password = '".$passhash."' ");
      $fetchDatauser = $getDatauser->fetch_assoc();
      $userIDs = $fetchDatauser["iduser"];
      $getIssetSes = $conn->query("SELECT * FROM apihash WHERE iduser = '".$userIDs."' ");
      $countIssetSes = $getIssetSes->num_rows;
      $loginVal = "login";
      if($countIssetSes == 0){
        $hashStatus = "Online";
        $conn->query("INSERT INTO apihash VALUES(NULL, '".$userIDs."', '".$hashesend."', NOW(), '".$hashStatus."', '".$loginVal."')");
      } else if($countIssetSes == 1){
        $conn->query("UPDATE apihash SET apihash_time = NOW() WHERE iduser = '".$userIDs."' ");
        $fetchIssetSes = $getIssetSes->fetch_assoc();
        $hashesend = $fetchIssetSes["apihash_hash"];
      } else {
        $conn->query("DELETE FROM apihash WHERE iduser = '".$userIDs."' ");
        $hashStatus = "Online";
        $conn->query("INSERT INTO apihash VALUES(NULL, '".$userIDs."', '".$hashesend."', NOW(), '".$hashStatus."', '".$loginVal."')");
      }
      $daJson["hash"] = $hashesend;
      $pesan = "Logged in";
      $status = "Success";
    } else {
      $pesan = "Wrong User or Password";
      $status = "failed";
    }
  }
  $daJson["status"] = $status;
  $daJson["message"] = $pesan;
} else if($do == "regis"){
  $status = "failed";
  $pesan = "";
  if(!isset($_POST["firstname"])){
    $pesan = "Error! Null firstname";
    $daJson["message"] = $pesan;
    $daJson["status"] = $status;
    $daJson["res"] = "regis";
    $printJson = json_encode($daJson);
    echo $printJson;
    exit();
  } else if(!isset($_POST["lastname"])){
    $pesan = "Error! Null lastname";
    $daJson["message"] = $pesan;
    $daJson["status"] = $status;
    $daJson["res"] = "regis";
    $printJson = json_encode($daJson);
    echo $printJson;
    exit();
  } else if(!isset($_POST["email"])){
    $pesan = "Error! Null email";
    $daJson["message"] = $pesan;
    $daJson["status"] = $status;
    $daJson["res"] = "regis";
    $printJson = json_encode($daJson);
    echo $printJson;
    exit();
  } else if(!isset($_POST["password"])){
    $pesan = "Error! Null password";
    $daJson["message"] = $pesan;
    $daJson["status"] = $status;
    $daJson["res"] = "regis";
    $printJson = json_encode($daJson);
    echo $printJson;
    exit();
  } else if(!isset($_POST["phone"])){
    $pesan = "Error! Null phone";
    $daJson["message"] = $pesan;
    $daJson["status"] = $status;
    $daJson["res"] = "regis";
    $printJson = json_encode($daJson);
    echo $printJson;
    exit();
  } else if(!isset($_POST["offer"])){
    $pesan = "Error! Null Offer";
    $daJson["message"] = $pesan;
    $daJson["status"] = $status;
    $daJson["res"] = "regis";
    $printJson = json_encode($daJson);
    echo $printJson;
    exit();
  }
  $inputFirstName   = $_POST["firstname"];
  $inputLastName    = $_POST["lastname"];
  $inputEmail       = $_POST["email"];
  $inputPassword    = $_POST["password"];
  $inputPhone       = $_POST["phone"];
  $inputOffer       = $_POST["offer"];
  if($inputOffer == 1){
    $inputOffer = "news";
  }
  if($inputFirstName == ""){
    $pesan = "Error! First name cannot be empty!";
    $daJson["message"] = $pesan;
    $daJson["status"] = $status;
    $daJson["res"] = "regis";
    $printJson = json_encode($daJson);
    echo $printJson;
    exit();
  } else if($inputLastName == ""){
    $pesan = "Error! Last name cannot be empty!";
    $daJson["message"] = $pesan;
    $daJson["status"] = $status;
    $daJson["res"] = "regis";
    $printJson = json_encode($daJson);
    echo $printJson;
    exit();
  } else if($inputEmail == ""){
    $pesan = "Error! Email cannot be empty!";
    $daJson["message"] = $pesan;
    $daJson["status"] = $status;
    $daJson["res"] = "regis";
    $printJson = json_encode($daJson);
    echo $printJson;
    exit();
  } else if($inputPassword == ""){
    $pesan = "Error! Password cannot be empty!";
    $daJson["message"] = $pesan;
    $daJson["status"] = $status;
    $daJson["res"] = "regis";
    $printJson = json_encode($daJson);
    echo $printJson;
    exit();
  } else if($inputPhone == ""){
    $pesan = "Error! Phone cannot be empty!";
    $daJson["message"] = $pesan;
    $daJson["status"] = $status;
    $daJson["res"] = "regis";
    $printJson = json_encode($daJson);
    echo $printJson;
    exit();
  } else {
    $inputFullname = $inputFirstName." ".$inputLastName;
    $inputWebsite = "-";
    $inputCompany = "-";
    $inputGambar = "-";
    $inputAlamat = "-";
    $inputKecamatan = "-";
    $inputKota = "-";
    $inputProvinsi = "-";
    $inputNegara = "-";
    $inputKodeNegara = "-";
    $inputKodepos = "-";
    $inputStatusMember = "Silver";
    $inputPoin = 0;
    $inputSaldoRedeem = 0;
    $inputTgllahir = NULL;
    //Email Explode
    $emailNoDotPecah = explode("@", $inputEmail);
    $emailNoDotHasil = $emailNoDotPecah[0];
    $emailNoDotHasilbelakang = $emailNoDotPecah[1];
    $emailNoDotHasil = str_replace(".", "", $emailNoDotHasil);
    $inputEmailNoDot = $emailNoDotHasil.'@'.$emailNoDotHasilbelakang;
    include "config.php";
    //Check Email Availabiliy
    $checkEmailIsset = $conn->query("SELECT emailtanpatitik FROM masterpelanggan WHERE emailtanpatitik = '".$inputEmailNoDot."' ");
    $countEmailIsset = $checkEmailIsset->num_rows;
    if($countEmailIsset != 0){
      $pesan = "Sorry, the user is already exist";
      $daJson["message"] = $pesan;
      $daJson["status"] = $status;
      $daJson["res"] = "regis";
      $printJson = json_encode($daJson);
      echo $printJson;
      exit();
    } else {
      //referal check
      $referalstatus = "";
      $referalParent = "";
      if(isset($_POST["referal"])){
        $inputReferalCode = $_POST["referal"];
        if($inputReferalCode != ""){
          $checkReferal = $conn->query("SELECT * FROM referal WHERE referal_kode = '".$inputReferalCode."' ");
          $countReferal = $checkReferal->num_rows;
          if($countReferal != 1){
            $pesan = "Sorry, referal code not exists!";
            $daJson["message"] = $pesan;
            $daJson["status"] = "failed";
            $daJson["res"] = "regis";
            $printJson = json_encode($daJson);
            echo $printJson;
            exit();
          } else {
            $referalstatus = "OK";
            $fetchReferal = $checkReferal->fetch_assoc();
            $referalParent = $fetchReferal["iduser"];
          }
        } else {
          $referalstatus = "";
          $referalParent = "";
        }
      } else {
        $inputReferalCode = "";
      }
      //Generate RefCode
      $referalCode = "RFR-".rand(100,999)."MBL".rand(1000,9999);
      $checkIssetRefCode = $conn->query("SELECT * FROM referal WHERE referal_kode = '".$referalCode."' ");
      $countIssetRefCode = $checkIssetRefCode->num_rows;
      while($countIssetRefCode != 0){
        $referalCode = "RFR-".rand(100,999)."MBL".rand(1000,9999);
        $checkIssetRefCode = $conn->query("SELECT * FROM referal WHERE referal_kode = '".$referalCode."' ");
        $countIssetRefCode = $checkIssetRefCode->num_rows;
      }
      //Username unique character
      $unaameNum = 0;
      $fixuname = $inputFirstName;
      $checkUname = $conn->query("SELECT username FROM masterpelanggan WHERE username = '".$fixuname."' ");
      $countUname = $checkUname->num_rows;
      while($countUname != 0){
        $unaameNum++;
        $fixuname = $inputFirstName.$unaameNum;
        $checkUname = $conn->query("SELECT username FROM masterpelanggan WHERE username = '".$fixuname."' ");
        $countUname = $checkUname->num_rows;
      }

      $passhashed = hash('sha256',$inputPassword);
      //Insert Data
      $conn->query("INSERT INTO masterpelanggan (
        username,
        password,
        email,
        emailtanpatitik,
        notelp,
        firstname,
        lastname,
        fullname,
        nickname,
        website,
        company,
        gambar,
        alamat,
        kecamatan,
        kota,
        provinsi,
        negara,
        kodenegara,
        kodepos,
        setujunews,
        poin,
        saldoredem,
        referralcode,
        statusmembership
      ) VALUE (
        '".$fixuname."',
        '".$passhashed."',
        '".$inputEmail."',
        '".$inputEmailNoDot."',
        '".$inputPhone."',
        '".$inputFirstName."',
        '".$inputLastName."',
        '".$inputFullname."',
        '".$inputFirstName."',
        '".$inputWebsite."',
        '".$inputCompany."',
        '".$inputGambar."',
        '".$inputAlamat."',
        '".$inputKecamatan."',
        '".$inputKota."',
        '".$inputProvinsi."',
        '".$inputNegara."',
        '".$inputKodeNegara."',
        '".$inputKodepos."',
        '".$inputOffer."',
        '".$inputPoin."',
        '".$inputSaldoRedeem."',
        '".$referalCode."',
        '".$inputStatusMember."'
      )");

      //Init referal table
      $getIDthisuser = $conn->query("SELECT iduser FROM masterpelanggan WHERE emailtanpatitik = '".$inputEmailNoDot."' ");
      $countIDthisuser = $getIDthisuser->num_rows;
      if($countIDthisuser == 0){
        $pesan = "Error found when trying to get this user data!";
        $daJson["message"] = $pesan;
        $daJson["status"] = "failed";
        $daJson["res"] = "regis";
        $printJson = json_encode($daJson);
        echo $printJson;
        exit();
      } else {
        $fetchIDthisuser = $getIDthisuser->fetch_assoc();
        $idThisuser = $fetchIDthisuser["iduser"];
        $belumVal = "Belum";
        //Write Referal
        $conn->query("INSERT INTO referal (
          iduser,
          iduserparent,
          referal_kode,
          referal_parent,
          sudahminspend
        ) VALUE (
          '".$idThisuser."',
          '".$referalParent."',
          '".$referalCode."',
          '".$inputReferalCode."',
          '".$belumVal."'
        )");
        //Write Voucher Own
        $voucherRegName = "Bonus Registrasi";
        $voucherRegNomAng = "5";
        $voucherRegStatus = "Aktif";
        $voucherKode = "REG-".rand(100,999)."MBL".rand(1000,9999);
        $checkVouchKode = $conn->query("SELECT * FROM voucher WHERE voucher_kode = '".$voucherKode."' ");
        $countVouchKode = $checkVouchKode->num_rows;
        while($countVouchKode != 0){
          $voucherKode = "REG-".rand(100,999)."MBL".rand(1000,9999);
          $checkVouchKode = $conn->query("SELECT * FROM voucher WHERE voucher_kode = '".$voucherKode."' ");
          $countVouchKode = $checkVouchKode->num_rows;
        }
        $conn->query("INSERT INTO voucher (
          voucher_kode,
          iduser,
          voucher_nama,
          voucher_nominalangka,
          voucher_timestart,
          voucher_timeend,
          voucher_timemade,
          voucher_status,
          jumlahpakai,
          minimumorder,
          member,
          tipe,
          gambar
        ) VALUE (
          '".$voucherKode."',
          '".$idThisuser."',
          '".$voucherRegName."',
          '".$voucherRegNomAng."',
          NOW(),
          NOW() + INTERVAL 30 DAY,
          NOW(),
          '".$voucherRegStatus."',
          '1',
          '0',
          'ya',
          'bulat',
          '/img/registergambarvoucher.jpg'
        ) ");
        // If isset Referal
        if($referalstatus != ""){
          $voucherRegStatus = "Aktif";
          $voucherRegRefName = "Bonus Referral Code 10%";
          $voucherRefKode = "REG-".rand(100,999)."MBL".rand(1000,9999);
          $checkVouchRefKode = $conn->query("SELECT * FROM voucher WHERE voucher_kode = '".$voucherRefKode."' ");
          $countVouchRefKode = $checkVouchRefKode->num_rows;
          while($countVouchRefKode != 0){
            $voucherRefKode = "REG-".rand(100,999)."MBL".rand(1000,9999);
            $checkVouchRefKode = $conn->query("SELECT * FROM voucher WHERE voucher_kode = '".$voucherRefKode."' ");
            $countVouchRefKode = $checkVouchRefKode->num_rows;
          }

          $conn->query("INSERT INTO voucher (
            voucher_kode,
            iduser,
            voucher_nama,
            voucher_nominalpersen,
            voucher_timestart,
            voucher_timeend,
            voucher_timemade,
            voucher_status,
            jumlahpakai,
            minimumorder,
            member,
            tipe,
            gambar
          ) VALUE (
            '".$voucherRefKode."',
            '".$referalParent."',
            '".$voucherRegRefName."',
            '10',
            NOW(),
            NOW() + INTERVAL 30 DAY,
            NOW(),
            '".$voucherRegStatus."',
            '1',
            '10',
            'ya',
            'bulat',
            '/img/registergambarvoucher.jpg'
          ) ");

        }
      }
      $pesan = "Successfully added new user";
      $daJson["message"] = $pesan;
      $daJson["status"] = "Success";
      $daJson["res"] = "regis";
      $printJson = json_encode($daJson);
      echo $printJson;
      exit();
    }
  }
  $daJson["message"] = $pesan;
  $daJson["status"] = $status;
  $daJson["res"] = "regis";
} else if($do == "out"){
  if(!isset($_POST["hash"])){
    echo "Error no hash detected";
    exit();
  }
  $hashSend = $_POST["hash"];
  $status = "failed";
  if($hashSend == ""){
    $pesan = "No hash found";
  } else {
    include "config.php";
    $getHash = $conn->query("SELECT * FROM apihash WHERE apihash_hash = '".$hashSend."' ");
    $countHash = $getHash->num_rows;
    if($countHash == 1){
      $statNonaktif = "Offline";
      $conn->query("UPDATE apihash SET apihash_status = '".$statNonaktif."' WHERE apihash_hash = '".$hashSend."' ");
      $status = "Success";
      $pesan = "Successfully logged out";
    } else {
      echo "Error! invalid hash";
      exit();
    }
  }
  $daJson["status"] = $status;
  $daJson["message"] = $pesan;
} else {
  $daJson["status"] = "failed";
  $daJson["res"] = "Theres no action detected";
}
$printJson = json_encode($daJson);
echo $printJson;
exit();
?>
