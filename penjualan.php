<?php
session_start();
require __DIR__ . '/function.php';


$customers = mysqli_query($conn, 'SELECT * FROM pelanggan');
$sum = 0;
if (isset($_SESSION['cart'])) {
  foreach ($_SESSION['cart'] as $key => $value) {
    $sum += ($value['harga'] * $value['qty']) - $value['diskon'];
  }
} else {
  $_SESSION['cart'] = [];
}

$bayar = $total =  $id_user = $id_pelanggan = '';
// transaksi_act
if (isset($_POST['trx'])) {

  $ind_timezone = htmlspecialchars(date("Y-m-d H:i:s"));
  $bayar = htmlspecialchars($_POST['bayar']);
  $total = htmlspecialchars($_POST['total']);
  $namaku = htmlspecialchars($_SESSION['username']);
  $id_user = $_SESSION['id_user'];
  $id_pelanggan  = htmlspecialchars($_POST['id_pelanggan']);
  $kembali = $bayar - $total;
  if (!$bayar) {
    header('Location: ' . BASEURL . '/penjualan');
    exit();
  }
  if (!$total) {
    header('Location: ' . BASEURL . '/penjualan');
    exit();
  }

  if (!$id_pelanggan) {
    header('Location: ' . BASEURL . '/penjualan');
    exit();
  }


  foreach ($_SESSION['cart'] as $key => $value) {
    $id_barang = $value['id'];
    $nama = $value['nama'];
    $data = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang='$id_barang'");
    $b = mysqli_fetch_assoc($data);
    $stok = $b['stok'];
    $jumlah = $value['qty'];

    if ($stok <= 0 && $jumlah >= $stok) {
      echo '<script>alert("Stock tidak mencukupi");
      window.location=' . BASEURL . '/penjualan' . '</script>';
      die();
    }
  }

  if ($bayar < $total) {
    echo '<script>alert("Uang pelanggan tidak cukup");  window.history.back();</script>';
  } else {
    $sql = "INSERT INTO transaksi (id_transaksi, id_pelanggan, id_user, tgl_wkt, total, bayar, kembali) VALUES (NULL,'$id_pelanggan','$id_user', '$ind_timezone', '$total', '$bayar', '$kembali')";

    $ins = mysqli_query($conn, $sql);

    //mendapatkan id transaksi baru
    $id_transaksi = mysqli_insert_id($conn);

    foreach ($_SESSION['cart'] as $key => $value) {
      $id_barang = $value['id'];
      $harga = $value['harga'];
      $qty = $value['qty'];
      $tot = $harga * $qty;
      $disk = $value['diskon'];

      $data = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang='$id_barang'");
      $b = mysqli_fetch_assoc($data);
      $stok = $b['stok'];
      $jumlah = $value['qty'];
      $sisa = $stok - $jumlah;
      $sql2 = "INSERT INTO transaksi_detail (id_transaksi_detail, id_transaksi, id_barang, harga, qty, total, diskon) VALUES (NULL, '$id_transaksi', '$id_barang', '$harga', '$qty', '$tot', '$disk')";

      $insert = mysqli_query($conn, $sql2);

      if ($ins && $insert) {
        //update stok
        mysqli_query($conn, "UPDATE barang SET stok='$sisa' WHERE id_barang='$id_barang'");
        $_SESSION['cart'] = [];
        //redirect ke halaman transaksi selesai
        header("location:" . BASEURL . "/transaksi-selesai?idtrx=" . "$id_transaksi");
      } else {
        echo "Error : " . mysqli_error($conn);
      }
    }
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Aplikasi Aplikasi POS">
  <meta name="author" content="Daniel Fransiscus">
  <title>Kasir - Aplikasi POS</title>
  <link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>/assets/css/datatables.css">
  <link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>/assets/css/styles.css">


</head>

<body class="sb-nav-fixed">

  <?php include 'partials/top_nav.php'; ?>



  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <?php include 'partials/sidebar.php'; ?>
    </div>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">

          <div class="card mb-4 mt-4">
            <div class="card-header">
              <h1>Penjualan</h1>
            </div>
            <div class="card-body">
              <form method="post" action="<?php echo BASEURL; ?>/keranjang-act">
                <div class="mb-3">
                  <label class="form-label" for="id_barang">ID Barang</label>
                  <input type="text" name="id_barang" class="form-control" id="id_barang" placeholder="Masukkan ID Produk" autofocus>
                </div>
                <?php flash(); ?>
              </form>
              <form method="post" action="<?php echo BASEURL; ?>/keranjang-update">
                <table id="datatablesSimple">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Barang</th>
                      <th>Harga Barang</th>
                      <th>Jumlah Barang</th>
                      <th>Sub Total</th>
                      <th>Stock Saaat Ini</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($_SESSION['cart'])) { ?>
                      <?php $i = 1; ?>
                      <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                        <?php
                        $idbarang = $value['id'];
                        $data = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang='$idbarang'");
                        $b = mysqli_fetch_assoc($data);
                        $stock = $b['stok'];
                        ?>
                        <tr>
                          <td>
                            <?php echo $i; ?>
                          </td>
                          <td>
                            <?php echo htmlentities($value['nama']); ?>
                            <?php
                            $dsc = mysqli_query($conn, "SELECT * FROM disbarang WHERE id_barang='$idbarang'");
                            $e = mysqli_fetch_assoc($dsc);
                            ?>
                            <?php if ($value['diskon'] > 0 && $value['qty'] >= $e['qty']) { ?>
                              <br>
                              <span class="badge bg-primary">Diskon
                                <?php echo htmlentities(number_format($value['diskon'])); ?>
                              </span>
                            <?php } else { ?>
                            <?php } ?>
                          </td>
                          <td>
                            <?php echo htmlentities(number_format($value['harga'])); ?>
                          </td>
                          <td>
                            <input type="number" name="qty[<?php echo $key; ?>]" min="1" max="<?php echo $stock; ?>" value="<?php echo $value['qty']; ?>" class="form-control" id="stock" required>
                          </td>
                          <td>
                            <?php echo htmlentities(number_format(($value['qty'] * $value['harga']) - $value['diskon'])); ?>
                          </td>
                          <td>
                            <?php echo $stock; ?>
                          </td>
                          </td>
                          <td>


                            <a href="<?php echo BASEURL; ?>/keranjang-hapus?id=<?php echo $value['id']; ?>" class="btn btn-danger">
                              <i class="fa fa-times" aria-hidden="true"></i>
                            </a>
                          </td>
                        </tr>
                        <?php $i++; ?>
                      <?php } ?>
                    <?php } ?>
                  </tbody>
                </table>
                <button type="submit" name="updt" class="btn btn-success">Ubah</button>
                <a class="btn btn-danger" href="<?php echo BASEURL; ?>/keranjang-reset" role="button">Reset</a>
              </form>
            </div>
            <div class="row justify-content-end px-4">
              <div class="col-md-4 ">
                <form action="<?php echo BASEURL ?>/penjualan" method="post" novalidate>
                  <div class="mb-3">
                    <label class="form-label">Nama Pelanggan</label>
                    <select class="form-select" id="nama_pelanggan" name="id_pelanggan" required>
                      <option value="" option hidden disabled selected value>Pilih nama pelanggan</option>
                      <?php foreach ($customers as $b) { ?>
                        <option value="<?php echo $b['id_pelanggan']; ?>">
                          <?php echo $b['nama']; ?>
                        </option>
                      <?php } ?>

                    </select>
                    <div class="invalid-feedback">
                      <?php echo $errors['id_pelanggan'] ?? '' ?>
                    </div>

                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="total">Total</label>
                    <input type="text" id="total" class="form-control" value="<?php echo number_format($sum); ?>" disabled></input>
                    <input type="hidden" id="tot" name="total" value="<?php echo $sum; ?>" required>
                    <div class="invalid-feedback">
                      <?php echo $errors['total'] ?? '' ?>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="bayar">Bayar</label>
                    <input type="text" id="bayar" name="bayar" class="form-control" min="1" required>
                    <small class="text-danger" id="msg2"> </small>
                    <div class="invalid-feedback">
                      <?php echo $errors['bayar'] ?? '' ?>
                    </div>
                  </div>
                  <button type="submit" name="trx" class="btn btn-primary mb-3">Selesai</button>
                </form>
              </div>
            </div>
          </div>
      </main>

    </div>
  </div>

  <script src="<?php echo BASEURL; ?>/assets/js/jquery-3.4.1.js"></script>
  <script src="<?php echo BASEURL; ?>/assets/js/fontawesome.js"></script>
  <script src="<?php echo BASEURL; ?>/assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo BASEURL; ?>/assets/js/scripts.js"></script>
  <script src="<?php echo BASEURL; ?>/assets/js/datatables.js"></script>
  <script src="<?php echo BASEURL; ?>/assets/js/datatables-simple-demo.js"></script>

  <script>
    window.setTimeout(function() {
      $(".alert").fadeTo(300, 0).slideUp(500, function() {
        $(this).remove();
      });
    }, 2000);
  </script>

</body>
<?php ob_end_flush(); ?>

</html>