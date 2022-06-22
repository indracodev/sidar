<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


if($_SESSION["IDUser"] > 0 ){
    header("Location: https://sidar.id/");
}
echo $_SESSION["IDUser"];
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
        button:focus, input:focus, select:focus, a:focus, textarea:focus, .swiper-button-next:focus, .swiper-button-prev:focus {
            outline: none!important;
            box-shadow: none!important;
            text-decoration: none!important;
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
            <header class="logo w-100">
                <img src="../img/logo.png" width="125" height="auto">
            </header>
            <div class="w-100">
                <h2 align="center" style="letter-spacing: 4px;">
                    <strong>SIDAR</strong>
                </h2>
                <p align="center" class="mb-5">
                    SYSTEM INFORMATION
                    <br>
                    DAILY ACTIVITY REPORT
                </p>
                <form action="https://sidar.id/login.php" method="post">
                    <div class="form-group border-bottom border-secondary">
                        <input type="text" name="username" class="form-control form-control-lg rounded-0 bg-transparent border-0" placeholder="Username" maxlength="17" required>
                    </div>
                    <div class="form-group border-bottom border-secondary position-relative">
                        <div class="input-group" id="show_hide_password">
                            <input class="form-control form-control-lg rounded-0 bg-transparent border-0" name="password" type="password" placeholder="Password" required="required">
                            <a href="" class="btn btn-show-pass d-flex justify-content-center align-items-center">
                                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
             
                <p align="left" class="mb-5">
                    <a href="forgotPassword.php">Forgot password?</a>
                </p>
                <p align="center" class="mb-5">
                    <button type="submit" class="btn form-control-lg btn-outline-dark px-5" value="Login">
                        <i class="fa fa-lock"></i> LOGIN
                    </button>
                </p>
                   </form>
            </div>
            <footer class="small text-center">
                Copyright © <?php echo date("Y"); ?> Indraco. All Rights Reserved
            </footer>
        </main><!-- end login -->

    </div><!-- end wrapper -->

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../custom.js"></script>
    <script type="text/javascript">
        (function ($) {
            "use strict";
            /*=================[ Show pass ]*/
            $(document).ready(function() {
                $("#show_hide_password a").on('click', function(event) {
                    event.preventDefault();
                    if($('#show_hide_password input').attr("type") == "text"){
                        $('#show_hide_password input').attr('type', 'password');
                        $('#show_hide_password i').addClass( "fa-eye-slash" );
                        $('#show_hide_password i').removeClass( "fa-eye" );
                    }else if($('#show_hide_password input').attr("type") == "password"){
                        $('#show_hide_password input').attr('type', 'text');
                        $('#show_hide_password i').removeClass( "fa-eye-slash" );
                        $('#show_hide_password i').addClass( "fa-eye" );
                    }
                });
            });
        })(jQuery);
        // [].forEach.call(document.querySelectorAll("*"), function(a){a.style.outline="1px solid green";})
    </script>
</body>
</html>