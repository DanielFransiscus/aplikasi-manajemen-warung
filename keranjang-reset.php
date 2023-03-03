<?php
session_start();
require 'function.php';
if ($status == true && $id_role != 1 && $id_role != 2) {
  header('Location: ' . BASEURL . '/auth/login');
}


$_SESSION['cart'] = [];
header('Location: ' . BASEURL . '/penjualan');
