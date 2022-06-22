<?php
header('Access-Control-Allow-Origin: *');
require('../phpmailer/phpmailer/PHPMailer.php');
require('../phpmailer/phpmailer/SMTP.php');
require('../phpmailer/phpmailer/Exception.php');
session_start();
//$IUser = $_SESSION["IUser"];
// Load file koneksi.php
include "../config.php";

$IUser = addslashes($_POST['userid']);
$nama = addslashes($_POST['nama']);
$username = addslashes(strtolower($_POST['username']));
$nofeednya = $_POST['nofeed'];
$Pesan = addslashes($_POST['message']);
$Email = addslashes($_POST['email']);

if(empty($Email)){
 $Email = 'kosong';   
}



$ambilfile = "SELECT * FROM feedattach 
WHERE nofeed = '" .$nofeednya. "' ORDER BY idattch DESC ;";
$queryambilfile =$conn->query($ambilfile);
$rowambilfile = mysqli_fetch_all($queryambilfile, MYSQLI_ASSOC);

    
$queryupimg = "INSERT INTO feedback (nofeed, message, iduser, email, nama, username) VALUE ('".$nofeednya."', '".$Pesan."','".$IUser."','".$Email."','".$nama."','".$username."')"; 
$sqlup = mysqli_query($conn, $queryupimg); 
   
for($x = 0; $x < sizeof($rowambilfile); $x++){
$filenamebaru =  $rowambilfile[$x]['gambar'];

$bodyattachh = '<br><img src="https://www.sidar.id/img/'.$IUser.'/'.$rowambilfile[$x]['gambar'].'" style="display: block;" width="100%" height="auto">';
$bodyattach = $bodyattach . $bodyattachh;
}

     
 $mail = new PHPMailer\PHPMailer\PHPMailer();
try {

//$mail->isSMTP();                                            // Send using SMTP
    $mail->Host     = 'sidar.id';
    $mail->SMTPAuth = true;
    $mail->Username = 'feedback@sidar.id';
    $mail->Password = '1g*[QPFe+v8E';
    $mail->SMTPSecure = 'ssl';
    $mail->Port     = 465;

    //Recipients
    $mail->setFrom('feedback@sidar.id', 'sidar.id');
    $mail->addBcc('dm@indraco.com', 'Admin Sidar');
    $mail->addBcc('ujicobaa33@gmail.com', 'User Sidar');


    $mail->addAttachment("../img/".$IUser."/".$filenamebaru[0]);

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
   
    $mail->Subject = 'Sidar Feedback';
    
    $mail->Body    = "Nama : $nama
     <br>
    Username : $username
    <br>
    Email : $Email
    <br>
    Message : $Pesan
    <br>
    $bodyattach
    ";

    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    $msg .= ' And,email has been sent';


$json = array(
       'result' => 'success',
       );
       
echo json_encode($json); 
     

} catch (Exception $e) {
    $msg .= " Mail could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
    
     
     
     
     

    
   
        $json = array(
       'result' => $bodyattach,
       );
       
echo json_encode($json); 
     

?>