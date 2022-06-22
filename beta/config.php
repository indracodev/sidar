<?php
$servername = "localhost";
$username = "u1313327_sidarverdua";
$password = "eyWsFTHC9^yV";
$database = "u1313327_sidarverdua";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?>