<?php
include "config.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

  if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else{
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    
    
date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');
$jam = date('h:i:s');





if(empty($_POST['username'])){
 echo " UserName is empty! ";
 return false;
}
elseif (empty($_POST['password'])){
  echo " Password is empty! ";
  return false;
}
else{
 $username = $_POST['username'];
 $password = $_POST['password'];
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
 
 
 $encrypted_password = encrypt_decrypt('encrypt', $password); 
 $password = $encrypted_password;

 $string = "SELECT * FROM masteruser 
 WHERE masteruser.username = '" .$username . "' AND masteruser.password = '" .$password."';";
 $query =$conn->query($string);
 if($query->num_rows){
   session_start();
   $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
   $_SESSION["IDUser"] = $row['id'];
   $_SESSION["Jabatan"] = $row['jabatan'];
   $_SESSION["NMUser"] = $row['nama'];
   $_SESSION["Dahupdatemail"] = $row['dahupdatemail'];
   $dahupdatemail = $row['dahupdatemail'];
   $_SESSION["Pass"] = $row['password'];
   $_SESSION["Lokasikerja"] = $row['lokasikerja'];
   $_SESSION["Unitusaha"] = $row['unitusaha'];
   $_SESSION["Level"] = $row['level'];
   $_SESSION["Ke"] = $row['ke'];
   $_SESSION["Ke2"] = $row['ke2'];
   $_SESSION["Ke3"] = $row['ke3'];
   $_SESSION["Ke4"] = $row['ke4'];
   $_SESSION["Ke5"] = $row['ke5'];
   $iduser = $row['id'];
   setcookie('IDUser', $iduser, strtotime('+360 days'), '/');
   setcookie('Jabatan', $row['jabatan'], strtotime('+360 days'), '/');
   setcookie('NMUser', $row['nama'], strtotime('+360 days'), '/');
   setcookie('Pass', $row['password'], strtotime('+360 days'), '/');
   setcookie('Unitusaha', $row['unitusaha'], strtotime('+360 days'), '/');
   setcookie('Level', $row['level'], strtotime('+360 days'), '/');
   setcookie('Ke', $row['ke'], strtotime('+360 days'), '/');
   setcookie('Ke2', $row['ke2'], strtotime('+360 days'), '/');
   setcookie('Ke3', $row['ke3'], strtotime('+360 days'), '/');
   setcookie('Ke4', $row['ke4'], strtotime('+360 days'), '/');
   setcookie('Ke5', $row['ke5'], strtotime('+360 days'), '/');
   $activity = "login";
   $updatelog = "INSERT INTO log (iduser, tanggal, jam, activity, ip) VALUE ('".$iduser."', '".$tanggal."', '".$jam."', '".$activity."', '".$ip."')"; 
   $queryupdatelog =$conn->query($updatelog);
 
   $ambilnomer = "SELECT nodar FROM dar 
   WHERE iduser = '" .$iduser. "' ORDER BY urid DESC LIMIT 1 ;";
   $queryambilnomer =$conn->query($ambilnomer);
    
    if($queryambilnomer){
      $rowambilnomer = mysqli_fetch_array($queryambilnomer, MYSQLI_ASSOC);
      $_SESSION["Nodar"] = $rowambilnomer['nodar'];
    }
   
 if($dahupdatemail == "belum"){
     header("location: emailupdate.php");
 }else{
     header("location: index.php"); 
 }
  // if($_SESSION["Level"] != "admin") header("location: index.php");
  // else header("location: index.php");
 }
 else{
   $activity = "salah password";
   $updatelogsalahpass = "INSERT INTO log (iduser, tanggal, jam, activity, ip) VALUE ('".$username."', '".$tanggal."', '".$jam."', '".$activity."', '".$ip."')"; 
   $queryupdatelogsalahpass =$conn->query($updatelogsalahpass);

 echo '<script>
	alert(" Password Salah ");
	window.location.assign("login");
</script>' ;
 
     //header("location: http://www.sidar.id/login");
   //echo " Akses yang Ditolak ";
 }
}
?>