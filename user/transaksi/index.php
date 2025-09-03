<?php
include '../../config.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data pelanggan user login
$pelanggan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pelanggan WHERE user_id='$user_id'"));

if (!$pelanggan) {
    die("⚠️ Data pelanggan tidak ditemukan. Silakan hubungi admin.");
}

// Ambil transaksi berdasarkan id_pelanggan
$query = mysqli_query($conn, "SELECT t.*, m.merk, m.name AS mobil_name 
                        FROM transaksi t 
                        JOIN mobil m ON t.id_mobil = m.id 
                        WHERE t.id_pelanggan = '{$pelanggan['id']}'
                        ORDER BY t.id DESC");
?>

<h2>Riwayat Transaksi Saya</h2>

<?php if (mysqli_num_rows($query) == 0) { ?>
    <p>❌ Belum ada transaksi sewa mobil.</p>
<?php } else { ?>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Mobil</th>
            <th>Tanggal Sewa</th>
            <th>Tanggal Kembali</th>
            <th>Total Bayar</th>
        </tr>
        <?php 
        $no = 1;
        while ($row = mysqli_fetch_assoc($query)) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['merk'] ?> - <?= $row['mobil_name'] ?></td>
                <td><?= $row['tgl_sewa'] ?></td>
                <td><?= $row['tgl_kembali'] ?></td>
                <td>Rp<?= number_format($row['total_bayar'], 0, ',', '.') ?></td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>

<p><a href="../sewa/index.php">+ Sewa Mobil Baru</a></p>
<p><a href="../../dashboard.php">⬅️ Kembali ke Dashboard</a></p>
