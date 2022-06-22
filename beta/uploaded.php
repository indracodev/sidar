<?php
include "config.php";
$iddetdar = $_POST['$iddetdar'];

if($_FILES["file"]["name"] != '')
{
 $file_name = $_FILES['file']['name'];    
 $test = explode('.', $_FILES["file"]["name"]);
 $ext = end($test);
 $name = rand(100, 999) . '.' . $ext;
 $location = 'images/' . $name;
 move_uploaded_file($_FILES["file"]["tmp_name"], $location);
 /*
 $queryupimg = "INSERT INTO masterattach (nodar, gambar, iduser) VALUE ('".$Nodar."', '".$filenamebaru."', '".$IUser."')"; 
 $sqlup = mysqli_query($conn, $queryupimg); 
 */
 
 echo '<div><a href="deletedraftattach.php?address='.$location.'" class="btn btn-light"> <strong>Delete</strong> </a>
        &nbsp; <a href="img/6/270520200816afb.PNG">'.$file_name.''.$iddetdar.'</a></div>';
 echo '<div><a href="deletedraftattach.php?address='.$location.'" class="btn btn-light"> <strong>Delete</strong> </a>
        &nbsp; <a href="img/6/270520200816afb.PNG">'.$iddetdar.'</a></div>';
 
}


?>