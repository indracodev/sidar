<?php
session_start();
$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;

$idnya = $_GET["idnya"];

if($_SESSION["IDUser"] == 0){
header("Location: http://sidar.id/login");
    }
    
include "config.php";

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
   $email = $row['email'];
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
                      <h5 class="card-title m-0 text-uppercase font-weight-bold">Detail User</h5>
                    </div>
                    <div class="card-body">
                      <!--
                        <form method="POST" action="updateuser.php">
                        -->
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="inputEmail4" >Nama</label>
                              <input disabled name="nama" type="text" class="form-control" id="Name" placeholder="Name" value="<?php echo $nama; ?>" required="required">
                            </div>
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">Unitusaha</label>
                              <input disabled name="unitusaha" type="text" class="form-control" id="LoginName" placeholder="Unitusaha" value="<?php echo $unitusaha; ?>" required="required">
                            </div>
                          </div>
                          
                              <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">Departemen</label>
                              <input disabled name="departemen" type="text" class="form-control" id="Name" placeholder="Departemen" value="<?php echo $departemen; ?>" required="required">
                            </div>
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">Bagian</label>
                              <input disabled name="bagian" type="text" class="form-control" id="LoginName" placeholder="Bagian Name" value="<?php echo $divisi; ?>" required="required">
                            </div>
                          </div>
                          
                           <div class="form-row">
                      <div class="form-group col-md-6">
                               <label class="mr-sm-2" for="inlineFormCustomSelect">Level</label>
                                <select name="jabatan" class="custom-select mr-sm-2" id="inlineFormCustomSelect" disabled>
                                  <option value="<?php echo $jabatan; ?>" selected><?php echo $jabatan; ?></option>
                                  <option value="manager">manager</option>
                                  <option value="supervisor">supervisor</option>
                                  <option value="staff">staff</option>
                                 </select>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="inputPassword4">Email</label>
                              <input disabled name="email" type="text" value="<?php echo $email; ?>" class="form-control" id="inputPassword" placeholder="Email" required="required">
                            </div>
                          </div>
                          
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">No Telephone</label>
                              <input disabled name="nohp" type="text" class="form-control" id="Name" placeholder="No tlp" value="<?php echo $notlp; ?>" required="required">
                               <input name="nodar" type="hidden" class="form-control" id="Name" placeholder="id" value="<?php echo $idnya; ?>" required="required">
                            </div>
                             <div class="form-group col-md-6">
                              <label for="inputEmail4">Report To</label>
                                   <select name="ke" class="custom-select d-block w-100" id="cc2" disabled >
                              <option value="<?php echo $ke ?>"> <?php echo $kenama ?>  </option>
                              
                                           <?php
                for($x = 0; $x < sizeof($arrayinfoccbc); $x++){
                      $status = $arrayinfoccbc[$x]["status"];
                  ?>
                              
                              <option value="<?php echo $arrayinfoccbc[$x]["id"]; ?>"><?php echo $arrayinfoccbc[$x]["nama"]; ?></option>
                              
                              <?php } ?>
                           
                            </select>
                            </div>
                          </div>
                          
                          
                            <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">CC 1</label>
                                       <select name="ke2" class="custom-select d-block w-100" id="cc2" disabled>
                              <option value="<?php echo $ke2 ?>"> <?php echo $ke2nama ?>  </option>
                              
                                           <?php
                for($x = 0; $x < sizeof($arrayinfoccbc); $x++){
                      $status = $arrayinfoccbc[$x]["status"];
                  ?>
                              
                              <option value="<?php echo $arrayinfoccbc[$x]["id"]; ?>"><?php echo $arrayinfoccbc[$x]["nama"]; ?></option>
                              
                              <?php } ?>
                           
                            </select>
                            </div>
                             <div class="form-group col-md-6">
                              <label for="inputEmail4">CC 2</label>
                          <select name="ke3" class="custom-select d-block w-100" id="cc2" disabled>
                              <option value="<?php echo $ke3 ?>"> <?php echo $ke3nama ?>  </option>
                              
                                           <?php
                for($x = 0; $x < sizeof($arrayinfoccbc); $x++){
                      $status = $arrayinfoccbc[$x]["status"];
                  ?>
                              
                              <option value="<?php echo $arrayinfoccbc[$x]["id"]; ?>"><?php echo $arrayinfoccbc[$x]["nama"]; ?></option>
                              
                              <?php } ?>
                           
                            </select>
                            </div>
                          </div>
                          
                            <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">CC 3</label>
                            <select name="ke4" class="custom-select d-block w-100" id="cc2" disabled>
                              <option value="<?php echo $ke4 ?>"> <?php echo $ke4nama ?>  </option>
                              
                                           <?php
                for($x = 0; $x < sizeof($arrayinfoccbc); $x++){
                      $status = $arrayinfoccbc[$x]["status"];
                  ?>
                              
                              <option value="<?php echo $arrayinfoccbc[$x]["id"]; ?>"><?php echo $arrayinfoccbc[$x]["nama"]; ?></option>
                              
                              <?php } ?>
                           
                            </select>
                            </div>
                                <div class="form-group col-md-6">
                              <label for="inputEmail4">CC 4</label>
                              <select name="ke5" class="custom-select d-block w-100" id="cc2" disabled>
                              <option value="<?php echo $ke5 ?>"> <?php echo $ke5nama ?>  </option>
                              
                                           <?php
                for($x = 0; $x < sizeof($arrayinfoccbc); $x++){
                      $status = $arrayinfoccbc[$x]["status"];
                  ?>
                              
                              <option value="<?php echo $arrayinfoccbc[$x]["id"]; ?>"><?php echo $arrayinfoccbc[$x]["nama"]; ?></option>
                              
                              <?php } ?>
                           
                            </select>
                            </div>
                            
                            </div>
                          
                            <div class="form-row">
                         
                          </div>
                  
                       
                            </div>
                
                          </div>
                          <div class="form-group">
                            <div class="form-check">
                          
                            </div>
                          </div>
                        <button style='display:none;' class="btn btn-outline-dark">
                            <i class="fa fa-send"></i> UPDATE USER
                        </button>
                     <!--
                        </form>
                        -->
                </div>
            </div>
            </div>
            </section><!-- end dar -->

			<!-- FOOTER -->
			<?php // include'footer.php';?>

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