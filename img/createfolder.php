<?php

include "../config.php";

 $ambilidtterakhir = "SELECT * FROM masteruser ORDER BY id DESC;";
   
   $queryambilidterakhir = $conn->query($ambilidtterakhir);
   
 $rowambilidterakhir = mysqli_fetch_array($queryambilidterakhir, MYSQLI_ASSOC);
 $idterakhir = $rowambilidterakhir['id'];
 


$file_path = $idterakhir + 1;


if (!file_exists($file_path)) {
    mkdir($file_path);
    echo '<script>
	alert(" User Berhasil Ditambah ");
	window.location.assign("../addUser.php");
</script>' ;

}else{
    
    echo '<script>
	alert(" User Berhasil Ditambah ");
	window.location.assign("../addUser.php");
</script>' ;
    
    
}

?>