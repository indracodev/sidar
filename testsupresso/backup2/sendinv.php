<?php
include "auth.php";
$do = $_GET["do"];
$status = "failed";
$pesan = "";
$daJson = array();

if($do == "send"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! no security key found";
  } else if(!isset($_POST["orderid"])){
    $pesan = "Error! code not found";
  } else {
    $hash = $_POST["hash"];
    $invCode = $_POST["orderid"];
    if($hash == ""){
      $pesan = "Sorry! security cannot be empty!";
    } else if($invCode == ""){
      $pesan = "Sorry! invoice key cannot be empty!";
    } else {
      include "config.php";
      //Hash checking
      $getHashData = $conn->query("SELECT * FROM apihash WHERE apihash_hash = '".$hash."' ");
      $countHashData = $getHashData->num_rows;
      if($countHashData != 1){
        $pesan = "Sorry! cannot perform this action. No securiy key found";
      } else {
        $fecthHashData = $getHashData->fetch_assoc();
        $idUser = $fecthHashData["iduser"];
        if($idUser == ""){
          //Guest
          $pesan = "Sorry! guest invoice is not available";
        } else {
          //Member
          $getInvData = $conn->query("SELECT * FROM daftarorder WHERE nomerorder = '".$invCode."' ");
          $countInvData = $getInvData->num_rows;
          if($countInvData != 1){
            $pesan = "Sorry! Invoice does not exist";
          } else {
            $fetchInvData = $getInvData->fetch_assoc();
            $thisInvOwn = $fetchInvData["iduser"];
            if($idUser != $thisInvOwn){
              $pesan = "Sorry! you are not the right owner of this transaction";
            } else {
              //Get member data
              $getMemberData = $conn->query("SELECT * FROM masterpelanggan WHERE iduser = '".$idUser."' ");
              $fetchMemberData = $getMemberData->fetch_assoc();
              $thisMemberName = $fetchMemberData["nickname"];
              $thisMemberEmail = $fetchMemberData["email"];

              //Assembly Body Email
              include "sendinv-mail.php";

              //Send Email
              require('phpmailer/PHPMailer.php');
              require('phpmailer/SMTP.php');
              require('phpmailer/Exception.php');
              $mail = new PHPMailer\PHPMailer\PHPMailer();

              try{
                //Send SMTP
              //  $mail->isSMTP();
                $mail->Host     = 'supresso.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'ecommerce@supresso.com';
                $mail->Password = 's{Vi(jz?B#sZ';
                $mail->SMTPSecure = 'ssl';
                $mail->Port     = 465;
                //Recipients
                $mail->setFrom('ecommerce@supresso.com', 'supresso.com');
                $mail->addAddress($thisMemberEmail, 'User Supresso');
                //Content
                $mail->isHTML(true);
                $mail->Subject = 'Supresso - Transaction History';
                $mail->Body = $echoPage;
                $mail->AltBody = 'Sorry, your email does not support HTML format';
                $mail->send();
                $status = "Success";
                $pesan = "Code sended! Check your email and enter the code";
                $daJson["email"] = $thisMemberEmail;
              } catch (Exception $e){
                $pesan = "Error: {$mail->ErrorInfo}";
              }
              $status = "Success";
            }
          }
        }
      }
    }
  }
} else {
  $pesan = "Sorry! no action found!";
}

$daJson["message"] = $pesan;
$daJson["status"] = $status;
$printJson = json_encode($daJson);
echo $printJson;
exit();
?>
