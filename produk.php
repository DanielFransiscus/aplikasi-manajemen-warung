<?php
session_start();

require __DIR__ . '/function.php';

$barang = query("SELECT * FROM barang 
    INNER JOIN kategori_barang 
    ON barang.id_kategori = kategori_barang.id_kategori
    INNER JOIN satuan
    ON barang.id_satuan= satuan.id_satuan
    order by id_barang ASC
    ");


$categories = query("SELECT * FROM  kategori_barang order by id_kategori ASC");
$satuans = query("SELECT * FROM  satuan order by id_satuan ASC");

$barang2 = query("SELECT * FROM barang where stok < 1 order by id_barang ASC");

$nama = $id_kategori = $id_satuan = $harga = $jumlah = '';
if (isset($_POST["insert"])) {

  $nama = htmlspecialchars($_POST["nama"]);
  $id_kategori = htmlspecialchars($_POST["id_kategori"]);
  $id_satuan = htmlspecialchars($_POST["id_satuan"]);
  $harga = htmlspecialchars($_POST["harga"]);



  if (!$nama) {
    header('Location: ' . BASEURL . '/produk');
    exit();
  }
  if (!$id_kategori) {
    header('Location: ' . BASEURL . '/produk');
    exit();
  }
  if (!$id_satuan) {
    header('Location: ' . BASEURL . '/produk');
    exit();
  }
  if (!$harga) {
    header('Location: ' . BASEURL . '/produk');
    exit();
  }


  if (tambahBarang($_POST) > 0) {
    setFlash('berhasil', 'ditambahkan', 'success');
    header('Location: ' . BASEURL . '/produk');
    exit;
  } else {
    setFlash('gagal', 'ditambahkan', 'danger');
    header('Location: ' . BASEURL . '/produk');
    exit;
  }
}


if (isset($_POST["update"])) {
  //cek apakah data berhasil di tambahkan atau tidak
  if (ubahBarang($_POST) > 0) {
    setFlash('berhasil', 'diubah', 'success');
    header('Location: ' . BASEURL . '/produk');
    exit;
  } else {
    setFlash('gagal', 'diubah', 'danger');
    header('Location: ' . BASEURL . '/produk');
    exit;
  }
}

if (isset($_POST["delete"])) {
  //cek apakah data berhasil di tambahkan atau tidak
  if (hapusBarang($_POST) > 0) {
    setFlash('berhasil', 'dihapus', 'success');
    header('Location: ' . BASEURL . '/produk');
    exit;
  } else {
    setFlash('gagal', 'dihapus', 'danger');
    header('Location: ' . BASEURL . '/produk');
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
          <h4 class="modal-title">Tambah Produk</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="<?php echo BASEURL; ?>/produk" method="post">
          <!-- Modal body -->
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label" class="form-label" for="nama">Nama Barang</label>
              <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama Barang" name="nama" maxlength="25" required>
            </div>
            <div class="mb-3">
              <label class="form-label" class="form-label" for="id_kategori">Kategori Barang</label>
              <select class="form-select" id="id_kategori" name="id_kategori" required>
                <option value="" option hidden disabled selected value>Pilih kategori barang</option>
                <?php foreach ($categories as $c) { ?>
                  <option value="<?php echo htmlentities($c['id_kategori']); ?>">
                    <?php echo htmlentities($c['nama_kategori']); ?>
                  </option>
                <?php } ?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label" class="form-label" for="id_satuan">Satuan Produk</label>
              <select class="form-select" id="id_satuan" name="id_satuan" required>
                <option value="" option hidden disabled selected value>Pilih Satuan Produk</option>
                <?php foreach ($satuans as $c) { ?>
                  <option value="<?php echo htmlentities($c['id_satuan']); ?>">
                    <?php echo htmlentities($c['nama_satuan']); ?>
                  </option>
                <?php } ?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label" class="form-label" for="harga">Harga Barang</label>
              <input type="number" class="form-control" id="harga" placeholder="Masukkan Harga Barang" name="harga" min="1" required>
            </div>
            <div class="mb-3">
              <label class="form-label" class="form-label" for="jumlah">Jumlah Barang</label>
              <input type="number" class="form-control" id="jumlah" placeholder="Masukkan Jumlah Barang" name="jumlah" min="0" value="0" disabled required>
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
              <h1>Produk</h1>
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
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Satuan</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Qty</th>
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
                        <?php echo htmlentities($b['id_barang']); ?>
                      </td>
                      <td>
                        <?php echo htmlentities($b['nama']); ?>
                      </td>
                      <td>
                        <?php echo htmlentities($b['nama_satuan']); ?>
                      </td>
                      <td>
                        <?php echo htmlentities($b['nama_kategori']); ?>
                      </td>
                      <td>
                        <?php echo htmlentities($b['harga_barang']); ?>
                      </td>
                      <td>
                        <?php echo htmlentities($b['stok']); ?>
                      </td>
                      <td>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#edit<?php echo htmlentities($b['id_barang']); ?>">Ubah</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?php echo htmlentities($b['id_barang']); ?>">Hapus</button>
                      </td>
                    </tr>
                    <?php $i++; ?>

                    <!-- model edit -->
                    <div class="modal fade" id="edit<?php echo htmlentities($b['id_barang']); ?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <!-- Modal Header -->
                          <div class="modal-header">
                            <h4 class="modal-title">Simpan
                              <?php echo htmlentities($b['nama']); ?>
                            </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="<?php echo BASEURL; ?>/produk" method="post">
                            <!-- Modal body -->
                            <div class="modal-body">
                              <div class="mb-3">
                                <input type="hidden" name="id_barang" value="<?php echo htmlentities($b['id_barang']); ?>">
                                <label class="form-label" for="nama">Nama Barang</label>
                                <input type="text" class="form-control" id="nama" placeholder="Nama Barang" name="nama" value="<?php echo htmlentities($b['nama']); ?>" maxlength="25" required>
                              </div>
                              <div class="mb-3">
                                <label class="form-label" for="nama_kategori">Kategori barang</label>
                                <select class="form-select" id="nama_kategori" name="id_kategori" required>
                                  <option selected disabled>Pilih kategori barang</option>
                                  <?php foreach ($categories as $c) { ?>
                                    <option value="<?php echo htmlentities($c['id_kategori']); ?>" <?php echo htmlentities(($b['nama_kategori'] == $c['nama_kategori'])) ? 'selected' : ''; ?>>
                                      <?php echo htmlentities($c['nama_kategori']); ?>
                                    </option>
                                  <?php } ?>
                                </select>

                              </div>

                              <div class="mb-3">
                                <label class="form-label" for="nama_satuan">Satuan</label>
                                <select class="form-select" id="nama_satuan" name="id_satuan" required>
                                  <option selected disabled>Pilih Satuan</option>
                                  <?php foreach ($satuans as $c) { ?>
                                    <option value="<?php echo htmlentities($c['id_satuan']); ?>" <?php echo htmlentities(($b['nama_satuan'] == $c['nama_satuan'])) ? 'selected' : ''; ?>>
                                      <?php echo htmlentities($c['nama_satuan']); ?>
                                    </option>
                                  <?php } ?>
                                </select>

                              </div>
                              <div class="mb-3">
                                <label class="form-label" for="harga">Harga Barang</label>
                                <input type="number" class="form-control" id="harga" placeholder="Harga Barang" name="harga" value="<?php echo htmlentities($b['harga_barang']); ?>" min="1" required>
                              </div>
                              <div class="mb-3">
                                <label class="form-label" for="jumlah">Jumlah Barang</label>
                                <input type="number" class="form-control" id="jumlah" placeholder="Jumlah Barang" name="jumlah" value="<?php echo htmlentities($b['stok']); ?>" min="0" disabled required>
                              </div>
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                              <button type="submit" name="update" class="btn btn-success">Simpan</button>
                              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>



                    <!-- modal delete -->
                    <div class="modal fade" id="delete<?php echo htmlentities($b["id_barang"]); ?>">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="<?php echo BASEURL; ?>/produk" method="post">
                            <div class="modal-body">
                              <p>Apakah anda yakin menghapus barang ini ?</p>
                              <input type="hidden" name="id_barang" value="<?php echo htmlentities($b['id_barang']); ?>">
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