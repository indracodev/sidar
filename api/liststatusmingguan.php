<?php 
include "../config.php";
session_start();

$username = addslashes(strtolower($_POST['username']));
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

date_default_timezone_set('Asia/Jakarta');
$tglhariini = date('Y-m-d');

$dt_min = new DateTime("last saturday"); // Edit
$dt_min->modify('+2 day'); // Edit
$dt_max = clone($dt_min);
$dt_max->modify('+5 days');
$mingguawal = $dt_min->format('Y-m-d');
$mingguakhir = $dt_max->format('Y-m-d');

$getstat = $_POST['status'];
    
 $string = "SELECT * FROM masteruser 
 WHERE username = '" .$username . "' AND password = '" .$password."';";
 $query = $conn->query($string);

 if($query->num_rows){
     
$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
$iduser = $row['id'];   
     

if ($getstat == 'nodata'){

$infodar = "SELECT id, nama, unitusaha, divisi, kota, departemen FROM masteruser WHERE (id = '".$iduser."' OR ke='".$iduser."' OR ke2='".$iduser."' OR ke3='".$iduser."' OR ke4='".$iduser."' OR ke5='".$iduser."') AND ( id NOT IN (SELECT iduser FROM dar WHERE tanggaldar BETWEEN CAST('".$mingguawal."' AS DATE) AND CAST('".$mingguakhir."' AS DATE) AND (iduser='".$iduser."' OR ke='".$iduser."' OR ke2='".$iduser."' OR ke3='".$iduser."' OR ke4='".$iduser."' OR ke5='".$iduser."' )))";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);  


}elseif($getstat == 'ontime'){
    
$infodar = "SELECT masteruser.nama, masteruser.unitusaha, masteruser.divisi, masteruser.kota, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE status = '".$getstat."' AND tanggaldar BETWEEN CAST('".$mingguawal."' AS DATE) AND CAST('".$mingguakhir."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);    
    
}elseif($getstat == 'late'){
    
$infodar = "SELECT masteruser.nama, masteruser.unitusaha, masteruser.divisi, masteruser.kota, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE status = '".$getstat."' AND tanggaldar BETWEEN CAST('".$mingguawal."' AS DATE) AND CAST('".$mingguakhir."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);    
    
}elseif($getstat == 'over'){
    
$infodar = "SELECT masteruser.nama, masteruser.unitusaha, masteruser.divisi, masteruser.kota, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE status = '".$getstat."' AND tanggaldar BETWEEN CAST('".$mingguawal."' AS DATE) AND CAST('".$mingguakhir."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);       
    
}elseif($getstat == 'absence'){
    
$infodar = "SELECT masteruser.nama, masteruser.unitusaha, masteruser.divisi, masteruser.kota, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE (status = '".$getstat."' OR status = 'Pending Absence') AND tanggaldar BETWEEN CAST('".$mingguawal."' AS DATE) AND CAST('".$mingguakhir."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);       
    
}




for($x = 0; $x < sizeof($arrayrdar); $x++){

$item[$x] = array(
       "unitusaha"=>$arrayrdar[$x]["unitusaha"],
       "departemen"=>$arrayrdar[$x]["departemen"],
       "nama"=>$arrayrdar[$x]["nama"],
       "tgldar"=>$arrayrdar[$x]["tanggaldar"],
       "divisi"=>$arrayrdar[$x]["divisi"],
       "kota"=>$arrayrdar[$x]["kota"],
       "status"=>$getstat,
      
      );       
    
    
}


$json = array(
       'result' => 'success',
       'item' => $item
       );
       
echo json_encode($json);



}else{
echo "salah password";    
    
}


?>