<?php 
include "../config.php";
session_start();

$ambilversion = "SELECT version FROM versionapp 
WHERE id = '1';";
$queryambilversion =$conn->query($ambilversion);
$rowambilversion = mysqli_fetch_array($queryambilversion, MYSQLI_ASSOC);
$version = $rowambilversion['version'];



?>
<form method="post" action="updateversion.php">
<input type="text" value="<?php echo $version?>" name="versionapp">
<button type="submit">update</button>
</form>