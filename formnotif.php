<?php 
session_start();
include "config.php";

$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;
$namaa = $_SESSION["NMUser"];

date_default_timezone_set('Asia/Jakarta');
$datetimee = date('Y-m-d');
$datetime = DateTime::createFromFormat('Y-m-d', $datetimee);
$namahari = $datetime->format('D');

if($namaa == "HRD IB"){
$lokja = '<option selected value="ib">IB</option>';    
}elseif($namaa == "HRD IGI Pasuruan"){
$lokja = '<option selected value="purwosari">Pasuruan</option>';     
}elseif($namaa == "HRD IGI Gresik"){
$lokja = '<option selected value="bambe">Gresik</option>';     
}elseif($namaa == "HRD SDA"){
$lokja = '<option selected value="sda">SDA</option>';     
}

if ($namaa == "HRD IB" || $namaa == "HRD IGI Pasuruan" || $namaa == "HRD IGI Gresik" || $namaa == "HRD SDA" ){
    
}else{
header("Location: http://sidar.id/login");    
} 


if($_SESSION["IDUser"] == 0){
header("Location: http://sidar.id/login");
    }
    

$infoccbc = "SELECT id,nama FROM masteruser WHERE jabatan='owner' OR jabatan='manager' OR jabatan='supervisor';";

$queryinfoccbc = $conn->query($infoccbc);
$arrayinfoccbc = mysqli_fetch_all($queryinfoccbc, MYSQLI_ASSOC);
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
    	
    </style>
</head>
<body>

	<div class="wrapper">
		
		<!-- NAVBAR -->
		<?php include'navbar1.php';?>

		<!-- KONTEN -->
		<main class="konten">
			  <section class="dar mb-5">
                <div class="container-fluid">
                    <div class="card mb-3">
                    <div class="card-header py-3">
                      <h5 class="card-title m-0 text-uppercase font-weight-bold">Send Notification</h5>
                    </div>
                    <div class="card-body">
                       
                        <form method="POST" action="sendnotification.php">
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label for="inputEmail4">Title</label>
                              <input type="text" name="title" class="form-control" id="title" placeholder="title" required="required">
                            </div>
                    
                          </div>
                          <div class="form-row">
                             <div class="form-group col-md-12">
                              <label for="inputEmail4">Body</label>
                              <textarea name="body" class="form-control" id="body" placeholder="Body" required="required"></textarea>
                            </div>
                          </div>    
                          <div class="form-row">
                          <div class="form-group col-md-12">
                               <label class="mr-sm-2" for="inlineFormCustomSelect">Action</label>
                                <select name="action" class="custom-select mr-sm-2" id="action" required="required">
                                  
                             <option value="dar">Dar</option>
                            <option value="report">Report</option>
                                  <option value="dashboard">Dashboard</option>
                                 </select>
                          </div>
                     
                          </div>
                           
                          
                              
                          <br>
                          
                        <button type="submit" class="btn btn-outline-dark">
                            <i class="fa fa-plus"></i> SEND
                        </button>
                     
                        </form>
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
</body>
</html>