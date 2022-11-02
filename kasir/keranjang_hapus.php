<?php 
session_start();
include './function.php';




if (isset($_GET['id'])){

	$id = $_GET['id'];

	$cart = $_SESSION['cart'];
// print_r($cart);

//berfungsi untuk mengambil data secara spesifik
	$k = array_filter($cart,function ($var) use ($id){
		return ($var['id']==$id);
	});
	print_r($k);

	foreach ($k as $key => $value) {
		unset($_SESSION['cart'][$key]);
	}

//mengembalikan urutan data
	$_SESSION['cart'] = array_values($_SESSION['cart']);

	 header('Location: ' . BASEURL . '/kasir/kasir.php');


}
?>