<?php
$servername = "localhost";
$username = "u1313327_sidar";
$password = "1#k18j)S%SI?";
$database = "u1313327_sidar";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?>