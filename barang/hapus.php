<?php
session_start();
require  '../function.php';
if ($status == true && $id_role != 1) {
  header('Location: ' . BASEURL . '/auth/login');
}
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  if (!is_numeric($id)) {
    http_response_code(404);
    include('../404.php');
    exit();
  }
  $query = "SELECT * FROM  barang where id_barang = $id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 0) {
    http_response_code(404);
    include('../404.php');
    exit();
  }
  $row = mysqli_fetch_assoc($result);
} else {
  http_response_code(400);
  echo "<h1><center>Id is required</center></h1>";
  exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $sql = "DELETE FROM barang WHERE id_barang = $id";
  if (mysqli_query($conn, $sql)) {
    setFlash('berhasil', 'dihapus', 'success');
    header('Location: ' . BASEURL . '/barang');
    exit();
  } else {
    setFlash('gagal', 'dihapus', 'danger');
    header('Location: ' . BASEURL . '/barang');
    exit();
  }
}
