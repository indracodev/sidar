<?php
session_start();
include "config.php";

$noidsr = $_GET['idnya'];
$tipe = $_GET['tipe'];

if($tipe == 'iya'){
$isinya = 'izin';
$acceptresign .= "UPDATE masteruser SET izinabsenlk='".$isinya."' WHERE id='".$noidsr."' ";
}else{
$isinya = '-';    
$acceptresign .= "UPDATE masteruser SET izinabsenlk='".$isinya."' WHERE id='".$noidsr."' ";    
}

if ($conn->query($acceptresign) === TRUE) {
echo '<script>
	alert("berhasil di set");
	window.location.assign("setizinabsen.php");
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
	alert("gagal di set ");
	window.location.assign("setizinabsen.php");
</script>' ;


  }



?>