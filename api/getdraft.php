<?php 
include "../config.php";
session_start();
$iduser = addslashes($_POST['iduser']); 
$username = addslashes(strtolower($_POST['username']));

 
 $stringmasteruser = "SELECT * FROM masteruser 
 WHERE id = '" .$iduser . "';";
 $querynama =$conn->query($stringmasteruser);

 $rowmasteruser = mysqli_fetch_array($querynama, MYSQLI_ASSOC);
 
 $namanya = $rowmasteruser['username'];

 if($username == $namanya){
     $sama = 'ya';
 }
 

if(empty($iduser) || empty($username) || $sama != 'ya'){
$json = array(
       'result' => 'iduser and username is empty!',
       'item' => $item
       );
       
echo json_encode($json); 
return false;
}

else{
 $idraft = $_POST['iduser'];
 $string = "SELECT * FROM draft 
 WHERE idraft = '" .$idraft . "' ;";
 $query =$conn->query($string);
 
 if($query->num_rows){
     
   $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
   $iduser = $row['id'];
   $activity = "login";

 
  
    

    
  
      $item[] = array(
       "iduser"=>$row['iduser'],
       "activity"=>$row['activity'],
       "result"=>$row['result'],
       "plan"=>$row['plan'],
   
      
      );   
         
   
   
   $json = array(
       'result' => 'success',
       'item' => $item
       );
       
    echo json_encode($json);    
   

   
 }
 
 
 
 
}

?>