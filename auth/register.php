<?php

require __DIR__ . '/function.php';
$url = BASEURL . '/auth/login';
if (isset($_POST["register"])) {
  if (registrasi($_POST) > 0) {
    echo " <script>
        alert('user baru berhasil ditambahkan');  
        window.location.href = '$url';
        </script>";
  } else {
    echo " <script>
        alert('user baru gagal ditambahkan');
        window.location.href = '$url';
        </script>";
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Aplikasi Aplikasi POS">
  <meta name="author" content="Daniel Fransiscus">
  <title>Register - SB Admin</title>
  <link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>/assets/css/styles.css">

</head>

<body class="bg-dark">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                  <h3 class="text-center font-weight-light my-4">Registrasi</h3>
                </div>
                <div class="card-body">
                  <form action="<?php echo BASEURL; ?>/auth/register" method="POST">

                    <div class="row mb-2">
                      <div class="form-floating mb-2">
                        <div class="form-floating mb-3 mb-md-0">
                          <input class="form-control" id="username" type="text" name="username" autocomplete="off" required />
                          <label class="form-label" for="username">Username</label>
                          <small class="text-danger" id="msg"> </small>
                          <div class="invalid-feedback">
                            <?php echo $errors['username'] ?? '' ?>
                          </div>
                        </div>

                      </div>

                    </div>
                    <div class="row mb-2">
                      <div class="form mb-2">
                        <select class="form-select" id="id_role" name="id_role" required>
                          <option value="" option hidden disabled selected value>Pilih Role</option>
                          <option value="1">Admin</option>
                          <option value="2">Kasir</option>
                        </select>
                      </div>
                    </div>


                    <div class="row mb-3">
                      <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                          <input class="form-control" id="password" type="password" placeholder="" name="password" required />
                          <label class="form-label" for="password">Password</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                          <input class="form-control" id="password2" type="password" placeholder="" name="password2" required />
                          <label class="form-label" for="password2">Password Konfirmasi</label>
                          <div class="invalid-feedback">
                            <?php echo $errors['password'] ?? '' ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <small class="text-danger" id="msg2"> </small>
                    <div class="mt-4 mb-0">
                      <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-block" name="register">Registrasi</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center py-3">
                  <div class="small">Sudah punya akun <a href="<?php echo BASEURL; ?>/auth/login">Masuk</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>



    <script src="<?php echo BASEURL; ?>/assets/js/jquery-3.4.1.js"></script>
    <script src="<?php echo BASEURL; ?>/assets/js/bootstrap.bundle.min.js"></script>



    <script>
      $(document).ready(function() {
        $('#username').keyup(function() {
          var uname = $('#username').val();
          if (uname == 0) {
            $('#result').text('');
          } else {
            $.ajax({
              url: '<?php echo BASEURL; ?>' + '/auth/cek',
              type: 'POST',
              data: 'username=' + uname,
              success: function(hasil) {
                if (hasil > 0) {
                  $('#msg').text('Username sudah terdaftar, Pilih username baru !');
                } else {
                  $('#msg').text('');
                }
              }
            });
          }
        });
      });
    </script>
    <script>
      /* To Disable Inspect Element */
      // $(document).bind("contextmenu", function(e) {
      //   e.preventDefault();
      // });

      // $(document).keydown(function(e) {
      //   if (e.which === 123) {
      //     return false;
      //   }
      // });
    </script>
</body>

</html>