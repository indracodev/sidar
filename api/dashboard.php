<?
session_start();
include "../config.php";

$iduser = addslashes($_POST["iduser"]) ;
$level = addslashes($_POST["level"]) ;


//$nodar =  $_SESSION["Nodar"] ;
//$pecah = explode("/", $nodar);
//$hasil = $pecah[1] + 1;
//$nodarnya = $iduser."/".$hasil;

date_default_timezone_set('Asia/Jakarta');
$tglhariini = date('Y-m-d');
$jam = date('H:i');
$kemarintgldar = new DateTime($tglhariini);
$kemarintgldar->modify('-1 day');
$tglkemarindar = $kemarintgldar->format('Y-m-d'); 

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

if(empty($iduser)){
echo "iduser kosong";
    }
    
elseif($level != "admin"){
 
 $zzz = "1";
 
 $infodar = "";
$querydar = "";
$arrayrdar = "";


if (date('H') >= 16) {
$infodar = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar = '".$tglhariini."' AND dar.iduser='".$iduser."' ORDER BY dar.tanggaldar DESC";
$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);

}else{
    
$infodar = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar = '".$tglkemarindar."' AND dar.iduser='".$iduser."' ORDER BY dar.tanggaldar DESC";
$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);

}

   

    
}


elseif ($level == "admin"){

$zzz = "3";
$infodar = "";
$querydar = "";
$arrayrdar = "";

if (date('H') >= 16) {
$infodar = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar = '".$tglhariini."' AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
}else{

$infodar = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar = '".$tglkemarindar."' AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);    
    
}

} 



else {

$zzz = "5";    
    
}

$varontime = 0;
$varlatesatu = 0;
$varlatedua = 0;
$varover = 0;
$varpendingabsence = 0;
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
                      }elseif($status == "late"){
           $varlatesatu++;
            $jumlahmuser--;
                      }elseif($status == "Pending Absence"){
         $varpendingabsence++;
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
    
    if ($level == "admin"){

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
    
          if ($level == "admin"){

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
    
        if ($level == "admin"){

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
    
        if ($level == "admin"){

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
    
        if ($level == "admin"){

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
 
    if ($level == "admin"){

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
                      }elseif($status == "late" && $namehari == "Mon"){
           $varlatesatumon++;
                      }elseif($status == "late2" && $namehari == "Mon"){
         $varlateduamon++;
                      }elseif($status == "over" && $namehari == "Mon"){
            $varovermon++;     
                      }elseif($status == "ontime" && $namehari == "Tue"){
           $varontimetue++;
                      }elseif($status == "late1" && $namehari == "Tue"){
           $varlatesatutue++;
                      }elseif($status == "late" && $namehari == "Tue"){
           $varlatesatutue++;
                      }elseif($status == "late2" && $namehari == "Tue"){
         $varlateduatue++;
                      }elseif($status == "over" && $namehari == "Tue"){
            $varovertue++;     
                      }elseif($status == "ontime" && $namehari == "Wed"){
           $varontimewed++;
                      }elseif($status == "late1" && $namehari == "Wed"){
           $varlatesatuwed++;
                      }elseif($status == "late" && $namehari == "Wed"){
           $varlatesatuwed++;
                      }elseif($status == "late2" && $namehari == "Wed"){
         $varlateduawedd++;
                      }elseif($status == "over" && $namehari == "Wed"){
            $varoverwed++;     
                      }elseif($status == "ontime" && $namehari == "Thu"){
           $varontimethu++;
                      }elseif($status == "late1" && $namehari == "Thu"){
           $varlatesatuthu++;
                      }elseif($status == "late" && $namehari == "Thu"){
           $varlatesatuthu++;
                      }elseif($status == "late2" && $namehari == "Thu"){
         $varlateduathu++;
                      }elseif($status == "over" && $namehari == "Thu"){
            $varoverthu++;     
                      }elseif($status == "ontime" && $namehari == "Fri"){
           $varontimefri++;
                      }elseif($status == "late1" && $namehari == "Fri"){
           $varlatesatufri++;
                      }elseif($status == "late" && $namehari == "Fri"){
           $varlatesatufri++;
                      }elseif($status == "late2" && $namehari == "Fri"){
         $varlateduafri++;
                      }elseif($status == "over" && $namehari == "Fri"){
            $varoverfri++;     
                      }elseif($status == "ontime" && $namehari == "Sat"){
           $varontimesat++;
                      }elseif($status == "late1" && $namehari == "Sat"){
           $varlatesatusat++;
                      }elseif($status == "late" && $namehari == "Sat"){
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
                      }elseif($status == "late"){
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
                      }elseif($status == "late"){
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
                      }elseif($status == "late"){
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
                      }elseif($status == "late"){
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
                      }elseif($status == "late"){
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
               $varontimejun++;
                      }elseif($status == "late1"){
           $varlatesatujun++;
                      }elseif($status == "late"){
           $varlatesatujun++;
                      }elseif($status == "late2"){
         $varlateduajun++;
                      }elseif($status == "over"){
            $varoverjun++;     
                      }elseif($status == "absence"){
            $varabsencejun++;     
                      }
                      
                      
                      
   }
   


for($x = 0; $x < sizeof($arrayrdarbulanjuli); $x++){
          
             $status = $arrayrdarbulanjuli[$x]["status"];

                      if ($status == "ontime"){
               $varontimejul++;
                      }elseif($status == "late1"){
           $varlatesatujul++;
                      }elseif($status == "late"){
           $varlatesatujul++;
                      }elseif($status == "late2"){
         $varlateduajul++;
                      }elseif($status == "over"){
            $varoverjul++;     
                      }elseif($status == "absence"){
            $varabsencejul++;     
                      }
                      
                      
   }   


for($x = 0; $x < sizeof($arrayrdarbulanagustus); $x++){
          
             $status = $arrayrdarbulanagustus[$x]["status"];

                      if ($status == "ontime"){
               $varontimeagu++;
                      }elseif($status == "late1"){
           $varlatesatuagu++;
                      }elseif($status == "late"){
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
                      }elseif($status == "late"){
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
                      }elseif($status == "late"){
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
                      }elseif($status == "late"){
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
                      }elseif($status == "late"){
           $varlatesatudes++;
                      }elseif($status == "late2"){
         $varlateduades++;
                      }elseif($status == "over"){
            $varoverdes++;     
                      }elseif($status == "absence"){
            $varabsencedes++;     
                      }
                      
                      
   }
   


$piebulatchart[0] = array(
       "ontimebulatchart"=> $varontime,
       "latebulatchart"=>$varlatesatu,
       "overbulatchart"=>$varover,
       "pendingbulatchart"=>$varpendingabsence,
       "nodata"=>$jumlahmuser,

      );       

$weekchartontime[0] = array(
       "varontimemon"=> $varontimemon,
       "varontimetue"=>$varontimetue,
       "varontimewed"=>$varontimewed,
       "varontimethu"=>$varontimethu,
       "varontimefri"=>$varontimefri,
       "varontimesat"=>$varontimesat,
      );
      
$weekchartover[0] = array(
      "varovermon"=> $varovermon,
       "varovertue"=>$varovertue,
       "varoverwed"=>$varoverwed,
       "varoverthu"=>$varoverthu,
       "varoverfri"=>$varoverfri,
       "varoversat"=>$varoversat,
      );

$weekchartlate[0] = array(
      "varlatesatumon"=> $varlatesatumon,
       "varlatesatutue"=>$varlatesatutue,
       "varlatesatuwed"=>$varlatesatuwed,
       "varlatesatuthu"=>$varlatesatuthu,
       "varlatesatufri"=>$varlatesatufri,
       "varlatesatusat"=>$varlatesatusat,
      );      


$tahunchartontime[0] = array(
      "varontimejan"=>$varontimejan,
       "varontimefeb"=>$varontimefeb,
       "varontimemar"=>$varontimemar,
       "varontimeapr"=>$varontimeapr,
       "varontimemei"=>$varontimemei,
       "varontimejun"=>$varontimejun,
       "varontimejul"=>$varontimejul,
       "varontimeagu"=>$varontimeagu,
       "varontimesep"=>$varontimesep,
       "varontimeokt"=>$varontimeokt,
       "varontimenov"=>$varontimenov,
       "varontimedes"=>$varontimedes,
     
      );

$tahunchartlate[0] = array(
       "varlatesatujan"=>$varlatesatujan,
       "varlatesatufeb"=>$varlatesatufeb,
       "varlatesatumar"=>$varlatesatumar,
       "varlatesatuapr"=>$varlatesatuapr,
       "varlatesatumei"=>$varlatesatumei,
       "varlatesatujun"=>$varlatesatujun,
       "varlatesatujul"=>$varlatesatujul,
       "varlatesatuagu"=>$varlatesatuagu,
       "varlatesatusep"=>$varlatesatusep,
       "varlatesatuokt"=>$varlatesatuokt,
       "varlatesatunov"=>$varlatesatunov,
       "varlatesatudes"=>$varlatesatudes,
      );      

$tahunchartover[0] = array(
      "varoverjan"=> $varoverjan,
       "varoverfeb"=>$varoverfeb,
       "varovermar"=>$varovermar,
       "varoverapr"=>$varoverapr,
       "varovermei"=>$varovermei,
       "varoverjun"=>$varoverjun,
       "varoverjul"=>$varoverjul,
       "varoveragu"=>$varoveragu,
       "varoversep"=>$varoversep,
       "varoverokt"=>$varoverokt,
       "varovernov"=>$varovernov,
       "varoverdes"=>$varoverdes,
      );

$tahunchartabsence[0] = array(
      "varabsencejan"=> $varabsencejan,
       "varabsencefeb"=>$varabsencefeb,
       "varabsencemar"=>$varabsencemar,
       "varabsenceapr"=>$varabsenceapr,
       "varabsencemei"=>$varabsencemei,
       "varabsencejun"=>$varabsencejun,
       "varabsencejul"=>$varabsencejul,
       "varabsenceagu"=>$varabsenceagu,
       "varabsencesep"=>$varabsencesep,
       "varabsenceokt"=>$varabsenceokt,
       "varabsencenov"=>$varabsencenov,
       "varabsencedes"=>$varabsencedes,
      ); 


$json = array(
       'result' => 'succsess',
       'piebulatchart' => $piebulatchart,
       'weekchartontime' => $weekchartontime,
       'weekchartover' => $weekchartover,
       'weekchartlate' => $weekchartlate,
       'tahunchartontime' => $tahunchartontime,
       'tahunchartlate' => $tahunchartlate,
       'tahunchartover' => $tahunchartover,
       'tahunchartabsence' => $tahunchartabsence,
       );
       
echo json_encode($json);

   

?>