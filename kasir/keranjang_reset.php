<?php
session_start();
include './function.php';



$_SESSION['cart'] = [];
header('Location: ' . BASEURL . '/kasir/kasir.php');


?>