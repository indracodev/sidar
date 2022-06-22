<?php 
include "../config.php";
session_start();


$username = addslashes(strtolower($_POST['username']));
$userid = addslashes($_POST['userid']);
date_default_timezone_set('Asia/Jakarta');
 
 $stringmasteruser = "SELECT * FROM masteruser 
 WHERE id = '" .$userid . "';";
 $querynama =$conn->query($stringmasteruser);

 $rowmasteruser = mysqli_fetch_array($querynama, MYSQLI_ASSOC);
 
 $namanya = $rowmasteruser['username'];

 if($username == $namanya){
     $sama = 'ya';
 }
 

if(empty($userid) || empty($username) || $sama != 'ya'){
$json = array(
       'result' => 'nodar and username is empty!',
       'item' => $item
       );
       
echo json_encode($json); 
return false;
}

else{



 
 $ambilnoabsensi = "SELECT * FROM absenluarkota WHERE iduser = '" .$userid. "' ORDER BY idabsen DESC LIMIT 1 ;";
   $queryambilnoabsensi =$conn->query($ambilnoabsensi);
  
  
  if($queryambilnoabsensi->num_rows){
      
    $rowambilnoabsensi = mysqli_fetch_array($queryambilnoabsensi, MYSQLI_ASSOC);
     $noabsensi = $rowambilnoabsensi['noabsensi'];
     $tglsubmit = $rowambilnoabsensi['tglsubmit']." ".$rowambilnoabsensi['jamsubmit'];
     $status = $rowambilnoabsensi['status'];
     

     
 
 $pecah = explode("/", $noabsensi);
$hasil = $pecah[1] + 1;
$noabsensinya = $userid."/".$hasil;  

      
  }else{
    $satu = "1";
   //echo " gak dapat nomer ";
   $noabsensinya = $userid."/".$satu;
  }
    

    if(empty($tglsubmit)){
      $tglsubmit = date('Y-m-d',strtotime("-1 days"));   
    }
      $item[] = array(
       "noabsensi"=>$noabsensinya,
       "tglsubmit"=>$tglsubmit,
       "status"=>$status,
      
      );   
         
   
   
   $json = array(
       'result' => 'success',
       'item' => $item
       );
       
  echo json_encode($json);    
   

   

 
 
 
}

?>