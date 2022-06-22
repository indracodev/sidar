<?php 
session_start();
include "config.php";

$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;
$namaa = $_SESSION["NMUser"];

$idnya = $_GET["idnya"];

date_default_timezone_set('Asia/Jakarta');
$datetimee = date('Y-m-d');
$datetime = DateTime::createFromFormat('Y-m-d', $datetimee);
$namahari = $datetime->format('D');

if($namaa == "HRD IB"){
$lokja = '<option selected value="ib">IB</option>';  
$unitsh = '<option selected value="IGI">IGI IB</option>';  
}elseif($namaa == "HRD IGI Pasuruan"){
$lokja = '<option selected value="purwosari">Pasuruan</option>';   
$unitsh = '<option selected value="IGI Pasuruan">IGI Pasuruan</option>'; 
}elseif($namaa == "HRD IGI Gresik"){
$lokja = '<option selected value="bambe">Gresik</option>';
$unitsh = '<option selected value="IGI Gresik">IGI Gresik</option>'; 
}elseif($namaa == "HRD SDA"){
$lokja = '<option selected value="sda">SDA</option>';  
$unitsh = '<option selected value="SDA">SDA</option>'; 
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



$ambiluser = "SELECT * FROM masteruser WHERE id = '" .$idnya . "';";



//$ambildar = "SELECT * FROM dar 
// WHERE nodar = '" .$idnya . "';";
 $queryuser =$conn->query($ambiluser);
 if($queryuser->num_rows){
   session_start();
   $row = mysqli_fetch_array($queryuser, MYSQLI_ASSOC);
   $nama = $row['nama'];
     
   $unitusaha = $row['unitusaha'];
   $departemen = $row['departemen'];
   $divisi = $row['divisi'];
   $jabatan = $row['jabatan'];
   $usernm = $row['username'];
   $email = $row['email'];
   $kota = $row['kota'];
   $nik = $row['nik'];
   $notlp = $row['notlp'];
   $ke = $row['ke'];
   $ke2 = $row['ke2'];
   $ke3 = $row['ke3'];
   $ke4 = $row['ke4'];
   $ke5 = $row['ke5'];
   


 }
 else{
    // header("location: http://www.icg.id/beta/dar/login");
   echo " gak dapat user ";
 }
 
 $infoccbc = "SELECT id,nama FROM masteruser WHERE jabatan='manager' OR jabatan='supervisor' OR jabatan='owner' OR jabatan='direktur';";

$queryinfoccbc = $conn->query($infoccbc);
$arrayinfoccbc = mysqli_fetch_all($queryinfoccbc, MYSQLI_ASSOC);
    $kenama;
    $ke2nama;
    $ke3nama;
    $ke4nama;
    $ke5nama;
    
      for($x = 0; $x < sizeof($arrayinfoccbc); $x++){
                      $idinfoccbc = $arrayinfoccbc[$x]["id"];
      
      if($idinfoccbc == $ke){
          
              $kenama = $arrayinfoccbc[$x]["nama"] ;
          
      }elseif ($idinfoccbc == $ke2){
          
           $ke2nama = $arrayinfoccbc[$x]["nama"] ;
           
      }elseif ($idinfoccbc == $ke3){
          
           $ke3nama = $arrayinfoccbc[$x]["nama"] ;
           
      }elseif ($idinfoccbc == $ke4){
          
           $ke4nama = $arrayinfoccbc[$x]["nama"] ;
           
      }elseif ($idinfoccbc == $ke5){
          
           $ke5nama = $arrayinfoccbc[$x]["nama"] ;
           
      }else{
          
          
      }
      
           
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
                       
                        <form method="POST" action="updateuser.php">
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">Name</label>
                              <input type="text" name="nama" class="form-control" id="Name" placeholder="Name" value="<?php echo $nama; ?>" required="required">
                            </div>
                            <div class="form-group col-md-6">
                               <label class="mr-sm-2" for="inlineFormCustomSelect">Unitusaha</label>
                                <select name="unitusaha" class="custom-select mr-sm-2" id="inlineFormCustomSelect" required="required">
                            <?php echo $unitsh; ?>
                                 </select>
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-6">
                               <label class="mr-sm-2" for="inlineFormCustomSelect">Departemen</label>
                                <select name="departemen" class="custom-select mr-sm-2" id="inlineFormCustomSelect" required="required">
                                  <option value="<?php echo $departemen; ?>" selected><?php echo strtoupper($departemen); ?></option>
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
                              <input value="<?php echo $nik; ?>" type="text" name="nik" class="form-control" id="inputnik" placeholder="NIK" required="required">
                            </div>
                          </div>    
                          <div class="form-row">
                          <div class="form-group col-md-6">
                               <label class="mr-sm-2" for="inlineFormCustomSelect">Jabatan</label>
                                <select name="jabatan" class="custom-select mr-sm-2" id="inlineFormCustomSelect" required="required">
                                <option value="<?php echo $jabatan; ?>" selected><?php echo strtoupper($jabatan); ?></option>
                                <option value="manager">Manager</option>
                                <option value="supervisor">Supervisor</option>
                                <option value="staff">Staff</option>
                                 </select>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">Bagian</label>
                              <input type="text" name="divisi" class="form-control" value="<?php echo $divisi; ?>" id="LoginName" placeholder="Bagian" required="required">
                            </div>
                          </div>
                           <div class="form-row">
                             <div class="form-group col-md-6">
                              <label for="inputEmail4">Login Name</label>
                              <input type="text" value="<?php echo $usernm; ?>" name="username" class="form-control" id="LoginName" placeholder="Login Name" disabled>
                              <input type="hidden" name="idnya" class="form-control" value="<?php echo $idnya; ?>" id="idnya" required="required">
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
                              <input type="text" name="kota" class="form-control" id="inputTelp" value="<?php echo $kota; ?>" placeholder="Kota" required="required">
                            </div>
                      
                          </div>
                              <div class="form-row">
                          
                               
                            </div>
                          <div class="form-group row">
                            <label class="col-md-12 form-control-label">Cc/Bc</label>
                            <div class="col-md-12 form-control-label">
                            <div class="row justify-content-center">
                                <div class="col-md-2">
                            <select name="ke" class="custom-select d-block w-100" id="cc2" >
                              <option value=""> Cc/Bc 1 </option>
                               <option selected value="<?php echo $ke ?>"> <?php echo $kenama ?>  </option>
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
                              
                             <option selected value="<?php echo $ke2 ?>"> <?php echo $ke2nama ?>  </option> 
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
                                <option selected value="<?php echo $ke3 ?>"> <?php echo $ke3nama ?>  </option>
                              
                              
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
                             <option selected value="<?php echo $ke4 ?>"> <?php echo $ke4nama ?>  </option>
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
                                <option selected value="<?php echo $ke5 ?>"> <?php echo $ke5nama ?>  </option>
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
                            <i class="fa fa-plus"></i> SAVE
                        </button>
                        <button style="display:none;" class="btn btn-outline-dark">
                            <i class="fa fa-pencil-square-o"></i> SAVE
                        </button>
                        </form>
                        
                     
                        <br>
                        <br>
                           <hr>
                        <br>
                        <br>
                        
                        <form method="POST" action="resetpasss.php">
                        <input type="text" name="passone" class="form-control p-4 rounded-pill mb-2" placeholder="New Password">
                        <input type="text" name="passtwo" class="form-control p-4 rounded-pill mb-2" placeholder="Confirm New Password">
                         <input type="hidden" name="idnya" value="<?php echo $idnya; ?>" class="form-control p-4 rounded-pill mb-2" >
                        <div class="d-block text-left pl-4">
                           
                        </div>
                        <div class="capcha mb-5"></div>
                        <button type="submit" class="btn btn-outline-dark rounded-pill">
                            <i class="fa fa-save"></i> RESET PASSWORD
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