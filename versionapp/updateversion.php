<?php 
include "../config.php";
session_start();

$versionya = $_POST['versionapp'];

$updatever .= "UPDATE versionapp SET version='".$versionya."' WHERE id='1' ";
    
if ($conn->query($updatever) === TRUE) {
echo '<script>
	alert("Berhasil Update Version");
	window.location.assign("index.php"); 
</script>' ;    

}



?>