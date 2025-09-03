<?php
include '../config.php';

$login_error = ""; // untuk menyimpan pesan error

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass  = md5($_POST['password']); // ⚠️ MD5 sebaiknya diganti bcrypt di produksi

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$pass'");
    $user  = mysqli_fetch_assoc($query);

    if ($user) {
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['role_id']  = $user['role_id'];
        $_SESSION['name']     = $user['name'];

        header("Location: ../dashboard.php");
        exit();
    } else {
        $login_error = "Login gagal! Email atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rental Mobil</title>
    <!-- ✅ Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- ✅ SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold text-center text-blue-600 mb-6">Login</h1>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-left font-medium text-gray-700">Email</label>
                <input type="email" name="email" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-left font-medium text-gray-700">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <button type="submit" name="login"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg font-semibold transition">
                Login
            </button>
            <p class="text-center text-gray-600">Belum punya akun? <a href="register.php" class="text-blue-500 hover:underline">Register</a></p>
        </form>
    </div>

    <?php if ($login_error): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= $login_error ?>',
                confirmButtonColor: '#3085d6'
            })
        </script>
    <?php endif; ?>

</body>

</html>