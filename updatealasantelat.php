<?php 
session_start();
include "config.php";

$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;
$namaa = $_SESSION["NMUser"];
$lokasikerja = $_SESSION["Lokasikerja"] ;

$notelat = $_GET["notelat"] ;

$pecaht = explode("/", $notelat);
$hasilt = $pecaht[0];

if($hasilt != $iduser){
header("Location: https://sidar.id/");     
}

date_default_timezone_set('Asia/Jakarta');
$datetimee = date('Y-m-d');
$datetime = DateTime::createFromFormat('Y-m-d', $datetimee);
$namahari = $datetime->format('D');


$infouser = "SELECT * FROM formtelat WHERE notelat = '".$notelat."';";

$queryinfouser = $conn->query($infouser);
$arrayinfouser = mysqli_fetch_array($queryinfouser, MYSQLI_ASSOC);



$namae = $arrayinfouser['nama'];
$departement = $arrayinfouser['departemen'];
$bagian = $arrayinfouser['bagian'];
$unitusaha = $arrayinfouser['unitusaha'];
$ke1 = $arrayinfouser['ke1'];
$ke2 = $arrayinfouser['ke2'];
$ke3 = $arrayinfouser['ke3'];
$ke4 = $arrayinfouser['ke4'];
$ke5 = $arrayinfouser['ke5'];

$telatpadatanggal = $arrayinfouser['telatpadatanggal'];
$masukjam = $arrayinfouser['masukjam'];
////////////////////////////////////////////////////////////////////////////////////////////


if(!empty($ke1)){
$infoke1 = "SELECT * FROM masteruser WHERE id = '".$ke1."' ;";
$queryinfoke1 = $conn->query($infoke1);
$arrayinfoke1 = mysqli_fetch_array($queryinfoke1, MYSQLI_ASSOC);
}

if(!empty($ke2)){
$infoke2 = "SELECT * FROM masteruser WHERE id = '".$ke2."' ;";
$queryinfoke2 = $conn->query($infoke2);
$arrayinfoke2 = mysqli_fetch_array($queryinfoke2, MYSQLI_ASSOC);
}

if(!empty($ke3)){
$infoke3 = "SELECT * FROM masteruser WHERE id = '".$ke3."' ;";
$queryinfoke3 = $conn->query($infoke3);
$arrayinfoke3 = mysqli_fetch_array($queryinfoke3, MYSQLI_ASSOC);
}

if(!empty($ke4)){
$infoke4 = "SELECT * FROM masteruser WHERE id = '".$ke4."' ;";
$queryinfoke4 = $conn->query($infoke4);
$arrayinfoke4 = mysqli_fetch_array($queryinfoke4, MYSQLI_ASSOC);
}

if(!empty($ke5)){
$infoke5 = "SELECT * FROM masteruser WHERE id = '".$ke5."' ;";
$queryinfoke5 = $conn->query($infoke5);
$arrayinfoke5 = mysqli_fetch_array($queryinfoke5, MYSQLI_ASSOC);
}


if($_SESSION["IDUser"] == 0){
header("Location: https://sidar.id/login");
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
    <!-- inner style -->
    <style type="text/css">
    	
    </style>

<link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>

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
                      <h5 class="card-title m-0 text-uppercase font-weight-bold">Form Terlambat Masuk Kantor</h5>
                    </div>
                    <div class="card-body">
                       
                        <form method="POST" action="tambahdatatelat.php">
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">Name</label>
                              <input type="text" name="namax" class="form-control" id="Name" value="<?php echo $namae ;?>" placeholder="Name" required="required" disabled>
                              <input type="hidden" name="nama" class="form-control" id="Name" value="<?php echo $namae ;?>" placeholder="Name" required="required">
                              <input type="hidden" name="iduser" class="form-control" id="idu" value="<?php echo $iduser ;?>" placeholder="Name" >
                              <input type="hidden" name="notifupdate" class="form-control" value="yes" id="notifupdate" value="yes" placeholder="Name" >
                              <input type="hidden" name="numbertelat" class="form-control" id="numbertelat" value="<?php echo $notelat;?>" placeholder="Name" >
                            </div>
                            <div class="form-group col-md-6">
                              <label for="unitusaha">Unit Usaha</label>
                              <input type="text" name="unitusahax" class="form-control" id="unitusahax" value="<?php echo $unitusaha ;?>" placeholder="unitusaha" required="required" disabled>
                              <input type="hidden" name="unitusaha" class="form-control" id="unitusaha" value="<?php echo $unitusaha ;?>" placeholder="unitusaha" required="required" >
                            </div>
                          </div>
                          
                          <div class="form-row">
                           <div class="form-group col-md-6">
                              <label for="departement">Departement</label>
                              <input type="text" name="departementx" class="form-control" id="departementx" value="<?php echo $departement ;?>" placeholder="departement" required="required" disabled>
                              <input type="hidden" name="departement" class="form-control" id="departement" value="<?php echo $departement ;?>" placeholder="departement" required="required">
                            </div>
                             <div class="form-group col-md-6">
                              <label for="divisi">Bagian</label>
                              <input type="text" name="divisix" class="form-control" id="divisix" value="<?php echo $bagian ;?>" placeholder="bagian" required="required" disabled>
                              <input type="hidden" name="divisi" class="form-control" id="divisi" value="<?php echo $bagian ;?>" placeholder="bagian" required="required">
                            </div>
                          </div>   
                          
                          <div class="form-row">
                          <div class="form-group col-md-6">
                            <label class="mr-sm-2" for="inlineFormCustomSelect">Tanggal Telat</label>
                            <input type="date" name="tgltelat" class="form-control" id="tgltelat" value="<?php echo $telatpadatanggal ; ?>" placeholder="dd-mm-yyyy" required="required" disabled>
                          </div>
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">Jam Telat</label>
                              <input type="time" value="<?php echo $masukjam ; ?>" name="timetelat" class="form-control timepicker" id="time" placeholder="" required="required" disabled>
                              
                            </div>
                          </div>
                          
                           <div class="form-row">
                             <div class="form-group col-md-6">
                              <label for="inputEmail4">Alasan Terlambat</label>
                              <textarea rows="3" name="alasan" class="form-control" id="alasan" placeholder="Alasan" required="required"></textarea>
                            </div> 
                           <div class="form-group col-md-6">
                               <label class="mr-sm-2" for="inlineFormCustomSelect">Menyetujui Pimpinan Departement</label>
                                <select name="keatasan" class="custom-select mr-sm-2" id="inlineFormCustomSelect" required="required" disabled>
                                  <option value="<?php echo $ke1 ;?>" selected><?php echo $arrayinfoke1['nama']?></option>
                                 </select>
                            </div>
                          </div>

                          <div class="form-group">
                            <div class="form-check">
                          
                            </div>
                          </div>
                        <button type="submit" class="btn btn-outline-dark">
                            <i class="fa fa-plus"></i> KIRIM
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
<script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>



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