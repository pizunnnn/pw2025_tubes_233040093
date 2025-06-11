<?php
session_start();
require 'koneksi.php';

// Cek koneksi database
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Cek apakah user sudah login dan berperan sebagai user
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}

// Ambil data user berdasarkan session
$username = $_SESSION['username'];
$userQuery = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'") or die(mysqli_error($conn));
$userData = mysqli_fetch_assoc($userQuery);

// Cek apakah profil lengkap
$profilLengkap = !empty($userData['nama_lengkap']) && !empty($userData['email']) && !empty($userData['ktp']);

// Ambil data mobil
$mobilQuery = mysqli_query($conn, "SELECT * FROM mobil") or die(mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beranda - Penyewaan Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">SewaMobil</a>
        <div class="d-flex align-items-center">
            <a href="profil.php?user_id=<?= $userData['id'] ?>" class="me-3">
                <img src="images/profil.jpg" alt="Profil" width="36" height="36" class="rounded-circle border border-white" style="object-fit: cover;">
            </a>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <h2 class="text-center text-primary mb-4">Daftar Mobil</h2>
    <div class="row">
        <?php while ($mobil = mysqli_fetch_assoc($mobilQuery)) : ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="uploads/<?= htmlspecialchars($mobil['gambar']) ?>" class="card-img-top" style="height:200px; object-fit:cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($mobil['nama_mobil']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($mobil['merk']) ?> - <?= htmlspecialchars($mobil['tahun']) ?></p>
                        <p class="fw-bold text-primary">Rp<?= number_format($mobil['harga'], 0, ',', '.') ?> /hari</p>
                        <p class="card-text"><?= htmlspecialchars($mobil['deskripsi']) ?></p>
                        <a href="<?= $profilLengkap ? 'pesan.php?id=' . $mobil['id'] : '#' ?>" 
                           class="btn btn-primary w-100"
                           onclick="<?= $profilLengkap ? '' : 'alert(`Silakan lengkapi data profil Anda terlebih dahulu.`); return false;' ?>">
                            Pesan Sekarang
                        </a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>
