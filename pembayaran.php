<?php
session_start();
include 'koneksi.php';

$id = $_GET['id'];

$data = mysqli_query($conn, "SELECT * FROM pesanan WHERE id='$id'");
$p = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html>
<head>
<title>Pembayaran</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background:#f5f6fa; font-family:'Segoe UI'; }
.box {
    background:white;
    border-radius:15px;
    padding:25px;
    box-shadow:0 5px 25px rgba(0,0,0,0.1);
}
</style>

</head>

<body>

<div class="container mt-5">
<div class="box">

<h4>💳 Pembayaran</h4>

<p>Total:</p>
<h3 class="text-danger">Rp <?php echo number_format($p['total']); ?></h3>

<hr>

<h6>Transfer ke:</h6>

<div class="mb-3">
    <b>BCA</b><br>
    1234567890<br>
    a.n Putra RI
</div>

<div class="mb-3">
    <b>BRI</b><br>
    9876543210<br>
    a.n Putra RI
</div>

<hr>

<h6>Upload Bukti Transfer</h6>

<form action="upload_bukti.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <input type="file" name="bukti" class="form-control mb-3" required>

    <button class="btn btn-success w-100">
        Kirim Bukti
    </button>
</form>

</div>
</div>

</body>
</html>