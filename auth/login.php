<?php
session_start();
include '../koneksi.php';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    $data = mysqli_fetch_assoc($query);

    if($data){
        if($password == $data['password']){

            $_SESSION['login'] = true;
            $_SESSION['user'] = $data['username'];
            $_SESSION['role'] = $data['role'];

            if($data['role'] == 'admin'){
                header("Location: ../admin/dashboard_admin.php");
            } else {
                header("Location: ../pelanggan/dashboard_pelanggan.php");
            }
            exit;

        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
body {
    background: #f8f9fa;
    font-family: 'Segoe UI', sans-serif;
}

/* BOX */
.login-box {
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
.btn-login {
    background: #111;
    color: white;
    border-radius: 10px;
}

.btn-login:hover {
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

        <div class="login-box text-center">

            <!-- LOGO -->
            <img src="../assets/images/logo.jpg" class="logo-img mb-2">

            <h5 class="fw-bold">Putra RI</h5>
            <p class="text-muted small mb-3">Masuk ke akun kamu</p>

            <?php if(isset($error)){ ?>
                <div class="alert alert-danger py-2"><?php echo $error; ?></div>
            <?php } ?>

            <form method="POST">
                <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
                <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

                <button name="login" class="btn btn-login w-100">Login</button>
            </form>

            <p class="small mt-3">
                Belum punya akun? <a href="register.php">Daftar</a>
            </p>

        </div>

    </div>

</div>

</body>
</html>