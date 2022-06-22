<?php 
require('phpmailer/phpmailer/PHPMailer.php');
require('phpmailer/phpmailer/SMTP.php');
require('phpmailer/phpmailer/Exception.php');

include "config.php";
session_start();


function encrypt_decrypt($action, $string)
{
  $output = false;
 
  $encrypt_method = "AES-256-CBC";
  $secret_key = 'osdkfje';
  $secret_iv = 'sdfvcdfeg';
 
  // hash
  $key = hash('sha256', $secret_key);
 
  // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a
  // warning
  $iv = substr(hash('sha256', $secret_iv), 0, 16);
 
  if ($action == 'encrypt')
  {
    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);
  }
  else
  {
    if ($action == 'decrypt')
    {
      $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
  }
 
  return $output;
}

if(empty($_POST['username'])){
 echo " UserName is empty! ";
 return false;
}
elseif (empty($_POST['email'])){
  echo " Email is empty! ";
  return false;
}
else{
 $username = addslashes($_POST['username']);
 $email = addslashes($_POST['email']);
 $string = "SELECT * FROM masteruser 
 WHERE username = '" .$username . "' AND email = '" .$email."';";
 $query =$conn->query($string);
 if($query->num_rows){
 $row = mysqli_fetch_array($query, MYSQLI_ASSOC);     
$password = $row['password'];
$password = encrypt_decrypt('decrypt', $password); 
$username = $row['username'];
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {

$mail->isSMTP();                                            // Send using SMTP
    $mail->Host     = 'sidar.id';
    $mail->SMTPAuth = true;
    $mail->Username = 'support@sidar.id';
    $mail->Password = 'm]*f#)MGP6GG';
    $mail->SMTPSecure = 'ssl';
    $mail->Port     = 465;

    //Recipients
    $mail->setFrom('support@sidar.id', 'sidar.id');
    $mail->addAddress($_POST['email'], 'User Sidar');


   
//    $mail->addAttachment('./pdfs/'.$filename);
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
   
    $mail->Subject = 'Sidar Password';
    
    $mail->Body    = "Username : $username
    <br>
    Password : $password
    ";

    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    $msg .= ' And,email has been sent';
   echo '<script>
	alert(" Password Berhasil Dikirim Ke Email ");
	alert(" Silakan Cek Email Anda");
	window.location.assign("index.php");
</script>' ;

} catch (Exception $e) {
    $msg .= " Mail could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


     
     
 }else{
   
       echo '<script>
	alert(" Username Dan Email Anda Tidak Match ");
	window.location.assign("login/forgotPassword.php");
</script>'    ; 
     
 }  
     


 
    
}



?>