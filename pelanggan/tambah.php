<?php
session_start();
require  '../function.php';
if ($status == true && $id_role != 1 && $id_role != 2) {
  header('Location: ' . BASEURL . '/auth/login');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = mysqli_escape_string($conn, htmlspecialchars($_POST["nama"]));
  $kontak = mysqli_escape_string($conn, htmlspecialchars($_POST["kontak"]));
  $alamat = mysqli_escape_string($conn, htmlspecialchars($_POST["alamat"]));

  if (empty($nama)) {
    $errors['nama'] = "Nama pelanggan wajib diisi";
    $s['kosong'] = true;
  }
  if (empty($kontak)) {
    $errors['kontak'] = "Kontak pelanggan wajib diisi";
    $s['kosong'] = true;
  }
  if (empty($alamat)) {
    $errors['alamat'] = "Alamat pelanggan wajib diisi";
    $s['kosong'] = true;
  }


  if (is_array($s['kosong'])) {
    if ($s['kosong'] == false) {
      $sql = "INSERT INTO pelanggan (nama, kontak, alamat) VALUES ('$nama', '$kontak', '$alamat')";
      if (mysqli_query($conn, $sql)) {
        setFlash('berhasil', 'ditambahkan', 'success');
        header('Location: ' . BASEURL . '/pelanggan');
        exit();
      } else {
        setFlash('gagal', 'ditambahkan', 'danger');
        header('Location: ' . BASEURL . '/pelanggan');
        exit();
      }
    }
  }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Aplikasi  Kasir">
  <meta name="author" content="Daniel Fransiscus">
  <title>Pelanggan</title>
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
        <div class="container-fluid px-4  ">
          <div class="row justify-content-center mt-4 mb-4 border">
            <div class="col-md-6">
              <h1 class="mt-3 mb-4 text-center">Tambah Pelanggan</h1>
              <form action="<?php echo BASEURL; ?>/pelanggan/tambah" method="post" novalidate>
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label" for="nama">Pelanggan</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control <?php echo isset($errors['nama']) ? 'is-invalid' : '' ?>" id="nama" placeholder="Masukkan nama pelanggan" name="nama" maxlength="25" required maxlength="10" required>
                    <div class="invalid-feedback">
                      <?php echo $errors['nama'] ?? '' ?>
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label" for="kontak">Kontak</label>
                  <div class="col-sm-10">
                    <input type="tel" class="form-control <?php echo isset($errors['kontak']) ? 'is-invalid' : '' ?>" id="kontak" placeholder="Masukkan kontak" name="kontak" maxlength="12" required>
                    <div class="invalid-feedback">
                      <?php echo $errors['kontak'] ?? '' ?>
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label" for="alamat">Alamat</label>
                  <div class="col-sm-10">
                    <textarea class="form-control <?php echo isset($errors['alamat']) ? 'is-invalid' : '' ?>" id="alamat" name="alamat" maxlength="75" placeholder="Masukkan alamat" rows="3" required></textarea>
                    <div class="invalid-feedback">
                      <?php echo $errors['alamat'] ?? '' ?>
                    </div>
                  </div>
                </div>
                <div class="row justify-content-center">
                  <div class="col-md-12 mb-4">
                    <button type="submit" class="btn btn-primary ms-2 float-end">Simpan</button>
                    <button type="button" onclick="window.location.href='<?php echo BASEURL; ?>/pelanggan'" class="btn btn-default float-end" data-bs-dismiss="modal">Batal</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
  </div>
  <script src="<?php echo BASEURL; ?>/assets/js/jquery-3.4.1.js"></script>
  <script src="<?php echo BASEURL; ?>/assets/js/fontawesome.js"></script>
  <script src="<?php echo BASEURL; ?>/assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo BASEURL; ?>/assets/js/scripts.js"></script>
</body>

</html>