<?php

session_start();

include './function.php';



$q1 = mysqli_query($conn, "Select Count(*) as total_brg From barang");
$q = mysqli_fetch_assoc($q1);


$q2 = mysqli_query($conn, "Select Count(*) as total_cst From pelanggan");
$s = mysqli_fetch_assoc($q2);

$q3 = mysqli_query($conn, "Select Count(*) as total_trx From transaksi");
$z = mysqli_fetch_assoc($q3);

$q4 = mysqli_query($conn, "Select Count(*) as total_ctg From kategori_barang");
$r = mysqli_fetch_assoc($q4);

$barang = query("SELECT * FROM barang where jumlah < 5 order by jumlah DESC, id_barang ASC");


$month = date('m');
$year = date('Y');

$top_barang = query("SELECT barang.id_barang, nama, barang.harga_barang, SUM(qty) as qty, MONTH(tgl_wkt) AS bulan  FROM transaksi_detail

INNER JOIN barang ON transaksi_detail.id_barang = barang.id_barang 
INNER JOIN transaksi ON transaksi_detail.id_transaksi = transaksi.id_transaksi 
WHERE MONTH(tgl_wkt) = $month
AND YEAR(tgl_wkt) = $year
GROUP BY nama ORDER BY qty DESC , id_barang ASC LIMIT 5");



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Aplikasi SIM Warung">
    <meta name="author" content="Daniel Fransiscus">
    <title>Dashboard - SIM Warung</title>
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
                    <h1 class="mt-4 mb-4">Dashboard</h1>

                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">
                                    <h3><?php echo $r['total_ctg']; ?></h3>
                                    <h5>Kategori Barang</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <h3><?php echo $q['total_brg']; ?></h3>
                                    <h5>Barang</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-secondary text-white mb-4">
                                <div class="card-body">
                                    <h3><?php echo $s['total_cst']; ?></h3>
                                    <h5>Pelanggan</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">
                                    <h3><?php echo $z['total_trx']; ?></h3>
                                    <h5>Transaksi</h5>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="modal-title">Daftar Stock Barang Kurang Dari 5</h6>
                                </div>
                                <div class="card-body">
                                    <table id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah Barang</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($barang as $b) { ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $b['id_barang']; ?></td>
                                                    <td><?php echo $b['nama']; ?></td>
                                                    <td><?php echo $b['jumlah']; ?></td>
                                                </tr>
                                                <?php $i++; ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="modal-title">Daftar Barang Terlaris Bulan Ini</h6>
                                </div>
                                <div class="card-body">
                                    <table id="my_new_table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Harga Barang</th>
                                                <th>Jumlah Barang</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($top_barang as $t) { ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $t['id_barang']; ?></td>
                                                    <td><?php echo $t['nama']; ?></td>
                                                    <td><?php echo $t['harga_barang']; ?></td>
                                                    <td><?php echo $t['qty']; ?></td>
                                                </tr>
                                                <?php $i++; ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>


                </div>

            </main>
            <?php include '../admin/templates/footer.php'; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../assets/js/scripts.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="../assets/js/datatables-simple-demo.js"></script>



</body>
<?php ob_end_flush(); ?>

</html>