<?php
include '../../config.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

// Cek apakah role = admin
if ($_SESSION['role_id'] != 1) { // asumsi role_id 1 = admin
    die("❌ Akses ditolak. Halaman ini hanya untuk admin.");
}

// Tambah role baru
if (isset($_POST['tambah'])) {
    $name = trim($_POST['name']);
    if ($name != "") {
        mysqli_query($conn, "INSERT INTO role (name) VALUES ('$name')");
    }
    header("Location: index.php");
    exit();
}

// Hapus role
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    // Jangan hapus role admin default (id=1)
    if ($id != 1) {
        mysqli_query($conn, "DELETE FROM role WHERE id=$id");
    }
    header("Location: index.php");
    exit();
}

// Ambil semua role
$result = mysqli_query($conn, "SELECT * FROM role ORDER BY id ASC");
?>

<h2>Manajemen Role</h2>

<form method="POST">
    <input type="text" name="name" placeholder="Nama role" required>
    <button type="submit" name="tambah">Tambah</button>
</form>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Nama Role</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td>
                <?php if ($row['id'] != 1) { // role admin default tidak boleh dihapus ?>
                    <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus role ini?')">Hapus</a>
                <?php } else { ?>
                    <i>(default)</i>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
</table>

<p><a href="../../dashboard.php">⬅️ Kembali ke Dashboard</a></p>
