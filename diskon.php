<?php
session_start();

require __DIR__ . '/function.php';


$disbarang = query("SELECT * FROM disbarang inner join barang ON disbarang.id_barang=barang.id_barang 
	order by id_diskon ASC
	");
$barang = query('SELECT * FROM barang order by id_barang ASC');

$id_barang = $qty = $potongan = '';
if (isset($_POST["insert"])) {
  $id_barang = htmlspecialchars($_POST["id_barang"]);
  $qty = htmlspecialchars($_POST["qty"]);
  $potongan = htmlspecialchars($_POST["potongan"]);
  if (!$id_barang) {
    header('Location: ' . BASEURL . '/diskon');
    exit();
  }
  if (!$qty) {
    header('Location: ' . BASEURL . '/diskon');
    exit();
  }
  if (!$potongan) {
    header('Location: ' . BASEURL . '/diskon');
    exit();
  }
  if (tambahDisbarang($_POST) > 0) {
    setFlash('berhasil', 'ditambahkan', 'success');
    header('Location: ' . BASEURL . '/diskon');
    exit;
  } else {
    setFlash('gagal', 'ditambahkan', 'danger');
    header('Location: ' . BASEURL . '/diskon');
    exit;
  }
}

if (isset($_POST["update"])) {
  //cek apakah data berhasil di tambahkan atau tidak
  if (ubahDisbarang($_POST) > 0) {
    setFlash('berhasil', 'diubah', 'success');
    header('Location: ' . BASEURL . '/diskon');
    exit;
  } else {
    setFlash('gagal', 'diubah', 'danger');
    header('Location: ' . BASEURL . '/diskon');
    exit;
  }
}

if (isset($_POST["delete"])) {
  //cek apakah data berhasil di tambahkan atau tidak
  if (hapusDisbarang($_POST) > 0) {
    setFlash('berhasil', 'dihapus', 'success');
    header('Location: ' . BASEURL . '/diskon');
    exit;
  } else {
    setFlash('gagal', 'dihapus', 'danger');
    header('Location: ' . BASEURL . '/diskon');
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
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Diskon Barang - Aplikasi POS</title>
  <link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>/assets/css/datatables.css">
  <link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>/assets/css/styles.css">

</head>

<body class="sb-nav-fixed">


  <!-- modal tambah -start-->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Diskon Barang</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="<?php echo BASEURL; ?>/diskon" method="post">
          <!-- Modal body -->
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label" for="id_barang">Nama Barang</label>
              <select class="form-select" id="id_barang" name="id_barang" required>
                <option value="" option hidden disabled selected value>Pilih nama barang</option>
                <?php foreach ($barang as $b) { ?>
                  <option value="<?php echo htmlentities($b['id_barang']); ?>">
                    <?php echo htmlentities($b['nama']); ?>
                  </option>
                <?php } ?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label" for="qty">Jumlah Barang</label>
              <input type="number" class="form-control" id="qty" placeholder="Masukkan jumlah Barang" name="qty" min="1" required>
            </div>
            <div class="mb-3">
              <label class="form-label" for="potongan">Potongan Harga</label>
              <input type="number" class="form-control" id="potongan" placeholder="Masukkan potongan harga" name="potongan" min="1" required>
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
  <!-- modal tambah -end -->


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
              <h1>Diskon Produk</h1>
            </div>
            <div class="card-body">

              <table id="datatablesSimple">
                <div class="clearfix">

                  <button type="button" class="btn btn-primary mb-4 float-end" data-bs-toggle="modal" data-bs-target="#myModal">
                    Tambah
                  </button>

                </div>

                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jumlah </th>
                    <th>Potongan Harga</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1; ?>
                  <?php foreach ($disbarang as $d) { ?>
                    <tr>
                      <td>
                        <?php echo $i; ?>
                      </td>
                      <td>
                        <?php echo htmlentities($d['nama']); ?>
                      </td>
                      <td>
                        <?php echo htmlentities($d['qty']); ?>
                      </td>
                      <td>
                        <?php echo htmlentities($d['potongan']); ?>
                      </td>
                      <td>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#edit<?php echo htmlentities($d['id_diskon']); ?>">Ubah</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?php echo htmlentities($d['id_diskon']); ?>">Hapus</button>
                      </td>
                    </tr>
                    <?php $i++; ?>
                    <!-- model edit -->
                    <div class="modal fade" id="edit<?php echo htmlentities($d['id_diskon']); ?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <!-- Modal Header -->
                          <div class="modal-header">
                            <h4 class="modal-title">Simpan
                              <?php echo htmlentities($d['nama']); ?>
                            </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="<?php echo BASEURL; ?>/diskon" method="post">
                            <!-- Modal body -->
                            <div class="modal-body">
                              <div class="mb-3">
                                <input type="hidden" name="id_diskon" value="<?php echo htmlentities($d['id_diskon']); ?>">
                                <label class="form-label" for="nama">Nama Barang</label>
                                <select class="form-select" id="nama" name="id_barang" required>
                                  <?php foreach ($barang as $b) { ?>
                                    <option value="<?php echo htmlentities($b['id_barang']); ?>" <?php echo htmlentities(($d['nama'] == $b['nama'])) ? 'selected' : ''; ?>>
                                      <?php echo htmlentities($b['nama']); ?>
                                    </option>
                                  <?php } ?>
                                </select>
                              </div>
                              <div class="mb-3">
                                <label class="form-label" for="qty">Jumlah Barang</label>
                                <input type="number" class="form-control" id="qty" placeholder="Jumlah Barang" name="qty" value="<?php echo htmlentities($d['qty']); ?>" min="1" required>
                              </div>
                              <div class="mb-3">
                                <label class="form-label" for="potongan">Potongan</label>
                                <input type="number" class="form-control" id="potongan" placeholder="potongan" name="potongan" value="<?php echo htmlentities($d['potongan']); ?>" min="1" required>
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
                    <div class="modal fade" id="delete<?php echo htmlentities($d["id_diskon"]); ?>">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="<?php echo BASEURL; ?>/diskon" method="post">
                            <div class="modal-body">
                              <p>Apakah anda yakin menghapus potongan harga barang ini ?</p>
                              <input type="hidden" name="id_diskon" value="<?php echo htmlentities($d['id_diskon']); ?>">
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