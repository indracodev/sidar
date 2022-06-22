<?php 
include "config.php";
session_start();
$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;

/*
SELECT masteruser.nama, masteruser.departemen, dar.jam, dar.tanggal, dar.urid
FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggal BETWEEN CAST('2020-01-28' AS DATE) AND CAST('2020-01-30' AS DATE) AND dar.iduser=1 ORDER BY dar.tanggal DESC
*/

/*

SELECT masteruser.nama, masteruser.departemen, dar.jam, dar.tanggal, dar.urid
FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE dar.activity LIKE '%ar%' AND dar.iduser=1 ORDER BY dar.tanggal DESC

*/

if($_SESSION["IDUser"] == 0){
header("Location: http://icg.id/beta/dar/login");
    }
else if ($_SESSION["Jabatan"] != "admin"){

$infodar = "SELECT masteruser.nama, masteruser.departemen, dar.jam, dar.tanggal, dar.nodar
FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE dar.iduser='".$iduser."' ORDER BY dar.tanggal DESC;";
$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);

}

else if ($_SESSION["Jabatan"] == "admin"){

$infodar = "SELECT masteruser.nama, masteruser.departemen, dar.jam, dar.tanggal, dar.nodar
FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE dar.iduser='".$iduser."' OR dar.ke='".$keuser."' ORDER BY dar.tanggal DESC;;";
$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);

} else {
    
}

?>

<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<title>User</title>
    <link rel="stylesheet icon" href="img/ikon.png">

    <!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Font Awesome CSS -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Roboto Fonts CSS -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
    <!-- User CSS -->
    <link rel="stylesheet" type="text/css" href="user.css">

    <!-- Custom styles for this page -->
    <link href="js/table/dataTables.bootstrap4.min.css" rel="stylesheet">

   <style>
    #linkk { color: black; } /* CSS link color */
  </style>


</head>
<body>

    <div class="wrapper">
        
        <!-- ---------------------------- 
            navbar
        ---------------------------- -->
        <?php include'admin-navbar.php';?>

        <!-- ---------------------------- 
            konten 
        ---------------------------- -->
        <main class="konten">

            <section class="dar mb-5">
                <div class="container-fluid">
                            <!-- DataTales Example -->
                          <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h4 class="card-title float-left">Report Per Day</h4>
                            </div>
                            <div class="card-body">
                              <div class="table-responsive">
                                <table class="table table-bordered" id="dataTablee" width="100%"  cellspacing="0">
                                  <thead>
                                    <tr>
                                      <th>Dept</th>
                                      <th>Name</th>
                                      <th>Date</th>
                                      <th>Time</th>
                                    </tr>
                                  </thead>
                                  <tfoot>
                                    <tr>
                                      <th>Dept</th>
                                      <th>Name</th>
                                      <th>Date</th>
                                      <th>Time</th>
                                    </tr>
                                  </tfoot>
                                  <tbody>
                                     <?php
                for($x = 0; $x < sizeof($arrayrdar); $x++){
                  ?>
                  <tr> 
                    <td scope="row"> <a id="linkk" href="reportdetail.php?idnya=<?php echo $arrayrdar[$x]["nodar"] ?>"><?php echo $arrayrdar[$x]["departemen"] ?></td> </a>
                    <td><a id="linkk" href="reportdetail.php?idnya=<?php echo $arrayrdar[$x]["nodar"] ?>"><?php echo $arrayrdar[$x]["nama"] ?></td></a>
                    <td><a id="linkk" href="reportdetail.php?idnya=<?php echo $arrayrdar[$x]["nodar"] ?>"><?php echo $arrayrdar[$x]["tanggal"] ?></td></a>
                    <td ><a id="linkk" href="reportdetail.php?idnya=<?php echo $arrayrdar[$x]["nodar"] ?>"><?php echo $arrayrdar[$x]["jam"] ?></td></a>
          
                  </tr>
                  <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                </div>
            </section><!-- end dar -->

            <footer class="text-center py-4">
                <small class="ls-2">Copyright &copy; 2020 - Indraco Group</small>
            </footer>

        </main>

    </div><!-- end wrapper -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- user JS -->
    <script type="text/javascript" src="user.js"></script>

     <!--table-->
    <script src="js/table/jquery.dataTables.min.js"></script>
    <script src="js/table/dataTables.bootstrap4.min.js"></script>
    
     <script>
    $(document).ready(function(){
        $('#dataTablee').DataTable({
   "aaSorting": []
    });
    });
</script>
    <!-- Page level custom scripts -->
    <script src="js/table/datatables-demo.js"></script>

</body>
</html>