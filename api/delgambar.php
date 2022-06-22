<?php
include "../config.php";

$address = $_GET["address"];
$pecah = explode("/", $address);
$hasiladdress = $pecah[2];

$iduser = $_POST["iduser"];
$gambar = $_POST["gambar"];
//unlink($gambar);

// sql to delete a record
$sql = "DELETE FROM masterattach WHERE gambar='".$gambar."' AND iduser='".$iduser."' ";

if ($conn->query($sql) === TRUE) {
      echo '<script>
	alert("Record deleted successfully");
	window.location.assign("../dar.php"); 
</script>' ;
  
} else {
    echo "Error deleting record: " . $conn->error;
}

?>