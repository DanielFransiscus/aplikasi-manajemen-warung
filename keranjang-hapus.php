<?php
session_start();
require 'function.php';
if ($status == true && $id_role != 1 && $id_role != 2) {
  header('Location: ' . BASEURL . '/auth/login');
}
if (isset($_GET['id'])) {

  $id = htmlspecialchars($_GET['id']);

  $cart = $_SESSION['cart'];
  // print_r($cart);

  //berfungsi untuk mengambil data secara spesifik
  $k = array_filter($cart, function ($var) use ($id) {
    return ($var['id'] == $id);
  });
  print_r($k);

  foreach ($k as $key => $value) {
    unset($_SESSION['cart'][$key]);
  }

  //mengembalikan urutan data
  $_SESSION['cart'] = array_values($_SESSION['cart']);

  header('Location: ' . BASEURL . '/penjualan');
}
