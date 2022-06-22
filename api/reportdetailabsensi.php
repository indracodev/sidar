<?php 
include "../config.php";
session_start();
$nodar = $_POST['noabsensi']; 
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
 
  $stringnoabsensi = "SELECT * FROM absenluarkota 
 WHERE noabsensi = '" .$nodar . "';";
 $querynoabsensi =$conn->query($stringnoabsensi);

 $rowmasternoabsensi = mysqli_fetch_array($querynoabsensi, MYSQLI_ASSOC);
 $keid = $rowmasternoabsensi['iduser'];
 $kee1 = $rowmasternoabsensi['ke'];
 $kee2 = $rowmasternoabsensi['ke2'];
 $kee3 = $rowmasternoabsensi['ke3'];
 $kee4 = $rowmasternoabsensi['ke4'];
 $kee5 = $rowmasternoabsensi['ke5'];
    
 $namanya = $rowmasteruser['username'];
 $nemnya = $rowmasteruser['nama'];
 $departemen = $rowmasteruser['departemen'];
 $note = $rowmasteruser['note'];
  
 if($idsuer == $keid || $iduser == $kee1 || $iduser == $kee2 || $iduser == $kee3 || $iduser == $kee4 || $iduser == $kee5 ){
     $sama = 'ya';
 }
 
  if($username == $namanya){
     $sama = 'ya';
 }
 

if(empty($nodar) || empty($username) || $sama != 'ya'){
$json = array(
       'result' => 'nodar and username is empty!',
       'item' => $namanya,
       );
       
echo json_encode($json); 
return false;
}

else{

 $string = "SELECT * FROM absenluarkota 
 WHERE noabsensi = '" .$nodar . "' ;";
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
    $kirimsudahbaca .= "UPDATE absenluarkota SET sudahbaca='" .$sudahbaca . "' WHERE noabsensi = '" .$nodar . "' ";      
if ($conn->query($kirimsudahbaca) === TRUE) {
}else{
    
} 


 }elseif ($sudahbaca != "" && $idbc1 != $iduser && $idbc2 != $iduser && $idbc3 != $iduser && $idbc4 != $iduser && $idbc5 != $iduser && $idbc6 != $iduser){
 $sudahbaca = $sudahbaca . $iduser . $wktgl . "/"; 
     
     $kirimsudahbaca .= "UPDATE absenluarkota SET sudahbaca='" .$sudahbaca . "' WHERE noabsensi = '" .$nodar . "' ";      
if ($conn->query($kirimsudahbaca) === TRUE) {
}else{
    
} 


 }else{
     
 } 





    
  
      $item[] = array(
       "noabsensi"=> $row["noabsensi"],
       "company"=>$row["company"],
       "departement"=>$row["departement"],
       "nama"=>$row["nama"],
       "tanggal"=>$row["tglsubmit"],
       "divisi"=>$row["bagian"],
       "kota"=>$row["kota"],
       "jam"=>$row["jamsubmit"],
       "sudahbaca"=>$row["sudahbaca"],
       "status"=>$row["status"],
       "latitude"=>$row["latitude"],
       "longitude"=>$row["longitude"],
       "alamat"=>$row["alamat"],
       "note"=>$row['note'],
       "gambar"=>$row['gambar'],
      
      );   
         
   
   
   $json = array(
       'result' => 'success',
       'item' => $item
       );
       
  echo json_encode($json);    
   

   
 }
 
 
 
 
}

?>