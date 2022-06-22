<?php 
session_start();
include "config.php";

$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;
$namaa = $_SESSION["NMUser"];

$addusernama = $_SESSION['addusernama'];
$adduserdepartement = $_SESSION['adduserdepartement'];
$addusernik = $_SESSION['addusernik'];
$adduseremail = $_SESSION['adduseremail'];
$adduserunitusaha = $_SESSION['adduserunitusaha'];
$adduserjabatan = $_SESSION['adduserjabatan'];
$adduserkota = $_SESSION['adduserkota'];
$addusernotelp = $_SESSION['addusernotelp'];
$adduserlokasikerja = $_SESSION['adduserlokasikerja'];
$adduserbagian = $_SESSION['adduserbagian'];

$adduserke = $_SESSION['adduserke'];
$adduserke2 = $_SESSION['adduserke2'];
$adduserke3 = $_SESSION['adduserke3'];
$adduserke4 = $_SESSION['adduserke4'];
$adduserke5 = $_SESSION['adduserke5'];

$lokasikerja = $_SESSION["Lokasikerja"] ;


date_default_timezone_set('Asia/Jakarta');
$datetimee = date('Y-m-d');
$datetime = DateTime::createFromFormat('Y-m-d', $datetimee);
$namahari = $datetime->format('D');

if($namaa == "HRD IB"){
$lokja = '<option selected value="ib">IB</option>';    
}elseif($namaa == "HRD IGI Pasuruan"){
$lokja = '<option selected value="IGI Purwosari">Pasuruan</option>';     
}elseif($namaa == "HRD IGI Gresik"){
$lokja = '<option selected value="IGI Bambe">Gresik</option>';     
}elseif($namaa == "HRD SDA"){
$lokja = '<option selected value="sda">SDA</option>';     
}

if ($namaa == "HRD IB" || $namaa == "HRD IGI Pasuruan" || $namaa == "HRD IGI Gresik" || $namaa == "HRD SDA" ){
    
}else{
header("Location: https://sidar.id/login");    
} 


if($_SESSION["IDUser"] == 0){
header("Location: https://sidar.id/login");
    }
    

$infoccbc = "SELECT id,nama FROM masteruser WHERE (jabatan='owner' OR jabatan='manager' OR jabatan='supervisor' OR jabatan='direktur' ) AND password != 'resign' ORDER BY nama ASC;";

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
                      <h5 class="card-title m-0 text-uppercase font-weight-bold">Data User Management</h5>
                    </div>
                    <div class="card-body">
                       
                        <form method="POST" action="tambahuser.php">
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">Name</label>
                              <input type="text" name="nama" class="form-control" id="Name" value="<?php echo $addusernama ;?>" placeholder="Name" required="required">
                            </div>
                            <div class="form-group col-md-6">
                               <label class="mr-sm-2" for="inlineFormCustomSelect">Unitusaha</label>
                                <select name="unitusaha" class="custom-select mr-sm-2" id="inlineFormCustomSelect" required="required">
                                  <option value="<?php echo $adduserunitusaha ;?>" selected><?php if(!empty($adduserunitusaha)){echo strtoupper($adduserunitusaha);}else{echo 'Choose...';}  ;?></option>
                                 <option value="igi">IGI</option>
                                 <option value="sda">SDA</option>
                                 </select>
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-6">
                               <label class="mr-sm-2" for="inlineFormCustomSelect">Departemen</label>
                                <select name="departemen" class="custom-select mr-sm-2" id="inlineFormCustomSelect" required="required">
                                  <option value="<?php echo $adduserdepartement ;?>" selected><?php if(!empty($adduserdepartement)){echo $adduserdepartement;}else{echo 'Choose...';}  ;?></option>
                                 <option value="DESIGN">DESIGN</option>
                                 <option value="EDP">EDP</option>
                                 <option value="EXPORT">EXPORT</option>
                                 <option value="EKSPEDISI">EKSPEDISI</option>
                                 <option value="FIN, ACC & TAX">FIN, ACC & TAX</option>
                                 <option value="INTERNAL AUDIT">INTERNAL AUDIT</option>
                                 <option value="HRGA & LEGAL">HRGA & LEGAL</option>
                                 <option value="INPRO">INPRO</option>
                                 <option value="LOGISTIC">LOGISTIC</option>
                                 <option value="OUTLET">OUTLET</option>
                                 <option value="PPIC">PPIC</option>
                                 <option value="PRODUCTION">PRODUCTION</option>
                                 <option value="PROMOSI">PROMOSI</option>
                                 <option value="PURCHASING">PURCHASING</option>
                                 <option value="QA">QA</option>
                                 <option value="QC">QC</option>
                                 <option value="R & D">R & D</option>
                                 <option value="SALES & MARKETING">SALES & MARKETING</option>
                                 <option value="TECHNIC">TECHNIC</option>
                                 <option value="WAREHOUSE">WAREHOUSE</option>
                                 <option value="HCS">HCS</option>
                                 </select>
                            </div>
                             <div class="form-group col-md-6">
                              <label for="inputEmail4">NIK</label>
                              <input type="text" value="<?php echo $addusernik ;?>" name="nik" class="form-control" id="inputnik" placeholder="NIK" required="required">
                            </div>
                          </div>    
                          <div class="form-row">
                          <div class="form-group col-md-6">
                               <label class="mr-sm-2" for="inlineFormCustomSelect">Jabatan</label>
                                <select name="jabatan" class="custom-select mr-sm-2" id="inlineFormCustomSelect" required="required">
                                  <option value="<?php echo $adduserjabatan ;?>" selected><?php if(!empty($adduserjabatan)){echo ucfirst($adduserjabatan);}else{echo 'Choose...';}  ;?></option>
                             <option value="manager">Manager</option>
                            <option value="supervisor">Supervisor</option>
                                  <option value="staff">Staff</option>
                                 </select>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">Bagian</label>
                              <input type="text" value="<?php echo $adduserbagian ;?>" name="divisi" class="form-control" id="LoginName" placeholder="Bagian" required="required">
                            </div>
                          </div>
                           <div class="form-row">
                             <div class="form-group col-md-6">
                              <label for="inputEmail4">Login Name</label>
                              <input type="text" name="username" class="form-control" id="LoginName" placeholder="Login Name" required="required">
                            </div>
                            <div class="form-group col-md-6">
                              <label for="inputPassword4">Password</label>
                              <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="inputCity">Telp</label>
                              <input type="text" value="<?php echo $addusernotelp ;?>" name="notlp" class="form-control" id="inputTelp" placeholder="Telp" required="required">
                            </div>
                            <div class="form-group col-md-6">
                               <label class="mr-sm-2" for="inlineFormCustomSelect">Work Location</label>
                                <select name="lokasikerja" class="custom-select mr-sm-2" id="inlineFormCustomSelect" required="required">
                           <?php echo $lokja; ?>
                                 </select>
                            </div>
                          </div>
                              <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="inputCity">Kota</label>
                              <input type="text" name="kota" value="<?php echo ucfirst($adduserkota) ;?>" class="form-control" id="inputTelp" placeholder="Kota" required="required">
                            </div>
                               
                            </div>
                          <div class="form-group row">
                            <label class="col-md-12 form-control-label">Cc/Bc</label>
                            <div class="col-md-12 form-control-label">
                            <div class="row justify-content-center">
                                <div class="col-md-2">
                            <select name="ke" class="custom-select d-block w-100" id="cc2" >
                              <option value=""> Cc/Bc 1 </option>
                              
                                           <?php
                for($x = 0; $x < sizeof($arrayinfoccbc); $x++){
                      $status = $arrayinfoccbc[$x]["status"];
                  ?>
                              
                 <option value="<?php echo $arrayinfoccbc[$x]["id"]; ?>"><?php echo $arrayinfoccbc[$x]["nama"]; ?></option>
                              
                              <?php } ?>
                           
                            </select>
                          </div>
                                 <div class="col-md-2">
                            <select name="ke2" class="custom-select d-block w-100" id="cc2">
                              <option value="">Cc/Bc 2</option>
                                               <?php
                for($x = 0; $x < sizeof($arrayinfoccbc); $x++){
                      $status = $arrayinfoccbc[$x]["status"];
                  ?>
                              
                              <option value="<?php echo $arrayinfoccbc[$x]["id"]; ?>"><?php echo $arrayinfoccbc[$x]["nama"]; ?></option>
                              
                              <?php } ?>
                            </select>
                          </div>
                                 <div class="col-md-2">
                            <select name="ke3" class="custom-select d-block w-100" id="cc2">
                              <option value="">Cc/Bc 3</option>
                                                <?php
                for($x = 0; $x < sizeof($arrayinfoccbc); $x++){
                      $status = $arrayinfoccbc[$x]["status"];
                  ?>
                              
                              <option value="<?php echo $arrayinfoccbc[$x]["id"]; ?>"><?php echo $arrayinfoccbc[$x]["nama"]; ?></option>
                              
                              <?php } ?>
                            </select>
                          </div>
                                <div class="col-md-2">
                            <select name="ke4" class="custom-select d-block w-100" id="cc2">
                              <option value="">Cc/Bc 4</option>
                                                  <?php
                for($x = 0; $x < sizeof($arrayinfoccbc); $x++){
                      $status = $arrayinfoccbc[$x]["status"];
                  ?>
                              
                              <option value="<?php echo $arrayinfoccbc[$x]["id"]; ?>"><?php echo $arrayinfoccbc[$x]["nama"]; ?></option>
                              
                              <?php } ?>
                            </select>
                          </div>
                              <div class="col-md-2">
                            <select name="ke5" class="custom-select d-block w-100" id="cc2">
                              <option value="">Cc/Bc 5</option>
                                                   <?php
                for($x = 0; $x < sizeof($arrayinfoccbc); $x++){
                      $status = $arrayinfoccbc[$x]["status"];
                  ?>
                              
                              <option value="<?php echo $arrayinfoccbc[$x]["id"]; ?>"><?php echo $arrayinfoccbc[$x]["nama"]; ?></option>
                              
                              <?php } ?>
                            </select>
                          </div>
                          </div>
                        </div>
                      </div>
                          <div class="form-group">
                            <div class="form-check">
                          
                            </div>
                          </div>
                        <button type="submit" class="btn btn-outline-dark">
                            <i class="fa fa-plus"></i> ADD
                        </button>
                        <button style="display:none;" class="btn btn-outline-dark">
                            <i class="fa fa-pencil-square-o"></i> EDIT
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