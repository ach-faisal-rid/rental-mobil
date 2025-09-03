<?php
include '../../config.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

// Ambil user login
$user_id = $_SESSION['user_id'];

// Cek apakah user punya data pelanggan
$pelanggan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pelanggan WHERE user_id='$user_id'"));

if (!$pelanggan) {
    // Ambil info user dari tabel users
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'"));

    // Insert data pelanggan baru otomatis
    mysqli_query($conn, "INSERT INTO pelanggan (user_id, name, alamat, nomor) 
                    VALUES ('$user_id', '{$user['name']}', '', '')"
                );

    // Ambil ulang data pelanggan setelah insert
    $pelanggan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pelanggan WHERE user_id='$user_id'"));
}

// Ambil mobil yang tersedia
$mobil = mysqli_query($conn, "
    SELECT * FROM mobil m 
    WHERE NOT EXISTS (
        SELECT 1 FROM transaksi t
        WHERE t.id_mobil = m.id 
        AND CURDATE() BETWEEN t.tgl_sewa AND t.tgl_kembali
    )
");

// Jika form sewa dikirim
if (isset($_POST['sewa'])) {
    $id_mobil    = $_POST['id_mobil'];
    $tgl_sewa    = $_POST['tgl_sewa'];
    $tgl_kembali = $_POST['tgl_kembali'];

    // Ambil harga sewa
    $m = mysqli_fetch_assoc(mysqli_query($conn, "SELECT harga_sewa FROM mobil WHERE id=$id_mobil"));
    $harga = $m['harga_sewa'];

    // Hitung lama sewa (hari)
    $lama  = (strtotime($tgl_kembali) - strtotime($tgl_sewa)) / (60*60*24);
    if ($lama < 1) $lama = 1;

    $total = $lama * $harga;

    // Simpan transaksi
    mysqli_query($conn, "INSERT INTO transaksi (id_pelanggan, id_mobil, tgl_sewa, tgl_kembali, total_bayar) 
    VALUES ('{$pelanggan['id']}','$id_mobil','$tgl_sewa','$tgl_kembali','$total')");

    // Update status mobil → disewa
    mysqli_query($conn, "UPDATE mobil SET status='disewa' WHERE id=$id_mobil");

    echo "✅ Sewa berhasil! <a href='index.php'>Kembali</a>";
    exit();
}
?>

<h2>Form Sewa Mobil</h2>
<form method="POST">
    Mobil: 
    <select name="id_mobil" required>
        <option value="">-- Pilih Mobil --</option>
        <?php while ($m = mysqli_fetch_assoc($mobil)) { ?>
            <option value="<?= $m['id'] ?>">
                <?= $m['merk'] ?> - <?= $m['name'] ?> (Rp<?= number_format($m['harga_sewa'],0,',','.') ?>/hari)
            </option>
        <?php } ?>
    </select><br>

    Tanggal Sewa: <input type="date" name="tgl_sewa" required><br>
    Tanggal Kembali: <input type="date" name="tgl_kembali" required><br>

    <button type="submit" name="sewa">Sewa</button>
</form>

<p><a href="../../dashboard.php">Kembali ke Dashboard</a></p>
