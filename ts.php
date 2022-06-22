<?php
session_start();
include "config.php";

$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;

date_default_timezone_set('Asia/Jakarta');
$datetimee = date('Y-m-d');
$datetime = DateTime::createFromFormat('Y-m-d', $datetimee);
$namahari = $datetime->format('D');
$jam = date('H:i');

if ($namahari == "Sat" && $jam >= "10:58"){


$belumkirim .= "UPDATE masteruser SET sudahkirim='belum' ";      
if ($conn->query($belumkirim) === TRUE) {
}else{
    
}    


    
}elseif ($namahari != "Sat" && $jam >= "15:59"){
    
$belumkirim .= "UPDATE masteruser SET sudahkirim='belum' ";      
if ($conn->query($belumkirim) === TRUE) {
}else{
    
}   
    
    
}

$sudahbaca = 4 . "/" ;

 $pecahsudahbaca = explode("/", $sudahbaca);
 $sdbc1 = $pecahsudahbaca[0];
 $sdbc2 = $pecahsudahbaca[1];
 $sdbc3 = $pecahsudahbaca[2];
 $sdbc4 = $pecahsudahbaca[3];
 $sdbc5 = $pecahsudahbaca[4];
 $sdbc6 = $pecahsudahbaca[5];
 
 $iu = "$iduser";
 
 if($sudahbaca == ""){
    $sudahbaca = $iduser . "/";
  echo $sudahbaca ;
  echo "if" ;

 }elseif ($sdbc1 == $iu){
 //  $sudahbaca = $sudahbaca . $iduser . "/"; 
  echo "elseif sdbc1" ;
  echo $sudahbaca;
echo "<br>";

 }elseif ($iu == $sdbc2){
   //$sudahbaca = $sudahbaca . $iduser . "/"; 
  echo "elseif sdbc2" ;
  echo "<br>";
  echo $sdbc2;
  echo $iu;
  echo "<br>";
  echo $sudahbaca;
echo "<br>";
}elseif ($sdbc3 == $iu){
  // $sudahbaca = $sudahbaca . $iduser . "/"; 
  echo "elseif sdbc3" ;
  echo $sudahbaca;
echo "<br>";
}elseif ($sdbc4 == $iu){
  // $sudahbaca = $sudahbaca . $iduser . "/"; 
  echo "elseif sdbc4" ;
  echo $sudahbaca;
echo "<br>";
}elseif ($sdbc5 == $iu){
  // $sudahbaca = $sudahbaca . $iduser . "/"; 
  echo "elseif sdbc5" ;
  echo $sudahbaca;
echo "<br>";
}elseif ($sdbc6 == $iu){
   //$sudahbaca = $sudahbaca . $iduser . "/"; 
  echo "elseif sdbc6" ;
  echo $sudahbaca;
echo "<br>";
}else{
    echo $sudahbaca;
  echo "else";
echo "<br>";

 }

echo $iduser;
echo "<br>";
echo $sdbc1;
echo "<br>";
echo $sdbc2;
echo "<br>";
echo $sdbc3;
echo "<br>";
echo $sdbc4;
echo "<br>";
echo $sdbc5;
echo "<br>";
echo $sdbc6;
echo "<br>";
?>