<?php
include '../../config.php';

if (isset($_POST['tambah'])) {
    $merk  = $_POST['merk'];
    $name  = $_POST['name'];
    $harga = $_POST['harga'];

    // Simpan ke database
    mysqli_query($conn, "INSERT INTO mobil (merk, name, harga_sewa) 
                    VALUES ('$merk','$name','$harga')");

    // Kembali ke daftar mobil
    header("Location: index.php");
    exit();
}
?>

<h2>Tambah Mobil</h2>
<form method="POST">
    Merk: <input type="text" name="merk" required><br>
    Nama: <input type="text" name="name" required><br>
    Harga: <input type="number" name="harga" required><br>
    <button type="submit" name="tambah">Tambah</button>
</form>

<p><a href="index.php">Kembali ke daftar mobil</a></p>
