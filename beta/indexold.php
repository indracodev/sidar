<?php
session_start();
include "config.php";

$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;

$iduser = $_COOKIE['IDUser'] ;
$keuser = $_COOKIE['Ke'] ;
//$nodar =  $_SESSION["Nodar"] ;
//$pecah = explode("/", $nodar);
//$hasil = $pecah[1] + 1;
//$nodarnya = $iduser."/".$hasil;

date_default_timezone_set('Asia/Jakarta');
$tglhariini = date('Y-m-d');
$jam = date('H:i');

$infomuser = "SELECT * FROM masteruser WHERE (id='".$iduser."' OR ke='".$iduser."' OR ke2='".$iduser."' OR ke3='".$iduser."' OR ke4='".$iduser."' OR ke5='".$iduser."') ;";
$queryuser = $conn->query($infomuser);
$arraymuser = mysqli_fetch_all($queryuser, MYSQLI_ASSOC);
$jumlahmuser = sizeof($arraymuser);

if($_SESSION["IDUser"] == 0 && $_COOKIE['IDUser'] == ''){
header("Location: http://sidar.id/login");
    }
    
elseif($_SESSION["Level"] != "admin" || $_COOKIE["Level"] != "admin"){
 
 $zzz = "1";
 
 $infodar = "";
$querydar = "";
$arrayrdar = "";

   
$infodar = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar = '".$tglhariini."' AND dar.iduser='".$iduser."' ORDER BY dar.tanggaldar DESC";
$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
//mysqli_close($conn);
    
}


elseif ($_SESSION["Level"] == "admin" || $_COOKIE['Level'] == "admin"){

$zzz = "3";
$infodar = "";
$querydar = "";
$arrayrdar = "";


$infodar = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.nodar, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar = '".$tglhariini."' AND (dar.iduser='".$iduser."' OR dar.ke='".$iduser."' OR dar.ke2='".$iduser."' OR dar.ke3='".$iduser."' OR dar.ke4='".$iduser."' OR dar.ke5='".$iduser."' ) ORDER BY dar.tanggaldar DESC, dar.jam DESC;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
//mysqli_close($conn);

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
mysqli_close($conn);

} else {
    
     $zzz = "monuser";
 
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;
   
$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar = '".$tglhariini."' AND dar.iduser='".$iduser."' ORDER BY dar.tanggaldar DESC";
$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);
mysqli_close($conn);
    
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
mysqli_close($conn);

} else {
    
     $zzz = "tueuser";
 
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;
   
$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglhariini."' AS DATE) AND dar.iduser='".$iduser."' ORDER BY dar.tanggaldar DESC";
$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);
mysqli_close($conn);
    
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
mysqli_close($conn);

} else {
    
     $zzz = "weduser";
 
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;
   
$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglhariini."' AS DATE) AND dar.iduser='".$iduser."' ORDER BY dar.tanggaldar DESC";
$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);
mysqli_close($conn);
    
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
mysqli_close($conn);

} else {
    
     $zzz = "thuuser";
 
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;
   
$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglhariini."' AS DATE) AND dar.iduser='".$iduser."' ORDER BY dar.tanggaldar DESC";
$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);
mysqli_close($conn);
    
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
mysqli_close($conn);

} else {
    
     $zzz = "friuser";
 
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;
   
$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglhariini."' AS DATE) AND dar.iduser='".$iduser."' ORDER BY dar.tanggaldar DESC";
$querydarhari = $conn->query($infodarhari);
$arrayrdarhari = mysqli_fetch_all($querydarhari, MYSQLI_ASSOC);
mysqli_close($conn);
    
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

mysqli_close($conn);

} else {
    
     $zzz = "satuser";
 
$infodarhari = "";
$querydarhari = "";
$arrayrdarhari = "";

//echo $zzz;
   
$infodarhari = "SELECT masteruser.nama, masteruser.departemen, dar.status, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggaldar BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglhariini."' AS DATE) AND dar.iduser='".$iduser."' ORDER BY dar.tanggaldar DESC";
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
                                            <a class="dropdown-item" href="#">Details</a>
                                           
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
   <!-- <script type="text/javascript" src="js/bar3.js"></script> -->
    <script type="text/javascript" src="js/bar-chart.js"></script>
    <script type="text/javascript" src="js/chart-bar-demo.js"></script>
  <!--  <script type="text/javascript" src="js/chart-pie-demo.js"></script> -->
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
              max: 20
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
  
  
  
  
</body>
</html>