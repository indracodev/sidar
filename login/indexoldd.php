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
        

        
        .btn-show-pass {
    font-size: 18px;
    color: #999999;
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: block; 
    align-items: center;
    position: absolute;
    height: 100%;
    top: 0;
    right: 17px;
    padding: 22.1rem 30px;
    cursor: pointer;
    -webkit-transition: background 0.4s;
    -o-transition: background 0.4s;
    -moz-transition: background 0.4s;
    transition: background 0.4s;
}
.btn-show-pass:hover {
    color: #ff5000;
}
  
.btn-show-pass.active {
  color: #ff5000;
}


@media only screen and (min-width: 393px) and (max-width: 767px) {
    
    .btn-show-pass {
             padding: 25.1rem 30px !important;
                }
 }
 
 
 @media only screen 
    and (device-width: 390px) 
    and (device-height: 844px) 
    and (-webkit-device-pixel-ratio: 3) {
        
            .btn-show-pass {
             padding: 33.8rem 30px !important;
                }
    }
    
    @media only screen 
    and (device-width: 428px) 
    and (device-height: 926px) 
    and (-webkit-device-pixel-ratio: 3) {
        
         .btn-show-pass {
             padding: 25.8rem 30px !important;
                }
    }
 

   @media only screen 
  and (min-width: 768) 
  and (max-height: 1024) 
  and (-webkit-min-device-pixel-ratio: 1.5) {
        .btn-show-pass {
             padding: 22.8rem 30px !important;
                }

      
      }
      
      @media only screen 
    and (device-width : 375px) 
    and (device-height : 812px) 
    and (-webkit-device-pixel-ratio : 3) { 
          .btn-show-pass {
             padding: 26.8rem 30px !important;
                }
    }
    
    
      
      @media only screen 
    and (device-width : 375px) 
    and (device-height : 667px) 
    and (-webkit-device-pixel-ratio : 2) { 
        
          .btn-show-pass {
             padding: 22.1rem 30px !important;
                }
    }

       @media only screen 
    and (device-width : 411px) 
    and (device-height : 823px) 
    and (-webkit-device-pixel-ratio : 2) {
          .btn-show-pass {
             padding: 25.8rem 30px !important;
                }
        
    }
        
        @media only screen 
    and (device-width : 414px) 
    and (device-height : 736px) 
    and (-webkit-device-pixel-ratio : 3) {
          .btn-show-pass {
             padding: 24.8rem 30px !important;
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
                        <div class="form-input">
                    <input type="text" name="username" class="form-control p-4 rounded-pill mb-2" placeholder="Username" maxlength="17" required>
                    </div>
            <div class="form-input">
        <div class="form-input" id="show_hide_password">
           <input class="form-control p-4 rounded-pill mb-3" name="password" type="password" placeholder="Password" required="required">
              <div class="btn-show-pass" style="display:flex !important">
            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
              </div>
        </div>
            </div>   
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
    <script>
        
        (function ($) {
    "use strict";

 /*==================================================================
    [ Show pass ]*/
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
    </script>
    <script type="text/javascript" src="../custom.js"></script>
</body>
</html>