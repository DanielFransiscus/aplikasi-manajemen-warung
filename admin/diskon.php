<?php
session_start();

include './function.php';


$disbarang = query("SELECT * FROM disbarang inner join barang ON disbarang.id_barang=barang.id_barang 
	order by id_diskon ASC
	");
$barang = query('SELECT * FROM barang order by id_barang ASC');


if (isset($_POST["insert"])) {
	if (tambahDisbarang($_POST) > 0) {
		setFlash('berhasil', 'ditambahkan', 'success');
		header('Location: ' . BASEURL . '/admin/diskon.php');
		exit;
	} else {
		setFlash('gagal', 'ditambahkan', 'danger');
		header('Location: ' . BASEURL . '/admin/diskon.php');
		exit;
	}
}

if (isset($_POST["update"])) {
	//cek apakah data berhasil di tambahkan atau tidak
	if (ubahDisbarang($_POST) > 0) {
		setFlash('berhasil', 'diubah', 'success');
		header('Location: ' . BASEURL . '/admin/diskon.php');
		exit;
	} else {
		setFlash('gagal', 'diubah', 'danger');
		header('Location: ' . BASEURL . '/admin/diskon.php');
		exit;
	}
}

if (isset($_POST["delete"])) {
	//cek apakah data berhasil di tambahkan atau tidak
	if (hapusDisbarang($_POST) > 0) {
		setFlash('berhasil', 'dihapus', 'success');
		header('Location: ' . BASEURL . '/admin/diskon.php');
		exit;
	} else {
		setFlash('gagal', 'dihapus', 'danger');
		header('Location: ' . BASEURL . '/admin/diskon.php');
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
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Diskon Barang - SIM Warung</title>
	<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet">

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
					<h1 class="mt-4">Diskon Barang</h1>
					<?php flash(); ?>
					<button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#myModal">
						Tambah
					</button>
					<div class="card mb-4">
						<div class="card-header">
							<i class="fas fa-table me-1"></i>
							Data Diskon Barang
						</div>
						<div class="modal" id="myModal">
							<div class="modal-dialog">
								<div class="modal-content">
									<!-- Modal Header -->
									<div class="modal-header">
										<h4 class="modal-title">Tambah Diskon Barang</h4>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<form action="<?php echo BASEURL; ?>/admin/diskon.php" onsubmit="return validateForm()" method="post">
										<!-- Modal body -->
										<div class="modal-body">
											<div class="mb-3">
												<label class="form-label" for="id_barang">Nama Barang</label>
												<select class="form-select" id="id_barang" name="id_barang">
													<option value="dummy" selected disabled>Pilih nama barang</option>
													<?php foreach ($barang as $b) { ?>
														<option value="<?php echo $b['id_barang']; ?>"><?php echo $b['nama']; ?></option>
													<?php } ?>
												</select>
												<small class="text-danger" id="msg"> </small>
												<script>
													function validateForm() {
														var ddl = document.getElementById("id_barang");
														var selectedValue = ddl.options[ddl.selectedIndex].value;
														if (selectedValue == "dummy") {
															text = "Pilih nama barang !";
															document.getElementById("msg").innerHTML = text;
															return false;
														}
													}
												</script>

											</div>
											<div class="mb-3">
												<label class="form-label" for="qty">Jumlah Barang</label>
												<input type="number" class="form-control" id="qty" placeholder="Masukkan jumlah Barang" name="qty" min="1" required>
											</div>
											<div class="mb-3">
												<label class="form-label" for="potongan">Potongan Harga</label>
												<input type="number" class="form-control" id="potongan" placeholder="Masukkan potongan harga" name="potongan" min="1" required>
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
										<th>ID Diskon Barang</th>
										<th>Nama Barang</th>
										<th>Jumlah Barang</th>
										<th>Potongan Harga</th>
										<th>Aksi</th>

									</tr>
								</thead>
								<tbody>
									<?php $i = 1; ?>
									<?php foreach ($disbarang as $d) { ?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $d['id_diskon']; ?></td>
											<td><?php echo $d['nama']; ?></td>
											<td><?php echo $d['qty']; ?></td>
											<td><?php echo $d['potongan']; ?></td>
											<td>
												<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#edit<?php echo $d['id_diskon']; ?>">Ubah</button>
												<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?php echo $d['id_diskon']; ?>">Hapus</button>
											</td>
										</tr>
										<?php $i++; ?>
										<!-- model edit -->
										<div class="modal fade" id="edit<?php echo $d['id_diskon']; ?>">
											<div class="modal-dialog">
												<div class="modal-content">
													<!-- Modal Header -->
													<div class="modal-header">
														<h4 class="modal-title">Ubah <?php echo $d['nama']; ?></h4>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
													<form action="<?php echo BASEURL; ?>/admin/diskon.php" method="post">
														<!-- Modal body -->
														<div class="modal-body">
															<div class="mb-3">
																<input type="hidden" name="id_diskon" value="<?php echo $d['id_diskon']; ?>">
																<label class="form-label" for="nama">Nama Barang</label>
																<select class="form-select" id="nama" name="id_barang">
																	<?php foreach ($barang as $b) { ?>
																		<option value="<?php echo $b['id_barang']; ?>" <?php echo ($d['nama'] == $b['nama']) ? 'selected' : '';  ?>><?php echo $b['nama']; ?></option>
																	<?php } ?>
																</select>
															</div>
															<div class="mb-3">
																<label class="form-label" for="qty">Jumlah Barang</label>
																<input type="number" class="form-control" id="qty" placeholder="Jumlah Barang" name="qty" value="<?php echo $d['qty']; ?>" min="1">
															</div>
															<div class="mb-3">
																<label class="form-label" for="potongan">Potongan</label>
																<input type="number" class="form-control" id="potongan" placeholder="potongan" name="potongan" value="<?php echo $d['potongan']; ?>" min="1">
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
										<div class="modal fade" id="delete<?php echo $d["id_diskon"]; ?>">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Hapus</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
													<form action="<?php echo BASEURL; ?>/admin/diskon.php" method="post">
														<div class="modal-body">
															<p>Apakah anda yakin menghapus potongan harga barang ini ?</p>
															<input type="hidden" name="id_diskon" value="<?php echo $d['id_diskon']; ?>">
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