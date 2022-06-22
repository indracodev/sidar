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

 $status = $_POST['status'];  
 $latitude = $_POST['latitude'];  
 $longitude = $_POST['longitude'];  
 $gambar = $_POST['gambar']; 
 $noabsensi = $_POST['noabsensi'];
   
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
 $bagian = $row['bagian'];  
 $company = $row['company'];  

//============================================================================






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
		/*		mysqli_query($conn,"INSERT INTO upgam VALUE('', '".$file_name."')"); */
				 
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


//============================================================================   
   
   

  
   $updatelog = "INSERT INTO log (iduser, tanggal, jam, activity, ip, userdevice) VALUE ('".$iduser."', '".$tanggal."', '".$jam."', '".$activity."', '".$ip."', '".$useragent."')"; 
   $queryupdatelog =$conn->query($updatelog); 
   
 
 }
 
 else{
   $activity = "salah pass absensi luarkota android";
$json = array(
       'result' => 'salah password'
       );
       
echo json_encode($json); 
   
   $updatelogsalahpass = "INSERT INTO log (iduser, tanggal, jam, activity, ip, userdevice) VALUE ('".$username."', '".$tanggal."', '".$jam."', '".$activity."', '".$ip."', '".$useragent."')"; 
   $queryupdatelogsalahpass =$conn->query($updatelogsalahpass);
 
 }
 
 
}

?>