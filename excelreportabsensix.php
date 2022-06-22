 <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <!-- Load translation files and libraries. -->
<style type="text/css">
	body{
		background-color: #fff;
	}
	
	.container{
		position: absolute;
		left: 50%;
		top: 50%;
		transform: translate(-50%, -50%);
	}

	.box-one{
		width: 180px;
		height: 180px;
		border-radius: 50%;
		border-top: 3px solid transparent;
		border-right: 3px solid transparent;
		border-bottom: 3px solid #f96d1f;
		border-left: 3px solid #f96d1f;
		animation: rotationa 2s linear infinite; 
	}
	.box-two{
		width: 145px;
		height: 145px;
		position: absolute;
		left: 9%;
		top: 9%;
		transform: translate(-20%, -20%);
		border-radius: 50%;
		border-top: 3px solid transparent;
		border-right: 3px solid transparent;
		border-bottom: 3px solid #f96d1f;
		border-left: 3px solid #f96d1f;
		animation: rotationb 2s linear infinite;
	}
	.box-three{
		width: 80px;
		height: 80px;
		position: absolute;
		left: 27%;
		top: 27%;
		transform: translate(-40%, -40%);
		border-radius: 50%;
		border-top: 3px solid #f96d1f;
		border-right: 3px solid #f96d1f;
		border-bottom: 3px solid transparent;
		border-left: 3px solid transparent;
		animation: rotationc 2s linear infinite;
	}
	@keyframes rotationa{
		0%{
			transform: rotate(0deg);
		}
		100%{
			transform: rotate(-360deg);
		}
	}
	@keyframes rotationb{
		0%{
			transform: rotate(0deg);
		}
		100%{
			transform: rotate(360deg);
		}
	}
	@keyframes rotationc{
		0%{
			transform: rotate(0deg);
		}
		100%{
			transform: rotate(-360deg);
		}
	}
</style>

	<div class="container">
		<div class="box-one"></div>		
		<div class="box-two"></div>
		<div class="box-three"></div>
		<br>

	</div>
	
	<div class="container"><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><h1>Sedang Download File</h1></div>

	<form method="POST" action="excelreportabsensinew.php">      
    <button type="submit" style="display:none" id="submit"></button>
    <input type="hidden" value="<?php echo $_POST["queryexcel"] ;?>" name="queryexcel">
    </form>

      <script>
      document.getElementById("submit").click();

 // window.close();

      </script>