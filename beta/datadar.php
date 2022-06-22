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

$KEuser = $_POST["keuser"];
$KEuser2 = $_POST["kedua"];
$KEuser3 = $_POST["ketiga"];
$KEuser4 = $_POST["keempat"];
$KEuser5 = $_POST["kelima"];
$jabatan =  $_POST["jabatan"];


/*
$jabatan = $_COOKIE["Jabatan"];

$IUser =  $_COOKIE["IDUser"];
$KEuser = $_COOKIE["Ke"];

$KEuser2 = $_COOKIE["Ke2"];
$KEuser3 = $_COOKIE["Ke3"];
$KEuser4 = $_COOKIE["Ke4"];
$KEuser5 = $_COOKIE["Ke5"];
*/

$Nodar = $_POST['nodar'];

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
    
date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');
$tanggaldate = date('d-m-Y');
$jam = date('H:i:s');


$tanggal1 = new DateTime($tanggaldar);
$tanggal2 = new DateTime($tanggaldate);
$tanggaldiff = date_diff($tanggal1,$tanggal2);
$perbedaan = $tanggaldiff->format("%a%");
 
 
if($jabatan == "staff" && $perbedaan == 0){
$timemalam = "23:59:00";
$timetujuh = "09:01:00";
$ThatTime ="19:00:00";


$late2start = "00:01:00";
$late2end = "16:00:00";

if ($jabatan == "staff" && date('H:i:s') <= date('H:i:s', strtotime($ThatTime))) {
  $status = "ontime";

} elseif($jabatan == "staff" &&  date('H:i:s') <= date('H:i:s', strtotime($timemalam)) && date('H:i:s') > date('H:i:s', strtotime($ThatTime)) ){
     $status = "late1";
} 
}

if($jabatan == "staff" && $perbedaan == 1){
$timemalam = "23:59:00";
$timetujuh = "09:01:00";
$ThatTime ="19:00:00";


$late2start = "00:01:00";
$late2end = "16:00:00";

if($jabatan == "staff" &&  $perbedaan == 1 && date('H:i:s') <= date('H:i:s', strtotime($late2end)) && date('H:i:s') > date('H:i:s', strtotime($late2start)) ){
     $status = "late2";
}
elseif($jabatan == "staff" &&  $perbedaan == 1 && date('H:i:s') > date('H:i:s', strtotime($late2end)) && date('H:i:s') > date('H:i:s', strtotime($late2start)) ){
     $status = "over";
}

}

if($jabatan == "staff" && $perbedaan > 1) {
  $status = "over";
    
}else{
    
}


 
if($jabatan == "supervisor" && $perbedaan == 0){
$timemalam = "23:59:00";
$timedelapan = "20:01:00";
$late2endmn = "16:00:00";
$ThatTimes ="20:00:00";
if ($jabatan == "supervisor" && date('H:i:s') <= date('H:i:s', strtotime($ThatTimes))) {
  $status = "ontime";
  
} elseif($jabatan == "supervisor" &&  date('H:i:s') <= date('H:i:s', strtotime($timemalam)) && date('H:i:s') > date('H:i:s', strtotime($ThatTimes)) ){
     $status = "late1";
} 

}

if($jabatan == "supervisor" && $perbedaan == 1){
$timemalam = "23:59:00";
$timedelapan = "20:01:00";
$late2endmn = "16:00:00";
$ThatTimes ="20:00:00";
if($jabatan == "supervisor" && date('H:i:s') <= date('H:i:s', strtotime($late2endmn)))  {
  $status = "late2";
    
}elseif($jabatan == "supervisor" && date('H:i:s') > date('H:i:s', strtotime($late2endmn)) ){
     $status = "over";
}
}


if($jabatan == "supervisor" && $perbedaan > 1) {
  $status = "over";
    
}else{
    
}


 
if($perbedaan == 0 && $jabatan == "manager" || $jabatan == "rspm" || $jabatan == "RSPM" || $jabatan == "NOM" || $jabatan == "NPM"){
$timesembilan = "23:01:00";    
$timemalama = "22:00:00";
$ThatTimema ="16:00:00";
$zxz = "ifmanager";

$late2startm = "00:01:00";
$late2endm = "16:00:00";

if ($perbedaan == 0 && date('H:i:s') <= date('H:i:s', strtotime($timemalama)) && $jabatan == "manager" || $jabatan == "rspm" || $jabatan == "RSPM" || $jabatan == "NOM" || $jabatan == "NPM") {
  $status = "ontime";

 }elseif($perbedaan == 0 && date('H:i:s') > date('H:i:s', strtotime($timemalama)) && date('H:i:s') > date('H:i:s', strtotime($ThatTimema)) && $jabatan == "manager" || $jabatan == "rspm" || $jabatan == "RSPM" || $jabatan == "NOM" || $jabatan == "NPM"){
     $status = "late1";
} 

}


if($perbedaan == 1 && $jabatan == "manager" || $jabatan == "rspm" || $jabatan == "RSPM" || $jabatan == "NOM" || $jabatan == "NPM"){
$timesembilan = "23:01:00";    
$timemalama = "22:00:00";
$ThatTimema ="16:00:00";
$zxz = "ifmanager";

$late2startm = "00:01:00";
$late2endm = "16:00:00";

if($perbedaan == 1 && date('H:i:s') < date('H:i:s', strtotime($late2endm)) && $jabatan == "manager" || $jabatan == "rspm" || $jabatan == "RSPM" ||  $jabatan == "NOM" || $jabatan == "NPM" ) {
  $status = "late2";
    
}

elseif($perbedaan == 1 && date('H:i:s') > date('H:i:s', strtotime($late2endm)) && $jabatan == "manager" || $jabatan == "rspm" || $jabatan == "RSPM" || $jabatan == "NOM" || $jabatan == "NPM") {
  $status = "over";

}

}



if($perbedaan > 1 && $jabatan == "manager" || $jabatan == "rspm" || $jabatan == "RSPM" || $jabatan == "NOM" || $jabatan == "NPM") {
  $status = "over";

}else{
    
}




if($perbedaan == 0 && $jabatan == "direktur" || $jabatan == "DIREKTUR"){
$timesembilan = "23:01:00";    
$timemalam = "23:59:00";
$ThatTimem ="23:59:50";

$late2end = "16:00:00";

if ($jabatan == "direktur" || $jabatan == "DIREKTUR" && date('H:i:s') <= date('H:i:s', strtotime($ThatTimem))) {
  $status = "ontime";

} elseif($jabatan == "direktur" || $jabatan == "DIREKTUR" &&  date('H:i:s') <= date('H:i:s', strtotime($timemalam)) && date('H:i:s') > date('H:i:s', strtotime($ThatTimem)) ){
     $status = "ontime";
} 

    
}

if($perbedaan == 1 && $jabatan == "direktur" || $jabatan == "DIREKTUR"){
$timesembilan = "23:01:00";    
$timemalam = "23:59:00";
$ThatTimem ="23:59:50";

$late2end = "16:00:00";

if($perbedaan == 1 && date('H:i:s') < date('H:i:s', strtotime($late2end)) && $jabatan == "direktur" || $jabatan == "DIREKTUR" && date('H:i:s') <= date('H:i:s', strtotime($late2end))) {
  $status = "late2";
    
}

elseif($perbedaan == 1 && date('H:i:s') > date('H:i:s', strtotime($late2end)) && $jabatan == "direktur" || $jabatan == "DIREKTUR"   && date('H:i:s') >= date('H:i:s', strtotime($late2end))) {
  $status = "over";

}

    
}


if($perbedaan > 1 && $jabatan == "direktur" || $jabatan == "DIREKTUR"   && date('H:i:s') >= date('H:i:s', strtotime($late2end))) {
  $status = "over";

}else{
    
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
 
 
 
$infoexplain = "SELECT * FROM draftddar WHERE iduser='".$IUser."' ";
$queryexplain = $conn->query($infoexplain);
$arrayexplain = mysqli_fetch_all($queryexplain, MYSQLI_ASSOC);

$jumlahexplan = 0;
  for($x = 0; $x < sizeof($arrayexplain); $x++){
                     
        if(empty($arrayexplain[$x]["explaination"])){
                         
        $jumlahexplan = $jumlahexplan + 1; 
        }else{
      
        }
}
 
if($jumlahexplan == 0){
    
 
 if ($_POST['btdar'] == 'kirimdar') {
    //action for update here
    /*
        for($x = 0; $x < sizeof($arrayrattach); $x++){
            $filenamaimg = $arrayrattach[$x]["gambar"] ;
              	$queryupdrafttoimg = "INSERT INTO masterattach (nodar, gambar, iduser) VALUE ('".$Nodar."', '".$filenamaimg."', '".$IUser."')"; 
				 $sqlupimg = mysqli_query($conn, $queryupdrafttoimg); 
        }
        
        $sqldeldraftimg = "DELETE FROM draftgambar WHERE iduser='".$IUser."' ";
        mysqli_query($conn, $sqldeldraftimg); 
    
    	$jumlah = count($_FILES['gambar']['name']);
    	*/
    	
    	/*
    	
		if ($jumlah > 0) {
			for ($i=0; $i < $jumlah; $i++) { 
				$file_name = $_FILES['gambar']['name'][$i];
				$filenamebaru = date('dmYHi').$file_name;
				$tmp_name = $_FILES['gambar']['tmp_name'][$i];			
		$target_dir = "img/".$IUser."/";
      $target_file = $target_dir . basename($_FILES["gambar"]["name"][$i]);	
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
if($imageFileType != "php" && $imageFileType != "html" && $imageFileType != "js") {
    
     if(!empty($file_name)){
   	move_uploaded_file($tmp_name, "img/".$IUser."/".$filenamebaru);
		//		mysqli_query($conn,"INSERT INTO upgam VALUE('', '".$file_name."')"); 
				$queryupimg = "INSERT INTO masterattach (nodar, gambar, iduser) VALUE ('".$Nodar."', '".$filenamebaru."', '".$IUser."')"; 
				 $sqlup = mysqli_query($conn, $queryupimg); 
     }
     else{
         
     }
     
}else{
    
    echo '<script>
	alert("Tidak boleh php");
</script>' ;
    
}
			
			}
		}
		
		*/
/*				 
  if($sqlup){ // Cek jika proses simpan ke database sukses atau tidak
    // Jika Sukses, Lakukan :
 //   header("location: https://www.supresso.com/up/upload.php"); // Redirect ke halaman index.php
  }else{
    // Jika Gagal, Lakukan :
echo $file_name; 
// echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan nama gambar ke database";
  }
*/


$sudahbaca;    
    
$query .= "INSERT INTO hdar (nodar ,iduser, ke, ke2, ke3, ke4, ke5, status, tanggal, jam, tanggaldar, sudahbaca) VALUES ('".$Nodar."', '".$IUser."', '".$KEuser."', '".$KEuser2."', '".$KEuser3."', '".$KEuser4."', '".$KEuser5."', '".$status."', '".$tanggal."', '".$jam."', '".$tgldarnya."', '".$sudahbaca."')";  
			
 

if ($conn->query($query) === TRUE) {
    
/*
$kosongdraft .= "UPDATE draft SET activity='', result='', plan='', tag='' WHERE iduser='".$IUser."' ";
    
if ($conn->query($kosongdraft) === TRUE) {
    

}

*/



$sudahkirim .= "UPDATE masteruser SET sudahkirim='sudah' WHERE id='".$IUser."' ";

$copyddar .="INSERT INTO ddar (nodar, iddetdar, iduser, target, activity, result, date, duedate, explaination)
SELECT nodar, iddetdar, iduser, target, activity, result, date, duedate, explaination FROM draftddar WHERE iduser = '".$IUser."';";    

$copyddarattach .="INSERT INTO ddarattach (iddetdar, img, iduser)
SELECT iddetdar, img, iduser FROM draftattach WHERE iduser = '".$IUser."';";   

$deletddar .= "DELETE FROM draftddar WHERE iduser='".$IUser."';";
    
if ($conn->query($copyddar) === TRUE) {
if ($conn->query($copyddarattach) === TRUE) {    
if ($conn->query($deletddar) === TRUE) {
    
echo '<script>
	alert(" DAR Berhasil Dikirimm ");
	window.location.assign("report.php"); 
</script>' ;
}
}
}    
    
if($perbedaan == 0){    
if ($conn->query($sudahkirim) === TRUE) {



echo '<script>
	alert(" DAR Berhasil Dikirim ");
//	window.location.assign("report.php"); 
</script>' ;

    
}
}else{
    echo '<script>
	alert(" DAR Berhasil Dikirim ");
//	window.location.assign("report.php");
</script>' ;
}


} else{
    // Jika Gagal, Lakukan :
   echo date('H:i:s', strtotime($ThatTime));
     echo "<br>";
  echo $status;
  echo "<br>";
  echo $jabatan;
  echo "<br>";
  echo $KEuser;
  echo "<br>";
  echo $KEuser2;
  echo "<br>";
  echo $KEuser3;
  echo "<br>";
  echo $KEuser4;
  echo "<br>";
  echo $KEuser5;
  echo "<br>";
  echo $perbedaan;
  echo "<br>";
  echo $IUser; 
  echo "<br>";
  echo $KEuser;
  echo "<br>";
  echo $status;
  echo "<br>";
  echo $tgldarnya;
  echo "<br>";
  echo $tanggal;
  echo "<br>";
  echo $jam;
  echo "<br>";
  echo $planning;
  echo "<br>";
  echo $activity;
  echo "<br>";
  echo $result;
  echo "<br>";
  echo $tags;
  echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database";

//echo '<script>
//	alert(" Gagal Mengirim DAR ");
//	window.location.assign("index.php");
//</script>' ;


  }
  

    
    
} 

/*
else if ($_POST['btdraft'] == 'savedraft') {
    //action for delete
    
    
    
    	$jumlah = count($_FILES['gambar']['name']);
		if ($jumlah > 0) {
			for ($i=0; $i < $jumlah; $i++) { 
				$file_name = $_FILES['gambar']['name'][$i];
				$filenamebaru = date('dmYHi').$file_name;
				$tmp_name = $_FILES['gambar']['tmp_name'][$i];			
		$target_dir = "img/".$IUser."/";
      $target_file = $target_dir . basename($_FILES["gambar"]["name"][$i]);	
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
if($imageFileType != "php" && $imageFileType != "html" && $imageFileType != "js" ) {
    
     if(!empty($file_name)){
   	move_uploaded_file($tmp_name, "img/".$IUser."/".$filenamebaru);
   	*/
		/*		mysqli_query($conn,"INSERT INTO upgam VALUE('', '".$file_name."')"); */
		
		/*
		
				$queryupimg = "INSERT INTO draftgambar (nodar, gambar, iduser) VALUE ('".$Nodar."', '".$filenamebaru."', '".$IUser."')"; 
				 $sqlup = mysqli_query($conn, $queryupimg); 
     }
     else{
         
     }
     
}else{
    
    echo '<script>
	alert("Draft Tidak boleh php");
</script>' ;
    
}
			
			}
	
    
		}
    
    
$savedraft .= "UPDATE draft SET activity='".$activity."', result='".$result."', plan='".$planning."', tag='".$tags."' WHERE iduser='".$IUser."' ";


 

if ($conn->query($savedraft) === TRUE) {
echo '<script>
	alert(" Draft Berhasil Disimpan ");
	window.location.assign("dar.php");
</script>' ;
} 
else{
    
    */
    
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

/*

echo '<script>
	alert(" Gagal Menyimpan Draft ");
	window.location.assign("index.php");
</script>' ;


  }
    
    
    
}

*/

/*
else if ($_POST['btdraftfoto'] == 'savedraftfoto') {
    //action for delete
$prosesupload = '';
echo $prosesupload ;    
    
    
    	$jumlah = count($_FILES['gambar']['name']);
		if ($jumlah > 0) {
			for ($i=0; $i < $jumlah; $i++) { 
				$file_name = $_FILES['gambar']['name'][$i];
				$filenamebaru = date('dmYHi').$file_name;
				$tmp_name = $_FILES['gambar']['tmp_name'][$i];			
		$target_dir = "img/".$IUser."/";
      $target_file = $target_dir . basename($_FILES["gambar"]["name"][$i]);	
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
if($imageFileType != "php" && $imageFileType != "html" && $imageFileType != "js" ) {
    
     if(!empty($file_name)){
   	move_uploaded_file($tmp_name, "img/".$IUser."/".$filenamebaru); */
		/*		mysqli_query($conn,"INSERT INTO upgam VALUE('', '".$file_name."')"); */
		
		/*
				$queryupimg = "INSERT INTO draftgambar (nodar, gambar, iduser) VALUE ('".$Nodar."', '".$filenamebaru."', '".$IUser."')"; 
				 $sqlup = mysqli_query($conn, $queryupimg); 
     }
     else{
         
     }
     
}else{
    
    echo '<script>
	alert("Draft Tidak boleh php");
</script>' ;
    
}
			
			}
	
    
		}
    
    
$savedraft .= "UPDATE draft SET activity='".$activity."', result='".$result."', plan='".$planning."', tag='".$tags."' WHERE iduser='".$IUser."' ";


 

if ($conn->query($savedraft) === TRUE) {
$prosesupload = '<script>
window.location.assign("dar.php");
</script>';  
echo $prosesupload ;
} 
else{
    */
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

/*
echo '<script>
	alert(" Gagal Menyimpan Draft ");
	window.location.assign("index.php");
</script>' ;


  }
    
    
    
}
*/
/*
else if ($_POST['btdraftlogout'] == 'savedraftlogout') {
    //action for delete
$prosesupload = '';
echo $prosesupload ;    
    
    
    	$jumlah = count($_FILES['gambar']['name']);
		if ($jumlah > 0) {
			for ($i=0; $i < $jumlah; $i++) { 
				$file_name = $_FILES['gambar']['name'][$i];
				$filenamebaru = date('dmYHi').$file_name;
				$tmp_name = $_FILES['gambar']['tmp_name'][$i];			
		$target_dir = "img/".$IUser."/";
      $target_file = $target_dir . basename($_FILES["gambar"]["name"][$i]);	
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
if($imageFileType != "php" && $imageFileType != "html" && $imageFileType != "js" ) {
    
     if(!empty($file_name)){
   	move_uploaded_file($tmp_name, "img/".$IUser."/".$filenamebaru); */
		/*		mysqli_query($conn,"INSERT INTO upgam VALUE('', '".$file_name."')"); */
		/*
				$queryupimg = "INSERT INTO draftgambar (nodar, gambar, iduser) VALUE ('".$Nodar."', '".$filenamebaru."', '".$IUser."')"; 
				 $sqlup = mysqli_query($conn, $queryupimg); 
     }
     else{
         
     }
     
}else{
    
    echo '<script>
	alert("Draft Tidak boleh php");
</script>' ;
    
}
			
			}
	
    
		}
    
    
$savedraft .= "UPDATE draft SET activity='".$activity."', result='".$result."', plan='".$planning."', tag='".$tags."' WHERE iduser='".$IUser."' ";

*/
 
/*
if ($conn->query($savedraft) === TRUE) {
$prosesupload = '<script>
window.location.assign("logoutt.php");
</script>';  
echo $prosesupload ;
} 
else{
    */
    
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
*//*
echo '<script>
	alert(" Gagal Menyimpan Draft ");
	window.location.assign("index.php");
</script>' ;


  }
    */
    
    
//}


/*
else if ($_POST['btnlibur'] == 'savelibur') {
    //action for delete
    
    
$query .= "INSERT INTO dar (nodar ,iduser, ke, ke2, ke3, ke4, ke5, status, tanggal, jam, plan ,activity, result, tag, tanggaldar, sudahbaca) VALUES ('".$Nodar."', '".$IUser."', '".$KEuser."', '".$KEuser2."', '".$KEuser3."', '".$KEuser4."', '".$KEuser5."', '".'Pending Absence'."', '".$tanggal."', '".$jam."', 'Tidak Masuk Kerja', 'Tidak Masuk Kerja',  'Tidak Masuk Kerja', '".$tags."', '".$tgldarnya."', '".$sudahbaca."')";  
			
 

if ($conn->query($query) === TRUE) {
    


$sudahkirim .= "UPDATE masteruser SET sudahkirim='sudah' WHERE id='".$IUser."' ";
    
    
if($perbedaan == 0){    
if ($conn->query($sudahkirim) === TRUE) {
    
echo '<script>
	alert(" DAR Berhasil Dikirim ");
	window.location.assign("report.php"); 
</script>' ;
}
}else{
    echo '<script>
	alert(" DAR Berhasil Dikirim ");
	window.location.assign("report.php");
</script>' ;
}


} else{
    // Jika Gagal, Lakukan :
   echo date('H:i:s', strtotime($ThatTime));
     echo "<br>";
  echo $status;
  echo "<br>";
  echo $jabatan;
  echo "<br>";
  echo $KEuser;
  echo "<br>";
  echo $KEuser2;
  echo "<br>";
  echo $KEuser3;
  echo "<br>";
  echo $KEuser4;
  echo "<br>";
  echo $KEuser5;
  echo "<br>";
  echo $perbedaan;
  echo "<br>";
  echo $IUser; 
  echo "<br>";
  echo $KEuser;
  echo "<br>";
  echo $status;
  echo "<br>";
  echo $tgldarnya;
  echo "<br>";
  echo $tanggal;
  echo "<br>";
  echo $jam;
  echo "<br>";
  echo $planning;
  echo "<br>";
  echo $activity;
  echo "<br>";
  echo $result;
  echo "<br>";
  echo $tags;
  echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database";

//echo '<script>
//	alert(" Gagal Mengirim DAR ");
//	window.location.assign("index.php");
//</script>' ;


  }

    
    
    
}
*/


else {
    //invalid action!
}


}
else {
  
     echo '<script>
	alert("Explanation Harus Di Isi");
	window.location.assign("newdar.php");
</script>' ;
    
}
 
/*
  $query = "UPDATE garansi SET iuserwp='$IUser',namatoko='$namatoko',namakota='$namakota',gambar='$fotobaru' where serialnumber='$serialnumber'";
  */
  
/*
  if($sql){ // Cek jika proses simpan ke database sukses atau tidak
    // Jika Sukses, Lakukan :
    header("location: http://www.icg.id/beta/dar/"); // Redirect ke halaman index.php
  }else{
    // Jika Gagal, Lakukan :
  echo $IUser; 
  echo $serialnumber;
  echo $namatoko;
  echo $namakota;
  echo $fotobaru;
  echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database";

  }
*/

/*
}

else{
  // Jika gambar gagal diupload, Lakukan :
  echo "Maaf, Gambar gagal untuk diupload.";
  echo $IUser; 
  echo "<br>";
  echo $serialnumber;
  echo $namatoko;
  echo $namakota;
  echo $fotobaru;
  echo "<br><a href='index.html'>Kembali Ke Form</a>";
} */

?>