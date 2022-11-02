<?php

include 'config.php';

session_start();

if ($_SESSION["login"] != true) {
    session_destroy();
    header('Location: ' . BASEURL . '/auth/login.php');
    exit;
} elseif (isset($_SESSION["login"]) && $_SESSION['id_role'] == 1 && $_SESSION["login"] = true) {
    header('Location: ' . BASEURL . '/admin/dashboard.php');
    exit;
} elseif (isset($_SESSION["login"]) && $_SESSION['id_role'] == 2 && $_SESSION["login"] = true) {
    header('Location: ' . BASEURL . '/kasir/dashboard.php');
    exit;
} else {
    session_destroy();
    exit();
}
?>