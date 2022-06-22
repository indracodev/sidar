<?php
include "config.php";

$idnya = $_GET["idnya"];


$string = "SELECT * FROM todo WHERE idtodo = '" .$idnya . "' ;";
$queryambil =$conn->query($string);
$rowambil = mysqli_fetch_array($queryambil, MYSQLI_ASSOC);

$IUser = $rowambil['iduser'];
$iduser = $rowambil['iduser'];
$target = $rowambil['target'];
$activity = $rowambil['todo'];
$result = $rowambil['result'];
$date = $rowambil['date'];
$duedate = $rowambil['duedate'];

 $ambilnomer = "SELECT nodar FROM hdar 
   WHERE iduser = '" .$IUser. "' ORDER BY urid DESC LIMIT 1 ;";
   $queryambilnomer =$conn->query($ambilnomer);
 if($queryambilnomer->num_rows){
   session_start();
 $rowambilnomer = mysqli_fetch_array($queryambilnomer, MYSQLI_ASSOC);
 $nodar = $rowambilnomer['nodar'];
 
 $pecah = explode("/", $nodar);
$hasil = $pecah[1] + 1;
$nodarnya = $IUser."/".$hasil;

 }
 else{
    // header("location: http://www.icg.id/beta/dar/login");
    $satu = "1";
   //echo " gak dapat nomer ";
   $nodarnya = $IUser."/".$satu;
 }

//=====================================================================

date_default_timezone_set('Asia/Jakarta');


$datee = date('Y-m-d');
$dateee = date('d-m-Y');
$tglhariini = date('Y-m-d');

$jam = date('H:i');
$day = date('d');
$year = date('Y');
 
$monthNum  = date('m');
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
$monthName = $dateObj->format('F'); // March



$tanggal = "$day $monthName $year"; 


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



$ambilstatustanggalibur = "SELECT * FROM mastertanggal 
   WHERE $bln = 'libur'";
   $queryambilstatustanggalibur =$conn->query($ambilstatustanggalibur);
  $jumlahlibur = count($arraytgl);

 //$statuslibur = $rowambilstatustanggalibur['id'];
   
 if($queryambilstatustanggalibur->num_rows){

$rowambilstatustanggalibur = mysqli_fetch_all($queryambilstatustanggalibur, MYSQLI_ASSOC);

$t = 0;
$daftartanggalibur[$t];
for ($x = 0; $x < count($rowambilstatustanggalibur); $x++) {
   $daftartanggalibur[$t] = $rowambilstatustanggalibur[$x]["id"]. "-" .$monthNum. "-".$year ;
   $t++;
}

 $jumlahlibur = count($rowambilstatustanggalibur);

 if($statuslibur == "libur"){
  //   $display = "display:none;";
     
 }else{
     
 }

 }else{
    // header("location: http://www.icg.id/beta/dar/login");
   echo " gak dapat libur ";
 }




 $ambilstatustanggaldar = "SELECT * FROM hdar 
   WHERE iduser = '".$iduser."' ORDER BY tanggaldar DESC;";
   $queryambilstatustanggaldar = $conn->query($ambilstatustanggaldar);
 if($queryambilstatustanggaldar->num_rows){
  
 $rowambilstatustanggaldar = mysqli_fetch_array($queryambilstatustanggaldar, MYSQLI_ASSOC);
 $statustanggaldar = $rowambilstatustanggaldar['tanggaldar'];

 }else{
    // header("location: http://www.icg.id/beta/dar/login");
    $arraytgl[0] = $datee;
 //  echo " gak dapat tanggaldar ";
 }
 

$ststgldar = new DateTime($statustanggaldar);
$ststgldar->modify('+1 day');
$tglterakhirdar = $ststgldar->format('Y-m-d'); 

 
$tanggal1 = new DateTime($tglterakhirdar);
$tanggal2 = new DateTime();
$tanggaldiff = date_diff($tanggal1,$tanggal2);
//$perbedaan = $tanggal2->diff($tanggal1)->format("%a");
$perbedaan = $tanggaldiff->format("%a%");
 
if ($arraytgl[0] == $dateee || $perbedaan == 0 || $datee == $statustanggaldar   ){
    
$displayselect = "display:none;";
$arraytgl[0] = $dateee;    
    
}else {
    
    
    
$displayselect = "";
$begin = new DateTime($tglterakhirdar);
$end = new DateTime('tomorrow');;

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

$z = 0;
$arraytgl[$z];
foreach ($period as $dt) {
  $arraytgl[$z] = $dt->format("d-m-Y");
    
    $z++;
  //  count($arraytgl);
    //unset($arrayku[2]);
}

}
   for($p = 0; $p <  sizeof($daftartanggalibur); $p++){
  for($x = 0; $x <  sizeof($arraytgl); $x++){
    //    $tmptgl = $arraytgl[$x];
    //     $tmptglibur = $daftartanggalibur[$p];
      if ($arraytgl[$x] == $daftartanggalibur[$p]){
        // unset($arraytgl[$x]);
       array_splice($arraytgl, $x, 1);
      }
  }

  }
  
$pecaht = explode("-", $arraytgl[0]);
$haridar = $pecaht[0];
$bulandar = $pecaht[1];
$tahundar = $pecaht[2];

$tgldar = $haridar.$bulandar.$tahundar;


//======================================================================

  $ambilnomerddar = "SELECT iddetdar FROM draftddar 
   WHERE iduser = '" .$iduser. "' ORDER BY urid DESC LIMIT 1 ;";
   $queryambilnomerddar =$conn->query($ambilnomerddar);
   
 if($queryambilnomerddar->num_rows){
   session_start();
 $rowambilnomerddar = mysqli_fetch_array($queryambilnomerddar, MYSQLI_ASSOC);
 $noddar = $rowambilnomerddar['iddetdar'];
 
 $pecahddar = explode("/", $noddar);
$hasilddar = $pecahddar[1] + 1;
$noddarnya = $tgldar."/".$hasilddar;

 }
 else{
    // header("location: http://www.icg.id/beta/dar/login");
    $satu = "1";
   //echo " gak dapat nomer ";
   $noddarnya = $tgldar."/".$satu;
 }

//========================================================================= 
/*
echo "<br>";
echo $noddarnya; 
echo "<br>";
echo $arraytgl[0]; 
echo "<br>";
echo $IUser; 
echo "<br>";
echo $target; 
echo "<br>";
echo $activity; 
echo "<br>";
echo $result;
echo "<br>";
echo $nodarnya;
echo "<br>";
*/

$query .= "INSERT INTO draftddar (nodar, idtodo, iddetdar, iduser, target, activity, result, date, duedate, explaination) VALUES ('".$nodarnya."', '".$idnya."', '".$noddarnya."','".$IUser."', '".$target."', '".$activity."', '".$result."', '".$date."', '".$duedate."','".$explaination."')";  
if ($conn->query($query) === TRUE) {
$updatetodo .= "UPDATE todo SET bisatambahdar='tidak' WHERE idtodo='".$idnya."' ";
$conn->query($updatetodo);
      echo '<script>
//	alert("Add to DAR successfully");
	window.location.assign("todo.php"); 
</script>' ;
  
} else {
    echo "Error Add to DAR: " . $conn->error;
}

?>