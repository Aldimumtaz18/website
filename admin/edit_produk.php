<?php
include '../koneksi.php';

$id = $_GET['id'];
$p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM produk WHERE id='$id'"));

if(isset($_POST['update'])){
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];

    if($_FILES['gambar']['name'] != ""){
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];

        move_uploaded_file($tmp, "../assets/images/".$gambar);

        mysqli_query($conn, "
            UPDATE produk SET nama='$nama', harga='$harga', gambar='$gambar'
            WHERE id='$id'
        ");
    } else {
        mysqli_query($conn, "
            UPDATE produk SET nama='$nama', harga='$harga'
            WHERE id='$id'
        ");
    }

    header("Location: produk.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Produk</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
<div class="card p-4">

<h5>Edit Produk</h5>
<hr>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="nama" class="form-control mb-3" value="<?php echo $p['nama']; ?>">

<input type="number" name="harga" class="form-control mb-3" value="<?php echo $p['harga']; ?>">

<input type="file" name="gambar" class="form-control mb-3">

<button name="update" class="btn btn-dark w-100">Update</button>

</form>

</div>
</div>

</body>
</html>