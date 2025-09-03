<?php
include '../../config.php';

if (isset($_POST['tambah'])) {
    $name   = $_POST['name'];
    $alamat = $_POST['alamat'];
    $nomor  = $_POST['nomor'];

    // Simpan ke database
    mysqli_query($conn, "INSERT INTO pelanggan (name, alamat, nomor) 
                    VALUES ('$name','$alamat','$nomor')"
                );

    // Kembali ke daftar pelanggan
    header("Location: index.php");
    exit();
}
?>

<h2>Tambah Pelanggan</h2>
<form method="POST">
    Nama: <input type="text" name="name" required><br>
    Alamat: <textarea name="alamat" required></textarea><br>
    Nomor Telepon: <input type="text" name="nomor" required><br>
    <button type="submit" name="tambah">Tambah</button>
</form>

<p><a href="index.php">Kembali ke daftar pelanggan</a></p>
