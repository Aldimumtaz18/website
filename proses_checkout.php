<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['login'])){
    header("Location: auth/login.php");
    exit;
}

$username = $_SESSION['user'];
$nama     = $_POST['nama'];
$hp       = $_POST['hp'];
$alamat   = $_POST['alamat'];
$metode   = $_POST['metode'];

$total = 0;

// ambil cart
$data = mysqli_query($conn, "
    SELECT c.*, p.nama, p.harga 
    FROM cart c
    JOIN produk p ON c.id_produk = p.id
    WHERE c.username='$username'
");

// hitung total
while($d = mysqli_fetch_assoc($data)){
    $total += $d['harga'] * $d['qty'];
}

// simpan pesanan
mysqli_query($conn, "
    INSERT INTO pesanan 
    (username, total, tanggal, status, nama, hp, alamat, metode)
    VALUES 
    ('$username','$total',NOW(),'Menunggu Pembayaran',
     '$nama','$hp','$alamat','$metode')
");

$id_pesanan = mysqli_insert_id($conn);

// simpan detail
$data = mysqli_query($conn, "
    SELECT c.*, p.nama, p.harga 
    FROM cart c
    JOIN produk p ON c.id_produk = p.id
    WHERE c.username='$username'
");

while($d = mysqli_fetch_assoc($data)){
    $subtotal = $d['harga'] * $d['qty'];

    mysqli_query($conn, "
        INSERT INTO detail_pesanan 
        (id_pesanan, nama_produk, harga, qty, subtotal)
        VALUES 
        ('$id_pesanan','".$d['nama']."','".$d['harga']."','".$d['qty']."','$subtotal')
    ");
}

// hapus cart
mysqli_query($conn, "DELETE FROM cart WHERE username='$username'");

// 👉 arahkan ke pembayaran
header("Location: pembayaran.php?id=$id_pesanan");
exit;