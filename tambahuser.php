<?php
session_start();
//$IUser = $_SESSION["IUser"];
// Load file koneksi.php
include "config.php";
// Ambil Data yang Dikirim dari Form
//$tgl = $_POST['tgl'];
//$jam = $_POST['jam'];
$IUser = $_POST['iduser'];
$KEuser = $_POST['keuser'];
$activity = $_POST['activity'];
$planning = $_POST['planning'];
$result = $_POST['result'];
$tags = $_POST['tags'];
$foto = $_FILES['foto']['name'];
$tmp = $_FILES['foto']['tmp_name'];

$lokasikerja = $_POST['lokasikerja'];
$unitusaha = $_POST['unitusaha'];
$departemen = $_POST['departemen'];
$divisi = $_POST['divisi'];
$jabatan = $_POST['jabatan'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$notlp = $_POST['notlp'];
$kota = $_POST['kota'];
$nik = $_POST['nik'];

$username = strtolower($_POST['username']);
$password = strtolower($_POST['password']);

function encrypt_decrypt($action, $string)
{
  $output = false;
 
  $encrypt_method = "AES-256-CBC";
  $secret_key = 'osdkfje';
  $secret_iv = 'sdfvcdfeg';
 
  // hash
  $key = hash('sha256', $secret_key);
 
  // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a
  // warning
  $iv = substr(hash('sha256', $secret_iv), 0, 16);
 
  if ($action == 'encrypt')
  {
    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);
  }
  else
  {
    if ($action == 'decrypt')
    {
      $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
  }
 
  return $output;
}

$password = encrypt_decrypt('encrypt', $password);  

$ke = $_POST['ke'];
$ke2 = $_POST['ke2'];
$ke3 = $_POST['ke3'];
$ke4 = $_POST['ke4'];
$ke5 = $_POST['ke5'];
$sudahkirim = "belum";
$maxjam = "";
$urutan = "0";
$group = "belum set";
$pw = "-";
$dahupdatemail = "belum";
$perlunotif = "tidak";
$tokendevice = "-";
$izinabsenlk = "-";
$jumlahcuti = "0";
$grupcuti = "1";
$grupcutiku = "1";
$kuotagrupcuti = "3";

$status = "kosong";
$IUser =  $_COOKIE["IDUser"];
$KEuser = $_COOKIE["Ke"];

$Nodar = $_POST['nodar'];

if($jabatan == "staff"){
$level = "user";    
}else{
$level = "admin";    
    
}


/*
$parsingnodar = $_SESSION["Nodar"];
$pecah = explode("/", $parsingnodar);
$hasil = $pecah[1];
echo $hasil;
*/


    
date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');
$jam = date('h:i:s');

$string = "SELECT * FROM masteruser 
 WHERE masteruser.username = '" .$username . "';";
 
  $query =$conn->query($string);
 if($query->num_rows){
    echo '<script>
	alert("Gagal insert!!! Username sudah ada di database ");
		alert("Silakan cari username lain");
window.location.assign("addUser.php");
</script>' ;

$_SESSION['addusernama'] = $nama;
$_SESSION['adduserdepartement'] = $departemen;
$_SESSION['addusernik'] = $nik;
$_SESSION['adduseremail'] = $email;
$_SESSION['adduserunitusaha'] = $unitusaha;
$_SESSION['adduserjabatan'] = $jabatan;
$_SESSION['adduserkota'] = $kota;
$_SESSION['addusernotelp'] = $notlp;
$_SESSION['adduserbagian'] = $divisi;
$_SESSION['adduserlokasikerja'] = $lokasikerja;

$_SESSION['adduserke'] = $ke;
$_SESSION['adduserke2'] = $ke2;
$_SESSION['adduserke3'] = $ke3;
$_SESSION['adduserke4'] = $ke4;
$_SESSION['adduserke5'] = $ke5;

 exit();
     
 }

//$IUser = "1";
  
// Rename nama fotonya dengan menambahkan tanggal dan jam upload
$fotobaru = date('dmYHis').$foto;
// Set path folder tempat menyimpan fotonya
$path = "images/".$fotobaru;
// Proses upload
//if(move_uploaded_file($tmp, $path)){ // Cek apakah gambar berhasil diupload atau tidak
  // Proses simpan ke Database
  
/*  
$updateheaderplan = "INSERT INTO headerplan (id, ke, status, tanggal, jam) VALUE('".$IUser."', '".$KEuser."', '".$status."', '".$tanggal."', '".$jam."')"; 
$queryupdateheaderplan =$conn->query($updateheaderplan);
 
$updateheaderactivity = "INSERT INTO headeractivity (id, ke, status, tanggal, jam) VALUE ('".$IUser."', '".$KEuser."', '".$status."', '".$tanggal."', '".$jam."')"; 
$queryupdateheaderactivity =$conn->query($updateheaderactivity);



$updatedetailplan = "INSERT INTO detailplan (plan, tag) VALUE ('".$planning."', '".$tags."')"; 
$queryupdatedetailplan =$conn->query($updatedetailplan);
 
$updatedetailactivity = "INSERT INTO detailactivity (activity, tag) VALUE ('".$activity."', '".$tags."')"; 
$queryupdatedetailactivity =$conn->query($updatedetailactivity);

 
 $tambahuser = "INSERT INTO masteruser (nama, username, password, email, notlp, unitusaha, departemen, divisi, kota, sudahkirim, level, ke, ke2, ke3, ke4, ke5, maxjam) VALUE ('".$nama."', '".$username."', '".$password."', '".$email."', '".$notlp."', '".$unitusaha."', '".$departemen."', '".$divisi."', '".$kota."', '".$sudahkirim."', '".$level."', '".$ke."', '".$ke2."', '".$ke3."', '".$ke4."', '".$ke5."', '".$maxjam."')";
 */


 $updatelog = "INSERT INTO masteruser (ke, ke2, ke3, ke4, ke5, username, password, nama, unitusaha, departemen, divisi, jabatan, level, email, notlp, kota, sudahkirim, urutan, lokasikerja, grup, pw, nik, dahupdatemail, tokendevice, perlunotif, izinabsenlk, jumlahcuti, grupcuti, kuotagrupcuti, grupcutiku) VALUE ('".$ke."', '".$ke2."', '".$ke3."', '".$ke4."', '".$ke5."', '".$username."', '".$password."', '".$nama."', '".$unitusaha."', '".$departemen."', '".$divisi."', '".$jabatan."', '".$level."', '".$email."', '".$notlp."','".$kota."', '".$sudahkirim."', '".$urutan."', '".$lokasikerja."',  '".$group."', '".$pw."', '".$nik."', '".$dahupdatemail."', '".$tokendevice."', '".$perlunotif."', '".$izinabsenlk."', '".$jumlahcuti."', '".$grupcuti."', '".$kuotagrupcuti."', '".$grupcutiku."')"; 
 //  $queryupdatelog =$conn->query($updatelog);
 $querytambahuser =$conn->query($updatelog);

 
 
if ($querytambahuser === TRUE) {

     
$_SESSION['addusernama'] = '';
$_SESSION['adduserdepartement'] = '';
$_SESSION['addusernik'] = '';
$_SESSION['adduseremail'] = '';
$_SESSION['adduserunitusaha'] = '';
$_SESSION['adduserjabatan'] = '';
$_SESSION['adduserkota'] = '';
$_SESSION['addusernotelp'] = '';
$_SESSION['adduserlokasikerja'] = '';

$_SESSION['adduserke'] = '';
$_SESSION['adduserke2'] = '';
$_SESSION['adduserke3'] = '';
$_SESSION['adduserke4'] = '';
$_SESSION['adduserke5'] = '';
    
echo '<script>
	window.location.assign("img/createfolder.php");
</script>' ;
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
	alert(" User Gagal Ditambah ");
//window.location.assign("index.php");
</script>' ;

  }
    
 
?>