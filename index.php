<?php 
session_start();
include 'koneksi.php';

$keyword = isset($_GET['cari']) ? $_GET['cari'] : '';
$query = "SELECT * FROM produk WHERE nama LIKE '%$keyword%'";
$data = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Putra RI</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

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

/* LOGO */
.logo {
    font-weight: 600;
}

.logo-img {
    width: 35px;
    height: 35px;
    object-fit: contain;
}

/* SEARCH */
.search-box {
    border-radius: 20px;
    border: 1px solid #ddd;
}

/* SLIDER */
.slider-img {
    height: 260px;
    object-fit: cover;
    border-radius: 12px;
}

/* TEXT SLIDER */
.slider-caption {
    position: absolute;
    top: 50%;
    left: 40px;
    transform: translateY(-50%);
    color: white;
    max-width: 400px;
    z-index: 2;
}

.slider-caption h4 {
    font-weight: bold;
}

.slider-caption p {
    font-size: 14px;
}

.slider-caption .btn {
    border-radius: 20px;
}

/* overlay */
.carousel-item::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.4);
    border-radius: 12px;
    z-index: 1;
}

/* CARD */
.card {
    border: 1px solid #eee;
    border-radius: 12px;
    transition: 0.2s;
}

.card:hover {
    transform: translateY(-3px);
}

.card img {
    height: 120px;
    object-fit: contain;
}

/* BUTTON */
.btn-cart {
    background: #111;
    color: white;
    border-radius: 8px;
}

.btn-cart:hover {
    background: #333;
}

/* MENU */
.menu {
    font-size: 14px;
    color: #777;
}

/* MOBILE */
@media (max-width: 768px){
    .slider-img {
        height: 160px;
    }
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="topbar">
    <div class="container d-flex justify-content-between align-items-center">

        <div class="logo d-flex align-items-center gap-2">
            <img src="assets/images/logo.jpg" class="logo-img">
            <span>Toko Bangunan Putra RI</span>
        </div>

        <form method="GET" class="w-50">
            <input type="text" name="cari" 
                   class="form-control search-box"
                   placeholder="Cari produk..."
                   value="<?php echo $keyword; ?>">
        </form>

        <div class="d-flex align-items-center gap-3">

            <?php if(isset($_SESSION['login'])) { ?>
                <small>Hi, <?php echo $_SESSION['user']; ?></small>
            <?php } ?>

            <button class="btn" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
                <i class="bi bi-list fs-4"></i>
            </button>

        </div>

    </div>
</div>

<!-- 🔥 SLIDER -->
<div class="container mt-3">

<div id="carouselBanner" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">

    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselBanner" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#carouselBanner" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#carouselBanner" data-bs-slide-to="2"></button>
    </div>

    <div class="carousel-inner rounded shadow-sm">

        <div class="carousel-item active">
            <img src="assets/images/slide1.jpg" class="d-block w-100 slider-img">

            <div class="slider-caption">
                <h4>Promo Material Bangunan</h4>
                <p>Dapatkan harga terbaik untuk kebutuhan proyek kamu</p>
                <a href="#produk" class="btn btn-light btn-sm">Belanja Sekarang</a>
            </div>
        </div>

        <div class="carousel-item">
            <img src="assets/images/slide2.jpg" class="d-block w-100 slider-img">

            <div class="slider-caption">
                <h4>Diskon Cat & Semen</h4>
                <p>Kualitas terbaik dengan harga hemat</p>
                <a href="#produk" class="btn btn-light btn-sm">Lihat Produk</a>
            </div>
        </div>

        <div class="carousel-item">
            <img src="assets/images/slide3.jpg" class="d-block w-100 slider-img">

            <div class="slider-caption">
                <h4>Lengkap & Terpercaya</h4>
                <p>Semua kebutuhan bangunan ada di sini</p>
                <a href="#produk" class="btn btn-light btn-sm">Mulai Belanja</a>
            </div>
        </div>

    </div>

</div>

</div>

<!-- SIDEBAR -->
<div class="offcanvas offcanvas-end" id="sidebarMenu">
    <div class="offcanvas-header">
        <h6 class="fw-bold">Menu</h6>
        <button class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

        <?php if(isset($_SESSION['login'])) { ?>

            <p class="small text-muted">Login sebagai</p>
            <h6><?php echo $_SESSION['user']; ?></h6>

            <hr>

            <a href="pelanggan/dashboard_pelanggan.php" class="d-block mb-2">Dashboard</a>
            <a href="cart.php" class="d-block mb-2">Keranjang</a>
            <a href="pelanggan/pesanan.php" class="d-block mb-2">Pesanan</a>

            <?php if($_SESSION['role'] == 'admin'){ ?>
                <a href="admin/dashboard_admin.php" class="d-block mb-2 text-danger">Admin Panel</a>
            <?php } ?>

            <hr>

            <a href="auth/logout.php" class="text-danger">Logout</a>

        <?php } else { ?>

            <a href="auth/login.php" class="btn btn-dark w-100 mb-2">Login</a>
            <a href="auth/register.php" class="btn btn-outline-dark w-100">Daftar</a>

        <?php } ?>

    </div>
</div>

<div class="container mt-4">

    <div class="menu d-flex gap-3 mb-3">
        <span>Semua</span>
        <span>Promo</span>
        <span>Terlaris</span>
        <span>Terbaru</span>
    </div>

    <!-- PRODUK -->
    <div class="row" id="produk">

    <?php while($p = mysqli_fetch_assoc($data)) { ?>

        <div class="col-md-3 col-6 mb-4">
            <div class="card p-3 text-center">

                <img src="assets/images/<?php echo $p['gambar']; ?>"
                     onerror="this.src='assets/images/default.png'">

                <h6 class="mt-2"><?php echo $p['nama']; ?></h6>

                <p class="fw-semibold">
                    Rp <?php echo number_format($p['harga']); ?>
                </p>

                <a href="tambah.php?id=<?php echo $p['id']; ?>" 
                   class="btn btn-cart btn-sm">
                    + Keranjang
                </a>

            </div>
        </div>

    <?php } ?>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>