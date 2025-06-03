<?php
session_start();
include 'koneksi.php';

$error = '';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100 bg-gradient-green">
    <div class="card login-card shadow-lg p-4">
        <h2 class="text-center mb-4">LOGIN</h2>
        <form action="login.php" method="post">
            <div class="form-group mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control border-success" required>
            </div>
            <div class="form-group mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control border-success" required>
            </div>
            <div class="text-end mb-3">
                <a href="#" class="text-success small">Forgot password?</a>
            </div>
            <div class="d-grid">
                <button type="submit" name="login" class="btn btn-success btn-login">LOGIN</button>
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

