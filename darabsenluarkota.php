<?php
include "config.php";
session_start();
$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;

date_default_timezone_set('Asia/Jakarta');

$datee = date('Y-m-d');

if($_SESSION["IDUser"] == 0){
header("Location: http://sidar.id/login");
    }



 $stringmasteruser = "SELECT * FROM masteruser 
 WHERE id = '" .$iduser . "';";
 $querynama =$conn->query($stringmasteruser);

 $rowmasteruser = mysqli_fetch_array($querynama, MYSQLI_ASSOC);
 
 $namanya = $rowmasteruser['username'];


 
 $ambilnoabsensi = "SELECT * FROM absenluarkota WHERE iduser = '" .$iduser. "' ORDER BY idabsen DESC LIMIT 1 ;";
   $queryambilnoabsensi =$conn->query($ambilnoabsensi);



 $ambilnofeedmasuk = "SELECT * FROM absenluarkota WHERE iduser = '" .$iduser. "' and tglsubmit = '" .$datee. "' and status = 'absen masuk' ORDER BY idabsen DESC LIMIT 1 ;";
   $queryambilnofeedmasuk =$conn->query($ambilnofeedmasuk);
  
  
  if($queryambilnofeedmasuk->num_rows){
      
      $btnmasuk = 'disabled';
     // echo 'ok masuk';
      
  }else{
      $btnmasuk = '';
  //     echo 'tidak masuk';
  }
  
  
  
   $ambilnofeedpulang = "SELECT * FROM absenluarkota WHERE iduser = '" .$iduser. "' and tglsubmit = '" .$datee. "' and status = 'absen pulang' ORDER BY idabsen DESC LIMIT 1 ;";
   $queryambilnofeedpulang =$conn->query($ambilnofeedpulang);
  
  
  if($queryambilnofeedpulang->num_rows){
     $btnpulang = 'disabled';  
   //   echo 'ok pulang';
  }else{
     $btnpulang = '';  
   //   echo 'tidak pulang';
  }
  
  
  
  if($queryambilnoabsensi->num_rows){
      
    $rowambilnoabsensi = mysqli_fetch_array($queryambilnoabsensi, MYSQLI_ASSOC);
     $noabsensi = $rowambilnoabsensi['noabsensi'];
 
 $pecah = explode("/", $noabsensi);
$hasil = $pecah[1] + 1;
$noabsensinya = $userid."/".$hasil;  

      
  }else{
    $satu = "1";
   //echo " gak dapat nomer ";
   $noabsensinya = $iduser."/".$satu;
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
        .konten {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .reset {
            width: 480px;
            position: relative;
        }
    </style>
</head>
<body>

	<div class="wrapper">

        <!-- NAVBAR -->
        <?php include'navbar1.php';?>

        <main class="konten">

            <section class="reset text-center">
                <div class="container">
                    <header class="mb-5">
                        <h2>
                            Dinas Luar Kota
                        </h2>
                    </header>
                    <form method="POST" enctype="multipart/form-data" style="padding-top:5px;padding-bottom:5px;border-style:dashed;" action="datauploadluarkota.php">
                   
                    <div class="d-block text-left pl-4">
                    <div class="capcha mb-5"></div>
                    
                    <textarea style="display:none;" value="" name="gambar" id="gambarmasuk" rows="5" cols="255">
</textarea>
           
                    <input type="hidden" name="status" value="absen masuk">
                    <input type="hidden" name="latitude" id="latitudemasuk" value="">
                    <input type="hidden" name="longitude" id="longitudemasuk" value="">
                    <input type="file" style="margin-bottom:5px;" id="foto1" name="file" accept="image/*" capture="camera"  required >      
                    </div>
          
                        <button <?php echo $btnmasuk;?> type="submit" class="btn btn-outline-dark rounded-pill">
                            <i class="fa fa-save"></i> Absen Masuk
                        </button>
                    </form>

                     <form method="POST" enctype="multipart/form-data" style="padding-top:5px;padding-bottom:5px;border-style:dashed;" action="datauploadluarkota.php">
                        <div class="capcha mb-5"></div>
                <div class="d-block text-left pl-4">
                     <textarea style="display:none;" name="gambar" id="gambarpulang" value="" rows="5" cols="255">
</textarea>
        
                    <input type="hidden" name="status" value="absen pulang">
                    <input type="hidden" name="latitude" id="latitudepulang" value="">
                    <input type="hidden" name="longitude" id="longitudepulang" value="">
                <input type="file" style="margin-bottom:5px;" id="foto2" name="file" accept="image/*" capture="camera"  required >
                        </div>
          
                        <button <?php echo $btnpulang;?>type="submit" class="btn btn-outline-dark rounded-pill">
                            <i class="fa fa-save"></i> Absen Pulang
                        </button>
                    </form>
                    
                    <p id="demo"></p>
                    
                </div><!-- end container -->
            </section>

        </main><!-- end main konten -->

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
            
function readFile() {
              
    
   if (this.files && this.files[0]) {
    
    var FR= new FileReader();
    
    FR.addEventListener("load", function(e) {
      $('#gambarmasuk').val(e.target.result);
      $('#gambarpulang').val(e.target.result);
      console.log(e.target.result);
    }); 
    
    FR.readAsDataURL( this.files[0] );
  }
  
}

document.getElementById("foto1").addEventListener("change", readFile); 
document.getElementById("foto2").addEventListener("change", readFile);  

    var x = document.getElementById("demo");

    function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.watchPosition(showPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}
    
function showPosition(position) {
    x.innerHTML="Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude;
    
      $('#latitudemasuk').val(position.coords.latitude);
      $('#longitudemasuk').val(position.coords.longitude);
       
      $('#latitudepulang').val(position.coords.latitude);
      $('#longitudepulang').val(position.coords.longitude);
}
            
        getLocation();    
            
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