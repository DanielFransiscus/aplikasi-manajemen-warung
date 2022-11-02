<?php
session_start();
include './function.php';

$customers = mysqli_query($conn, 'SELECT * FROM pelanggan');
$sum = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        $sum += ($value['harga'] * $value['qty']) - $value['diskon'];
    }
} else {
    $_SESSION['cart'] = [];
}


// transaksi_act
if (isset($_POST['trx'])) {

    $ind_timezone =  date("Y-m-d H:i:s");    
    $bayar = $_POST['bayar'];
    $total = $_POST['total'];
    $total = $_POST['total'];
    $namaku = $_SESSION['nama'];
    $id_user = $_SESSION['id_user'];
    $id_pelanggan = $_POST['id_pelanggan'];
    $kembali = $bayar - $total;

    foreach ($_SESSION['cart'] as $key => $value) {
        $id_barang = $value['id'];
        $nama = $value['nama'];
        $data = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang='$id_barang'");
        $b = mysqli_fetch_assoc($data);
        $stok = $b['jumlah'];
        $jumlah = $value['qty'];
        if ($stok <= 0 && $jumlah >= $stok) {
            echo '<script>alert("Stock tidak mencukupi");window.location="kasir.php"</script>';
            die();
        }
    }

    if ($bayar < $total) {
        echo '<script>alert("Uang pelanggan tidak cukup");  window.history.back();</script>';
    } else {

        $sql = "INSERT INTO transaksi (id_transaksi, id_pelanggan, id_user, tgl_wkt, total, bayar, kembali) VALUES (NULL,'$id_pelanggan','$id_user', '$ind_timezone', '$total', '$bayar', '$kembali')";

        $ins =  mysqli_query($conn, $sql);

        //mendapatkan id transaksi baru
        $id_transaksi = mysqli_insert_id($conn);

        foreach ($_SESSION['cart'] as $key => $value) {
            $id_barang = $value['id'];
            $harga = $value['harga'];
            $qty = $value['qty'];
            $tot = $harga * $qty;
            $disk = $value['diskon'];

            $data = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang='$id_barang'");
            $b = mysqli_fetch_assoc($data);
            $stok = $b['jumlah'];
            $jumlah = $value['qty'];
            $sisa = $stok - $jumlah;
            $sql2 = "INSERT INTO transaksi_detail (id_transaksi_detail, id_transaksi, id_barang, harga, qty, total, diskon) VALUES (NULL, '$id_transaksi', '$id_barang', '$harga', '$qty', '$tot', '$disk')";

            $insert = mysqli_query($conn, $sql2);

            if ($ins && $insert) {  
                //update stok
                mysqli_query($conn, "UPDATE barang SET jumlah='$sisa' WHERE id_barang='$id_barang'");
                $_SESSION['cart'] = [];
                //redirect ke halaman transaksi selesai
                header("location:transaksi_selesai.php?idtrx=" . $id_transaksi);
            } else {
              echo "Error : " . mysqli_error($conn);

          }
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
    <title>Kasir - SIM Warung</title>
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
                    <h1 class="mt-4 mb-4">Kasir</h1>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Barang
                        </div>


                        <div class="card-body">

                            <form method="post" action="keranjang_act.php">
                                <div class="mb-3">
                                    <label class="form-label" for="id_barang">ID Barang</label>
                                    <input type="text" name="id_barang" class="form-control" id="id_barang" placeholder="Masukkan ID Barang" autofocus>
                                </div>
                                <?php flash(); ?>
                            </form>

                            <form method="post" action="keranjang_update.php">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Harga Barang</th>
                                            <th>Jumlah Barang</th>
                                            <th>Sub Total</th>
                                            <th>Stock Saaat Ini</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($_SESSION['cart'])) { ?>

                                            <?php $i = 1; ?>
                                            <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                                                <?php
                                                $idbarang = $value['id'];

                                                $data = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang='$idbarang'");
                                                $b = mysqli_fetch_assoc($data);
                                                $stock = $b['jumlah'];
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>

                                                    <td>
                                                        <?php echo $value['nama']; ?>
                                                        <?php 
                                                        $dsc = mysqli_query($conn, "SELECT * FROM disbarang WHERE id_barang='$idbarang'");
                                                        $e = mysqli_fetch_assoc($dsc);
                                                        ?>

                                                        <?php if ($value['diskon'] > 0 && $value['qty'] >= $e['qty'] ) { ?>
                                                            <br>
                                                            <span class="badge bg-primary">Diskon <?php echo number_format($value['diskon']); ?></span>
                                                        <?php } else {?>
                                                        <?php }?>
                                                    </td>
                                                    <td><?php echo number_format($value['harga']); ?></td>
                                                    <td>
                                                        <input type="number" name="qty[<?php echo $key; ?>]" min="1" max="<?php echo $stock; ?>" value="<?php echo $value['qty']; ?>" class="form-control" id="stock" required>
                                                    </td>
                                                    <td><?php echo number_format(($value['qty'] * $value['harga']) - $value['diskon']); ?></td>
                                                    <td><?php echo $stock; ?></td>
                                                </td>

                                                <td>
                                                    <a href="keranjang_hapus.php?id=<?php echo $value['id']; ?>" class="btn btn-danger">
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <?php $i++; ?>
                                        <?php } ?>
                                    <?php } ?>

                                </tbody>
                            </table>
                            <button type="submit" name="updt" class="btn btn-success">Ubah</button>
                            <a class="btn btn-danger" href="keranjang_reset.php" role="button">Reset</a>
                        </form>

                    </div>
                    <div class="row justify-content-end px-4">
                        <div class="col-md-4 ">


                            <form action="<?php echo BASEURL ?>/kasir/kasir.php" onsubmit="return validateForm()" method="post">
                                <div class="mb-3">
                                    <label class="form-label">Nama Pelanggan</label>
                                    <select class="form-select" id="nama_pelanggan" name="id_pelanggan">
                                        <option value="dummy" selected disabled>Pilih nama pelanggan</option>
                                        <?php foreach ($customers as $b) { ?>
                                            <option value="<?php echo $b['id_pelanggan']; ?>"><?php echo $b['nama']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <small class="text-danger" id="msg"> </small>

                                    <script>
                                        function validateForm() {
                                            var ddl = document.getElementById("nama_pelanggan");
                                            var selectedValue = ddl.options[ddl.selectedIndex].value;

                                            var bayar = document.getElementById("bayar").value;
                                            var total = document.getElementById("total").value;

                                            if (selectedValue == "dummy") {
                                                text = "Pilih nama pelanggan !";
                                                document.getElementById("msg").innerHTML = text;
                                                return false;
                                            }
                                            if (tot<bayar) {
                                                text2 = "Uang tidak cukup";
                                                document.getElementById("msg2").innerHTML = text2;
                                                return false;
                                            }
                                        }
                                    </script>

                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="total">Total</label>
                                    <input type="text" id="total" class="form-control" value="<?php echo number_format($sum); ?>" disabled></input>
                                    <input type="hidden" id="tot" name="total" value="<?php echo $sum ;?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="bayar">Bayar</label>
                                    <input type="text" id="bayar" name="bayar" class="form-control" min="1" required>
                                    <small class="text-danger" id="msg2"> </small>
                                </div>

                                <button type="submit" name="trx" class="btn btn-primary mb-3">Selesai</button>

                            </form>
                        </div>
                    </div>
                </div>
            </main>
            <?php include '../kasir/templates/footer.php'; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../assets/js/scripts.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="../assets/js/datatables-simple-demo.js"></script>







    <script>
        //inisialisasi inputan


        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 2000);
    </script>

</body>
<?php ob_end_flush(); ?>

</html>