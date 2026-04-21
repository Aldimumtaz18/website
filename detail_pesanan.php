<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role'] != 'pelanggan'){
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];
$username = $_SESSION['user'];

// ambil pesanan
$pesanan = mysqli_query($conn, "
    SELECT * FROM pesanan 
    WHERE id='$id' AND username='$username'
");

$p = mysqli_fetch_assoc($pesanan);

// ambil detail produk
$detail = mysqli_query($conn, "
    SELECT * FROM detail_pesanan 
    WHERE id_pesanan='$id'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Detail Pesanan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background:#f5f6fa;
    font-family:'Segoe UI';
}

.box {
    background:white;
    border-radius:15px;
    padding:25px;
    box-shadow:0 5px 25px rgba(0,0,0,0.08);
}

.badge-status {
    padding:6px 10px;
    border-radius:8px;
    font-size:12px;
}

.status-menunggu { background:#fff3cd; }
.status-proses { background:#cfe2ff; }
.status-kirim { background:#d1e7dd; }
.status-selesai { background:#e2e3e5; }

.product-img {
    width:50px;
    height:50px;
    object-fit:contain;
}
</style>

</head>

<body>

<div class="container mt-5">
<div class="box">

<div class="d-flex justify-content-between mb-4">
    <h4>📦 Detail Pesanan #<?php echo $p['id']; ?></h4>
    <a href="pesanan.php" class="btn btn-outline-dark btn-sm">← Kembali</a>
</div>

<!-- STATUS -->
<?php
$status_class = "status-menunggu";

if($p['status'] == 'Diproses') $status_class = "status-proses";
elseif($p['status'] == 'Dikirim') $status_class = "status-kirim";
elseif($p['status'] == 'Selesai') $status_class = "status-selesai";
?>

<p>
Status:
<span class="badge-status <?php echo $status_class; ?>">
    <?php echo $p['status']; ?>
</span>
</p>

<hr>

<!-- DATA PENGIRIMAN -->
<h6>📍 Data Pengiriman</h6>
<p>
Nama: <?php echo $p['nama']; ?> <br>
HP: <?php echo $p['hp']; ?> <br>
Alamat: <?php echo $p['alamat']; ?>
</p>

<hr>

<!-- PRODUK -->
<h6>🛒 Produk</h6>

<table class="table">
<tr>
    <th>Produk</th>
    <th>Harga</th>
    <th>Qty</th>
    <th>Total</th>
</tr>

<?php while($d = mysqli_fetch_assoc($detail)){ ?>

<tr>
<td><?php echo $d['nama_produk']; ?></td>
<td>Rp <?php echo number_format($d['harga']); ?></td>
<td><?php echo $d['qty']; ?></td>
<td>Rp <?php echo number_format($d['subtotal']); ?></td>
</tr>

<?php } ?>

<tr>
    <td colspan="3"><b>Total</b></td>
    <td><b>Rp <?php echo number_format($p['total']); ?></b></td>
</tr>

</table>

<hr>

<!-- PEMBAYARAN -->
<h6>💳 Pembayaran</h6>

<p>Metode: <?php echo $p['metode'] ?? '-'; ?></p>

<!-- 🔥 JIKA BELUM BAYAR -->
<?php if($p['status'] == 'Menunggu Pembayaran'){ ?>

<a href="../pembayaran.php?id=<?php echo $p['id']; ?>" 
   class="btn btn-success">
   Bayar Sekarang
</a>

<?php } ?>

<!-- 🔥 JIKA SUDAH UPLOAD -->
<?php if(!empty($p['bukti'])){ ?>

<div class="mt-3">
    <p>Bukti Transfer:</p>
    <img src="../assets/bukti/<?php echo $p['bukti']; ?>" width="200">
</div>

<?php } ?>

</div>
</div>

</body>
</html>