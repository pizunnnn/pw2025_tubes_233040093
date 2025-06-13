<?php
session_start();
require '../koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$query = mysqli_query($conn, "SELECT p.*, u.username, m.nama_mobil 
    FROM peminjaman p
    JOIN user u ON p.user_id = u.id
    JOIN mobil m ON p.mobil_id = m.id
    ORDER BY p.tanggal_pinjam DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Peminjaman & Pengembalian</title>
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

    <div class="container py-5">
        <h2 class="text-primary mb-4">Daftar Peminjaman & Pengembalian</h2>
            <a href="index.php" class="btn btn-secondary mb-3">← Kembali</a>
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Mobil</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['nama_mobil']) ?></td>
                        <td><?= $row['tanggal_pinjam'] ?></td>
                        <td><?= $row['tanggal_kembali'] ?: '-' ?></td>
                        <td><span class="badge bg-<?= $row['status'] == 'dipinjam' ? 'warning' : 'success' ?>">
                            <?= ucfirst($row['status']) ?>
                        </span></td>
                        <td>
                            <?php if ($row['status'] == 'dipinjam') : ?>
                                <a href="kembalikan.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-success">Tandai Dikembalikan</a>
                            <?php else: ?>
                                <span class="text-muted">Selesai</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
