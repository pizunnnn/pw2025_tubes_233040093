<?php
session_start();
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['booking_id'])) {
    $booking_id = (int)$_POST['booking_id'];
    mysqli_query($conn, "UPDATE booking SET notifikasi_dibaca = 'sudah' WHERE id = $booking_id");
}

header("Location: index_user.php");
exit;
?>
