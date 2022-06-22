<?php
session_start();
$iduser = $_COOKIE["IDUser"] ;
$keuser = $_COOKIE["Ke"] ;
$lokasikerja = $_SESSION["Lokasikerja"] ;

if($_SESSION["IDUser"] == 0){
header("Location: http://sidar.id/login");
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
                            Update Your Email
                        </h2>
                    </header>
                    <form method="POST" action="upemail.php">
                        <input type="text" name="emailone" class="form-control p-4 rounded-pill mb-2" placeholder="New Email">
                        <input type="text" name="emailtwo" class="form-control p-4 rounded-pill mb-2" placeholder="Confirm New Email">
                        <div class="d-block text-left pl-4">
                           
                        </div>
                        <div class="capcha mb-5"></div>
                        <button type="submit" class="btn btn-outline-dark rounded-pill">
                            <i class="fa fa-save"></i> UPDATE EMAIL
                        </button>
                    </form>
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