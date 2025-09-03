<?php
session_start();

// Jika belum login, arahkan ke index
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Ambil data dari session
$name = $_SESSION['name'];
$role_id = $_SESSION['role_id']; // 1 = admin, 2 = user
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- ✅ Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="max-w-3xl mx-auto mt-10 bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Dashboard</h1>
        <p class="mb-6 text-gray-600">
            Halo, <b class="text-blue-600"><?php echo $name; ?></b>! Anda login sebagai 
            <b class="text-green-600"><?php echo ($role_id == 1) ? "Admin" : "User"; ?></b>.
        </p>

        <h3 class="text-lg font-semibold text-gray-700 mb-3">📌 Menu</h3>

        <?php if ($role_id == 1) { ?>
            <!-- Menu Admin -->
            <ul class="space-y-2">
                <li><a href="admin/mobil/index.php" class="block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Kelola Mobil</a></li>
                <li><a href="admin/role/index.php" class="block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Kelola Role</a></li>
                <li><a href="admin/users/index.php" class="block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Kelola Users</a></li>
                <li><a href="admin/pelanggan/index.php" class="block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Kelola Pelanggan</a></li>
                <li><a href="admin/transaksi/index.php" class="block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Kelola Transaksi</a></li>
            </ul>
        <?php } else { ?>
            <!-- Menu User -->
            <ul class="space-y-2">
                <li><a href="user/sewa/index.php" class="block px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Sewa Mobil</a></li>
                <li><a href="user/transaksi/index.php" class="block px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Transaksi Saya</a></li>
            </ul>
        <?php } ?>

        <div class="mt-6">
            <a href="auth/logout.php" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Logout</a>
        </div>
    </div>
</body>
</html>
