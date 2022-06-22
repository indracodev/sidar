<?php
session_start();
include "config.php";

$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;
$keuser2 = $_SESSION["Ke2"];
$keuser3 = $_SESSION["Ke3"];
$keuser4 = $_SESSION["Ke4"];
$keuser5 = $_SESSION["Ke5"];
$namaa = $_SESSION["NMUser"];

$body = $_POST["body"];
$title = $_POST["title"];
$action = $_POST["action"];

if ($namaa == "HRD IB"){

$infodar = "SELECT * FROM masteruser WHERE lokasikerja = 'ib' AND tokendevice != '-' AND perlunotif = 'iya' ";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);

} 

if ($namaa == "HRD IGI Pasuruan"){

$infodar = "SELECT * FROM masteruser WHERE lokasikerja = 'IGI Purwosari' AND tokendevice != '-' AND perlunotif = 'iya' ";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);

} 

if ($namaa == "HRD IGI Gresik"){

$infodar = "SELECT * FROM masteruser WHERE lokasikerja = 'IGI Bambe' AND tokendevice != '-' AND perlunotif = 'iya' ";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);

} 

if ($namaa == "HRD SDA"){

$infodar = "SELECT * FROM masteruser WHERE lokasikerja = 'sda' AND tokendevice != '-' AND perlunotif = 'iya' ";

$querydar = $conn->query($infodar);
$arrayrdar = mysqli_fetch_all($querydar, MYSQLI_ASSOC);
mysqli_close($conn);

} 

    
for($x = 0; $x < sizeof($arrayrdar); $x++){

$tokendevice = $arrayrdar[$x]["tokendevice"];     

$postfieldnya = '{
 "to" : "'.$tokendevice.'",
 "notification" : {
     "body" : "'.$body.'",
     "title": "'.$title.'",
     "priority" : "high"
 },
  "data" : {
     "actions" : "'.$action.'"
 }
}'  ;              

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
 "to" : "'.$tokendevice.'",
 "notification" : {
     "body" : "'.$body.'",
     "title": "'.$title.'",
     "priority" : "high"
 },
  "data" : {
     "actions" : "'.$action.'"
 }
}',
  CURLOPT_HTTPHEADER => array(
    'Authorization: key=AAAA-vMY0I4:APA91bGp9OSiEC0Tj2FsH5e0-4id7APAFvTXmONdpqIepx9aHG6IHgz_1Xcy0VJUmmhFJ3NCpiVhXljkztQMCRy_Uro3zNVkdRtly7lNdARC6OOG4QugBNZCN7LRYjjlvx28NWAGssDA',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

}

?>