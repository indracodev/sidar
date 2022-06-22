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
   
   header("location: http://www.icg.id/beta/dar/index.php");
 } 

 else{
      echo '<script>
	alert(" Password Gagal Diupdate ");
	window.location.assign("index.php");
</script>' ;
     header("location: http://www.icg.id/beta/dar/index.php");
   //echo " Akses yang Ditolak ";
 }
}

else{
    
    
          echo '<script>
	alert(" Password Tidak Sama ");
	window.location.assign("index.php");
</script>' ;
     header("location: http://www.icg.id/beta/dar/index.php");
   //echo " Akses yang Ditolak ";
 }
    

?>