<?php
include '../config.php';
$kodenegara = $_POST['state'];
$postcode = $_POST['postcode'];
$iduser = $_POST['iduser'];
$city = $_POST['city'];
$alamat = $_POST['alamat'];
$namanegara = $_POST['namanegara'];

if (!empty($kodenegara)){
$string = "SELECT * FROM draftcartuser
WHERE iduser = '" .$iduser. "'";
$query =$conn->query($string);

$ambilcart = 'SELECT * FROM draftcart WHERE iduser = "'.$iduser.'"';
$querycart = $conn->query($ambilcart);
$arraycart = mysqli_fetch_all($querycart, MYSQLI_ASSOC);

      for($x = 0; $x < sizeof($arraycart); $x++){
                  $jumlahberat = $jumlahberat + ($arraycart[$x]["berat"] * $arraycart[$x]["qty"]);

      }

if($query->num_rows){

$updatecart = "UPDATE draftcartuser SET negara='".$kodenegara."', namanegara='".$namanegara."', kodepos='".$postcode."' , kota='".$city."', jalan='".$alamat."' WHERE iduser='".$iduser."'";
$conn->query($updatecart);

}else{

  $insertusertcart = "INSERT INTO draftcartuser (iduser, negara, kodepos, kota, jalan, namanegara) VALUE ('".$iduser."', '".$kodenegara."', '".$postcode."', '".$city."', '".$alamat."', '".$namanegara."')";
//$queryinsertusercart =$conn->query($insertusertcart);
$perluinsert = '1';
if ($conn->query($insertusertcart) === TRUE) {
     echo '<script>
//	alert("berhasil insert draft");
//	window.location.assign("cart.php");
     </script>' ;
}else{
echo $iduser;
echo '<br>';
echo $id;
echo '<br>';
echo $namaproduk;
echo '<br>';
echo $shortdescription;
echo '<br>';
echo $gambar;
echo '<br>';
echo $harga;
echo '<br>';
echo $qty;
echo '<br>';
echo $diskon;
echo '<br>';
echo $subtotal;
echo '<br>';
echo $tanggal;
echo '<br>';
echo $jam;
echo '<br>';
echo $ip;

    echo '<script>
//	alert("Gagal insert draft");
     </script>' ;
}

}

if($jumlahberat > 1){
$volumtiga = 75;
}else{
$volumtiga = 30;
}

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.easyship.com/rate/v1/rates");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{
  \"origin_country_alpha2\": \"sg\",
  \"origin_postal_code\": \"238897\",
  \"destination_country_alpha2\": \"$kodenegara\",
  \"destination_postal_code\": \"$postcode\",
  \"taxes_duties_paid_by\": \"Sender\",
  \"is_insured\": false,
  \"items\": [
    {
      \"actual_weight\": $jumlahberat,
      \"sku\": \"test\",
      \"height\": 30,
      \"width\": 30,
      \"length\": $volumtiga,
      \"category\": \"Dry Food & Supplements\",
      \"declared_currency\": \"SGD\",
      \"declared_customs_value\": 10
    }
  ]
}");

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "Authorization: Bearer prod_bbzjPNveJC+gSLXI24f+oVEMMmyzO+LW2OWokIBqPhw="
));

$response = curl_exec($ch);
curl_close($ch);
//var_dump(json_decode($response, true));
$data = json_decode($response, true);
//echo '<br>';
//echo '<br>';
//echo count($data['rates']);
if(count($data['rates']) > 5){
    $ulang = 5;
}elseif(count($data['rates']) > 3){
    $ulang = 3;
}else{
    $ulang = count($data['rates']);
}

//for($x = 0; $x < count($data['rates']); $x++){
for($x = 0; $x < $ulang; $x++){

$harga = $data['rates'][$x]['total_charge'];

$ambilpriceid = 'SELECT * FROM shippingstripe WHERE harga = "'.$harga.'"';
$hasilpriceid = mysqli_query($conn, $ambilpriceid);
$rowresultpriceid = mysqli_fetch_array($hasilpriceid, MYSQLI_ASSOC);

$stimasi = $data['rates'][$x]['min_delivery_time'];
$estimasi = $data['rates'][$x]['max_delivery_time'];

$stimasi = $stimasi + 1;
$estimasi = $estimasi + 1;

if($stimasi == 1){
$har = " day";
}else{
$har = " days";
}

if($estimasi == 1){
$harr = " day";
}else{
$harr = " days";
}
$kurir = $data['rates'][$x]['courier_name'];
$hargashipnya = $data['rates'][$x]['total_charge'];
if($kurir == "Ninja Van - Express"){
$hargashipnya = $hargashipnya + 5;
}
if($kurir == "DHL eCommerce - Packet International" || $kurir == "DHL eCommerce - Packet Plus" || $kurir == "DHL eCommerce - Packet International Direct" || $kurir == "DHL eCommerce - Parcel Direct US"   ){
$hargashipnya = $hargashipnya + 4;
}

$idprice = $rowresultpriceid['priceidshipping'];

$kuririd = $data['rates'][$x]['courier_id'];
echo '<br>';

echo '<input type="radio" id="shipping'.$x.'" name="shipping" value="'.$hargashipnya.'/'.$idprice.'/'.$kurir.'/'.$kuririd.'" required>';
echo '<label for="shipping'.$x.'">&nbsp'. $data['rates'][$x]['courier_name'].' </label><br>';
if($data['rates'][$x]['max_delivery_time'] == '1'){
echo "Estimated Shipping: " . $stimasi . $har  ;
}else{
echo "Estimated Shipping: " . $stimasi . $har . " - " . $estimasi . $harr ;
}
echo '<br>';
echo "Price : " . "$".$hargashipnya;

echo '<br>';

/*
echo "Courier Name : " . $data['rates'][$x]['courier_name'];
echo '<br>';
echo "Estimate Shipping: " . $data['rates'][$x]['min_delivery_time'] . " day" . " - " . $data['rates'][$x]['max_delivery_time'] . " day" ;
echo '<br>';
echo "Price : " . "$".$data['rates'][$x]['total_charge'];
echo '<br>';
echo "Length : " .$data['rates'][$x]['box']['length'];
*/
}

}

else{

}
