<?php
session_start();

include './function.php';

$barang = query("SELECT * FROM barang 


    INNER JOIN kategori_barang 
    ON barang.id_kategori = kategori_barang.id_kategori

    order by id_barang ASC
    ");
$categories = query("SELECT * FROM  kategori_barang order by id_kategori ASC");

$barang2 = query("SELECT * FROM barang where jumlah < 1 order by id_barang ASC");

if (isset($_POST["insert"])) {
    if (tambahBarang($_POST) > 0) {
        setFlash('berhasil', 'ditambahkan', 'success');
        header('Location: ' . BASEURL . '/admin/barang.php');
        exit;
    } else {
        setFlash('gagal', 'ditambahkan', 'danger');
        header('Location: ' . BASEURL . '/admin/barang.php');
        exit;
    }
}


if (isset($_POST["update"])) {
    //cek apakah data berhasil di tambahkan atau tidak
    if (ubahBarang($_POST) > 0) {
        setFlash('berhasil', 'diubah', 'success');
        header('Location: ' . BASEURL . '/admin/barang.php');
        exit;
    } else {
        setFlash('gagal', 'diubah', 'danger');
        header('Location: ' . BASEURL . '/admin/barang.php');
        exit;
    }
}

if (isset($_POST["delete"])) {
    //cek apakah data berhasil di tambahkan atau tidak
    if (hapusBarang($_POST) > 0) {
        setFlash('berhasil', 'dihapus', 'success');
        header('Location: ' . BASEURL . '/admin/barang.php');
        exit;
    } else {
        setFlash('gagal', 'dihapus', 'danger');
        header('Location: ' . BASEURL . '/admin/barang.php');
        exit;
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
    <title>Barang - SIM Warung</title>
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
                    <h1 class="mt-4">Barang</h1>
                    <?php flash(); ?>
                    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#myModal">
                        Tambah
                    </button>
                    <a href="<?php echo BASEURL; ?>/admin/list_barang.php" class="btn btn-dark mb-4">Export</a>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Barang
                        </div>

                        <?php
                        foreach ($barang2 as $c) {
                            $brg = $c['nama'];
                            ?>

                            <div class="alert alert-warning alert-dismissible fade show mx-2 my-2" role="alert">
                                Stock <strong><?php echo $brg; ?></strong> telah habis
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>

                        <?php } ?>


                    </script>


                    <div class="modal" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Tambah Barang</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="<?php echo BASEURL; ?>/admin/barang.php" onsubmit="return validateForm()" method="post">
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label" class="form-label" for="nama">Nama Barang</label>
                                            <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama Barang" name="nama" maxlength="25">
                                        </div>


                                        <div class="mb-3">
                                            <label class="form-label" class="form-label" for="id_kategori">Kategori Barang</label>

                                            <select class="form-select" id="id_kategori" name="id_kategori">
                                                <option value="dummy" selected disabled>Pilih kategori barang</option>
                                                <?php foreach ($categories as $c) { ?>
                                                    <option value="<?php echo $c['id_kategori']; ?>"><?php echo $c['nama_kategori']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <small class="text-danger" id="msg"> </small>
                                            <script>
                                                function validateForm() {
                                                    var ddl = document.getElementById("id_kategori");
                                                    var selectedValue = ddl.options[ddl.selectedIndex].value;
                                                    if (selectedValue == "dummy") {
                                                        text = "Pilih kategori barang !";
                                                        document.getElementById("msg").innerHTML = text;
                                                        return false;
                                                    }
                                                }
                                            </script>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" class="form-label" for="harga">Harga Barang</label>
                                            <input type="number" class="form-control" id="harga" placeholder="Masukkan Harga Barang" name="harga" min="1" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" class="form-label" for="jumlah">Jumlah Barang</label>
                                            <input type="number" class="form-control" id="jumlah" placeholder="Masukkan Jumlah Barang" name="jumlah" min="1" required>
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
                                    <th>ID Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori Barang</th>
                                    <th>Harga Barang</th>
                                    <th>Jumlah Barang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($barang as $b) { ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $b['id_barang']; ?></td>
                                        <td><?php echo $b['nama']; ?></td>
                                        <td><?php echo $b['nama_kategori']; ?></td>
                                        <td><?php echo $b['harga_barang']; ?></td>
                                        <td><?php echo $b['jumlah']; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#edit<?php echo $b['id_barang']; ?>">Ubah</button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?php echo $b['id_barang']; ?>">Hapus</button>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>

                                    <!-- model edit -->
                                    <div class="modal fade" id="edit<?php echo $b['id_barang']; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Ubah <?php echo $b['nama']; ?></h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="<?php echo BASEURL; ?>/admin/barang.php" method="post">
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <input type="hidden" name="id_barang" value="<?php echo $b['id_barang']; ?>">
                                                            <label class="form-label" for="nama">Nama Barang</label>
                                                            <input type="text" class="form-control" id="nama" placeholder="Nama Barang" name="nama" value="<?php echo $b['nama']; ?>" maxlength="25">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="nama_kategori">Kategori barang</label>
                                                            <select class="form-select" id="nama_kategori" name="id_kategori">
                                                                <option selected disabled>Pilih kategori barang</option>
                                                                <?php foreach ($categories as $c) { ?>
                                                                    <option value="<?php echo $c['id_kategori']; ?>" <?php echo ($b['nama_kategori'] == $c['nama_kategori']) ? 'selected' : ''; ?>><?php echo $c['nama_kategori']; ?></option>
                                                                <?php } ?>
                                                            </select>

                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="harga">Harga Barang</label>
                                                            <input type="number" class="form-control" id="harga" placeholder="Harga Barang" name="harga" value="<?php echo $b['harga_barang']; ?>" min="1">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="jumlah">Jumlah Barang</label>
                                                            <input type="number" class="form-control" id="jumlah" placeholder="Jumlah Barang" name="jumlah" value="<?php echo $b['jumlah']; ?>" min="1">
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
                                    <div class="modal fade" id="delete<?php echo $b["id_barang"]; ?>">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Hapus</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="<?php echo BASEURL; ?>/admin/barang.php" method="post">
                                                    <div class="modal-body">
                                                        <p>Apakah anda yakin menghapus barang ini ?</p>
                                                        <input type="hidden" name="id_barang" value="<?php echo $b['id_barang']; ?>">
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
        window.setTimeout(function () {
            $(".alert").fadeTo(500, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, 2000);
    </script>



</body>
<?php ob_end_flush(); ?>

</html>