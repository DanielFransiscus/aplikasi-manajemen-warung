<?php
require __DIR__ . '/function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'] ? $_POST['username'] : '';
  $sql = "SELECT COUNT(*) AS countUsr FROM users WHERE username = '$username'";
  $query = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($query);
  $count = $row['countUsr'];
  echo $count;
} else {
  header("HTTP/1.0 405 Method Not Allowed");
}
