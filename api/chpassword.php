<?php
include "../config.php";
session_start();

$iduser = addslashes($_POST['iduser']);
$username = addslashes(strtolower($_POST['username']));
$passwordsaatini = addslashes(strtolower($_POST['passwordsaatini']));
$passwordbaru = addslashes(strtolower($_POST['passwordbaru']));
  
  if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else{
      $ip=$_SERVER['REMOTE_ADDR'];
    }
   
$useragent = $_SERVER['HTTP_USER_AGENT'];   
    
date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');
$jam = date('h:i:s');

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

$passwordsaatini = encrypt_decrypt('encrypt', $passwordsaatini);  
$passwordbaru = encrypt_decrypt('encrypt', $passwordbaru);  


 $string = "SELECT * FROM masteruser 
 WHERE masteruser.username = '" .$username . "' AND masteruser.id = '" .$iduser . "' AND masteruser.password = '" .$passwordsaatini."';";
 $query =$conn->query($string);
 
 if($query->num_rows){
   $respass = "UPDATE masteruser SET password='".$passwordbaru."' WHERE id='".$iduser."' ; ";


 //$query =$conn->query($respass);
 if($conn->query($respass) === TRUE){


   $activity = "reset pass";
   $updatelog = "INSERT INTO log (iduser, tanggal, jam, activity, ip, userdevice) VALUE ('".$iduser."', '".$tanggal."', '".$jam."', '".$activity."', '".$ip."', '".$useragent."')"; 
   $queryupdatelog =$conn->query($updatelog);

 
$json = array(
       'result' => 'Password Sukses Terganti',
       );
       
echo json_encode($json); 
 } 

 else{
$json = array(
       'result' => 'Password Gagal Terganti',
       );
       
echo json_encode($json); 
 
 }

}else{
$json = array(
       'result' => 'Password Saat Ini Tidack sama',
       );
       
echo json_encode($json); 
     
    
}
 

?>