<?php
require __DIR__ . '/function.php';

session_start();




if (isset($_SESSION['id_role']) && isset($_SESSION["login"])) {
  if ($_SESSION['id_role'] === 1 || $_SESSION['id_role'] === 2 && $_SESSION["login"] === true) {
    header('Location: ' . BASEURL . '/dashboard');
    exit;
  }
}




$username = '';
$password = '';

if (isset($_POST["login"])) {
  $username = htmlspecialchars($_POST['username']);
  $password = htmlspecialchars($_POST['password']);
  if (!$username) {
    $errors['username'] = REQUIRED_FIELD_ERROR;
  }

  if (!$password) {
    $errors['password'] = REQUIRED_FIELD_ERROR;
  }
  $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row["password"])) {
      if ($row['id_role'] == 1) {

        $_SESSION["login"] = true;
        $_SESSION["id_user"] = $row['id_user'];
        $_SESSION["username"] = $row['username'];
        $_SESSION['id_role'] = 1;
        $_SESSION['role'] = "admin";
        header('Location: ' . BASEURL . '/dashboard');
      } elseif ($row['id_role'] == 2) {

        $_SESSION["login"] = true;
        $_SESSION["id_user"] = $row['id_user'];
        $_SESSION["username"] = $row['username'];
        $_SESSION['id_role'] = 2;
        $_SESSION['role'] = "kasir";
        header('Location: ' . BASEURL . '/dashboard');
      } else {
        session_destroy();
        header('Location: ' . BASEURL . '/auth/login');
      }
    } else {
      setFlash('Gagal', 'login.', 'danger', ' Isi password dengan benar !');
    }
  } else {
    setFlash('Gagal', 'login.', 'danger', ' Isi username dengan benar !');
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
  <meta name="author" content="Daniel Fransiscus">
  <title>Login - Aplikasi POS</title>
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
                  <h3 class="text-center font-weight-light my-4">Login</h3>
                  <?php flash(); ?>
                </div>
                <div class="card-body">
                  <form action="<?php echo BASEURL; ?>/auth/login" method="post">
                    <div class="form-floating mb-3">
                      <input class="form-control <?php echo isset($errors['username']) ? 'is-invalid' : '' ?>" id="username" type="text" name="username" required>
                      <label class="form-label" for="username">Username</label>
                      <div class="invalid-feedback">
                        <?php echo $errors['username'] ?? '' ?>
                      </div>
                    </div>
                    <div class="form-floating mb-3">
                      <input class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : '' ?>" id="password" type="password" name="password" required>
                      <label class="form-label" for="password">Password</label>
                      <div class="invalid-feedback">
                        <?php echo $errors['password'] ?? '' ?>
                      </div>
                    </div>


                    <div class="mt-4">
                      <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-block" name="login">Login</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center py-3">
                  <div class="small">Belum punya akun ? <a href="<?php echo BASEURL; ?>/auth/register"> Daftar </a></div>
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
      /* To Disable Inspect Element */
      $(document).bind("contextmenu", function(e) {
        e.preventDefault();
      });

      $(document).keydown(function(e) {
        if (e.which === 123) {
          return false;
        }
      });
    </script>
  </div>
</body>

</html>