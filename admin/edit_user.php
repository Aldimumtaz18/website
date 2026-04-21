<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];
$u = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='$id'"));

if(isset($_POST['update'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    mysqli_query($conn, "
        UPDATE users 
        SET username='$username', password='$password', role='$role'
        WHERE id='$id'
    ");

    header("Location: user.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit User</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background:#f8f9fa;
    font-family:'Segoe UI';
}

.card-box {
    background:white;
    border-radius:12px;
    padding:25px;
    border:1px solid #eee;
}
</style>

</head>

<body>

<div class="container mt-5">

<div class="card-box">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">✏️ Edit User</h5>
    <a href="user.php" class="btn btn-outline-dark btn-sm">← Kembali</a>
</div>

<hr>

<form method="POST">

<input type="text" name="username" class="form-control mb-3" 
value="<?= $u['username']; ?>" required>

<input type="text" name="password" class="form-control mb-3" 
value="<?= $u['password']; ?>" required>

<select name="role" class="form-control mb-3">
<option value="pelanggan" <?= $u['role']=='pelanggan'?'selected':'' ?>>
Pelanggan
</option>

<option value="admin" <?= $u['role']=='admin'?'selected':'' ?>>
Admin
</option>
</select>

<button name="update" class="btn btn-dark w-100">
Simpan Perubahan
</button>

</form>

</div>

</div>

</body>
</html>