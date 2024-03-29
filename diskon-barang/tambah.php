<?php
session_start();
require  '../function.php';
if ($status == true && $id_role != 1) {
  header('Location: ' . BASEURL . '/auth/login');
}
$barang = query('SELECT * FROM barang order by id_barang ASC');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_barang = htmlspecialchars($_POST["id_barang"]);
  $qty = htmlspecialchars(abs((int)$_POST["qty"]));
  $potongan = htmlspecialchars(abs((int)$_POST["potongan"]));

  if (empty($id_barang)) {
    $errors['id_barang'] = "Nama barang wajib diisi";
    $s['kosong'] = true;
  }
  if (empty($qty)) {
    $errors['qty'] = "Jumlah barang wajib diisi";
    $s['kosong'] = true;
  }
  if (empty($potongan)) {
    $errors['potongan'] = "Potongan harga barang wajib diisi";
    $s['kosong'] = true;
  }
  if (is_array($s['kosong'])) {
    if ($s['kosong'] == false) {
      $sql = "INSERT INTO disbarang (id_barang, qty, potongan) VALUES ('$id_barang', '$qty', '$potongan')";
      if (mysqli_query($conn, $sql)) {
        setFlash('berhasil', 'ditambahkan', 'success');
        header('Location: ' . BASEURL . '/diskon-barang');
        exit();
      } else {
        setFlash('gagal', 'ditambahkan', 'danger');
        header('Location: ' . BASEURL . '/diskon-barang');
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
  <title>Diskon Barang</title>
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
            <h1 class="mt-3 mb-4 text-center">Tambah Diskon Barang</h1>
            <form action="<?php echo BASEURL; ?>/diskon-barang/tambah" method="post" novalidate>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="id_barang">Barang</label>
                <div class="col-sm-10">
                  <select class="form-select <?php echo isset($errors['id_barang']) ? 'is-invalid' : '' ?>" id="id_barang" name="id_barang" required>
                    <option value="" hidden selected>Pilih barang</option>
                    <?php foreach ($barang as $b) { ?>
                      <option value="<?php echo htmlentities($b['id_barang']); ?>">
                        <?php echo htmlentities($b['nama']); ?>
                      </option>
                    <?php } ?>
                  </select>
                  <div class="invalid-feedback">
                    <?php echo $errors['id_barang'] ?? '' ?>
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label" for="qty">Jumlah</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control <?php echo isset($errors['qty']) ? 'is-invalid' : '' ?>" id=" qty" placeholder="Masukkan jumlah Barang" name="qty" min="1" required>
                    <div class="invalid-feedback">
                      <?php echo $errors['qty'] ?? '' ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label" for="potongan">Potongan</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control <?php echo isset($errors['potongan']) ? 'is-invalid' : '' ?>"" id=" potongan" placeholder="Masukkan potongan harga barang" name="potongan" min="1" required>
                    <div class="invalid-feedback">
                      <?php echo $errors['potongan'] ?? '' ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row justify-content-centers">
                <div class="col-md-12 mb-4">
                  <button type="submit" class="btn btn-primary ms-2 float-end">Simpan</button>
                  <button type="button" onclick="window.location.href='<?php echo BASEURL; ?>/diskon-barang'" class="btn btn-default float-end" data-bs-dismiss="modal">Batal</button>
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