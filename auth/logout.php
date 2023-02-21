<?php
require __DIR__ . '/function.php';
session_start();



$_SESSION = [];
session_unset();
session_destroy();

header('Location: ' . BASEURL . '/auth/login');
