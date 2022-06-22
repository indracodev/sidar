<?php 
include "../config.php";
session_start();
$username = addslashes(strtolower($_POST['username']));
$iduser = addslashes($_POST['iduser']);
$level = addslashes($_POST['level']);
$password = addslashes(strtolower($_POST['password']));

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

 $string = "SELECT * FROM masteruser 
 WHERE masteruser.username = '" .$username . "' AND masteruser.password = '" .$password."';";
 $query =$conn->query($string);

 if($query->num_rows){
     

if(!empty($username) && !empty($iduser) && !empty($password)){

if($level != "admin" && $datefilter != ""){
 
 $zzz = "1";
 
 $infodar = "";
$querydar = "";
$arrayrdar = "";

   
$infodar = "SELECT masteruser.nama, masteruser.username, masteruser.kota, masteruser.divisi, masteruser.departemen, masteruser.unitusaha, dar.status, dar.sudahbaca, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggal BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglend."' AS DATE) AND dar.iduser='".$iduser."' ORDER BY dar.urid DESC LIMIT 70;";
$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);
    
}


    
if ($level != "admin"){

$zzz = "2";

$infodar = "";
$querydar = "";
$arrayrdar = "";

if(isset($_POST['cari'])){ // Check if form was submitted



$infodar = "SELECT masteruser.nama, masteruser.username,  masteruser.kota, masteruser.divisi, masteruser.departemen, masteruser.unitusaha, dar.status, dar.sudahbaca, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE dar.iduser='".$iduser."' AND (dar.activity LIKE '".$searchingg."' OR dar.plan LIKE '".$searchingg."' OR dar.result LIKE '".$searchingg."' OR masteruser.nama LIKE '".$searchingg."') ORDER BY dar.urid DESC LIMIT 70;";
$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);



    }

else{
        
if($_SESSION["readfilter"] == "1"){        
$infodar = "SELECT masteruser.nama, masteruser.username,  masteruser.kota, masteruser.divisi, masteruser.departemen, masteruser.unitusaha, dar.status, dar.sudahbaca, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE dar.iduser='".$iduser."' AND sudahbaca NOT LIKE '%".$iduser."|%' ORDER BY dar.urid DESC LIMIT 70;";
$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);
}else{
$infodar = "SELECT masteruser.nama, masteruser.username,  masteruser.kota, masteruser.divisi, masteruser.departemen, masteruser.unitusaha, dar.status, dar.sudahbaca, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE dar.iduser='".$iduser."' ORDER BY dar.urid DESC LIMIT 70;";
$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);    
    
}

        
    }



}


if ($level == "admin" && $datefilter != ""){

$zzz = "32";
$infodar = "";
$querydar = "";
$arrayrdar = "";


$infodar = "SELECT masteruser.nama, masteruser.username,  masteruser.kota, masteruser.divisi, masteruser.departemen, masteruser.unitusaha, dar.jam, dar.tanggaldar, dar.status, dar.sudahbaca, dar.tanggal, dar.nodar, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggal BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglend."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."') ORDER BY dar.urid DESC LIMIT 70;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);

} 


if ($level == "admin"){

$zzz = "3";
$infodar = "";
$querydar = "";
$arrayrdar = "";

if(isset($_POST['cari'])){ // Check if form was submitted




$infodar = "SELECT masteruser.nama, masteruser.username,  masteruser.kota, masteruser.divisi, masteruser.departemen, masteruser.unitusaha, dar.status, dar.sudahbaca, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) AND (dar.activity LIKE '".$searchingg."' OR dar.plan LIKE '".$searchingg."' OR dar.result LIKE '".$searchingg."' OR masteruser.nama LIKE '".$searchingg."') ORDER BY dar.urid DESC LIMIT 70;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);



    }
    else{

if($_SESSION["readfilter"] == "1"){
  $infodar = "SELECT masteruser.nama, masteruser.username,  masteruser.kota, masteruser.divisi, masteruser.departemen, masteruser.unitusaha, dar.status, dar.sudahbaca, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) AND sudahbaca NOT LIKE '%".$iduser."|%' ORDER BY dar.urid DESC LIMIT 70;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);  
    
}else{
    $infodar = "SELECT masteruser.nama, masteruser.username,  masteruser.kota, masteruser.divisi, masteruser.departemen, masteruser.unitusaha, dar.status, dar.sudahbaca, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.urid DESC LIMIT 70;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);
    
}



}

} 

for($x = 0; $x < sizeof($arrayrdar); $x++){

$item[$x] = array(
       "nodar"=> $arrayrdar[$x]["nodar"],
       "unitusaha"=>$arrayrdar[$x]["unitusaha"],
       "departemen"=>$arrayrdar[$x]["departemen"],
       "nama"=>$arrayrdar[$x]["nama"],
       "divisi"=>$arrayrdar[$x]["divisi"],
       "kota"=>$arrayrdar[$x]["kota"],
       "username"=>$arrayrdar[$x]["username"],
       "tanggaldar"=>$arrayrdar[$x]["tanggaldar"],
       "tanggal"=>$arrayrdar[$x]["tanggal"],
       "jam"=>$arrayrdar[$x]["jam"],
       "sudahbaca"=>$arrayrdar[$x]["sudahbaca"],
       "noabsensi"=>$arrayrdar[$x]["tag"],
       "status"=>$arrayrdar[$x]["status"],
      
      );       
    
    
}


$json = array(
       'result' => 'succsess',
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