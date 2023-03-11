<?php
session_start();
require '../function.php';
if ($status == true && $id_role != 1) {
  header('Location: ' . BASEURL . '/auth/login');
}
$barang = query("SELECT * FROM barang  
    INNER JOIN barang_keluar
    ON barang.id_barang = barang_keluar.id_barang
    order by barang.id_barang ASC
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
  <title>Stok Keluar</title>
  <link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>/assets/css/datatables.css">
  <link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>/assets/css/styles.css">
</head>

<body class="sb-nav-fixed">
  <?php include '../partials/top_nav.php'; ?>
  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <?php include '../partials/sidebar.php'; ?>
    </div>
    <div id="layoutSidenav_content">
      <div class="container-fluid px-4">
        <div class="card mb-4 mt-4">
          <?php flash(); ?>
          <div class="card-header">
            <h1>Stok Keluar</h1>
          </div>
          <div class="card-body">
            <table id="datatablesSimple">
              <div class="clearfix">
                <a class="btn btn-primary mb-4 float-end" href="<?php echo BASEURL; ?>/stok-keluar/tambah" role="button">Tambah</a>
              </div>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Barang</th>
                  <th>Jumlah</th>
                  <th>Tanggal & Waktu</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                <?php foreach ($barang as $c) { ?>
                  <tr>
                    <td>
                      <?php echo $i; ?>
                    </td>
                    <td>
                      <?php echo htmlentities($c['nama']); ?>
                    </td>
                    <td>
                      <?php echo htmlentities($c['jumlah']); ?>
                    </td>
                    <td>
                      <?php echo htmlentities($c['tgl_keluar']); ?>
                    </td>
                    <td>
                      <a class="btn btn-danger" href="<?php echo BASEURL; ?>/stok-keluar/hapus?id=<?php echo $c['id_keluar'] ?>" onclick="return confirm('Apakah anda yakin menghapus data ini ?')">Hapus</a>
                    </td>
                  </tr>
                  <?php $i++; ?>
                <?php } ?>
              </tbody>
            </table>
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
      window.setTimeout(function() {
        $(".alert").fadeTo(300, 0).slideUp(500, function() {
          $(this).remove();
        });
      }, 2000);
    </script>
</body>
<?php ob_end_flush(); ?>

</html>