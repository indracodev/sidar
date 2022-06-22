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
                               
                                    </tr>
                                  </thead>
                         
                                  <tbody>
                                                             <?php
                for($x = 0; $x < sizeof($arrayrdar); $x++){
                      $status = $arrayrdar[$x]["status"];
                      $sudahbaca = $arrayrdar[$x]['sudahbaca'];
               
                      $pecahnik = explode(".", $arrayrdar[$x]["nik"]);
                      $hasilnik1 = $pecahnik[0];
                      $hasilnik2 = $pecahnik[1];
                      $hasilnik3 = $pecahnik[2];
                      $hasilnik4 = $pecahnik[3];
                      $hasilniknya = $pecahnik[0].$pecahnik[1].$pecahnik[2].$pecahnik[3];
                      
                      
                      $iduser = $arrayrdar[$x]['iduser'];
                      $tglsubmit = $arrayrdar[$x]['tglsubmit']; 
                      
                      $queryabsensipulang = "SELECT * FROM absenluarkota WHERE iduser = '".$iduser."' AND tglsubmit = '".$tglsubmit."' AND status = 'absen pulang'";
	                   $querydarpulang = $conn->query($queryabsensipulang);
                       $arrayrdarpulang = mysqli_fetch_array($querydarpulang, MYSQLI_ASSOC);
  
   
                       $pecahsudahbaca = explode("/", $sudahbaca);
                       $sdbc1 = $pecahsudahbaca[0];
                       $sdbc2 = $pecahsudahbaca[1];
                       $sdbc3 = $pecahsudahbaca[2];
                       $sdbc4 = $pecahsudahbaca[3];
                       $sdbc5 = $pecahsudahbaca[4];
                       $sdbc6 = $pecahsudahbaca[5];
 
 	                  
 
 
                       $pecahsdbc1 = explode("|", $sdbc1);
                       $sdbc100 = $pecahsdbc1[0];
                       $sdbc101 = $pecahsdbc1[1];
                       
                       $pecahsdbc2 = explode("|", $sdbc2);
                       $sdbc200 = $pecahsdbc2[0];
                       $sdbc201 = $pecahsdbc2[1];
                       
                       $pecahsdbc3 = explode("|", $sdbc3);
                       $sdbc300 = $pecahsdbc3[0];
                       $sdbc301 = $pecahsdbc3[1];
                       
                       $pecahsdbc4 = explode("|", $sdbc4);
                       $sdbc400 = $pecahsdbc4[0];
                       $sdbc401 = $pecahsdbc4[1];
                       
                       $pecahsdbc5 = explode("|", $sdbc5);
                       $sdbc500 = $pecahsdbc5[0];
                       $sdbc501 = $pecahsdbc5[1];
                       
                       $pecahsdbc6 = explode("|", $sdbc6);
                       $sdbc600 = $pecahsdbc6[0];
                       $sdbc601 = $pecahsdbc6[1];
                 
                       $ius = "$iduser";
                  
                       if($sdbc100 == $ius || $sdbc200 == $ius || $sdbc300 == $ius || $sdbc400 == $ius || $sdbc500 == $ius || $sdbc600 == $ius){
                           
                           $sama = "normal";
                         //  echo $sama;
                           
                       }else{
                           $sama = "bold";
                         //  echo $sama;
                       }
                      
                   
                      
                  ?>
                
                  
                  <tr> 
                    <td scope="row"><?php echo $arrayrdar[$x]["departement"] ?></td> 
                    <td><?php echo $arrayrdar[$x]["nama"] ?></td>
                    <td><?php echo $hasilniknya ?></td>
                    <td><?php echo $arrayrdar[$x]["bagian"] ?></td>
                    <td><?php echo $arrayrdar[$x]["kota"] ?></td>
           
                    <td ><?php
                    $tanggal = $arrayrdar[$x]["tglsubmit"];
                  //  echo $arrayrdar[$x]["jam"] 
                  
 $pecahtgl = explode("-", $tanggal);
$day = $pecahtgl[2];
$mon = $pecahtgl[1];
$yer = $pecahtgl[0];

$tgl = $day .'-'. $mon .'-'. $yer;
/*
$dateObj   = DateTime::createFromFormat('!m', $mon);
$monthName = $dateObj->format('F'); // March
*/
$tgl = $day .'-'. $mon .'-'. $yer;                  

$jam = $arrayrdar[$x]["jamsubmit"];



$pecahjam = explode(":", $jam);
$hor = $pecahjam[0];
$min = $pecahjam[1];
$det = $pecahjam[2];

$comparejam = $hor.$min.$det;
$comparejam = (int)$comparejam;
$thattime = '080000';
$thattime = (int)$thattime;

if($comparejam > $thattime && $status == "absen masuk"){
 $telat = "<label style='color:red;'>LATE</label>"; 
}else{
 $telat = "";    
}

/*
$dateObj   = DateTime::createFromFormat('!m', $mon);
$monthName = $dateObj->format('F'); // March
*/

$jamm = $hor .':'. $min;

$darsend = $tgl;
echo $darsend;                  
         
                    
                    
                    
                   ?></td>
                   
                   <td ><?php


$jam = $arrayrdar[$x]["jamsubmit"];



$pecahjam = explode(":", $jam);
$hor = $pecahjam[0];
$min = $pecahjam[1];
$det = $pecahjam[2];

$comparejam = $hor.$min.$det;
$comparejam = (int)$comparejam;
$thattime = '080000';
$thattime = (int)$thattime;

if($comparejam > $thattime && $status == "absen masuk"){
 $telat = "<label style='color:red;'>LATE</label>"; 
}else{
 $telat = "";    
}



$jamm = $hor .':'. $min;

$jamsend = $jamm;
echo $jamsend;                  
         
                    
                    
                    
                   ?></td>
                   
                    <td ><?php


$jam = $arrayrdar[$x]["jamsubmit"];



$pecahjam = explode(":", $jam);
$hor = $pecahjam[0];
$min = $pecahjam[1];
$det = $pecahjam[2];

$comparejam = $hor.$min.$det;
$comparejam = (int)$comparejam;
$thattime = '080000';
$thattime = (int)$thattime;

if($comparejam > $thattime && $status == "absen masuk"){
 $telat = "<label style='color:red;'>LATE</label>"; 
}else{
 $telat = "";    
}



echo $telat;                  
         
                    
                    
                    
                   ?></td>
                   
                   <td ><?php echo $arrayrdarpulang['tglsubmit'] ?></td>
          
                   <td ><?php echo $arrayrdarpulang['jamsubmit'] ?></td>
                   
             
          
                  </tr>
                  <?php } ?>

	</table>
</body>
</html>