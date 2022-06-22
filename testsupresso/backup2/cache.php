<?php
include "auth.php";
$do = $_GET["do"];
$status = "failed";
$pesan = "";
$daJson = array();
if($do == "getimg"){
  include "config.php";
  $statusVal = "aktif";
  $pid = 0;
  $getProduct = $conn->query("SELECT * FROM masterproduk WHERE status = '".$statusVal."' ");
  while($fetchProduct = $getProduct->fetch_assoc()){
    $daJson[$pid]["gambar1"] = $fetchProduct["gambar1"];
    $daJson[$pid]["gambar2"] = $fetchProduct["gambar2"];
    $daJson[$pid]["gambar3"] = $fetchProduct["gambar3"];
    $daJson[$pid]["gambar4"] = $fetchProduct["gambar4"];
    $pid++;
  }
  $printJson = json_encode($daJson);
  echo $printJson;
  exit();
} else if($do == "address"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! security key not found";
  } else if(!isset($_POST["name"])){
    $pesan = "Error! name not found";
  } else if(!isset($_POST["email"])){
    $pesan = "Error! email not found";
  } else if(!isset($_POST["phone"])){
    $pesan = "Error! phone not found";
  } else if(!isset($_POST["address"])){
    $pesan = "Error! address not found";
  } else if(!isset($_POST["district"])){
    $pesan = "Error! district not found";
  } else if(!isset($_POST["city"])){
    $pesan = "Error! city not found";
  } else if(!isset($_POST["province"])){
    $pesan = "Error! province not found";
  } else if(!isset($_POST["country"])){
    $pesan = "Error! country not found";
  } else if(!isset($_POST["postal"])){
    $pesan = "Error! postal not found";
  } else {
    $hash       = $_POST["hash"];
    $name       = $_POST["name"];
    $email      = $_POST["email"];
    $phone      = $_POST["phone"];
    $address    = $_POST["address"];
    $district   = $_POST["district"];
    $city       = $_POST["city"];
    $province   = $_POST["province"];
    $country    = $_POST["country"];
    $postalcode = $_POST["postal"];
    if($hash == ""){
      $pesan = "Sorry! hash cannot be empty!";
    } else if($name == ""){
      $pesan = "Sorry! Name cannot be empty!";
    } else if($email == ""){
      $pesan = "Sorry! Email cannot be empty!";
    } else if($phone == ""){
      $pesan = "Sorry! Phone cannot be empty!";
    } else if($address == ""){
      $pesan = "Sorry! address cannot be empty!";
    } else if($district == ""){
      $pesan = "Sorry! district cannot be empty!";
    } else if($city == ""){
      $pesan = "Sorry! city cannot be empty!";
    } else if($province == ""){
      $pesan = "Sorry! province cannot be empty!";
    } else if($country == ""){
      $pesan = "Sorry! country cannot be empty!";
    } else if($postalcode == ""){
      $pesan = "Sorry! postal code cannot be empty!";
    } else {
      include "config.php";
      //hash checker
      $getHash = $conn->query("SELECT * FROM apihash WHERE apihash_hash = '".$hash."' ");
      $counHash = $getHash->num_rows;
      if($counHash != 1){
        $pesan = "Sorry! user not found";
      } else {
        $fetchHash = $getHash->fetch_assoc();
        $hashUsrID = $fetchHash["iduser"];
        if($hashUsrID == ""){
          //Guest
          $getHashAddress = $conn->query("SELECT * FROM apicacheaddr WHERE apihash_hash = '".$hash."' ");
          $countHashAddress = $getHashAddress->num_rows;
          if($countHashAddress != 1){
            //Write New Address
            $conn->query("INSERT INTO apicacheaddr VALUES(NULL, '".$hash."', '".$name."', '".$email."', '".$phone."', '".$address."', '".$district."', '".$city."', '".$province."', '".$country."', '".$postalcode."')");
            $daJson["member"] = "Guest";
            $daJson["cacheaddr"] = "No";
            $daJson["name"] = $name;
            $daJson["email"] = $email;
            $daJson["phone"] = $phone;
            $daJson["address"] = $address;
            $daJson["district"] = $district;
            $daJson["city"] = $city;
            $daJson["province"] = $province;
            $daJson["country"] = $country;
            $daJson["postal"] = $postalcode ;
            $status = "Success";
            $pesan = "Create new address";
          } else {
            //Get Existing Address
            $conn->query("UPDATE apicacheaddr SET
              apicacheaddr_name = '".$name."',
              apicacheaddr_email = '".$email."',
              apicacheaddr_phone = '".$phone."',
              apicacheaddr_address = '".$address."',
              apicacheaddr_district = '".$district."',
              apicacheaddr_city = '".$city."',
              apicacheaddr_province = '".$province."',
              apicacheaddr_country = '".$country."',
              apicacheaddr_postalcode = '".$postalcode."'
            WHERE apihash_hash = '".$hash."' ");
            $daJson["member"] = "Guest";
            $daJson["cacheaddr"] = "Updated";
            $daJson["name"] = $name;
            $daJson["email"] = $email;
            $daJson["phone"] = $phone;
            $daJson["address"] = $address;
            $daJson["district"] = $district;
            $daJson["city"] = $city;
            $daJson["province"] = $province;
            $daJson["country"] = $country;
            $daJson["postal"] = $postalcode ;
            $status = "Success";
            $pesan = "Update address";
          }
        } else {
          //Member
          $getMemberData = $conn->query("SELECT * FROM masterpelanggan WHERE iduser = '".$hashUsrID."' ");
          $fetchMemberData = $getMemberData->fetch_assoc();
          $memberFullname   = $fetchMemberData["fullname"];
          $memberEmail      = $fetchMemberData["email"];
          $memberPhone      = $fetchMemberData["notelp"];
          $memberAddress    = $fetchMemberData["alamat"];
          $memberDistrict   = $fetchMemberData["kecamatan"];
          $memberCity       = $fetchMemberData["kota"];
          $memberProvince   = $fetchMemberData["provinsi"];
          $memberCountry    = $fetchMemberData["negara"];
          $memberPostal     = $fetchMemberData["kodepos"];
          if($memberAddress != "" && $memberDistrict != "" && $memberCity != "" && $memberProvince != "" && $memberCountry != "" && $memberPostal != ""){
            //Data Complete
            $status = "Success";
            $pesan = "This user is a member, data complete. Getting existing data";
            $daJson["name"] = $memberFullname;
            $daJson["email"] = $memberEmail;
            $daJson["phone"] = $memberPhone;
            $daJson["member"] = "Member";
            $daJson["cacheaddr"] = "Existing data";
            $daJson["address"] = $memberAddress;
            $daJson["district"] = $memberDistrict;
            $daJson["city"] = $memberCity;
            $daJson["province"] = $memberProvince;
            $daJson["country"] = $memberCountry;
            $daJson["postal"] = $memberPostal;
          } else {
            //Data Incomplete
            $conn->query("UPDATE masterpelanggan SET
              alamat = '".$address."',
              kecamatan = '".$district."',
              kota = '".$city."',
              provinsi = '".$province."',
              negara = '".$country."',
              kodepos = '".$postalcode."'
            WHERE iduser = '".$hashUsrID."' ");

            $status = "Success";
            $pesan = "This user is a member, data incomplete. Use submited data";
            $daJson["name"] = $memberFullname;
            $daJson["email"] = $memberEmail;
            $daJson["phone"] = $memberPhone;
            $daJson["member"] = "Member";
            $daJson["cacheaddr"] = "Submited";
            $daJson["address"] = $address;
            $daJson["district"] = $district;
            $daJson["city"] = $city;
            $daJson["province"] = $province;
            $daJson["country"] = $country;
            $daJson["postal"] = $postalcode ;
          }
        }
      }
    }
  }
} else if($do == "guestaddress"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! no security key found";
  } else {
    $hash = $_POST["hash"];
    if($hash == ""){
      $pesan = "Sorry! security key cannot be empty!";
    } else {
      include "config.php";
      $getHashAddress = $conn->query("SELECT * FROM apicacheaddr WHERE apihash_hash = '".$hash."' ");
      $countHashAddress = $getHashAddress->num_rows;
      if($countHashAddress != 1){
        $pesan = "Sorry! No address data found";
      } else {
        $fetchHashAddress = $getHashAddress->fetch_assoc();
        $daJson["name"] = $fetchHashAddress["apicacheaddr_name"];
        $daJson["email"] = $fetchHashAddress["apicacheaddr_email"];
        $daJson["phone"] = $fetchHashAddress["apicacheaddr_phone"];
        $daJson["address"] = $fetchHashAddress["apicacheaddr_address"];
        $daJson["district"] = $fetchHashAddress["apicacheaddr_district"];
        $daJson["city"] = $fetchHashAddress["apicacheaddr_city"];
        $daJson["province"] = $fetchHashAddress["apicacheaddr_province"];
        $daJson["country"] = $fetchHashAddress["apicacheaddr_country"];
        $daJson["postal"] = $fetchHashAddress["apicacheaddr_postalcode"];
        $status = "Success";
        $pesan = "Data successfully loaded";
      }
    }
  }

} else {
  $pesan = "Sorry theres no action detected!";
}
$daJson["pesan"] = $pesan;
$daJson["status"] = $status;
$printJson = json_encode($daJson);
echo $printJson;
exit();
?>
