<?php
session_start();
require 'koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: admin/index.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        echo "<script>alert('Username atau password salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100 bg-gradient-blue">
    <div class="card login-card shadow-lg p-4">
        <h2 class="text-center mb-4">LOGIN</h2>

       
        <form action="" method="post">
            <div class="form-group mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control border-primary" required>
            </div>
            <div class="form-group mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control border-primary" required>
            </div>
            <div class="text-end mb-3">
                <a href="#" class="text-primary small">Forgot password?</a>
            </div>
            <div class="d-grid">
                <button type="submit" name="login" class="btn btn-primary btn-login">LOGIN</button>
            </div>
        </form>

        <div class="text-center mt-3">
            <small class="text-muted">
                Don't have an account yet? <a href="register.php" class="text-primary">Register now!</a>
            </small>
        </div>
    </div>
</div>

</body>
</html>

