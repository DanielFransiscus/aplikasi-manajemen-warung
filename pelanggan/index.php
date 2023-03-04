<?php
session_start();

require '../function.php';
if ($status == true && $id_role != 1 && $id_role != 2) {
  header('Location: ' . BASEURL . '/auth/login');
}


$customers = query("SELECT * FROM pelanggan order by id_pelanggan ASC");


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Aplikasi  Kasir">
  <meta name="author" content="Daniel Fransiscus">
  <title>Pelanggan - Kasir</title>
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
              <h1>Pelanggan</h1>
            </div>
            <div class="card-body">

              <table id="datatablesSimple">
                <div class="clearfix">


                  <a class="btn btn-primary mb-4 float-end" href="<?php echo BASEURL; ?>/pelanggan/tambah" role="button">Tambah</a>

                </div>

                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kontak</th>
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


                        <a class="btn btn-success" href="<?php echo BASEURL; ?>/pelanggan/ubah?id=<?php echo $b['id_pelanggan'] ?>">Ubah</a>
                        <a class="btn btn-danger" href="<?php echo BASEURL; ?>/pelanggan/hapus?id=<?php echo $b['id_pelanggan'] ?>" onclick="return confirm('Apakah anda yakin menghapus data ini ?')">Hapus</a>

                      </td>
                    </tr>
                    <?php $i++; ?>
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