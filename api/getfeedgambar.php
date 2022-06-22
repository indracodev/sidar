<?php 
include "../config.php";
session_start();
$nofeed = $_POST['nofeed']; 
$username = addslashes(strtolower($_POST['username']));

$pecah = explode("/", $nofeed);
$hasiliduser = $pecah[0];
 
 $stringmasteruser = "SELECT * FROM masteruser 
 WHERE id = '" .$hasiliduser . "';";
 $querynama =$conn->query($stringmasteruser);

 $rowmasteruser = mysqli_fetch_array($querynama, MYSQLI_ASSOC);
 
 $namanya = $rowmasteruser['username'];

 if($username == $namanya){
     $sama = 'ya';
 }
 

if(empty($nofeed) || empty($username) || $sama != 'ya'){
$json = array(
       'result' => 'nofeed and username is empty!',
       'item' => $item
       );
       
echo json_encode($json); 
return false;
}

else{



 
   $ambilattach = "SELECT * FROM feedattach 
   WHERE nofeed = '" .$nofeed. "' ;";
   $queryambilattach =$conn->query($ambilattach);
       $t = 0;
      $daftargambar[$t];
      $idgambar[$t] ;
  $jumlahrow;
  if($queryambilattach->num_rows){
      $rowambilattach = mysqli_fetch_all($queryambilattach, MYSQLI_ASSOC);
      $jumlahrow = count($rowambilattach); 
   
      for ($x = 0; $x < count($rowambilattach); $x++) {
      $daftargambar[$t] = $rowambilattach[$x]["gambar"] ;
      $idgambar[$t] = $rowambilattach[$x]["id"];
         
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