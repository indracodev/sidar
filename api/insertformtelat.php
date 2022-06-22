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
$tgltelat = $_POST['tgltelat'];
$timetelat = $_POST['timetelat'];
$alasan = $_POST['alasan'];
$keatasan = $_POST['keatasan'];

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
    $satu = "1";
   $notelatnya = $IUser."/".$satu;
 }




 $updatelog = "INSERT INTO formtelat (notelat, iduser, nama, unitusaha, departemen, bagian, telatpadatanggal, masukjam, terlambatke, alasan, ijintertulisatasan, dibuatpadatgl, ke1, menyetujuiatasan, mengetahuihcs, sudahisialasan) VALUE ('".$notelatnya."', '".$IUser."', '".$nama."', '".$unitusaha."', '".$departemen."', '".$divisi."', '".$tgltelat."', '".$timetelat."', '".$terlambatke."', '".$alasan."','".$ijintertulisatasan."', '".$dibuatpadatgl."', '".$keatasan."', '".$menyetujuiatasan."',  '".$mengetahuihcs."', 'iya')"; 
 $querytambahuser =$conn->query($updatelog);

 
 
if ($querytambahuser === TRUE) {
				 
	$json = array(
       'result' => 'success'

       );
       
    echo json_encode($json);    
   		 
				 
}


}

?>