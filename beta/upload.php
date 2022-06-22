<?php
include "config.php";
$iddetdar = $_POST['iddetdar'];
$idusr = $_POST['idusr'];

if($_FILES["file"]["name"] != '')
{
 $file_name = $_FILES['file']['name'];    
 $test = explode('.', $_FILES["file"]["name"]);
 $ext = end($test);
 $name = rand(100, 999) . '.' . $ext;
 $filenamebaru = date('dmYHi').$file_name;
 $location = "img/".$idusr."/".$filenamebaru;

 
 
 move_uploaded_file($_FILES["file"]["tmp_name"], $location);
 $queryupimg = "INSERT INTO draftattach (iddetdar, img, iduser) VALUE ('".$iddetdar."', '".$filenamebaru."', '".$idusr."')"; 
 $sqlup = mysqli_query($conn, $queryupimg);  
 
 

 
}

$ambilattach = "SELECT * FROM draftattach WHERE iddetdar = '" .$iddetdar . "';";
$queryattach =$conn->query($ambilattach);
$arrayrattach = mysqli_fetch_all($queryattach, MYSQLI_ASSOC);

           
for($x = 0; $x < sizeof($arrayrattach); $x++){
           
           echo '<div><a href="deletedraftimg.php?address='.$location.'" class="btn btn-light"> <strong>Delete</strong> </a>
        &nbsp; <a href="'.$location.'">'.$filenamebaru.'</a></div>';
                          
}  

?>