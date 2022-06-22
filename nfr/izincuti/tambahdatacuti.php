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
$tglcuti = $_POST['tglcuti'];
$tglmasukkerja = $_POST['tglmasukkerja'];
$jumlahhari = $_POST['jumlahhari'];
$keperluan = $_POST['keperluan'];
$delegasi = $_POST['delegasi'];
$alasan = $_POST['alasan'];
$keatasan = $_POST['keatasan'];
$notifhcs = $_POST['notifhcs'];
$notifupdate = $_POST['notifupdate'];
$numbertelat = $_POST['numbertelat'];
$sisacuti = $_POST['sisacutix'];

$status = 'ok';

if($sisacuti < $jumlahhari){
echo '<script>
    alert("Sisa cuti anda tidak mencukupi");
	window.location.assign("addformcuti.php");
</script>' ;
exit();
}

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
$menyetujuidelegasi = "Belum";

 $pecahdelegasi = explode("/", $delegasi);
 $iduserdelegasi = $pecahdelegasi[0];
 $namauserdelegasi = $pecahdelegasi[1];

 $ambiluser = "SELECT * FROM masteruser 
   WHERE id = '" .$IUser. "' ;";
$queryambiluser =$conn->query($ambiluser);
$rowambiluser = mysqli_fetch_array($queryambiluser, MYSQLI_ASSOC);
 $grupcutiku = $rowambiluser['grupcutiku'];
 $kuotagrupcuti = $rowambiluser['kuotagrupcuti'];
 
 $ambilnomer = "SELECT nocuti FROM formcuti 
   WHERE iduser = '" .$IUser. "' ORDER BY id DESC LIMIT 1 ;";
   $queryambilnomer =$conn->query($ambilnomer);
 if($queryambilnomer->num_rows){
   session_start();
 $rowambilnomer = mysqli_fetch_array($queryambilnomer, MYSQLI_ASSOC);
 $nocuti = $rowambilnomer['nocuti'];
 
 $pecah = explode("/", $nocuti);
$hasil = $pecah[1] + 1;
$nocutinya = $IUser."/".$hasil;

 }
 else{
    // header("location: http://www.icg.id/beta/dar/login");
    $satu = "1";
   //echo " gak dapat nomer ";
   $nocutinya = $IUser."/".$satu;
 
 }



if($notifupdate == 'yes'){
 $updatelog = "UPDATE formcuti SET alasan='".$alasan."', sudahisialasan='iya' WHERE nocuti='".$numbertelat."' ";    
}else{
 $updatelog = "INSERT INTO formcuti (nocuti, iduser, nama, unitusaha, departemen, bagian, cutipadatanggal, cutisampaitanggal, jumlahcutihari, keperluan, alasan, delegasikepada, iduserdelegasi, dibuatpadatgl, dibuatpadajam, ke1, menyetujuidelegasi, menyetujuiatasan, mengetahuihcs, sudahisialasan) VALUE ('".$nocutinya."', '".$IUser."', '".$nama."', '".$unitusaha."', '".$departemen."', '".$divisi."', '".$tglcuti."', '".$tglmasukkerja."', '".$jumlahhari."', '".$keperluan."', '".$alasan."', '".$namauserdelegasi."', '".$iduserdelegasi."', '".$dibuatpadatgl."', '".$jam."', '".$keatasan."', '".$menyetujuidelegasi."', '".$menyetujuiatasan."',  '".$mengetahuihcs."',  '".$sudahisialasan."')";     
$isikuotacuti = "INSERT INTO isikuotacuti (nocuti, iduser, tanggalcuti, grupcutiku, kuotacuti, datecreated, timecreated, status) VALUE ('".$nocutinya."', '".$IUser."', '".$tglcuti."', '".$grupcutiku."', '".$kuotagrupcuti."', '".$tanggal."', '".$jam."', '".$status."')";

}


 
 $querytambahuser =$conn->query($updatelog);

 $querytambahkuotacuti =$conn->query($isikuotacuti);

 
if ($querytambahuser === TRUE) {

if($notifupdate == 'yes'){
echo '<script>
	window.location.assign("index.php");
</script>' ;
}else{
echo '<script>
	window.location.assign("formcuti.php");
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