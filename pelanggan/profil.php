<?php
session_start();
include '../koneksi.php';

// 🔥 WAJIB LOGIN
if(!isset($_SESSION['login'])){
    header("Location: ../auth/login.php");
    exit;
}

$username = $_SESSION['user'];

// AMBIL DATA USER
$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$user = mysqli_fetch_assoc($query);

// SIMPAN UPDATE
if(isset($_POST['simpan'])){
    $email   = $_POST['email'];
    $no_hp   = $_POST['no_hp'];
    $alamat  = $_POST['alamat'];

    mysqli_query($conn, "UPDATE users SET 
        email='$email',
        no_hp='$no_hp',
        alamat='$alamat'
        WHERE username='$username'
    ");

    header("Location: profil.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Profil Saya</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #f8f9fa;
    font-family: 'Segoe UI', sans-serif;
}

.profile-box {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
}

.profile-header {
    border-bottom: 1px solid #eee;
    margin-bottom: 20px;
    padding-bottom: 10px;
}

.form-control {
    border-radius: 10px;
}

.btn-save {
    background: #111;
    color: white;
    border-radius: 10px;
}

.btn-save:hover {
    background: #333;
}
</style>

</head>

<body>

<div class="container mt-5">

<div class="profile-box">

    <!-- HEADER -->
    <div class="profile-header d-flex justify-content-between">
        <h5>👤 Profil Saya</h5>
        <a href="dashboard_pelanggan.php" class="btn btn-outline-dark btn-sm">← Kembali</a>
    </div>

    <form method="POST">

        <!-- USERNAME -->
        <div class="mb-3">
            <label>Username</label>
            <input type="text" class="form-control" 
                   value="<?php echo $user['username']; ?>" disabled>
        </div>

        <!-- EMAIL -->
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" 
                   value="<?php echo $user['email'] ?? ''; ?>">
        </div>

        <!-- NO HP -->
        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="no_hp" class="form-control" 
                   value="<?php echo $user['no_hp'] ?? ''; ?>">
        </div>

        <!-- ALAMAT -->
        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" rows="3"><?php echo $user['alamat'] ?? ''; ?></textarea>
        </div>

        <button name="simpan" class="btn btn-save w-100">
            💾 Simpan Perubahan
        </button>

    </form>

</div>

</div>

</body>
</html>