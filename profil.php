<?php
require 'koneksi.php';

if (!isset($_GET['user_id'])) {
    die("Akses tidak sah");
}

$user_id = (int) $_GET['user_id'];
$result = mysqli_query($conn, "SELECT * FROM user WHERE id = $user_id");

if (!$result || mysqli_num_rows($result) == 0) {
    die("User tidak ditemukan");
}

$user = mysqli_fetch_assoc($result);

// Proses update data
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];

    // Upload file KTP
    $ktp = $user['ktp'];
    if ($_FILES['ktp']['name']) {
        $ktp = $_FILES['ktp']['name'];
        $tmp = $_FILES['ktp']['tmp_name'];
        move_uploaded_file($tmp, "images/" . $ktp);
    }

    $update = mysqli_query($conn, "UPDATE user SET nama_lengkap='$nama', email='$email', ktp='$ktp' WHERE id=$user_id");

    if ($update) {
        echo "<script>alert('Data berhasil diperbarui'); window.location='profil.php?user_id=$user_id';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal memperbarui data');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="text-primary mb-4">Profil Saya</h2>

    <form method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($user['nama_lengkap'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Upload KTP</label>
           <?php if (!empty($user['ktp']) && file_exists("images/" . $user['ktp'])): ?>
    <p><img src="images/<?= $user['ktp'] ?>" width="150"></p>
<?php else: ?>
    <p class="text-danger">Gambar KTP belum tersedia atau tidak ditemukan.</p>
<?php endif; ?>
            <input type="file" name="ktp" class="form-control">
        </div>
        <button type="submit" name="update" class="btn btn-primary">Simpan</button>
        <a href="index.php?user_id=<?= $user_id ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

</body>
</html>
