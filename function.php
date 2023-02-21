<?php
ob_start();
date_default_timezone_set('Asia/Jakarta');
require $_SERVER['DOCUMENT_ROOT'] . '/myapp/config.php';
$status = $_SESSION['login'] ?? header('Location: ' . BASEURL . '/auth/login');
$id_user = $_SESSION["id_user"] ?? header('Location: ' . BASEURL . '/auth/login');
$username = $_SESSION["username"] ?? header('Location: ' . BASEURL . '/auth/login');
$id_role = $_SESSION['id_role'] ?? header('Location: ' . BASEURL . '/auth/login');
$role = $_SESSION['role'] ?? header('Location: ' . BASEURL . '/auth/login');

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


function tambahBarangMasuk($data)
{
  global $conn;
  $id_barang = htmlspecialchars($data["id_barang"]);
  $jumlah = htmlspecialchars($data["jumlah"]);
  $tgl_msk = htmlspecialchars(date("Y-m-d H:i:s"));

  $query = "INSERT INTO barang_masuk (id_masuk, id_barang, jumlah, tgl_msk) 
	VALUES ('', $id_barang, '$jumlah', '$tgl_msk')";

  return mysqli_query($conn, $query);
}

function tambahBarangKeluar($data)
{
  global $conn;
  $id_barang = htmlspecialchars($data["id_barang"]);
  $jumlah = htmlspecialchars($data["jumlah"]);
  $tgl_keluar = htmlspecialchars(date("Y-m-d H:i:s"));

  $query = "INSERT INTO barang_keluar (id_keluar, id_barang, jumlah, tgl_keluar) 
	VALUES ('', $id_barang, '$jumlah', '$tgl_keluar')";

  return mysqli_query($conn, $query);
}

function tambahBarang($data)
{
  global $conn;

  $nama = htmlspecialchars($data["nama"]);
  $id_kategori = htmlspecialchars($data["id_kategori"]);
  $id_satuan = htmlspecialchars($data["id_satuan"]);
  $harga = htmlspecialchars($data["harga"]);
  $jumlah = htmlspecialchars($data["jumlah"]);

  $query = "INSERT INTO barang (id_barang,id_kategori, id_satuan, nama, harga_barang, stok) 
	VALUES ('', $id_kategori, '$id_satuan', '$nama', '$harga', '$jumlah')";

  return mysqli_query($conn, $query);
}

function ubahBarang($data)
{
  global $conn;

  $id = htmlspecialchars($data["id_barang"]);
  $id_kategori = htmlspecialchars($data["id_kategori"]);
  $id_satuan = htmlspecialchars($data["id_satuan"]);
  $nama = htmlspecialchars($data["nama"]);
  $harga = htmlspecialchars($data["harga"]);
  $jumlah = htmlspecialchars($data["jumlah"]);


  $query = "UPDATE barang SET
	nama = '$nama',
	id_kategori = '$id_kategori',
  id_satuan = '$id_satuan',
	harga_barang = '$harga',
	stok = '$jumlah'
	WHERE id_barang = $id
	";

  return mysqli_query($conn, $query);
}



function ubahProfil($data)
{
  global $conn;

  $id_user = htmlspecialchars($_SESSION["id_user"]);
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

  return mysqli_query($conn, $query);
}


function hapusBarang($data)
{
  global $conn;
  $id = htmlspecialchars($data["id_barang"]);
  return mysqli_query($conn, "DELETE FROM barang WHERE id_barang = $id");
}

function hapusBarangMasuk($data)
{
  global $conn;
  $id = htmlspecialchars($data["id_masuk"]);
  return mysqli_query($conn, "DELETE FROM barang_masuk WHERE id_masuk = $id");
}

function hapusBarangKeluar($data)
{
  global $conn;
  $id = htmlspecialchars($data["id_keluar"]);
  return mysqli_query($conn, "DELETE FROM barang_keluar WHERE id_keluar = $id");
}

function tambahKategori($data)
{
  global $conn;
  $nama_kategori = htmlspecialchars($data["nama_kategori"]);
  $query = "INSERT INTO kategori_barang (id_kategori, nama_kategori) 
	VALUES ('', '$nama_kategori')";
  return mysqli_query($conn, $query);
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
  return mysqli_query($conn, $query);
}

function hapusKategori($data)
{
  global $conn;
  $id = htmlspecialchars($data["id_kategori"]);
  return mysqli_query($conn, "DELETE FROM kategori_barang WHERE id_kategori = $id");
}


function tambahSatuan($data)
{
  global $conn;
  $nama_satuan = htmlspecialchars($data["nama_satuan"]);
  $query = "INSERT INTO satuan (id_satuan, nama_satuan) 
	VALUES ('', '$nama_satuan')";
  return mysqli_query($conn, $query);
}

function ubahSatuan($data)
{
  global $conn;
  $id = htmlspecialchars($data["id_satuan"]);
  $nama_satuan = htmlspecialchars($data["nama_satuan"]);
  $query = "UPDATE satuan SET
	nama_satuan = '$nama_satuan'
	WHERE id_satuan = $id
	";
  return mysqli_query($conn, $query);
}

function hapusSatuan($data)
{
  global $conn;
  $id = htmlspecialchars($data["id_satuan"]);
  return mysqli_query($conn, "DELETE FROM satuan WHERE id_satuan = $id");
}

function tambahDisbarang($data)
{
  global $conn;

  $id_barang = htmlspecialchars($data["id_barang"]);
  $qty = htmlspecialchars($data["qty"]);
  $potongan = htmlspecialchars($data["potongan"]);
  $query = "INSERT INTO disbarang (id_diskon, id_barang, qty, potongan) 
	VALUES ('', '$id_barang', '$qty', '$potongan')";
  return mysqli_query($conn, $query);
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
  return mysqli_query($conn, $query);
}

function hapusDisbarang($data)
{
  global $conn;
  $id = htmlspecialchars($data["id_diskon"]);
  return mysqli_query($conn, "DELETE FROM disbarang WHERE id_diskon = $id");
}

function tambahPelanggan($data)
{
  global $conn;
  $nama = htmlspecialchars($data["nama"]);
  $kontak = htmlspecialchars($data["kontak"]);
  $alamat = htmlspecialchars($data["alamat"]);
  $query = "INSERT INTO pelanggan (id_pelanggan, nama, kontak, alamat) 
	VALUES ('', '$nama', '$kontak', '$alamat')";
  return  mysqli_query($conn, $query);
}

function ubahPelanggan($data)
{
  global $conn;
  $id = htmlspecialchars($data["id_pelanggan"]);
  $nama = htmlspecialchars($data["nama"]);
  $kontak = htmlspecialchars($data["kontak"]);
  $alamat = htmlspecialchars($data["alamat"]);
  $query = "UPDATE pelanggan SET
	nama = '$nama',
	kontak = '$kontak',
	alamat = '$alamat'
	WHERE id_pelanggan = $id
	";
  return mysqli_query($conn, $query);
}

function hapusPelanggan($data)
{
  global $conn;
  $id = htmlspecialchars($data["id_pelanggan"]);
  return mysqli_query($conn, "DELETE FROM pelanggan WHERE id_pelanggan = $id");
}

function hapusTransaksi($data)
{
  global $conn;
  $id = htmlspecialchars($data["id_transaksi"]);
  return mysqli_query($conn, "DELETE FROM transaksi WHERE id_transaksi = $id");
}

function setFlash($pesan, $aksi, $tipe)
{
  $_SESSION['flash'] = [
    'pesan' => $pesan,
    'aksi' => $aksi,
    'tipe' => $tipe
  ];
}

function flash()
{
  if (isset($_SESSION['flash'])) {
    echo '<div class="alert alert-' . $_SESSION['flash']['tipe'] . ' alert-dismissible fade show" role="alert">
		Data <strong>' . $_SESSION['flash']['pesan'] . '</strong> ' . $_SESSION['flash']['aksi'] . '
		</div>';
    unset($_SESSION['flash']);
  }
}
