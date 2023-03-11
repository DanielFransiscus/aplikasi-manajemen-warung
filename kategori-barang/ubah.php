<?php
session_start();
require  '../function.php';
if ($status == true && $id_role != 1) {
  header('Location: ' . BASEURL . '/auth/login');
}
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  if (!is_numeric($id)) {
    http_response_code(404);
    include('../404.php');
    exit();
  }
  $query = "SELECT * FROM  kategori_barang where id_kategori = $id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 0) {
    http_response_code(404);
    include('../404.php');
    exit();
  }
  $row = mysqli_fetch_assoc($result);
} else {
  http_response_code(400);
  echo "<h1><center>Id is required</center></h1>";
  exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama_kategori = mysqli_escape_string($conn, htmlspecialchars($_POST["nama_kategori"]));
  $ids = mysqli_escape_string($conn, htmlspecialchars($_POST["id"]));
  if (empty($nama_kategori)) {
    $errors['nama_kategori'] = "Kategori wajib diisi";
    $s['kosong'] = true;
  }
  if (is_array($s['kosong'])) {
    if ($s['kosong'] == false) {

      $sql = "UPDATE kategori_barang SET nama_kategori = '$nama_kategori' WHERE id_kategori = '$ids'";
      if (mysqli_query($conn, $sql)) {
        setFlash('berhasil', 'diubah', 'success');
        header('Location: ' . BASEURL . '/kategori-barang');
        exit();
      } else {
        setFlash('gagal', 'diubah', 'danger');
        header('Location: ' . BASEURL . '/kategori-barang');
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
  <title>Kategori Barang</title>
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
            <h1 class="mt-3 mb-4 text-center">Tambah Kategori Barang</h1>
            <form action="<?php echo BASEURL; ?>/kategori-barang//ubah?id=<?php echo $id; ?>" method="post" novalidate>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="nama_kategori">Kategori</label>
                <div class="col-sm-10">
                  <input type="hidden" name="id" value="<?php echo $row['id_kategori']; ?>">
                  <input type="text" class="form-control <?php echo isset($errors['nama_kategori']) ? 'is-invalid' : '' ?>" id="nama_kategori" placeholder="Masukkan nama kategori" name="nama_kategori" value="<?php echo $row['nama_kategori']; ?>" maxlength="25" required>
                  <div class="invalid-feedback">
                    <?php echo $errors['nama_kategori'] ?? '' ?>
                  </div>
                </div>
              </div>
              <div class="row justify-content-center">
                <div class="col-md-12 mb-4">
                  <button type="submit" class="btn btn-primary ms-2 float-end">Simpan</button>
                  <button type="button" onclick="window.location.href='<?php echo BASEURL; ?>/kategori-barang'" class="btn btn-default float-end" data-bs-dismiss="modal">Batal</button>
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