<?php 
include "config.php";
session_start();
$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;
$keuser2 = $_SESSION["Ke2"];
$keuser3 = $_SESSION["Ke3"];
$keuser4 = $_SESSION["Ke4"];
$keuser5 = $_SESSION["Ke5"];



$datefilter = $_POST['datefilter'];
$pecahtgl = explode("-", $datefilter);

$tglstartisi = $pecahtgl[0];
$tglendisi = $pecahtgl[1];

$tglstart = str_replace("/","-",$tglstartisi);
$tglend = str_replace("/","-",$tglendisi);

$searching = $_POST['searching'];
$searchingg = "%" .  $searching  . "%";
$searchinggg = "'".$searchingg."'";
/*
SELECT masteruser.nama, masteruser.departemen, dar.jam, dar.tanggal, dar.urid
FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggal BETWEEN CAST('2020-01-28' AS DATE) AND CAST('2020-01-30' AS DATE) AND dar.iduser=1 ORDER BY dar.tanggal DESC
*/

/*

SELECT masteruser.nama, masteruser.departemen, dar.jam, dar.tanggal, dar.urid
FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE dar.activity LIKE '%ar%' AND dar.iduser=1 ORDER BY dar.tanggal DESC

*/

if($_POST['aktifbaca'] == "aktifbaca"){
$aktifbaca = "display:none;";
$readfilter = "1";
$_SESSION["readfilter"] = "1";
}else{
$aktifbaca = "";
$bacatidakaktif = "display:none;" ;
$readfilter = "0";
//$_SESSION["readfilter"] = "0";
}
    
if($_POST['bacatidakaktif'] == "bacatidakaktif"){
$bacatidakaktif = "display:none;" ;
$aktifbaca = "";
$readfilter = "0";
$_SESSION["readfilter"] = "";
}else{


}

if($_SESSION["readfilter"] == "1"){
$bacatidakaktif = "" ;    
$aktifbaca = "display:none;";    
} else{
$bacatidakaktif = "display:none;" ;    
$aktifbaca = "";        
    
} 





if($_SESSION["IDUser"] == 0){
header("Location: http://sidar.id/login");
    }
    

elseif($_SESSION["Level"] != "admin" && $datefilter != ""){
 
 $zzz = "1";
 
 $infodar = "";
$querydar = "";
$arrayrdar = "";

   
$infodar = "SELECT masteruser.nama, masteruser.departemen, masteruser.unitusaha, hdar.status, hdar.sudahbaca, hdar.tanggaldar, hdar.jam, hdar.tanggal, hdar.nodar, hdar.urid, hdar.tag FROM hdar INNER JOIN masteruser ON masteruser.id=hdar.iduser WHERE tanggal BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglend."' AS DATE) AND hdar.iduser='".$iduser."' ORDER BY hdar.tanggal DESC, hdar.jam DESC";
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



$infodar = "SELECT masteruser.nama, masteruser.departemen, masteruser.unitusaha, hdar.status, hdar.sudahbaca, hdar.tanggaldar, hdar.jam, hdar.tanggal, hdar.nodar, hdar.tag FROM hdar INNER JOIN masteruser ON masteruser.id=hdar.iduser WHERE hdar.iduser='".$iduser."' AND (hdar.activity LIKE '".$searchingg."' OR hdar.plan LIKE '".$searchingg."' OR hdar.result LIKE '".$searchingg."' OR masteruser.nama LIKE '".$searchingg."') ORDER BY hdar.tanggal DESC, hdar.jam DESC;";
$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);



    }
    else{
        
if($_SESSION["readfilter"] == "1"){        
$infodar = "SELECT masteruser.nama, masteruser.departemen, masteruser.unitusaha, hdar.status, hdar.sudahbaca, hdar.tanggaldar, hdar.jam, hdar.tanggal, hdar.nodar FROM hdar INNER JOIN masteruser ON masteruser.id=hdar.iduser WHERE hdar.iduser='".$iduser."' AND sudahbaca NOT LIKE '%".$iduser."|%' ORDER BY hdar.tanggaldar DESC, hdar.jam DESC LIMIT 70;";
$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);
}else{
$infodar = "SELECT masteruser.nama, masteruser.departemen, masteruser.unitusaha, hdar.status, hdar.sudahbaca, hdar.tanggaldar, hdar.jam, hdar.tanggal, hdar.nodar FROM hdar INNER JOIN masteruser ON masteruser.id=hdar.iduser WHERE hdar.iduser='".$iduser."' ORDER BY hdar.tanggaldar DESC, hdar.jam DESC LIMIT 70;";
$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);    
    
}

        
    }



}


elseif ($_SESSION["Level"] == "admin" && $datefilter != ""){

$zzz = "32";
$infodar = "";
$querydar = "";
$arrayrdar = "";


$infodar = "SELECT masteruser.nama, masteruser.departemen, masteruser.unitusaha, hdar.jam, hdar.tanggaldar, hdar.status, hdar.sudahbaca, hdar.tanggal, hdar.nodar, hdar.urid FROM hdar INNER JOIN masteruser ON masteruser.id=hdar.iduser WHERE tanggal BETWEEN CAST('".$tglstart."' AS DATE) AND CAST('".$tglend."' AS DATE) AND (hdar.iduser='".$iduser."' OR hdar.ke='".$iduser."' OR hdar.ke2='".$iduser."' OR hdar.ke3='".$iduser."' OR hdar.ke4='".$iduser."' OR hdar.ke5='".$iduser."') ORDER BY hdar.tanggal DESC, hdar.jam DESC";

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




$infodar = "SELECT masteruser.nama, masteruser.departemen, masteruser.unitusaha, hdar.status, hdar.sudahbaca, hdar.tanggaldar, hdar.jam, hdar.tanggal, hdar.nodar FROM hdar INNER JOIN masteruser ON masteruser.id=hdar.iduser WHERE (hdar.iduser='".$iduser."' OR hdar.ke='".$iduser."' OR hdar.ke2='".$iduser."' OR hdar.ke3='".$iduser."' OR hdar.ke4='".$iduser."' OR hdar.ke5='".$iduser."' ) AND (hdar.activity LIKE '".$searchingg."' OR hdar.plan LIKE '".$searchingg."' OR hdar.result LIKE '".$searchingg."' OR masteruser.nama LIKE '".$searchingg."') ORDER BY hdar.tanggal DESC, hdar.jam DESC;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);



    }
    else{

if($_SESSION["readfilter"] == "1"){
  $infodar = "SELECT masteruser.nama, masteruser.departemen, masteruser.unitusaha, hdar.status, hdar.sudahbaca, hdar.tanggaldar, hdar.jam, hdar.tanggal, hdar.nodar FROM hdar INNER JOIN masteruser ON masteruser.id=hdar.iduser WHERE (hdar.iduser='".$iduser."' OR hdar.ke='".$iduser."' OR hdar.ke2='".$iduser."' OR hdar.ke3='".$iduser."' OR hdar.ke4='".$iduser."' OR hdar.ke5='".$iduser."' ) AND sudahbaca NOT LIKE '%".$iduser."|%' ORDER BY hdar.tanggal DESC, hdar.jam DESC LIMIT 70;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);  
    
}else{
    $infodar = "SELECT masteruser.nama, masteruser.departemen, masteruser.unitusaha, hdar.status, hdar.sudahbaca, hdar.tanggaldar, hdar.jam, hdar.tanggal, hdar.nodar FROM hdar INNER JOIN masteruser ON masteruser.id=hdar.iduser WHERE (hdar.iduser='".$iduser."' OR hdar.ke='".$iduser."' OR hdar.ke2='".$iduser."' OR hdar.ke3='".$iduser."' OR hdar.ke4='".$iduser."' OR hdar.ke5='".$iduser."' ) ORDER BY hdar.tanggal DESC, hdar.jam DESC LIMIT 70;";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);
    
}



}

} 



else {

$zzz = "5";    
    
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
    <link href="js/table/dataaTables.bootstrap4.min.css" rel="stylesheet">

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
        
        .badge-pendingabsence {
         background-color: teal;
        }
        
          .badge-decline {
         background-color: black;
        }
        
          .badge-absence {
         background-color: blue;
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
			 <a href="logoutt.php" id="untuklogout" >
			     </a>
			<!-- letakkan isi konten disini ! -->
              <section class="dar mb-5">
                <div class="container-fluid">
               
                       <!-- DataTales Example -->
                          <div class="card shadow mb-4">
                            <div class="card-header py-3">
                             <h4 class="card-title m-0 text-uppercase font-weight-bold">Report Per Day</h4>
                            </div>
                                <div class="card-body d-flex justify-content-between align-items-center">
                              
                                 <div class="row">
                                    <label> 
                                <h6 style="display:flex;justify-content:center;">Period Filter:</h6>
                                  <div class='col-sm-3' style="max-width:100%;flex-basis:100%;">
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
                                   </label>
                                 </div>
                                 
                                  
                                 <div class="row" style="<?php echo $aktifbaca ; ?>">
                                      <label> 
                                     <h6 style="display:flex;justify-content:center;">Read Filter:</h6>
                                  <div class='col-sm-3' style="max-width:100%;flex-basis:100%;">
                                    <div class="form-group">
                                        <div class='' id=''>
                                    
                                        <form method="POST" action="">
                                <!--    <input type="text" class="form-control" name="datefilter"  id="datefilter"> -->
                                     <button type="submit" name="aktifbaca" id="aktifbaca" value="aktifbaca" class="btn btn-outline-dark form-group">
                                  Not Active
                                     </button>
                                     
                                     </form>
                                     
                                     
                                            <span class="add-on"><i class="icon-remove"></i></span>
                                        </div>
                                    </div>
                                   </div>
                                    </label> 
                                 </div>
                                 
                                    <div class="row" style="<?php echo $bacatidakaktif ; ?>">
                                      <label> 
                                     <h6 style="display:flex;justify-content:center;">Read Filter:</h6>
                                  <div class='col-sm-3' style="max-width:100%;flex-basis:100%;">
                                    <div class="form-group">
                                        <div class='' id=''>
                                    
                                        <form method="POST" action="">
                                <!--    <input type="text" class="form-control" name="datefilter"  id="datefilter"> -->
                                      <button type="submit" style="color:white;" name="bacatidakaktif" id="bacatidakaktif" value="bacatidakaktif" class="btn btn-outline-dark btn-success form-group">
                                    Active
                                     </button>
                                     </form>
                                     
                                     
                                            <span class="add-on"><i class="icon-remove"></i></span>
                                        </div>
                                    </div>
                                   </div>
                                    </label> 
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
                                      <th>Company</th>    
                                      <th>Dept </th>
                                      <th>Name</th>
                                      <th>DAR Date</th>
                                      <th>DAR Sent</th>
                                      <th>Status</th>
                                      <th style="display:none" >Tag</th>
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
                      }elseif($status == "late2"){
                $echosts = '<span class="badge badge-late">Late2</span>';  
                           $echostatus = 'bgcolor="orange"'; 
                      }elseif($status == "over"){
                $echosts = '<span class="badge badge-danger">Over</span>';  
                           $echostatus = 'bgcolor="red"'; 
                      }elseif($status == "Pending Absence"){
                $echosts = '<span class="badge badge-pendingabsence" style="color:white;">Pending Absence</span>';  
                           $echostatus = 'bgcolor="Blue"'; 
                      }elseif($status == "Absence"){
                $echosts = '<span class="badge badge-absence" style="color:white;">Absence</span>';  
                           $echostatus = 'bgcolor="Blue"'; 
                      }elseif($status == "Decline"){
                $echosts = '<span class="badge badge-decline" style="color:white;">Decline</span>';  
                           $echostatus = 'bgcolor="Blue"'; 
                      }
                      
                      else{
                     $echosts = '<span class="badge badge-success">Ontime</span>';
                           $echostatus = 'bgcolor="green"'; 
                      }
                       $tggldar = $arrayrdar[$x]["tanggaldar"];
                       $mydate = strtotime($tggldar);
                       
                       $wktu = $arrayrdar[$x]["jam"];
                       $tg = $arrayrdar[$x]["tanggal"];
                       
                       $mytg = strtotime($tg);
                       $mywkt = strtotime($wktu);
                       
                       $mydatesent = $mytg.$mywkt;
                  ?>
                
                 
                  <tr> 
                    <td scope="row"> <a style="font-weight:<?php echo $sama ?>;" id="linkk" href="reportdetail.php?idnya=<?php echo $arrayrdar[$x]["nodar"] ?>"><?php echo $arrayrdar[$x]["unitusaha"] ?></td> </a>
                    <td scope="row"> <a style="font-weight:<?php echo $sama ?>;" id="linkk" href="reportdetail.php?idnya=<?php echo $arrayrdar[$x]["nodar"] ?>"><?php echo $arrayrdar[$x]["departemen"] ?></td> </a>
                    <td><a style="font-weight:<?php echo $sama ?>;" id="linkk" href="reportdetail.php?idnya=<?php echo $arrayrdar[$x]["nodar"] ?>"><?php echo $arrayrdar[$x]["nama"] ?></td></a>
                    <td data-sort="<?php echo $mydate; ?>"><a style="font-weight:<?php echo $sama ?>;" id="linkk" href="reportdetail.php?idnya=<?php echo $arrayrdar[$x]["nodar"] ?>"><?php 
                 $tanggaldar = $arrayrdar[$x]["tanggaldar"];
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
                    <td data-sort="<?php echo $mydatesent; ?>"><a style="font-weight:<?php echo $sama ?>;" id="linkk" href="reportdetail.php?idnya=<?php echo $arrayrdar[$x]["nodar"] ?>"><?php
                    $tanggal = $arrayrdar[$x]["tanggal"];
                  //  echo $arrayrdar[$x]["jam"] 
                  
 $pecahtgl = explode("-", $tanggal);
$day = $pecahtgl[2];
$mon = $pecahtgl[1];
$yer = $pecahtgl[0];

$tgl = $day .'-'. $mon .'-'. $yer;
/*
$dateObj   = DateTime::createFromFormat('!m', $mon);
$monthName = $dateObj->format('F'); // March
*/
$tgl = $day .'-'. $mon .'-'. $yer;                  

$jam = $arrayrdar[$x]["jam"];
$pecahjam = explode(":", $jam);
$hor = $pecahjam[0];
$min = $pecahjam[1];
/*
$dateObj   = DateTime::createFromFormat('!m', $mon);
$monthName = $dateObj->format('F'); // March
*/

$jamm = $hor .':'. $min;

$darsend = $tgl.' / '.$jamm;
echo $darsend;                  
         
                    
                    
                    
                   ?></td></a>
                   
                   <td ><a style="font-weight:<?php echo $sama ?>;" id="linkk" href="reportdetail.php?idnya=<?php echo $arrayrdar[$x]["nodar"] ?>"><?php echo $echosts ?></td></a>
          
                   
                   
                    <td style="display:none" ><a id="linkk" style="font-weight:<?php echo $sama ?>;" href="reportdetail.php?idnya=<?php echo $arrayrdar[$x]["nodar"] ?>"><?php echo $arrayrdar[$x]["tag"] ?></td></a>
          
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
    stateSave: true,
   
   "aaSorting": []
    });
    
    $("#dataTablee_filter").html('<form action="" method="post"><label>Search<input type="text" name="searching"> <input style="display:none;" type="submit" name="cari"> </label> </form>');
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