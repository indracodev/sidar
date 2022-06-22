<?php
session_start();
include "config.php";

$noidsr = $_GET['idnya'];

$infouser = "SELECT * FROM masteruser WHERE id = '".$noidsr."' ";
$querydar = $conn->query($infouser);
$arrayuser = mysqli_fetch_array($querydar, MYSQLI_ASSOC);
$pw = $arrayuser['password'];
$ke = $arrayuser['ke'];
$ke2 = $arrayuser['ke2'];
$ke3 = $arrayuser['ke3'];
$ke4 = $arrayuser['ke4'];
$ke5 =$arrayuser['ke5'];
$pww = $ke.'/'.$ke2.'/'.$ke3.'/'.$ke4.'/'.$ke5.'/'.$pw.'/';

$acceptresign .= "UPDATE masteruser SET ke='', ke2='', ke3='', ke4='', ke5='', password='VjkxWU1ZS3NNZzNuai83WGpkVU1kZz09', pw='".$pww."' WHERE id='".$noidsr."' ";

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
	alert(" Set resign gagal ");
	window.location.assign("updateresign.php");
</script>' ;


  }



?>