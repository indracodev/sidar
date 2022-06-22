<?php 
session_start();
$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;
$keuser2 = $_SESSION["Ke2"];
$keuser3 = $_SESSION["Ke3"];
$keuser4 = $_SESSION["Ke4"];
$keuser5 = $_SESSION["Ke5"];
$namaa = $_SESSION["NMUser"];
$lokasikerja = $_SESSION["Lokasikerja"] ;
include "config.php";


$kodtanggal = '<section class="dar mb-5">
                <div class="container-fluid">
               
                       <!-- DataTales Example -->
                          <div class="card shadow mb-4">
                            <div class="card-header py-3">
                             <h4 class="card-title m-0 text-uppercase font-weight-bold">Set Holiday AFB</h4>
                            </div>
                                <div class="card-body">
                                 <h6>Setting Holiday :</h6>
                                 <div class="row">
                                  <div class="col-sm-5">
                                 
                           
                                     <form method="POST" action="setholidayy.php" >
                                      <label for="datepicker"></label>
                                      <input type="submit" class="form-control btn btn-danger" value="Submit Holiday" name="holiday"  id="holiday">
				                      <input type="text" name="isiholiday" class="form-control datepicker" id="datepickerafb">
                                     </form>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     
                                    
                                   
                                   </div>
                                 </div>
                                 </div>
                                 
                                 <br>
                                 <br>
                            
                                 
                                 <div class="card-body">
                                 <h6>Setting Workday :</h6>
                                 <div class="row">
                                  <div class="col-sm-5">
                                 
                           
                                    <form method="POST" action="setworkday.php" >
                                     <label for="datepicker"></label>
                                     <input type="submit" class="form-control btn btn-success" value="Submit Workday" name="workday"  id="workday">
				                     <input type="text" name="isiworkday" class="form-control datepicker" id="datepickerafb1">
                                    </form>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     
                                    
                                   
                                   </div>
                                 </div>
                                 </div>
                                 
                                 <br>
                                 
                               <div class="card-body">
                      
                  
                       
                              <div class="table-responsive">
                             
                              </div>
                            </div>
                          </div>
                      </div>
            </section>';

if ($namaa == "HRD IB" || $namaa == "HRD IGI Pasuruan" || $namaa == "HRD IGI Gresik" || $namaa == "HRD SDA" ){
    
}else{
header("Location: http://sidar.id/login");    
}  

if($_SESSION["IDUser"] == 0){
header("Location: http://sidar.id/login");
    }


if ($namaa == "HRD IB"){

$mastgl = 'mastertanggal1';

$infodar = "SELECT * FROM masteruser WHERE lokasikerja = 'ib' ";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);

} 

if ($namaa == "HRD IGI Pasuruan"){

$mastgl = 'mastertanggal2';

$infodar = "SELECT * FROM masteruser WHERE lokasikerja = 'IGI Purwosari' ";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);


} 

if ($namaa == "HRD IGI Gresik"){

$mastgl = 'mastertanggal3';

$infodar = "SELECT * FROM masteruser WHERE lokasikerja = 'IGI Bambe' ";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);

} 

if ($namaa == "HRD SDA"){

$mastgl = 'mastertanggal4';

$infodar = "SELECT * FROM masteruser WHERE lokasikerja = 'sda' ";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);


} 



else {

$zzz = "5";    
    
}

date_default_timezone_set('Asia/Jakarta');
$monthNum  = date('m');
$year = date('Y');

// $ambilstatustanggalibur = "SELECT * FROM mastertanggal WHERE $bln = 'libur'";
 $ambilstatustanggalibur = "SELECT * FROM $mastgl WHERE januari = 'libur' ";
 $queryambilstatustanggalibur =$conn->query($ambilstatustanggalibur); 

$rowambilstatustanggalibur = mysqli_fetch_all($queryambilstatustanggalibur, MYSQLI_ASSOC);

$t = 0;
$daftartanggalibur[$t];
for ($x = 0; $x < count($rowambilstatustanggalibur); $x++) {
   $daftartanggalibur[$t] = $rowambilstatustanggalibur[$x]["id"]. "/" .'1'. "/".$year ;
   $t++;
}

//--------------------------------------------------------------------------------------

 $ambilstatustanggalibur = "SELECT * FROM $mastgl WHERE februari = 'libur' ";
 $queryambilstatustanggalibur =$conn->query($ambilstatustanggalibur); 

$rowambilstatustanggalibur = mysqli_fetch_all($queryambilstatustanggalibur, MYSQLI_ASSOC);

for ($x = $t; $x < count($rowambilstatustanggalibur); $x++) {
   $daftartanggalibur[$t] = $rowambilstatustanggalibur[$x]["id"]. "/" .'2'. "/".$year ;
   $t++;
}

//--------------------------------------------------------------------------------------

 $ambilstatustanggalibur = "SELECT * FROM $mastgl WHERE maret = 'libur' ";
 $queryambilstatustanggalibur =$conn->query($ambilstatustanggalibur); 

$rowambilstatustanggalibur = mysqli_fetch_all($queryambilstatustanggalibur, MYSQLI_ASSOC);

$daftartanggalibur[$t];
for ($x = 0; $x < count($rowambilstatustanggalibur); $x++) {
   $daftartanggalibur[$t] = $rowambilstatustanggalibur[$x]["id"]. "/" .'3'. "/".$year ;
   $t++;
}

//--------------------------------------------------------------------------------------

 $ambilstatustanggalibur = "SELECT * FROM $mastgl WHERE april = 'libur' ";
 $queryambilstatustanggalibur =$conn->query($ambilstatustanggalibur); 

$rowambilstatustanggalibur = mysqli_fetch_all($queryambilstatustanggalibur, MYSQLI_ASSOC);


$daftartanggalibur[$t];
for ($x = 0; $x < count($rowambilstatustanggalibur); $x++) {
   $daftartanggalibur[$t] = $rowambilstatustanggalibur[$x]["id"]. "/" .'4'. "/".$year ;
   $t++;
}

//--------------------------------------------------------------------------------------

 $ambilstatustanggalibur = "SELECT * FROM $mastgl WHERE mei = 'libur' ";
 $queryambilstatustanggalibur =$conn->query($ambilstatustanggalibur); 

$rowambilstatustanggalibur = mysqli_fetch_all($queryambilstatustanggalibur, MYSQLI_ASSOC);

$daftartanggalibur[$t];
for ($x = 0; $x < count($rowambilstatustanggalibur); $x++) {
   $daftartanggalibur[$t] = $rowambilstatustanggalibur[$x]["id"]. "/" .'5'. "/".$year ;
   $t++;
}

//--------------------------------------------------------------------------------------

 $ambilstatustanggalibur = "SELECT * FROM $mastgl WHERE juni = 'libur' ";
 $queryambilstatustanggalibur =$conn->query($ambilstatustanggalibur); 

$rowambilstatustanggalibur = mysqli_fetch_all($queryambilstatustanggalibur, MYSQLI_ASSOC);

$daftartanggalibur[$t];
for ($x = 0; $x < count($rowambilstatustanggalibur); $x++) {
   $daftartanggalibur[$t] = $rowambilstatustanggalibur[$x]["id"]. "/" .'6'. "/".$year ;
   $t++;
}

//--------------------------------------------------------------------------------------

 $ambilstatustanggalibur = "SELECT * FROM $mastgl WHERE juli = 'libur' ";
 $queryambilstatustanggalibur =$conn->query($ambilstatustanggalibur); 

$rowambilstatustanggalibur = mysqli_fetch_all($queryambilstatustanggalibur, MYSQLI_ASSOC);

$daftartanggalibur[$t];
for ($x = 0; $x < count($rowambilstatustanggalibur); $x++) {
   $daftartanggalibur[$t] = $rowambilstatustanggalibur[$x]["id"]. "/" .'7'. "/".$year ;
   $t++;
}

//--------------------------------------------------------------------------------------

 $ambilstatustanggalibur = "SELECT * FROM $mastgl WHERE agustus = 'libur' ";
 $queryambilstatustanggalibur =$conn->query($ambilstatustanggalibur); 

$rowambilstatustanggalibur = mysqli_fetch_all($queryambilstatustanggalibur, MYSQLI_ASSOC);

$daftartanggalibur[$t];
for ($x = 0; $x < count($rowambilstatustanggalibur); $x++) {
   $daftartanggalibur[$t] = $rowambilstatustanggalibur[$x]["id"]. "/" .'8'. "/".$year ;
   $t++;
}

//--------------------------------------------------------------------------------------

 $ambilstatustanggalibur = "SELECT * FROM $mastgl WHERE september = 'libur' ";
 $queryambilstatustanggalibur =$conn->query($ambilstatustanggalibur); 

$rowambilstatustanggalibur = mysqli_fetch_all($queryambilstatustanggalibur, MYSQLI_ASSOC);

$daftartanggalibur[$t];
for ($x = 0; $x < count($rowambilstatustanggalibur); $x++) {
   $daftartanggalibur[$t] = $rowambilstatustanggalibur[$x]["id"]. "/" .'9'. "/".$year ;
   $t++;
}

//--------------------------------------------------------------------------------------

 $ambilstatustanggalibur = "SELECT * FROM $mastgl WHERE oktober = 'libur' ";
 $queryambilstatustanggalibur =$conn->query($ambilstatustanggalibur); 

$rowambilstatustanggalibur = mysqli_fetch_all($queryambilstatustanggalibur, MYSQLI_ASSOC);

$daftartanggalibur[$t];
for ($x = 0; $x < count($rowambilstatustanggalibur); $x++) {
   $daftartanggalibur[$t] = $rowambilstatustanggalibur[$x]["id"]. "/" .'10'. "/".$year ;
   $t++;
}

//--------------------------------------------------------------------------------------

 $ambilstatustanggalibur = "SELECT * FROM $mastgl WHERE november = 'libur' ";
 $queryambilstatustanggalibur =$conn->query($ambilstatustanggalibur); 

$rowambilstatustanggalibur = mysqli_fetch_all($queryambilstatustanggalibur, MYSQLI_ASSOC);


$daftartanggalibur[$t];
for ($x = 0; $x < count($rowambilstatustanggalibur); $x++) {
   $daftartanggalibur[$t] = $rowambilstatustanggalibur[$x]["id"]. "/" .'11'. "/".$year ;
   $t++;
}

//--------------------------------------------------------------------------------------

 $ambilstatustanggalibur = "SELECT * FROM $mastgl WHERE desember = 'libur' ";
 $queryambilstatustanggalibur =$conn->query($ambilstatustanggalibur); 

$rowambilstatustanggalibur = mysqli_fetch_all($queryambilstatustanggalibur, MYSQLI_ASSOC);


$daftartanggalibur[$t];
for ($x = 0; $x < count($rowambilstatustanggalibur); $x++) {
   $daftartanggalibur[$t] = $rowambilstatustanggalibur[$x]["id"]. "/" .'12'. "/".$year ;
   $t++;
}

//--------------------------------------------------------------------------------------

   $daftartanggalibur[$t] = '31/05/2020' ;
   $t++;
   $daftartanggalibur[$t] = '30/05/2020' ;
   $t++;
   $daftartanggalibur[$t] = '31/07/2020' ;
   $t++;

 $jumlahlibur = count($rowambilstatustanggalibur);

 

$p = 0;
for ($x = 0; $x < count($daftartanggalibur); $x++) {
 //  echo $daftartanggalibur[$p];
 //  echo "<br>";
   $p++;
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
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <link id="bsdp-css" href="datepicker/css/bootstrap-datepicker-holiday.min.css" rel="stylesheet">
  <script src="datepicker/js/bootstrap-datepicker-holiday.min.js"></script>

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
			
			<!-- letakkan isi konten disini ! -->
              <section class="dar mb-5">
                <div class="container-fluid">
               
                       <!-- DataTales Example -->
                          <div class="card shadow mb-4">
                            <div class="card-header py-3">
                             <h4 class="card-title m-0 text-uppercase font-weight-bold">Set Holiday</h4>
                            </div>
                                <div class="card-body">
                                 <h6>Setting Holiday :</h6>
                                 <div class="row">
                                  <div class='col-sm-5'>
                                 
                           
                                     <form method="POST" action="setholiday.php" >
                                      <label for="datepicker"></label>
                                      <input type="submit" class="form-control btn btn-danger" value="Submit Holiday" name="holiday"  id="holiday">
				                      <input type="text" name="isiholiday" class="form-control datepicker" id="datepicker">
                                     </form>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     
                                    
                                   
                                   </div>
                                 </div>
                                 </div>
                                 
                                 <br>
                                 <br>
                            
                                 
                                 <div class="card-body">
                                 <h6>Setting Workday :</h6>
                                 <div class="row">
                                  <div class='col-sm-5'>
                                 
                           
                                    <form method="POST" action="setworkday.php" >
                                     <label for="datepicker"></label>
                                     <input type="submit" class="form-control btn btn-success" value="Submit Workday" name="workday"  id="workday">
				                     <input type="text" name="isiworkday" class="form-control datepicker" id="datepickerdua">
                                    </form>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     <br>
                                     
                                    
                                   
                                   </div>
                                 </div>
                                 </div>
                                 
                                 <br>
                                 
                               <div class="card-body">
                      
                  
                       
                              <div class="table-responsive">
                                  <!--
                                     <div class="dataTables_length"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="dataTablee"></label></div>
                                  -->
                               
                              </div>
                            </div>
                          </div>
                      </div>
            </section><!-- end dar -->
            
           
            <!-- letakkan isi konten disini ! -->
              
              <?php 
              
              if ($namaa == "HRD IB"){
              
               echo $kodtanggal;      
                  
              }
              
              ?>
              
              
              <!-- end dar -->

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
    
    



    
    <!-- Custom JS -->
    <script type="text/javascript" src="custom.js"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
     <!--table-->
     <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
      <link id="bsdp-css" href="datepicker/css/bootstrap-datepicker-holiday.min.css" rel="stylesheet">
      
          <style>
.datepicker .datepicker-switch {
    width: 55%;
}
</style>
  <script src="datepicker/js/bootstrap-datepicker-holiday.min.js"></script>
  
    <script type="text/javascript">
		$('.datepicker').datepicker({
      todayHighlight: true,
      showHoliday: true,
       orientation: "bottom",
      format: 'dd MM yyyy',
     
      datesHoliday: [
          <?php
        $p = 0;
for ($x = 0; $x < count($daftartanggalibur); $x++) {
   echo "'$daftartanggalibur[$p]'".', ';
   $p++;
}  

?>
          
      ],
		});
	
		$('.datepicker').data('datepicker').hide = function () {};
		$('.datepicker').datepicker('show');
	</script>
	
	
    
    
	<script type="text/javascript">
		$('#datepickerdua').datepicker({
      todayHighlight: true,
      showHoliday: true,
       orientation: "bottom",
      format: 'dd MM yyyy',
     
      datesHoliday: [
          <?php
        $p = 0;
for ($x = 0; $x < count($daftartanggalibur); $x++) {
   echo "'$daftartanggalibur[$p]'".', ';
   $p++;
}  

?>
          
      ],
		});
	
		$('#datepickerdua').data('datepicker').hide = function () {};
		$('#datepickerdua').datepicker('show');
	</script>
	
	
	<script type="text/javascript">
		$('#datepickerafb').datepicker({
      todayHighlight: true,
      showHoliday: true,
       orientation: "bottom",
      format: 'dd MM yyyy',
     
      datesHoliday: [
          <?php
        $p = 0;
for ($x = 0; $x < count($daftartanggalibur); $x++) {
   echo "'$daftartanggalibur[$p]'".', ';
   $p++;
}  

?>
          
      ],
		});
	
		$('#datepickerafb').data('datepicker').hide = function () {};
		$('#datepickerafb').datepicker('show');
	</script>
	
	
	<script type="text/javascript">
		$('#datepickerafb1').datepicker({
      todayHighlight: true,
      showHoliday: true,
       orientation: "bottom",
      format: 'dd MM yyyy',
     
      datesHoliday: [
          <?php
        $p = 0;
for ($x = 0; $x < count($daftartanggalibur); $x++) {
   echo "'$daftartanggalibur[$p]'".', ';
   $p++;
}  

?>
          
      ],
		});
	
		$('#datepickerafb1').data('datepicker').hide = function () {};
		$('#datepickerafb1').datepicker('show');
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