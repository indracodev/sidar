<?php 
include "../config.php";
session_start();
$nodar = addslashes($_POST['nodar']); 
$iduser = addslashes($_POST['iduser']);
$username = addslashes(strtolower($_POST['username']));

$pecah = explode("/", $nodar);
$hasiliduser = $pecah[0];

date_default_timezone_set('Asia/Jakarta');
$tggl = date('Y-m-d');
$waktu = date('H:i');

$wktgl = "|". $tggl.";".$waktu;
 
 $stringmasteruser = "SELECT * FROM masteruser 
 WHERE id = '" .$hasiliduser . "';";
 $querynama =$conn->query($stringmasteruser);

 $rowmasteruser = mysqli_fetch_array($querynama, MYSQLI_ASSOC);
 
 $divisiuser = $rowmasteruser["divisi"];
 $kotauser = $rowmasteruser["kota"];
 
 $namanya = $rowmasteruser['username'];
 $nemnya = $rowmasteruser['nama'];
 $departemen = $rowmasteruser['departemen'];
 
 if($username == $namanya){
     $sama = 'ya';
 }
 

if(empty($nodar) || empty($username) || $sama != 'ya'){
$json = array(
       'result' => 'nodar and username is empty!',
       'item' => $item
       );
       
echo json_encode($json); 
return false;
}

else{
 $username = $_POST['nodar'];
 $string = "SELECT * FROM dar 
 WHERE nodar = '" .$nodar . "' ;";
 $query =$conn->query($string);
 
 if($query->num_rows){
     
   $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
 //  $iduser = $row['id'];
   $activity = "login";
   $sudahbaca = $row['sudahbaca'];

$pecahsudahbaca = explode("/", $sudahbaca);
 $sdbc1 = $pecahsudahbaca[0];
 $sdbc2 = $pecahsudahbaca[1];
 $sdbc3 = $pecahsudahbaca[2];
 $sdbc4 = $pecahsudahbaca[3];
 $sdbc5 = $pecahsudahbaca[4];
 $sdbc6 = $pecahsudahbaca[5];
 
 $idbc01 = explode("|", $sdbc1);
 $idbc1 = $idbc01[0];
 $idbc02 = explode("|", $sdbc2);
 $idbc2 = $idbc02[0];
 $idbc03 = explode("|", $sdbc3);
 $idbc3 = $idbc03[0];
 $idbc04 = explode("|", $sdbc4);
 $idbc4 = $idbc04[0];
 $idbc05 = explode("|", $sdbc5);
 $idbc5 = $idbc05[0];
 $idbc06 = explode("|", $sdbc6);
 $idbc6 = $idbc06[0];
 
 $ius = "$iduser";

 if($sudahbaca == ""){
    $sudahbaca = $iduser . $wktgl . "/";
    $kirimsudahbaca .= "UPDATE dar SET sudahbaca='" .$sudahbaca . "' WHERE nodar = '" .$nodar . "' ";      
if ($conn->query($kirimsudahbaca) === TRUE) {
}else{
    
} 


 }elseif ($sudahbaca != "" && $idbc1 != $iduser && $idbc2 != $iduser && $idbc3 != $iduser && $idbc4 != $iduser && $idbc5 != $iduser && $idbc6 != $iduser){
 $sudahbaca = $sudahbaca . $iduser . $wktgl . "/"; 
     
     $kirimsudahbaca .= "UPDATE dar SET sudahbaca='" .$sudahbaca . "' WHERE nodar = '" .$nodar . "' ";      
if ($conn->query($kirimsudahbaca) === TRUE) {
}else{
    
} 


 }else{
     
 } 


 
   $ambilattach = "SELECT * FROM masterattach 
   WHERE nodar = '" .$nodar. "' ;";
   $queryambilattach =$conn->query($ambilattach);
       $t = 0;
      $daftargambar[$t];
  
  if($queryambilattach->num_rows){
      $rowambilattach = mysqli_fetch_all($queryambilattach, MYSQLI_ASSOC);
   
   
      for ($x = 0; $x < count($rowambilattach); $x++) {
      $daftargambar[$t] = $rowambilattach[$x]["gambar"] ;
 
         
      $t++;
    } 
      
  }
    

    
  
      $item[] = array(
       "iduser"=>$row['iduser'],
       "nama"=>$nemnya,
       "departemen"=>$departemen,
       "tanggaldar"=>$row['tanggaldar'],
       "tanggal"=>$row['tanggal'],
       "jam"=>$row['jam'],
       "status"=>$row['status'],
       "activity"=>$row['activity'],
       "result"=>$row['result'],
       "plan"=>$row['plan'],
       "divisi"=>$divisiuser,
       "kota"=>$kotauser,
       "noabsensi"=>$row['tag'],
       "gambar"=>$daftargambar,
      
      );   
         
   
   
   $json = array(
       'result' => 'success',
       'item' => $item
       );
       
  echo json_encode($json);    
   

   
 }
 
 
 
 
}

?>