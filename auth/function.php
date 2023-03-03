<?php
ob_start();

require '../config.php';


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
    echo '<div class="alert alert-' . $_SESSION['flash']['tipe'] . ' alert-dismissible fade show" role="alert">' . $_SESSION['flash']['pesan'] . $_SESSION['flash']['aksi'] . $_SESSION['flash']['saran'] . '
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>';
    unset($_SESSION['flash']);
  }
}
