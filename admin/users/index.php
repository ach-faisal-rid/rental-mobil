<?php
include '../../config.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

// Cek apakah role = admin
if ($_SESSION['role_id'] != 1) { // 1 = admin
    die("❌ Akses ditolak. Halaman ini hanya untuk admin.");
}

// Hapus user
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    // Jangan hapus user admin utama (id=1)
    if ($id != 1) {
        mysqli_query($conn, "DELETE FROM users WHERE id=$id");
    }
    header("Location: index.php");
    exit();
}

// Ambil semua user + role
$result = mysqli_query($conn, "
    SELECT u.*, r.name AS role_name 
    FROM users u 
    LEFT JOIN role r ON u.role_id = r.id 
    ORDER BY u.id ASC
");
?>

<h2>Manajemen Users</h2>
<p><a href="add.php">+ Tambah User</a></p>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Nama</th>
        <th>Role</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['role_name'] ?></td>
            <td>
                <?php if ($row['id'] != 1) { // jangan hapus user admin utama ?>
                    <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> | 
                    <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus user ini?')">Hapus</a>
                <?php } else { ?>
                    <i>(default admin)</i>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
</table>

<p><a href="../../dashboard.php">⬅️ Kembali ke Dashboard</a></p>
