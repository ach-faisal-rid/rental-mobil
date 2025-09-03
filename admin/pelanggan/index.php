<?php
include '../../config.php';

// Ambil data pelanggan
$result = mysqli_query($conn, "SELECT * FROM pelanggan");
?>

<h2>Data Pelanggan</h2>
<a href="add.php">Tambah Pelanggan</a> |
<a href="../../dashboard.php">Dashboard</a>

<table border="1">
<tr>
    <th>ID</th>
    <th>Nama</th>
    <th>Alamat</th>
    <th>Nomor</th>
    <th>Aksi</th>
</tr>
<?php while ($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['name'] ?></td>
    <td><?= $row['alamat'] ?></td>
    <td><?= $row['nomor'] ?></td>
    <td>
        <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
        <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus pelanggan ini?')">Hapus</a>
    </td>
</tr>
<?php } ?>
</table>
