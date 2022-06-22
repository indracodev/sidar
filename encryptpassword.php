<?php

include "config.php";


$sql = "SELECT * FROM masteruser";
$result = $conn->query($sql);
$rowresult = mysqli_fetch_all($result, MYSQLI_ASSOC);

//echo sizeof($rowresult);

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

$dec = 'ZTBrVmhyQ3FENGkzS09jRDlVdTJxQT09';

$decrypted_password = encrypt_decrypt('decrypt', $dec);  
echo $decrypted_password;
/*
for($x= 0; $x < sizeof($rowresult); $x++ ){
    
$id = $rowresult[$x]["id"];
$username = $rowresult[$x]["username"];
$username = rtrim(strtolower($username));

 
//$username = encrypt_decrypt('decrypt', $username); 



$updatepasscrypt = "UPDATE masteruserbaru SET username='".$username."' WHERE id='".$id."' "; 
$conn->query($updatepasscrypt);

} 
*/
echo 'sudah';

?>