<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];

$p = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT * FROM pesanan WHERE id='$id'
"));

$detail = mysqli_query($conn, "
    SELECT d.*, pr.nama, pr.gambar 
    FROM detail_pesanan d
    JOIN produk pr ON d.id_produk = pr.id
    WHERE d.id_pesanan='$id'
");

// 🔥 UPDATE STATUS
if(isset($_POST['status'])){
    $status = $_POST['status'];

    mysqli_query($conn, "
        UPDATE pesanan SET status='$status'
        WHERE id='$id'
    ");

    header("Location: detail_pesanan.php?id=$id");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Detail Pesanan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background:#f5f6fa; font-family:'Segoe UI'; }

.box {
    background:white;
    border-radius:12px;
    padding:20px;
    border:1px solid #eee;
}

.img {
    width:50px;
    height:50px;
    object-fit:contain;
}
</style>
</head>

<body>

<div class="container mt-4">
<div class="box">

<div class="d-flex justify-content-between mb-3">
    <h5>Detail Pesanan #<?php echo $p['id']; ?></h5>
    <a href="pesanan.php" class="btn btn-outline-dark btn-sm">← Kembali</a>
</div>

<p><b>User:</b> <?php echo $p['username']; ?></p>
<p><b>Total:</b> Rp <?php echo number_format($p['total']); ?></p>
<p><b>Metode:</b> <?php echo $p['metode']; ?></p>
<p><b>Status:</b> <?php echo $p['status']; ?></p>

<hr>

<h6>Produk</h6>

<table class="table">
<tr>
<th>Produk</th>
<th>Qty</th>
<th>Harga</th>
</tr>

<?php while($d = mysqli_fetch_assoc($detail)){ ?>

<tr>
<td>
<div class="d-flex align-items-center gap-2">
<img src="../assets/images/<?php echo $d['gambar']; ?>" class="img">
<?php echo $d['nama']; ?>
</div>
</td>

<td><?php echo $d['qty']; ?></td>
<td>Rp <?php echo number_format($d['harga']); ?></td>
</tr>

<?php } ?>

</table>

<hr>

<!-- 🔥 BUKTI TRANSFER -->
<?php if(!empty($p['bukti'])){ ?>
<h6>Bukti Transfer</h6>
<img src="../assets/bukti/<?php echo $p['bukti']; ?>" width="200">
<hr>
<?php } ?>

<!-- 🔥 AKSI ADMIN -->
<form method="POST" class="d-flex gap-2">

<button name="status" value="Diproses" class="btn btn-primary btn-sm">
Proses
</button>

<button name="status" value="Dikirim" class="btn btn-success btn-sm">
Kirim
</button>

<button name="status" value="Selesai" class="btn btn-dark btn-sm">
Selesai
</button>

</form>

</div>
</div>

</body>
</html>