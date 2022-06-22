<?php
include "config.php";




$address = $_GET["address"];
$pecah = explode("/", $address);
$hasiladdress = $pecah[2];

unlink($address);

// sql to delete a record
$sql = "DELETE FROM draftattach WHERE img='".$hasiladdress."' ";

if ($conn->query($sql) === TRUE) {
      echo '<script>
	alert("Record deleted successfully");
	window.location.assign("newdar.php"); 
</script>' ;
  
} else {
    echo "Error deleting record: " . $conn->error;
}

?>