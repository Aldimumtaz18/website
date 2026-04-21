<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit;
}

$keyword = isset($_GET['cari']) ? $_GET['cari'] : '';

$data = mysqli_query($conn, "
    SELECT * FROM users 
    WHERE username LIKE '%$keyword%'
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Data User</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background:#f8f9fa;
    font-family:'Segoe UI';
}

.box {
    background:white;
    border-radius:12px;
    padding:20px;
    border:1px solid #eee;
}

/* ROLE */
.badge-role {
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
}

.admin { background:#cfe2ff; }
.pelanggan { background:#d1e7dd; }

/* BUTTON */
.btn-sm {
    border-radius:8px;
    font-size:12px;
}
</style>

</head>

<body>

<div class="container mt-4">
<div class="box">

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">👤 Data User</h5>

    <div class="d-flex gap-2">
        <a href="tambah_user.php" class="btn btn-dark btn-sm">+ Tambah</a>
        <a href="dashboard_admin.php" class="btn btn-outline-dark btn-sm">← Kembali</a>
    </div>
</div>

<!-- 🔍 SEARCH -->
<form method="GET" class="mb-3">
<input type="text" name="cari" class="form-control" placeholder="Cari username..." value="<?= $keyword; ?>">
</form>

<div class="table-responsive">
<table class="table align-middle">

<tr>
<th>#</th>
<th>Username</th>
<th>Role</th>
<th class="text-end">Aksi</th>
</tr>

<?php while($u = mysqli_fetch_assoc($data)){ ?>

<tr>

<td>#<?= $u['id']; ?></td>

<td><?= $u['username']; ?></td>

<td>
<span class="badge-role <?= $u['role']; ?>">
<?= ucfirst($u['role']); ?>
</span>
</td>

<td class="text-end">

<a href="edit_user.php?id=<?= $u['id']; ?>" 
   class="btn btn-primary btn-sm">
   Edit
</a>

<?php if($u['username'] != $_SESSION['user']){ ?>
<a href="hapus_user.php?id=<?= $u['id']; ?>" 
   class="btn btn-danger btn-sm"
   onclick="return confirm('Yakin hapus user ini?')">
   Hapus
</a>
<?php } ?>

</td>

</tr>

<?php } ?>

</table>
</div>

</div>
</div>

</body>
</html>