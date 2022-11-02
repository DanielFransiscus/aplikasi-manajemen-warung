<?php
session_start();


include './function.php';

$customers = query("SELECT * FROM pelanggan order by id_pelanggan ASC");


if (isset($_POST["insert"])) {
	if (tambahPelanggan($_POST) > 0) {
		setFlash('berhasil', 'ditambahkan', 'success');
		header('Location: ' . BASEURL . '/admin/pelanggan.php');
		exit();
	} else {
		setFlash('gagal', 'ditambahkan', 'danger');
		header('Location: ' . BASEURL . '/admin/pelanggan.php');
		exit();
	}
}

if (isset($_POST["update"])) {
    //cek apakah data berhasil di tambahkan atau tidak
	if (ubahPelanggan($_POST) > 0) {
		setFlash('berhasil', 'diubah', 'success');
		header('Location: ' . BASEURL . '/admin/pelanggan.php');
		exit();
	} else {
		setFlash('gagal', 'diubah', 'danger');
		header('Location: ' . BASEURL . '/admin/pelanggan.php');
		exit();
	}
}

if (isset($_POST["delete"])) {
    //cek apakah data berhasil di tambahkan atau tidak
	if (hapusPelanggan($_POST) > 0) {
		setFlash('berhasil', 'dihapus', 'success');
		header('Location: ' . BASEURL . '/admin/pelanggan.php');
		exit();
	} else {
		setFlash('gagal', 'dihapus', 'danger');
		header('Location: ' . BASEURL . '/admin/pelanggan.php');
		exit();
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
	<title>Pelanggan - SIM Warung</title>
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
					<h1 class="mt-4">Pelanggan</h1>
					<?php flash(); ?>
					<button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#myModal">
						Tambah
					</button>
					<div class="card mb-4">
						<div class="card-header">
							<i class="fas fa-table me-1"></i>
							Data Pelanggan
						</div>
						<div class="modal" id="myModal">
							<div class="modal-dialog">
								<div class="modal-content">
									<!-- Modal Header -->
									<div class="modal-header">
										<h4 class="modal-title">Tambah Pelanggan</h4>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<form action="<?php echo BASEURL; ?>/admin/pelanggan.php" method="post">
										<!-- Modal body -->
										<div class="modal-body">
											<div class="mb-3">
												<label class="form-label" class="form-label" class="form-label" for="nama">Nama Pelanggan</label>
												<input type="text" class="form-control" id="nama" placeholder="Masukkan nama pelanggan" name="nama" maxlength="25" required>
											</div>
											<div class="mb-3">
												<label class="form-label" class="form-label" class="form-label" for="kontak">Kontak Pelanggan</label>
												<input type="tel" class="form-control" id="kontak" placeholder="Masukkan kontak pelanggan" name="kontak" maxlength="12" required>
											</div>
											<div class="mb-3">
												<label class="form-label" class="form-label" class="form-label" for="email">Email Pelanggan</label>
												<input type="email" class="form-control" id="email" placeholder="Masukkan email pelanggan" name="email" maxlength="35" required>
											</div>
											<div class="mb-3">
												<label class="form-label" class="form-label" class="form-label" for="alamat">Alamat Pelanggan</label>
												<textarea class="form-control" id="alamat" name="alamat" maxlength="75" placeholder="Masukkan alamat pelanggan" rows="3"></textarea>

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
										<th width="10%">No</th>
										<th width="10%">ID Pelanggan</th>
										<th width="10%">Nama Pelanggan</th>
										<th width="10%">Kontak Pelanggan</th>
										<th width="10%">Email Pelanggan</th>
										<th>Alamat Pelanggan</th>
										<th width="15%">Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1; ?>
									<?php foreach ($customers as $b) { ?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $b['id_pelanggan']; ?></td>
											<td><?php echo $b['nama']; ?></td>
											<td>
												<?php echo $b['kontak']; ?>


											</td>
											<td><?php echo $b['email']; ?></td>
											<td>
												<?php echo $b['alamat']; ?>

											</td>
											<td>
												<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#edit<?php echo $b['id_pelanggan']; ?>">Ubah</button>
												<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?php echo $b['id_pelanggan']; ?>">Hapus</button>
											</td>
										</tr>
										<?php $i++; ?>
										<!-- model edit -->
										<div class="modal fade" id="edit<?php echo $b['id_pelanggan']; ?>">
											<div class="modal-dialog">
												<div class="modal-content">
													<!-- Modal Header -->
													<div class="modal-header">
														<h4 class="modal-title">Ubah <?php echo $b['nama']; ?></h4>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
													<form action="<?php echo BASEURL; ?>/admin/pelanggan.php" method="post">
														<!-- Modal body -->
														<div class="modal-body">
															<div class="mb-3">
																<input type="hidden" name="id_pelanggan" value="<?php echo $b['id_pelanggan']; ?>">
																<label class="form-label" class="form-label" class="form-label" for="nama">Nama Pelanggan</label>
																<input type="text" class="form-control" id="nama" placeholder="Masukkan nama pelanggan" name="nama" value="<?php echo $b['nama']; ?>" maxlength="25">
															</div>
															<div class="mb-3">
																<label class="form-label" class="form-label" class="form-label" for="kontak">Kontak Pelanggan</label>
																<input type="tel" class="form-control" id="kontak" placeholder="Masukkan kontak pelanggan" name="kontak" value="<?php echo $b['kontak']; ?>" maxlength="12">
															</div>
															<div class="mb-3">
																<label class="form-label" class="form-label" class="form-label" for="email">Email Pelanggan</label>
																<input type="email" class="form-control" id="email" placeholder="Masukkan email pelanggan" name="email" value="<?php echo $b['email']; ?>" maxlength="35">
															</div>
															<div class="mb-3">
																<label class="form-label" class="form-label" class="form-label" for="alamat">Alamat Pelanggan</label>
																<textarea class="form-control" id="alamat" name="alamat" maxlength="96" placeholder="Masukkan alamat pelanggan" rows="3"><?php echo $b['alamat']; ?> </textarea>
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
										<div class="modal fade" id="delete<?php echo $b["id_pelanggan"]; ?>">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Hapus</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
													<form action="<?php echo BASEURL; ?>/admin/pelanggan.php" method="post">
														<div class="modal-body">
															<p>Apakah anda yakin menghapus pelanggan ini ?</p>
															<input type="hidden" name="id_pelanggan" value="<?php echo $b['id_pelanggan']; ?>">
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
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
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