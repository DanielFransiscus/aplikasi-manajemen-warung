<?php
session_start();

include './function.php';

if (isset($_POST['submit'])) {
    $username = $_SESSION["username"];
    $id_role = $_SESSION['id_role'];
    $password_lama = htmlspecialchars($_POST['password_lama']);
    $password_baru = htmlspecialchars($_POST['password_baru']);
    $konf_password = htmlspecialchars($_POST['konf_password']);

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' AND id_role = '$id_role'");
    $row = mysqli_fetch_assoc($result);

    if (!password_verify($password_lama, $row["password"])) {
        // echo "<script>alert('Password lama tidak sesuai!, silahkan ulang kembali');</script>";

        setFlash2("Gagal", "mengganti password. ", "danger", "Password lama tidak sesuai. Isi password yang benar !");
        header('Location: ' . BASEURL . '/admin/ganti_password.php');
        exit();
    } else if ($password_baru != $konf_password) {
        // echo "<script>alert(' Ganti Password Gagal! Password dan Konfirm Password Harus Sama.');</script>";


        setFlash2("Gagal", "mengganti password. ", "danger", "Isi password dan password konfirmasi harus sama");
        header('Location: ' . BASEURL . '/admin/ganti_password.php');
        exit();
    } elseif (!isset($_POST['password_baru']) && !isset($_POST['$konf_password'])) {
        // echo "<script>alert(' Ganti Password Gagal! Isi kedua password.');</script>";
        setFlash2("Gagal", "mengganti password. ", "danger", "Isi kedua password !");
        header('Location: ' . BASEURL . '/admin/ganti_password.php');
        exit();
    } else {
        $password_baru = password_hash($password_baru, PASSWORD_DEFAULT);
        $query = "UPDATE user SET password='$password_baru' WHERE username='$username' AND id_role = '$id_role'";
        $sql = mysqli_query($conn, $query);
        //setelah berhasil update
        if ($sql) {
            setFlash('berhasil', 'diubah', 'success');
            header('Location: ' . BASEURL . '/admin/ganti_password.php');
            exit();
        } else {
            setFlash('gagal', 'diubah', 'danger');
            header('Location: ' . BASEURL . '/admin/ganti_password.php');
            exit();
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
    <meta name="description" content="Aplikasi SIM Warung">
    <meta name="author" content="Daniel Fransiscus">
    <title>Ganti Password - SIM Warung</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

</head>

<body class="sb-nav-fixed">

    <?php include '../admin/templates/top_nav.php'; ?>




    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include '../admin/templates/sidebar.php'; ?>
        </div>





        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">

                    <!-- awal -->
                    <h1 class="mt-4">Ganti Password</h1>

                    <?php flash(); ?>

                    <?php flash2(); ?>


                    <div class="card" style="width: 50%">
                        <div class="card-body">

                            <form action="<?php echo BASEURL; ?>/admin/ganti_password.php" onsubmit="return validateForm()" method="post">
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label" for="password_lama">Password Lama</label>
                                        <input type="text" class="form-control" id="password_lama" placeholder="Masukkan Password Lama" name="password_lama" value="" maxlength="17" required>
                                        <small id="msg" class="text-danger"></small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="password_baru">Password Baru</label>
                                        <input type="password" class="form-control" id="password_baru" placeholder="Masukkan Password Baru" name="password_baru" maxlength="17" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="konf_password">Konfirmasi Password Baru</label>
                                        <input type="password" class="form-control" id="konf_password" placeholder="Masukkan Konfirmasi Password Baru" name="konf_password" maxlength="17" required>
                                        <small id="msg2" class="text-danger"></small>
                                    </div>

                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="submit" name="submit" class="btn btn-success">Ubah</Ubah></button>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>

            </main>
            <?php include '../admin/templates/footer.php'; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="../assets/js/scripts.js"></script>


    <script>
        window.setTimeout(function () {
            $(".alert").fadeTo(500, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, 2000);



        function validateForm() {


            var password = document.getElementById("password_baru").value;
            var password2 = document.getElementById("konf_password").value;

            if (password != password2) {
                text = "Password baru dan password konfirmasi tidak sama";
                document.getElementById("msg2").innerHTML = text;
                return false;
            } else {
                text = "";
                document.getElementById("msg2").innerHTML = text;
            }

        }
    </script>





</body>
<?php ob_end_flush(); ?>

</html>