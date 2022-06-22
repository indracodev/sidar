<?php

$servername = "localhost";
$username = "supresso_dar";
$password = "JZ@_B[403cCG";
$database = "supresso_ospedale";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


$output = '';
$iduser = $_POST["idaser"] ;

date_default_timezone_set('Asia/Jakarta');

$dateee = date('d-m-Y');
$tglhariini = date('Y-m-d');

$ststgldar = new DateTime($tglhariini);
$ststgldar->modify('-30 day');
$tglterakhirdar = $ststgldar->format('Y-m-d'); 


 $queryy = "SELECT masteruser.nama, masteruser.nik, masteruser.departemen, dar.status, dar.sudahbaca, dar.tanggaldar, dar.jam, dar.tanggal, dar.urid, dar.tag FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggal BETWEEN CAST('".$tglterakhirdar."' AS DATE) AND CAST('".$tglhariini."' AS DATE) AND dar.iduser=".$iduser." AND (dar.status='late' OR dar.status='over') ORDER BY dar.tanggaldar DESC";
 $resultt = mysqli_query($conn, $queryy);
 if(mysqli_num_rows($resultt) > 0)
 {
  $output .= '
   <table class="table" bordered="1">  
                    <tr>  
                         <th>DEPT</th>  
                         <th>NAME</th>
                         <th>NIK</th>
                          <th>DAR DATE</th>
                         <th>STATUS</th> 
                    </tr>
  ';
  while($row = mysqli_fetch_array($resultt))
  {
   $output .= '
                     <tr>  
                         <td>'.$row["departemen"].'</td>  
                         <td>'.$row["nama"].'</td>  
                         <td>'.$row["nik"].'</td> 
                          <td>'.$row["tanggaldar"].'</td> 
                         <td>'.$row["status"].'</td> 
                    </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=listlatedar'.$iduser.'.xls');
  echo $output;
 }

?>
