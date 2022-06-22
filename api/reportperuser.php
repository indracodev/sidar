<?php 
include "../config.php";
session_start();

$username = addslashes(strtolower($_POST['username']));

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
     

if ($level == 'admin'){

$infomuser = "SELECT * FROM masteruser WHERE (id='".$iduser."' OR ke='".$iduser."' OR ke2='".$iduser."' OR ke3='".$iduser."' OR ke4='".$iduser."' OR ke5='".$iduser."') ORDER BY urutan DESC ;";
$queryuser = $conn->query($infomuser);
$arraymuser = mysqli_fetch_all($queryuser, MYSQLI_ASSOC);


}




for($x = 0; $x < sizeof($arraymuser); $x++){

$item[$x] = array(
       "nama"=>$arraymuser[$x]["nama"],
       "unitusaha"=>$arraymuser[$x]["unitusaha"],
       "departemen"=>$arraymuser[$x]["departemen"],
       "bagian"=>$arraymuser[$x]["divisi"],
       "kota"=>$arraymuser[$x]["kota"],
       "jabatan"=>$arraymuser[$x]["jabatan"],
       "iduser"=>$arraymuser[$x]["id"],
      
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