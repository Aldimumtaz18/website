<?php
include 'koneksi.php';

$id = $_POST['id'];

$file = $_FILES['bukti']['name'];
$tmp  = $_FILES['bukti']['tmp_name'];

$folder = "assets/bukti/";

// buat folder kalau belum ada
if(!is_dir($folder)){
    mkdir($folder, 0777, true);
}

move_uploaded_file($tmp, $folder.$file);

// update pesanan
mysqli_query($conn, "
    UPDATE pesanan 
    SET bukti='$file', status='Menunggu Verifikasi'
    WHERE id='$id'
");

// arahkan ke pesanan pelanggan
header("Location: pelanggan/pesanan.php");
exit;