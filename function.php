<?php
ob_start();

require 'config.php';

$status = $_SESSION['login'];
$id_user = $_SESSION["id_user"];
$username = $_SESSION["username"];
$id_role = $_SESSION['id_role'];
$role = $_SESSION['role'];

if (empty($status) && empty($id_user) && empty($username) && empty($id_role) && empty($role)) {
  header('Location: ' . BASEURL . '/auth/login');
}

if ($status == true && $id_role != 1 && $id_role != 2) {
  header('Location: ' . BASEURL . '/auth/login');
}



function query($query)
{
  global $conn;
  $result = mysqli_query($conn, $query);
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}


function hapusTransaksi($data)
{
  global $conn;
  $id = htmlspecialchars($data["id_transaksi"]);
  return mysqli_query($conn, "DELETE FROM transaksi WHERE id_transaksi = $id");
}

function setFlash($pesan, $aksi, $tipe)
{
  $_SESSION['flash'] = [
    'pesan' => $pesan,
    'aksi' => $aksi,
    'tipe' => $tipe
  ];
}

function flash()
{
  if (isset($_SESSION['flash'])) {
    echo '<div class="alert alert-' . $_SESSION['flash']['tipe'] . ' alert-dismissible fade show" role="alert">
		Data ' . $_SESSION['flash']['pesan'] . ' ' . $_SESSION['flash']['aksi'] . '
		</div>';
    unset($_SESSION['flash']);
  }
}
