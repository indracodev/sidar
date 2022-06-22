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






if($_SESSION["IDUser"] == 0){
header("Location: http://sidar.id/login");
    }
    

$sql = "SELECT * FROM mastertarget WHERE iduser = '".$iduser."' ";
$result = $conn->query($sql);
$arrayresult= mysqli_fetch_all($result, MYSQLI_ASSOC);


 
 $zzz = "1";
 
$infotodo = "";
$querytodo = "";
$arraytodo = "";

   
$infotodo = "SELECT * FROM todo WHERE iduser='".$iduser."' AND result != 'done'  ";
$querytodo = $conn->query($infotodo);
$arraytodo = mysqli_fetch_all($querytodo, MYSQLI_ASSOC);

    

    


 


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


   
    <link href="https://cdn.datatables.net/rowgroup/1.1.2/css/rowGroup.dataTables.min.css" rel="stylesheet">
    <!-- inner style -->
    <style type="text/css">
    	
    </style>
    
       <style type="text/css">
       
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
                             <h4 class="card-title m-0 text-uppercase font-weight-bold">TODO</h4>
                            </div>
                                <div class="card-body d-flex justify-content-between align-items-center">
                              
                                 
                                  
                                 <div class="row" style="<?php echo $aktifbaca ; ?>">
                                      <label> 
                                  <!--   <h6 style="display:flex;justify-content:center;">Add ToDo:</h6> -->
                                  <div class='col-sm-3' style="max-width:100%;flex-basis:100%;">
                                    <div class="form-group">
                                        <div class='' id=''>
                                    
                                     <div class="dropdown">
                                        <div id="dropCardHeader" aria-haspopup="true" aria-expanded="false">
                                        <button class="btn btn-outline-dark" id="myBtnt" data-toggle="modal" data-target="#myModalt" >
                                        <i class="fa fa-plus"></i> ADD TARGET &nbsp &nbsp
                                             </button>
                                        </div>
                                       
                                    </div> 
                                   
                                    </br>
                                    
                                    
                                       <div class="dropdown">
                                        <div id="dropCardHeader" aria-haspopup="true" aria-expanded="false">
                                        <button class="btn btn-outline-danger" id="myBtndt" data-toggle="modal" data-target="#myModaldt" data-id="1">
                                        <i class="fa fa-minus"></i> DELETE TARGET
                                             </button>
                                        </div>
                                       
                                    </div> 
                                 
                                     
                                     
                                            <span class="add-on"><i class="icon-remove"></i></span>
                                        </div>
                                    </div>
                                   </div>
                                    </label> 
                                 </div>
                                 
                                 <div class="row" style="<?php echo $aktifbaca ; ?>">
                                      <label> 
                                  <!--   <h6 style="display:flex;justify-content:center;">Add ToDo:</h6> -->
                                  <div class='col-sm-3' style="max-width:100%;flex-basis:100%;">
                                    <div class="form-group">
                                        <div class='' id=''>
                              
                                     <div class="dropdown">
                                        <div id="dropCardHeader" aria-haspopup="true" aria-expanded="false">
                                        <button class="btn btn-outline-dark" id="myBtn" data-toggle="modal" data-target="#myModal" data-id="1">
                                        <i class="fa fa-plus"></i> ADD TODO  &nbsp 
                                             </button>
                                        </div>
                                       
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
                                <table class="table table-bordered" id="dataTablee" width="100%" cellspacing="0">
                                  <thead>
                                    <tr>
                                      <th>Target</th>    
                                      <th>Todo </th>
                                      <th>Result</th>
                                   
                                      <th>Due Date</th>
                                      <th>Delete</th>
                                      <th>Add to DAR</th>
                                      <th style="display:none" >Tag</th>
                                    </tr>
                                  </thead>
                         
                                  <tbody>
                                                             <?php
                for($x = 0; $x < sizeof($arraytodo); $x++){
                     
                  ?>
                
                 
                  <tr> 
                    <td scope="row"> <a style="font-weight:<?php echo $sama ?>;" id="linkk" ><?php echo $arraytodo[$x]["target"] ?></td> </a>
                    <td scope="row"> <a style="font-weight:<?php echo $sama ?>;" id="linkk" href="reportdetail.php?idnya=<?php echo $arraytodo[$x]["idtodo"] ?>"><?php echo $arraytodo[$x]["todo"] ?></td> </a>
                    <td><a style="font-weight:<?php echo $sama ?>;" id="linkk" href="reportdetail.php?idnya=<?php echo $arraytodo[$x]["idtodo"] ?>"><?php echo $arraytodo[$x]["result"] ?></td></a>
            
                    <td data-sort="<?php echo $mydatesent; ?>"><a style="font-weight:<?php echo $sama ?>;" id="linkk" href="reportdetail.php?idnya=<?php echo $arraytodo[$x]["idtodo"] ?>"><?php
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
                   
                   <td ><a style="font-weight:<?php echo $sama ?>;" id="linkk" href="hapustodo.php?idnya=<?php echo $arraytodo[$x]["idtodo"] ?>"> <button class="btn btn-outline-dark" id="myBtn" >
                                        Delete
                                             </button></td></a>
          
                    <td ><a style="font-weight:<?php echo $sama ?>;" id="linkk" href="addtodar.php?idnya=<?php echo $arraytodo[$x]["idtodo"] ?>"> <button class="btn btn-outline-dark" id="myBtn" >
                                        Add to DAR
                                             </button></td></a>
                   
                    <td style="display:none" ><a id="linkk" style="font-weight:<?php echo $sama ?>;" href="reportdetail.php?idnya=<?php echo $arraytodo[$x]["idtodo"] ?>"><?php echo $arrayrdar[$x]["tag"] ?></td></a>
          
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

    <!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                  <h4 class="modal-title" id="labelModalKu">ADD TODO</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Tutup</span>
                </button>
              
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <p class="statusMsg"></p>
                <form method="post" action="insertodo.php">
                    <div class="form-group">
                       <label for="target">Target</label>
                        <select name="target" class="form-control" name="target" id="target">
                        <?php for($x = 0; $x < sizeof($arrayresult); $x++){ ?>    
                        <option value="<?php echo $arrayresult[$x]['namatarget'] ?>"><?php echo $arrayresult[$x]['namatarget'] ?></option>
                        
                        <? } ?>
                        </select>
                        
                    </div>
                    <div class="form-group">
                        <label for="todo">Todo</label>
                        <input type="text" class="form-control" name="todo" id="todo" placeholder="Todo"/>
                    </div>
                        <div class="form-group">
                    <label>Date</label>
                    <div>
                  <input class="form-control" type="date" name="tgl" id="dateofbirth">
                  </div>
                    </div>
                      <div class="form-group">
                    <label>Due Date</label>
                  <input class="form-control" type="date" name="duetgl" id="dateofbirth">
                    </div>
                    
                     <input style="display:none;" type="text" name="iduser" value="<?php echo $iduser ;?>">
               
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                <button type="submit" class="btn btn-primary submitBtn" >ADD</button>
                 </form>
            </div>
        </div>
    </div>
</div>
            </div>
        </div>
     </div>

 
 <!-- Modal -->
<div class="modal fade" id="myModaldt" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                  <h4 class="modal-title" id="labelModalKu">ADD TARGET</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Tutup</span>
                </button>
              
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <p class="statusMsg"></p>
                <form method="post" action="deletetarget.php">
                    <div class="form-group">
                         <label for="target">Target</label>
                        <select name="target" class="form-control" name="target" id="target">
                        <?php for($x = 0; $x < sizeof($arrayresult); $x++){ ?>    
                        <option value="<?php echo $arrayresult[$x]['idtarget'] ?>"><?php echo $arrayresult[$x]['namatarget'] ?></option>
                        
                        <? } ?>
                        </select>
                    </div>
        
                     <input style="display:none;" type="text" name="iduser" value="<?php echo $iduser ;?>">
               
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                <button type="submit" class="btn btn-primary submitBtn" >DELETE</button>
                 </form>
            </div>
        </div>
    </div>
</div>



  <!-- Modal -->
<div class="modal fade" id="myModalt" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                  <h4 class="modal-title" id="labelModalKu">ADD TARGET</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Tutup</span>
                </button>
              
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <p class="statusMsg"></p>
                <form method="post" action="inserttarget.php">
                    <div class="form-group">
                        <label for="target">Target</label>
                        <input type="text" class="form-control" name="target" id="target" placeholder="Target"/>
                    </div>
        
                    
                     <input style="display:none;" type="text" name="iduser" value="<?php echo $iduser ;?>">
               
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                <button type="submit" class="btn btn-primary submitBtn" >ADD</button>
                 </form>
            </div>
        </div>
    </div>
</div>
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
     order: [[0, 'asc']],
     rowGroup: {
          dataSrc: 0
    },
    

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