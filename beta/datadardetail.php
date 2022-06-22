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
 
 
 if ($_POST['tbdar'] == 'adddar') {
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
    
$query .= "INSERT INTO draftddar (nodar, iddetdar, iduser, target, activity, result, explaination) VALUES ('".$Nodar."', '".$iddetdar."','".$IUser."', '".$target."', '".$activity."', '".$result."', '".$explaination."')";  
			
 

if ($conn->query($query) === TRUE) {
    
/*
$kosongdraft .= "UPDATE draft SET activity='', result='', plan='', tag='' WHERE iduser='".$IUser."' ";
    
if ($conn->query($kosongdraft) === TRUE) {
    

}

*/

//$sudahkirim .= "UPDATE masteruser SET sudahkirim='sudah' WHERE id='".$IUser."' ";
    
    
if($perbedaan == 0){    
//if ($conn->query($sudahkirim) === TRUE) {
    
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