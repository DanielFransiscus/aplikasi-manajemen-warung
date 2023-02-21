<?php

session_start();

include './function.php';

$q = json_decode(file_get_contents(__DIR__ . '/profil.json'), true);

if ($q == null) {

  setFlash('tidak dapat dibaca', 'The string is not valid JSON', 'danger');
}




if (isset($_POST['submit'])) {
  $q['nama_warung'] = $_POST["nama_warung"];
  $q['kontak'] = $_POST["kontak"];
  $q['alamat'] = $_POST["alamat"];
  $jsonString = json_encode($q);

  file_put_contents('profil.json', $jsonString);
  setFlash('berhasil', 'ditambahkan', 'success');
  // header('Location: ' . BASEURL . '/profil-warung');
}







?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Aplikasi Aplikasi POS">
  <meta name="author" content="">
  <title>Profil Warung - Aplikasi POS</title>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css">

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>/assets/css/styles.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

</head>

<body class="sb-nav-fixed">


  <?php include 'partials/top_nav.php'; ?>
  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <?php include 'partials/sidebar.php'; ?>
    </div>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <!-- awal -->
          <h1 class="mt-4">Profil Warung</h1>
          <?php echo flash(); ?>
          <div class="card" style="width: 60%">
            <div class="card-body">
              <form action="<?php echo BASEURL; ?>/profil-warung" method="post">
                <!-- Modal body -->
                <div class="modal-body">
                  <div class="mb-3">
                    <label class="form-label" for="nama_warung">Nama Warung</label>
                    <input type="text" class="form-control" id="nama_warung" placeholder="Masukkan Nama Warung" name="nama_warung" value="<?php echo $q['nama_warung']; ?>" maxlength="45" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="alamat">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" maxlength="250"><?php echo $q['alamat']; ?></textarea>
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="konf_password">Kontak</label>
                    <input type="text" class="form-control" id="kontak" placeholder="Masukkan Kontak" name="kontak" maxlength="13" value="<?php echo $q['kontak']; ?>" required>
                  </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">

                  <button type="submit" name="submit" class="btn btn-success">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
  <script src="../js/scripts.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
  <script src="../js/datatables-simple-demo.js"></script>
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