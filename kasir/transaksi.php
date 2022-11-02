<?php
session_start();

include './function.php';




if (isset($_POST["delete"])) {
    //cek apakah data berhasil di tambahkan atau tidak
    if (hapusTransaksi($_POST) > 0) {
        setFlash('berhasil', 'dihapus', 'success');
        header('Location: ' . BASEURL . '/admin/transaksi.php');
        exit;
    } else {
        setFlash('gagal', 'dihapus', 'danger');
        header('Location: ' . BASEURL . '/admin/transaksi.php');
        exit;
    }
}


$iduser = $_SESSION['id_user'];
$sql = "SELECT * FROM transaksi

inner join user ON transaksi.id_user=user.id_user
inner join pelanggan ON transaksi.id_pelanggan=pelanggan.id_pelanggan

where transaksi.id_user = $iduser 
order by id_transaksi ASC
";

$transaksi = query($sql);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Aplikasi SIM Warung">
    <meta name="author" content="Daniel Fransiscus">
    <title>Daftar Transaksi - SIM Warung</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
</head>

<body class="sb-nav-fixed">

    <?php include '../kasir/templates/top_nav.php'; ?>



    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include '../kasir/templates/sidebar.php'; ?>
        </div>



        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Transaksi</h1>
                    <?php flash(); ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Transaksi
                            <form action="list_transaksi.php" method="post">
                                <input placeholder="Masukkan tanggal awal" type="date" name="tgl_awal">
                                <input placeholder="Masukkan tanggal akhir" type="date" name="tgl_akhir">
                                <button type="submit" name="submit">Export</button>
                            </form>
                        </div>


                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID Transaksi</th>
                                        <th>Nama Petugas</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Tanggal dan Waktu</th>
                                        <th>Bayar</th>
                                        <th>Total</th>
                                        <th>Kembali</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($transaksi as $b) { ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $b['id_transaksi']; ?></td>
                                            <td><?php echo $b['nama_user']; ?></td>
                                            <td><?php echo $b['nama']; ?></td>
                                            <td><?php echo $b['tgl_wkt']; ?></td>

                                            <td><?php echo $b['bayar']; ?></td>
                                            <td><?php echo $b['total']; ?></td>
                                            <td><?php echo $b['kembali']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?php echo $b['id_transaksi']; ?>">Hapus</button>
                                                <a class="btn btn-secondary" href="transaksi_selesai.php?idtrx=<?php echo $b['id_transaksi']; ?>">Lihat</a>
                                            </td>
                                        </tr>




                                        <?php $i++; ?>


                                        <div class="modal fade" id="delete<?php echo $b["id_transaksi"]; ?>">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Hapus</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <p>Apakah anda yakin menghapus transaksi ini ?</p>
                                                            <input type="hidden" name="id_transaksi" value="<?php echo $b['id_transaksi']; ?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="delete" class="btn btn-danger">Hapus</button>
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        <?php } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>


            </main>

            <?php include '../admin/templates/footer.php'; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.js">
    </script>
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../assets/js/scripts.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="../assets/js/datatables-simple-demo.js"></script>

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