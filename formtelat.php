<?php 
include "config.php";
session_start();
$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;
$keuser2 = $_SESSION["Ke2"];
$keuser3 = $_SESSION["Ke3"];
$keuser4 = $_SESSION["Ke4"];
$keuser5 = $_SESSION["Ke5"];
$namaa = $_SESSION["NMUser"];

$lokasikerja = $_SESSION["Lokasikerja"] ;


$datefilter = $_POST['datefilter'];
$pecahtgl = explode("-", $datefilter);

$tglstartisi = $pecahtgl[0];
$tglendisi = $pecahtgl[1];

$tglstart = str_replace("/","-",$tglstartisi);
$tglend = str_replace("/","-",$tglendisi);

$searching = $_POST['searching'];
$searchingg = "%" .  $searching  . "%";
$searchinggg = "'".$searchingg."'";

date_default_timezone_set('Asia/Jakarta');   
$datee = date('Y-m-d');
$jamet = date('H:i:s');    

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
$latitude = '-';
$longitude = '-';
$act = 'ke halaman form telat';
$updatelog = "INSERT INTO log (iduser, tanggal, jam, activity, ip, userdevice,latitude, longitude) VALUE ('".$iduser."', '".$datee."', '".$jamet."', '".$act."', '".$ip."', '".$useragent."', '".$latitude."', '".$longitude."')"; 
$conn->query($updatelog); 
       			

if($_SESSION["IDUser"] == 0){
header("Location: https://sidar.id/login");
}elseif ($namaa == "HRD IB" && $datefilter != ""){

$zzz = "32";
$infodar = "";
$querydar = "";
$arrayrdar = "";


$infodar = "SELECT masteruser.id, masteruser.nama, masteruser.nik, masteruser.departemen, formtelat.telatpadatanggal, formtelat.masukjam, formtelat.alasan, formtelat.dibuatpadatgl, formtelat.ke1, formtelat.menyetujuiatasan, formtelat.mengetahuihcs, formtelat.notelat FROM formtelat INNER JOIN masteruser ON masteruser.id=formtelat.iduser WHERE tanggal BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglend."' AS DATE) AND masteruser.lokasikerja = 'ib' ORDER BY formtelat.telatpadatanggal DESC";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);

} 


elseif ($namaa == "HRD IB" || $namaa == "Admin HRD IB"){

$zzz = "3";
$infodar = "";
$querydar = "";
$arrayrdar = "";

if(isset($_POST['cari'])){ // Check if form was submitted


$infodar = "SELECT masteruser.id, masteruser.nama, masteruser.nik, masteruser.departemen, formtelat.telatpadatanggal, formtelat.masukjam, formtelat.alasan, formtelat.dibuatpadatgl, formtelat.ke1, formtelat.menyetujuiatasan, formtelat.mengetahuihcs, formtelat.notelat FROM formtelat INNER JOIN masteruser ON masteruser.id=formtelat.iduser WHERE AND (formtelat.alasan LIKE '".$searchingg."') AND masteruser.lokasikerja = 'ib' ORDER BY formtelat.telatpadatanggal DESC, formtelat.id DESC;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);

    }
    else{

$infodar = "SELECT masteruser.id, masteruser.nama, masteruser.nik, masteruser.departemen, formtelat.telatpadatanggal, formtelat.masukjam, formtelat.alasan, formtelat.dibuatpadatgl, formtelat.ke1, formtelat.menyetujuiatasan, formtelat.mengetahuihcs, formtelat.notelat FROM formtelat INNER JOIN masteruser ON masteruser.id=formtelat.iduser WHERE masteruser.lokasikerja = 'ib' ORDER BY formtelat.telatpadatanggal DESC, formtelat.id DESC LIMIT 70;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);

}

} 


elseif ($namaa == "HRD IGI Pasuruan" && $datefilter != ""){

$zzz = "32";
$infodar = "";
$querydar = "";
$arrayrdar = "";


$infodar = "SELECT masteruser.id, masteruser.nama, masteruser.nik, masteruser.departemen, formtelat.telatpadatanggal, formtelat.masukjam, formtelat.alasan, formtelat.dibuatpadatgl, formtelat.ke1, formtelat.menyetujuiatasan, formtelat.mengetahuihcs, formtelat.notelat FROM formtelat INNER JOIN masteruser ON masteruser.id=formtelat.iduser WHERE tanggal BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglend."' AS DATE) AND masteruser.lokasikerja = 'IGI Purwosari' ORDER BY formtelat.telatpadatanggal DESC";


$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);

} 


elseif ($namaa == "HRD IGI Pasuruan" || $namaa == "Admin HRD Pasuruan"){

$zzz = "3";
$infodar = "";
$querydar = "";
$arrayrdar = "";

if(isset($_POST['cari'])){ // Check if form was submitted


$infodar = "SELECT masteruser.id, masteruser.nama, masteruser.nik, masteruser.departemen, formtelat.telatpadatanggal, formtelat.masukjam, formtelat.alasan, formtelat.dibuatpadatgl, formtelat.ke1, formtelat.menyetujuiatasan, formtelat.mengetahuihcs, formtelat.notelat FROM formtelat INNER JOIN masteruser ON masteruser.id=formtelat.iduser WHERE AND (formtelat.alasan LIKE '".$searchingg."') AND masteruser.lokasikerja = 'IGI Purwosari' ORDER BY formtelat.telatpadatanggal DESC, formtelat.masukjam DESC;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);

    }
    else{

$infodar = "SELECT masteruser.id, masteruser.nama, masteruser.nik, masteruser.departemen, formtelat.telatpadatanggal, formtelat.masukjam, formtelat.alasan, formtelat.dibuatpadatgl, formtelat.ke1, formtelat.menyetujuiatasan, formtelat.mengetahuihcs, formtelat.notelat FROM formtelat INNER JOIN masteruser ON masteruser.id=formtelat.iduser WHERE masteruser.lokasikerja = 'IGI Purwosari' ORDER BY formtelat.telatpadatanggal DESC, formtelat.masukjam DESC LIMIT 70;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);

}

} 



elseif ($namaa == "HRD IGI Gresik" && $datefilter != ""){

$zzz = "32";
$infodar = "";
$querydar = "";
$arrayrdar = "";


$infodar = "SELECT masteruser.id, masteruser.nama, masteruser.nik, masteruser.departemen, formtelat.telatpadatanggal, formtelat.masukjam, formtelat.alasan, formtelat.dibuatpadatgl, formtelat.ke1, formtelat.menyetujuiatasan, formtelat.mengetahuihcs, formtelat.notelat FROM formtelat INNER JOIN masteruser ON masteruser.id=formtelat.iduser WHERE tanggal BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglend."' AS DATE) AND masteruser.lokasikerja = 'IGI Bambe' ORDER BY formtelat.telatpadatanggal DESC";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);

} 


elseif ($namaa == "HRD IGI Gresik" || $namaa == "Admin HRD Gresik"){

$zzz = "3";
$infodar = "";
$querydar = "";
$arrayrdar = "";

if(isset($_POST['cari'])){ // Check if form was submitted



$infodar = "SELECT masteruser.id, masteruser.nama, masteruser.nik, masteruser.departemen, formtelat.telatpadatanggal, formtelat.masukjam, formtelat.alasan, formtelat.dibuatpadatgl, formtelat.ke1, formtelat.menyetujuiatasan, formtelat.mengetahuihcs, formtelat.notelat FROM formtelat INNER JOIN masteruser ON masteruser.id=formtelat.iduser WHERE AND (formtelat.alasan LIKE '".$searchingg."') AND masteruser.lokasikerja = 'IGI Bambe' ORDER BY formtelat.telatpadatanggal DESC, formtelat.masukjam DESC;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);

    }
    else{

$infodar = "SELECT masteruser.id, masteruser.nama, masteruser.nik, masteruser.departemen, formtelat.telatpadatanggal, formtelat.masukjam, formtelat.alasan, formtelat.dibuatpadatgl, formtelat.ke1, formtelat.menyetujuiatasan, formtelat.mengetahuihcs, formtelat.notelat FROM formtelat INNER JOIN masteruser ON masteruser.id=formtelat.iduser WHERE masteruser.lokasikerja = 'IGI Bambe' ORDER BY formtelat.telatpadatanggal DESC, formtelat.masukjam DESC LIMIT 70;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);

}

} 



elseif ($namaa == "HRD SDA" && $datefilter != ""){

$zzz = "32";
$infodar = "";
$querydar = "";
$arrayrdar = "";


$infodar = "SELECT masteruser.id, masteruser.nama, masteruser.nik, masteruser.departemen, formtelat.telatpadatanggal, formtelat.masukjam, formtelat.alasan, formtelat.dibuatpadatgl, formtelat.ke1, formtelat.menyetujuiatasan, formtelat.mengetahuihcs, formtelat.notelat FROM formtelat INNER JOIN masteruser ON masteruser.id=formtelat.iduser WHERE tanggal BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglend."' AS DATE) AND masteruser.lokasikerja = 'sda' ORDER BY formtelat.telatpadatanggal DESC";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);

} 


elseif ($namaa == "HRD SDA" || $namaa == "Admin HRD SDA"){

$zzz = "3";
$infodar = "";
$querydar = "";
$arrayrdar = "";

if(isset($_POST['cari'])){ // Check if form was submitted


$infodar = "SELECT masteruser.id, masteruser.nama, masteruser.nik, masteruser.departemen, formtelat.telatpadatanggal, formtelat.masukjam, formtelat.alasan, formtelat.dibuatpadatgl, formtelat.ke1, formtelat.menyetujuiatasan, formtelat.mengetahuihcs, formtelat.notelat FROM formtelat INNER JOIN masteruser ON masteruser.id=formtelat.iduser WHERE AND (formtelat.alasan LIKE '".$searchingg."') AND masteruser.lokasikerja = 'sda' ORDER BY formtelat.telatpadatanggal DESC, formtelat.masukjam DESC;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);

    }
    else{

$infodar = "SELECT masteruser.id, masteruser.nama, masteruser.nik, masteruser.departemen, formtelat.telatpadatanggal, formtelat.masukjam, formtelat.alasan, formtelat.dibuatpadatgl, formtelat.ke1, formtelat.menyetujuiatasan, formtelat.mengetahuihcs, formtelat.notelat FROM formtelat INNER JOIN masteruser ON masteruser.id=formtelat.iduser WHERE masteruser.lokasikerja = 'sda' ORDER BY formtelat.telatpadatanggal DESC, formtelat.masukjam DESC LIMIT 70;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);

}

}


elseif($_SESSION["Level"] != "admin" && $datefilter != ""){
 
 $zzz = "1";
 
 $infodar = "";
$querydar = "";
$arrayrdar = "";

   
$infodar = "SELECT masteruser.nama, masteruser.departemen, masteruser.divisi, masteruser.kota, masteruser.unitusaha, formtelat.telatpadatanggal, formtelat.masukjam, formtelat.alasan, formtelat.dibuatpadatgl, formtelat.ke1, formtelat.menyetujuiatasan, formtelat.mengetahuihcs, formtelat.notelat FROM formtelat INNER JOIN masteruser ON masteruser.id=formtelat.iduser WHERE telatpadatanggal BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglend."' AS DATE) AND formtelat.iduser='".$iduser."' ORDER BY formtelat.telatpadatanggal DESC, formtelat.masukjam DESC";
$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);
    
}


    
elseif ($_SESSION["Level"] != "admin"){

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
    
    
elseif ($_SESSION["Level"] == "admin" && $datefilter != ""){

$zzz = "32";
$infodar = "";
$querydar = "";
$arrayrdar = "";


$infodar = "SELECT masteruser.nama, masteruser.departemen, masteruser.divisi, masteruser.kota, masteruser.unitusaha, formtelat.telatpadatanggal, formtelat.masukjam, formtelat.alasan, formtelat.dibuatpadatgl, formtelat.ke1, formtelat.menyetujuiatasan, formtelat.mengetahuihcs, formtelat.notelat FROM formtelat INNER JOIN masteruser ON masteruser.id=formtelat.iduser WHERE telatpadatanggal BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglend."' AS DATE) AND (formtelat.iduser='".$iduser."' OR formtelat.ke1='".$iduser."' OR formtelat.ke2='".$iduser."' OR formtelat.ke3='".$iduser."' OR formtelat.ke4='".$iduser."' OR formtelat.ke5='".$iduser."') ORDER BY formtelat.telatpadatanggal DESC, formtelat.masukjam DESC";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);

} 


elseif ($_SESSION["Level"] == "admin"){

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


else {

$zzz = "5";    
    
}
 
if(strpos($namaa, 'HRD') !== false){
$isihcs = '1'; 
$linkaddform = 'sendnotiftelathcs.php';
$titleatas = 'Form Terlambat Masuk Kantor';
$wdtbutton = 'Tambah Form Terlambat';
$btnaccept = 'Confirm';
}else{
$isihcs = '0';  
$linkaddform = 'addformtelat.php';
$wdtbutton = 'Tambah Form Izin Terlambat';
$titleatas = 'Permohonan izin terlambat masuk kantor';
$btnaccept = 'Accept';
} 
$navactiveharvest = "active";

//echo $isihcs;



if($isihcs != '1'){

$ambilizintelat = "SELECT * FROM formtelat WHERE iduser = '" .$iduser. "' AND sudahisialasan = 'belum' ORDER BY id DESC LIMIT 1 ;";
$queryambilizintelat =$conn->query($ambilizintelat);

 if($queryambilizintelat->num_rows){
$rowizintelat = mysqli_fetch_array($queryambilizintelat, MYSQLI_ASSOC);
$notelat = $rowizintelat['notelat'];
header("Location: https://sidar.id/updatealasantelat.php?notelat=".$notelat);
exit();     
 }
 
}

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
    <!--daterange picker-->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- Custom table for this page -->
    <link href="js/table/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- inner style -->
    <style type="text/css">
    	
    </style>
    
       <style type="text/css">
    	tr.highlighted td {
        background-color: rgba(0,0,0,.05);
        }

        .badge-late {
         background-color: orange;
        }
        
        .disable { 
    pointer-events: none; 
    cursor: default; 
}
    </style>
    
    
       <style>
    #linkk { color: black; } /* CSS link color */
  </style>


</head>
<body>

	<div class="wrapper">
		
		<!-- NAVBAR -->
		<?php include'navbar1.php';?>

		<!-- KONTEN -->
		<main class="konten">
			
			<!-- letakkan isi konten disini ! -->
              <section class="dar mb-5">
                <div class="container-fluid">
               
                       <!-- DataTales Example -->
                          <div class="card shadow mb-4">
                            <div class="card-header py-3">
                             <h4 class="card-title m-0 text-uppercase font-weight-bold"><?php echo $titleatas ?></h4>
                            </div>
                                <div class="card-body">
                                 <h6>Period Filter:</h6>
                                 <div class="row justify-content-between">
                                  <div class='col-sm-3'>
                                    <div class="form-group">
                                        <div class='' id=''>
                                    
                                        <form method="POST" action="">
                                     <input type="text" class="form-control" name="datefilter"  id="datefilter">
                                     
                                       <input type="submit" style="display:none;" class="form-control" name="autoClickBtn"  id="autoClickBtn">
                                     </form>
                                     
                                     
                                            <span class="add-on"><i class="icon-remove"></i></span>
                                        </div>
                                    </div>
                                   </div>
                                   
                                <div class='col-sm-3' style="text-align:right;">
                              <a href="<?php echo $linkaddform;?>">
                                <button name="clearfilter" id="aktifbaca" value="clearfilter" class="btn btn-outline-dark form-group">
                                  <?php echo $wdtbutton;?>
                                </button>
                              </a>
                                </div>
                                   
                                 </div>
                                 </div>
                               <div class="card-body">
                      
                  
                       
                              <div class="table-responsive">
                                  <!--
                                     <div class="dataTables_length"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="dataTablee"></label></div>
                                  -->
                                <table class="table table-bordered" id="dataTablee" width="100%" cellspacing="0">
                                  <thead>
                                    <tr>
                                      <th>Dept </th>
                                      <th>Name</th>
                                      <th>Tanggal Terlambat</th>
                                      <th>Jam Terlambat</th>
                                      <th>Alasan</th>
                                      <th>Menyetujui Atasan</th>
                                      <th>Mengetahui HCS</th>
                                      <?php if($_SESSION["Level"] == "admin"){ ?>
                                      <th>Setuju</th>
                                      <th <?php if($isihcs == "1"){ echo 'style="display:none;"';} ?>>Tolak</th>
                                      <?php } ?>
                                      
                                    </tr>
                                  </thead>
                         
                                  <tbody>
                                                             <?php
                for($x = 0; $x < sizeof($arrayrdar); $x++){
                      $status = $arrayrdar[$x]["status"];
                      $sudahbaca = $arrayrdar[$x]['sudahbaca'];
                      
                       $pecahsudahbaca = explode("/", $sudahbaca);
                       $sdbc1 = $pecahsudahbaca[0];
                       $sdbc2 = $pecahsudahbaca[1];
                       $sdbc3 = $pecahsudahbaca[2];
                       $sdbc4 = $pecahsudahbaca[3];
                       $sdbc5 = $pecahsudahbaca[4];
                       $sdbc6 = $pecahsudahbaca[5];
 
 
                       $pecahsdbc1 = explode("|", $sdbc1);
                       $sdbc100 = $pecahsdbc1[0];
                       $sdbc101 = $pecahsdbc1[1];
                       
                       $pecahsdbc2 = explode("|", $sdbc2);
                       $sdbc200 = $pecahsdbc2[0];
                       $sdbc201 = $pecahsdbc2[1];
                       
                       $pecahsdbc3 = explode("|", $sdbc3);
                       $sdbc300 = $pecahsdbc3[0];
                       $sdbc301 = $pecahsdbc3[1];
                       
                       $pecahsdbc4 = explode("|", $sdbc4);
                       $sdbc400 = $pecahsdbc4[0];
                       $sdbc401 = $pecahsdbc4[1];
                       
                       $pecahsdbc5 = explode("|", $sdbc5);
                       $sdbc500 = $pecahsdbc5[0];
                       $sdbc501 = $pecahsdbc5[1];
                       
                       $pecahsdbc6 = explode("|", $sdbc6);
                       $sdbc600 = $pecahsdbc6[0];
                       $sdbc601 = $pecahsdbc6[1];
                 
                       $ius = "$iduser";
                  
                       if($sdbc100 == $ius || $sdbc200 == $ius || $sdbc300 == $ius || $sdbc400 == $ius || $sdbc500 == $ius || $sdbc600 == $ius){
                           
                           $sama = "normal";
                         //  echo $sama;
                           
                       }else{
                           $sama = "bold";
                         //  echo $sama;
                       }
                      
                      
                      if ($status == "ontime"){
                $echosts = '<span class="badge badge-success">Ontime</span>';
                          $echostatus = 'bgcolor="green"';
                      }elseif($status == "late1"){
                    $echosts = '<span class="badge badge-warning">Late1</span>';
                           $echostatus = 'bgcolor="yellow"'; 
                      }elseif($status == "late"){
                    $echosts = '<span class="badge badge-warning">Late</span>';
                           $echostatus = 'bgcolor="yellow"'; 
                      }elseif($status == "late2"){
                $echosts = '<span class="badge badge-late">Late2</span>';  
                           $echostatus = 'bgcolor="orange"'; 
                      }else{
                     $echosts = '<span class="badge badge-danger">Over</span>';
                           $echostatus = 'bgcolor="red"'; 
                      }
                      
                  ?>
                
                  
                  <tr> 
                    <td scope="row"> <a style="font-weight:<?php echo $sama ?>;" id="linkk" href="formtelatdetail.php?notelat=<?php echo $arrayrdar[$x]["notelat"] ?>&nama=<?php echo $arrayrdar[$x]["nama"] ?>"><?php echo $arrayrdar[$x]["departemen"] ?></td> </a>
                    <td><a style="font-weight:<?php echo $sama ?>;" id="linkk" href="formtelatdetail.php?notelat=<?php echo $arrayrdar[$x]["notelat"] ?>&nama=<?php echo $arrayrdar[$x]["nama"] ?>"><?php echo $arrayrdar[$x]["nama"] ?></td></a>
                    <td><a style="font-weight:<?php echo $sama ?>;" id="linkk" href="formtelatdetail.php?notelat=<?php echo $arrayrdar[$x]["notelat"] ?>&nama=<?php echo $arrayrdar[$x]["nama"] ?>"><?php 
                 $tanggaldar = $arrayrdar[$x]["telatpadatanggal"];
                    $pecahtgldar = explode("-", $tanggaldar);
$daydar = $pecahtgldar[2];
$mondar = $pecahtgldar[1];
$yerdar = $pecahtgldar[0];
/*
$dateObj   = DateTime::createFromFormat('!m', $mon);
$monthName = $dateObj->format('F'); // March
*/
$tgldar = $daydar .'-'. $mondar .'-'. $yerdar;
                    
                    echo $tgldar; ?></td></a>
                    <td ><a style="font-weight:<?php echo $sama ?>;" id="linkk" href="formtelatdetail.php?notelat=<?php echo $arrayrdar[$x]["notelat"] ?>&nama=<?php echo $arrayrdar[$x]["nama"] ?>"><?php
              
/*
$jam = $arrayrdar[$x]["jam"];
$pecahjam = explode(":", $jam);
$hor = $pecahjam[0];
$min = $pecahjam[1];


$jamm = $hor .':'. $min;

$darsend = $tgl.' / '.$jamm;
*/
echo $arrayrdar[$x]["masukjam"];                  
         
                    
                    
                    
                   ?></td></a>
                   
                   <td ><a style="font-weight:<?php echo $sama ?>;" id="linkk" href="formtelatdetail.php?notelat=<?php echo $arrayrdar[$x]["notelat"] ?>&nama=<?php echo $arrayrdar[$x]["nama"] ?>"><?php echo $arrayrdar[$x]["alasan"] ?></td></a>
                   
                   <td ><a style="font-weight:<?php echo $sama ?>;" id="linkk" href="formtelatdetail.php?notelat=<?php echo $arrayrdar[$x]["notelat"] ?>&nama=<?php echo $arrayrdar[$x]["nama"] ?>"><?php echo $arrayrdar[$x]["menyetujuiatasan"] ?></td></a>
          
                   
                    <td ><a style="font-weight:<?php echo $sama ?>;" id="linkk" href="formtelatdetail.php?notelat=<?php echo $arrayrdar[$x]["notelat"] ?>&nama=<?php echo $arrayrdar[$x]["nama"] ?>"><?php echo $arrayrdar[$x]["mengetahuihcs"] ?></td></a>
          
                   <?php if($_SESSION["Level"] == "admin"){ ?>
                    
                    <td ><a style="font-weight:<?php echo $sama ?>;<?php if($arrayrdar[$x]["ke1"] != $iduser && $isihcs != '1'){ echo 'pointer-events:none;';}?><?php if($arrayrdar[$x]["menyetujuiatasan"] == "Tidak" ){ echo 'display:none;';} ?>" class="<?php if(($arrayrdar[$x]["ke1"] != $iduser && $isihcs != '1') || ($isihcs == '1' && ($arrayrdar[$x]["menyetujuiatasan"] == "Belum" || $arrayrdar[$x]["menyetujuiatasan"] == "Tidak")) || ($isihcs == '1' && ($arrayrdar[$x]["mengetahuihcs"] == "Setuju" || $arrayrdar[$x]["mengetahuihcs"] == "Tidak")) || ($isihcs != '1' && ($arrayrdar[$x]["menyetujuiatasan"] == "Setuju" || $arrayrdar[$x]["menyetujuiatasan"] == "Tidak"))){ echo 'disable';}?>" id="linkk" href="setujutelat.php?idnya=<?php echo $arrayrdar[$x]["notelat"] ?>&usr=<?php echo $iduser;?>&hcs=<?php echo $isihcs;?>"><button class="btn btn-<?php if($arrayrdar[$x]["menyetujuiatasan"] == "Setuju" && $isihcs != '1'){echo 'dark';}else{echo 'success';}?> <?php if(($arrayrdar[$x]["ke1"] != $iduser && $isihcs != '1') || ($isihcs == '1' && ($arrayrdar[$x]["menyetujuiatasan"] == "Belum" || $arrayrdar[$x]["menyetujuiatasan"] == "Tidak")) || ($isihcs == '1' && ($arrayrdar[$x]["mengetahuihcs"] == "Setuju" || $arrayrdar[$x]["mengetahuihcs"] == "Tidak")) || ($isihcs != '1' && ($arrayrdar[$x]["menyetujuiatasan"] == "Setuju" || $arrayrdar[$x]["menyetujuiatasan"] == "Tidak"))){ echo 'disabled';}?>"><?php if($arrayrdar[$x]["menyetujuiatasan"] == "Setuju"  && $isihcs != '1'){echo 'Accepted';} else{echo $btnaccept;}?></button></td></a> 
                    <td <?php if($isihcs == "1"){ echo 'style="display:none;"';} ?>><a style="font-weight:<?php echo $sama ?>;<?php if($arrayrdar[$x]["ke1"] != $iduser && $isihcs != '1'){ echo 'pointer-events:none;';}?> <?php if($arrayrdar[$x]["menyetujuiatasan"] == "Setuju" ){ echo 'display:none;';} ?>" class="<?php if(($arrayrdar[$x]["ke1"] != $iduser && $isihcs != '1') || ($isihcs == '1' && ($arrayrdar[$x]["menyetujuiatasan"] == "Belum" || $arrayrdar[$x]["menyetujuiatasan"] == "Tidak")) || ($isihcs == '1' && ($arrayrdar[$x]["mengetahuihcs"] == "Setuju" || $arrayrdar[$x]["mengetahuihcs"] == "Tidak")) || ($isihcs != '1' && ($arrayrdar[$x]["menyetujuiatasan"] == "Setuju" || $arrayrdar[$x]["menyetujuiatasan"] == "Tidak"))){ echo 'disable';}?>" id="linkk" href="tolaktelat.php?idnya=<?php echo $arrayrdar[$x]["notelat"] ?>&usr=<?php echo $iduser;?>&hcs=<?php echo $isihcs;?>"><button class="btn btn-<?php if($arrayrdar[$x]["menyetujuiatasan"] == "Tidak" && $isihcs != '1'){echo 'dark';}else{echo 'danger';}?> <?php if(($arrayrdar[$x]["ke1"] != $iduser && $isihcs != '1') || ($isihcs == '1' && ($arrayrdar[$x]["menyetujuiatasan"] == "Belum" || $arrayrdar[$x]["menyetujuiatasan"] == "Tidak")) || ($isihcs == '1' && ($arrayrdar[$x]["mengetahuihcs"] == "Setuju" || $arrayrdar[$x]["mengetahuihcs"] == "Tidak")) || ($isihcs != '1' && ($arrayrdar[$x]["menyetujuiatasan"] == "Setuju" || $arrayrdar[$x]["menyetujuiatasan"] == "Tidak"))){ echo 'disabled';}?>">Decline</button></td></a>
 
                   <?php } ?>
                   
                  </tr>
                  <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                      </div>
            </section><!-- end dar -->

			<!-- FOOTER -->
			<?php include'footer.php';?>

		</main><!-- end konten -->
	</div><!-- end wrapper -->

	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
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
    
    <!-- Custom JS -->
    <script type="text/javascript" src="custom.js"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
     <!--table-->
     <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  
    
         <script>
        $(function() {

          $('input[name="datefilter"]').daterangepicker({
              autoUpdateInput: false,
              locale: {
                  firstDay: 1, 
                  cancelLabel: 'Clear'
              }
          });
          
          

          $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
              
                
            
              $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
            
              var startDate = picker.startDate.format('YYYY/MM/DD');
              var endDate = picker.endDate.format('YYYY/MM/DD');
              
            $('input[name="autoClickBtn"]').val(document.getElementById('autoClickBtn').click());
              
 //function(){document.getElementById('autoClickBtn').click();}
           /*   
           $.ajax({
           method: "POST",
           url: "rec.php",
           data: {startDate: picker.startDate, endDate: picker.endDate}
        }).done(function(response){
            // Do something with response here
            console.log(response);
        }).fail(function (error) {
            // And handle errors here
            console.log(error);
        });
                    
  */
         
              
     /*         

        var activity =  document.querySelector('input[name="datefilter"]');
        activity.value = quill.root.innerHTML;
              
             $.ajax({
            type: 'POST',
            url: 'rec.php',
            data:  { startDate:startDate, endDate:endDate},
             success: function(result) {
                $('#sonuc').html(result);
            },
            error: function() {
                alert('Some error found. Please try again!');
            }
             });
             
             window.location.replace("http://www.w3schools.com");
       */      
              
          });
          
          
          
          
          

          $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
              $(this).val('');
               $('input[name="autoClickBtn"]').val(document.getElementById('autoClickBtn').click());
          });


        });
        
  
    </script>
    
    
    
    <script>
    
      $(document).ready(function(){
        $('#dataTablee').DataTable({
  
   "aaSorting": []
    });

    });
    
    /*
    $(document).ready(function(){
        $('#dataTablee').DataTable({
    "searching": false,
     "paging":   true,
        "ordering": true,
        "info":     true,
   "aaSorting": []
    });
    
   //  $("#dataTablee_length").html('<b>Custom tool bar! Text/images etc.</b>');
    });
    */
</script>


    
   <script src="js/table/jquery.dataTables.min.js"></script>
    <script src="js/table/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="js/table/datatables-demo.js"></script>
    
    
    
<script>
    document.getElementById("dataTablee_filter").style.display = "none";
    document.getElementById("dataTablee_filter").innerHTML = "Hello World!";
</script>
</body>
</html>