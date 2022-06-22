<?php
session_start();
include "config.php";

$nodar = $_GET['idnya'];


$acceptabsence .= "UPDATE dar SET status='".'Absence'."' WHERE nodar='".$nodar."' ";


 

if ($conn->query($acceptabsence) === TRUE) {
echo '<script>
	alert("Absence berhasil di terima");
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
	alert(" Absence gagal di terima ");
	window.location.assign("confirmabsence.php");
</script>' ;


  }



?>