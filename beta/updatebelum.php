<?php
include "config.php";

 
 $updateuser .= "UPDATE masteruser SET sudahkirim='belum' ";


 

if ($conn->query($updateuser) === TRUE) {
echo 'sudah insert' ;
} 
else{
 echo 'tidak insert' ;
}
?>