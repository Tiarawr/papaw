<?php
// Mulai session untuk mengecek login pengguna
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Koneksi ke database
$pdo = new PDO("mysql:host=localhost;dbname=papaw;charset=utf8", 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        echo "Password baru dan konfirmasi password tidak cocok!";
    } else {
        // Ambil password yang sudah di-hash dari database
        $stmt = $pdo->prepare("SELECT password FROM akun WHERE id_akun = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($currentPassword, $user['password'])) {
            // Password lama cocok, hash password baru dan update ke database
            $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);
            $updateStmt = $pdo->prepare("UPDATE akun SET password = ? WHERE id_akun = ?");
            $updateStmt->execute([$newPasswordHash, $_SESSION['user_id']]);
            echo "Password berhasil diubah!";
        } else {
            echo "Password lama tidak sesuai!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Password</title>
</head>
<body>
    <!-- Form untuk mengubah password -->
    <form method="POST">
        <label>Password Lama:</label>
        <input type="password" name="current_password" required>
        <label>Password Baru:</label>
        <input type="password" name="new_password" required>
        <label>Konfirmasi Password Baru:</label>
        <input type="password" name="confirm_password" required>
        <button type="submit">Ubah Password</button>
    </form>  
</body>
</html>


