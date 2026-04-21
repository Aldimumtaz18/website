<?php
include '../koneksi.php';

if(isset($_POST['simpan'])){
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    move_uploaded_file($tmp, "../assets/images/".$gambar);

    mysqli_query($conn, "
        INSERT INTO produk (nama, harga, gambar)
        VALUES ('$nama','$harga','$gambar')
    ");

    header("Location: produk.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah Produk</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
<div class="card p-4">

<h5>Tambah Produk</h5>
<hr>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="nama" class="form-control mb-3" placeholder="Nama Produk" required>

<input type="number" name="harga" class="form-control mb-3" placeholder="Harga" required>

<input type="file" name="gambar" class="form-control mb-3" required>

<button name="simpan" class="btn btn-dark w-100">Simpan</button>

</form>

</div>
</div>

</body>
</html>