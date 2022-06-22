<?php 
include "../config.php";
session_start();
$username = addslashes(strtolower($_POST['username'])); 

$stringmasteruser = "SELECT * FROM masteruser WHERE username = '" .$username . "';";
$querynama =$conn->query($stringmasteruser);
$rowmasteruser = mysqli_fetch_array($querynama, MYSQLI_ASSOC);
 
  $sudahkirim = $rowmasteruser['sudahkirim']; 
//  $iduser = $rowmasteruser['id'];
   $json = array(
       'sudahkirim' => $sudahkirim
       );
       
    echo json_encode($json);    


?>