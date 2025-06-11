<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}
require '../koneksi.php';

$id = $_GET['id'];

// Hapus gambar terlebih dahulu
$get = mysqli_query($conn, "SELECT gambar FROM mobil WHERE id = $id");
$data = mysqli_fetch_assoc($get);
if ($data && file_exists("../uploads/" . $data['gambar'])) {
    unlink("../uploads/" . $data['gambar']);
}

// Hapus dari database
$delete = mysqli_query($conn, "DELETE FROM mobil WHERE id = $id");

if ($delete) {
    echo "<script>alert('Mobil berhasil dihapus'); window.location='dashboard.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus mobil'); window.location='dashboard.php';</script>";
}
