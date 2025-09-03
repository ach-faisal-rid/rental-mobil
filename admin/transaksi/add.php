<?php
include '../../config.php';

// Ambil data pelanggan untuk dropdown
$pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan");

// Ambil mobil yang tersedia
$mobil = mysqli_query($conn, "SELECT * FROM mobil WHERE status='tersedia'");

// Jika form disubmit
if (isset($_POST['tambah'])) {
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_mobil     = $_POST['id_mobil'];
    $tgl_sewa     = $_POST['tgl_sewa'];
    $tgl_kembali  = $_POST['tgl_kembali'];

    // Ambil harga sewa mobil
    $m = mysqli_fetch_assoc(mysqli_query($conn, "SELECT harga_sewa FROM mobil WHERE id=$id_mobil"));
    $harga = $m['harga_sewa'];

    // Hitung lama sewa (hari)
    $lama  = (strtotime($tgl_kembali) - strtotime($tgl_sewa)) / (60*60*24);
    if ($lama < 1) $lama = 1; // minimal 1 hari

    $total = $lama * $harga;

    // Simpan transaksi
    mysqli_query($conn, "INSERT INTO transaksi (id_pelanggan, id_mobil, tgl_sewa, tgl_kembali, total_bayar) 
    VALUES ('$id_pelanggan','$id_mobil','$tgl_sewa','$tgl_kembali','$total')");

    // Update status mobil → disewa
    mysqli_query($conn, "UPDATE mobil SET status='disewa' WHERE id=$id_mobil");

    // Redirect ke daftar transaksi
    header("Location: index.php");
    exit();
}
?>

<h2>Tambah Transaksi</h2>
<form method="POST">
    Pelanggan: 
    <select name="id_pelanggan" required>
        <option value="">-- Pilih Pelanggan --</option>
        <?php while ($p = mysqli_fetch_assoc($pelanggan)) { ?>
            <option value="<?= $p['id'] ?>"><?= $p['name'] ?></option>
        <?php } ?>
    </select><br>

    Mobil: 
    <select name="id_mobil" required>
        <option value="">-- Pilih Mobil --</option>
        <?php while ($m = mysqli_fetch_assoc($mobil)) { ?>
            <option value="<?= $m['id'] ?>"><?= $m['merk'] ?> - <?= $m['name'] ?> (Rp<?= number_format($m['harga_sewa'],0,',','.') ?>/hari)</option>
        <?php } ?>
    </select><br>

    Tanggal Sewa: <input type="date" name="tgl_sewa" required><br>
    Tanggal Kembali: <input type="date" name="tgl_kembali" required><br>

    <button type="submit" name="tambah">Simpan</button>
</form>

<p><a href="index.php">Kembali ke daftar transaksi</a></p>
