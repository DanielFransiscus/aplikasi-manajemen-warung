<?php
ob_start();

include '../config.php';


function registrasi($data) {
	global $conn;
	$nama = strtolower(stripslashes($data["nama"]));
	$id_role = $data["id_role"];
	$username = strtolower(stripslashes($data["username"]));
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // cek username sudah ada atau belum
	$result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

	if (mysqli_fetch_assoc($result)) {
		echo "<script>
		alert('username sudah terdaftar!')
		</script>";
		return false;
	}


    // cek konfirmasi password
	elseif ($password !== $password2) {
		echo "<script>
		alert('konfirmasi password tidak sesuai!');
		</script>";
		return false;
	}

    // enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan userbaru ke database
	mysqli_query($conn, "INSERT INTO user (id_user, id_role, nama_user, username, password)
		VALUES ('','$id_role', '$nama', '$username', '$password')");

	return mysqli_affected_rows($conn);
}




function setFlash($pesan, $aksi, $tipe){
	$_SESSION['flash'] = [
		'pesan' => $pesan,
		'aksi'  => $aksi,
		'tipe'  => $tipe
	];
}


function flash(){
	if(isset($_SESSION['flash'])){
		echo '<div class="alert alert-' . $_SESSION['flash']['tipe'] . ' alert-dismissible fade show" role="alert">
		Data <strong>' . $_SESSION['flash']['pesan'] . '</strong> ' . $_SESSION['flash']['aksi'] . '
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>';
		unset($_SESSION['flash']);
	}
}

?>