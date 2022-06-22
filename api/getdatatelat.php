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

   
$infodar = "SELECT masteruser.nama, masteruser.departemen, masteruser.divisi, masteruser.kota, masteruser.unitusaha, formtelat.telatpadatanggal, formtelat.masukjam, formtelat.alasan, formtelat.dibuatpadatgl, formtelat.ke1, formtelat.menyetujuiatasan, formtelat.mengetahuihcs, formtelat.notelat FROM formtelat INNER JOIN masteruser ON masteruser.id=formtelat.iduser WHERE telatpadatanggal BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglend."' AS DATE) AND formtelat.iduser='".$iduser."' ORDER BY formtelat.telatpadatanggal DESC, formtelat.masukjam DESC";
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



$infodar = "SELECT masteruser.nama, masteruser.departemen, masteruser.divisi, masteruser.kota, masteruser.unitusaha, formtelat.telatpadatanggal, formtelat.masukjam, formtelat.alasan, formtelat.dibuatpadatgl, formtelat.ke1, formtelat.menyetujuiatasan, formtelat.mengetahuihcs, formtelat.notelat FROM formtelat INNER JOIN masteruser ON masteruser.id=formtelat.iduser WHERE formtelat.iduser='".$iduser."' AND (formtelat.alasan LIKE '".$searchingg."' OR masteruser.nama LIKE '".$searchingg."') ORDER BY formtelat.telatpadatanggal DESC, formtelat.masukjam DESC;";
$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);



    }

else{
        

$infodar = "SELECT masteruser.nama, masteruser.departemen, masteruser.divisi, masteruser.kota, masteruser.unitusaha, formtelat.telatpadatanggal, formtelat.masukjam, formtelat.alasan, formtelat.dibuatpadatgl, formtelat.ke1, formtelat.menyetujuiatasan, formtelat.mengetahuihcs, formtelat.notelat FROM formtelat INNER JOIN masteruser ON masteruser.id=formtelat.iduser WHERE formtelat.iduser='".$iduser."' ORDER BY formtelat.telatpadatanggal DESC, formtelat.masukjam DESC LIMIT 70;";
$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);    
    

        
    }



}


if ($level == "admin" && $datefilter != ""){

$zzz = "32";
$infodar = "";
$querydar = "";
$arrayrdar = "";


$infodar = "SELECT masteruser.nama, masteruser.departemen, masteruser.divisi, masteruser.kota, masteruser.unitusaha, formtelat.telatpadatanggal, formtelat.masukjam, formtelat.alasan, formtelat.dibuatpadatgl, formtelat.ke1, formtelat.menyetujuiatasan, formtelat.mengetahuihcs, formtelat.notelat FROM formtelat INNER JOIN masteruser ON masteruser.id=formtelat.iduser WHERE telatpadatanggal BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglend."' AS DATE) AND (formtelat.iduser='".$iduser."' OR formtelat.ke1='".$iduser."' OR formtelat.ke2='".$iduser."' OR formtelat.ke3='".$iduser."' OR formtelat.ke4='".$iduser."' OR formtelat.ke5='".$iduser."') ORDER BY formtelat.telatpadatanggal DESC, formtelat.masukjam DESC";

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




$infodar = "SELECT masteruser.nama, masteruser.departemen, masteruser.divisi, masteruser.kota, masteruser.unitusaha, formtelat.telatpadatanggal, formtelat.masukjam, formtelat.alasan, formtelat.dibuatpadatgl, formtelat.ke1, formtelat.menyetujuiatasan, formtelat.mengetahuihcs, formtelat.notelat FROM formtelat INNER JOIN masteruser ON masteruser.id=formtelat.iduser WHERE (formtelat.iduser='".$iduser."' OR formtelat.ke1='".$iduser."' OR formtelat.ke2='".$iduser."' OR formtelat.ke3='".$iduser."' OR formtelat.ke4='".$iduser."' OR formtelat.ke5='".$iduser."' ) AND (formtelat.alasan LIKE '".$searchingg."' OR masteruser.nama LIKE '".$searchingg."') ORDER BY formtelat.telatpadatanggal DESC, formtelat.masukjam DESC;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);



    }
    else{


$infodar = "SELECT masteruser.nama, masteruser.departemen, masteruser.divisi, masteruser.kota, masteruser.unitusaha, formtelat.telatpadatanggal, formtelat.masukjam, formtelat.alasan, formtelat.dibuatpadatgl, formtelat.ke1, formtelat.menyetujuiatasan, formtelat.mengetahuihcs, formtelat.notelat FROM formtelat INNER JOIN masteruser ON masteruser.id=formtelat.iduser WHERE (formtelat.iduser='".$iduser."' OR formtelat.ke1='".$iduser."' OR formtelat.ke2='".$iduser."' OR formtelat.ke3='".$iduser."' OR formtelat.ke4='".$iduser."' OR formtelat.ke5='".$iduser."' ) ORDER BY formtelat.telatpadatanggal DESC, formtelat.masukjam DESC LIMIT 70;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);
    




}

} 

for($x = 0; $x < sizeof($arrayrdar); $x++){

$item[$x] = array(
       "notelat"=> $arrayrdar[$x]["notelat"],
       "unitusaha"=>$arrayrdar[$x]["unitusaha"],
       "departemen"=>$arrayrdar[$x]["departemen"],
       "nama"=>$arrayrdar[$x]["nama"],
       "divisi"=>$arrayrdar[$x]["divisi"],
       "telatpadatanggal"=>$arrayrdar[$x]["telatpadatanggal"],
       "masukjam"=>$arrayrdar[$x]["masukjam"],
       "alasan"=>$arrayrdar[$x]["alasan"],
       "menyetujuiatasan"=>$arrayrdar[$x]["menyetujuiatasan"],
       "mengetahuihcs"=>$arrayrdar[$x]["mengetahuihcs"],
      
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