<?php 
include "config.php";
session_start();
$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;

 $string = "SELECT * FROM masteruser 
 WHERE id = '" .$iduser."';";
 $query =$conn->query($string);

   $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
   $iduser = $row['id'];
   $activity = "absensi luarkota android";


 $userid = $row['id'];
 $namae = $row['nama'];
 $departement = $row['departemen'];
 $bagian = $row['divisi'];  
 $company = $row['unitusaha'];  
 
 $ke = $row['ke'];  
 $ke2 = $row['ke2'];  
 $ke3 = $row['ke3'];  
 $ke4 = $row['ke4'];  
 $ke5 = $row['ke5']; 
 
 $lokja = $row['lokasikerja']; 

 $kota = $row['kota'];
 $status = $_POST['status'];  
 $latitude = $_POST['latitude'];  
 $longitude = $_POST['longitude'];  
 $noabsensi = $_POST['noabsensi'];
 $gambar = $_POST['gambar'];
 
 $gambar = str_replace("data:image/png;base64,","", $gambar);
 $nik = $row['nik'];

 $tanggal = date('Y-m-d');
 $jam = date('h:i:s');
 $sudahbaca = "";
 
 
 $ambilnofeed = "SELECT * FROM absenluarkota WHERE iduser = '" .$userid. "' ORDER BY idabsen DESC LIMIT 1 ;";
   $queryambilnofeed =$conn->query($ambilnofeed);
  
  
  if($queryambilnofeed->num_rows){
      
    $rowambilnofeed = mysqli_fetch_array($queryambilnofeed, MYSQLI_ASSOC);
     $nofeed = $rowambilnofeed['noabsensi'];
 
 $pecah = explode("/", $nofeed);
$hasil = $pecah[1] + 1;
$noabsensi = $userid."/".$hasil;  

      
  }else{
    $satu = "1";
   //echo " gak dapat nomer ";
   $noabsensi = $userid."/".$satu;
  }





$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://dev.virtualearth.net/REST/v1/Locations/'.$latitude.','.$longitude.'?o=json&key=AvsGNjpxWM3VpNnudig6vvSsJmLoJzeATUjAMR6j3yCKUBaE5PBFJ3R5ZsxUpEYc',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);

$data = json_decode($response, true);
 $adminDistrict = $data['resourceSets'][0]['resources'][0]['address']['adminDistrict'];

 $adminDistrict2 = $data['resourceSets'][0]['resources'][0]['address']['adminDistrict2'];

 $locality = $data['resourceSets'][0]['resources'][0]['address']['locality'];

 $countryRegion = $data['resourceSets'][0]['resources'][0]['address']['countryRegion'];

	$jsonlocate = array(
	   'locality' => $locality,
       'adminDistrict2' => $adminDistrict2,
       'adminDistrict' => $adminDistrict,
       'countryRegion' => $countryRegion,
       );

    $jsonlocate = json_encode($jsonlocate);    
   		 
$file_name = $_FILES['file']['name'];
if (strpos($file_name, '%') !== false) {
   $namfile = str_replace('%', '', $file_name);
   $file_name = $namfile;
}
				$filenamebaru = date('dmYHi').$file_name;
				$tmp_name = $_FILES['file']['tmp_name'];	
				$data = base64_encode($tmp_name);
		$target_dir = "../img/".$userid."/";
      $target_file = $target_dir . basename($_FILES["file"]["name"]);	
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if($imageFileType != "php" && $imageFileType != "html" && $imageFileType != "js") {
  
     if(!empty($file_name)){
  // 	move_uploaded_file($tmp_name, "../img/".$userid."/".$filenamebaru);
		/*		mysqli_query($conn,"INSERT INTO upgam VALUE('', '".$file_name."')"); */


 $inserteabsensi = "INSERT INTO absenluarkota (iduser, noabsensi, sudahbaca, nama, departement, bagian, nik, company, status, latitude, longitude, alamat, gambar, ke, ke2, ke3, ke4, ke5, lokasikerja, tglsubmit, jamsubmit, note, kota) VALUE ('".$userid."', '".$noabsensi."', '".$sudahbaca."', '".$namae."', '".$departement."', '".$bagian."', '".$nik."', '".$company."', '".$status."',  '".$latitude."',  '".$longitude."', '".$jsonlocate."', '".$gambar."', '".$ke."', '".$ke2."', '".$ke3."', '".$ke4."', '".$ke5."', '".$lokja."', '".$tanggal."', '".$jam."', '".$note."', '".$kota."')"; 
	$queryinsertabsensi = mysqli_query($conn, $inserteabsensi); 
				 				 
   
				 
echo '<script>
	alert("Berhasil Absen Luar Kota ");
	window.location.assign("darabsenluarkota.php"); 
</script>' ;

     }
     else{
     
     echo $data;    
         
     }
}
else{
    
    echo '<script>
	alert("Tidak boleh php");
</script>' ;
    
}



?>