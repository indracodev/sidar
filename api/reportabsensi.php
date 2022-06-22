<?php 
include "../config.php";
session_start();
$username = addslashes(strtolower($_POST['username']));
$iduser = addslashes($_POST['iduser']);
$level = addslashes($_POST['level']);
$password = addslashes(strtolower($_POST['password']));

/*
if(empty($iduser)){
$iduser = $_GET['iduser'];    
}

if(empty($username)){
$username = $_GET['username'];        
}

if(empty($level)){
$level = $_GET['level'];      
}

if(empty($password)){
$password = $_GET['password'];        
}
*/

$datefilter = $_POST['datefilter'];
$pecahtgl = explode("-", $datefilter);

$tglstartisi = $pecahtgl[0];
$tglendisi = $pecahtgl[1];

$tglstart = str_replace("/","-",$tglstartisi);
$tglend = str_replace("/","-",$tglendisi);

function encrypt_decrypt($action, $string)
{
  $output = false;
 
  $encrypt_method = "AES-256-CBC";
  $secret_key = 'osdkfje';
  $secret_iv = 'sdfvcdfeg';
 
  // hash
  $key = hash('sha256', $secret_key);
 
  // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a
  // warning
  $iv = substr(hash('sha256', $secret_iv), 0, 16);
 
  if ($action == 'encrypt')
  {
    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);
  }
  else
  {
    if ($action == 'decrypt')
    {
      $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
  }
 
  return $output;
}

 $password = encrypt_decrypt('encrypt', $password); 


 $string = "SELECT * FROM masteruser 
 WHERE masteruser.username = '" .$username . "' AND masteruser.password = '" .$password."';";
 $query =$conn->query($string);

 if($query->num_rows){
     

if(!empty($username) && !empty($iduser) && !empty($password)){

if($datefilter != ""){
 
 $zzz = "1";
 
 $infodar = "";
$querydar = "";
$arrayrdar = "";

   
$infodar = "SELECT * FROM absensluarkota WHERE tanggal BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglend."' AS DATE) AND (iduser='".$iduser."' OR ke='".$iduser."' OR ke2='".$iduser."' OR ke3='".$iduser."' OR ke4='".$iduser."' OR ke5='".$iduser."' ) ORDER BY idabsen DESC LIMIT 70;";
$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);
    
}


    
$zzz = "2";

$infodar = "";
$querydar = "";
$arrayrdar = "";

if(isset($_POST['cari'])){ // Check if form was submitted



$infodar = "SELECT * FROM absenluarkota WHERE (iduser='".$iduser."' OR ke='".$iduser."' OR ke2='".$iduser."' OR ke3='".$iduser."' OR ke4='".$iduser."' OR ke5='".$iduser."' ) AND (nama LIKE '".$searchingg."' OR tglsubmit LIKE '".$searchingg."') ORDER BY idabsen DESC LIMIT 70;";
$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);



    }

else{
        
if($_SESSION["readfilter"] == "1"){        
$infodar = "SELECT * FROM absenluarkota WHERE (iduser='".$iduser."' OR ke='".$iduser."' OR ke2='".$iduser."' OR ke3='".$iduser."' OR ke4='".$iduser."' OR ke5='".$iduser."' ) AND sudahbaca NOT LIKE '%".$iduser."|%' ORDER BY idabsen DESC LIMIT 70;";
$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);
}else{
$infodar = "SELECT * FROM absenluarkota WHERE (iduser='".$iduser."' OR ke='".$iduser."' OR ke2='".$iduser."' OR ke3='".$iduser."' OR ke4='".$iduser."' OR ke5='".$iduser."' ) ORDER BY idabsen DESC LIMIT 70;";
$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);    
    
}

        
    }






for($x = 0; $x < sizeof($arrayrdar); $x++){

$item[$x] = array(
       "noabsensi"=> $arrayrdar[$x]["noabsensi"],
       "company"=>$arrayrdar[$x]["company"],
       "departement"=>$arrayrdar[$x]["departement"],
       "divisi"=>$arrayrdar[$x]["bagian"],
       "kota"=>$arrayrdar[$x]["kota"],
       "nama"=>$arrayrdar[$x]["nama"],
       "tanggal"=>$arrayrdar[$x]["tglsubmit"],
       "jam"=>$arrayrdar[$x]["jamsubmit"],
       "sudahbaca"=>$arrayrdar[$x]["sudahbaca"],
       "status"=>$arrayrdar[$x]["status"],
  
      );       
    
    
}


$json = array(
       'result' => 'success',
       'item' => $item
       );
       
echo json_encode($json);

}else{

$json = array(
       'result' => 'username dan idsuer kosong',
       'item' => $item
       );
       
echo json_encode($json);    
    
}

}else{
echo "salah password";    
    
}

?>