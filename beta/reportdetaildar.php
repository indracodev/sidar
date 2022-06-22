<?php 
session_start();
$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;
$nodar =  $_SESSION["Nodar"] ;

//$idnya = $_POST["idnya"];
$idnya = $_GET["idnya"];
$targt = $_GET["target"];
$pecah = explode("/", $idnya);
$hasil = $pecah[0];
$hasiliduser = $pecah[0];
$nodarnya = $iduser."/".$hasil;
date_default_timezone_set('Asia/Jakarta');
$tggl = date('Y-m-d');
$waktu = date('H:i');

$wktgl = "|". $tggl.";".$waktu;
/*
if($iduser != $hasil){
header("Location: http://sidar.id/report.php");
    }
*/

if($_SESSION["IDUser"] == 0){
header("Location: http://sidar.id/login");
    }
    
include "config.php";

$bolehakses;

$ambilidke = "SELECT id FROM masteruser WHERE id = '" .$iduser . "' OR ke = '" .$iduser . "' OR ke2 = '" .$iduser . "' OR ke3 = '" .$iduser . "' OR ke4 = '" .$iduser . "' OR ke5 = '" .$iduser . "';";
$queryambilidke =$conn->query($ambilidke);

$rowambilidke = mysqli_fetch_all($queryambilidke, MYSQLI_ASSOC);

for ($x = 0; $x < count($rowambilidke); $x++) {
 if($rowambilidke[$x]["id"] == $hasil){
     $bolehakses = 'boleh';
 }else{
   //  $bolehakses = 'tidak';
 } 
 
}

if($bolehakses != 'boleh'){
header("Location: http://sidar.id/report.php");
    }

$ambildar = "SELECT masteruser.nama, masteruser.departemen, hdar.sudahbaca, hdar.tanggaldar, hdar.jam, hdar.tanggal
FROM hdar INNER JOIN masteruser ON masteruser.id=hdar.iduser WHERE nodar = '" .$idnya . "';";

$ambilattach = "SELECT * FROM masterattach WHERE nodar = '" .$idnya . "';";
$queryattach =$conn->query($ambilattach);
$arrayrattach = mysqli_fetch_all($queryattach, MYSQLI_ASSOC);


$infotodo = "SELECT * FROM ddar WHERE nodar='".$idnya."' AND target='".$targt."' ";
$querytodo = $conn->query($infotodo);
$arraytodo = mysqli_fetch_all($querytodo, MYSQLI_ASSOC);



//$ambildar = "SELECT * FROM dar 
// WHERE nodar = '" .$idnya . "';";
 $querydar =$conn->query($ambildar);
 if($querydar->num_rows){
   session_start();
   $row = mysqli_fetch_array($querydar, MYSQLI_ASSOC);
   $daractivity = $row['activity'];
   $darplan = $row['plan'];
   $dartag = $row['tag'];
   $darresult = $row['result'];
   $tanggaldar = $row['tanggaldar'];
   $tanggal = $row['tanggal'];
   $jam = $row['jam'];
   $nama = $row['nama'];
   $dept = $row['departemen'];
   
   $sudahbaca = $row['sudahbaca'];


 }
 else{
    // header("location: http://www.icg.id/beta/dar/login");
   echo " gak dapat dar ";
 }
 
 $pecahsudahbaca = explode("/", $sudahbaca);
 $sdbc1 = $pecahsudahbaca[0];
 $sdbc2 = $pecahsudahbaca[1];
 $sdbc3 = $pecahsudahbaca[2];
 $sdbc4 = $pecahsudahbaca[3];
 $sdbc5 = $pecahsudahbaca[4];
 $sdbc6 = $pecahsudahbaca[5];
 
 $idbc01 = explode("|", $sdbc1);
 $idbc1 = $idbc01[0];
 $idbc02 = explode("|", $sdbc2);
 $idbc2 = $idbc02[0];
 $idbc03 = explode("|", $sdbc3);
 $idbc3 = $idbc03[0];
 $idbc04 = explode("|", $sdbc4);
 $idbc4 = $idbc04[0];
 $idbc05 = explode("|", $sdbc5);
 $idbc5 = $idbc05[0];
 $idbc06 = explode("|", $sdbc6);
 $idbc6 = $idbc06[0];


 
 $ius = "$iduser";
 
 if($sudahbaca == ""){
    $sudahbaca = $iduser . $wktgl . "/";
    $kirimsudahbaca .= "UPDATE dar SET sudahbaca='" .$sudahbaca . "' WHERE nodar = '" .$idnya . "' ";      
if ($conn->query($kirimsudahbaca) === TRUE) {
}else{
    
} 


 }elseif ($sudahbaca != "" && $idbc1 != $iduser && $idbc2 != $iduser && $idbc3 != $iduser && $idbc4 != $iduser && $idbc5 != $iduser && $idbc6 != $iduser){
 $sudahbaca = $sudahbaca . $iduser . $wktgl . "/"; 
     
     $kirimsudahbaca .= "UPDATE dar SET sudahbaca='" .$sudahbaca . "' WHERE nodar = '" .$idnya . "' ";      
if ($conn->query($kirimsudahbaca) === TRUE) {
}else{
    
} 


 }else{
     
 }
 
  
 
$pecahtgldar = explode("-", $tanggaldar);
$daydar = $pecahtgldar[2];
$mondar = $pecahtgldar[1];
$yerdar = $pecahtgldar[0];
/*
$dateObj   = DateTime::createFromFormat('!m', $mon);
$monthName = $dateObj->format('F'); // March
*/
$tgldar = $daydar .'-'. $mondar .'-'. $yerdar;
 
 

$pecahtgl = explode("-", $tanggal);
$day = $pecahtgl[2];
$mon = $pecahtgl[1];
$yer = $pecahtgl[0];
/*
$dateObj   = DateTime::createFromFormat('!m', $mon);
$monthName = $dateObj->format('F'); // March
*/
$tgl = $day .'-'. $mon .'-'. $yer;

$namadownload = "report" . " ". $nama. $tgl . ".pdf" ;


$pecahjam = explode(":", $jam);
$hor = $pecahjam[0];
$min = $pecahjam[1];

$jamm = $hor .':'. $min;

$darsent = $tgl.';'.$jamm;
    
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

    <link href="https://cdn.datatables.net/responsive/2.2.4/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowgroup/1.1.2/css/rowGroup.dataTables.min.css" rel="stylesheet">



    <!-- inner style -->
    <style type="text/css">
    	
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
                            <div class="kiri" >
                            <form method="post" action="report.php">
                            <button type="submit" class="btn btn-outline-dark border-0">
                                <i class="fa fa-reply"></i> Back
                            </button>
                            </form>
                          
                        </div><!-- end kolom kiri -->
                            </div>
                                <div class="mt-3 d-flex flex-row-reverse align-items-center">
                             
                             
                                 
                                 
                                    <div class="row" style="<?php echo $bacatidakaktif ; ?>">
                                      <label> 
                                 <!--    <h6 style="display:flex;justify-content:center;">Read Filter:</h6> -->
                                  <div class='col-sm-3' style="max-width:100%;flex-basis:100%;">
                                    <div class="form-group">
                                        <div class='' id=''>
                                    
                                    
                                    <div class="kanan text-right mt-2">
                            
                                
                            
                                  <div class="tanggal-report" style="height: 20px;">
                                   <label class="font-weight-bold" style="width:50px;text-align: left;">Name    </label>
                                    <label class="font-weight-bold" style="width:190px;text-align: left;">: <?php echo $nama; ?> </label>
                            
                            </div>
                            
                            <div class="tanggal-report" style="height: 20px;">
                                   <label class="font-weight-bold" style="width:94px;text-align: left;">Department  </label>
                                   <label class="font-weight-bold" style="width:190px;text-align: left;">: <?php echo $dept; ?></label>
                            
                            </div>
                       
                            <div class="tanggal-report" style="height: 20px;">
                                   <label class="font-weight-bold" style="width:79px;text-align: left;">DAR Date  </label>
                                    <label class="font-weight-bold" style="width:190px;text-align: left;">: <?php echo $tgldar; ?> </label>
                            
                            </div>
                            
                            <div class="tanggal-report">
                                   <label class="font-weight-bold" style="width:79px;text-align: left;">DAR Sent  </label>
                                    <label class="font-weight-bold" style="width:190px;text-align: left;">: <?php echo $darsent; ?> </label>
                            
                            </div>
                        </div><!-- end kolom kanan -->
                                     
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
                                   
                                 
                                      <th>Todo </th>
                                      <th>Result</th>
                                      <th >Explaination </th>
                                      <th class="none">Proof </th>
                                
                                      <th>Due Date</th>
                               
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
                
                    
                    <td class="align-middle" scope="row"> <a style="font-weight:<?php echo $sama ?>;" id="linkk" href="reportdetail.php?idnya=<?php echo $arraytodo[$x]["iddetdar"] ?>"><?php echo $arraytodo[$x]["activity"] ?></td> </a>
                    <td class="align-middle"><a style="font-weight:<?php echo $sama ?>;" id="linkk" href="reportdetail.php?idnya=<?php echo $arraytodo[$x]["idtodo"] ?>"><?php echo $arraytodo[$x]["result"] ?></td></a>
                 <td class="align-middle"> <li class="attachment-list"><?php echo $arraytodo[$x]["explaination"] ?></li></td>
                 <td class="align-middle">                <?php
                for($v = 0; $v < sizeof($arrayrattach); $v++){
                  ?>
                  
                       
           
                    <li class="attachment-list">
                    <a href="img/<?php echo $iduser ?>/<?php echo $arrayrattach[$v]["img"] ?>" class="attachment-link" target="blank"><?php echo $arrayrattach[$v]["img"] ?></a>
                            </li>
                   
               
                  
                  <?php } ?>
                  
                 
                 
                 </td>
     
                    <td class="align-middle" data-sort="<?php echo $mydatesent; ?>"><a style="font-weight:<?php echo $sama ?>;" id="linkk" href="reportdetail.php?idnya=<?php echo $arraytodo[$x]["idtodo"] ?>"><?php
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
         
                    
                    
                    
                   ?></td></a>
                   
             
                   
                 
          
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
                <form method="post" action="datadardetailedit.php">
                <div class="modal-body">
                    <div class="fetched-datad"></div>
                       <input style="display:none" type="text" class="form-control" name="iduser" id="iduser" />
                </div>
                <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn btn-primary submitBtn" name="tbdar" value="adddar" >EDIT</button>
                </div>
                </form>
            </div>
        </div>
    </div>






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
  

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
       <script>
    $(document).ready(function(){
        $('#myModaladd').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
          //  alert("hello");
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'detailmodal.php',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
</script> 

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

   bInfo : false,
   bPaginate: false,
   bFilter: false,

  
   "aaSorting": []
    });
    
   // $("#dataTablee_filter").html('<form action="" method="post"><label>Search<input type="text" name="searching"> <input style="display:none;" type="submit" name="cari"> </label> </form>');
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