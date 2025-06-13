<?php
session_start();
require '../koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("ID peminjaman tidak valid.");
}

$peminjaman_id = (int)$_GET['id'];

// Ambil data peminjaman untuk mengetahui mobil_id-nya
$query = mysqli_query($conn, "SELECT * FROM peminjaman WHERE id = $peminjaman_id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data peminjaman tidak ditemukan.");
}

$mobil_id = $data['mobil_id'];

// Update status di tabel peminjaman
$update = mysqli_query($conn, "UPDATE peminjaman SET status = 'dikembalikan' WHERE id = $peminjaman_id");

// Update status mobil tersedia kembali

if ($update) {
    header("Location: peminjaman.php");
    exit;
} else {
    echo "Gagal memperbarui status.";
}
?>
