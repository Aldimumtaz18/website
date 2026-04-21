<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['login'])){
    header("Location: auth/login.php");
    exit;
}

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM cart WHERE id='$id'");

header("Location: cart.php");
exit;
?>