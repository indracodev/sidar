<?php
session_start();
include "config.php";

date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');
$jam = date('h:i:s');

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

$nodar = $_GET['idnya'];
$delegasi = $_GET['delegasi'];
$hcs = $_GET['hcs'];
$aidiuser = $_GET['usr'];

if($hcs == '1'){
$acceptabsence = "UPDATE formcuti SET mengetahuihcs='Tidak' WHERE nocuti='".$nodar."' ";    
}else{

if($delegasi == '1'){
$acceptabsence = "UPDATE formcuti SET menyetujuidelegasi='Tidak' WHERE nocuti='".$nodar."' ";
}else{
$acceptabsence = "UPDATE formcuti SET menyetujuiatasan='Tidak' WHERE nocuti='".$nodar."' ";    
}

}

 

if ($conn->query($acceptabsence) === TRUE) {

   $updatelogsalahpass = "INSERT INTO formcutisetuju (nocuti, tanggal, jam, iduseryangsetuju, ip, userdevice, status) VALUE ('".$nodar."', '".$tanggal."', '".$jam."', '".$aidiuser."', '".$ip."', '".$useragent."', 'Tidak')"; 
   $queryupdatelogsalahpass =$conn->query($updatelogsalahpass);    
    
echo '<script>
	alert("Izin Cuti berhasil di terima");
	window.location.assign("formcuti.php");
</script>' ;
} 
else{
    // Jika Gagal, Lakukan :
    /*
  echo $IUser; 
  echo $KEuser;
  echo $status;
  echo $tanggal;
  echo $jam;
  echo $planning;
  echo $activity;
  echo $tags;
  echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database";
*/
echo '<script>
	alert(" Izin Cuti gagal di terima ");
	window.location.assign("formcuti.php");
</script>' ;


  }



?>