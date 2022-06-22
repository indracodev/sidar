<?php 
include "../config.php";
session_start();

$ntelat = addslashes($_POST['nocuti']);
$userid = addslashes($_POST['userid']);
date_default_timezone_set('Asia/Jakarta');
$datetimee = date('Y-m-d');
$jam = date('h:i:s');
$datetime = DateTime::createFromFormat('Y-m-d', $datetimee);
$namahari = $datetime->format('D');
$pecah = explode("/", $ntelat);
$iduser = $pecah[0];
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

$infouser = "SELECT * FROM masteruser WHERE id = '".$iduser."';";

$queryinfouser = $conn->query($infouser);
$arrayinfouser = mysqli_fetch_array($queryinfouser, MYSQLI_ASSOC);

$namae = strtolower($arrayinfouser['nama']);
$departement = $arrayinfouser['departemen'];
$bagian = $arrayinfouser['divisi'];
$unitusaha = $arrayinfouser['unitusaha'];
$ke1 = $arrayinfouser['ke'];
$ke2 = $arrayinfouser['ke2'];
$ke3 = $arrayinfouser['ke3'];
$ke4 = $arrayinfouser['ke4'];
$ke5 = $arrayinfouser['ke5'];

$infotelat = "SELECT * FROM formcuti WHERE nocuti = '".$ntelat."';";
$queryinfotelat = $conn->query($infotelat);
$arrayinfotelat = mysqli_fetch_array($queryinfotelat, MYSQLI_ASSOC);

$cutipadatanggal = $arrayinfotelat['cutipadatanggal'];
$cutisampaitanggal = $arrayinfotelat['cutisampaitanggal'];
$alasanya = $arrayinfotelat['alasan'];
$keatasan = $arrayinfotelat['ke1'];

$infonamatasan = "SELECT * FROM masteruser WHERE id = '".$keatasan."';";
$queryinfonamatasan = $conn->query($infonamatasan);
$arrayinfonamatasan = mysqli_fetch_array($queryinfonamatasan, MYSQLI_ASSOC);

$namatasan = $arrayinfonamatasan['nama'];
////////////////////////////////////////////////////////////////////////////////////////////


if(!empty($ke1)){
$infoke1 = "SELECT * FROM masteruser WHERE id = '".$ke1."' ;";
$queryinfoke1 = $conn->query($infoke1);
$arrayinfoke1 = mysqli_fetch_array($queryinfoke1, MYSQLI_ASSOC);
}

if(!empty($ke2)){
$infoke2 = "SELECT * FROM masteruser WHERE id = '".$ke2."' ;";
$queryinfoke2 = $conn->query($infoke2);
$arrayinfoke2 = mysqli_fetch_array($queryinfoke2, MYSQLI_ASSOC);
}

if(!empty($ke3)){
$infoke3 = "SELECT * FROM masteruser WHERE id = '".$ke3."' ;";
$queryinfoke3 = $conn->query($infoke3);
$arrayinfoke3 = mysqli_fetch_array($queryinfoke3, MYSQLI_ASSOC);
}

if(!empty($ke4)){
$infoke4 = "SELECT * FROM masteruser WHERE id = '".$ke4."' ;";
$queryinfoke4 = $conn->query($infoke4);
$arrayinfoke4 = mysqli_fetch_array($queryinfoke4, MYSQLI_ASSOC);
}

if(!empty($ke5)){
$infoke5 = "SELECT * FROM masteruser WHERE id = '".$ke5."' ;";
$queryinfoke5 = $conn->query($infoke5);
$arrayinfoke5 = mysqli_fetch_array($queryinfoke5, MYSQLI_ASSOC);
}
 

if($userid != $userid && $userid != $keatasan && $userid != $ke1 &&  $userid != $ke2 && $userid != $ke3 && $userid != $ke4 && $userid != $ke5){
    

$json = array(
       'result' => 'iduser tidak sama',
      // 'item' => $item
       );
       
echo json_encode($json); 
return false;
}

else{

      $item[] = array(
       "nocuti"=>$ntelat,
       "nama"=>$namae,
       "unitusaha"=>$unitusaha,
       "departement"=>$departement,
       "bagian"=>$bagian,
       "ke1"=>$ke1,
       "cutipadatanggal"=>$cutipadatanggal,
       "cutisampaitanggal"=>$cutisampaitanggal,
       "namatasan"=>$namatasan,
       "alasan"=>$alasanya,
      );   

$acceptabsence = "UPDATE formcuti SET menyetujuiatasan='Setuju' WHERE nocuti='".$ntelat."' ";       

if ($conn->query($acceptabsence) === TRUE) {

   $updatelogsalahpass = "INSERT INTO formcutisetuju (nocuti, tanggal, jam, iduseryangsetuju, ip, userdevice, status) VALUE ('".$ntelat."', '".$datetimee."', '".$jam."', '".$userid."', '".$ip."', '".$useragent."', 'Setuju')"; 
   $queryupdatelogsalahpass =$conn->query($updatelogsalahpass);    
    
} 
    

   
   $json = array(
       'result' => 'success',
      // 'item' => $item
       );
       

  echo json_encode($json);    
   
}

?>