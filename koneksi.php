<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "pw2025_tubes_233040093";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    echo "ERROR DETAIL: " . mysqli_connect_error();
    die("Koneksi database gagal.");
}
?>
