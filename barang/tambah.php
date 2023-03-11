<?php
session_start();

require  '../function.php';
if ($status == true && $id_role != 1) {
  header('Location: ' . BASEURL . '/auth/login');
}
$categories = query("SELECT * FROM  kategori_barang order by id_kategori ASC");
$satuans = query("SELECT * FROM  satuan order by id_satuan ASC");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = mysqli_escape_string($conn, htmlspecialchars($_POST["nama"]));
  $harga = htmlspecialchars(abs((int)$_POST["harga"]));
  $id_satuan = htmlspecialchars($_POST["id_satuan"]);
  $id_kategori = htmlspecialchars($_POST["id_kategori"]);
  if (empty($nama)) {
    $errors['nama'] = "Nama barang wajib diisi";
    $s['kosong'] = true;
  }
  if (empty($harga)) {
    $errors['harga'] = "Harga barang wajib diisi";
    $s['kosong'] = true;
  }
  if (empty($id_satuan)) {
    $errors['id_satuan'] = "Satuan barang wajib diisi";
    $s['kosong'] = true;
  }
  if (empty($id_kategori)) {
    $errors['id_kategori'] = "Kategori barang wajib diisi";
    $s['kosong'] = true;
  }
  if (is_array($s['kosong'])) {
    if ($s['kosong'] == false) {
      $sql = "INSERT INTO barang (id_kategori, id_satuan, nama, harga_barang, stok) 
      VALUES ($id_kategori, '$id_satuan', '$nama', '$harga', '$jumlah')";
      if (mysqli_query($conn, $sql)) {
        setFlash('berhasil', 'ditambahkan', 'success');
        header('Location: ' . BASEURL . '/barang');
        exit();
      } else {
        setFlash('gagal', 'ditambahkan', 'danger');
        header('Location: ' . BASEURL . '/barang');
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
  <title>Barang</title>
  <link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>/assets/css/styles.css">
</head>

<body class="sb-nav-fixed">
  <?php include '../partials/top_nav.php'; ?>
  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <?php include '../partials/sidebar.php'; ?>
    </div>
    <div id="layoutSidenav_content">
      <div class="container-fluid px-4  ">
        <div class="row justify-content-center mt-4 mb-4 border">
          <div class="col-md-6">
            <h1 class="mt-3 mb-4 text-center">Tambah Barang</h1>
            <form action="<?php echo BASEURL; ?>/barang/tambah" method="post" novalidate>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="nama">Nama</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control <?php echo isset($errors['nama']) ? 'is-invalid' : '' ?>" id="nama" placeholder="Masukkan Nama Barang" name="nama" maxlength="25" required>
                  <div class="invalid-feedback">
                    <?php echo $errors['nama'] ?? '' ?>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" class="form-label" for="id_kategori">Kategori</label>
                <div class="col-sm-10">
                  <select class="form-select <?php echo isset($errors['id_kategori']) ? 'is-invalid' : '' ?>" id="id_kategori" name="id_kategori" required>
                    <option value="" option hidden selected>Pilih kategori barang</option>
                    <?php foreach ($categories as $c) { ?>
                      <option value="<?php echo htmlentities($c['id_kategori']); ?>">
                        <?php echo htmlentities($c['nama_kategori']); ?>
                      </option>
                    <?php } ?>
                  </select>
                  <div class="invalid-feedback">
                    <?php echo $errors['id_kategori'] ?? '' ?>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="id_satuan">Satuan</label>
                <div class="col-sm-10">
                  <select class="form-select <?php echo isset($errors['id_satuan']) ? 'is-invalid' : '' ?>" id="id_satuan" name="id_satuan" required>
                    <option value="" option hidden selected>Pilih Satuan Barang</option>
                    <?php foreach ($satuans as $c) { ?>
                      <option value="<?php echo htmlentities($c['id_satuan']); ?>">
                        <?php echo htmlentities($c['nama_satuan']); ?>
                      </option>
                    <?php } ?>
                  </select>
                  <div class="invalid-feedback">
                    <?php echo $errors['id_satuan'] ?? '' ?>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="harga">Harga</label>
                <div class="col-sm-10">
                  <input type="number" class="form-control <?php echo isset($errors['harga']) ? 'is-invalid' : '' ?>" id="harga" placeholder="Masukkan Harga Barang" name="harga" min="1" required>
                  <div class="invalid-feedback">
                    <?php echo $errors['harga'] ?? '' ?>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="jumlah">Jumlah </label>
                <div class="col-sm-10">
                  <input type="number" class="form-control" id="jumlah" placeholder="Masukkan Jumlah Barang" name="jumlah" min="0" value="0" disabled required>
                  <div class="invalid-feedback">
                    <?php echo $errors['harga'] ?? '' ?>
                  </div>
                </div>
              </div>
              <div class="row justify-content-center">
                <div class="col-md-12 mb-4">
                  <button type="submit" class="btn btn-primary ms-2 float-end">Simpan</button>
                  <button type="button" onclick="window.location.href='<?php echo BASEURL; ?>/barang'" class="btn btn-default float-end" data-bs-dismiss="modal">Batal</button>
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