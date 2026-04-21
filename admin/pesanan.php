<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM pesanan ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Kelola Pesanan</title>

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

.badge-status {
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
}

.menunggu { background:#fff3cd; }
.proses { background:#cfe2ff; }
.kirim { background:#d1e7dd; }
.selesai { background:#e2e3e5; }

.btn-sm {
    border-radius:8px;
    font-size:12px;
}
</style>

</head>

<body>

<div class="container mt-4">
<div class="box">

<div class="d-flex justify-content-between mb-3">
    <h5>🧾 Kelola Pesanan</h5>
    <a href="dashboard_admin.php" class="btn btn-outline-dark btn-sm">← Kembali</a>
</div>

<table class="table align-middle">
<tr>
<th>#</th>
<th>User</th>
<th>Total</th>
<th>Status</th>
<th class="text-end">Aksi</th>
</tr>

<?php while($p = mysqli_fetch_assoc($data)){ 

$status_class = "menunggu";
if($p['status'] == 'Diproses') $status_class = "proses";
elseif($p['status'] == 'Dikirim') $status_class = "kirim";
elseif($p['status'] == 'Selesai') $status_class = "selesai";

?>

<tr id="row<?= $p['id']; ?>">

<td>#<?= $p['id']; ?></td>
<td><?= $p['username']; ?></td>
<td>Rp <?= number_format($p['total']); ?></td>

<td>
<span class="badge-status <?= $status_class; ?>" id="status<?= $p['id']; ?>">
<?= $p['status']; ?>
</span>
</td>

<td class="text-end">
<div id="aksi<?= $p['id']; ?>" class="d-flex justify-content-end gap-1">

<?php if($p['status'] == 'Menunggu Pembayaran'){ ?>
<button onclick="updateStatus(<?= $p['id']; ?>,'Diproses')" class="btn btn-primary btn-sm">Verifikasi</button>

<?php } elseif($p['status'] == 'Diproses'){ ?>
<button onclick="updateStatus(<?= $p['id']; ?>,'Dikirim')" class="btn btn-success btn-sm">Kirim</button>

<?php } elseif($p['status'] == 'Dikirim'){ ?>
<button onclick="updateStatus(<?= $p['id']; ?>,'Selesai')" class="btn btn-dark btn-sm">Selesai</button>

<?php } else { ?>
<span class="text-success small">✔ Selesai</span>
<?php } ?>

</div>
</td>

</tr>

<?php } ?>

</table>

</div>
</div>

<!-- 🔥 SCRIPT AJAX -->
<script>
function updateStatus(id, status){

    fetch('update_status.php?id=' + id + '&status=' + status)
    .then(() => {

        // update status text
        let statusEl = document.getElementById('status'+id);
        statusEl.innerText = status;

        // update warna
        statusEl.className = 'badge-status';
        if(status == 'Diproses') statusEl.classList.add('proses');
        else if(status == 'Dikirim') statusEl.classList.add('kirim');
        else if(status == 'Selesai') statusEl.classList.add('selesai');

        // update tombol aksi
        let aksi = document.getElementById('aksi'+id);

        if(status == 'Diproses'){
            aksi.innerHTML = `<button onclick="updateStatus(${id},'Dikirim')" class="btn btn-success btn-sm">Kirim</button>`;
        }
        else if(status == 'Dikirim'){
            aksi.innerHTML = `<button onclick="updateStatus(${id},'Selesai')" class="btn btn-dark btn-sm">Selesai</button>`;
        }
        else{
            aksi.innerHTML = `<span class="text-success small">✔ Selesai</span>`;
        }

    });
}
</script>

</body>
</html>