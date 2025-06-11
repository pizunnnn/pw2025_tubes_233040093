<?php
session_start();
require '../koneksi.php';

// Cek apakah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Ambil data mobil
$result = mysqli_query($conn, "SELECT * FROM mobil");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Mobil</title>
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
<div class="container py-5">
    <h2 class="mb-4">Data Mobil</h2>

    <a href="tambah_mobil.php" class="btn btn-success mb-3">+ Tambah Mobil</a>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama Mobil</th>
                <th>Merk</th>
                <th>Tahun</th>
                <th>Harga</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1; while ($mobil = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><img src="../uploads/<?= $mobil['gambar'] ?>" width="100" style="object-fit: cover;"></td>
                <td><?= htmlspecialchars($mobil['nama_mobil']) ?></td>
                <td><?= htmlspecialchars($mobil['merk']) ?></td>
                <td><?= htmlspecialchars($mobil['tahun']) ?></td>
                <td>Rp<?= number_format($mobil['harga'], 0, ',', '.') ?></td>
                <td><?= htmlspecialchars($mobil['deskripsi']) ?></td>
                <td>
                    <a href="edit_mobil.php?id=<?= $mobil['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="hapus_mobil.php?id=<?= $mobil['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
