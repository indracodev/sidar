<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, PATCH, VIEW");
$servername = "localhost";
$username = "u1313327_guardpurwosari";
$password = "%nyxgyRymIDK";
$db = "u1313327_guardpurwosari";


// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);
date_default_timezone_set("Asia/Jakarta");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

error_reporting(E_ERROR | E_PARSE);
