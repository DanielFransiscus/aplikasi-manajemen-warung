<?php
session_start();

include './function.php';




if (isset($_POST['id_barang'])) {
    $id_barang = $_POST['id_barang'];
    $qty = 1;

    //menampilkan data barang
    $data = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang='$id_barang'");
    $b = mysqli_fetch_assoc($data);

    $jumlah = $b['jumlah'];

    if($jumlah > 0){ 

    //cek diskon barang
        $disbarang = mysqli_query($conn, "SELECT * FROM disbarang WHERE id_barang=$id_barang");
        $disb = mysqli_fetch_assoc($disbarang);

    //cek jika di keranjang sudah ada barang yang masuk
        $key = array_search($b['id_barang'], array_column($_SESSION['cart'], 'id'));
    // return var_dump($key);

        if ($key !== false) {
        // return var_dump($_SESSION['cart']);

        //jika ada data yang sesuai di keranjang akan ditambahkan jumlah nya
            $c_qty = $_SESSION['cart'][$key]['qty'];
            $_SESSION['cart'][$key]['qty'] = $c_qty + 1;

        //cek jika ada potongan dan cek jumlah barang lebih besar sama dengan minimum order potongan
            if ($disb['qty'] && $_SESSION['cart'][$key]['qty'] == $disb['qty']) {

            //Simpan diskon dengan jumlah kelipatan dikali potongan barang
                $_SESSION['cart'][$key]['diskon'] = $disb['potongan'];
            }
        } else {
        // return var_dump($b);
        //Jika tidak ada yang sesuai akan menjadi barang baru dikeranjang
            $barang = [
                'id' => $b['id_barang'],
                'nama' => $b['nama'],
                'harga' => $b['harga_barang'],
                'qty' => $qty,
                'diskon' => 0,

            ];

            $_SESSION['cart'][] = $barang;

        //merubah urutan tampil pada keranjang
        // krsort($_SESSION['cart']);
        }

        header('Location: ' . BASEURL . '/kasir/kasir.php');
    }

    else{

        echo "<script>
        window.location = 'kasir.php';
        </script>";
        setFlash('gagal', 'ditambahkan', 'danger');
    }
}
?>