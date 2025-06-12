<?php
session_start();
require '../koneksi.php';

// Cek role admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Ambil data booking gabung dengan user dan mobil
$booking = mysqli_query($conn, "
    SELECT booking.*, user.id AS user_id, user.username, mobil.nama_mobil 
    FROM booking 
    JOIN user ON booking.user_id = user.id 
    JOIN mobil ON booking.mobil_id = mobil.id 
    ORDER BY booking.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Booking - Admin</title>
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

    <div class="bg-white border-bottom py-2">
        <div class="container text-center">
            <a href="booking.php" class="text-decoration-none text-primary mx-3 small">Daftar Booking</a>
            <a href="mobil.php" class="text-decoration-none text-primary mx-3 small">Daftar Mobil</a>
            <a href="peminjaman.php" class="text-decoration-none text-primary mx-3 small">Peminjaman & Pengembalian</a>
        </div>
    </div>

    <div class="container py-5">
        <h2 class="text-center text-primary mb-4">Daftar Booking</h2>
        <a href="index.php" class="btn btn-secondary mb-3">← Kembali ke Dashboard</a>

        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama User</th>
                        <th>Mobil</th>
                        <th>Tanggal Booking</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($booking)) :
                    ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td>
                                <a href="detail_user.php?id=<?= $row['user_id'] ?>" class="text-decoration-none">
                                    <?= htmlspecialchars($row['username']) ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($row['nama_mobil']) ?></td>
                            <td><?= htmlspecialchars(date('d-m-Y H:i', strtotime($row['created_at']))) ?></td>
                            <td><?= nl2br(htmlspecialchars($row['catatan'])) ?></td>
                            <td class="text-center">
                                <a href="detail_user.php?id=<?= $row['user_id'] ?>" class="btn btn-info btn-sm mb-1">Lihat User</a>
                                <a href="konfirmasi_booking.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm mb-1" onclick="return confirm('Yakin ingin konfirmasi booking ini?')">Konfirmasi</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    <?php if (mysqli_num_rows($booking) == 0): ?>
                        <tr><td colspan="6" class="text-center text-muted">Belum ada data booking.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
