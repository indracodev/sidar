<?php
session_start();
//$IUser = $_SESSION["IUser"];
// Load file koneksi.php
include "config.php";
// Ambil Data yang Dikirim dari Form
//$tgl = $_POST['tgl'];
//$jam = $_POST['jam'];
$IUUser = $_POST['idnya'];


$lokasikerja = $_POST['lokasikerja'];
$unitusaha = $_POST['unitusaha'];
$departemen = $_POST['departemen'];
$divisi = $_POST['divisi'];
$jabatan = $_POST['jabatan'];
$nama = $_POST['nama'];
$level = $_POST['level'];
$email = $_POST['email'];
$notlp = $_POST['notlp'];
$kota = $_POST['kota'];
$nik = $_POST['nik'];
$ke = $_POST['ke'];
$ke1 = $_POST['ke1'];
$ke2 = $_POST['ke2'];
$ke3 = $_POST['ke3'];
$ke4 = $_POST['ke4'];
$ke5 = $_POST['ke5'];



$status = "kosong";
$IUser =  $_COOKIE["IDUser"];
$KEuser = $_COOKIE["Ke"];


    
date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');
$jam = date('h:i:s');

$updateuser .= "UPDATE masteruser SET nama='".$nama."', unitusaha='".$unitusaha."', departemen='".$departemen."', email='".$email."', nik='".$nik."', notlp='".$notlp."', jabatan='".$jabatan."', ke='".$ke."', ke2='".$ke2."', ke3='".$ke3."', ke4='".$ke4."', ke5='".$ke5."', divisi='".$divisi."', kota='".$kota."'  WHERE id='".$IUUser."' ";


if ($conn->query($updateuser) === TRUE) {
echo '<script>
	alert(" User Berhasil Diupdate ");
	window.location.assign("listedituser.php");
</script>' ;
} 
else{
 

echo $nama;
echo "<br>";
echo $unitusaha ;
echo "<br>";
echo $departemen ;
echo "<br>";
echo $email ;
echo "<br>";
echo $notlp ;
echo "<br>";
echo $jabatan ;
echo "<br>";
echo $divisi ;
echo "<br>";
echo $ke ;
echo "<br>";
echo $ke2 ;
echo "<br>";
echo $ke3 ;
echo "<br>";
echo $ke4 ;
echo "<br>";
echo $ke5 ;
echo "<br>";
echo $IUUser ;
echo "<br>";

/* 

echo $varlatesatumon ;
echo "<br>";
echo $varlatesatutue ;
echo "<br>";
echo $varlatesatuwed ;
echo "<br>";
echo $varlatesatuthu ;
echo "<br>";
echo $varlatesatufri ;
echo "<br>";
echo $varlatesatusat ;
echo "<br>";

echo $varlateduamon ;
echo "<br>";
echo $varlateduatue ;
echo "<br>";
echo $varlateduawed ;
echo "<br>";
echo $varlateduathu ;
echo "<br>";
echo $varlateduafri ;
echo "<br>";
echo $varlateduasat ;
echo "<br>";

echo $varovermon ;
echo "<br>";
echo $varovertue ;
echo "<br>";
echo $varoverwed ;
echo "<br>";
echo $varoverthu ;
echo "<br>";
echo $varoverfri ;
echo "<br>";
echo $varoversat ; 


echo '<script>
	alert(" Gagal Update User ");
	window.location.assign("index.php");
</script>' ;
*/

  }
    
 
?>