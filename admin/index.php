<?php
session_start();
require '../koneksi.php';

// Cek apakah admin yang login
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
    // Query booking
$booking = mysqli_query($conn, "
    SELECT booking.*, user.username, mobil.nama_mobil 
    FROM booking 
    JOIN user ON booking.user_id = user.id 
    JOIN mobil ON booking.mobil_id = mobil.id 
    ORDER BY booking.created_at DESC
");

// Query peminjaman
$peminjaman = mysqli_query($conn, "SELECT peminjaman.*, booking.id AS booking_id, user.username, mobil.nama_mobil 
    FROM peminjaman 
    JOIN booking ON peminjaman.booking_id = booking.id 
    JOIN user ON booking.user_id = user.id 
    JOIN mobil ON booking.mobil_id = mobil.id 
    ORDER BY peminjaman.tanggal_pinjam DESC");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Penyewaan Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Admin Panel</a>
            <div class="d-flex">
                <span class="navbar-text me-3 text-white">
                    Login sebagai: <strong><?= $_SESSION['username']; ?></strong>
                </span>
                <a href="../logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Link kecil navigasi -->
    <div class="bg-white border-bottom py-2">
        <div class="container text-center">
            <a href="booking.php" class="text-decoration-none text-primary mx-3 small">Daftar Booking</a>
            <a href="mobil.php" class="text-decoration-none text-primary mx-3 small">Daftar Mobil</a>
            <a href="peminjaman.php" class="text-decoration-none text-primary mx-3 small">Peminjaman & Pengembalian</a>
        </div>
    </div>

    <!-- Konten utama -->
    <div class="container mt-5 text-center">
        <h1 class="fw-bold text-primary">Selamat Datang, Admin!</h1>
        <p class="text-muted">Gunakan panel ini untuk mengelola data penyewaan mobil.</p>

        <div class="row justify-content-center mt-4">
            <div class="col-md-4">
                <div class="card border-primary">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Data Mobil</h5>
                        <p class="card-text">Tambah, ubah, dan hapus data mobil yang tersedia.</p>
                        <a href="mobil.php" class="btn btn-primary w-100">Kelola Mobil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center text-muted mt-5 mb-3">&copy; <?= date("Y"); ?> Penyewaan Mobil</footer>
</body>
</html>
