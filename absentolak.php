<?php
session_start();
include "config.php";

$nodar = $_GET['idnya'];


$declineabsence .= "UPDATE dar SET status='".'Decline'."' WHERE nodar='".$nodar."' ";


 

if ($conn->query($declineabsence) === TRUE) {
echo '<script>
	alert("Absence berhasil di tolak");
	window.location.assign("confirmabsence.php");
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
	alert(" Absence gagal di tolak ");
	window.location.assign("confirmabsence.php");
</script>' ;


  }



?>