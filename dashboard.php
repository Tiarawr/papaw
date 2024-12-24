<?php
// Mulai session
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Pengguna belum login, arahkan kembali ke halaman login

}

// Jika pengguna sudah login, tampilkan konten halaman
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>

    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <p>You are successfully logged in. This is your dashboard.</p>

    <!-- Menampilkan User ID dan Username -->
    <p><strong>User ID:</strong> <?php echo $_SESSION['user_id']; ?></p>
    <p><strong>Username:</strong> <?php echo $_SESSION['username']; ?></p>

    <a href="logout.php">Logout</a>

    <footer>
        <p>© 2024 Papaw Care. All rights reserved.</p>
    </footer>

</body>
</html>
