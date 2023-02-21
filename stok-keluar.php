<?php
session_start();

require __DIR__ . '/function.php';

$barang = query("SELECT * FROM barang 
   
    
    INNER JOIN barang_keluar
    ON barang.id_barang = barang_keluar.id_barang
    order by barang.id_barang ASC
    ");


$barangs = query("SELECT * FROM  barang order by id_barang ASC");

$id_barang = $jumlah = $tgl_keluar = '';
if (isset($_POST["insert"])) {
  $id_barang = htmlspecialchars($_POST["id_barang"]);
  $jumlah = htmlspecialchars($_POST["jumlah"]);
  $tgl_keluar = htmlspecialchars(date("Y-m-d H:i:s"));
  if (!$id_barang) {
    header('Location: ' . BASEURL . '/stok-keluar');
    exit();
  }
  if (!$jumlah) {
    header('Location: ' . BASEURL . '/stok-keluar');
    exit();
  }
  if (!$tgl_keluar) {
    header('Location: ' . BASEURL . '/stok-keluar');
    exit();
  }
  if (tambahBarangkeluar($_POST) > 0) {
    setFlash('berhasil', 'ditambahkan', 'success');
    header('Location: ' . BASEURL . '/stok-keluar');
    exit;
  } else {
    setFlash('gagal', 'ditambahkan', 'danger');
    header('Location: ' . BASEURL . '/stok-keluar');
    exit;
  }
}

if (isset($_POST["delete"])) {
  //cek apakah data berhasil di tambahkan atau tidak
  if (hapusBarangkeluar($_POST) > 0) {
    setFlash('berhasil', 'dihapus', 'success');
    header('Location: ' . BASEURL . '/stok-keluar');
    exit;
  } else {
    setFlash('gagal', 'dihapus', 'danger');
    header('Location: ' . BASEURL . '/stok-keluar');
    exit;
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
  <title>Barang - Aplikasi POS</title>
  <link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>/assets/css/datatables.css">
  <link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>/assets/css/styles.css">



</head>

<body class="sb-nav-fixed">





  <!-- modal tambah - start -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Stok Produk</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="<?php echo BASEURL; ?>/stok-keluar" method="post">
          <!-- Modal body -->
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label" class="form-label" for="id_barang">Nama Produk</label>
              <select class="form-select" id="id_barang" name="id_barang" required>
                <option value="" option hidden disabled selected value>Pilih nama produk</option>
                <?php foreach ($barangs as $c) { ?>
                  <option value="<?php echo htmlentities($c['id_barang']); ?>">
                    <?php echo htmlentities($c['nama']); ?>
                  </option>
                <?php } ?>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label" class="form-label" for="jumlah">Jumlah</label>
              <input type="number" class="form-control" id="jumlah" placeholder="keluarkan jumlah barang" name="jumlah" min="1" required>
            </div>

          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" name="insert" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- modal tambah - end -->


  <?php include 'partials/top_nav.php'; ?>


  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <?php include 'partials/sidebar.php'; ?>
    </div>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">


          <div class="card mb-4 mt-4">
            <?php flash(); ?>
            <div class="card-header">
              <h1>Stok Keluar</h1>
            </div>
            <div class="card-body">

              <table id="datatablesSimple">
                <div class="clearfix">


                  <button type="button" class="btn btn-primary mb-4 float-end" data-bs-toggle="modal" data-bs-target="#myModal">
                    Tambah </button>
                </div>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1; ?>
                  <?php foreach ($barang as $b) { ?>
                    <tr>
                      <td>
                        <?php echo $i; ?>
                      </td>
                      <td>
                        <?php echo htmlentities($b['tgl_keluar']); ?>
                      </td>
                      <td>
                        <?php echo htmlentities($b['nama']); ?>
                      </td>
                      <td>
                        <?php echo htmlentities($b['jumlah']); ?>
                      </td>
                      <td>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?php echo htmlentities($b['id_barang']); ?>">Hapus</button>

                      </td>

                    </tr>
                    <?php $i++; ?>
                    <!-- modal delete -->
                    <div class="modal fade" id="delete<?php echo htmlentities($b["id_barang"]); ?>">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="<?php echo BASEURL; ?>/stok-keluar" method="post">
                            <div class="modal-body">
                              <p>Apakah anda yakin menghapus barang ini ?</p>
                              <input type="hidden" name="id_keluar" value="<?php echo htmlentities($b['id_keluar']); ?>">
                            </div>
                            <div class="modal-footer">
                              <button type="submit" name="delete" class="btn btn-danger">Hapus</button>
                              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </tbody>
              </table>
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