<?php
session_start();
include "config.php";

$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;

date_default_timezone_set('Asia/Jakarta');
$datetimee = date('Y-m-d');
$datetime = DateTime::createFromFormat('Y-m-d', $datetimee);
$namahari = $datetime->format('D');


//echo $namahari;
//echo "<br>";

if($namahari == "Mon"){
    
    if ($_SESSION["Level"] == "admin"){

$zzz = "monadmin";
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;


$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar = '".$datetimee."' AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";

$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);
mysqli_close($conn);

} else {
    
     $zzz = "monuser";
 
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;
   
$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar = '".$datetimee."' AND dar.iduser='".$iduser."' ORDER BY dar.tanggaldar DESC";
$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);
mysqli_close($conn);
    
}

    
}elseif ($namahari == "Tue") {
    
    $tglstart = date('Y-m-d',strtotime("-1 days"));
    
          if ($_SESSION["Level"] == "admin"){

$zzz = "tueadmin";
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;

$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$datetimee."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";

$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);
mysqli_close($conn);

} else {
    
     $zzz = "tueuser";
 
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;
   
$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$datetimee."' AS DATE) AND dar.iduser='".$iduser."' ORDER BY dar.tanggaldar DESC";
$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);
mysqli_close($conn);
    
}

    
    
}elseif ($namahari == "Wed") {
    
    $tglstart = date('Y-m-d',strtotime("-2 days"));
    
        if ($_SESSION["Level"] == "admin"){

$zzz = "wedadmin";
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;

$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$datetimee."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";

$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);
mysqli_close($conn);

} else {
    
     $zzz = "weduser";
 
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;
   
$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$datetimee."' AS DATE) AND dar.iduser='".$iduser."' ORDER BY dar.tanggaldar DESC";
$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);
mysqli_close($conn);
    
}

    
    
}elseif ($namahari == "Thu") {
    
    $tglstart = date('Y-m-d',strtotime("-3 days"));
    
        if ($_SESSION["Level"] == "admin"){

$zzz = "thuadmin";
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;

$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$datetimee."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";

$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);
mysqli_close($conn);

} else {
    
     $zzz = "thuuser";
 
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;
   
$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$datetimee."' AS DATE) AND dar.iduser='".$iduser."' ORDER BY dar.tanggaldar DESC";
$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);
mysqli_close($conn);
    
}

    
}elseif ($namahari == "Fri") {
    
    $tglstart = date('Y-m-d',strtotime("-4 days"));
    
        if ($_SESSION["Level"] == "admin"){

$zzz = "friadmin";
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;

$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$datetimee."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";

$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);
mysqli_close($conn);

} else {
    
     $zzz = "friuser";
 
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;
   
$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$datetimee."' AS DATE) AND dar.iduser='".$iduser."' ORDER BY dar.tanggaldar DESC";
$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);
mysqli_close($conn);
    
}

    
}elseif ($namahari == "Sat") {
 
 $tglstart = date('Y-m-d',strtotime("-5 days"));
 
    if ($_SESSION["Level"] == "admin"){

$zzz = "satadmin";
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;

$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$datetimee."' AS DATE) AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";

$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);
mysqli_close($conn);

} else {
    
     $zzz = "satuser";
 
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;
   
$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$datetimee."' AS DATE) AND dar.iduser='".$iduser."' ORDER BY dar.tanggaldar DESC";
$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);
mysqli_close($conn);
    
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
*/

?>