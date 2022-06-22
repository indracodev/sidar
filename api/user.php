<?php 
include "../config.php";
session_start();

  if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else{
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    
$useragent = $_SERVER['HTTP_USER_AGENT'];

date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');
$jam = date('h:i:s');

$tokendevice = $_POST["tokendevice"];
$latitude = $_POST["latitude"];
$longitude = $_POST["longitude"];

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

if(empty($latitude)){
$latitude = "-";    
}

if(empty($longitude)){
$longitude = "-";    
}
   
if(empty($_POST['username'])){
$json = array(
       'result' => 'UserName is empty!',
       'item' => $item
       );
       
echo json_encode($json); 
return false;
}

elseif (empty($_POST['password'])){
$json = array(
       'result' => 'Password is empty!',
       'item' => $item
       );
       
echo json_encode($json); 
return false;
}

else{
 
 $username = addslashes(strtolower($_POST['username']));
 $password = addslashes(strtolower($_POST['password']));
 $password = encrypt_decrypt('encrypt', $password); 
 
 $string = "SELECT * FROM masteruser 
 WHERE masteruser.username = '" .$username . "' AND masteruser.password = '" .$password."';";
 $query =$conn->query($string);
 
 if($query->num_rows){
     
   $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
   $iduser = $row['id'];
   $activity = "login android";

 
   $ambilnomer = "SELECT nodar,tanggaldar FROM dar 
   WHERE iduser = '" .$iduser. "' ORDER BY urid DESC LIMIT 1 ;";
   $queryambilnomer =$conn->query($ambilnomer);
    
    if($queryambilnomer){
      $rowambilnomer = mysqli_fetch_array($queryambilnomer, MYSQLI_ASSOC);
      $ndar = $rowambilnomer['nodar'];
      $tgldarterakhir = $rowambilnomer['tanggaldar'];
    }
    
  
    
   $ambilabsenluarkotamasuk = "SELECT * FROM absenluarkota 
   WHERE tglsubmit = '" .$tanggal. "' AND status = 'absen masuk' AND iduser = '" .$iduser. "' ORDER BY idabsen DESC LIMIT 1 ;";
   $queryambilabsenluarkotamasuk =$conn->query($ambilabsenluarkotamasuk);
   
   $ambilabsenluarkotapulang = "SELECT * FROM absenluarkota 
   WHERE tglsubmit = '" .$tanggal. "' AND status = 'absen pulang' AND iduser = '" .$iduser. "' ORDER BY idabsen DESC LIMIT 1 ;";
   $queryambilabsenluarkotapulang =$conn->query($ambilabsenluarkotapulang);
    
    if($queryambilabsenluarkotamasuk){
      $rowambilabsenmasuk = mysqli_fetch_array($queryambilabsenluarkotamasuk, MYSQLI_ASSOC);
      $nmasuk = $rowambilabsenmasuk['nama'];

    }
    
     if($queryambilabsenluarkotapulang){
      $rowambilabsenpulang = mysqli_fetch_array($queryambilabsenluarkotapulang, MYSQLI_ASSOC);
      $npulang = $rowambilabsenpulang['nama'];
    
    }
    
  
  if(empty($nmasuk)){
   $smasuk = 'belum';   
  }else{
   $smasuk = 'sudah';   
  }
    
  
  if(empty($npulang)){
    $spulang = 'belum';  
  }else{
    $spulang = 'sudah'; 
     $smasuk = 'sudah';  
  }
        
    

    
  
      $item[] = array(
       "userid"=>$row['id'],
       "username"=>$row['username'],
       "nama"=>$row['nama'],
       "departement"=>$row['departemen'],
       "divisi"=>$row['divisi'],
       "jabatan"=>$row['jabatan'],
       "level"=>$row['level'],
       "email"=>$row['email'],
       "lokasikerja"=>$row['lokasikerja'],
       "unitusaha"=>$row['unitusaha'],
       "ke"=>$row['ke'],
       "ke2"=>$row['ke2'],
       "ke3"=>$row['ke3'],
       "ke4"=>$row['ke4'],
       "ke5"=>$row['ke5'],
       "sudahkirim"=>$row['sudahkirim'],
       "nodar"=>$ndar,
       "dahupdatemail"=>$row['dahupdatemail'],
       "izinabsenlk"=>$row['izinabsenlk'],
       "tanggaldarterakhir"=>$tgldarterakhir,
       "latitude"=>$latitude,
       "longitude"=>$longitude,
       "absenmasuk"=>$smasuk,
       "absenpulang"=>$spulang
      );   
         
   
   
   $json = array(
       'result' => 'success',
       'item' => $item
       );
       
    echo json_encode($json);    
   
  
   $updatelog = "INSERT INTO log (iduser, tanggal, jam, activity, ip, userdevice, latitude, longitude) VALUE ('".$iduser."', '".$tanggal."', '".$jam."', '".$activity."', '".$ip."', '".$useragent."', '".$latitude."', '".$longitude."')"; 
   $queryupdatelog =$conn->query($updatelog); 
   
   if(!empty($tokendevice)){
   
   $updatetoken = "UPDATE masteruser SET tokendevice = '".$tokendevice."' WHERE id = '" .$iduser. "' "; 
   $queryupdatetoken =$conn->query($updatetoken); 
   }
 }
 
 else{
   $activity = "salah password android";
$json = array(
       'result' => 'salah password',
       'item' => $item
       );
       
echo json_encode($json); 
   
   $updatelogsalahpass = "INSERT INTO log (iduser, tanggal, jam, activity, ip, userdevice, latitude, longitude) VALUE ('".$username."', '".$tanggal."', '".$jam."', '".$activity."', '".$ip."', '".$useragent."', '".$latitude."', '".$longitude."')"; 
   $queryupdatelogsalahpass =$conn->query($updatelogsalahpass);
 
 }
 
 
}

?>