<?php
include "../config.php";


$iduser = $_POST["iduser"];
$gambar = $_POST["gambar"];
//unlink($gambar);

// sql to delete a record
$sql = "DELETE FROM feedattach WHERE gambar='".$gambar."' AND iduser='".$iduser."' ";

if ($conn->query($sql) === TRUE) {
      echo '<script>
	alert("Record deleted successfully");
	window.location.assign("../dar.php"); 
</script>' ;
  
} else {
    echo "Error deleting record: " . $conn->error;
}

?>