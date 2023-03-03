<?php

require __DIR__ . '/function.php';
session_start();


if (isset($_SESSION['id_role']) && isset($_SESSION["login"])) {
  if ($_SESSION['id_role'] == 1 || $_SESSION['id_role'] == 2 && $_SESSION["login"] == true) {
    header('Location: ' . BASEURL . '/dashboard');
    exit;
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $username = htmlspecialchars(trim($_POST["username"]));
  $password = htmlspecialchars(trim($_POST["password"]));
  $password2 = htmlspecialchars(trim($_POST["password2"]));
  if (empty($username)) {
    $errors['username'] = "Username wajib diisi";
    $s['kosong'] = true;
  }
  if (empty($password)) {
    $errors['password'] = "Password wajib diisi";
    $s['kosong'] = true;
  }
  if (empty($password2)) {
    $errors['password2'] = "Password wajib diisi";
    $s['kosong'] = true;
  }

  if ($password2 != $password) {
    $errors['password'] = "Password tidak cocok";
    $s['kosong'] = true;
  }

  if (is_array($s['kosong'])) {
    if ($s['kosong'] == false) {
      $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
      if (mysqli_num_rows($result) === 1) {
        setFlash('Username sudah terdaftar', '', 'danger', '');
      } else {
        if ($password !== $password2) {
          setFlash('Password tidak cocok !', '', 'danger', '');
        } else {
          $password = password_hash($password, PASSWORD_DEFAULT);
          $id_role = 2;
          if (mysqli_query($conn, "INSERT INTO users (id_user, id_role, username, password) VALUES (NULL, '$id_role', '$username', '$password')")) {
            setFlash('Selamat, akunmu berhasil dibuat', '', 'success', '');
            header('Location: ' . BASEURL . '/auth/login');
            exit();
          } else {
            setFlash('User baru gagal ditambahkan', '', 'danger', '');
            header('Location: ' . BASEURL . '/auth/registrasi');
            exit();
          }
        }
      }
    }
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
  <title>registrasi - SB Admin</title>
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
                  <?php flash(); ?>
                </div>
                <div class="card-body">
                  <form action="<?php echo BASEURL; ?>/auth/registrasi" method="POST" novalidate>
                    <div class="row mb-2">
                      <div class="form-floating mb-2">
                        <div class="form-floating mb-3 mb-md-0">
                          <input class="form-control <?php echo isset($errors['username']) ? 'is-invalid' : '' ?>" id="username" type="text" name="username" autocomplete="off" <?php if (isset($_POST['username'])) {
                                                                                                                                                                                  echo 'value="' . $_POST['username'] . '"';
                                                                                                                                                                                } ?> required />
                          <label class="form-label" for="username">Username</label>
                          <div class="invalid-feedback">
                            <?php echo $errors['username'] ?? '' ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                          <input class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : '' ?>" type="password" name="password" required />
                          <label class="form-label" for="password">Password</label>
                          <div class="invalid-feedback">
                            <?php echo $errors['password'] ?? '' ?>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                          <input class="form-control <?php echo isset($errors['password2']) ? 'is-invalid' : '' ?>" id=" password2" type="password" placeholder="" name="password2" required />
                          <label class="form-label" for="password2">Password Konfirmasi</label>
                          <div class="invalid-feedback">
                            <?php echo $errors['password2'] ?? '' ?>
                          </div>

                        </div>

                      </div>

                    </div>
                    <small class="text-danger" id="msg2"> </small>
                    <div class="mt-4 mb-0">
                      <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-block">Registrasi</button>
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
</body>

</html>