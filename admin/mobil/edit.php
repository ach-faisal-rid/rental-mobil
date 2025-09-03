<?php
include '../../config.php';

// ambil ID dari URL
if (!isset($_GET['id'])) {
    echo "ID mobil tidak ditemukan!";
    exit();
}

$id = $_GET['id'];

// ambil data mobil berdasarkan ID
$result = mysqli_query($conn, "SELECT * FROM mobil WHERE id=$id");
$mobil = mysqli_fetch_assoc($result);

if (!$mobil) {
    echo "Data mobil tidak ditemukan!";
    exit();
}

// jika form disubmit
if (isset($_POST['update'])) {
    $merk  = $_POST['merk'];
    $name  = $_POST['name'];
    $status = $_POST['status'];
    $harga = $_POST['harga'];

    mysqli_query($conn, "UPDATE mobil 
                    SET merk='$merk', name='$name', status='$status', harga_sewa='$harga'
                    WHERE id=$id"
                );

    header("Location: mobil.php");
    exit();
}
?>

<h2>Edit Data Mobil</h2>
<form method="POST">
    Merk: <input type="text" name="merk" value="<?= $mobil['merk'] ?>"><br>
    Nama: <input type="text" name="name" value="<?= $mobil['name'] ?>"><br>
    Status:
    <select name="status">
        <option value="tersedia" <?= ($mobil['status']=='tersedia')?'selected':'' ?>>Tersedia</option>
        <option value="disewa" <?= ($mobil['status']=='disewa')?'selected':'' ?>>Disewa</option>
    </select><br>
    Harga Sewa: <input type="number" name="harga" value="<?= $mobil['harga_sewa'] ?>"><br>
    <button type="submit" name="update">Simpan Perubahan</button>
</form>

<p><a href="index.php">Kembali ke daftar mobil</a></p>
