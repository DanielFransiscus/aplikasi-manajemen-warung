<?php

session_start();

require  '../function.php';
if ($status == true && $id_role != 1) {
  header('Location: ' . BASEURL . '/auth/login');
}


$p = "SELECT * FROM  profil where id = 1";
$result = mysqli_query($conn, $p);
$row = mysqli_fetch_assoc($result);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama_warung = mysqli_escape_string($conn, htmlspecialchars($_POST["nama_warung"]));
  $alamat = mysqli_escape_string($conn, htmlspecialchars($_POST["alamat"]));
  $kontak = mysqli_escape_string($conn, htmlspecialchars($_POST["kontak"]));

  if (empty($nama_warung)) {
    $errors['nama_warung'] = "Nama warung wajib diisi";
    $s['kosong'] = true;
  }
  if (empty($alamat)) {
    $errors['alamat'] = "Alamat warung wajib diisi";
    $s['kosong'] = true;
  }
  if (empty($kontak)) {
    $errors['kontak'] = "Kontak warung wajib diisi";
    $s['kosong'] = true;
  }



  if (is_array($s['kosong'])) {
    if ($s['kosong'] == false) {
      $sql = "UPDATE profil SET nama_warung = '$nama_warung', alamat = '$alamat', kontak = '$kontak' WHERE id = 1";
      if (mysqli_query($conn, $sql)) {
        setFlash('berhasil', 'diubah', 'success');
        header('Location: ' . BASEURL . '/profil-warung');
        exit();
      } else {
        setFlash('gagal', 'diubah', 'danger');
        header('Location: ' . BASEURL . '/profil-warung');
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
  <meta name="description" content="Aplikasi Aplikasi POS">
  <meta name="author" content="">
  <title>Profil Warung - Aplikasi POS</title>
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
          <!-- awal -->



          <div class="row justify-content-center mt-4 mb-4 border">
            <div class="col-md-6">
              <?php echo flash(); ?>
              <h1 class="mt-3 mb-4 text-center">Profil Warung</h1>


              <form action="<?php echo BASEURL; ?>/profil-warung/" method="post" novalidate>
                <!-- Modal body -->

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label" for="nama_warung">Nama </label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control <?php echo isset($errors['nama_warung']) ? 'is-invalid' : '' ?>"" id=" nama_warung" placeholder="Masukkan Nama Warung" name="nama_warung" value="<?php echo $row['nama_warung']; ?>" maxlength="58" required>
                    <div class="invalid-feedback">
                      <?php echo $errors['nama_warung'] ?? '' ?>
                    </div>
                  </div>
                </div>




                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label" for="alamat">Alamat</label>
                  <div class="col-sm-10">
                    <textarea class="form-control <?php echo isset($errors['alamat']) ? 'is-invalid' : '' ?>"" id=" alamat" name="alamat" rows="3" maxlength="250"><?php echo $row['alamat']; ?></textarea>
                    <div class="invalid-feedback">
                      <?php echo $errors['alamat'] ?? '' ?>
                    </div>
                  </div>
                </div>





                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label" for="kontak">Kontak</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control <?php echo isset($errors['kontak']) ? 'is-invalid' : '' ?>" id=" kontak" placeholder="Masukkan Kontak" name="kontak" maxlength="13" value="<?php echo $row['kontak']; ?>" required>
                    <div class="invalid-feedback">
                      <?php echo $errors['kontak'] ?? '' ?>
                    </div>
                  </div>
                </div>


                <div class="row justify-content-center">
                  <div class="col-md-12 mb-4">
                    <button type="submit" class="btn btn-primary ms-2 float-end">Ubah</button>
                  </div>
                </div>



            </div>
            <!-- Modal footer -->

            </form>
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