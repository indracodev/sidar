<?php 
session_start();
include "config.php";

$dapatday = $_POST['tglcutinya'];
$grupcuti = $_POST['grupcuti'];


//////////////////////////////////////////////////////////////////////////////////////////////////////////
$infojmlkuota= "SELECT * FROM masteruser WHERE grupcutiku = '".$grupcuti."' limit 1 ;";

$queryjmlkuota = $conn->query($infojmlkuota);
$arrayjmlkuota = mysqli_fetch_array($queryjmlkuota, MYSQLI_ASSOC);
$kuotagrupcuti = $arrayjmlkuota['kuotagrupcuti'];
///////////////////////////////////////////////////////////////////////////////////////////////////////////

$infokuotagrup = "SELECT * FROM isikuotacuti WHERE tanggalcuti = '".$panhari."' and grupcutiku = '".$grupcuti."';";

$querykuotagrup = $conn->query($infokuotagrup);
$arraykuotagrup = mysqli_fetch_all($querykuotagrup, MYSQLI_ASSOC);

if(sizeof($arraykuotagrup) >= $kuotagrupcuti){
echo 'habis';  
}else{
echo 'ada';    
}
?>