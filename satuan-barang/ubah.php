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

  $query = "SELECT * FROM  satuan where id_satuan = $id";
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
  die();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama_satuan = mysqli_escape_string($conn, htmlspecialchars($_POST["nama_satuan"]));
  $ids = mysqli_escape_string($conn, htmlspecialchars($_POST["id"]));

  if (empty($nama_satuan)) {
    $errors['nama_satuan'] = "Satuan wajib diisi";
    $s['kosong'] = true;
  }
  if (is_array($s['kosong'])) {
    if ($s['kosong'] == false) {

      $sql = "UPDATE satuan SET nama_satuan = '$nama_satuan' WHERE id_satuan = '$ids'";
      if (mysqli_query($conn, $sql)) {
        setFlash('berhasil', 'diubah', 'success');
        header('Location: ' . BASEURL . '/satuan-barang');
        exit();
      } else {
        setFlash('gagal', 'diubah', 'danger');
        header('Location: ' . BASEURL . '/satuan-barang');
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
  <title>Satuan Barang - Kasir</title>
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
        <div class="container-fluid px-4  ">

          <!-- awal -->

          <div class="row justify-content-center mt-4 mb-4 border">
            <div class="col-md-6">
              <h1 class="mt-3 mb-4 text-center">Tambah Satuan Barang</h1>

              <form action="<?php echo BASEURL; ?>/satuan-barang/ubah?id=<?php echo $id; ?>" method="post" novalidate>
                <!-- Modal body -->

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label" for="nama_satuan">Satuan</label>
                  <div class="col-sm-10">
                    <input type="hidden" name="id" value="<?php echo $row['id_satuan']; ?>">
                    <input type="text" class="form-control <?php echo isset($errors['nama_satuan']) ? 'is-invalid' : '' ?>" id="nama_satuan" placeholder="Masukkan nama kategori" name="nama_satuan" value="<?php echo $row['nama_satuan']; ?>" maxlength="10" required>
                    <div class="invalid-feedback">
                      <?php echo $errors['nama_satuan'] ?? '' ?>
                    </div>



                  </div>
                </div>

                <div class="row justify-content-center">
                  <div class="col-md-12 mb-4">
                    <button type="submit" class="btn btn-primary ms-2 float-end">Simpan</button>
                    <button type="button" onclick="window.location.href='<?php echo BASEURL; ?>/satuan-barang'" class="btn btn-default float-end" data-bs-dismiss="modal">Batal</button>
                  </div>
                </div>

              </form>
            </div>
          </div>
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



</body>
<?php ob_end_flush(); ?>

</html>