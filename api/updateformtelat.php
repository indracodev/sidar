<?php 
include "../config.php";

   
date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');
$jam = date('h:i:s');

$IUser = $_POST['iduser'];
$nama = $_POST['nama'];
$notelat = $_POST['notelat'];
$alasan = $_POST['alasan'];


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




 $updatelog = "UPDATE formtelat SET alasan='".$alasan."', sudahisialasan='iya' WHERE notelat='".$notelat."' ";
 $querytambahuser =$conn->query($updatelog);

 
 
if ($querytambahuser === TRUE) {
				 
	$json = array(
       'result' => 'success'

       );
       
    echo json_encode($json);    
   		 
				 
}


}

?>