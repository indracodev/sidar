<?php
include "auth.php";
$do = $_GET["do"];
$status = "failed";
$pesan = "";
$daJson = array();

if($do == "get"){
  include "config.php";
  if(isset($_POST["input"])){
    $input = $_POST["input"];
    if($input != ""){
      $pid = 0;
      $getCountries = $conn->query("SELECT * FROM countries WHERE name LIKE '".$input."%' ");
      while($fetchCountries = $getCountries->fetch_assoc()){
        $daJson[$pid]["id"] = $fetchCountries["id"];
        $daJson[$pid]["country"] = $fetchCountries["name"];
        $daJson[$pid]["alpha"] = $fetchCountries["alpha_2"];
        $pid++;
      }
      $status = "Success";
      $printJson = json_encode($daJson);
      echo $printJson;
      exit();
    } else {
      $pid = 0;
      $getCountries = $conn->query("SELECT * FROM countries");
      while($fetchCountries = $getCountries->fetch_assoc()){
        $daJson[$pid]["id"] = $fetchCountries["id"];
        $daJson[$pid]["country"] = $fetchCountries["name"];
        $daJson[$pid]["alpha"] = $fetchCountries["alpha_2"];
        $pid++;
      }
    }
    $status = "Success";
    $printJson = json_encode($daJson);
    echo $printJson;
    exit();
  } else {
    $pid = 0;
    $getCountries = $conn->query("SELECT * FROM countries");
    while($fetchCountries = $getCountries->fetch_assoc()){
      $daJson[$pid]["id"] = $fetchCountries["id"];
      $daJson[$pid]["country"] = $fetchCountries["name"];
      $daJson[$pid]["alpha"] = $fetchCountries["alpha_2"];
      $pid++;
    }
    $status = "Success";
    $printJson = json_encode($daJson);
    echo $printJson;
    exit();
  }
} else if($do == "origin"){
  if(!isset($_POST["input"])){
    $pesan = "Error! input not found";
  } else {
    $input = $_POST["input"];
    if($input == ""){
      $pesan = "Sorry! input cannot be empty";
    } else {
      include "config.php";
      $getCountry = $conn->query("SELECT name FROM countries WHERE alpha_2 = '".$input."' ");
      $countCountry = $getCountry->num_rows;
      if($countCountry != 1){
        $pesan = "Sorry! country not found";
      } else {
        $fetchCountry = $getCountry->fetch_assoc();
        $countryName = $fetchCountry["name"];
        $daJson["country"] = $countryName;
        $status = "Success";
        $pesan = "Country detected";
      }
    }
  }

} else {
  $pesan = "Error! no action detected";
}

$daJson["message"] = $pesan;
$daJson["status"] = $status;
$printJson = json_encode($daJson);
echo $printJson;
exit();
?>
