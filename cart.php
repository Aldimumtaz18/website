<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['login'])){
    header("Location: auth/login.php");
    exit;
}

$username = $_SESSION['user'];
$total = 0;

// ambil data cart + produk
$data = mysqli_query($conn, "
    SELECT c.id, c.qty, p.nama, p.harga, p.gambar 
    FROM cart c
    JOIN produk p ON c.id_produk = p.id
    WHERE c.username='$username'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Keranjang</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #f5f6fa;
    font-family: 'Segoe UI';
}

.cart-box {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
}

.product-img {
    width: 50px;
    height: 50px;
    object-fit: contain;
}
</style>

</head>

<body>

<div class="container mt-5">
<div class="cart-box">

<div class="d-flex justify-content-between mb-3">
    <h4>🛒 Keranjang</h4>
    <a href="pelanggan/dashboard_pelanggan.php" class="btn btn-outline-dark btn-sm">
        ← Belanja Lagi
    </a>
</div>

<?php if(mysqli_num_rows($data) == 0){ ?>

<div class="alert alert-warning text-center">
    Keranjang kosong 😢
</div>

<?php } else { ?>

<table class="table align-middle">
<tr>
    <th>Produk</th>
    <th>Harga</th>
    <th>Qty</th>
    <th>Total</th>
    <th>Aksi</th>
</tr>

<?php while($item = mysqli_fetch_assoc($data)){ 
    $subtotal = $item['harga'] * $item['qty'];
    $total += $subtotal;
?>

<tr>
<td>
    <div class="d-flex align-items-center gap-2">
        <img src="assets/images/<?php echo $item['gambar']; ?>" class="product-img">
        <?php echo $item['nama']; ?>
    </div>
</td>

<td>Rp <?php echo number_format($item['harga']); ?></td>
<td><?php echo $item['qty']; ?></td>
<td>Rp <?php echo number_format($subtotal); ?></td>

<td>
    <a href="hapus_cart.php?id=<?php echo $item['id']; ?>" 
       class="btn btn-danger btn-sm">
       Hapus
    </a>
</td>
</tr>

<?php } ?>

<tr>
    <td colspan="3"><b>Total</b></td>
    <td colspan="2"><b>Rp <?php echo number_format($total); ?></b></td>
</tr>

</table>

<a href="checkout.php" class="btn btn-success">Checkout</a>

<?php } ?>

</div>
</div>

</body>
</html>