<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = (int) $_POST['user_id'];
    $mobil_id = (int) $_POST['mobil_id'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan']);

    // Validasi sederhana
    if (!$user_id || !$mobil_id || !$tanggal_pinjam || !$tanggal_kembali) {
        die("Data tidak lengkap.");
    }

    // Simpan ke database
    $query = "INSERT INTO booking (user_id, mobil_id, tanggal_pinjam, tanggal_kembali, catatan, status)
              VALUES ($user_id, $mobil_id, '$tanggal_pinjam', '$tanggal_kembali', '$catatan', 'pending')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Pemesanan berhasil!'); window.location='index.php?user_id=$user_id';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat memesan.'); window.history.back();</script>";
    }
} else {
    echo "Akses tidak sah.";
}
?>
