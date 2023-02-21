<?php
session_start();
require __DIR__ . '/function.php';


if (isset($_POST['updt'])) {

  $qty = $_POST['qty'];
  $cart = $_SESSION['cart'];

  // print_r($qty);

  foreach ($cart as $key => $value) {
    $_SESSION['cart'][$key]['qty'] = $qty[$key];

    $idbarang = $_SESSION['cart'][$key]['id'];
    //cek diskon barang
    $disbarang = mysqli_query($conn, "SELECT * FROM disbarang WHERE id_barang='$idbarang'");
    $disb = mysqli_fetch_assoc($disbarang);

    //cek jika di keranjang sudah ada barang yang masuk
    $key = array_search($idbarang, array_column($_SESSION['cart'], 'id'));
    // return var_dump($key);
    if ($key !== false) {
      // return var_dump($_SESSION['cart']);

      //cek jika ada potongan dan cek jumlah barang lebih besar sama dengan minimum order potongan
      if ($disb['qty'] && $_SESSION['cart'][$key]['qty'] == $disb['qty']) {

        //Simpan diskon dengan jumlah kelipatan dikali potongan barang
        $_SESSION['cart'][$key]['diskon'] = $disb['potongan'];
      }
    }
  }

  header('Location: ' . BASEURL . '/penjualan');
}
