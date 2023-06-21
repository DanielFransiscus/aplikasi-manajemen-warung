<?php
session_start();
require 'function.php';
if ($status == true && $id_role != 1 && $id_role != 2) {
  header('Location: ' . BASEURL . '/auth/login');
}
if (isset($_POST["delete"])) {
  if (hapusTransaksi($_POST) > 0) {
    setFlash('berhasil', 'dihapus', 'success');
    header('Location: ' . BASEURL . '/laporan-penjualan');
    exit;
  } else {
    setFlash('gagal', 'dihapus', 'danger');
    header('Location: ' . BASEURL . '/laporan-penjualan');
    exit;
  }
}
$transaksi = query("SELECT * FROM transaksi
    inner join users ON transaksi.id_user=users.id_user
    inner join pelanggan ON transaksi.id_pelanggan=pelanggan.id_pelanggan
    ORDER BY id_transaksi ASC
    ");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Aplikasi  Kasir">
  <meta name="author" content="Daniel Fransiscus">
  <title>Laporan Penjualan</title>
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
      <div class="container-fluid px-4">
        <h1 class="mt-4">Laporan Penjualan</h1>
        <?php flash(); ?>
        <div class="card mb-4">
          <div class="card-header">
            <form action="<?php echo BASEURL; ?>/list-transaksi" method="post">
              <input placeholder="Masukkan tanggal awal" type="date" name="tgl_awal">
              <input placeholder="Masukkan tanggal akhir" type="date" name="tgl_akhir">
              <button type="submit" name="submit">Export</button>
            </form>
          </div>
          <div class="card-body">
            <table id="datatablesSimple">
              <thead>
                <tr>
                  <th>No</th>
                  <th>ID</th>
                  <th>Petugas</th>
                  <th>Pelanggan</th>
                  <th>Tanggal dan Waktu</th>
                  <th>Bayar</th>
                  <th>Total</th>
                  <th>Kembali</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                <?php foreach ($transaksi as $b) { ?>
                  <tr>
                    <td>
                      <?php echo $i; ?>
                    </td>
                    <td>
                      <?php echo htmlentities($b['id_transaksi']); ?>
                    </td>
                    <td>
                      <?php echo htmlentities($b['username']); ?>
                    </td>
                    <td>
                      <?php echo htmlentities($b['nama']); ?>
                    </td>
                    <td>
                      <?php echo htmlentities($b['tgl_wkt']); ?>
                    </td>

                    <td>
                      <?php echo htmlentities('Rp ' . number_format($b['bayar'], 2, ',', '.')); ?>
                    </td>
                    <td>
                      <?php echo htmlentities('Rp ' . number_format($b['total'], 2, ',', '.')); ?>
                    </td>
                    <td>
                      <?php echo htmlentities('Rp ' . number_format($b['kembali'], 2, ',', '.')); ?>
                    </td>


                    <td>
                      <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#delete<?php echo htmlentities($b['id_transaksi']); ?>">Hapus</button>
                      <a class="btn btn-secondary"
                        href="<?php echo BASEURL; ?>/transaksi-selesai?idtrx=<?php echo htmlentities($b['id_transaksi']); ?>">Lihat</a>
                    </td>
                  </tr>
                  <?php $i++; ?>
                  <div class="modal fade" id="delete<?php echo htmlentities($b["id_transaksi"]); ?>">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Hapus</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?php echo BASEURL; ?>/laporan-penjualan" method="post">
                          <div class="modal-body">
                            <p>Apakah anda yakin menghapus transaksi ini ?</p>
                            <input type="hidden" name="id_transaksi"
                              value="<?php echo htmlentities($b['id_transaksi']); ?>">
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="delete" class="btn btn-danger">Hapus</button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="<?php echo BASEURL; ?>/assets/js/jquery-3.4.1.js"></script>
  <script src="<?php echo BASEURL; ?>/assets/js/fontawesome.js"></script>
  <script src="<?php echo BASEURL; ?>/assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo BASEURL; ?>/assets/js/scripts.js"></script>
  <script src="<?php echo BASEURL; ?>/assets/js/datatables.js"></script>
  <script src="<?php echo BASEURL; ?>/assets/js/datatables-simple-demo.js"></script>
  <script>
    window.setTimeout(function () {
      $(".alert").fadeTo(300, 0).slideUp(500, function () {
        $(this).remove();
      });
    }, 2000);
  </script>
</body>
<?php ob_end_flush(); ?>

</html>