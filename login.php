<?php
include "config.php";
$headerURL = "https://localhost/sidar-git/";
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
    
$useragent = $_SERVER['HTTP_USER_AGENT'];

$latitude = $_POST["latitude"];    
$longitude = $_POST["longitude"];  

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
 

if(empty($latitude)){
$latitude = "-";    
}
    
if(empty($longitude)){
$longitude = "-";      
}    
    
date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');
$jam = date('h:i:s');



if(strlen($_POST['username']) >= 30 || strlen($_POST['password']) >= 30 ){
// header("Location: https://localhost/sidar/login");
header("Location: ".$headerURL."login");
exit();
} 
//  var_dump(strlen($_POST['username']));
// die;
if(empty($_POST['username'])){
 echo " UserName is empty! ";
 return false;


}
elseif (empty($_POST['password'])){
  echo " Password is empty! ";
  return false;
}
else{
  
 $username = strtolower(addslashes($_POST['username']));
 $password = strtolower(addslashes($_POST['password']));
 $password = encrypt_decrypt('encrypt', $password); 

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
   
   $updatelog = "INSERT INTO log (iduser, tanggal, jam, activity, ip, userdevice, latitude, longitude) VALUE ('".$iduser."', '".$tanggal."', '".$jam."', '".$activity."', '".$ip."', '".$useragent."', '".$latitude."', '".$longitude."')"; 
   $queryupdatelog =$conn->query($updatelog);
 
   $ambilnomer = "SELECT nodar FROM dar 
   WHERE iduser = '" .$iduser. "' ORDER BY urid DESC LIMIT 1 ;";
   $queryambilnomer =$conn->query($ambilnomer);
    
    if($queryambilnomer){
      $rowambilnomer = mysqli_fetch_array($queryambilnomer, MYSQLI_ASSOC);
      $_SESSION["Nodar"] = $rowambilnomer['nodar'];
    }
  //  var_dump("134");
  // die;
 if($dahupdatemail == "belum"){
  // var_dump("belum");
  // die;
    //  header("location: emailupdate.php");
     header("Location: ".$headerURL."emailupdate.php");
 }else{
  // var_dump("sudah");
  // die;
    //  header("location: /sidar"); 
     header("Location: ".$headerURL);
 }
  // if($_SESSION["Level"] != "admin") header("location: index.php");
  // else header("location: index.php");
 }
 else{
   $activity = "salah password";
   $updatelogsalahpass = "INSERT INTO log (iduser, tanggal, jam, activity, ip, userdevice, latitude, longitude) VALUE ('".$username."', '".$tanggal."', '".$jam."', '".$activity."', '".$ip."', '".$useragent."', '".$latitude."', '".$longitude."')"; 
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