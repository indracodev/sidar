<?php
session_start();
include "config.php";

$noidsr = $_GET['idnya'];

$infouser = "SELECT * FROM masteruser WHERE id = '".$noidsr."' ";
$querydar = $conn->query($infouser);
$arrayuser = mysqli_fetch_array($querydar, MYSQLI_ASSOC);
$pw = $arrayuser['pw'];

$pecah = explode("/", $pw);
$ke = $pecah[0];
$ke2 = $pecah[1];
$ke3 = $pecah[2];
$ke4 = $pecah[3];
$ke5 = $pecah[4];
$pww = $pecah[5];

$acceptresign .= "UPDATE masteruser SET password='".$pww."', ke='".$ke."', ke2='".$ke3."', ke3='".$ke3."', ke4='".$ke4."', ke5='".$ke5."'  WHERE id='".$noidsr."' ";
 

if ($conn->query($acceptresign) === TRUE) {
echo '<script>
	alert("Resign berhasil di set");
	window.location.assign("updateresign.php");
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
	alert(" Resign gagal di set ");
	window.location.assign("updateresign.php");
</script>' ;


  }



?>