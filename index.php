<?php
session_start();
require 'koneksi.php';

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

// Ambil notifikasi booking yang diterima dan belum dibaca
$notifQuery = mysqli_query($conn, "SELECT b.*, m.nama_mobil 
    FROM booking b
    JOIN mobil m ON b.mobil_id = m.id
    WHERE b.user_id = {$userData['id']} AND b.status = 'diterima' AND b.notifikasi_dibaca = 'belum'");
$jumlahNotif = mysqli_num_rows($notifQuery);
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
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Brand + Lokasi -->
        <div class="d-flex flex-column">
            <span class="navbar-brand fw-bold fs-3">SewaMobil</span>
            <small class="text-white">Jalan Lengkong Kecil No.19, Kec. Lengkong, Kel. Paledang, Kota Bandung</small>
        </div>

        <!-- Notifikasi & Profil -->
        <ul class="navbar-nav ms-auto align-items-center">
            <!-- Notifikasi -->
            <li class="nav-item dropdown me-3">
                <a class="nav-link dropdown-toggle position-relative" href="#" role="button" data-bs-toggle="dropdown">
                    🔔
                    <?php if ($jumlahNotif > 0): ?>
                        <span class="badge bg-danger"><?= $jumlahNotif ?></span>
                    <?php endif; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <?php if ($jumlahNotif == 0): ?>
                        <li><span class="dropdown-item text-muted">Tidak ada notifikasi</span></li>
                    <?php else: ?>
                        <?php while ($notif = mysqli_fetch_assoc($notifQuery)) : ?>
                            <li>
                                <form action="baca_notif.php" method="post">
                                    <input type="hidden" name="booking_id" value="<?= $notif['id'] ?>">
                                    <button type="submit" class="dropdown-item text-wrap">
                                        Pemesanan mobil <strong><?= htmlspecialchars($notif['nama_mobil']) ?></strong> Anda telah <strong>diterima</strong>.
                                    </button>
                                </form>
                            </li>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </ul>
            </li>

            <!-- Profil dan Logout -->
            <li class="nav-item me-2">
                <a href="profil.php?user_id=<?= $userData['id'] ?>">
                    <img src="images/profil.jpg" alt="Profil" width="36" height="36" class="rounded-circle border border-white" style="object-fit: cover;">
                </a>
            </li>
            <li class="nav-item">
                <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </li>
        </ul>
    </div>
</nav>


<div class="container py-5">
    <h2 class="text-center text-primary mb-4">Daftar Mobil</h2>
    <div class="row">
        <?php while ($mobil = mysqli_fetch_assoc($mobilQuery)) : ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="images/<?= htmlspecialchars($mobil['gambar']) ?>" class="card-img-top" style="height:200px; object-fit:cover;">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
