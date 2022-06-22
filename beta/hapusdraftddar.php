<?php
include "config.php";




$idnya = $_GET["idnya"];



// sql to delete a record
$sql = "DELETE FROM draftddar WHERE iddetdar='".$idnya."' ";

$sqlimage = "DELETE FROM draftattach WHERE iddetdar='".$idnya."' ";

if ($conn->query($sql) === TRUE) {

if ($conn->query($sqlimage) === TRUE) {
 
  
}    
    
      echo '<script>
	alert("Record deleted successfully");
	window.location.assign("newdar.php"); 
</script>' ;
  
} else {
    echo "Error deleting record: " . $conn->error;
}

?>