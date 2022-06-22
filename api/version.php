<?php 
include "../config.php";
session_start();

$ambilversion = "SELECT version FROM versionapp 
WHERE id = '1';";
$queryambilversion =$conn->query($ambilversion);
$rowambilversion = mysqli_fetch_array($queryambilversion, MYSQLI_ASSOC);
$version = $rowambilversion['version'];
  
$json = array(
       'result' => $version,
       );
       
echo json_encode($json); 
 


?>