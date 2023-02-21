<?php

session_start();

require __DIR__ . '/function.php';


if (isset($_POST['submit'])) {
  $date1 = htmlspecialchars($_POST['tgl_awal']);
  $date2 = htmlspecialchars($_POST['tgl_akhir']);
  $transaksi = query("SELECT * FROM transaksi

		inner join users ON transaksi.id_user=users.id_user
		inner join pelanggan ON transaksi.id_pelanggan=pelanggan.id_pelanggan
		WHERE DATE(tgl_wkt)
		BETWEEN  '$date1'  AND '$date2'
		ORDER BY DATE(tgl_wkt) ASC, id_transaksi ASC
		");
}

$date = date('d-m-Y');

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=" . "list-transaksi_" . "$date" . ".xls");

?>



<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Daftar Transaksi</title>
  <link rel="stylesheet" href="">
</head>
<style>
  table {
    width: 100%;
  }
</style>

<body>

  <br>

  <table border="1">
    <thead>
      <th align="left">No</th>
      <th align="left">ID Transaksi</th>
      <th align="left">Nama Petugas</th>
      <th align="left">Nama Pelanggan</th>
      <th align="left">Tanggal dan Waktu</th>
      <th align="left">Bayar</th>
      <th align="left">Total</th>
      <th align="left">Kembali</th>
      </tr>
    </thead>

    <tbody>
      <?php $i = 1; ?>
      <?php foreach ($transaksi as $b) { ?>
        <tr>
          <td align="left"><?php echo $i; ?></td>
          <td align="left"><?php echo htmlentities($b['id_transaksi']); ?></td>
          <td align="left"><?php echo htmlentities($b['username']); ?></td>
          <td align="left"><?php echo htmlentities($b['nama']); ?></td>
          <td align="left"><?php echo htmlentities($b['tgl_wkt']); ?></td>
          <td align="left"><?php echo htmlentities($b['bayar']); ?></td>
          <td align="left"><?php echo htmlentities($b['total']); ?></td>
          <td align="left"><?php echo htmlentities($b['kembali']); ?></td>
        </tr>
        <?php $i++; ?>

      <?php } ?>
    </tbody>
  </table>

</body>

</html>