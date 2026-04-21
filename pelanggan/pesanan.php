<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role'] != 'pelanggan'){
    header("Location: ../auth/login.php");
    exit;
}

$username = $_SESSION['user'];

$data = mysqli_query($conn, "
    SELECT * FROM pesanan 
    WHERE username='$username'
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Pesanan Saya</title>

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
</style>

</head>

<body>

<div class="container mt-5">
<div class="box">

<div class="d-flex justify-content-between mb-4">
    <h4>📦 Pesanan Saya</h4>
    <a href="dashboard_pelanggan.php" class="btn btn-outline-dark btn-sm">
        ← Kembali
    </a>
</div>

<?php if(mysqli_num_rows($data) == 0){ ?>

<div class="alert alert-warning text-center">
    Belum ada pesanan 😢
</div>

<?php } else { ?>

<table class="table align-middle">
<thead>
<tr>
    <th>ID</th>
    <th>Total</th>
    <th>Status</th>
    <th>Tanggal</th>
    <th></th>
</tr>
</thead>

<tbody>

<?php while($p = mysqli_fetch_assoc($data)){ 

$status_class = "status-menunggu";

if($p['status'] == 'Diproses') $status_class = "status-proses";
elseif($p['status'] == 'Dikirim') $status_class = "status-kirim";
elseif($p['status'] == 'Selesai') $status_class = "status-selesai";

?>

<tr>
<td>#<?php echo $p['id']; ?></td>
<td>Rp <?php echo number_format($p['total']); ?></td>

<td>
    <span class="badge-status <?php echo $status_class; ?>">
        <?php echo $p['status']; ?>
    </span>
</td>

<td><?php echo $p['tanggal']; ?></td>

<td>
    <button class="btn btn-dark btn-sm"
        data-bs-toggle="modal"
        data-bs-target="#modal<?php echo $p['id']; ?>">
        Detail
    </button>
</td>
</tr>

<?php } ?>

</tbody>
</table>

<?php } ?>

</div>
</div>

<!-- 🔥 MODAL DETAIL (DI LUAR TABLE) -->
<?php 
mysqli_data_seek($data, 0); // reset loop

while($p = mysqli_fetch_assoc($data)){ 

$id_pesanan = $p['id'];

$detail = mysqli_query($conn, "
    SELECT * FROM detail_pesanan 
    WHERE id_pesanan='$id_pesanan'
");
?>

<div class="modal fade" id="modal<?php echo $p['id']; ?>">
<div class="modal-dialog modal-lg">
<div class="modal-content p-3">

<h5>Detail Pesanan #<?php echo $p['id']; ?></h5>
<hr>

<p>
<b>Nama:</b> <?php echo $p['nama']; ?><br>
<b>HP:</b> <?php echo $p['hp']; ?><br>
<b>Alamat:</b> <?php echo $p['alamat']; ?>
</p>

<hr>

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

</table>

<p><b>Total:</b> Rp <?php echo number_format($p['total']); ?></p>
<p><b>Metode:</b> <?php echo $p['metode']; ?></p>

<button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>

</div>
</div>
</div>

<?php } ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>