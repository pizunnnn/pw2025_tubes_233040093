<?php
session_start();
require '../koneksi.php';

// Cek apakah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Proses simpan
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_mobil'];
    $merk = $_POST['merk'];
    $tahun = $_POST['tahun'];
    $harga_input = $_POST['harga'];
    $harga = preg_replace("/[^0-9]/", "", $harga_input);
    $deskripsi = $_POST['deskripsi'];

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    move_uploaded_file($tmp, "../images/$gambar");

    mysqli_query($conn, "INSERT INTO mobil (nama_mobil, merk, tahun, harga, gambar, deskripsi) VALUES 
        ('$nama', '$merk', '$tahun', '$harga', '$gambar', '$deskripsi')");
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 600px;">
    <h2 class="mb-4 text-primary">Tambah Mobil</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Nama Mobil</label>
            <input type="text" name="nama_mobil" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Merk</label>
            <input type="text" name="merk" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tahun</label>
            <input type="number" name="tahun" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga (tanpa titik atau Rp)</label>
            <input type="text" name="harga" id="harga" class="form-control" placeholder="Contoh: 4000000" required>
            <div class="form-text">Akan otomatis diformat saat diketik.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Gambar</label>
            <input type="file" name="gambar" class="form-control" accept="image/*" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" name="simpan" class="btn btn-primary w-100">Simpan Mobil</button>
    </form>
</div>

<script>
document.getElementById("harga").addEventListener("input", function(e) {
    let angka = e.target.value.replace(/[^\d]/g, "");
    if (angka !== "") {
        e.target.value = new Intl.NumberFormat('id-ID').format(angka);
    }
});
</script>
</body>
</html>
