<?php
$servername = "localhost";
$username = "u1132260_patrol";
$password = "*wR4R205gWj=";
$db = "u1132260_patrol";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);
date_default_timezone_set("Asia/Jakarta");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

error_reporting(E_ERROR | E_PARSE);