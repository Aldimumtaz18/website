<?php
$conn = mysqli_connect("localhost", "root", "", "toko_bangunan_putra_ri");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>