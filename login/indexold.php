<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
if(!isset($_SESSION)) session_start();
if($_SESSION["IDUser"] > 0 ){
header("Location: https://sidar.id/");

    }
    
?>

<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>SIDAR</title>
	<link rel="stylesheet icon" href="../img/ikon.png">
	<!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Font Awesome CSS -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="../custom.css">
    <!-- inner style -->
    <style type="text/css">
    	.wrapper {
            background-color: #999;
        }
        .login {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1rem;
            background-color: #f9f9f9;
        }
        @media(min-width: 768px) {
            .login {
                width: 480px;
                height: 640px;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                padding: 2rem;
            }
        }
    </style>
</head>
<body>

	<div class="wrapper">

        <main class="login shadow">
            <div class="logo w-100">
                <img src="../img/logo.png" class="img-fluid" width="100px">
            </div>
            <div class="w-100">
                <h2 class="font-weight-bold text-center" style="letter-spacing: 4px;">SIDAR</h2>
                <p class="mb-5 text-center mx-auto" style="max-width: 200px;">
                    SYSTEM INFORMATION DAILY ACTIVITY REPORT
                </p>
                <form action="../login.php" method="post" class="mb-2">
                    <input type="text" name="username" class="form-control p-4 rounded-pill mb-2" placeholder="Username" maxlength="17" required>
                    <input type="password" name="password" class="form-control p-4 rounded-pill mb-3" placeholder="Password" maxlength="17" required>
               
                <div class="" style="margin-left:10px">
                    <a href="forgotPassword.php">Forgot password?</a>
                </div>
                <br>
                <div class="text-center">
                    <button type="submit" class="btn btn-outline-dark rounded-pill py-2 px-4" value="Login">
                    <i class="fa fa-lock"></i> LOGIN
                </button>
                </div>
                 </form>
            </div>
            <!-- FOOTER -->
            <footer class="text-center">
                <p class="mb-0" style="
                font-size: 80%; 
                letter-spacing: 2px;
                color: rgba(0,0,0,.7);
                ">
                   	Copyright © <?php echo date("Y"); ?> Indraco. All Rights Reserved
                </p>
            </footer>
        </main><!-- end login -->

	</div><!-- end wrapper -->

	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- Custom JS -->
    <script type="text/javascript" src="../custom.js"></script>
</body>
</html>