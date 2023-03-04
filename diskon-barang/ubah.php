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

  $query = "SELECT * FROM disbarang inner join barang ON disbarang.id_barang=barang.id_barang where id_diskon = $id
	order by id_diskon ASC";

  $barang = query('SELECT * FROM barang order by id_barang ASC');


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
  $id_diskon = htmlspecialchars($_POST["id_diskon"]);
  $id_barang = htmlspecialchars($_POST["id_barang"]);
  $qty =  htmlspecialchars(abs((int)$_POST["qty"]));
  $potongan =  htmlspecialchars(abs((int)$_POST["potongan"]));


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

      $sql = "UPDATE disbarang SET id_barang = '$id_barang', qty = '$qty', potongan = '$potongan' WHERE id_diskon = $id_diskon";
      if (mysqli_query($conn, $sql)) {
        setFlash('berhasil', 'diubah', 'success');
        header('Location: ' . BASEURL . '/diskon-barang');
        exit();
      } else {
        setFlash('gagal', 'diubah', 'danger');
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
  <title>Diskon Barang - Kasir</title>
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
              <h1 class="mt-3 mb-4 text-center">Ubah Diskon Barang</h1>

              <form action="<?php echo BASEURL; ?>/diskon-barang/ubah?id=<?php echo $id; ?>" method="post" novalidate>
                <!-- Modal body -->

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label" for="id_barang">Barang</label>
                  <div class="col-sm-10">
                    <input type="hidden" name="id_diskon" value="<?php echo htmlentities($row['id_diskon']); ?>">
                    <select class="form-select <?php echo isset($errors['id_barang']) ? 'is-invalid' : '' ?>" id="id_barang" name="id_barang" required>
                      <option value="" hidden selected>Pilih nama barang</option>
                      <?php foreach ($barang as $b) { ?>
                        <option value="<?php echo htmlentities($b['id_barang']); ?>" <?php echo htmlentities(($row['nama'] == $b['nama'])) ? 'selected' : ''; ?>>
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
                      <input type="number" class="form-control <?php echo isset($errors['qty']) ? 'is-invalid' : '' ?>" id=" qty" placeholder="Masukkan jumlah Barang" name="qty" value="<?php echo htmlentities($row['qty']); ?>" min="1" required>
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


                      <input type="number" class="form-control <?php echo isset($errors['potongan']) ? 'is-invalid' : '' ?>" id="potongan" placeholder="Masukkan potongan harga barang" name="potongan" value="<?php echo htmlentities($row['potongan']); ?>" min="1" required>
                      <div class="invalid-feedback">
                        <?php echo $errors['potongan'] ?? '' ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row justify-content-center">
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