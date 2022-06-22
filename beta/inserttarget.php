<?php
session_start();
//$iduser = $_SESSION["IDUser"];

include "config.php";

$IUser = $_POST['iduser'];
$target = $_POST['target'];

$pecahtgl = explode("-", $tgl);
$pecahduetgl = explode("-", $duetgl);

$haritgl = $pecahtgl[0];
$bulantgl = $pecahtgl[1];
$tahuntgl = $pecahtgl[2];

$hariduetgl = $pecahduetgl[0];
$bulanduetgl = $pecahduetgl[1];
$tahunduetgl = $pecahduetgl[2];

//$tanggaldate = $tahuntgl.'-'.$bulantgl.'-'.$haritgl;
//$tanggalduedate = $tahuntgl.'-'.$bulantgl.'-'.$haritgl;

$tanggaldate = $tgl;
$tanggalduedate = $duetgl;


$result = 'process';


/*
$parsingnodar = $_SESSION["Nodar"];
$pecah = explode("/", $parsingnodar);
$hasil = $pecah[1];
echo $hasil;
*/


    
date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');
$jam = date('h:i:s');

//$IUser = "1";
  
// Rename nama fotonya dengan menambahkan tanggal dan jam upload
//$fotobaru = date('dmYHis').$foto;
// Set path folder tempat menyimpan fotonya
//$path = "images/".$fotobaru;
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


 $updatelog = "INSERT INTO mastertarget (iduser, namatarget, result) VALUE ('".$IUser."', '".$target."', '')"; 
 //  $queryupdatelog =$conn->query($updatelog);
 $querytambahtodo =$conn->query($updatelog);

 $updatetodo = "INSERT INTO todo (iduser, target, todo, result, date, duedate, datecreated, tampil) VALUE ('".$IUser."', '".$target."', '', '', '".$tanggal."', '".$tanggal."', '".$tanggal."', 'tidak')"; 
 //  $queryupdatelog =$conn->query($updatelog);
 $querytambahtododo =$conn->query($updatetodo);

 
 
if ($querytambahtodo === TRUE) {

     echo '<script>
	//alert("Berhasil insert ");
window.location.assign("todo.php");
</script>' ;
    

} 
else{
echo $IUser; 
echo "<br>";
echo $target;
echo "<br>";
echo $todo;
echo "<br>";
echo $result;
echo "<br>";
echo $tanggaldate;
echo "<br>";
echo $tanggalduedate;
echo "<br>";
echo $tanggal;
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
echo '<script>
	alert(" User Gagal Ditambah ");
window.location.assign("index.php");
</script>' ;

  }
    
 
?>