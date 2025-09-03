<?php
include '../../config.php';

// Ambil data transaksi + join pelanggan & mobil
$result = mysqli_query($conn, "
    SELECT t.id, p.name AS pelanggan, m.merk, m.name AS mobil, 
        t.tgl_sewa, t.tgl_kembali, t.total_bayar
    FROM transaksi t
    JOIN pelanggan p ON t.id_pelanggan = p.id
    JOIN mobil m ON t.id_mobil = m.id
    ORDER BY t.id DESC
");
?>

<h2>Data Transaksi</h2>
<a href="add.php">Tambah Transaksi</a> |
<a href="../../dashboard.php">Dashboard</a>

<table border="1">
<tr>
    <th>ID</th>
    <th>Pelanggan</th>
    <th>Mobil</th>
    <th>Tgl Sewa</th>
    <th>Tgl Kembali</th>
    <th>Total Bayar</th>
    <th>Aksi</th>
</tr>
<?php while ($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['pelanggan'] ?></td>
    <td><?= $row['merk'] ?> - <?= $row['mobil'] ?></td>
    <td><?= $row['tgl_sewa'] ?></td>
    <td><?= $row['tgl_kembali'] ?></td>
    <td>Rp<?= number_format($row['total_bayar'], 0, ',', '.') ?></td>
    <td>
        <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
        <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus transaksi ini?')">Hapus</a>
    </td>
</tr>
<?php } ?>
</table>
