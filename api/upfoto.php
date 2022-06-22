<?php
header('Access-Control-Allow-Origin: *');
session_start();
//$IUser = $_SESSION["IUser"];
// Load file koneksi.php
include "../config.php";

$IUser = $_POST['iduser'];
$Nodar = $_POST['nodar'];

$file_name = $_FILES['file']['name'];
if (strpos($file_name, '%') !== false) {
   $namfile = str_replace('%', '', $file_name);
   $file_name = $namfile;
}
				$filenamebaru = date('dmYHi').$file_name;
				$tmp_name = $_FILES['file']['tmp_name'];			
		$target_dir = "../img/".$IUser."/";
      $target_file = $target_dir . basename($_FILES["file"]["name"]);	
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if(empty($imageFileType)){
      $filenamenew = $filenamebaru.".jpg";
      $filenamebaru = $filenamenew;
    }else{
    
    }
if($imageFileType != "php" && $imageFileType != "html" && $imageFileType != "js") {
  
     if(!empty($file_name)){
   	move_uploaded_file($tmp_name, "../img/".$IUser."/".$filenamebaru);
		/*		mysqli_query($conn,"INSERT INTO upgam VALUE('', '".$file_name."')"); */
				$queryupimg = "INSERT INTO masterattach (nodar, gambar, iduser) VALUE ('".$Nodar."', '".$filenamebaru."', '".$IUser."')"; 
				 $sqlup = mysqli_query($conn, $queryupimg); 
     }
     else{
         
         
     }
}
else{
    
    echo '<script>
	alert("Tidak boleh php");
</script>' ;
    
}
?>