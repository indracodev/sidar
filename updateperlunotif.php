<?php
session_start();
//$IUser = $_SESSION["IUser"];
// Load file koneksi.php
include "config.php";
// Ambil Data yang Dikirim dari Form
//$tgl = $_POST['tgl'];
//$jam = $_POST['jam'];
$IUUser = $_GET['idnya'];


$perlunotif = $_GET['perlunotif'];




$updateuser .= "UPDATE masteruser SET perlunotif='".$perlunotif."' WHERE id='".$IUUser."' ";


if ($conn->query($updateuser) === TRUE) {
echo '<script>
	alert(" Notif Berhasil Diupdate ");
	window.location.assign("listusernotif.php");
</script>' ;
} 
else{
 

echo $IUUser;
echo "<br>";
echo $perlunotif ;
echo "<br>";



  }
    
 
?>