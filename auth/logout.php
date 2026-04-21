<?php
session_start();

// hapus semua session
session_unset();
session_destroy();

// arahkan ke halaman utama
header("Location: ../index.php");
exit;
?>