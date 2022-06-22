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
 
 $useragent = $_SERVER['HTTP_USER_AGENT'];   
    
date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');
$jam = date('h:i:s');
 $dahupdatemail = "sudah";


if(empty($_POST['emailone'])){
 echo " email is empty! ";
 return false;
}
elseif (empty($_POST['emailtwo'])){
  echo " email is empty! ";
  return false;
}
elseif($_POST['emailtwo'] == $_POST['emailone']){
 $emailone = $_POST['emailone'];
 $emailtwo = $_POST['emailtwo'];
 $dahupdatemail = "sudah";
 $respass = "UPDATE masteruser SET email='".$emailone."', dahupdatemail='".$dahupdatemail."' WHERE id='".$IUser."' ; ";


 //$query =$conn->query($respass);
 if($conn->query($respass) === TRUE){


   $activity = "update email";
   $updatelog = "INSERT INTO log (iduser, tanggal, jam, activity, ip, userdevice) VALUE ('".$IUser."', '".$tanggal."', '".$jam."', '".$activity."', '".$ip."', '".$useragent."')"; 
   $queryupdatelog =$conn->query($updatelog);

 
 echo '<script>
	alert(" Email Berhasil Diupdate ");
	window.location.assign("index.php");
</script>' ;
   
 //  header("location: https://www.sidar.id/index.php");
 } 

 else{
      echo '<script>
	alert(" Email Gagal Diupdate ");
	window.location.assign("emailupdate.php");
</script>' ;
 //    header("location: https://www.sidar.id/index.php");
   //echo " Akses yang Ditolak ";
 }
}

else{
    
    
          echo '<script>
	alert(" Email Tidak Sama ");
	window.location.assign("emailupdate.php");
</script>' ;
 //    header("location: https://www.sidar.id/index.php");
   //echo " Akses yang Ditolak ";
 }
    

?>