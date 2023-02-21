<?php

define('BASEURL', 'http://localhost/myapp');
define('REQUIRED_FIELD_ERROR', 'This field is required');
$errors = [];
$servername = "localhost";
$username = "root";
$password = "";
$database = "kasirdb";
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
