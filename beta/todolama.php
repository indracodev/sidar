<?php 
include "config.php";
session_start();
$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;
$keuser2 = $_SESSION["Ke2"];
$keuser3 = $_SESSION["Ke3"];
$keuser4 = $_SESSION["Ke4"];
$keuser5 = $_SESSION["Ke5"];


/*
SELECT masteruser.nama, masteruser.departemen, dar.jam, dar.tanggal, dar.urid
FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggal BETWEEN CAST('2020-01-28' AS DATE) AND CAST('2020-01-30' AS DATE) AND dar.iduser=1 ORDER BY dar.tanggal DESC
*/

/*

SELECT masteruser.nama, masteruser.departemen, dar.jam, dar.tanggal, dar.urid
FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE dar.activity LIKE '%ar%' AND dar.iduser=1 ORDER BY dar.tanggal DESC

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
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" >
    <!-- Font Awesome CSS -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/util.css">

    <link rel="stylesheet" type="text/css" href="custom1.css">
    

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
                          <div class="card shadow mb-4 mt-3">
                            <div class="card-header py-3">
              
                <div class="card-body d-flex justify-content-between align-items-center">
                                <h4 class="card-title m-0 text-uppercase font-weight-bold">TODO</h4>
                               
                                 <div class="dropdown">
                                        <div id="dropCardHeader" aria-haspopup="true" aria-expanded="false">
                                        <button class="btn btn-outline-dark" id="myBtn" data-toggle="modal" data-target="#myModal" data-id="1">
                                        <i class="fa fa-plus"></i> ADD TODO
                                             </button>
                                        </div>
                                       
                                    </div>
                                  
                                 
                                 
                                 
                                 
                                 
                                 </div>
                            </div>
                            
                                
<div class="card-body">
                      
<div class="table100">
<table>
<thead>
<tr class="table100-head">
<th class="column1">Target</th>
<th class="column2">Todo</th>
<th class="column3">Result</th>
<th class="column4">Date</th>
<th class="column5">Due Date</th>

</tr>
</thead>
<tbody>
<tr>
<td class="column1">1</td>
<td class="column2">200398</td>
<td class="column3">Done</td>
<td class="column4">$999.00</td>
<td class="column5">1</td>

</tr>
<tr>
<td class="column1">2</td>
<td class="column2">200397</td>
<td class="column3">Done</td>
<td class="column4">$756.00</td>
<td class="column5">1</td>

</tr>
<tr>
<td class="column1">3</td>
<td class="column2">200396</td>
<td class="column3">Done</td>
<td class="column4">$22.00</td>
<td class="column5">2</td>

</tr>
<tr>
<td class="column1">4</td>
<td class="column2">200392</td>
<td class="column3">Process</td>
<td class="column4">$10.00</td>
<td class="column5">3</td>

</tr>
<tr>
<td class="column1">5</td>
<td class="column2">200391</td>
<td class="column3">Process</td>
<td class="column4">$199.00</td>
<td class="column5">6</td>

</tr>

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
                  <h4 class="modal-title" id="labelModalKu">Contact Form</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Tutup</span>
                </button>
              
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <p class="statusMsg"></p>
                <form role="form">
                    <div class="form-group">
                        <label for="masukkanNama">Target</label>
                        <input type="text" class="form-control" id="masukkanNama" placeholder="Masukkan nama Anda"/>
                    </div>
                    <div class="form-group">
                        <label for="masukkanEmail">Todo</label>
                        <input type="text" class="form-control" id="masukkanEmail" placeholder="Masukkan email Anda"/>
                    </div>
                        <div class="form-group">
                    <label>Date</label>
                    <div>
                  <input class="form-control" type="date" name="dateofbirth" id="dateofbirth">
                  </div>
                    </div>
                      <div class="form-group">
                    <label>Due Date</label>
                  <input class="form-control" type="date" name="dateofbirth" id="dateofbirth">
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary submitBtn" onclick="kirimContactForm()">KIRIM</button>
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
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js" ></script>
	<script type="text/javascript">
	$('.datepicker').datepicker({
	 
    format: 'mm/dd/yyyy',
	});
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
     
<!--     
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
       <script>
    $(document).ready(function(){
        $('#myModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            
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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  -->
  
  

   
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