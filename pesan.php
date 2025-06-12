<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "Akses tidak sah!";
    exit;
}

$id_mobil = (int) $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM mobil WHERE id = $id_mobil");
$mobil = mysqli_fetch_assoc($query);

if (!$mobil) {
    echo "Mobil tidak ditemukan.";
    exit;
}

// Ambil user_id dari session
$username = $_SESSION['username'];
$user_result = mysqli_query($conn, "SELECT id FROM user WHERE username = '$username'");
$user = mysqli_fetch_assoc($user_result);
$user_id = $user['id'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesan Mobil - <?= $mobil['nama_mobil'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="text-center text-primary mb-4">Pesan Mobil: <?= $mobil['nama_mobil'] ?></h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="proses_pesan.php" method="POST">
                <input type="hidden" name="mobil_id" value="<?= $mobil['id'] ?>">
                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                
                <div class="mb-3">
                    <label for="tanggal_pinjam" class="form-label">Tanggal Mulai Sewa</label>
                    <input type="date" class="form-control" name="tanggal_pinjam" required>
                </div>
                <div class="mb-3">
                    <label for="tanggal_kembali" class="form-label">Tanggal Selesai Sewa</label>
                    <input type="date" class="form-control" name="tanggal_kembali" required>
                </div>
                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan (opsional)</label>
                    <textarea name="catatan" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Lanjutkan Pesan</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
