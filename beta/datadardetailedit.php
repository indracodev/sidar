<?php
session_start();
//$IUser = $_SESSION["IUser"];
// Load file koneksi.php
include "config.php";
// Ambil Data yang Dikirim dari Form
//$tgl = $_POST['tgl'];
//$jam = $_POST['jam'];
$IUser = $_POST['iduser'];
//$KEuser = $_POST['keuser'];
//$activityfirst = $_POST['activity'];
//$planningfirst = $_POST['planning'];
//$resultfirst = $_POST['result'];
//$activity = addslashes($activityfirst);
//$planning = addslashes($planningfirst);
//$result = addslashes($resultfirst);

//$tags = $_POST['tags'];
//$foto = $_FILES['foto']['name'];
//$tmp = $_FILES['foto']['tmp_name'];

$tanggaldar = $_POST['tanggaldar'];

$pecahtgldar = explode("-", $tanggaldar);
$haritgl = $pecahtgldar[0];
$bulantgl = $pecahtgldar[1];
$tahuntgl = $pecahtgldar[2];
$tgldarnya = $tahuntgl."-".$bulantgl."-".$haritgl;

/*
$jabatan =  $_SESSION["Jabatan"];

$IUser =  $_SESSION["IDUser"];
$KEuser = $_SESSION["Ke"];
$KEuser2 = $_SESSION["Ke2"];
$KEuser3 = $_SESSION["Ke3"];
$KEuser4 = $_SESSION["Ke4"];
$KEuser5 = $_SESSION["Ke5"];
*/

//$KEuser = $_POST["keuser"];
//$KEuser2 = $_POST["kedua"];
//$KEuser3 = $_POST["ketiga"];
//$KEuser4 = $_POST["keempat"];
//$KEuser5 = $_POST["kelima"];
//$jabatan =  $_POST["jabatan"];


/*
$jabatan = $_COOKIE["Jabatan"];

$IUser =  $_COOKIE["IDUser"];
$KEuser = $_COOKIE["Ke"];

$KEuser2 = $_COOKIE["Ke2"];
$KEuser3 = $_COOKIE["Ke3"];
$KEuser4 = $_COOKIE["Ke4"];
$KEuser5 = $_COOKIE["Ke5"];
*/
$duser = $_POST['iduser'];
$Nodar = $_POST['nodar'];
$iddetdar = $_POST['iddetdar'];
$explaination = $_POST['explaination'];
$explainationd = $_POST['explanationd'];
$result = $_POST['result'];
$idtodo = $_POST['idtodo'];

/*
$parsingnodar = $_SESSION["Nodar"];
$pecah = explode("/", $parsingnodar);
$hasil = $pecah[1];
echo $hasil;
*/


/*
$ambilattach = "SELECT * FROM draftgambar WHERE iduser = '" .$IUser . "';";
$queryattach =$conn->query($ambilattach);
$arrayrattach = mysqli_fetch_all($queryattach, MYSQLI_ASSOC);
*/
    

$updateddar .= "UPDATE draftddar SET result='".$result."', explaination='".$explainationd."' WHERE iddetdar='".$iddetdar."' ";

$updatetodo .= "UPDATE todo SET result='".$result."' WHERE idtodo='".$idtodo."' ";

 

if ($conn->query($updateddar) === TRUE) {
if ($conn->query($updatetodo) === TRUE) {

echo '<script>
//	alert(" Dar Berhasil Diupdate ");
	window.location.assign("newdar.php");
</script>' ;

}
} 
else{
}


/*
$ambilstatustanggaldar = "SELECT * FROM dar 
   WHERE iduser = '" .$iduser. "' ORDER BY tanggaldar DESC;";
   $queryambilstatustanggaldar =$conn->query($ambilstatustanggaldar);
 if($queryambilstatustanggaldar->num_rows){
  
 $rowambilstatustanggaldar = mysqli_fetch_array($queryambilstatustanggaldar, MYSQLI_ASSOC);
 $statustanggaldar = $rowambilstatustanggaldar['tanggaldar'];
 


 }else{
    // header("location: http://www.icg.id/beta/dar/login");
    $status = "ontime";
 //  echo " gak dapat tanggaldar ";
 }

*/

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
 */
 
 


?>