<?php
ob_start();

include '../config.php';

date_default_timezone_set('Asia/Jakarta');

if (!isset($_SESSION["login"]) && $_SESSION['id_role'] != 1) {
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

function tambahBarang($data)
{
	global $conn;

	$nama = htmlspecialchars($data["nama"]);
	$id_kategori = htmlspecialchars($data["id_kategori"]);
	$harga = htmlspecialchars($data["harga"]);
	$jumlah = htmlspecialchars($data["jumlah"]);



	$query = "INSERT INTO barang (id_barang,id_kategori, nama, harga_barang, jumlah) 
	VALUES ('', $id_kategori, '$nama', '$harga', '$jumlah')";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function ubahBarang($data)
{
	global $conn;

	$id = htmlspecialchars($data["id_barang"]);
	$id_kategori = htmlspecialchars($data["id_kategori"]);
	$nama = htmlspecialchars($data["nama"]);
	$harga = htmlspecialchars($data["harga"]);
	$jumlah = htmlspecialchars($data["jumlah"]);


	$query = "UPDATE barang SET
	nama = '$nama',
	id_kategori = '$id_kategori',
	harga_barang = '$harga',
	jumlah = '$jumlah'
	WHERE id_barang = $id
	";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}



function ubahProfil($data)
{
	global $conn;

	$id_user =  $_SESSION["id_user"];
	$nama_warung = htmlspecialchars($data["nama_warung"]);
	$alamat = htmlspecialchars($data["alamat"]);
	$kontak = htmlspecialchars($data["kontak"]);

	$query = "UPDATE warung SET
	id_user = '$id_user',
	nama_warung = '$nama_warung',
	alamat = '$alamat',
	kontak = '$kontak'
	WHERE id_warung = 1
	";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}


function hapusBarang($data)
{
	global $conn;
	$id = htmlspecialchars($data["id_barang"]);
	mysqli_query($conn, "DELETE FROM barang WHERE id_barang = $id");
	return mysqli_affected_rows($conn);
}


function tambahKategori($data)
{
	global $conn;

	$nama_kategori = htmlspecialchars($data["nama_kategori"]);


	$query = "INSERT INTO kategori_barang (id_kategori, nama_kategori) 
	VALUES ('', '$nama_kategori')";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function ubahKategori($data)
{
	global $conn;

	$id = htmlspecialchars($data["id_kategori"]);
	$nama_kategori = htmlspecialchars($data["nama_kategori"]);


	$query = "UPDATE kategori_barang SET
	nama_kategori = '$nama_kategori'
	WHERE id_kategori = $id
	";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}


function hapusKategori($data)
{
	global $conn;
	$id = htmlspecialchars($data["id_kategori"]);
	mysqli_query($conn, "DELETE FROM kategori_barang WHERE id_kategori = $id");
	return mysqli_affected_rows($conn);
}





function tambahDisbarang($data)
{
	global $conn;

	$id_barang = htmlspecialchars($data["id_barang"]);
	$qty = htmlspecialchars($data["qty"]);
	$potongan = htmlspecialchars($data["potongan"]);


	$query = "INSERT INTO disbarang (id_diskon, id_barang, qty, potongan) 
	VALUES ('', '$id_barang', '$qty', '$potongan')";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function ubahDisbarang($data)
{
	global $conn;

	$id_diskon = htmlspecialchars($data["id_diskon"]);
	$id_barang = htmlspecialchars($data["id_barang"]);
	$qty = htmlspecialchars($data["qty"]);
	$potongan = htmlspecialchars($data["potongan"]);


	$query = "UPDATE disbarang SET
	id_barang = '$id_barang',
	qty = '$qty ',
	potongan = '$potongan'
	WHERE id_diskon  = $id_diskon 
	";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}


function hapusDisbarang($data)
{
	global $conn;
	$id = htmlspecialchars($data["id_diskon"]);
	mysqli_query($conn, "DELETE FROM disbarang WHERE id_diskon = $id");
	return mysqli_affected_rows($conn);
}



function tambahPelanggan($data)
{
	global $conn;

	$nama = htmlspecialchars($data["nama"]);
	$kontak = htmlspecialchars($data["kontak"]);
	$email = htmlspecialchars($data["email"]);
	$alamat = htmlspecialchars($data["alamat"]);


	$query = "INSERT INTO pelanggan (id_pelanggan, nama, kontak, email, alamat) 
	VALUES ('', '$nama', '$kontak', '$email', '$alamat')";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function ubahPelanggan($data)
{
	global $conn;

	$id = htmlspecialchars($data["id_pelanggan"]);
	$nama = htmlspecialchars($data["nama"]);
	$kontak = htmlspecialchars($data["kontak"]);
	$email = htmlspecialchars($data["email"]);
	$alamat = htmlspecialchars($data["alamat"]);


	$query = "UPDATE pelanggan SET
	nama = '$nama',
	kontak = '$kontak',
	email = '$email',
	alamat = '$alamat'
	WHERE id_pelanggan = $id
	";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function hapusPelanggan($data)
{
	global $conn;
	$id = htmlspecialchars($data["id_pelanggan"]);
	mysqli_query($conn, "DELETE FROM pelanggan WHERE id_pelanggan = $id");
	return mysqli_affected_rows($conn);
}

function hapusTransaksi($data)
{
	global $conn;
	$id = htmlspecialchars($data["id_transaksi"]);
	mysqli_query($conn, "DELETE FROM transaksi WHERE id_transaksi = $id");
	return mysqli_affected_rows($conn);
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

?>