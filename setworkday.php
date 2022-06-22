<?php
session_start();
include "config.php";
$lokasikerja = $_SESSION["Lokasikerja"] ;
$workday = $_POST['isiworkday'];

echo $workday;

$pecahtgl = explode(" ", $workday);

$tglhar = $pecahtgl[0];
$tglbulan = $pecahtgl[1];

switch ($tglbulan) {
    case 'January':
       $bln = "januari";
        break;
    case 'February':
        $bln = "februari";
        break;
    case 'March':
       $bln = "maret";
        break;
    case 'April':
       $bln = "april";
        break;
    case 'May':
      $bln = "mei";
        break;
    case 'June':
        $bln = "juni";
        break;
    case 'July':
      $bln = "juli";
        break;
    case 'August':
       $bln = "agustus";
        break;
    case 'September':
      $bln = "september";
        break;
    case 'October':
     $bln = "oktober";
        break;
    case 'November':
        $bln = "november";
        break;
    case 'December':
       $bln = "desember";
        break;
    default:
        echo "Your favorite color is neither red, blue, nor green!";
}

echo $bln;

if($lokasikerja == "ib"){
$mastgl = "mastertanggal1";    
    
}elseif($lokasikerja == "purwosari"){
$mastgl = "mastertanggal2";    

}elseif($lokasikerja == "IGI Bambe"){
$mastgl = "mastertanggal3";    
    
}elseif($lokasikerja == "sda"){
$mastgl = "mastertanggal4";    
    
}else{
$mastgl = "mastertanggal";
    
}
/*
$infouser = "SELECT * FROM masteruser WHERE id = '".$noidsr."' ";
$querydar = $conn->query($infouser);
$arrayuser = mysqli_fetch_array($querydar, MYSQLI_ASSOC);
$pw = $arrayuser['password'];
*/

$acceptworkday .= "UPDATE $mastgl SET $bln='' WHERE id='".$tglhar."' ";




if ($conn->query($acceptworkday) === TRUE) {
echo '<script>
	alert("Workday berhasil di set");
	window.location.assign("holidaysetting.php");
</script>' ;
} 
else{
   
    /*
  echo $IUser; 
  echo $KEuser;
  echo $status;
  echo $tanggal;
  echo $jam;
  echo $planning;
  echo $activity;
  echo $tags;
  echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database";
*/

echo '<script>
	alert("Workday gagal set");
	window.location.assign("holidaysetting.php");
</script>' ;


  }


?>