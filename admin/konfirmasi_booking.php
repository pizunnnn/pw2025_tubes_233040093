<?php
session_start();
require '../koneksi.php';

// Cek role admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Pastikan ID booking ada
if (!isset($_GET['id'])) {
    die("ID booking tidak ditemukan.");
}

$id = (int)$_GET['id'];

// Ambil data booking
$booking = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM booking WHERE id = $id"));
if (!$booking) {
    die("Data booking tidak ditemukan.");
}

// Cek apakah mobil sedang dipinjam
$mobil_id = $booking['mobil_id'];
$cekPeminjaman = mysqli_query($conn, "
    SELECT * FROM peminjaman 
    WHERE mobil_id = $mobil_id 
    AND status = 'dipinjam'
");

if (mysqli_num_rows($cekPeminjaman) > 0) {
    echo "<script>alert('Mobil sedang dipinjam. Tidak dapat mengkonfirmasi booking ini.'); window.location='booking.php';</script>";
    exit;
}

// Masukkan ke tabel peminjaman
$tanggal_pinjam = $booking['tanggal_pinjam'];
$tanggal_kembali = $booking['tanggal_kembali'];
$user_id = $booking['user_id'];

$insert = mysqli_query($conn, "
    INSERT INTO peminjaman (booking_id, user_id, mobil_id, tanggal_pinjam, tanggal_kembali, status)
    VALUES ($id, $user_id, $mobil_id, '$tanggal_pinjam', '$tanggal_kembali', 'dipinjam')
");

if ($insert) {
    // Update status di tabel booking
    mysqli_query($conn, "UPDATE booking SET status = 'diterima' WHERE id = $id");
    echo "<script>alert('Booking berhasil dikonfirmasi.'); window.location='booking.php';</script>";
} else {
    echo "<script>alert('Gagal menyimpan data peminjaman.'); window.location='booking.php';</script>";
}
?>
