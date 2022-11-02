<?php


session_start();
include './function.php';


$barang = query("SELECT * FROM barang order by id_barang ASC");

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=list_barang.xls");

?>


<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Daftar Barang</title>
	<link rel="stylesheet" href="">
</head>


<style>
	table {
		width: 50%;
		
	}
</style>

<body>
	<h2>Daftar Barang</h2>
	<table border="2">

		<tr>
			<th align="left">No</th>
			<th align="left">ID Barang</th>
			<th align="left">Nama Barang</th>
			<th align="left">Harga Barang</th>
			<th align="left">Jumlah Barang</th>

		</tr>


		<?php $i = 1; ?>
		<?php foreach ($barang as $b) { ?>
			<tr>
				<td align="left"><?php echo $i; ?></td>
				<td align="left"><?php echo $b['id_barang']; ?></td>
				<td align="left"><?php echo $b['nama']; ?></td>
				<td align="left"><?php echo $b['harga_barang']; ?></td>
				<td align="left"><?php echo $b['jumlah']; ?></td>


			</tr>
			<?php $i++; ?>
		<?php } ?>

	</table>

</body>

</html>