<?php
include '../../config.php';

// Pastikan ada ID
if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan!";
    exit();
}

$id = $_GET['id'];

// Hapus data mobil
mysqli_query($conn, "DELETE FROM mobil WHERE id=$id");

// Kembali ke index mobil
header("Location: index.php");
exit();
