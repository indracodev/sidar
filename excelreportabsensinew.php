<!DOCTYPE html>
<html>
<head>
	<title>Export Data Ke Excel </title>
</head>
<body>
	<style type="text/css">
	body{
		font-family: sans-serif;
	}
	table{
		margin: 20px auto;
		border-collapse: collapse;
	}
	table th,
	table td{
		border: 1px solid #3c3c3c;
		padding: 3px 8px;
 
	}
	a{
		background: blue;
		color: #fff;
		padding: 8px 10px;
		text-decoration: none;
		border-radius: 2px;
	}
	</style>
	

	<?php
	//ini_set('display_errors', '1');
    //ini_set('display_startup_errors', '1');
    //error_reporting(E_ALL);
    ini_set('memory_limit', '2077M');
    include "config.php";
    session_start();
	header("Content-type: application/xls");
	header("Content-Disposition: attachment; filename=DataReportAbsensi.xls");
	header("Pragma: no-cache"); 
    header("Expires: 0");
	$queryabsensi = $_POST["queryexcel"];
	$querydar = $conn->query($queryabsensi);
    $arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
  /*
  	$queryabsensipulang = $_POST["queryexcelpulang"];
	$querydarpulang = $conn->query($queryabsensipulang);
    $arrayrdarpulang = mysqli_fetch_all($querydarpulang, MYSQLI_ASSOC);
  */
	?>
 
	<center>
		<h1>Data Report Absensi</h1>
	</center>
 
	<table border="1">
	<tr>
                                      <th>Dept </th>
                                      <th>Name</th>
                                      <th>NIK</th>
                                      <th>Divisi</th>
                                      <th>Area</th>
                                      <th>Date_Masuk</th>
                                      <th>Time_Masuk</th>
                                      <th>Late</th>
                                      <th>Date_Pulang</th>
                                      <th>Time_Pulang</th>
                                      <th>At_Distributor_Masuk</th>
                                      <th>At_Distributor_Pulang</th>
                               
                                    </tr>
                                  </thead>
                         
                                  <tbody>
                                                             <?php
                for($x = 0; $x < sizeof($arrayrdar); $x++){
                     
                      $pecahnik = explode(".", $arrayrdar[$x]["NIK"]);
                      $hasilnik1 = $pecahnik[0];
                      $hasilnik2 = $pecahnik[1];
                      $hasilnik3 = $pecahnik[2];
                      $hasilnik4 = $pecahnik[3];
                      $hasilniknya = $pecahnik[0].$pecahnik[1].$pecahnik[2].$pecahnik[3];
                      
                   
                      
                  ?>
                
                  
                  <tr> 
                    <td scope="row"><?php echo $arrayrdar[$x]["Dept"] ?></td> 
                    <td><?php echo $arrayrdar[$x]["Name"] ?></td>
                    <td><?php echo $hasilniknya ?></td>
                    <td><?php echo $arrayrdar[$x]["Divisi"] ?></td>
                    <td><?php echo $arrayrdar[$x]["Area"] ?></td>
           
                    <td ><?php echo $arrayrdar[$x]["Date_Masuk"] ?></td>
                   
                   <td ><?php echo $arrayrdar[$x]["Time_Masuk"] ?></td>
                   
                    <td ><?php echo $arrayrdar[$x]["Late"] ?></td>
                   
                   <td ><?php if(!empty($arrayrdar[$x]["Date_Pulang"])){echo $arrayrdar[$x]["Date_Pulang"];}else{echo '-';} ?></td>
          
                   <td ><?php if(!empty($arrayrdar[$x]["Time_Pulang"])){echo $arrayrdar[$x]["Time_Pulang"];}else{echo '-';} ?></td>
                   
                   <td ><?php echo $arrayrdar[$x]["At_Distributor_Masuk"] ?></td>
             
                   <td ><?php echo $arrayrdar[$x]["At_Distributor_Pulang"] ?></td>
          
                  </tr>
                  <?php } ?>

	</table>

</body>
</html>