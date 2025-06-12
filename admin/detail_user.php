<?php
require '../koneksi.php';
if (!isset($_GET['id'])) die("ID user tidak ditemukan");

$id = (int)$_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id = $id"));
if (!$data) die("User tidak ditemukan");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Profil User</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nama Lengkap:</strong><br><?= htmlspecialchars($data['nama_lengkap']) ?></p>
                    <p><strong>Email:</strong><br><?= htmlspecialchars($data['email']) ?></p>
                    <p><strong>KTP:</strong></p>
                    <img src="../images/<?= htmlspecialchars($data['ktp']) ?>" alt="KTP" class="img-fluid rounded border" width="300">
                </div>
                <div class="card-footer text-end">
                    <a href="booking.php" class="btn btn-secondary">← Kembali ke Daftar Booking</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
