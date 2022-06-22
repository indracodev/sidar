<?php 
include "../config.php";
session_start();

  if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else{
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    
$useragent = $_SERVER['HTTP_USER_AGENT'];

date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');
$jam = date('h:i:s');
$alamat = $_POST['alamat']; 
 $status = $_POST['status'];  
 $latitude = $_POST['latitude'];  
 $longitude = $_POST['longitude'];  
 $gambar = $_POST['gambar']; 
 $noabsensi = $_POST['noabsensi'];
 $file = $_POST['file'];
 $tanggal = $_POST['tanggal'];
 $jam = $_POST['jam'];
 $note = $_POST['note'];
 $sudahbaca = "";
 
 if(empty($tanggal)){
     $tanggal = date('Y-m-d');
 }
 
 if(empty($jam)){
     $jam = date('h:i:s');
 }
   
if(empty($_POST['username'])){
$json = array(
       'result' => 'UserName is empty!',
       'item' => $item
       );
       
echo json_encode($json); 
return false;
}

elseif (empty($_POST['password'])){
$json = array(
       'result' => 'Password is empty!',
       'item' => $item
       );
       
echo json_encode($json); 
return false;
}

else{
 $username = addslashes(strtolower($_POST['username']));
 $password = addslashes(strtolower($_POST['password']));


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
 
 $string = "SELECT * FROM masteruser 
 WHERE masteruser.username = '" .$username . "' AND masteruser.password = '" .$password."';";
 $query =$conn->query($string);
 
 if($query->num_rows){
     
   $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
   $iduser = $row['id'];
   $activity = "absensi luarkota android";

 $userid = $row['id'];
 $namae = $row['nama'];
 $departement = $row['departemen'];
 $bagian = $row['divisi'];
 $kota = $row['kota'];
 $company = $row['unitusaha'];  
 
 $ke = $row['ke'];  
 $ke2 = $row['ke2'];  
 $ke3 = $row['ke3'];  
 $ke4 = $row['ke4'];  
 $ke5 = $row['ke5']; 
 $nik = $row['nik'];
 $lokja = $row['lokasikerja']; 

//============================================================================



/*


$file_name = $_FILES['file']['name'];
if (strpos($file_name, '%') !== false) {
   $namfile = str_replace('%', '', $file_name);
   $file_name = $namfile;
}
				$filenamebaru = date('dmYHi').$file_name;
				$tmp_name = $_FILES['file']['tmp_name'];			
		$target_dir = "../img/".$userid."/";
      $target_file = $target_dir . basename($_FILES["file"]["name"]);	
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if(empty($imageFileType)){
      $filenamenew = $filenamebaru.".jpg";
      $filenamebaru = $filenamenew;
    }else{
    
    }
if($imageFileType != "php" && $imageFileType != "html" && $imageFileType != "js") {
  
     if(!empty($file_name)){
   	move_uploaded_file($tmp_name, "../img/".$userid."/".$filenamebaru);
				 
      $inserteabsensi = "INSERT INTO log (iduser, noabsensi, nama, departement, bagian, company, status, latitude, longitude, gambar, tglsubmit, jamsubmit) VALUE ('".$userid."', '".$noabsensi."', '".$namae."', '".$departement."', '".$bagian."', '".$company."', '".$status."',  '".$latitude."',  '".$longitude."',  '".$filenamebaru."', '".$tanggal."', '".$jam."')"; 
				 $queryinsertabsensi = mysqli_query($conn, $inserteabsensi); 
				 
				 
	$json = array(
       'result' => 'success'

       );
       
    echo json_encode($json);    
   		 
				 
     }
     else{
         
         
     }
}
else{
    
    echo '<script>
	alert("Tidak boleh php");
</script>' ;
    
}

*/


//============================================================================  

if($longitude == '0' || $latitude == '0' || empty($latitude) || empty($longitude)){
   
      	$json = array(
       'result' => 'failed'

       );
     echo json_encode($json);   
       
}else{
 
 
   $stringambildatadist = "SELECT * FROM datadist 
 WHERE iduser = '" .$userid."';";
 $querydatadist =$conn->query($stringambildatadist);
 
 
 
  if($querydatadist->num_rows){
    $rowdatadist = mysqli_fetch_all($query, MYSQLI_ASSOC);
    for($x = 0; $x < sizeof($rowdatadist); $x++){
   
    $my_latitude = $latitude;
    $my_longitude = $longitude;
    $her_latitude = $rowdatadist[$x]['latitude'];
    $her_longitude = $rowdatadist[$x]['longitude'];

    $distance = round((((acos(sin(($my_latitude*pi()/180)) * sin(($her_latitude*pi()/180))+cos(($my_latitude*pi()/180)) * cos(($her_latitude*pi()/180)) * cos((($my_longitude- $her_longitude)*pi()/180))))*180/pi())*60*1.1515*1.609344), 3);
   
   if($distance > 0.50){
        $luarjangkauan = 'ya';
    }

    }
    
    if($luarjangkauan == 'ya'){
      $didistributor = '0';    
    }else{
      $didistributor = '1';  
    }
 
    
    
  }else{
    $didistributor = '0';  
      
  }

 
 $inserteabsensi = "INSERT INTO absenluarkota (iduser, noabsensi, sudahbaca, nama, departement, bagian, nik, company, status, latitude, longitude, alamat, gambar, ke, ke2, ke3, ke4, ke5, lokasikerja, tglsubmit, jamsubmit, note, kota, didistributor) VALUE ('".$userid."', '".$noabsensi."', '".$sudahbaca."', '".$namae."', '".$departement."', '".$bagian."', '".$nik."', '".$company."', '".$status."',  '".$latitude."',  '".$longitude."', '".$alamat."', '".$file."', '".$ke."', '".$ke2."', '".$ke3."', '".$ke4."', '".$ke5."', '".$lokja."', '".$tanggal."', '".$jam."', '".$note."', '".$kota."', '".$didistributor."')"; 
	$queryinsertabsensi = mysqli_query($conn, $inserteabsensi); 
				 
				 
				 
	//	$errornya = ("Error description: " . $conn -> error);	 
				 

   // echo json_encode($json);    
   		 

  
   $updatelog = "INSERT INTO log (iduser, tanggal, jam, activity, ip, userdevice,latitude, longitude) VALUE ('".$iduser."', '".$tanggal."', '".$jam."', '".$activity."', '".$ip."', '".$useragent."', '".$latitude."', '".$longitude."')"; 
   $queryupdatelog =$conn->query($updatelog); 
   
 	$json = array(
       'result' => 'success'

       );
      echo json_encode($json);  
    

}
 
 }
 
 else{
   $activity = "salah pass absensi luarkota android";
$json = array(
       'result' => 'salah password'
       );
       
echo json_encode($json); 
   
   $updatelogsalahpass = "INSERT INTO log (iduser, tanggal, jam, activity, ip, userdevice, latitude, longitude) VALUE ('".$username."', '".$tanggal."', '".$jam."', '".$activity."', '".$ip."', '".$useragent."', '".$latitude."', '".$longitude."')"; 
   $queryupdatelogsalahpass =$conn->query($updatelogsalahpass);
 
 }
 
 
}

?>