<?php
// Mulai session di awal halaman
session_start();

// Konfigurasi koneksi database
$host = 'localhost';
$dbname = 'papaw';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Fungsi untuk melakukan login
function login($pdo, $username, $password)
{
    try {
        // Query untuk mengecek apakah username ada di database
        $query = "SELECT * FROM akun WHERE username = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Set session untuk pengguna
            $_SESSION['user_id'] = $user['id_akun'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];  // Menyimpan role pengguna

            // Arahkan pengguna ke halaman berdasarkan role
            if ($user['role'] === 'shelter') {
                header('Location: shelter.php');
            } else {
                header('Location: index.php');
            }
            exit; // Menghentikan eksekusi setelah header
        } else {
            return "Username atau password salah!";
        }
    } catch (PDOException $e) {
        return "Login gagal: " . $e->getMessage();
    }
}

// Menangani request form
$loginMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Memanggil fungsi login
    $loginMessage = login($pdo, $username, $password);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.css">

    <link rel="stylesheet" href="CSS\login.css">
    <title>Login</title>
</head>
<body>
    <!-- Halaman Login -->
    <div class="login_container">
        <!-- Tombol Back -->
        <a href="index.php" class="back-button">
            <i class="ri-arrow-left-circle-fill"></i>Back
        </a>
        <div class="wrapper">
            <h1>Login</h1>
            <form method="POST" action="login.php">
                <div class="input-group">
                    <label for="username-input">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                            <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Z"/>
                        </svg>
                    </label>
                    <input required type="text" name="username" id="username-input" placeholder="Username">
                </div>
                <div class="input-group">
                    <label for="password-input">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="http://www.w3.org/2000/svg" width="24px" fill="#e8eaed">
                            <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z"/>
                        </svg>
                    </label>
                    <input required type="password" name="password" id="password-input" placeholder="Password">
                    <span class="password-toggle" id="toggle-password">
                        <i class="ri-eye-line" id="eye-icon"></i>
                    </span>
                </div>
                <button type="submit">Login</button>

                <?php if ($loginMessage): ?>
                    <p style="color: red;"><?php echo $loginMessage; ?></p>
                <?php endif; ?>
            </form>
            <p>Belum punya akun? <a href="register.php">Daftar</a></p>
        </div>
        <!-- Gambar -->
        <div class="image">
            <img src="assets/cats.jpg" alt="image">
        </div>
    </div>

    <!-- Password Visible -->
    <script src="JS\password.js"></script>
</body>
</html>
