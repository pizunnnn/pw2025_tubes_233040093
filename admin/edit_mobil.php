<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}
require '../koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM mobil WHERE id = $id");
$data = mysqli_fetch_assoc($query);

if (isset($_POST['update'])) {
    $nama = $_POST['nama_mobil'];
    $merk = $_POST['merk'];
    $tahun = $_POST['tahun'];
    $harga_input = $_POST['harga'];
    $harga = preg_replace("/[^0-9]/", "", $harga_input);
    $deskripsi = $_POST['deskripsi'];

    // Cek apakah ada gambar baru di-upload
    if ($_FILES['gambar']['name'] != '') {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($tmp, "../images/$gambar");

        $update = mysqli_query($conn, "UPDATE mobil SET 
            nama_mobil='$nama',
            merk='$merk',
            tahun='$tahun',
            harga='$harga',
            deskripsi='$deskripsi',
            gambar='$gambar'
            WHERE id=$id");
    } else {
        $update = mysqli_query($conn, "UPDATE mobil SET 
            nama_mobil='$nama',
            merk='$merk',
            tahun='$tahun',
            harga='$harga',
            deskripsi='$deskripsi'
            WHERE id=$id");
    }

    if ($update) {
        echo "<script>alert('Data berhasil diperbarui'); window.location='index.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 600px;">
    <h2 class="mb-4 text-primary">Edit Data Mobil</h2>
     <a href="index.php" class="btn btn-secondary mb-3">← Kembali</a>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Nama Mobil</label>
            <input type="text" name="nama_mobil" class="form-control" value="<?= htmlspecialchars($data['nama_mobil']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Merk</label>
            <input type="text" name="merk" class="form-control" value="<?= htmlspecialchars($data['merk']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tahun</label>
            <input type="number" name="tahun" class="form-control" value="<?= $data['tahun'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="text" name="harga" id="harga" class="form-control" value="<?= number_format($data['harga'], 0, ',', '.') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Gambar Saat Ini</label><br>
            <img src="../images/<?= $data['gambar'] ?>" width="200" class="img-thumbnail">
        </div>
        <div class="mb-3">
            <label class="form-label">Ganti Gambar (opsional)</label>
            <input type="file" name="gambar" class="form-control" accept="image/*">
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" required><?= htmlspecialchars($data['deskripsi']) ?></textarea>
        </div>
        <button type="submit" name="update" class="btn btn-primary w-100">Update Mobil</button>
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
