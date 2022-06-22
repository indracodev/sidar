<?php
session_start();
include "config.php";

    
date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');
$jam = date('h:i:s');

$IUser = $_POST['iduser'];
$nama = $_POST['nama'];
$unitusaha = $_POST['unitusaha'];
$departemen = $_POST['departement'];
$divisi = $_POST['divisi'];
$tgltelat = $_POST['tgltelat'];
$timetelat = $_POST['timetelat'];
$alasan = $_POST['alasan'];
$keatasan = $_POST['keatasan'];
$notifhcs = $_POST['notifhcs'];
$notifupdate = $_POST['notifupdate'];
$numbertelat = $_POST['numbertelat'];

if($notifhcs == 'yes'){
$sudahisialasan = 'belum';    
}else{
$sudahisialasan = 'iya';     
}

$terlambatke = "-";
$ijintertulisatasan = "-";
$dibuatpadatgl = date('Y-m-d');
$menyetujuiatasan = "Belum";
$mengetahuihcs = "Belum";


 $ambilnomer = "SELECT notelat FROM formtelat 
   WHERE iduser = '" .$IUser. "' ORDER BY id DESC LIMIT 1 ;";
   $queryambilnomer =$conn->query($ambilnomer);
 if($queryambilnomer->num_rows){
   session_start();
 $rowambilnomer = mysqli_fetch_array($queryambilnomer, MYSQLI_ASSOC);
 $notelat = $rowambilnomer['notelat'];
 
 $pecah = explode("/", $notelat);
$hasil = $pecah[1] + 1;
$notelatnya = $IUser."/".$hasil;

 }
 else{
    // header("location: http://www.icg.id/beta/dar/login");
    $satu = "1";
   //echo " gak dapat nomer ";
   $notelatnya = $IUser."/".$satu;
 
 }



if($notifupdate == 'yes'){
 $updatelog = "UPDATE formtelat SET alasan='".$alasan."', sudahisialasan='iya' WHERE notelat='".$numbertelat."' ";    
}else{
 $updatelog = "INSERT INTO formtelat (notelat, iduser, nama, unitusaha, departemen, bagian, telatpadatanggal, masukjam, terlambatke, alasan, ijintertulisatasan, dibuatpadatgl, ke1, menyetujuiatasan, mengetahuihcs, sudahisialasan) VALUE ('".$notelatnya."', '".$IUser."', '".$nama."', '".$unitusaha."', '".$departemen."', '".$divisi."', '".$tgltelat."', '".$timetelat."', '".$terlambatke."', '".$alasan."','".$ijintertulisatasan."', '".$dibuatpadatgl."', '".$keatasan."', '".$menyetujuiatasan."',  '".$mengetahuihcs."',  '".$sudahisialasan."')";     
}


 
 $querytambahuser =$conn->query($updatelog);

 
 
if ($querytambahuser === TRUE) {

if($notifupdate == 'yes'){
echo '<script>
	window.location.assign("index.php");
</script>' ;
}else{
echo '<script>
	window.location.assign("formtelat.php");
</script>' ;
}
    

} 
else{
echo $idterakhir; 
echo "<br>";
echo $unitusaha;
echo "<br>";
echo $departemen;
echo "<br>";
echo $divisi;
echo "<br>";
echo $jabatan;
echo "<br>";
echo $nama;
echo "<br>";
echo $email;
echo "<br>";
echo $notlp;
echo "<br>";
echo $kota;
echo "<br>";
echo $level;
echo "<br>";
echo $username;
echo "<br>";
echo $password;
echo "<br>";
echo $ke;
echo "<br>";
echo $ke2;
echo "<br>";
echo $ke3;
echo "<br>";
echo $ke4;
echo "<br>";
echo $ke5;
echo("Error description: " . mysqli_error($conn));
echo '<script>
	alert("Gagal Insert Data ");
//window.location.assign("index.php");
</script>' ;

  }
    
 
?>