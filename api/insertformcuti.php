<?php 
include "../config.php";

   
date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');
$jam = date('h:i:s');

$IUser = $_POST['iduser'];
$nama = $_POST['nama'];
$unitusaha = $_POST['unitusaha'];
$departemen = $_POST['departement'];
$divisi = $_POST['divisi'];
$tglcuti = $_POST['tglcuti'];
$cutisampaitanggal = $_POST['cutisampaitanggal'];
$alasan = $_POST['alasan'];
$keatasan = $_POST['keatasan'];
$keperluan = $_POST['keperluan'];
$delegasikepada = $_POST['delegasikepada'];
$jumlahcutihari = $_POST['jumlahcutihari'];

$terlambatke = "-";
$ijintertulisatasan = "-";
$dibuatpadatgl = date('Y-m-d');
$menyetujuiatasan = "Belum";
$mengetahuihcs = "Belum";

 $stringmasteruser = "SELECT * FROM masteruser 
 WHERE id = '" .$IUser . "';";
 $querynama =$conn->query($stringmasteruser);

 $rowmasteruser = mysqli_fetch_array($querynama, MYSQLI_ASSOC);
 
 $namanya = $rowmasteruser['nama'];

 if($nama == $namanya){
     $sama = 'ya';
 }
 

if(empty($IUser) || empty($nama) || $sama != 'ya'){
$json = array(
       'result' => 'iduser and nama is empty!',
       'item' => $item
       );
       
echo json_encode($json); 
return false;
}else{

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
    $satu = "1";
   $nocutinya = $IUser."/".$satu;
 }




 $updatelog = "INSERT INTO formcuti (nocuti, iduser, nama, unitusaha, departemen, bagian, cutipadatanggal, cutisampaitanggal, jumlahcutihari, alasan, keperluan, dibuatpadatgl, dibuatpadajam, delegasikepada, ke1, menyetujuiatasan, mengetahuihcs, sudahisialasan) VALUE ('".$nocutinya."', '".$IUser."', '".$nama."', '".$unitusaha."', '".$departemen."', '".$divisi."', '".$tglcuti."', '".$cutisampaitanggal."', '".$jumlahcutihari."', '".$alasan."','".$keperluan."', '".$dibuatpadatgl."', '".$jam."', '".$delegasikepada."',  '".$keatasan."', '".$menyetujuiatasan."',  '".$mengetahuihcs."', 'iya')"; 
 $querytambahuser =$conn->query($updatelog);

 
 
if ($querytambahuser === TRUE) {
				 
	$json = array(
       'result' => 'success'

       );
       
    echo json_encode($json);    
   		 
				 
}


}

?>