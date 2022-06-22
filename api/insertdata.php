<?php 
include "../config.php";

$IUser = $_POST['iduser'];
$activityfirst = $_POST['activity'];
$planningfirst = $_POST['planning'];
$resultfirst = $_POST['result'];
$activity = addslashes($activityfirst);
$planning = addslashes($planningfirst);
$result = addslashes($resultfirst);
$KEuser = $_POST["keuser"];
$KEuser2 = $_POST["kedua"];
$KEuser3 = $_POST["ketiga"];
$KEuser4 = $_POST["keempat"];
$KEuser5 = $_POST["kelima"];
$jabatan =  $_POST["jabatan"];
$Nodar = $_POST['nodar'];
$tanggaldar = $_POST['tanggaldar'];
//$tags = $_POST['tags'];

$pecah = explode("/", $Nodar);
$hasil = $pecah[1] + 1;
$Nodar = $IUser."/".$hasil;

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

$ststgldar = new DateTime($tanggaldar);
$ststgldar->modify('+1 day');

$tglterakhirdar = $ststgldar->format('Y-m-d'); 

$pecahtgldar = explode("-", $tglterakhirdar);
$haritgl = $pecahtgldar[0];
$bulantgl = $pecahtgldar[1];
$tahuntgl = $pecahtgldar[2];
$tgldarnya = $tahuntgl."-".$bulantgl."-".$haritgl;

$ambilnoabsensi = "SELECT noabsensi FROM absenluarkota WHERE tglsubmit = '" .$tglterakhirdar . "' AND iduser =  '" .$IUser . "' ORDER BY idabsen DESC LIMIT 2;";

$querynoabsensi =$conn->query($ambilnoabsensi);
$arraynoabsensi = mysqli_fetch_all($querynoabsensi, MYSQLI_ASSOC);
$noabsensisatu = $arraynoabsensi[0]['noabsensi'];
$noabsensidua = $arraynoabsensi[1]['noabsensi'];
if(empty($noabsensidua)){
$noabsensi = $noabsensisatu.'|';    
}else{
$noabsensi = $noabsensisatu .'|'.$noabsensidua;  
}
$tags = $noabsensi;

    
date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');
$tanggaldate = date('d-m-Y');
$jam = date('H:i:s');


$tanggal1 = new DateTime($tglterakhirdar);
$tanggal2 = new DateTime($tanggaldate);
$tanggaldiff = date_diff($tanggal1,$tanggal2);
$perbedaan = $tanggaldiff->format("%a%");

 
if($jabatan == "staff" && $perbedaan == 0){
$timemalam = "23:59:00";
$timetujuh = "09:01:00";
$ThatTime ="19:00:00";


$late2start = "00:01:00";
$late2end = "16:00:00";

if ($jabatan == "staff" && date('H:i:s') <= date('H:i:s', strtotime($ThatTime))) {
  $status = "ontime";

} elseif($jabatan == "staff" &&  date('H:i:s') <= date('H:i:s', strtotime($timemalam)) && date('H:i:s') > date('H:i:s', strtotime($ThatTime)) ){
     $status = "late";
} 
}

if($jabatan == "staff" && $perbedaan == 1){
$timemalam = "23:59:00";
$timetujuh = "09:01:00";
$ThatTime ="19:00:00";


$late2start = "00:01:00";
$late2end = "06:00:00";

if($jabatan == "staff" &&  $perbedaan == 1 && date('H:i:s') <= date('H:i:s', strtotime($late2end)) && date('H:i:s') > date('H:i:s', strtotime($late2start)) ){
     $status = "late";
}
elseif($jabatan == "staff" &&  $perbedaan == 1 && date('H:i:s') > date('H:i:s', strtotime($late2end)) && date('H:i:s') > date('H:i:s', strtotime($late2start)) ){
     $status = "over";
}

}

if($jabatan == "staff" && $perbedaan > 1) {
  $status = "over";
    
}else{
    
}


 
if($jabatan == "supervisor" && $perbedaan == 0){
$timemalam = "23:59:00";
$timedelapan = "20:01:00";
$late2endmn = "16:00:00";
$ThatTimes ="20:00:00";
if ($jabatan == "supervisor" && date('H:i:s') <= date('H:i:s', strtotime($ThatTimes))) {
  $status = "ontime";
  
} elseif($jabatan == "supervisor" &&  date('H:i:s') <= date('H:i:s', strtotime($timemalam)) && date('H:i:s') > date('H:i:s', strtotime($ThatTimes)) ){
     $status = "late";
} 

}

if($jabatan == "supervisor" && $perbedaan == 1){
$timemalam = "23:59:00";
$timedelapan = "20:01:00";
$late2endmn = "06:00:00";
$ThatTimes ="20:00:00";
if($jabatan == "supervisor" && date('H:i:s') <= date('H:i:s', strtotime($late2endmn)))  {
  $status = "late";
    
}elseif($jabatan == "supervisor" && date('H:i:s') > date('H:i:s', strtotime($late2endmn)) ){
     $status = "over";
}
}


if($jabatan == "supervisor" && $perbedaan > 1) {
  $status = "over";
    
}else{
    
}


 
if($perbedaan == 0 && $jabatan == "manager" || $jabatan == "rspm" || $jabatan == "RSPM" || $jabatan == "NOM" || $jabatan == "NPM"){
$timesembilan = "23:01:00";    
$timemalama = "22:00:00";
$ThatTimema ="16:00:00";
$zxz = "ifmanager";

$late2startm = "00:01:00";
$late2endm = "16:00:00";

if ($perbedaan == 0 && date('H:i:s') <= date('H:i:s', strtotime($timemalama)) && $jabatan == "manager" || $jabatan == "rspm" || $jabatan == "RSPM" || $jabatan == "NOM" || $jabatan == "NPM") {
  $status = "ontime";

 }elseif($perbedaan == 0 && date('H:i:s') > date('H:i:s', strtotime($timemalama)) && date('H:i:s') > date('H:i:s', strtotime($ThatTimema)) && $jabatan == "manager" || $jabatan == "rspm" || $jabatan == "RSPM" || $jabatan == "NOM" || $jabatan == "NPM"){
     $status = "late";
} 

}


if($perbedaan == 1 && $jabatan == "manager" || $jabatan == "rspm" || $jabatan == "RSPM" || $jabatan == "NOM" || $jabatan == "NPM"){
$timesembilan = "23:01:00";    
$timemalama = "22:00:00";
$ThatTimema ="16:00:00";
$zxz = "ifmanager";

$late2startm = "00:01:00";
$late2endm = "06:00:00";

if($perbedaan == 1 && date('H:i:s') < date('H:i:s', strtotime($late2endm)) && $jabatan == "manager" || $jabatan == "rspm" || $jabatan == "RSPM" ||  $jabatan == "NOM" || $jabatan == "NPM" ) {
  $status = "late";
    
}

elseif($perbedaan == 1 && date('H:i:s') > date('H:i:s', strtotime($late2endm)) && $jabatan == "manager" || $jabatan == "rspm" || $jabatan == "RSPM" || $jabatan == "NOM" || $jabatan == "NPM") {
  $status = "over";

}

}



if($perbedaan > 1 && $jabatan == "manager" || $jabatan == "rspm" || $jabatan == "RSPM" || $jabatan == "NOM" || $jabatan == "NPM") {
  $status = "over";

}else{
    
}




if($perbedaan == 0 && $jabatan == "direktur" || $jabatan == "DIREKTUR"){
$timesembilan = "23:01:00";    
$timemalam = "23:59:00";
$ThatTimem ="23:59:50";

$late2end = "16:00:00";

if ($jabatan == "direktur" || $jabatan == "DIREKTUR" && date('H:i:s') <= date('H:i:s', strtotime($ThatTimem))) {
  $status = "ontime";

} elseif($jabatan == "direktur" || $jabatan == "DIREKTUR" &&  date('H:i:s') <= date('H:i:s', strtotime($timemalam)) && date('H:i:s') > date('H:i:s', strtotime($ThatTimem)) ){
     $status = "ontime";
} 

    
}

if($perbedaan == 1 && $jabatan == "direktur" || $jabatan == "DIREKTUR"){
$timesembilan = "23:01:00";    
$timemalam = "23:59:00";
$ThatTimem ="23:59:50";

$late2end = "06:00:00";

if($perbedaan == 1 && date('H:i:s') < date('H:i:s', strtotime($late2end)) && $jabatan == "direktur" || $jabatan == "DIREKTUR" && date('H:i:s') <= date('H:i:s', strtotime($late2end))) {
  $status = "late";
    
}

elseif($perbedaan == 1 && date('H:i:s') > date('H:i:s', strtotime($late2end)) && $jabatan == "direktur" || $jabatan == "DIREKTUR"   && date('H:i:s') >= date('H:i:s', strtotime($late2end))) {
  $status = "over";

}

    
}


if($perbedaan > 1 && $jabatan == "direktur" || $jabatan == "DIREKTUR"   && date('H:i:s') >= date('H:i:s', strtotime($late2end))) {
  $status = "over";

}else{
    
}

	
$sudahbaca;    
    
$query .= "INSERT INTO dar (nodar ,iduser, ke, ke2, ke3, ke4, ke5, status, tanggal, jam, plan ,activity, result, tag, tanggaldar, sudahbaca) VALUES ('".$Nodar."', '".$IUser."', '".$KEuser."', '".$KEuser2."', '".$KEuser3."', '".$KEuser4."', '".$KEuser5."', '".$status."', '".$tanggal."', '".$jam."', '".$planning."', '".$activity."',  '".$result."', '".$tags."', '".$tglterakhirdar."', '".$sudahbaca."')";  
			
 $latitude = '-';
$latitude = '-';
$act = 'kirim dar android';
$updatelog = "INSERT INTO log (iduser, tanggal, jam, activity, ip, userdevice,latitude, longitude) VALUE ('".$IUser."', '".$tanggal."', '".$jam."', '".$act."', '".$ip."', '".$useragent."', '".$latitude."', '".$longitude."')"; 
$queryupdatelog = $conn->query($updatelog); 
       

if ($conn->query($query) === TRUE) {


$kosongdraft .= "UPDATE draft SET activity='', result='', plan='', tag='' WHERE iduser='".$IUser."' ";
    
if ($conn->query($kosongdraft) === TRUE) {
    

}


$sudahkirim .= "UPDATE masteruser SET sudahkirim='sudah' WHERE id='".$IUser."' ";
    
    
if($perbedaan == 0){    
if ($conn->query($sudahkirim) === TRUE) {
    
echo '<script>
	alert(" DAR Berhasil Dikirim ");
	window.location.assign("report.php"); 
</script>' ;
}
}else{
    echo '<script>
	alert(" DAR Berhasil Dikirim ");
	window.location.assign("report.php");
</script>' ;
}


} else{
    // Jika Gagal, Lakukan :
   echo date('H:i:s', strtotime($ThatTime));
  echo "<br>";
  echo $status;
  echo "<br>";
  echo $jabatan;
  echo "<br>";
  echo $KEuser;
  echo "<br>";
  echo $KEuser2;
  echo "<br>";
  echo $KEuser3;
  echo "<br>";
  echo $KEuser4;
  echo "<br>";
  echo $KEuser5;
  echo "<br>";
  echo $perbedaan;
  echo "<br>";
  echo $IUser; 
  echo "<br>";
  echo $KEuser;
  echo "<br>";
  echo $status;
  echo "<br>";
  echo $tgldarnya;
  echo "<br>";
  echo $tanggal;
  echo "<br>";
  echo $jam;
  echo "<br>";
  echo $planning;
  echo "<br>";
  echo $activity;
  echo "<br>";
  echo $result;
  echo "<br>";
  echo $tags;
  echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database";

  }


?>