<?php

define('BASEURL', 'http://localhost/myapp');

$servername = "localhost";
$username = "root";
$password = "";
$database = "kasirdb";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

?>