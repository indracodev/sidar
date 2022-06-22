<?php
session_start();
include "config.php";

setcookie('IDUser', '');
   setcookie('Jabatan', '');
   setcookie('NMUser', '');
   setcookie('Pass', '');
   setcookie('Unitusaha', '');
   setcookie('Level', '');
   setcookie('Ke', '');
   setcookie('Ke2', '');
   setcookie('Ke3', '');
   setcookie('Ke4', '');
   setcookie('Ke5', '');

$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;

//$nodar =  $_SESSION["Nodar"] ;
//$pecah = explode("/", $nodar);
//$hasil = $pecah[1] + 1;
//$nodarnya = $iduser."/".$hasil;

date_default_timezone_set('Asia/Jakarta');
$tglhariini = date('Y-m-d');
$jam = date('H:i');


$tahun = date('Y');

$tglstartjanuari = $tahun . '-' . '01' . '-' . '01';
$tglstartfebruari = $tahun . '-' . '02' . '-' . '01';
$tglstartmaret = $tahun . '-' . '03' . '-' . '01';
$tglstartapril = $tahun . '-' . '04' . '-' . '01';
$tglstartmei = $tahun . '-' . '05' . '-' . '01';
$tglstartjuni = $tahun . '-' . '06' . '-' . '01';
$tglstartjuli = $tahun . '-' . '07' . '-' . '01';
$tglstartagustus = $tahun . '-' . '08' . '-' . '01';
$tglstartseptember = $tahun . '-' . '09' . '-' . '01';
$tglstartoktober = $tahun . '-' . '10' . '-' . '01';
$tglstartnovember = $tahun . '-' . '11' . '-' . '01';
$tglstartdesember = $tahun . '-' . '12' . '-' . '01';
$tglastjanuari = new DateTime($tglstartjanuari);
$tglastjanuari->modify('last day of this month');
$tglastfebruari = new DateTime($tglstartfebruari);
$tglastfebruari->modify('last day of this month');
$tglastmaret = new DateTime($tglstartmaret);
$tglastmaret->modify('last day of this month');
$tglastapril = new DateTime($tglstartapril);
$tglastapril->modify('last day of this month');
$tglastmei = new DateTime($tglstartmei);
$tglastmei->modify('last day of this month');
$tglastjuni = new DateTime($tglstartjuni);
$tglastjuni->modify('last day of this month');
$tglastjuli = new DateTime($tglstartjuli);
$tglastjuli->modify('last day of this month');
$tglastagustus = new DateTime($tglstartagustus);
$tglastagustus->modify('last day of this month');
$tglastseptember = new DateTime($tglstartseptember);
$tglastseptember->modify('last day of this month');
$tglastoktober = new DateTime($tglstartoktober);
$tglastoktober->modify('last day of this month');
$tglastnovember = new DateTime($tglstartnovember);
$tglastnovember->modify('last day of this month');
$tglastdesember = new DateTime($tglstartdesember);
$tglastdesember->modify('last day of this month');

$monthNum  = date('m');
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
$namabulan = $dateObj->format('F'); // March

$infomuser = "SELECT * FROM masteruser WHERE (id='".$iduser."' OR ke='".$iduser."' OR ke2='".$iduser."' OR ke3='".$iduser."' OR ke4='".$iduser."' OR ke5='".$iduser."') ;";
$queryuser = $conn->query($infomuser);
$arraymuser = mysqli_fetch_all($queryuser, MYSQLI_ASSOC);
$jumlahmuser = sizeof($arraymuser);

if($_SESSION["IDUser"] == 0){
header("Location: http://sidar.id/login");
    }
    
elseif($_SESSION["Level"] != "admin"){
 
 $zzz = "1";
 
 $infodar = "";
$querydar = "";
$arrayrdar = "";

   
$infodar = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar = '".$tglhariini."' AND dar.iduser='".$iduser."' ORDER BY dar.tanggaldar DESC";
$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);

    
}


elseif ($_SESSION["Level"] == "admin"){

$zzz = "3";
$infodar = "";
$querydar = "";
$arrayrdar = "";


$infodar = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar = '".$tglhariini."' AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);


} 



else {

$zzz = "5";    
    
}

$varontime = 0;
$varlatesatu = 0;
$varlatedua = 0;
$varover = 0;
$nodata = 0;


if (sizeof($arrayrdar) == 0){
 $nodata = $jumlahmuser;
    

}else {
    
      for($x = 0; $x < sizeof($arrayrdar); $x++){
          
             $status = $arrayrdar[$x]["status"];
          
                      if ($status == "ontime"){
               $varontime++;
               $jumlahmuser--;
                      }elseif($status == "late1"){
           $varlatesatu++;
            $jumlahmuser--;
                      }elseif($status == "late2"){
         $varlatedua++;
          $jumlahmuser--;
                      }else{
            $varover++;   
             $jumlahmuser--;
                      }
   }
    
    
}

 $ambilstatus = "SELECT * FROM masteruser 
   WHERE id = '" .$iduser. "' ;";
   $queryambilstatus =$conn->query($ambilstatus);
 if($queryambilstatus->num_rows){
   session_start();
 $rowambilstatus = mysqli_fetch_array($queryambilstatus, MYSQLI_ASSOC);
 $statuskirim = $rowambilstatus['sudahkirim'];
 
 if($statuskirim == "sudah"){
     
     $display = "display:none;";
     
 }else{
     
 }


 }
 else{
    // header("location: http://www.icg.id/beta/dar/login");
   echo " gak dapat status ";
 }



 $ambilnomer = "SELECT nodar FROM dar 
   WHERE iduser = '" .$iduser. "' ORDER BY urid DESC LIMIT 1 ;";
   $queryambilnomer =$conn->query($ambilnomer);
 if($queryambilnomer->num_rows){
   session_start();
 $rowambilnomer = mysqli_fetch_array($queryambilnomer, MYSQLI_ASSOC);
 $nodar = $rowambilnomer['nodar'];
 
 $pecah = explode("/", $nodar);
$hasil = $pecah[1] + 1;
$nodarnya = $iduser."/".$hasil;

 }
 else{
    // header("location: http://www.icg.id/beta/dar/login");
//   echo " gak dapat nomer ";
 }


 $ambiltgldarakhir = "SELECT tanggal FROM dar ORDER BY urid DESC LIMIT 1 ;";
   $queryambiltglakhir =$conn->query($ambiltgldarakhir);
 if($queryambiltglakhir->num_rows){
   session_start();
 $rowambiltgldarakhir = mysqli_fetch_array($queryambiltglakhir, MYSQLI_ASSOC);
 $tgldarterakhir = $rowambiltgldarakhir['tanggal'];
 

 }
 else{
    // header("location: http://www.icg.id/beta/dar/login");
  // echo " gak dapat nomer ";
 }



$ambildraft = "SELECT * FROM draft 
 WHERE iduser = '" .$iduser . "';";
 $querydraft =$conn->query($ambildraft);
 if($querydraft->num_rows){
   session_start();
   $row = mysqli_fetch_array($querydraft, MYSQLI_ASSOC);
   $draftactivity = $row['activity'];
   $draftplan = $row['plan'];
   $drafttag = $row['tag'];

 }
 else{
    // header("location: http://www.icg.id/beta/dar/login");
   echo " gak dapat draft ";
 }
 
 
 


$datetime = DateTime::createFromFormat('Y-m-d', $tglhariini);
$namahari = $datetime->format('D');

if ($tglhariini == $tgldarterakhir){
$stts = "v";
 

} elseif ($tglhariini != $tgldarterakhir){
 $stts = "w";
 
if ($namahari == "Sat" && $jam >= "13:00"){
$stts = "x";

$belumkirim .= "UPDATE masteruser SET sudahkirim='belum' ";      
if ($conn->query($belumkirim) === TRUE) {
}else{
    
}    


 
}elseif ($namahari != "Sat" && $jam >= "16:00"){
    $stts = "y";
$belumkirim .= "UPDATE masteruser SET sudahkirim='belum' ";      
if ($conn->query($belumkirim) === TRUE) {
}else{
    
}   
    
    
}

}else{
    $stts = "z";
}

//echo $namahari;
//echo "<br>";

if($namahari == "Mon"){
    
    if ($_SESSION["Level"] == "admin" || $_COOKIE["Level"] == "admin"){

$zzz = "monadmin";
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;


$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar = '".$tglhariini."' AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";

$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);


} else {
    
     $zzz = "monuser";
 
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;
   
$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar = '".$tglhariini."' AND dar.iduser='".$iduser."' ORDER BY dar.tanggaldar DESC";
$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);

}

    
}elseif ($namahari == "Tue") {
    
    $tglstart = date('Y-m-d',strtotime("-1 days"));
    
          if ($_SESSION["Level"] == "admin" || $_COOKIE['Level'] == "admin"){

$zzz = "tueadmin";
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;

$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglhariini."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";

$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);


} else {
    
     $zzz = "tueuser";
 
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;
   
$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglhariini."' AS DATE) AND dar.iduser='".$iduser."' ORDER BY dar.tanggaldar DESC";
$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);

    
}

    
    
}elseif ($namahari == "Wed") {
    
    $tglstart = date('Y-m-d',strtotime("-2 days"));
    
        if ($_SESSION["Level"] == "admin" || $_SESSION['Level'] == "admin"){

$zzz = "wedadmin";
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;

$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglhariini."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";

$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);


} else {
    
     $zzz = "weduser";
 
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;
   
$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglhariini."' AS DATE) AND dar.iduser='".$iduser."' ORDER BY dar.tanggaldar DESC";
$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);

    
}

    
    
}elseif ($namahari == "Thu") {
    
    $tglstart = date('Y-m-d',strtotime("-3 days"));
    
        if ($_SESSION["Level"] == "admin" || $_SESSION['Level'] == "admin"){

$zzz = "thuadmin";
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;

$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglhariini."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";

$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);


} else {
    
     $zzz = "thuuser";
 
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;
   
$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglhariini."' AS DATE) AND dar.iduser='".$iduser."' ORDER BY dar.tanggaldar DESC";
$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);

    
}

    
}elseif ($namahari == "Fri") {
    
    $tglstart = date('Y-m-d',strtotime("-4 days"));
    
        if ($_SESSION["Level"] == "admin" || $_SESSION['Level'] == "admin"){

$zzz = "friadmin";
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;

$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglhariini."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";

$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);


} else {
    
     $zzz = "friuser";
 
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;
   
$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglhariini."' AS DATE) AND dar.iduser='".$iduser."' ORDER BY dar.tanggaldar DESC";
$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);

    
}

    
}elseif ($namahari == "Sat") {
 
 $tglstart = date('Y-m-d',strtotime("-5 days"));
 
    if ($_SESSION["Level"] == "admin" || $_SESSION['Level'] == "admin"){

$zzz = "satadmin";
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";


//echo $zzz;

$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglhariini."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";

$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);



} else {
    
     $zzz = "satuser";
 
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;
   
$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglhariini."' AS DATE) AND dar.iduser='".$iduser."' ORDER BY dar.tanggaldar DESC";
$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);

    
}

    
}

$varontimemon = 0;
$varontimetue = 0;
$varontimewed = 0;
$varontimethu = 0;
$varontimefri = 0;
$varontimesat = 0;

$varlatesatumon = 0;
$varlatesatutue = 0;
$varlatesatuwed = 0;
$varlatesatuthu = 0;
$varlatesatufri = 0;
$varlatesatusat = 0;

$varlateduamon = 0;
$varlateduatue = 0;
$varlateduawed = 0;
$varlateduathu = 0;
$varlateduafri = 0;
$varlateduasat = 0;

$varovermon = 0;
$varovertue = 0;
$varoverwed = 0;
$varoverthu = 0;
$varoverfri = 0;
$varoversat = 0;


for($x = 0; $x < sizeof($arrayrdarhari); $x++){
          
             $status = $arrayrdarhari[$x]["status"];
             $tgldar = $arrayrdarhari[$x]["tanggaldar"];
             
$datetime = DateTime::createFromFormat('Y-m-d', $tgldar);
$namehari = $datetime->format('D');

                      if ($status == "ontime" && $namehari == "Mon"){
               $varontimemon++;
                      }elseif($status == "late1" && $namehari == "Mon"){
           $varlatesatumon++;
                      }elseif($status == "late2" && $namehari == "Mon"){
         $varlateduamon++;
                      }elseif($status == "over" && $namehari == "Mon"){
            $varovermon++;     
                      }elseif($status == "ontime" && $namehari == "Tue"){
           $varontimetue++;
                      }elseif($status == "late1" && $namehari == "Tue"){
           $varlatesatutue++;
                      }elseif($status == "late2" && $namehari == "Tue"){
         $varlateduatue++;
                      }elseif($status == "over" && $namehari == "Tue"){
            $varovertue++;     
                      }elseif($status == "ontime" && $namehari == "Wed"){
           $varontimewed++;
                      }elseif($status == "late1" && $namehari == "Wed"){
           $varlatesatuwed++;
                      }elseif($status == "late2" && $namehari == "Wed"){
         $varlateduawedd++;
                      }elseif($status == "over" && $namehari == "Wed"){
            $varoverwed++;     
                      }elseif($status == "ontime" && $namehari == "Thu"){
           $varontimethu++;
                      }elseif($status == "late1" && $namehari == "Thu"){
           $varlatesatuthu++;
                      }elseif($status == "late2" && $namehari == "Thu"){
         $varlateduathu++;
                      }elseif($status == "over" && $namehari == "Thu"){
            $varoverthu++;     
                      }elseif($status == "ontime" && $namehari == "Fri"){
           $varontimefri++;
                      }elseif($status == "late1" && $namehari == "Fri"){
           $varlatesatufri++;
                      }elseif($status == "late2" && $namehari == "Fri"){
         $varlateduafri++;
                      }elseif($status == "over" && $namehari == "Fri"){
            $varoverfri++;     
                      }elseif($status == "ontime" && $namehari == "Sat"){
           $varontimesat++;
                      }elseif($status == "late1" && $namehari == "Sat"){
           $varlatesatusat++;
                      }elseif($status == "late2" && $namehari == "Sat"){
         $varlateduasat++;
                      }elseif($status == "over" && $namehari == "Sat"){
            $varoversat++;     
                      }
                      
                      
   }



$datestartjanuari = new DateTime($tahun . '-' . '01' . '-' . '01');
$tglstartjanuari = $datestartjanuari->format('Y-m-d');
$datestartfebruari = new DateTime($tahun . '-' . '02' . '-' . '01');
$tglstartfebruari = $datestartfebruari->format('Y-m-d');
$tglstartmaret = new DateTime($tahun . '-' . '03' . '-' . '01');
$tglstartmaret = $tglstartmaret->format('Y-m-d');
$tglstartapril = new DateTime($tahun . '-' . '04' . '-' . '01');
$tglstartapril = $tglstartapril->format('Y-m-d');
$tglstartmei = new DateTime($tahun . '-' . '05' . '-' . '01');
$tglstartmei = $tglstartmei->format('Y-m-d');
$tglstartjuni = new DateTime($tahun . '-' . '06' . '-' . '01');
$tglstartjuni = $tglstartjuni->format('Y-m-d');
$tglstartjuli = new DateTime($tahun . '-' . '07' . '-' . '01');
$tglstartjuli = $tglstartjuli->format('Y-m-d');
$tglstartagustus = new DateTime($tahun . '-' . '08' . '-' . '01');
$tglstartagustus = $tglstartagustus->format('Y-m-d');
$tglstartseptember = new DateTime($tahun . '-' . '09' . '-' . '01');
$tglstartseptember = $tglstartseptember->format('Y-m-d');
$tglstartoktober = new DateTime($tahun . '-' . '10' . '-' . '01');
$tglstartoktober = $tglstartoktober->format('Y-m-d');
$tglstartnovember = new DateTime($tahun . '-' . '11' . '-' . '01');
$tglstartnovember = $tglstartnovember->format('Y-m-d');
$tglstartdesember = new DateTime($tahun . '-' . '12' . '-' . '01');
$tglstartdesember = $tglstartdesember->format('Y-m-d');
$tglastjanuari = new DateTime($tglstartjanuari);
$tglastjanuari->modify('last day of this month');
$tglastjanuari = $tglastjanuari->format('Y-m-d');
$tglastfebruari = new DateTime($tglstartfebruari);
$tglastfebruari->modify('last day of this month');
$tglastfebruari = $tglastfebruari->format('Y-m-d');
$tglastmaret = new DateTime($tglstartmaret);
$tglastmaret->modify('last day of this month');
$tglastmaret = $tglastmaret->format('Y-m-d');
$tglastapril = new DateTime($tglstartapril);
$tglastapril->modify('last day of this month');
$tglastapril = $tglastapril->format('Y-m-d');
$tglastmei = new DateTime($tglstartmei);
$tglastmei->modify('last day of this month');
$tglastmei = $tglastmei->format('Y-m-d');
$tglastjuni = new DateTime($tglstartjuni);
$tglastjuni->modify('last day of this month');
$tglastjuni = $tglastjuni->format('Y-m-d');
$tglastjuli = new DateTime($tglstartjuli);
$tglastjuli->modify('last day of this month');
$tglastjuli = $tglastjuli->format('Y-m-d');
$tglastagustus = new DateTime($tglstartagustus);
$tglastagustus->modify('last day of this month');
$tglastagustus = $tglastagustus->format('Y-m-d');
$tglastseptember = new DateTime($tglstartseptember);
$tglastseptember->modify('last day of this month');
$tglastseptember = $tglastseptember->format('Y-m-d');
$tglastoktober = new DateTime($tglstartoktober);
$tglastoktober->modify('last day of this month');
$tglastoktober = $tglastoktober->format('Y-m-d');
$tglastnovember = new DateTime($tglstartnovember);
$tglastnovember->modify('last day of this month');
$tglastnovember = $tglastnovember->format('Y-m-d');
$tglastdesember = new DateTime($tglstartdesember);
$tglastdesember->modify('last day of this month');
$tglastdesember = $tglastdesember->format('Y-m-d');



$infodarbulanjanuari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstartjanuari."' AS DATE) AND CAST('".$tglastjanuari."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";
$querydarbulanjanuari = $conn->query($infodarbulanjanuari);
$arrayrdarbulanjanuari = mysqli_fetch_all($querydarbulanjanuari, MYSQLI_ASSOC);


$infodarbulanfebruari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstartfebruari."' AS DATE) AND CAST('".$tglastfebruari."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";
$querydarbulanfebruari = $conn->query($infodarbulanfebruari);
$arrayrdarbulanfebruari = mysqli_fetch_all($querydarbulanfebruari, MYSQLI_ASSOC);


$infodarbulanmaret = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstartmaret."' AS DATE) AND CAST('".$tglastmaret."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";
$querydarbulanmaret = $conn->query($infodarbulanmaret);
$arrayrdarbulanmaret = mysqli_fetch_all($querydarbulanmaret, MYSQLI_ASSOC);


$infodarbulanapril = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstartapril."' AS DATE) AND CAST('".$tglastapril."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";
$querydarbulanapril = $conn->query($infodarbulanapril);
$arrayrdarbulanapril = mysqli_fetch_all($querydarbulanapril, MYSQLI_ASSOC);


$infodarbulanmei = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstartmei."' AS DATE) AND CAST('".$tglastmei."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";
$querydarbulanmei = $conn->query($infodarbulanmei);
$arrayrdarbulanmei = mysqli_fetch_all($querydarbulanmei, MYSQLI_ASSOC);


$infodarbulanjuni = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstartjuni."' AS DATE) AND CAST('".$tglastjuni."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";
$querydarbulanjuni = $conn->query($infodarbulanjuni);
$arrayrdarbulanjuni = mysqli_fetch_all($querydarbulanjuni, MYSQLI_ASSOC);


$infodarbulanjuli = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstartjuli."' AS DATE) AND CAST('".$tglastjuli."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";
$querydarbulanjuli = $conn->query($infodarbulanjuli);
$arrayrdarbulanjuli = mysqli_fetch_all($querydarbulanjuli, MYSQLI_ASSOC);


$infodarbulanagustus = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstartagustus."' AS DATE) AND CAST('".$tglastagustus."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";
$querydarbulanagustus = $conn->query($infodarbulanagustus);
$arrayrdarbulanagustus = mysqli_fetch_all($querydarbulanagustus, MYSQLI_ASSOC);


$infodarbulanseptember = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstartseptember."' AS DATE) AND CAST('".$tglastseptember."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";
$querydarbulanseptember = $conn->query($infodarbulanseptember);
$arrayrdarbulanseptember = mysqli_fetch_all($querydarbulanseptember, MYSQLI_ASSOC);


$infodarbulanoktober = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstartoktober."' AS DATE) AND CAST('".$tglastoktober."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";
$querydarbulanoktober = $conn->query($infodarbulanoktober);
$arrayrdarbulanoktober = mysqli_fetch_all($querydarbulanoktober, MYSQLI_ASSOC);


$infodarbulannovember = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstartnovember."' AS DATE) AND CAST('".$tglastnovember."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";
$querydarbulannovember = $conn->query($infodarbulannovember);
$arrayrdarbulannovember = mysqli_fetch_all($querydarbulannovember, MYSQLI_ASSOC);


$infodarbulandesember = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstartdesember."' AS DATE) AND CAST('".$tglastdesember."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";
$querydarbulandesember = $conn->query($infodarbulandesember);
$arrayrdarbulandesember = mysqli_fetch_all($querydarbulandesember, MYSQLI_ASSOC);




$varontimejan = 0;
$varontimefeb = 0;
$varontimemar = 0;
$varontimeapr = 0;
$varontimemei = 0;
$varontimejun = 0;
$varontimejul = 0;
$varontimeagu = 0;
$varontimesep = 0;
$varontimeokt = 0;
$varontimenov = 0;
$varontimedes = 0;


$varlatesatujan = 0;
$varlatesatufeb = 0;
$varlatesatumar = 0;
$varlatesatuapr = 0;
$varlatesatumei = 0;
$varlatesatujun = 0;
$varlatesatujul = 0;
$varlatesatuagu = 0;
$varlatesatusep = 0;
$varlatesatuokt = 0;
$varlatesatunov = 0;
$varlatesatudes = 0;


$varlateduajan = 0;
$varlateduafeb = 0;
$varlateduamar = 0;
$varlateduaapr = 0;
$varlateduamei = 0;
$varlateduajun = 0;
$varlateduajul = 0;
$varlateduaagu = 0;
$varlateduasep = 0;
$varlateduaokt = 0;
$varlateduanov = 0;
$varlateduades = 0;


$varoverjan = 0;
$varoverfeb = 0;
$varovermar = 0;
$varoverapr = 0;
$varovermei = 0;
$varoverjun = 0;
$varoverjul = 0;
$varoveragu = 0;
$varoversep = 0;
$varoverokt = 0;
$varovernov = 0;
$varoverdes = 0;

$varabsencejan = 0;
$varabsencefeb = 0;
$varabsencemar = 0;
$varabsenceapr = 0;
$varabsencemei = 0;
$varabsencejun = 0;
$varabsencejul = 0;
$varabsenceagu = 0;
$varabsencesep = 0;
$varabsenceokt = 0;
$varabsencenov = 0;
$varabsencedes = 0;



for($x = 0; $x < sizeof($arrayrdarbulanjanuari); $x++){
          
             $status = $arrayrdarbulanjanuari[$x]["status"];

                      if ($status == "ontime"){
               $varontimejan++;
                      }elseif($status == "late1"){
           $varlatesatujan++;
                      }elseif($status == "late2"){
         $varlateduajan++;
                      }elseif($status == "over"){
            $varoverjan++;     
                      }elseif($status == "absence"){
            $varabsencejan++;     
                      }
                      
                      
                      
   }

for($x = 0; $x < sizeof($arrayrdarbulanfebruari); $x++){
          
             $status = $arrayrdarbulanfebruari[$x]["status"];

                      if ($status == "ontime"){
               $varontimefeb++;
                      }elseif($status == "late1"){
           $varlatesatufeb++;
                      }elseif($status == "late2"){
         $varlateduafeb++;
                      }elseif($status == "over"){
            $varoverfeb++;     
                      }elseif($status == "absence"){
            $varabsencefeb++;     
                      }
                      
                      
   }

for($x = 0; $x < sizeof($arrayrdarbulanmaret); $x++){
          
             $status = $arrayrdarbulanmaret[$x]["status"];

                      if ($status == "ontime"){
               $varontimemar++;
                      }elseif($status == "late1"){
           $varlatesatumar++;
                      }elseif($status == "late2"){
         $varlateduamar++;
                      }elseif($status == "over"){
            $varovermar++;     
                      }elseif($status == "absence"){
            $varabsencemar++;     
                      }
                      
                      
   }

for($x = 0; $x < sizeof($arrayrdarbulanapril); $x++){
          
             $status = $arrayrdarbulanapril[$x]["status"];

                      if ($status == "ontime"){
               $varontimeapr++;
                      }elseif($status == "late1"){
           $varlatesatapr++;
                      }elseif($status == "late2"){
         $varlateduaapr++;
                      }elseif($status == "over"){
            $varoverapr++;     
                      }elseif($status == "absence"){
            $varabsenceapr++;     
                      }
                      
                      
   }


for($x = 0; $x < sizeof($arrayrdarbulanmei); $x++){
          
             $status = $arrayrdarbulanmei[$x]["status"];

                      if ($status == "ontime"){
               $varontimemei++;
                      }elseif($status == "late1"){
           $varlatesatumei++;
                      }elseif($status == "late2"){
         $varlateduamei++;
                      }elseif($status == "over"){
            $varovermei++;     
                      }elseif($status == "absence"){
            $varabsencemei++;     
                      }
                      
                      
   }



for($x = 0; $x < sizeof($arrayrdarbulanjuni); $x++){
          
             $status = $arrayrdarbulanjuni[$x]["status"];

                      if ($status == "ontime"){
               $varontimejuni++;
                      }elseif($status == "late1"){
           $varlatesatujuni++;
                      }elseif($status == "late2"){
         $varlateduajuni++;
                      }elseif($status == "over"){
            $varoverjuni++;     
                      }elseif($status == "absence"){
            $varabsencejuni++;     
                      }
                      
                      
                      
   }
   


for($x = 0; $x < sizeof($arrayrdarbulanjuli); $x++){
          
             $status = $arrayrdarbulanjuli[$x]["status"];

                      if ($status == "ontime"){
               $varontimejuli++;
                      }elseif($status == "late1"){
           $varlatesatujuli++;
                      }elseif($status == "late2"){
         $varlateduajuli++;
                      }elseif($status == "over"){
            $varoverjuli++;     
                      }elseif($status == "absence"){
            $varabsencejuli++;     
                      }
                      
                      
   }   


for($x = 0; $x < sizeof($arrayrdarbulanagustus); $x++){
          
             $status = $arrayrdarbulanagustus[$x]["status"];

                      if ($status == "ontime"){
               $varontimeagu++;
                      }elseif($status == "late1"){
           $varlatesatuagu++;
                      }elseif($status == "late2"){
         $varlateduaagu++;
                      }elseif($status == "over"){
            $varoveragu++;     
                      }elseif($status == "absence"){
            $varabsenceagu++;     
                      }
                      
                      
   }



for($x = 0; $x < sizeof($arrayrdarbulanseptember); $x++){
          
             $status = $arrayrdarbulanseptember[$x]["status"];

                      if ($status == "ontime"){
               $varontimesep++;
                      }elseif($status == "late1"){
           $varlatesatusep++;
                      }elseif($status == "late2"){
         $varlateduasep++;
                      }elseif($status == "over"){
            $varoversep++;     
                      }elseif($status == "absence"){
            $varabsencesep++;     
                      }
                      
                      
   }



for($x = 0; $x < sizeof($arrayrdarbulanoktober); $x++){
          
             $status = $arrayrdarbulanoktober[$x]["status"];

                      if ($status == "ontime"){
               $varontimeokt++;
                      }elseif($status == "late1"){
           $varlatesatuokt++;
                      }elseif($status == "late2"){
         $varlateduaokt++;
                      }elseif($status == "over"){
            $varoverokt++;     
                      }elseif($status == "absence"){
            $varabsenceokt++;     
                      }
                      
                      
   }
   
   
for($x = 0; $x < sizeof($arrayrdarbulannovember); $x++){
          
             $status = $arrayrdarbulannovember[$x]["status"];

                      if ($status == "ontime"){
               $varontimenov++;
                      }elseif($status == "late1"){
           $varlatesatunov++;
                      }elseif($status == "late2"){
         $varlateduanov++;
                      }elseif($status == "over"){
            $varovernov++;     
                      }elseif($status == "absence"){
            $varabsencenov++;     
                      }
                      
                      
   }
   
   
for($x = 0; $x < sizeof($arrayrdarbulandesember); $x++){
          
             $status = $arrayrdarbulandesember[$x]["status"];

                      if ($status == "ontime"){
               $varontimedes++;
                      }elseif($status == "late1"){
           $varlatesatudes++;
                      }elseif($status == "late2"){
         $varlateduades++;
                      }elseif($status == "over"){
            $varoverdes++;     
                      }elseif($status == "absence"){
            $varabsencedes++;     
                      }
                      
                      
   }
   
   
if($namabulan == "January"){
    
}elseif($namabulan == "February"){
    
}elseif($namabulan == "March"){
    
}elseif($namabulan == "April"){
    
}elseif($namabulan == "May"){
    
}elseif($namabulan == "June"){
    
}elseif($namabulan == "July"){
    
}elseif($namabulan == "August"){
    
}elseif($namabulan == "September"){
    
}elseif($namabulan == "October"){
    
}elseif($namabulan == "November"){
    
}elseif($namabulan == "December"){
    
}else{
    
}
   
   

/*   
   echo $namehari;
echo "<br>";
echo $varontimemon ;
echo "<br>";
echo $varontimetue ;
echo "<br>";
echo $varontimewed ;
echo "<br>";
echo $varontimethu ;
echo "<br>";
echo $varontimefri ;
echo "<br>";
echo $varontimesat ;
echo "<br>";

echo $varlatesatumon ;
echo "<br>";
echo $varlatesatutue ;
echo "<br>";
echo $varlatesatuwed ;
echo "<br>";
echo $varlatesatuthu ;
echo "<br>";
echo $varlatesatufri ;
echo "<br>";
echo $varlatesatusat ;
echo "<br>";

echo $varlateduamon ;
echo "<br>";
echo $varlateduatue ;
echo "<br>";
echo $varlateduawed ;
echo "<br>";
echo $varlateduathu ;
echo "<br>";
echo $varlateduafri ;
echo "<br>";
echo $varlateduasat ;
echo "<br>";

echo $varovermon ;
echo "<br>";
echo $varovertue ;
echo "<br>";
echo $varoverwed ;
echo "<br>";
echo $varoverthu ;
echo "<br>";
echo $varoverfri ;
echo "<br>";
echo $varoversat ;
 
 
// $datareport = 3;
 
  */  
?>

<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>SIDAR</title>
	<link rel="stylesheet icon" href="img/ikon.png">
	<!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Font Awesome CSS -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="custom1.css">
    <!-- inner style -->
    <style type="text/css">
    	#dropCardHeader {
    		cursor: pointer;
    	}
    </style>
</head>
<body>

	<div class="wrapper">
		
		<!-- NAVBAR -->
		<?php include'navbar1.php';?>

		<!-- KONTEN -->
		<main class="konten">
			<a href="logoutt.php" id="untuklogout" >
			</a>
			<div class="diagram py-3">
				<div class="container-fluid">
					<div class="row">

						<div class="col-xl-8">
							<!-- AREA CART -->
							
							<!-- BAR CART -->
						
							<div class="card mb-3">
								<div class="card-header d-flex justify-content-between align-items-center">
									<h5 class="card-title m-0 text-uppercase font-weight-bold">performance per day</h5>
									<div class="dropdown">
                                        <div id="dropCardHeader" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-sort-down"></i>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropCardHeader">
                                            <a class="dropdown-item" href="#">Details</a>
                                           
                                        </div>
                                    </div>
								</div>
									<div class="card card-default pb-5">
									<div class="card-body" style="height: 300px;">
										<canvas id="bar3"></canvas>
										<div id='customLegend' class='customLegend'></div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xl-4">
                            <!-- PIE CART -->
                            <div class="card mb-3">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title m-0 text-uppercase font-weight-bold">Today Report</h5>
                                    <div class="dropdown">
                                        <div id="dropCardHeader" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-sort-down"></i>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropCardHeader">
                                            <a class="dropdown-item" href="#">Details <?php echo $varontimeapr ?></a>
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-pie mb-4">
                                        <canvas id="myPieChart" style="width: 300px; height: 300px;"></canvas>
                                    </div>
                                    <div class="keterangan text-center">
                                        <span class="mr-3">
                                            <i class="fa fa-circle" style="color: #28a745;"></i> <small>Ontime</small>
                                        </span>
                                        <span class="mr-3">
                                            <i class="fa fa-circle" style="color: #ffc107;"></i> <small>Late 1</small>
                                        </span>
                                         <span class="mr-3">
                                            <i class="fa fa-circle" style="color: orange;"></i> <small>Late 2</small>
                                        </span>
                                <br>
                                         <span class="mr-3">
                                            <i class="fa fa-circle" style="color: #dc3545;"></i> <small>Over</small>
                                        </span>
                                        <span class="mr-3">
                                            <i class="fa fa-circle" style="color: #ffffc;"></i> <small>No Data <?php?></small>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                          <div class="col-xl-8">
                         <!-- BAR CART -->
                            <div class="card mb-3">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title m-0 text-uppercase font-weight-bold">Statistic Per Month</h5>
                                    <div class="dropdown">
                                        <div id="dropCardHeader" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-sort-down"></i>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropCardHeader">
                                            <a class="dropdown-item" href="#">Details</a>
                                        </div>
                                    </div>
                                </div>
                                 <div class="card card-default pb-5">
                                    <div class="card-body" style="height: 400px;">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                    <div class="keterangan text-left" style="padding-left: 3.8rem;">
                                        <span class="mr-1">
                                            <i class="fa fa-circle" style="color:#27cc98;"></i> 
                                            <normal>Ontime</normal>
                                        </span>
                                        <span class="mr-1">
                                            <i class="fa fa-circle" style="color:#fefe1f;"></i> 
                                            <normal>Late1</normal>
                                        </span>
                                        <span class="mr-1">
                                            <i class="fa fa-circle" style="color:#fec416 "></i>
                                            <normal>Late2</normal>
                                        </span>
                                        <span class="mr-1">
                                            <i class="fa fa-circle" style="color:#cc0201 "></i>
                                            <normal>Over</normal>
                                        </span>
                                         <span class="mr-1">
                                            <i class="fa fa-circle" style="color:blue "></i>
                                            <normal>Absence</normal>
                                        </span>
                                    </div>
                                </div><!--card body-->
                            </div>
                        </div>
                        
						
					</div><!-- end row -->
				</div><!-- end container fluid -->
			</div><!-- end diagram -->

			<!-- FOOTER -->
			<?php include'footer.php';?>

		</main><!-- end konten -->
	</div><!-- end wrapper -->

	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- Custom JS -->
    <script>
            function myFunctionx() {
     
         document.getElementById("btncolaps").click();
         document.getElementById("btncolaps").style.visibility = "visible";
         document.getElementById("spancolaps").style.display = "block";
         document.getElementById("spancolaps1").style.display = "block";
         document.getElementById("spancolaps2").style.display = "block";    
        };

      function myFunction() {
          //  document.getElementById("btncolaps").style.visibility = "hidden";
         document.getElementById("spancolaps").style.display = "none";
         document.getElementById("spancolaps1").style.display = "none";
         document.getElementById("spancolaps2").style.display = "none";       
        };
     
    
    </script>
    
    
    <script>
        $(document).ready(function () {
	$('.tombolCollapseSidebarr').on('click', function () {
		$('.wrapper').toggleClass('geser');
		$('.sidebar').toggleClass('geser');
		$('.topbar').toggleClass('geser');
		$('.anti-scroll').toggleClass('geser');
		$('.konten').toggleClass('geser');
		$(this).toggleClass('geser');
	});
});
        
    </script>
    
    <script type="text/javascript" src="custom.js"></script>
  
   
    <!-- Plugin Diagram -->
    <script type="text/javascript" src="js/chart.min.js"></script>
<!--     <script type="text/javascript" src="js/linechart.js"></script> -->
   <!-- <script type="text/javascript" src="js/bar3.js"></script> -->
    <script type="text/javascript" src="js/bar-chart.js"></script>
    <script type="text/javascript" src="js/chart-bar-demo.js"></script>
  <!--  <script type="text/javascript" src="js/chart-pie-demo.js"></script> -->
 
 <script>
var ctx = document.getElementById('myChart').getContext("2d");
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Agt", "Spt", "Oct", "Nov", "Des"],
        datasets: [{
            label: "Ontime",
            borderColor: "rgb(41, 204, 151)",
            pointBorderColor: "rgb(41, 204, 151)",
            pointBackgroundColor: "rgb(41, 204, 151)",
            pointHoverBackgroundColor: "white",
            pointHoverBorderColor: "rgba(76, 132, 255,1)",
            pointBorderWidth: 4,
            pointHoverRadius: 5,
            pointHoverBorderWidth: 1,
            pointRadius: 3,
            fill: false,
            borderWidth: 4,
            data: [<?php echo $varontimejan; ?>, <?php echo $varontimefeb; ?>, <?php echo $varontimemar; ?>, <?php echo $varontimeapr; ?>, <?php echo $varontimemei; ?>, <?php echo $varontimejun; ?>, <?php echo $varontimejul; ?>, <?php echo $varontimeagu; ?>, <?php echo $varontimesep; ?>, <?php echo $varontimeokt; ?>, <?php echo $varontimenov; ?>, <?php echo $varontimedes; ?>]
        },{
            label: "Late1",
            borderColor: "rgb(255, 255, 0)",
            pointBorderColor: "rgb(255, 255, 0)",
            pointBackgroundColor: "rgb(255, 255, 0)",
            pointHoverBackgroundColor: "white",
            pointHoverBorderColor: "rgba(254, 196, 0,1)",
            pointBorderWidth: 4,
            pointHoverRadius: 5,
            pointHoverBorderWidth: 1,
            pointRadius: 3,
            fill: false,
            borderWidth: 4,
            data: [<?php echo $varlatesatujan; ?>, <?php echo $varlatesatufeb; ?>, <?php echo $varlatesatumar; ?>, <?php echo $varlatesatuapr; ?>, <?php echo $varlatesatumei; ?>, <?php echo $varlatesatujun; ?>, <?php echo $varlatesatujul; ?>, <?php echo $varlatesatuagu; ?>, <?php echo $varlatesatusep; ?>, <?php echo $varlatesatuokt; ?>, <?php echo $varlatesatunov; ?>, <?php echo $varlatesatudes; ?>]
        },{
            label: "Late2",
            borderColor: "rgb(254, 196, 0)",
            pointBorderColor: "rgb(254, 196, 0)",
            pointBackgroundColor: "rgb(254, 196, 0)",
            pointHoverBackgroundColor: "white",
            pointHoverBorderColor: "rgb(254, 196, 0)",
            pointBorderWidth: 4,
            pointHoverRadius: 5,
            pointHoverBorderWidth: 1,
            pointRadius: 3,
            fill: false,
            borderWidth: 4,
            data: [<?php echo $varlateduajan; ?>, <?php echo $varlateduafeb; ?>, <?php echo $varlateduamar; ?>, <?php echo $varlateduaapr; ?>, <?php echo $varlateduamei; ?>, <?php echo $varlateduajun; ?>, <?php echo $varlateduajul; ?>, <?php echo $varlateduaagu; ?>, <?php echo $varlateduasep; ?>, <?php echo $varlateduaokt; ?>, <?php echo $varlateduanov; ?>, <?php echo $varlateduades; ?>]
        },{
            label: "Over",
            borderColor: "rgb(204, 0 , 0 )",
            pointBorderColor: "rgb(204, 0 , 0 )",
            pointBackgroundColor: "rgb(204, 0 , 0 )",
            pointHoverBackgroundColor: "white",
            pointHoverBorderColor: "rgba(41, 204, 151,1)",
            pointBorderWidth: 4,
            pointHoverRadius: 5 ,
            pointHoverBorderWidth: 1,
            pointRadius: 3,
            fill: false,
            borderWidth: 4,
            data: [<?php echo $varoverjan; ?>, <?php echo $varoverfeb; ?>, <?php echo $varovermar; ?>, <?php echo $varoverapr; ?>, <?php echo $varovermei; ?>, <?php echo $varoverjun; ?>, <?php echo $varoverjul; ?>, <?php echo $varoveragu; ?>, <?php echo $varoversep; ?>, <?php echo $varoverokt; ?>, <?php echo $varovernov; ?>, <?php echo $varoverdes; ?>]
        
    },
    {
            label: "Absence",
            borderColor: "rgb(0, 0, 255)",
            pointBorderColor: "rgb(0, 0, 255)",
            pointBackgroundColor: "rgb(0, 0, 255)",
            pointHoverBackgroundColor: "white",
            pointHoverBorderColor: "rgba(0, 0, 255)",
            pointBorderWidth: 4,
            pointHoverRadius: 5 ,
            pointHoverBorderWidth: 1,
            pointRadius: 3,
            fill: false,
            borderWidth: 4,
            data: [<?php echo $varabsencejan; ?>, <?php echo $varabsencefeb; ?>, <?php echo $varabsencemar; ?>, <?php echo $varabsenceapr; ?>, <?php echo $varabsencemei; ?>, <?php echo $varabsencejun; ?>, <?php echo $varabsencejul; ?>, <?php echo $varabsenceagu; ?>, <?php echo $varabencesep; ?>, <?php echo $varabsenceokt; ?>, <?php echo $varabsencenov; ?>, <?php echo $varabsencedes; ?>]
        }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      legend: {
        display: false
      },
        scales: {
            yAxes: [{
                ticks: {
                    fontColor: "#8a909d",
                    fontFamily: "Roboto, sans-serif",
                    beginAtZero: true,
                    maxTicksLimit: 5,
                    padding: 20,
                    stepSize: 1,
                    max: 1520
                },
                gridLines: {
                    drawTicks: false,
                    display: true
                }

            }],
            xAxes: [{
                gridLines: {
                    zeroLineColor: "#e5e5e5"
                },
                ticks: {
                    padding: 20,
                    fontColor: "#8a909d",
                    fontFamily: "Roboto, sans-serif"
                }
            }]
        },
    }
});

      
  </script>
  
 
 
  <script>
      // Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Ontime", "Over", "Late1", "Late2", "NoData"],
    datasets: [{
      data: [<?php echo $varontime; ?>, <?php echo $varover; ?>, <?php echo $varlatesatu; ?>, <?php echo $varlatedua; ?>, <?php echo $jumlahmuser; ?> ], 
      backgroundColor: ['#28a745', '#dc3545', '#ffc107','orange','black'],
      hoverBackgroundColor: ['#28a745', '#dc3545', '#ffc107'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});
  </script>
  
  <script>
      
      /*======== 27. ACQUISITION3 ========*/
var acquisition3 = document.getElementById("bar3");
if (acquisition3 !== null) {
  var acChart3 = new Chart(acquisition3, {
    // The type of chart we want to create
    type: "bar",

    // The data for our dataset
    data: {
      labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
      datasets: [
        {
          label: "Ontime",
          backgroundColor: "#28a745",
          borderColor: "rgba(76, 132, 255,0)",
          data: [<?php echo $varontimemon; ?>, <?php echo $varontimetue; ?>, <?php echo $varontimewed; ?>, <?php echo $varontimethu; ?>, <?php echo $varontimefri; ?>, <?php echo $varontimesat; ?>],
          pointBackgroundColor: "rgba(76, 132, 255,0)",
          pointHoverBackgroundColor: "rgba(76, 132, 255,1)",
          pointHoverRadius: 3,
          pointHitRadius: 30
        },
        {
          label: "Late 1",
          backgroundColor: "#ffc107",
          borderColor: "rgba(254, 196, 0,0)",
          data: [<?php echo $varlatesatumon; ?>, <?php echo $varlatesatutue; ?>, <?php echo $varlatesatuwed; ?>, <?php echo $varlatesatuthu; ?>, <?php echo $varlatesatufri; ?>, <?php echo $varlatesatusat; ?>],
          pointBackgroundColor: "rgba(254, 196, 0,0)",
          pointHoverBackgroundColor: "rgba(254, 196, 0,1)",
          pointHoverRadius: 3,
          pointHitRadius: 30
        },
        {
          label: "Late 2",
          backgroundColor: "orange",
          borderColor: "rgba(41, 204, 151,0)",
          data: [<?php echo $varlateduamon; ?>, <?php echo $varlateduatue; ?>, <?php echo $varlateduawed; ?>, <?php echo $varlateduathu; ?>, <?php echo $varlateduafri; ?>, <?php echo $varlateduasat; ?>],
          pointBackgroundColor: "rgba(41, 204, 151,0)",
          pointHoverBackgroundColor: "rgba(41, 204, 151,1)",
          pointHoverRadius: 3,
          pointHitRadius: 30
        },
        {
          label: "Over",
          backgroundColor: "#dc3545",
          borderColor: "rgba(41, 204, 151,0)",
          data: [<?php echo $varovermon; ?>, <?php echo $varovertue; ?>, <?php echo $varoverwed; ?>, <?php echo $varoverthu; ?>, <?php echo $varoverfri; ?>, <?php echo $varoversat; ?>],
          pointBackgroundColor: "rgba(41, 204, 151,0)",
          pointHoverBackgroundColor: "rgba(41, 204, 151,1)",
          pointHoverRadius: 3,
          pointHitRadius: 30
        }
      ]
    },

    // Configuration options go here
    options: {
      responsive: true,
      maintainAspectRatio: false,
      legend: {
        display: false
      },
      scales: {
        xAxes: [
          {
            gridLines: {
              display: false
            }
          }
        ],
        yAxes: [
          {
            gridLines: {
              display: true
            },
            ticks: {
              beginAtZero: true,
              stepSize: 5,
              fontColor: "#8a909d",
              fontFamily: "Roboto, sans-serif",
              max: 55
            }
          }
        ]
      },
      tooltips: {}
    }
  });
  document.getElementById("customLegend").innerHTML = acChart3.generateLegend();
}
      
  </script>
  
      <script>
window.onload = function(){
   var link = document.getElementById('untuklogout');
   setInterval(function(){
    //   alert("Hello");
        link.click();
   }, 1800000);
};
    </script>
  
  
  
</body>
</html>