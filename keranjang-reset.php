<?php
session_start();
require __DIR__ . '/function.php';



$_SESSION['cart'] = [];
header('Location: ' . BASEURL . '/penjualan');
