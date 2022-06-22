<?php 
include "../config.php";
session_start();
$nodar = $_POST['nodar']; 
$username = addslashes(strtolower($_POST['username']));

$pecah = explode("/", $nodar);
$hasiliduser = $pecah[0];
 
 $stringmasteruser = "SELECT * FROM masteruser 
 WHERE id = '" .$hasiliduser . "';";
 $querynama =$conn->query($stringmasteruser);

 $rowmasteruser = mysqli_fetch_array($querynama, MYSQLI_ASSOC);
 
 $namanya = $rowmasteruser['username'];

 if($username == $namanya){
     $sama = 'ya';
 }
 

if(empty($nodar) || empty($username) || $sama != 'ya'){
$json = array(
       'result' => 'nodar and username is empty!',
       'item' => $item
       );
       
echo json_encode($json); 
return false;
}

else{



 
   $ambilattach = "SELECT * FROM masterattach 
   WHERE nodar = '" .$nodar. "' ;";
   $queryambilattach =$conn->query($ambilattach);
       $t = 0;
      $daftargambar[$t];
  $jumlahrow;
  if($queryambilattach->num_rows){
      $rowambilattach = mysqli_fetch_all($queryambilattach, MYSQLI_ASSOC);
      $jumlahrow = count($rowambilattach); 
   
      for ($x = 0; $x < count($rowambilattach); $x++) {
      $daftargambar[$t] = $rowambilattach[$x]["gambar"] ;
 
         
      $t++;
    } 
      
  }
    

    
  
      $item[] = array(
       "jumlahgambar"=>$jumlahrow,
       "gambar"=>$daftargambar,
      
      );   
         
   
   
   $json = array(
       'result' => 'success',
       'item' => $item
       );
       
  echo json_encode($json);    
   

   

 
 
 
}

?>