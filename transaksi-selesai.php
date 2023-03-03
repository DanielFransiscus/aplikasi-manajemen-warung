<?php
session_start();
require __DIR__ . '/function.php';
if ($status == true && $id_role != 1 && $id_role != 2) {
  header('Location: ' . BASEURL . '/auth/login');
}

if (!isset($_GET['idtrx']) || $_GET['idtrx'] == "") {
  http_response_code(400);
  echo "<h1><center>idtrx is Required</center></h1>";
  exit();
} else {

  $id_trx = $_GET['idtrx'];
  if (is_numeric($id_trx)) {

    $data = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi='$id_trx'");
    $trx = mysqli_fetch_assoc($data);
    $detail = mysqli_query($conn, "SELECT * FROM transaksi_detail INNER JOIN barang ON transaksi_detail.id_barang = barang.id_barang WHERE transaksi_detail.id_transaksi = '$id_trx'");

    $p = "SELECT * FROM  profil where id = 1";
    $result = mysqli_query($conn, $p);
    $q = mysqli_fetch_assoc($result);



    if (!is_array($trx)) {
      http_response_code(404);
      include('404.php');
      exit();
    }
  } else {
    http_response_code(400);
    echo "<h1><center>idtrx isn't numeric</center></h1>";
    exit();
  }
}
?>


<!DOCTYPE html>
<html>

<head>
  <title>Kasir Selesai</title>
  <style type="text/css">
    body {
      color: #a7a7a7;
    }

    @media print {

      #printPageButton,
      #back {
        display: none;
      }
    }

    div {
      font-size: 19px;
    }
  </style>
</head>

<body>
  <button id="back" type="button" onclick="window.location.href='<?php echo BASEURL; ?>/laporan-penjualan'">Kembali</button>
  <button id="printPageButton" type="button" onclick="window.print();">Cetak</button>
  <div align="center">

    <header>
      <!-- /header -->
      <h3>Warung
        <?php echo htmlentities($q['nama_warung']); ?> <br>
        <?php echo htmlentities($q['alamat']); ?><br>
      </h3>
    </header>

    <table width="500" border="0" cellpadding="1" cellspacing="0">

      <tr align="center">
        <td>
          <hr>
        </td>
      </tr>

      <?php
      $idusr = $trx['id_user'];
      $sql = "SELECT * FROM users WHERE id_user= $idusr";
      $petugas = mysqli_query($conn, $sql);
      $ptg = mysqli_fetch_assoc($petugas);
      ?>

      <tr>
        <td>Tanggal dan Waktu :
          <?php echo htmlentities($trx['tgl_wkt']); ?>
        </td>
      </tr>
      <tr>
        <td>ID Transaksi :
          <?php echo htmlentities($trx['id_transaksi']); ?>
        </td>
      </tr>
      <tr>
        <td>Nama Petugas :
          <?php echo htmlentities($ptg['username']); ?>
        </td>
      </tr>
      <tr>
        <?php

        $id_pelanggan = $trx['id_pelanggan'];

        $cst = "SELECT * FROM pelanggan where id_pelanggan = $id_pelanggan";
        $p = mysqli_query($conn, $cst);
        $pg = mysqli_fetch_assoc($p);

        ?>
      <tr>
        <td>Nama Pelangggan :
          <?php echo htmlentities($pg['nama']); ?>
        </td>
      </tr>


      <td>
        <hr>
      </td>
      </tr>
    </table>
    <table width="500" border="0" cellpadding="3" cellspacing="0">
      <tr>
        <td valign="top" align="left">Nama</td>
        <td valign="top" align="left">Jumlah</td>
        <td valign="top" align="left">Harga</td>
        <td valign="top" align="right">Sub Total</td>
      </tr>
      <?php while ($row = mysqli_fetch_array($detail)) { ?>
        <tr>
          <td valign="top" align="left">
            <?php echo htmlentities($row['nama']); ?>
            <?php if ($row['diskon'] > 0) { ?>
              <br>
              <small align>Diskon</small>
            <?php } ?>
          </td>
          <td valign="top" align="left">
            <?php echo htmlentities($row['qty']); ?>
          </td>
          <td valign="top" align="left">
            <?php echo htmlentities("Rp " . number_format($row['harga_barang'], 2, ',', '.')); ?>
          </td>
          <td valign="top" align="right">
            <?php echo htmlentities("Rp " . number_format($row['total'], 2, ',', '.')); ?>
            <?php if ($row['diskon'] > 0) { ?>
              <br>
              <small>-
                <?php echo htmlentities("Rp " . number_format($row['diskon'], 2, ',', '.')); ?>
              </small>
            <?php } ?>
          </td>
        </tr>
      <?php } ?>
      <tr>
        <td colspan="4">
          <hr>
        </td>
      </tr>
      <tr>
        <td align="right" colspan="3">Total</td>
        <td align="right">
          <?php echo htmlentities("Rp " . number_format($trx['total'], 2, ',', '.')); ?>
        </td>
      </tr>
      <tr>
        <td align="right" colspan="3">Bayar</td>
        <td align="right">
          <?php echo htmlentities("Rp " . number_format($trx['bayar'], 2, ',', '.')); ?>
        </td>
      </tr>
      <tr>
        <td align="right" colspan="3">Kembali</td>
        <td align="right">
          <?php echo htmlentities("Rp " . number_format($trx['kembali'], 2, ',', '.')); ?>
        </td>
      </tr>
    </table>
    <br><br>
    <footer>
      <div>
        Terima Kasih Selamat Berbelanja
      </div>
      <div>
        Info dan Layanan Konsumen
      </div>
      <div>
        <?php echo htmlentities($q['kontak']); ?>
      </div>
    </footer>
  </div>

</body>

</html>