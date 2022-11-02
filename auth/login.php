<?php

include './function.php';

session_start();


if (isset($_SESSION["login"]) && $_SESSION['id_role'] == 1  && $_SESSION["login"] = true) {
    header('Location: ' . BASEURL . '/admin/dashboard.php');
    exit;
}

elseif (isset($_SESSION["login"]) && $_SESSION['id_role'] == 2 && $_SESSION["login"] = true) {
    header('Location: ' . BASEURL . '/kasir/dashboard.php');
    exit;
}
else{
     session_destroy();
}


if (isset($_POST["login"])) {

    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    $id_role = htmlspecialchars($_POST["id_role"]);

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' AND id_role = '$id_role'");
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {

            if ($row['id_role'] == 1) {
                session_start();
                $_SESSION["login"] = true;
                $_SESSION["id_user"] = $row['id_user'];
                $_SESSION["username"] = $row['username'];
                $_SESSION["nama"] = $row['nama_user'];
                $_SESSION['id_role'] = 1;
                $_SESSION['role'] = "admin";
                header('Location: ' . BASEURL . '/admin/dashboard.php');
            } elseif ($row['id_role'] == 2) {
                session_start();
                $_SESSION["login"] = true;
                $_SESSION["id_user"] = $row['id_user'];
                $_SESSION["username"] = $row['username'];
                $_SESSION["nama"] = $row['nama_user'];
                $_SESSION['id_role'] = 2;
                $_SESSION['role'] = "kasir";
                header('Location: ' . BASEURL . '/kasir/dashboard.php');
            } else {
                session_start();
                session_destroy();
                header('Location: ' . BASEURL . '/auth/login.php');
            }
        } else {
            setFlash('Gagal', 'login.', 'danger', ' Isi password dengan benar !');
            
        }
    } else {
        setFlash('Gagal', 'login.', 'danger', ' Isi username, password, dan role dengan benar !');
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Aplikasi SIM Warung">
    <meta name="author" content="Daniel Fransiscus">
    <title>Login - SIM Warung</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">

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

                                    <form action="<?php echo BASEURL; ?>/auth/login.php" onsubmit="return validateForm()" method="post">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="username" type="text" name="username" required>
                                            <label class="form-label" for="username">Username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="password" type="password" name="password" required>
                                            <label class="form-label" for="password">Password</label>
                                        </div>
                                        <div class="form-group mb-3">
                                            <select class="form-select" id="id_role" name="id_role">
                                             <option value="dummy" selected disabled>Pilih Role</option>
                                             <option value="1">Admin</option>
                                             <option value="2">Kasir</option>
                                         </select>
                                     </div>
                                     <small class="text-danger" id="msg"> </small>

                                     <script>
                                        function validateForm() {
                                            var ddl = document.getElementById("id_role");
                                            var selectedValue = ddl.options[ddl.selectedIndex].value;
                                            if (selectedValue == "dummy") {
                                                text = "Pilih role !";
                                                document.getElementById("msg").innerHTML = text;
                                                return false;
                                            }
                                        }
                                    </script>


                                    <div class="mt-4 mb-0">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary btn-block" name="login">Login</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center py-3">
                                <div class="small"><a href="<?php echo BASEURL; ?>/register/index.php">Belum punya akun? Registrasilah sekarang juga !</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="layoutAuthentication_footer">
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Daniel 2022</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 2000);
    </script>
</div>
</body>

</html>