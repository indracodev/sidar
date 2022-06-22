<?php
$servername = "localhost";
$username = "u1313327_testsupresso";
$password = "v5Gh@h+Y&8}U";
$database = "u1313327_testsupresso";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
