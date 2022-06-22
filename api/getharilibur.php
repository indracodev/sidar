<?php 
include "../config.php";
session_start();
$iduser = addslashes($_POST['iduser']); 
$username = addslashes(strtolower($_POST['username']));
$bulan = addslashes($_POST['bulan']);
 
 $stringmasteruser = "SELECT * FROM masteruser 
 WHERE id = '" .$iduser . "';";
 $querynama =$conn->query($stringmasteruser);

 $rowmasteruser = mysqli_fetch_array($querynama, MYSQLI_ASSOC);
 
 $namanya = $rowmasteruser['username'];

 if($username == $namanya){
     $sama = 'ya';
 }
 

if(empty($iduser) || empty($username) || $sama != 'ya'){
$json = array(
       'result' => 'iduser and username is empty!',
       'item' => $item
       );
       
echo json_encode($json); 
return false;
}

else{
$monthNum  = date('m');
$year = date('Y');
switch ($monthNum) {
    case 1:
       $bln = "januari";
        break;
    case 2:
        $bln = "februari";
        break;
    case 3:
       $bln = "maret";
        break;
    case 4:
       $bln = "april";
        break;
    case 5:
      $bln = "mei";
        break;
    case 6:
        $bln = "juni";
        break;
    case 7:
      $bln = "juli";
        break;
    case 8:
       $bln = "agustus";
        break;
    case 9:
      $bln = "september";
        break;
    case 10:
     $bln = "oktober";
        break;
    case 11:
        $bln = "november";
        break;
    case 12:
       $bln = "desember";
        break;
    default:
        echo "Your favorite color is neither red, blue, nor green!";
}

 $ambilstatustanggalibur = "SELECT * FROM mastertanggal WHERE $bln = 'libur'";

   

 $queryambilstatustanggalibur =$conn->query($ambilstatustanggalibur);

 
 if($queryambilstatustanggalibur->num_rows){
     
$rowambilstatustanggalibur = mysqli_fetch_all($queryambilstatustanggalibur, MYSQLI_ASSOC);


$t = 0;
$daftartanggalibur[$t];
$daftartanggalibur[0] = '31-10-2020' ;
   $t++;
$daftartanggalibur[1] = '31-12-2020' ;
   $t++;
$daftartanggalibur[2] = '30-01-2020' ;
   $t++;
$daftartanggalibur[3] = '31-01-2020' ;
   $t++;  
$daftartanggalibur[4] = '27-02-2021' ;
   $t++;  
$daftartanggalibur[5] = '28-02-2021' ;
   $t++;    
$daftartanggalibur[$t] = '30-01-2022' ;
   $t++;
 $daftartanggalibur[$t] = '26-02-2022' ;
   $t++;
    $daftartanggalibur[$t] = '27-02-2022' ;
   $t++;
    $daftartanggalibur[$t] = '28-02-2022' ;
   $t++;
    $daftartanggalibur[$t] = '19-02-2022' ;
   $t++;
    $daftartanggalibur[$t] = '20-02-2022' ;
   $t++;
      $daftartanggalibur[$t] = '03-04-2022' ;
   $t++;

   $daftartanggalibur[$t] = '02-04-2022' ;
   $t++;
   $daftartanggalibur[$t] = '29-04-2022' ;
   $t++;
    $daftartanggalibur[$t] = '30-04-2022' ;
   $t++;



   
for ($x = 0; $x < count($rowambilstatustanggalibur); $x++) {
   $daftartanggalibur[$t] = $rowambilstatustanggalibur[$x]["id"]. "-" .$monthNum. "-".$year ;
 
         
   $t++;
} 
 
 

    
      $item[] = array(
       "harilibur"=>$daftartanggalibur, 
     
      
      );  
  
   
   
   $json = array(
       'result' => 'success',
       'item' => $item
       );
       
    echo json_encode($json);    
   

   
 }
 
 
 
 
}

?>