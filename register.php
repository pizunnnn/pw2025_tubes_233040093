<?php
require 'koneksi.php';

$success = $error = "";

if (isset($_POST['register'])) {
    $username = strtolower(trim($_POST['username']));
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    // Cek konfirmasi password
    if ($password !== $password2) {
        $error = "Konfirmasi password tidak sesuai!";
    } else {
        // Cek apakah username sudah ada
        $cek = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "Username sudah terdaftar!";
        } else {
            // Hash password
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Simpan ke database
            $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$passwordHash')";
            if (mysqli_query($conn, $query)) {
                $success = "Registrasi berhasil! Silakan login.";
            } else {
                $error = "Gagal registrasi: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100 bg-gradient-blue">
    <div class="card login-card shadow-lg p-4">
        <h2 class="text-center mb-4">REGISTER</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php elseif ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control border-primary" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email (opsional)</label>
                <input type="email" name="email" id="email" class="form-control border-primary">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control border-primary" required>
            </div>
            <div class="mb-3">
                <label for="password2" class="form-label">Konfirmasi Password</label>
                <input type="password" name="password2" id="password2" class="form-control border-primary" required>
            </div>
            <div class="d-grid">
                <button type="submit" name="register" class="btn btn-primary btn-login">REGISTER</button>
            </div>
        </form>

        <div class="text-center mt-3">
            <small class="text-muted">Sudah punya akun? <a href="login.php" class="text-primary">Login di sini</a></small>
        </div>
    </div>
</div>

</body>
</html>
