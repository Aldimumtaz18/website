<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Kelola Produk</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background:#f5f6fa; font-family:'Segoe UI'; }

.box {
    background:white;
    border-radius:12px;
    padding:20px;
    border:1px solid #eee;
}

.img-produk {
    width:55px;
    height:55px;
    object-fit:contain;
}
</style>
</head>

<body>

<div class="container mt-4">

<div class="box">

<div class="d-flex justify-content-between mb-3">
    <h5>📦 Kelola Produk</h5>
    <div>
        <a href="tambah_produk.php" class="btn btn-dark btn-sm">+ Tambah</a>
        <a href="dashboard_admin.php" class="btn btn-outline-dark btn-sm">← Kembali</a>
    </div>
</div>

<table class="table align-middle">
<tr>
<th>Gambar</th>
<th>Nama</th>
<th>Harga</th>
<th></th>
</tr>

<?php while($p = mysqli_fetch_assoc($data)){ ?>

<tr>
<td>
<img src="../assets/images/<?php echo $p['gambar']; ?>" class="img-produk">
</td>

<td><?php echo $p['nama']; ?></td>

<td>Rp <?php echo number_format($p['harga']); ?></td>

<td class="text-end">
<a href="edit_produk.php?id=<?php echo $p['id']; ?>" class="btn btn-sm btn-primary">Edit</a>

<a href="hapus_produk.php?id=<?php echo $p['id']; ?>" 
   class="btn btn-sm btn-danger"
   onclick="return confirm('Yakin hapus?')">
   Hapus
</a>
</td>

</tr>

<?php } ?>

</table>

</div>
</div>

</body>
</html>