<?php
include '../../config.php';

// Pastikan ada ID
if (!isset($_GET['id'])) {
    echo "ID pelanggan tidak ditemukan!";
    exit();
}

$id = $_GET['id'];

// Ambil data pelanggan berdasarkan ID
$result = mysqli_query($conn, "SELECT * FROM pelanggan WHERE id=$id");
$pelanggan = mysqli_fetch_assoc($result);

if (!$pelanggan) {
    echo "Data pelanggan tidak ditemukan!";
    exit();
}

// Update data
if (isset($_POST['update'])) {
    $name   = $_POST['name'];
    $alamat = $_POST['alamat'];
    $nomor  = $_POST['nomor'];

    mysqli_query($conn, "UPDATE pelanggan 
                    SET name='$name', alamat='$alamat', nomor='$nomor' 
                    WHERE id=$id"
                );

    header("Location: index.php");
    exit();
}
?>

<h2>Edit Data Pelanggan</h2>
<form method="POST">
    Nama: <input type="text" name="name" value="<?= $pelanggan['name'] ?>" required><br>
    Alamat: <textarea name="alamat" required><?= $pelanggan['alamat'] ?></textarea><br>
    Nomor Telepon: <input type="text" name="nomor" value="<?= $pelanggan['nomor'] ?>" required><br>
    <button type="submit" name="update">Simpan Perubahan</button>
</form>

<p><a href="index.php">Kembali ke daftar pelanggan</a></p>
