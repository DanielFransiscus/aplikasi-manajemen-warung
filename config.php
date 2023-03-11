<?php
// error_reporting(0);
define('BASEURL', 'http://localhost/myapp');
date_default_timezone_set('Asia/Jakarta');
$s['kosong'] = [];
$errors = [];
$servername = "localhost";
$username = "root";
$password = "";
$database = "kasirdb";
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
  exit();
}
