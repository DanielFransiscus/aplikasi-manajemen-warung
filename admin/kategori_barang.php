<?php
session_start();

include './function.php';

$categories = query("SELECT * FROM  kategori_barang order by id_kategori ASC");


if (isset($_POST["insert"])) {
    if (tambahKategori($_POST) > 0) {
        setFlash('berhasil', 'ditambahkan', 'success');
        header('Location: ' . BASEURL . '/admin/kategori_barang.php');
        exit;
    } else {
        setFlash('gagal', 'ditambahkan', 'danger');
        header('Location: ' . BASEURL . '/admin/kategori_barang.php');
        exit;
    }
}


if (isset($_POST["update"])) {
    //cek apakah data berhasil di tambahkan atau tidak
    if (ubahKategori($_POST) > 0) {
        setFlash('berhasil', 'diubah', 'success');
        header('Location: ' . BASEURL . '/admin/kategori_barang.php');
        exit;
    } else {
        setFlash('gagal', 'diubah', 'danger');
        header('Location: ' . BASEURL . '/admin/kategori_barang.php');
        exit;
    }
}


if (isset($_POST["delete"])) {
    //cek apakah data berhasil di tambahkan atau tidak
    if (hapusKategori($_POST) > 0) {
        setFlash('berhasil', 'dihapus', 'success');
        header('Location: ' . BASEURL . '/admin/kategori_barang.php');
        exit;
    } else {
        setFlash('gagal', 'dihapus', 'danger');
        header('Location: ' . BASEURL . '/admin/kategori_barang.php');
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" >
    <meta http-equiv="X-UA-Compatible" content="IE=edge" >
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" >
    <meta name="description" content="Aplikasi SIM Warung">
    <meta name="author" content="Daniel Fransiscus" >
    <title>Kategori Barang - SIM Warung</title>
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
                <h1 class="mt-4">Kategori Barang</h1>
                <?php flash(); ?>
                <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#myModal">
                    Tambah
                </button>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Data Kategori Barang
                    </div>
                    <div class="modal" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Tambah Kategori</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="<?php echo BASEURL; ?>/admin/kategori_barang.php"  method="post">
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label" for="nama_kategori">Nama Kategori</label>
                                            <input type="text" class="form-control" id="nama_kategori" placeholder="Masukkan nama kategori" name="nama_kategori" maxlength="10" required>

                                        </div>
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="submit" name="insert" class="btn btn-primary">Simpan</button>
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Kategori</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($categories as $c) { ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $c['id_kategori']; ?></td>
                                        <td><?php echo $c['nama_kategori']; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#edit<?php echo $c['id_kategori']; ?>">Ubah</button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?php echo $c['id_kategori']; ?>">Hapus</button>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                    <!-- model edit -->
                                    <div class="modal fade" id="edit<?php echo $c['id_kategori']; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Ubah <?php echo $c['nama_kategori']; ?></h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="<?php echo BASEURL; ?>/admin/kategori_barang.php" method="post">
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <input type="hidden" name="id_kategori" value="<?php echo $c['id_kategori']; ?>">
                                                            <label class="form-label" for="nama_kategori">Nama Kategori</label>
                                                            <input type="text" class="form-control" id="nama_kategori" placeholder="Masukkan nama kategori" name="nama_kategori" value="<?php echo $c['nama_kategori']; ?>" maxlength="10" required>

                                                        </div>
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="submit" name="update" class="btn btn-success">Ubah</button>
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- modal delete -->
                                    <div class="modal fade" id="delete<?php echo $c["id_kategori"]; ?>">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Hapus</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="<?php echo BASEURL; ?>/admin/kategori_barang.php" method="post">
                                                    <div class="modal-body">
                                                        <p>Apakah anda yakin menghapus kategori ini ?</p>
                                                        <input type="hidden" name="id_kategori" value="<?php echo $c['id_kategori']; ?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" name="delete" class="btn btn-danger">Hapus</button>
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </tbody>
                        </table>
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