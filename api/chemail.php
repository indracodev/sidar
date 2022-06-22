<?php
include "../config.php";
session_start();

$iduser = addslashes($_POST['iduser']);
$username = addslashes(strtolower($_POST['username']));
$email = addslashes($_POST['email']);
//$passwordbaru = $_POST['passwordbaru'];
  
  if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else{
      $ip=$_SERVER['REMOTE_ADDR'];
    }

    
    
date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');
$jam = date('h:i:s');


 $string = "SELECT * FROM masteruser 
 WHERE username = '" .$username . "' AND id = '" .$iduser . "';";
 $query =$conn->query($string);
 
 if($query->num_rows){
     $dahupdatemail = "sudah";
   $respass = "UPDATE masteruser SET email='".$email."', dahupdatemail='".$dahupdatemail."' WHERE id='".$iduser."' ; ";


 //$query =$conn->query($respass);
 if($conn->query($respass) === TRUE){


   $activity = "update email";
   $updatelog = "INSERT INTO log (iduser, tanggal, jam, activity, ip, userdevice) VALUE ('".$iduser."', '".$tanggal."', '".$jam."', '".$activity."', '".$ip."', '".$useragent."')"; 
   $queryupdatelog =$conn->query($updatelog);

 
$json = array(
       'result' => 'sukses',
       );
       
echo json_encode($json); 
 } 

 else{
$json = array(
       'result' => 'gagalsatu',
       );
       
echo json_encode($json); 
 
 }

}else{
$json = array(
       'result' => 'gagal',
       );
       
echo json_encode($json); 
     
    
}
 

?>