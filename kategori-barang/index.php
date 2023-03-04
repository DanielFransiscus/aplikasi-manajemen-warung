<?php
session_start();

require '../function.php';
if ($status == true && $id_role != 1) {
  header('Location: ' . BASEURL . '/auth/login');
}

$categories = query("SELECT * FROM  kategori_barang order by id_kategori ASC");



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Aplikasi  Kasir">
  <meta name="author" content="Daniel Fransiscus">
  <title>Kategori Barang - Kasir</title>
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
      <main>
        <div class="container-fluid px-4">
          <div class="card mb-4 mt-4">
            <?php flash(); ?>
            <div class="card-header">
              <h1>Kategori Barang</h1>
            </div>
            <div class="card-body">

              <table id="datatablesSimple">
                <div class="clearfix">


                  <a class="btn btn-primary mb-4 float-end" href="<?php echo BASEURL; ?>/kategori-barang/tambah" role="button">Tambah</a>

                </div>

                <thead>
                  <tr>
                    <th>No</th>

                    <th>Kategori</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1; ?>
                  <?php foreach ($categories as $c) { ?>
                    <tr>
                      <td>
                        <?php echo $i; ?>
                      </td>

                      <td>
                        <?php echo htmlentities($c['nama_kategori']); ?>
                      </td>
                      <td>


                        <a class="btn btn-success" href="<?php echo BASEURL; ?>/kategori-barang/ubah?id=<?php echo $c['id_kategori'] ?>">Ubah</a>
                        <a class="btn btn-danger" href="<?php echo BASEURL; ?>/kategori-barang/hapus?id=<?php echo $c['id_kategori'] ?>" onclick="return confirm('Apakah anda yakin menghapus data ini ?')">Hapus</a>

                      </td>
                    </tr>
                    <?php $i++; ?>
                    <!-- model edit -->
                    <div class="modal fade" id="edit<?php echo $c['id_kategori']; ?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <!-- Modal Header -->
                          <div class="modal-header">
                            <h4 class="modal-title">Simpan
                              <?php echo $c['nama_kategori']; ?>
                            </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="<?php echo BASEURL; ?>/kategori-barang" method="post">
                            <!-- Modal body -->
                            <div class="modal-body">
                              <div class="mb-3">
                                <input type="hidden" name="id_kategori" value="<?php echo $c['id_kategori']; ?>">
                                <label class="form-label" for="nama_kategori">Nama Kategori</label>
                                <input type="text" class="form-control" id="nama_kategori" placeholder="Masukkan nama kategori" name="nama_kategori" value="<?php echo $c['nama_kategori']; ?>" maxlength="10" required>

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
                    <div class="modal fade" id="delete<?php echo $c["id_kategori"]; ?>">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="<?php echo BASEURL; ?>/kategori-barang" method="post">
                            <div class="modal-body">
                              <p>Apakah anda yakin menghapus kategori ini ?</p>
                              <input type="hidden" name="id_kategori" value="<?php echo $c['id_kategori']; ?>">
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