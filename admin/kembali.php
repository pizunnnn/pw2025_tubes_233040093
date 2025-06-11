<?php
require '../koneksi.php';
$id = $_GET['id'];

mysqli_query($conn, "UPDATE peminjaman SET status='dikembalikan', tanggal_kembali=CURDATE() WHERE id=$id");
header("Location: peminjaman.php");
exit;