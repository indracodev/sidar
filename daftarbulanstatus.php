<?php 
include "config.php";
session_start();
$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;


/*
SELECT masteruser.nama, masteruser.departemen, dar.jam, dar.tanggal, dar.urid
FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggal BETWEEN CAST('2020-01-28' AS DATE) AND CAST('2020-01-30' AS DATE) AND dar.iduser=1 ORDER BY dar.tanggal DESC
*/

/*

SELECT masteruser.nama, masteruser.departemen, dar.jam, dar.tanggal, dar.urid
FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE dar.activity LIKE '%ar%' AND dar.iduser=1 ORDER BY dar.tanggal DESC

*/

$getstat = $_GET['stat'];
    

    


if($_SESSION["IDUser"] == 0){
header("Location: https://sidar.id/login");
    }
else if ($_SESSION["Level"] != "admin"){

$infomuser = "SELECT * FROM masteruser WHERE id='".$iduser."' ;";
$queryuser = $conn->query($infomuser);
$arraymuser = mysqli_fetch_all($queryuser, MYSQLI_ASSOC);

}

else if ($_SESSION["Level"] == "admin"){

$infomuser = "SELECT * FROM masteruser WHERE (id='".$iduser."' OR ke='".$iduser."' OR ke2='".$iduser."' OR ke3='".$iduser."' OR ke4='".$iduser."' OR ke5='".$iduser."') ORDER BY urutan DESC ;";
$queryuser = $conn->query($infomuser);
$arraymuser = mysqli_fetch_all($queryuser, MYSQLI_ASSOC);

} else {
    
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
                             <h4 class="card-title m-0 text-uppercase font-weight-bold">Daftar Bulanan Status <?php echo $getstat ?></h4>
                            </div>
                                
                               <div class="card-body">
                               <a href="addUser.php" class="btn btn-outline-dark" style="margin-bottom: 15px; display:none;"> <i class="fa fa-plus"></i> <strong></strong></a>
                              <div class="table-responsive">
                            <table class="table table-bordered" id="dataTablee" width="100%" cellspacing="0">
                                  <thead>
                                    <tr>
                                      <th>Bulan</th>
                         
                                     
                                    </tr>
                                  </thead>
                          
                                  <tbody>
              
                  <tr> 
                    <td scope="row"> <a id="linkk" href="liststatusbulan.php?bulan=01&stat=<?php echo $getstat; ?>">Januari</td> </a>
                   </tr><tr>
                    <td scope="row"> <a id="linkk" href="liststatusbulan.php?bulan=02&stat=<?php echo $getstat; ?>">Ferbruari</td> </a>
                    </tr><tr>
                    <td scope="row"> <a id="linkk" href="liststatusbulan.php?bulan=03&stat=<?php echo $getstat; ?>">Maret</td> </a>
                   </tr><tr>  
                    <td scope="row"> <a id="linkk" href="liststatusbulan.php?bulan=04&stat=<?php echo $getstat; ?>">April</td> </a>
                    </tr> <tr> 
                    <td scope="row"> <a id="linkk" href="liststatusbulan.php?bulan=05&stat=<?php echo $getstat; ?>">Mei</td> </a>
                    </tr> <tr>
                    <td scope="row"> <a id="linkk" href="liststatusbulan.php?bulan=06&stat=<?php echo $getstat; ?>">Juni</td> </a>
                    </tr><tr>
                    <td scope="row"> <a id="linkk" href="liststatusbulan.php?bulan=07&stat=<?php echo $getstat; ?>">Juli</td> </a>
                    </tr><tr>
                    <td scope="row"> <a id="linkk" href="liststatusbulan.php?bulan=08&stat=<?php echo $getstat; ?>">Agustus</td> </a>
                   </tr><tr> 
                    <td scope="row"> <a id="linkk" href="liststatusbulan.php?bulan=09&stat=<?php echo $getstat; ?>">September</td> </a>
                    </tr><tr>
                     <td scope="row"> <a id="linkk" href="liststatusbulan.php?bulan=10&stat=<?php echo $getstat; ?>">Oktober</td> </a>
                    </tr><tr>
                    <td scope="row"> <a id="linkk" href="liststatusbulan.php?bulan=11&stat=<?php echo $getstat; ?>">November</td> </a>
                    </tr><tr>
                    <td scope="row"> <a id="linkk" href="liststatusbulan.php?bulan=12&stat=<?php echo $getstat; ?>">Desember</td> </a>
                   
          
          
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
   <script>
    $(document).ready(function(){
        $('#dataTablee').DataTable({
   "aaSorting": []
    });
    });
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

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
     <!--table-->  
    <script src="js/table/jquery.dataTables.min.js"></script>
    <script src="js/table/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="js/table/datatables-demo.js"></script>
</body>
</html>