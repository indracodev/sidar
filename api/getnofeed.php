<?php 
include "../config.php";
session_start();


$username = addslashes(strtolower($_POST['username']));
$userid = addslashes($_POST['userid']);

 
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



 
 $ambilnofeed = "SELECT * FROM feedback WHERE iduser = '" .$userid. "' ORDER BY id DESC LIMIT 1 ;";
   $queryambilnofeed =$conn->query($ambilnofeed);
  
  
  if($queryambilnofeed->num_rows){
      
    $rowambilnofeed = mysqli_fetch_array($queryambilnofeed, MYSQLI_ASSOC);
     $nofeed = $rowambilnofeed['nofeed'];
 
 $pecah = explode("/", $nofeed);
$hasil = $pecah[1] + 1;
$nofeednya = $userid."/".$hasil;  

      
  }else{
    $satu = "1";
   //echo " gak dapat nomer ";
   $nofeednya = $userid."/".$satu;
  }
    

    
  
      $item[] = array(
       "nofeed"=>$nofeednya,

      
      );   
         
   
   
   $json = array(
       'result' => 'success',
       'item' => $item
       );
       
  echo json_encode($json);    
   

   

 
 
 
}

?>