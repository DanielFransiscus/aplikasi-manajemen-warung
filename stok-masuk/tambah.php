<?php
session_start();

require  '../function.php';

if ($status == true && $id_role != 1) {
  header('Location: ' . BASEURL . '/auth/login');
}

$barangs = query("SELECT * FROM  barang order by id_barang ASC");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_barang = mysqli_escape_string($conn, htmlspecialchars($_POST["id_barang"]));
  $jumlah = htmlspecialchars(abs((int)$_POST["jumlah"]));
  $tanggal = date("Y-m-d H:i:s");

  if (empty($id_barang)) {
    $errors['id_barang'] = "Nama barang wajib diisi";
    $s['kosong'] = true;
  }
  if (empty($jumlah)) {
    $errors['jumlah'] = "Jumlah barang wajib diisi";
    $s['kosong'] = true;
  }




  if (is_array($s['kosong'])) {
    if ($s['kosong'] == false) {
      $sql = "INSERT INTO barang_masuk ( id_barang, jumlah, tgl_msk) 
      VALUES ($id_barang, '$jumlah', '$tanggal')";


      if (mysqli_query($conn, $sql)) {
        setFlash('berhasil', 'ditambahkan', 'success');
        header('Location: ' . BASEURL . '/stok-masuk');
        exit();
      } else {
        setFlash('gagal', 'ditambahkan', 'danger');
        header('Location: ' . BASEURL . '/stok-masuk');
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
              <h1 class="mt-3 mb-4 text-center">Tambah Stok Masuk</h1>

              <form action="<?php echo BASEURL; ?>/stok-masuk/tambah" method="post" novalidate>
                <!-- Modal body -->

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label" for="id_barang">Barang</label>
                  <div class="col-sm-10">
                    <select class="form-select <?php echo isset($errors['id_barang']) ? 'is-invalid' : '' ?>" id="id_barang" name="id_barang" required>
                      <option value="" hidden selected>Pilih nama barang</option>
                      <?php foreach ($barangs as $c) { ?>
                        <option value="<?php echo htmlentities($c['id_barang']); ?>">
                          <?php echo htmlentities($c['nama']); ?>
                        </option>
                      <?php } ?>
                    </select>
                    <div class="invalid-feedback">
                      <?php echo $errors['id_barang'] ?? '' ?>
                    </div>
                  </div>
                </div>


                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label" for="jumlah">Jumlah</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control <?php echo isset($errors['id_barang']) ? 'is-invalid' : '' ?>" id="jumlah" placeholder="Masukkan jumlah barang" name="jumlah" min="1" required>
                    <div class="invalid-feedback">
                      <?php echo $errors['jumlah'] ?? '' ?>
                    </div>
                  </div>
                </div>



                <div class="row justify-content-center">
                  <div class="col-md-12 mb-4">
                    <button type="submit" class="btn btn-primary ms-2 float-end">Simpan</button>
                    <button type="button" onclick="window.location.href='<?php echo BASEURL; ?>/stok-masuk'" class="btn btn-default float-end" data-bs-dismiss="modal">Batal</button>
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