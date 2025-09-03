<?php
$host = "localhost";
$user = "root";
$pass = "root"; // Password for MySQL kalau nggak ada hapus
$db   = "rental_mobil";

$conn = mysqli_connect($host, $user, $pass, $db);

if(!$conn){
    die("Koneksi gagal: " . mysqli_connect_error());
}

// echo "Koneksi berhasil! 👍";

session_start();
?>
