<?php
include '../koneksi.php';

$id = $_GET['id'];
$status = $_GET['status'];

mysqli_query($conn, "UPDATE pesanan SET status='$status' WHERE id='$id'");