<?php
session_start();
require __DIR__ . '/function.php';




$customers = query("SELECT * FROM pelanggan order by id_pelanggan ASC");

$nama = '';
$kontak = '';
$alamat = '';


if (isset($_POST["insert"])) {
  $nama = htmlspecialchars($_POST['nama']);
  $kontak = htmlspecialchars($_POST['kontak']);
  $alamat = htmlspecialchars($_POST['alamat']);


  if (!$nama) {
    header('Location: ' . BASEURL . '/pelanggan');
    exit();
  }
  if (!$kontak) {
    header('Location: ' . BASEURL . '/pelanggan');
    exit();
  }
  if (!$alamat) {
    header('Location: ' . BASEURL . '/pelanggan');
    exit();
  }


  if (tambahPelanggan($_POST) > 0) {
    setFlash('berhasil', 'ditambahkan', 'success');
    header('Location: ' . BASEURL . '/pelanggan');
    exit();
  } else {
    setFlash('gagal', 'ditambahkan', 'danger');
    header('Location: ' . BASEURL . '/pelanggan');
    exit();
  }
}

if (isset($_POST["update"])) {
  //cek apakah data berhasil di tambahkan atau tidak
  if (ubahPelanggan($_POST) > 0) {
    setFlash('berhasil', 'diubah', 'success');
    header('Location: ' . BASEURL . '/pelanggan');
    exit();
  } else {
    setFlash('gagal', 'diubah', 'danger');
    header('Location: ' . BASEURL . '/pelanggan');
    exit();
  }
}

if (isset($_POST["delete"])) {
  //cek apakah data berhasil di tambahkan atau tidak
  if (hapusPelanggan($_POST) > 0) {
    setFlash('berhasil', 'dihapus', 'success');
    header('Location: ' . BASEURL . '/pelanggan');
    exit();
  } else {
    setFlash('gagal', 'dihapus', 'danger');
    header('Location: ' . BASEURL . '/pelanggan');
    exit();
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
  <title>Pelanggan - Aplikasi POS</title>
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
          <h4 class="modal-title">Tambah Pelanggan</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="<?php echo BASEURL; ?>/pelanggan" method="post">
          <!-- Modal body -->
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label" class="form-label" class="form-label" for="nama">Nama
                Pelanggan</label>
              <input type="text" class="form-control" id="nama" placeholder="Masukkan nama" name="nama" maxlength="25" required>
            </div>
            <div class="mb-3">
              <label class="form-label" class="form-label" class="form-label" for="kontak">Kontak
                Pelanggan</label>
              <input type="tel" class="form-control" id="kontak" placeholder="Masukkan kontak" name="kontak" maxlength="12" required>
            </div>
            <div class="mb-3">
              <label class="form-label" class="form-label" class="form-label" for="alamat">Alamat
                Pelanggan</label>
              <textarea class="form-control" id="alamat" name="alamat" maxlength="75" placeholder="Masukkan alamat" rows="3" required></textarea>
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
              <h1>Pelanggan</h1>
            </div>
            <div class="card-body">
              <ul>
                <?php if (!empty($_SESSION['errors']) && is_array($_SESSION['errors'])) { ?>

                  <?php echo "<li>" . $_SESSION['errors']['nama'] . "</li>"; ?>
                  <?php echo "<li>" . $_SESSION['errors']['kontak'] . "</li>"; ?>
                  <?php echo "<li>" . $_SESSION['errors']['alamat'] . "</li>"; ?>

                <?php } ?>

              </ul>

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
                    <th>Kontak </th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1; ?>
                  <?php foreach ($customers as $b) { ?>
                    <tr>
                      <td>
                        <?php echo $i; ?>
                      </td>
                      <td>
                        <?php echo htmlentities($b['nama']); ?>
                      </td>
                      <td>
                        <?php echo htmlentities($b['kontak']); ?>
                      </td>
                      <td>
                        <?php echo htmlentities($b['alamat']); ?>
                      </td>
                      <td>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#edit<?php echo htmlentities($b['id_pelanggan']); ?>">Ubah</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?php echo htmlentities($b['id_pelanggan']); ?>">Hapus</button>
                      </td>
                    </tr>
                    <?php $i++; ?>
                    <!-- model edit -->
                    <div class="modal fade" id="edit<?php echo htmlentities($b['id_pelanggan']); ?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <!-- Modal Header -->
                          <div class="modal-header">
                            <h4 class="modal-title">Simpan
                              <?php echo htmlentities($b['nama']); ?>
                            </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="<?php echo BASEURL; ?>/pelanggan" method="post">
                            <!-- Modal body -->
                            <div class="modal-body">
                              <div class="mb-3">
                                <input type="hidden" name="id_pelanggan" value="<?php echo htmlentities($b['id_pelanggan']); ?>">
                                <label class="form-label" class="form-label" class="form-label" for="nama">Nama
                                  Pelanggan</label>
                                <input type="text" class="form-control" id="nama" placeholder="Masukkan nama " name="nama" value="<?php echo htmlentities($b['nama']); ?>" maxlength="25" required>

                              </div>
                              <div class="mb-3">
                                <label class="form-label" class="form-label" class="form-label" for="kontak">Kontak
                                  Pelanggan</label>
                                <input type="tel" class="form-control" id="kontak" placeholder="Masukkan kontak" name="kontak" value="<?php echo htmlentities($b['kontak']); ?>" maxlength="12" required>

                              </div>

                              <div class="mb-3">
                                <label class="form-label" class="form-label" class="form-label" for="alamat">Alamat
                                  Pelanggan</label>
                                <textarea class="form-control" id="alamat" name="alamat" maxlength="96" placeholder="Masukkan alamat" rows="3" required><?php echo htmlentities($b['alamat']); ?> </textarea>

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
                    <div class="modal fade" id="delete<?php echo htmlentities($b["id_pelanggan"]); ?>">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="<?php echo BASEURL; ?>/pelanggan" method="post">
                            <div class="modal-body">
                              <p>Apakah anda yakin menghapus pelanggan ini ?</p>
                              <input type="hidden" name="id_pelanggan" value="<?php echo htmlentities($b['id_pelanggan']); ?>">
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
    setTimeout(function() {
      $(".alert").fadeTo(300, 0).slideUp(500, function() {
        $(this).remove();
      });
    }, 2000);
  </script>



</body>
<?php ob_end_flush(); ?>

</html>