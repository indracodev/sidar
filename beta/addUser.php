<?php 
session_start();
include "config.php";

$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;

date_default_timezone_set('Asia/Jakarta');
$datetimee = date('Y-m-d');
$datetime = DateTime::createFromFormat('Y-m-d', $datetimee);
$namahari = $datetime->format('D');


$infoccbc = "SELECT id,nama FROM masteruser WHERE jabatan='manager' OR jabatan='supervisor';";

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
                              <input type="text" name="nama" class="form-control" id="Name" placeholder="Name" required="required">
                            </div>
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">Login Name</label>
                              <input type="text" name="username" class="form-control" id="LoginName" placeholder="Login Name" required="required">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">Unit Usaha</label>
                              <input type="text" name="unitusaha" class="form-control" id="Name" placeholder="Unit Usaha" required="required">
                            </div>
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">Departemen</label>
                              <input type="text" name="departemen" class="form-control" id="LoginName" placeholder="Departemen" required="required">
                            </div>
                          </div>    
                          <div class="form-row">
                          <div class="form-group col-md-6">
                               <label class="mr-sm-2" for="inlineFormCustomSelect">Jabatan</label>
                                <select name="jabatan" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                  <option selected>Choose...</option>
                             <option value="manager">Manager</option>
                            <option value="supervisor">Supervisor</option>
                                  <option value="staff">Staff</option>
                                 </select>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">Bagian</label>
                              <input type="text" name="divisi" class="form-control" id="LoginName" placeholder="Bagian" required="required">
                            </div>
                          </div>
                           <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">Email</label>
                              <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email" required="required">
                            </div>
                            <div class="form-group col-md-6">
                              <label for="inputPassword4">Password</label>
                              <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="inputCity">Telp</label>
                              <input type="text" name="notlp" class="form-control" id="inputTelp" placeholder="Telp" required="required">
                            </div>
                            <div class="form-group col-md-6">
                               <label class="mr-sm-2" for="inlineFormCustomSelect">Level</label>
                                <select name="level" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                  <option selected>Choose...</option>
                                  <option value="admin">Admin</option>
                                  <option value="user">User</option>
                                 </select>
                            </div>
                          </div>
                              <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="inputCity">Kota</label>
                              <input type="text" name="kota" class="form-control" id="inputTelp" placeholder="Kota" required="required">
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