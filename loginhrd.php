<?php
include "config.php";


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
 $string = "SELECT * FROM masteruser 
 WHERE masteruser.username = '" .$username . "' AND masteruser.password = '" .$password."';";
 $query =$conn->query($string);
 if($query->num_rows){
   session_start();
   $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
   $_SESSION["IDUser"] = $row['id'];
   $_SESSION["Jabatan"] = $row['jabatan'];
   $_SESSION["NMUser"] = $row['nama'];
   $_SESSION["Pass"] = $row['password'];
   $_SESSION["Lokasikerja"] = $row['lokasikerja'];
   $_SESSION["Unitusaha"] = $row['unitusaha'];
   $_SESSION["Level"] = $row['level'];
   $_SESSION["Ke"] = $row['ke'];
   $_SESSION["Ke2"] = $row['ke2'];
   $_SESSION["Ke3"] = $row['ke3'];
   $_SESSION["Ke4"] = $row['ke4'];
   $_SESSION["Ke5"] = $row['ke5'];
   $_SESSION["Hrd"] ='ada';
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
   
 
   if($_SESSION["Level"] != "admin") header("location: addUser.php");
   else header("location: addUser.php");
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