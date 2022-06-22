<?php 
session_start();
include "config.php";
$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;
$keuser2 = $_SESSION["Ke2"];
$keuser3 = $_SESSION["Ke3"];
$keuser4 = $_SESSION["Ke4"];
$keuser5 = $_SESSION["Ke5"];

$q = 0;
date_default_timezone_set('Asia/Jakarta');

$datee = date('Y-m-d');
$dateee = date('d-m-Y');
$tglhariini = date('Y-m-d');

$jam = date('H:i');
$day = date('d');
$year = date('Y');
 
$monthNum  = date('m');
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
$monthName = $dateObj->format('F'); // March



$tanggal = "$day $monthName $year"; 


switch ($monthNum) {
    case 1:
       $bln = "januari";
        break;
    case 2:
        $bln = "februari";
        break;
    case 3:
       $bln = "maret";
        break;
    case 4:
       $bln = "april";
        break;
    case 5:
      $bln = "mei";
        break;
    case 6:
        $bln = "juni";
        break;
    case 7:
      $bln = "juli";
        break;
    case 8:
       $bln = "agustus";
        break;
    case 9:
      $bln = "september";
        break;
    case 10:
     $bln = "oktober";
        break;
    case 11:
        $bln = "november";
        break;
    case 12:
       $bln = "desember";
        break;
    default:
        echo "Your favorite color is neither red, blue, nor green!";
}



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






if($_SESSION["IDUser"] == 0){
header("Location: http://sidar.id/login");
    }
    


 
 $zzz = "1";
 
 $infotodo = "";
$querytodo = "";
$arraytodo = "";

   
$infotodo = "SELECT * FROM draftddar WHERE iduser='".$iduser."' ";
$querytodo = $conn->query($infotodo);
$arraytodo = mysqli_fetch_all($querytodo, MYSQLI_ASSOC);


$ambilstatustanggalibur = "SELECT * FROM mastertanggal 
   WHERE $bln = 'libur'";
   $queryambilstatustanggalibur =$conn->query($ambilstatustanggalibur);
  $jumlahlibur = count($arraytgl);

 //$statuslibur = $rowambilstatustanggalibur['id'];
 
   
 if($queryambilstatustanggalibur->num_rows){

$rowambilstatustanggalibur = mysqli_fetch_all($queryambilstatustanggalibur, MYSQLI_ASSOC);


$t = 0;
$daftartanggalibur[$t];
for ($x = 0; $x < count($rowambilstatustanggalibur); $x++) {
   $daftartanggalibur[$t] = $rowambilstatustanggalibur[$x]["id"]. "-" .$monthNum. "-".$year ;
   $t++;
}


 $jumlahlibur = count($rowambilstatustanggalibur);


 if($statuslibur == "libur"){
     
  //   $display = "display:none;";
     
 }else{
     
 }

 }else{
    // header("location: http://www.icg.id/beta/dar/login");
   echo " gak dapat libur ";
 }



 $ambilstatustanggaldar = "SELECT * FROM hdar 
   WHERE iduser = '".$iduser."' ORDER BY tanggaldar DESC;";
   $queryambilstatustanggaldar = $conn->query($ambilstatustanggaldar);
 if($queryambilstatustanggaldar->num_rows){
  
 $rowambilstatustanggaldar = mysqli_fetch_array($queryambilstatustanggaldar, MYSQLI_ASSOC);
 $statustanggaldar = $rowambilstatustanggaldar['tanggaldar'];
 


 }else{
    // header("location: http://www.icg.id/beta/dar/login");
    $arraytgl[0] = $datee;
 //  echo " gak dapat tanggaldar ";
 }

$ststgldar = new DateTime($statustanggaldar);
$ststgldar->modify('+1 day');
$tglterakhirdar = $ststgldar->format('Y-m-d'); 

 
$tanggal1 = new DateTime($tglterakhirdar);
$tanggal2 = new DateTime();
$tanggaldiff = date_diff($tanggal1,$tanggal2);
//$perbedaan = $tanggal2->diff($tanggal1)->format("%a");
$perbedaan = $tanggaldiff->format("%a%");
 
if ($arraytgl[0] == $dateee || $perbedaan == 0 || $datee == $statustanggaldar   ){
    
$displayselect = "display:none;";
$arraytgl[0] = $dateee;    
    
}else {
    
    
    
$displayselect = "";
$begin = new DateTime($tglterakhirdar);
$end = new DateTime('tomorrow');;


$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

$z = 0;
$arraytgl[$z];
foreach ($period as $dt) {
  $arraytgl[$z] = $dt->format("d-m-Y");
    
    $z++;
  //  count($arraytgl);
    //unset($arrayku[2]);
}

}
   for($p = 0; $p <  sizeof($daftartanggalibur); $p++){
  for($x = 0; $x <  sizeof($arraytgl); $x++){
    //    $tmptgl = $arraytgl[$x];
    //     $tmptglibur = $daftartanggalibur[$p];
      if ($arraytgl[$x] == $daftartanggalibur[$p]){
        // unset($arraytgl[$x]);
       array_splice($arraytgl, $x, 1);
      }
  }

  }
//  $arraytgl[$x+1] = "";

// unset($arraytgl[]);

 $ambilstatus = "SELECT * FROM masteruser 
   WHERE id = '" .$iduser. "' ;";
   $queryambilstatus =$conn->query($ambilstatus);
 if($queryambilstatus->num_rows){

 $rowambilstatus = mysqli_fetch_array($queryambilstatus, MYSQLI_ASSOC);
 $statuskirim = $rowambilstatus['sudahkirim'];
 $keuser = $rowambilstatus['ke'];
 $keuserdua = $rowambilstatus['ke2'];
 $keusertiga = $rowambilstatus['ke3'];
 $keuserempat = $rowambilstatus['ke4'];
 $keuserlima = $rowambilstatus['ke5'];
 $jabatan = $rowambilstatus['jabatan'];
 
 if($statuskirim == "sudah"){
     
     $display = "display:none;";
     
 }else{
     
 }


 }else{
    // header("location: http://www.icg.id/beta/dar/login");
   echo " gak dapat status ";
 }



 $ambilnomer = "SELECT nodar FROM hdar 
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
    $satu = "1";
   //echo " gak dapat nomer ";
   $nodarnya = $iduser."/".$satu;
 }




 $ambiltgldarakhir = "SELECT tanggal FROM hdar ORDER BY urid DESC LIMIT 1 ;";
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

   
   if ($arraytgl[0] == $dateee || $perbedaan == 0 || $datee == $statustanggaldar   ){
    
$displayselect = "display:none;";
//$arraytgl[0] = $dateee;    
  
   }else{
       
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

    <!-- Custom table for this page -->
    <link href="js/table/dataaTables.bootstrap4.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/responsive/2.2.4/css/responsive.dataTables.min.css" rel="stylesheet">

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

 
    <style type="text/css">
    table.dataTable tr.dtrg-group td{
    background-color:#e0e0e0
}
table.dataTable tr.dtrg-group.dtrg-level-0 td{
    font-weight:bold;
    border-bottom: 2px solid #636262
}
table.dataTable tr.dtrg-group.dtrg-level-1 td,table.dataTable tr.dtrg-group.dtrg-level-2 td{
    background-color:#f0f0f0;
    padding-top:0.25em;
    padding-bottom:0.25em;
    padding-left:2em;
    font-size:0.9em
}
table.dataTable tr.dtrg-group.dtrg-level-2 td{
    background-color:#f3f3f3
}

    </style>
    
       <style type="text/css">
       
       td.control {
    background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
    cursor: pointer;
}
tr.shown td.control {
    background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
}
       
       [type="date"] {
  background:#fff url(https://cdn1.iconfinder.com/data/icons/cc_mono_icon_set/blacks/16x16/calendar_2.png)  97% 50% no-repeat ;
}
[type="date"]::-webkit-inner-spin-button {
  display: none;
   -webkit-appearance: none;
  margin: 0;
}
[type="date"]::-webkit-calendar-picker-indicator {
  opacity: 0;
  position: absolute;
  width: 100%;
  height: 20px;
  
}
       
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
        
        .text {
    min-height: 170px;
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
                             <h4 class="card-title m-0 text-uppercase font-weight-bold">New DAR </h4>
                            </div>
                                <div class="card-body d-flex justify-content-between align-items-center">
                              
                                 
                                  
                                 <div class="row" style="<?php echo $aktifbaca ; ?>">
                                      <label> 
                                  <!--   <h6 style="display:flex;justify-content:center;">Add ToDo:</h6> -->
                                  <div class='col-sm-3' style="max-width:100%;flex-basis:100%;">
                                    <div style="<?php echo $displayselect;?>" class="form-group">
              
                 <?php $late2endmn = "16:00:00"; ?>
                   <label style="color:red;" for="TglDar">Belum Kirim DAR</label><br>
                       <label style="color:red;" for="TglDar">DAR Date</label>
                              <select name="tanggaldar" id="TglDar" style="width:70%; display:inline-block; color:red;" class="form-control">
                              <option value="<?php echo $arraytgl[0];?>" ><?php echo $arraytgl[0];?></option>
                              
                            </select>
                            
              
                                    </div>
                                   </div>
                                    </label> 
                                 </div>
                                 
                                 
                                    <div class="row" style="<?php echo $bacatidakaktif ; ?>">
                                      <label> 
                                 <!--    <h6 style="display:flex;justify-content:center;">Read Filter:</h6> -->
                                  <div class='col-sm-3' style="max-width:100%;flex-basis:100%;">
                                    <div class="form-group">
                                        <div class='' id=''>
                                    
                                    
                                    <div class="dropdown">
                                        <form method="post" action="datadar.php">
                                        <div id="dropCardHeader" aria-haspopup="true" aria-expanded="false">
                                        <input type="text" style="display:none;" name="nodar" value="<?php echo $nodarnya;?>">        
                                        <input type="text" style="display:none;" name="tanggaldar" value="<?php echo $arraytgl[0];?>">
                                        <input name="iduser" style="display:none;" type="text"  id="iduser" value="<?php echo $iduser; ?>">
                                        <input name="keuser" style="display:none;" type="text" id="keuser" value="<?php echo $keuser; ?>">
                                        <input name="kedua" style="display:none;" type="text" id="keuser" value="<?php echo $keuserdua; ?>">
                                        <input name="ketiga" style="display:none;" type="text" id="keuser" value="<?php echo $keusertiga; ?>">
                                        <input name="keempat" style="display:none;" type="text" id="keuser" value="<?php echo $keuserempat; ?>">
                                        <input name="kelima" style="display:none;" type="text" id="keuser" value="<?php echo $keuserlima; ?>">
                                        <input name="jabatan" style="display:none;" type="text" id="keuser" value="<?php echo $jabatan; ?>">   
                                        <input type="text" style="display:none;" name="nodar" value="<?php echo $nodarnya;?>">    
                                        <button type="submit" class="btn btn-outline-dark" id="myBtn" name="btdar" value="kirimdar">
                                        <i class="fa fa-plane"></i> SEND DAR
                                        </button>
                                     
                                        </div>
                                         </form> 
                                    </div>
                                     
                                     
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
                                <table class="table table-bordered display" id="dataTablee" width="100%" cellspacing="0">
                                  <thead>
                                    <tr>
                                      <th></th>
                                      <th>Target/Objective</th>    
                                      <th>Todo </th>
                                      <th>Result</th>
                                      <th class="none">Explanation :</th>
                                      <th class="none">Proof :</th>
                                      <th>Due Date</th>
                                      <th>Edit</th>
                                 
                                    </tr>
                                  </thead>
                         
                                  <tbody>
                                                             <?php
                for($x = 0; $x < sizeof($arraytodo); $x++){
        $idtd = $arraytodo[$x]["iddetdar"];            
        $ambilattach = "SELECT * FROM draftattach WHERE iddetdar = '" .$idtd . "';";
        $queryattach = $conn->query($ambilattach);
        $arrayrattach = mysqli_fetch_all($queryattach, MYSQLI_ASSOC);

                  ?>
                
                 
                  <tr> 
                 <td class="dtr-control text-center"></td>
                 <td class="align-middle" scope="row"> <?php echo $arraytodo[$x]["target"] ?></td> 
                 <td class="align-middle" scope="row"> <?php echo $arraytodo[$x]["activity"] ?></td>
                 <td class="align-middle"><?php echo $arraytodo[$x]["result"] ?></td>
                 <td class="align-middle"> <li class="attachment-list"><?php echo $arraytodo[$x]["explaination"] ?></li></td>
                 <td class="align-middle">                <?php
                for($v = 0; $v < sizeof($arrayrattach); $v++){
                  ?>
                  
                       
           
                    <li class="attachment-list">
                    <a href="img/<?php echo $iduser ?>/<?php echo $arrayrattach[$v]["img"] ?>" class="attachment-link" target="blank"><?php echo $arrayrattach[$v]["img"] ?></a>
                            </li>
                   
               
                  
                  <?php } ?>
                  
                 
                 
                 </td>
     
                    <td class="align-middle" data-sort="<?php echo $mydatesent; ?>"><?php
                    $tanggal = $arraytodo[$x]["duedate"];
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
echo $tgl;                  
         
                    
                    
                    
                   ?></td>
                   
                   <td class="align-middle">    <button class="btn btn-outline-dark" id="myBtn" data-toggle="modal" data-target="#myModal" data-id="<?php echo $arraytodo[$x]["iddetdar"] ; ?>">Edit </button></td>
            
                   
                 
          
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

   <div class="modal fade" id="myModaladd" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                     <h5 class="modal-title">ADD DAR</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                   
                </div>
                <form method="post" action="datadardetail.php">
                <div class="modal-body">
                    <div class="fetched-data"></div>
                       <input style="display:none" type="text" class="form-control" name="iduser" id="iduser" />
                </div>
                <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn btn-primary submitBtn" name="tbdar" value="adddar" >ADD</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                     <h5 class="modal-title">EDIT DAR</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                   
                </div>
                <form class="modaldaredit" method="post" action="datadardetailedit.php">
                <div class="modal-body">
                    <div class="fetched-datad"></div>
                    
                       <input style="display:none" type="text" class="form-control" name="iduserr" id="iduserr" />
                </div>
                <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn btn-primary submitBtn" name="tbdar" value="adddar" id="editbtn">SAVE</button>
                </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Quil editor JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>


<script>
var formd = document.querySelector('.modaldaredit');
formd.onsubmit = function() {

var explanationd =  document.querySelector('input[name=explanationd]');
explanationd.value = quill.root.innerHTML;

xmlhttp.open("POST", "datadardetailedit.php", true);
xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xmlhttp.send("explanationd=" + explanationd);

};


</script>

    



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

  





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  
<script>
    $(document).ready(function(){
        $('#myModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
          //  alert("hello");
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'detailmodaledit.php',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-datad').html(data);//menampilkan data ke dalam modal
                }
            });
         });
$('#myModal').on('hidden.bs.modal', function () {
 location.reload();
})
    });
</script> 

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    
<script>
$(document).ready(function(){
 $(document).on('change', '#file', function(){
  var iddetdar = document.getElementById('iddetdar').value;
  var idusr = document.getElementById('idusr').value;
  var name = document.getElementById("file").files[0].name;
  var form_data = new FormData();
  var ext = name.split('.').pop().toLowerCase();
  if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1)
  {
   alert("Invalid Image File");
  }
  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("file").files[0]);
  var f = document.getElementById("file").files[0];
  var fsize = f.size||f.fileSize;
  if(fsize > 2000000)
  {
   alert("Ukuran File Gambar Terlalu Besar Maksimal 2MB");
  }
  else
  {
   var iddetdarr = document.getElementById('iddetdar').value;
   var idusr = document.getElementById('idusr').value;
   form_data.append("iddetdar", iddetdarr);
   form_data.append("idusr", idusr);
   form_data.append("file", document.getElementById('file').files[0]);
   $.ajax({
    url:"upload.php",
    method:"POST",
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend:function(){
     $('#uploaded_image').html("<label class='text-success'>Sedang Mengupload Gambar...</label>");
    },
    success:function(data)
    {
     $('#uploaded_image').html(data);
    }
   });
  }
  $('#file').val('');
 });
});
</script>



<script>
/*
$(document).ready(function(){
 $(document).on('change', '#filed', function(){
  var name = document.getElementById("filed").files[0].name;
  var form_data = new FormData();
  var ext = name.split('.').pop().toLowerCase();
  if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1)
  {
   alert("Invalid Image File");
  }
  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("filed").files[0]);
  var f = document.getElementById("filed").files[0];
  var fsize = f.size||f.fileSize;
  if(fsize > 2000000)
  {
   alert("Ukuran File Gambar Terlalu Besar Maksimal 2MB");
  }
  else
  {
   var iddetdar = document.getElementById('iddetdar').value;
   form_data.append("iddetdar", iddetdar);
   form_data.append("file", document.getElementById('filed').files[0]);
   $.ajax({
    url:"uploaded.php",
    method:"POST",
    data:form_data,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend:function(){
     $('#uploaded_imaged').html("<label class='text-success'>Sedang Mengupload Gambar...</label>");
    },
    success:function(data)
    {
     $('#uploaded_imaged').html(data);
    }
   });
  }
  $('#filed').val('');
 });
});
*/
</script>
    

   
    <script>
    
      $(document).ready(function(){
        $('#dataTablee').DataTable({
    stateSave: true,
  responsive: true,

   bInfo : false,
   bPaginate: false,
   bFilter: false,
        order: [[1, 'asc']],
     rowGroup: {
          dataSrc: 1
    },
   
  
   "aaSorting": []
    });
    
    //$("#dataTablee_filter").html('<form action="" method="post"><label>Search<input type="text" name="searching"> <input style="display:none;" type="submit" name="cari"> </label> </form>');
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

 <script src="https://cdn.datatables.net/responsive/2.2.4/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/rowgroup/1.1.2/js/dataTables.rowGroup.min.js"></script>

    
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