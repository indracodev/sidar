<?php
include "config.php";
session_start(); //to ensure you are using same session

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


 $iduser = $_SESSION["IDUser"];
 $activity = "logout";

  $updatelog = "INSERT INTO log (iduser, tanggal, jam, activity, ip) VALUE ('".$iduser."', '".$tanggal."', '".$jam."', '".$activity."', '".$ip."')"; 
 $queryupdatelog =$conn->query($updatelog);


   $_SESSION["IDUser"] = "";
   $_SESSION["Jabatan"] = "";
   $_SESSION["NMUser"] = "";
   $_SESSION["Pass"] = "";
   $_SESSION["Unitusaha"] = "";
   setcookie('IDUser', '');
   setcookie('Jabatan', '');
   setcookie('NMUser', '');
   setcookie('Pass', '');
   setcookie('Unitusaha', '');
   setcookie('Level', '');
   setcookie('Ke', '');
   setcookie('Ke2', '');
   setcookie('Ke3', '');
   setcookie('Ke4', '');
   setcookie('Ke5', '');
?>
<script>
//	alert(" Berhasil Logout ");
	window.location.assign("index.php");
</script>



?>