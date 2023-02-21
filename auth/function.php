<?php
ob_start();
require $_SERVER['DOCUMENT_ROOT'] . '/myapp/config.php';
function registrasi($data)
{
  global $conn;
  global $errors;
  $id_role = $data["id_role"];
  $username = strtolower(stripslashes($data["username"]));
  $password = mysqli_real_escape_string($conn, $data["password"]);
  $password2 = mysqli_real_escape_string($conn, $data["password2"]);

  // cek username sudah ada atau belum
  $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");

  if (mysqli_fetch_assoc($result)) {
    echo "<script>
    alert('Username sudah terdaftar!')
    </script>";
    return false;
  }

  // cek konfirmasi password
  if ($password !== $password2) {
    echo "<script>
    alert('Password konfirmasi tidak sesuai!');
    </script>";
    return false;
  }

  // enkripsi password
  $password = password_hash($password, PASSWORD_DEFAULT);

  // tambahkan userbaru ke database
  mysqli_query($conn, "INSERT INTO users (id_user, id_role, username, password)
		VALUES ('','$id_role', '$username', '$password')");

  return mysqli_affected_rows($conn);
}

function setFlash($pesan, $aksi, $tipe, $saran)
{
  $_SESSION['flash'] = [
    'pesan' => $pesan,
    'aksi' => $aksi,
    'tipe' => $tipe,
    'saran' => $saran
  ];
}

function flash()
{
  if (isset($_SESSION['flash'])) {
    echo '<div class="alert alert-' . $_SESSION['flash']['tipe'] . ' alert-dismissible fade show" role="alert">
		<strong>' . $_SESSION['flash']['pesan'] . '</strong> ' . $_SESSION['flash']['aksi'] . $_SESSION['flash']['saran'] . '
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>';
    unset($_SESSION['flash']);
  }
}
