<?php 
include "../config.php";
session_start();

$username = addslashes(strtolower($_POST['username']));
$idusertujuan = addslashes($_POST['idusertujuan']);
$password = addslashes(strtolower($_POST['password']));

date_default_timezone_set('Asia/Jakarta');
$tglhariini = date('Y-m-d');


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
 WHERE username = '" .$username . "' AND password = '" .$password."';";
 $query = $conn->query($string);
 
 
 

 if($query->num_rows){
     
$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
$iduser = $row['id'];   
$level = $row['level']; 
     
     
$bolehakses;

$ambilidke = "SELECT * FROM masteruser WHERE id = '".$idusertujuan."';";
$queryambilidke =$conn->query($ambilidke);


 if($queryambilidke->num_rows){
     
$rowambilidke = mysqli_fetch_array($queryambilidke, MYSQLI_ASSOC);



 if($iduser == $rowambilidke["ke"] || $iduser == $rowambilidke["ke2"] || $iduser == $rowambilidke["ke3"] || $iduser == $rowambilidke["ke4"] || $iduser == $rowambilidke["ke5"]){
     $bolehakses = 'boleh';
 }


}

if($bolehakses == 'boleh'){

  
     
     

if ($level == 'admin'){

$infodar = "SELECT masteruser.nama, masteruser.departemen, masteruser.divisi, masteruser.kota, masteruser.unitusaha, dar.status, dar.sudahbaca, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE dar.iduser='".$idusertujuan."' ORDER BY dar.tanggaldar DESC, dar.jam DESC LIMIT 70;";
$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);


}




for($x = 0; $x < sizeof($arrayrdar); $x++){

$item[$x] = array(
       "nodar"=> $arrayrdar[$x]["nodar"],
       "unitusaha"=>$arrayrdar[$x]["unitusaha"],
       "departemen"=>$arrayrdar[$x]["departemen"],
       "nama"=>$arrayrdar[$x]["nama"],
       "username"=>$arrayrdar[$x]["username"],
       "tanggaldar"=>$arrayrdar[$x]["tanggaldar"],
       "tanggal"=>$arrayrdar[$x]["tanggal"],
       "jam"=>$arrayrdar[$x]["jam"],
       "sudahbaca"=>$arrayrdar[$x]["sudahbaca"],
       "divisi"=>$arrayrdar[$x]["divisi"],
       "kota"=>$arrayrdar[$x]["kota"],
       "noabsensi"=>$arrayrdar[$x]["tag"],
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
'result' => 'tidak boleh'

       );
       
echo json_encode($json);
 
        
    }   


}else{
echo "salah password";    
    
}


?>