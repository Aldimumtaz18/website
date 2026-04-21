<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit;
}

// HITUNG DATA
$produk = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM produk"));
$pesanan = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pesanan"));
$user = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE role='pelanggan'"));

// GRAFIK
$grafik = mysqli_query($conn, "
    SELECT DATE(tanggal) as tgl, COUNT(*) as jumlah 
    FROM pesanan 
    GROUP BY DATE(tanggal)
    ORDER BY tgl ASC
");

$tanggal = [];
$jumlah = [];

while($g = mysqli_fetch_assoc($grafik)){
    $tanggal[] = $g['tgl'];
    $jumlah[] = $g['jumlah'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard Admin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body {
    background: #f8f9fa;
    font-family: 'Segoe UI', sans-serif;
}

/* HEADER */
.topbar {
    background: white;
    padding: 12px 0;
    border-bottom: 1px solid #eee;
}

.logo {
    width: 35px;
}

/* CARD */
.card-box {
    background: white;
    border-radius: 12px;
    padding: 20px;
    border: 1px solid #eee;
    text-align: center;
    transition: 0.2s;
}

.card-box:hover {
    transform: translateY(-3px);
}

/* MENU */
.menu-box {
    background: white;
    border-radius: 12px;
    padding: 20px;
    border: 1px solid #eee;
    text-align: center;
}

.btn-menu {
    background: #111;
    color: white;
    border-radius: 8px;
}

.btn-menu:hover {
    background: #333;
}

/* CHART */
.chart-box {
    background: white;
    border-radius: 12px;
    padding: 20px;
    border: 1px solid #eee;
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="topbar">
    <div class="container d-flex justify-content-between align-items-center">

        <div class="d-flex align-items-center gap-2">
            <img src="../assets/images/logo.jpg" class="logo">
            <span class="fw-semibold">Admin Panel</span>
        </div>

        <div>
            Hi, <b><?php echo $_SESSION['user']; ?></b> |
            <a href="../auth/logout.php" class="text-danger">Logout</a>
        </div>

    </div>
</div>

<div class="container mt-4">

<!-- 🔥 STATS -->
<div class="row g-3 mb-4">

<div class="col-md-4">
<div class="card-box">
<h6 class="text-muted">Produk</h6>
<h3><?php echo $produk; ?></h3>
</div>
</div>

<div class="col-md-4">
<div class="card-box">
<h6 class="text-muted">Pesanan</h6>
<h3><?php echo $pesanan; ?></h3>
</div>
</div>

<div class="col-md-4">
<div class="card-box">
<h6 class="text-muted">Pelanggan</h6>
<h3><?php echo $user; ?></h3>
</div>
</div>

</div>

<!-- 🔥 MENU -->
<div class="row g-3 mb-4">

<div class="col-md-4">
<div class="menu-box">
<h6>📦 Kelola Produk</h6>
<a href="produk.php" class="btn btn-menu w-100 mt-2">Buka</a>
</div>
</div>

<div class="col-md-4">
<div class="menu-box">
<h6>🧾 Kelola Pesanan</h6>
<a href="pesanan.php" class="btn btn-menu w-100 mt-2">Buka</a>
</div>
</div>

<div class="col-md-4">
<div class="menu-box">
<h6>👤 Data User</h6>
<a href="user.php" class="btn btn-menu w-100 mt-2">Buka</a>
</div>
</div>

</div>

<!-- 🔥 GRAFIK -->
<div class="chart-box">
<h6 class="mb-3">📊 Grafik Pesanan</h6>
<canvas id="chart"></canvas>
</div>

</div>

<script>
new Chart(document.getElementById('chart'), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($tanggal); ?>,
        datasets: [{
            label: 'Jumlah Pesanan',
            data: <?php echo json_encode($jumlah); ?>,
            borderWidth: 2,
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        responsive: true
    }
});
</script>

</body>
</html>