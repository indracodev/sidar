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
$hcs = $_GET['hcs'];

$aidiuser = $_GET['usr'];


if($hcs == '1'){
$acceptabsence = "UPDATE formtelat SET mengetahuihcs='Setuju' WHERE notelat='".$nodar."' ";
}else{
$acceptabsence = "UPDATE formtelat SET menyetujuiatasan='Setuju' WHERE notelat='".$nodar."' ";    
}

 

if ($conn->query($acceptabsence) === TRUE) {

  $updatelogsalahpass = "INSERT INTO formtelatsetuju (notelat, tanggal, jam, iduseryangsetuju, ip, userdevice, status) VALUE ('".$nodar."', '".$tanggal."', '".$jam."', '".$aidiuser."', '".$ip."', '".$useragent."', 'Setuju')"; 
   $queryupdatelogsalahpass =$conn->query($updatelogsalahpass);        
    
echo '<script>
	alert("Izin Telat berhasil di terima");
	window.location.assign("formtelat.php");
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
	alert(" Izin Telat gagal di terima ");
	window.location.assign("formtelat.php");
</script>' ;


  }



?>