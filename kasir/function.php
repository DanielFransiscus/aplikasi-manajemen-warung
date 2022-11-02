<?php
ob_start();

include '../config.php';

date_default_timezone_set('Asia/Jakarta');


if (!isset($_SESSION["login"]) && $_SESSION['id_role'] != 2) {
	header('Location: ' . BASEURL . '/auth/login.php');
	exit;
}


function query($query)
{
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$rows[] = $row;
	}
	return $rows;
}

function setFlash($pesan, $aksi, $tipe)
{
	$_SESSION['flash'] = [
		'pesan' => $pesan,
		'aksi'  => $aksi,
		'tipe'  => $tipe
	];
}


function flash()
{
	if (isset($_SESSION['flash'])) {
		echo '<div class="alert alert-' . $_SESSION['flash']['tipe'] . ' alert-dismissible fade show" role="alert">
		Data <strong>' . $_SESSION['flash']['pesan'] . '</strong> ' . $_SESSION['flash']['aksi'] . '
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>';
		unset($_SESSION['flash']);
	}
}


function setFlash2($pesan, $aksi, $tipe, $saran)
{

	$_SESSION['flash2'] = [
		'pesan' => $pesan,
		'aksi'  => $aksi,
		'tipe'  => $tipe,
		'saran'  => $saran
	];
}


function flash2()
{
	if (isset($_SESSION['flash2'])) {
		echo '<div class="alert alert-' . $_SESSION['flash2']['tipe'] . ' alert-dismissible fade show" role="alert">
		 <strong>' . $_SESSION['flash2']['pesan'] . '</strong> ' . $_SESSION['flash2']['aksi'] . $_SESSION['flash2']['saran'] . '
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>';
		unset($_SESSION['flash2']);
	}
}


function hapusTransaksi($data)
{
	global $conn;
	$id = $data["id_transaksi"];
	mysqli_query($conn, "DELETE FROM transaksi WHERE id_transaksi = $id");
	return mysqli_affected_rows($conn);
}
