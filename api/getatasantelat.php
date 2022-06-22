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
 $ke1 = $rowmasteruser['ke'];
 $ke2 = $rowmasteruser['ke2'];
 $ke3 = $rowmasteruser['ke3'];
 $ke4 = $rowmasteruser['ke4'];
 $ke5 = $rowmasteruser['ke5'];

if(!empty($ke1)){
$infoke1 = "SELECT * FROM masteruser WHERE id = '".$ke1."' ;";
$queryinfoke1 = $conn->query($infoke1);
$arrayinfoke1 = mysqli_fetch_array($queryinfoke1, MYSQLI_ASSOC);
$ke1nama = $arrayinfoke1['nama'];
}

if(!empty($ke2)){
$infoke2 = "SELECT * FROM masteruser WHERE id = '".$ke2."' ;";
$queryinfoke2 = $conn->query($infoke2);
$arrayinfoke2 = mysqli_fetch_array($queryinfoke2, MYSQLI_ASSOC);
$ke2nama = $arrayinfoke2['nama'];
}

if(!empty($ke3)){
$infoke3 = "SELECT * FROM masteruser WHERE id = '".$ke3."' ;";
$queryinfoke3 = $conn->query($infoke3);
$arrayinfoke3 = mysqli_fetch_array($queryinfoke3, MYSQLI_ASSOC);
$ke3nama = $arrayinfoke3['nama'];
}

if(!empty($ke4)){
$infoke4 = "SELECT * FROM masteruser WHERE id = '".$ke4."' ;";
$queryinfoke4 = $conn->query($infoke4);
$arrayinfoke4 = mysqli_fetch_array($queryinfoke4, MYSQLI_ASSOC);
$ke4nama = $arrayinfoke4['nama'];
}

if(!empty($ke5)){
$infoke5 = "SELECT * FROM masteruser WHERE id = '".$ke5."' ;";
$queryinfoke5 = $conn->query($infoke5);
$arrayinfoke5 = mysqli_fetch_array($queryinfoke5, MYSQLI_ASSOC);
$ke5nama = $arrayinfoke5['nama'];
}

 if($username == $namanya){
     $sama = 'ya';
 }
 

if(empty($userid) || empty($username) || $sama != 'ya'){
$json = array(
       'result' => 'iduser and username is empty!',
       'item' => $item
       );
       
echo json_encode($json); 
return false;
}

else{




      $item[] = array(
       "ke1"=>$ke1,
       "ke1nama"=>$ke1nama,
       "ke2"=>$ke2,
       "ke2nama"=>$ke2nama,
       "ke3"=>$ke3,
       "ke3nama"=>$ke3nama,
       "ke4"=>$ke4,
       "ke4nama"=>$ke4nama,
       "ke5"=>$ke5,
       "ke5nama"=>$ke5nama,
      );   
         
   
   
   $json = array(
       'result' => 'success',
       'item' => $item
       );
       
  echo json_encode($json);    
   

 
 
}

?>