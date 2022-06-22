<?php
include "config.php";
session_start();

$IUser = $_SESSION["IDUser"] ;

  if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else{
      $ip=$_SERVER['REMOTE_ADDR'];
    }
  

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
    
    
date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');
$jam = date('h:i:s');



if(empty($_POST['passone'])){
 echo " UserName is empty! ";
 return false;
}
elseif (empty($_POST['passtwo'])){
  echo " Password is empty! ";
  return false;
}
elseif($_POST['passtwo'] == $_POST['passone']){
 $passone = $_POST['passone'];
 $passtwo = $_POST['passtwo'];
 $encrypted_password = encrypt_decrypt('encrypt', $passone); 
$passone = $encrypted_password;
 $respass = "UPDATE masteruser SET password='".$passone."' WHERE id='".$IUser."' ; ";


 //$query =$conn->query($respass);
 if($conn->query($respass) === TRUE){


   $activity = "reset pass";
   $updatelog = "INSERT INTO log (iduser, tanggal, jam, activity, ip) VALUE ('".$IUser."', '".$tanggal."', '".$jam."', '".$activity."', '".$ip."')"; 
   $queryupdatelog =$conn->query($updatelog);

 
 echo '<script>
	alert(" Password Berhasil Diupdate ");
	window.location.assign("index.php");
</script>' ;
   
 //  header("location: https://www.sidar.id/index.php");
 } 

 else{
      echo '<script>
	alert(" Password Gagal Diupdate ");
	window.location.assign("index.php");
</script>' ;
  //   header("location: https://www.sidar.id/index.php");
   //echo " Akses yang Ditolak ";
 }
}

else{
    
    
          echo '<script>
	alert(" Password Tidak Sama ");
	window.location.assign("index.php");
</script>' ;
 //    header("location: https://www.sidar.id/index.php");
   //echo " Akses yang Ditolak ";
 }
    

?>