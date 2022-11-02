<?php
session_start();
include './function.php';



if(isset($_GET['idtrx'])){
	$id_trx = $_GET['idtrx'];

	$data = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi='$id_trx'");
	$trx = mysqli_fetch_assoc($data);

	$detail = mysqli_query($conn, "SELECT * FROM transaksi_detail INNER JOIN barang ON transaksi_detail.id_barang = barang.id_barang WHERE transaksi_detail.id_transaksi = '$id_trx'");

	$q1 = mysqli_query($conn, "Select * from warung where id_warung=1");
	$q = mysqli_fetch_assoc($q1);

}
?>


<!DOCTYPE html>
<html>

<head>
	<title>Kasir Selesai</title>
	<style type="text/css">
		body {
			color: #a7a7a7;
		}

		@media print {

			#printPageButton,
			#back {
				display: none;
			}
		}

		div {
			font-size: 19px;
		}
	</style>
</head>

<body>
	<button id="back" type="button" onclick="window.location.href = 'transaksi.php'">Kembali</button>
	<button id="printPageButton" type="button" onclick="window.print();">Cetak</button>
	<div align="center">

		<header> 
			<!-- /header -->
			<h3>Warung <?php echo $q['nama_warung']; ?> <br>
				<?php echo $q['alamat']; ?><br>
			</h3>
		</header>

		<table width="500" border="0" cellpadding="1" cellspacing="0">

			<tr align="center">
				<td>
					<hr>
				</td>
			</tr>

			<?php
			$idusr =  $trx['id_user'];
			$sql = "SELECT * FROM user WHERE id_user= $idusr";
			$petugas = mysqli_query($conn, $sql);
			$ptg = mysqli_fetch_assoc($petugas);
			?>

			<tr>
				<td>Tanggal dan Waktu : <?php echo $trx['tgl_wkt']; ?></td>
			</tr>
			<tr>
				<td>ID Transaksi : <?php echo $trx['id_transaksi']; ?></td>
			</tr>
			<tr>
				<td>Nama Petugas : <?php echo $ptg['nama_user']; ?></td>
			</tr>
			<tr>	
				<?php 	

				$id_pelanggan = $trx['id_pelanggan'];

				$cst = "SELECT * FROM pelanggan where id_pelanggan = $id_pelanggan";
				$p = mysqli_query($conn, $cst );
				$pg = mysqli_fetch_assoc($p);

				?>
				<tr>
					<td>Nama Pelangggan : <?php echo $pg['nama']; ?></td>
				</tr>


				<td>
					<hr>
				</td>
			</tr>
		</table>
		<table width="500" border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td valign="top" align="left">Nama</td>
				<td valign="top" align="left">Jumlah</td>
				<td valign="top" align="left">Harga</td>
				<td valign="top" align="right">Sub Total</td>
			</tr>
			<?php while ($row = mysqli_fetch_array($detail)) { ?>
				<tr>
					<td valign="top" align="left">
						<?php echo $row['nama']; ?>
						<?php if ($row['diskon'] > 0) { ?>
							<br>
							<small align>Diskon</small>
						<?php } ?>
					</td>
					<td valign="top" align="left"><?php echo $row['qty']; ?></td>
					<td valign="top" align="left"><?php echo "Rp " . number_format($row['harga_barang'], 2, ',', '.'); ?></td>
					<td valign="top" align="right">
						<?php echo "Rp " . number_format($row['total'], 2, ',', '.'); ?>
						<?php if ($row['diskon'] > 0) { ?>
							<br>
							<small>-<?php echo "Rp " . number_format($row['diskon'], 2, ',', '.'); ?></small>
						<?php } ?>
					</td>
				</tr>
			<?php } ?>
			<tr>
				<td colspan="4">
					<hr>
				</td>
			</tr>
			<tr>
				<td align="right" colspan="3">Total</td>
				<td align="right"><?php echo "Rp " . number_format($trx['total'], 2, ',', '.'); ?></td>
			</tr>
			<tr>
				<td align="right" colspan="3">Bayar</td>
				<td align="right"><?php echo "Rp " . number_format($trx['bayar'], 2, ',', '.'); ?></td>
			</tr>
			<tr>
				<td align="right" colspan="3">Kembali</td>
				<td align="right"><?php echo "Rp " . number_format($trx['kembali'], 2, ',', '.'); ?></td>
			</tr>
		</table>
		<br><br>
		<footer>
			<div>
				Terima Kasih Selamat Berbelanja
			</div>
			<div>
				Info dan Layanan Konsumen
			</div>
			<div>
				<?php echo $q['kontak']; ?>
			</div>
		</footer>
	</div>

</body>

</html>