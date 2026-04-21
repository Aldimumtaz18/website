<?php
include '../koneksi.php';

if(isset($_POST['simpan'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    mysqli_query($conn, "
        INSERT INTO users (username, password, role)
        VALUES ('$username','$password','$role')
    ");

    header("Location: user.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah User</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
<div class="card p-4">

<h5>Tambah User</h5>
<hr>

<form method="POST">

<input type="text" name="username" class="form-control mb-3" placeholder="Username" required>

<input type="text" name="password" class="form-control mb-3" placeholder="Password" required>

<select name="role" class="form-control mb-3">
<option value="pelanggan">Pelanggan</option>
<option value="admin">Admin</option>
</select>

<button name="simpan" class="btn btn-dark w-100">Simpan</button>

</form>

</div>
</div>

</body>
</html>