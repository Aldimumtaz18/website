<?php
session_start();
include 'koneksi.php';

// 🔥 WAJIB LOGIN
if(!isset($_SESSION['login'])){
    header("Location: auth/login.php");
    exit;
}

$username = $_SESSION['user'];
$id  = $_GET['id'];
$qty = isset($_GET['qty']) ? $_GET['qty'] : 1;

// cek produk
$data = mysqli_query($conn, "SELECT * FROM produk WHERE id='$id'");
$p = mysqli_fetch_assoc($data);

if(!$p){
    header("Location: index.php");
    exit;
}

// cek cart
$cek = mysqli_query($conn, "SELECT * FROM cart WHERE username='$username' AND id_produk='$id'");

if(mysqli_num_rows($cek) > 0){
    mysqli_query($conn, "UPDATE cart SET qty = qty + $qty 
                         WHERE username='$username' AND id_produk='$id'");
} else {
    mysqli_query($conn, "INSERT INTO cart (username, id_produk, qty)
                         VALUES ('$username','$id','$qty')");
}

header("Location: cart.php");
exit;
?>