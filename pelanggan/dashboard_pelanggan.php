<?php 
session_start();
include '../koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role'] != 'pelanggan'){
    header("Location: ../auth/login.php");
    exit;
}

$keyword = isset($_GET['cari']) ? $_GET['cari'] : '';
$query = "SELECT * FROM produk WHERE nama LIKE '%$keyword%'";
$data = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Pelanggan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
body { background:#f8f9fa; font-family:'Segoe UI'; }

.topbar {
    background:white;
    padding:12px 0;
    border-bottom:1px solid #eee;
}

.logo-img { width:35px; height:35px; }

.search-box { border-radius:20px; border:1px solid #ddd; }

.card {
    border:1px solid #eee;
    border-radius:12px;
    transition:0.2s;
}
.card:hover { transform:translateY(-3px); }

.card img {
    height:120px;
    object-fit:contain;
}

.btn-cart {
    background:#111;
    color:white;
    border-radius:8px;
}

.menu-item {
    display:flex;
    align-items:center;
    gap:10px;
    padding:10px;
    border-radius:8px;
    text-decoration:none;
    color:#333;
}

.menu-item:hover {
    background:#f1f1f1;
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="topbar">
<div class="container d-flex justify-content-between align-items-center">

<div class="d-flex align-items-center gap-2">
    <img src="../assets/images/logo.jpg" class="logo-img">
    <span class="fw-semibold">Putra RI</span>
</div>

<form method="GET" class="w-50">
    <input type="text" name="cari" class="form-control search-box" placeholder="Cari produk...">
</form>

<div class="d-flex gap-2 align-items-center">
    <small>Hi, <?php echo $_SESSION['user']; ?></small>
    <button class="btn" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
        <i class="bi bi-list fs-4"></i>
    </button>
</div>

</div>
</div>

<!-- SIDEBAR -->
<div class="offcanvas offcanvas-end" id="sidebarMenu">
<div class="offcanvas-header border-bottom">
    <h6>Menu</h6>
    <button class="btn-close" data-bs-dismiss="offcanvas"></button>
</div>

<div class="offcanvas-body">

<div class="mb-3">
    <small class="text-muted">Login sebagai</small>
    <div class="fw-semibold"><?php echo $_SESSION['user']; ?></div>
</div>

<a href="../cart.php" class="menu-item">
    <i class="bi bi-cart"></i> Keranjang
</a>

<a href="pesanan.php" class="menu-item">
    <i class="bi bi-box"></i> Pesanan Saya
</a>

<a href="profil.php" class="menu-item">
    <i class="bi bi-person"></i> Profil
</a>

<hr>

<a href="../auth/logout.php" class="menu-item text-danger">
    <i class="bi bi-box-arrow-right"></i> Logout
</a>

</div>
</div>

<!-- PRODUK -->
<div class="container mt-4">
<div class="row">

<?php while($p = mysqli_fetch_assoc($data)) { ?>

<div class="col-md-3 col-6 mb-4">
    <div class="card p-3 text-center">

        <img src="../assets/images/<?php echo $p['gambar']; ?>">

        <h6 class="mt-2"><?php echo $p['nama']; ?></h6>

        <p class="fw-semibold">
            Rp <?php echo number_format($p['harga']); ?>
        </p>

        <!-- BUTTON -->
        <button class="btn btn-cart btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?php echo $p['id']; ?>">
            + Keranjang
        </button>

    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="modal<?php echo $p['id']; ?>">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content p-3 text-center">

<h6><?php echo $p['nama']; ?></h6>
<p class="text-muted">Rp <?php echo number_format($p['harga']); ?></p>

<form action="../tambah.php" method="GET">

<input type="hidden" name="id" value="<?php echo $p['id']; ?>">

<div class="d-flex justify-content-center gap-3 mb-3">

<button type="button" class="btn btn-outline-dark" onclick="minus(<?php echo $p['id']; ?>)">-</button>

<input type="number" name="qty" id="qty<?php echo $p['id']; ?>" value="1" min="1" class="form-control text-center" style="width:80px;">

<button type="button" class="btn btn-outline-dark" onclick="plus(<?php echo $p['id']; ?>)">+</button>

</div>

<button class="btn btn-dark w-100">Tambah ke Keranjang</button>

</form>

</div>
</div>
</div>

<?php } ?>

</div>
</div>

<script>
function plus(id){
    let el = document.getElementById('qty'+id);
    el.value = parseInt(el.value)+1;
}
function minus(id){
    let el = document.getElementById('qty'+id);
    if(el.value > 1) el.value--;
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>