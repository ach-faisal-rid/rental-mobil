<?php
include '../config.php';

$register_error = "";
$register_success = "";

if (isset($_POST['register'])) {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = md5($_POST['password']); // ⚠️ MD5 hanya contoh, di produksi sebaiknya bcrypt
    $role_id  = 2; // default role: user/pelanggan

    // Cek apakah email sudah terdaftar
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        $register_error = "Email sudah terdaftar!";
    } else {
        // Simpan user
        mysqli_query($conn, "INSERT INTO users (name, email, password, role_id) 
                        VALUES ('$name','$email','$password','$role_id')");

        // Ambil ID user yang baru dibuat
        $user_id = mysqli_insert_id($conn);

        // Buat data pelanggan otomatis
        mysqli_query($conn, "INSERT INTO pelanggan (user_id, name, alamat, nomor) 
                        VALUES ('$user_id','$name','','')");

        $register_success = "Registrasi berhasil! Silakan login.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Rental Mobil</title>
    <!-- ✅ Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- ✅ SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold text-center text-blue-600 mb-6">Registrasi</h1>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-left font-medium text-gray-700">Nama</label>
                <input type="text" name="name" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
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
            <button type="submit" name="register"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg font-semibold transition">
                Register
            </button>
        </form>

        <p class="text-center mt-4 text-gray-600">
            Sudah punya akun? <a href="login.php" class="text-blue-500 font-semibold">Login di sini</a>
        </p>
    </div>

    <?php if ($register_error): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal Registrasi',
                text: '<?= $register_error ?>',
                confirmButtonColor: '#d33'
            })
        </script>
    <?php endif; ?>

    <?php if ($register_success): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= $register_success ?>',
                confirmButtonColor: '#3085d6'
            }).then(() => {
                window.location.href = "login.php"; // redirect ke login
            })
        </script>
    <?php endif; ?>

</body>

</html>