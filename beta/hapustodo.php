<?php
include "config.php";




$idnya = $_GET["idnya"];



// sql to delete a record
$sql = "DELETE FROM todo WHERE idtodo='".$idnya."' ";

if ($conn->query($sql) === TRUE) {
      echo '<script>
	alert("Record deleted successfully");
//	window.location.assign("dar.php"); 
</script>' ;
  
} else {
    echo "Error deleting record: " . $conn->error;
}

?>