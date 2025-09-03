<?php
session_start();

// Hapus semua session
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <!-- ✅ SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil Logout',
        text: 'Anda telah keluar dari sistem.',
        confirmButtonColor: '#3085d6'
    }).then(() => {
        window.location.href = "login.php"; // arahkan ke login
    })
</script>
</body>
</html>
