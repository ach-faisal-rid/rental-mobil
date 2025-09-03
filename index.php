<?php
session_start();

// Jika sudah login langsung arahkan ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Mobil Sederhana</title>
    <!-- ✅ Tambah Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">

    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md text-center">
            <h1 class="text-2xl font-bold text-blue-600 mb-4">🚗 Selamat Datang di Rental Mobil</h1>
            <p class="text-gray-600 mb-6">Website sederhana untuk penyewaan mobil.</p>

            <h3 class="text-lg font-semibold mb-3">Menu</h3>
            <ul class="space-y-3">
                <li>
                    <a href="auth/login.php"
                        class="block w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition">
                        Login
                    </a>
                </li>
                <li>
                    <a href="auth/register.php"
                        class="block w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition">
                        Register
                    </a>
                </li>
            </ul>
        </div>
    </div>

</body>

</html>