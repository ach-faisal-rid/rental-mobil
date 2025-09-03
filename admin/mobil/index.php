<?php
include '../../config.php';

// Tampilkan data
$result = mysqli_query($conn, "SELECT * FROM mobil");
?>

<h2>Data Mobil</h2>
<a href="add.php">Tambah Mobil</a> |
<a href="../../dashboard.php">Dashboard</a>

<table border="1">
<tr>
    <th>ID</th>
    <th>Merk</th>
    <th>Nama</th>
    <th>Status</th>
    <th>Harga</th>
    <th>Aksi</th>
</tr>
<?php while ($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['merk'] ?></td>
    <td><?= $row['name'] ?></td>
    <td><?= $row['status'] ?></td>
    <td><?= $row['harga_sewa'] ?></td>
    <td>
        <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
        <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus mobil ini?')">Hapus</a>
    </td>
</tr>
<?php } ?>
</table>
