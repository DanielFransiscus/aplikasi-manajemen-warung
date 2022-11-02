<?php

session_start();

include './function.php';



if (isset($_POST['submit'])) {
    if (ubahProfil($_POST) > 0) {
        setFlash('berhasil', 'diubah', 'success');
        header('Location: ' . BASEURL . '/admin/warung.php');
        exit;
    } else {
        setFlash('gagal', 'diubah', 'danger');
        header('Location: ' . BASEURL . '/admin/warung.php');
        exit;
    }
}



$q1 = mysqli_query($conn, "Select * from warung where id_warung=1");
$q = mysqli_fetch_assoc($q1);


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Aplikasi SIM Warung">
    <meta name="author" content="">
    <title>Profil Warung - SIM Warung</title>
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
                    <h1 class="mt-4">Profil Warung</h1>

                    <?php echo flash(); ?>
                    <div class="card" style="width: 60%">

                        <div class="card-body">

                            <form action="<?php echo BASEURL; ?>/admin/warung.php" method="post">
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label" for="nama_warung">Nama Warung</label>
                                        <input type="text" class="form-control" id="nama_warung" placeholder="Masukkan Nama Warung" name="nama_warung" value="<?php echo $q['nama_warung']; ?>" maxlength="25" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="alamat">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="3" maxlength="35"><?php echo $q['alamat']; ?></textarea>

                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="konf_password">Kontak</label>
                                        <input type="text" class="form-control" id="kontak" placeholder="Masukkan Kontak" name="kontak" maxlength="13" value="<?php echo $q['kontak']; ?>" required>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="submit" name="submit" class="btn btn-success">Ubah</button>
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
    <script src="../js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
    <script>
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 2000);
    </script>


</body>
<?php ob_end_flush(); ?>

</html>