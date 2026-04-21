<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['login'])){
    header("Location: auth/login.php");
    exit;
}

$username = $_SESSION['user'];
$total = 0;

$data = mysqli_query($conn, "
    SELECT c.qty, p.nama, p.harga, p.gambar 
    FROM cart c
    JOIN produk p ON c.id_produk = p.id
    WHERE c.username='$username'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background:#f5f6fa;
    font-family:'Segoe UI';
}

.box {
    background:white;
    border-radius:15px;
    padding:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

.product-img {
    width:50px;
    height:50px;
    object-fit:contain;
}
</style>

</head>

<body>

<div class="container mt-5">

<h4 class="mb-4">🧾 Checkout</h4>

<form action="proses_checkout.php" method="POST">

<div class="row">

<!-- ALAMAT -->
<div class="col-md-6">
<div class="box mb-3">

<h6>📍 Alamat Pengiriman</h6>

<input type="text" name="nama" class="form-control mb-2" placeholder="Nama lengkap" required>
<input type="text" name="hp" class="form-control mb-2" placeholder="No HP" required>
<textarea name="alamat" class="form-control mb-3" placeholder="Alamat lengkap" required></textarea>

<h6>💳 Metode Pembayaran</h6>

<div class="form-check">
  <input class="form-check-input" type="radio" name="metode" value="COD" required>
  <label class="form-check-label">Bayar di Tempat (COD)</label>
</div>

<div class="form-check">
  <input class="form-check-input" type="radio" name="metode" value="Transfer">
  <label class="form-check-label">Transfer Bank</label>
</div>

<div class="form-check">
  <input class="form-check-input" type="radio" name="metode" value="E-Wallet">
  <label class="form-check-label">E-Wallet (OVO/DANA/GoPay)</label>
</div>

</div>
</div>

<!-- RINGKASAN -->
<div class="col-md-6">
<div class="box">

<h6>🛒 Ringkasan Pesanan</h6>

<table class="table">

<?php while($item = mysqli_fetch_assoc($data)){ 
    $subtotal = $item['harga'] * $item['qty'];
    $total += $subtotal;
?>

<tr>
<td>
    <img src="assets/images/<?php echo $item['gambar']; ?>" class="product-img">
    <?php echo $item['nama']; ?>
</td>
<td>x<?php echo $item['qty']; ?></td>
<td>Rp <?php echo number_format($subtotal); ?></td>
</tr>

<?php } ?>

<tr>
<td colspan="2"><b>Total</b></td>
<td><b>Rp <?php echo number_format($total); ?></b></td>
</tr>

</table>

<button class="btn btn-success w-100">
    Bayar Sekarang
</button>

</div>
</div>

</div>

</form>

</div>

</body>
</html>