<?php
include '../koneksi.php';

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if($password != $confirm){
        $error = "Password tidak sama!";
    } else {

        $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
        if(mysqli_num_rows($cek) > 0){
            $error = "Username sudah digunakan!";
        } else {

            mysqli_query($conn, "INSERT INTO users (username, password, role)
            VALUES ('$username','$password','pelanggan')");

            header("Location: login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
body {
    background: #f8f9fa;
    font-family: 'Segoe UI', sans-serif;
}

/* BOX */
.register-box {
    width: 320px;
    padding: 30px;
    border-radius: 15px;
    background: white;
    border: 1px solid #eee;
}

/* LOGO */
.logo-img {
    width: 60px;
    height: 60px;
    object-fit: contain;
}

/* INPUT */
.form-control {
    border-radius: 10px;
}

/* BUTTON */
.btn-register {
    background: #111;
    color: white;
    border-radius: 10px;
}

.btn-register:hover {
    background: #333;
}
</style>

</head>

<body>

<div class="container">

    <!-- 🔥 BACK BUTTON -->
    <div class="mt-3">
        <a href="../index.php" class="btn btn-light border">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="d-flex justify-content-center align-items-center" style="height:90vh;">

        <div class="register-box text-center">

            <!-- LOGO -->
            <img src="../assets/images/logo.jpg" class="logo-img mb-2">

            <h5 class="fw-bold">Putra RI</h5>
            <p class="text-muted small mb-3">Buat akun baru</p>

            <?php if(isset($error)){ ?>
                <div class="alert alert-danger py-2"><?php echo $error; ?></div>
            <?php } ?>

            <form method="POST">
                <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
                <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
                <input type="password" name="confirm" class="form-control mb-3" placeholder="Konfirmasi Password" required>

                <button name="register" class="btn btn-register w-100">Daftar</button>
            </form>

            <p class="small mt-3">
                Sudah punya akun? <a href="login.php">Login</a>
            </p>

        </div>

    </div>

</div>

</body>
</html>