<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="CSS/register.css">
    <!-- Tambahkan library ikon jika diperlukan -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
</head>
<body>
    <div class="register_container">
        <!-- Tombol Back -->
        <a href="login.php" class="back-button">
            <i class="ri-arrow-left-circle-fill"></i>Back
        </a>
        <div class="wrapper">
            <h1>Register</h1>
            <form method="POST" action="register.php">
                <div class="input-group">
                    <label for="username-input">
                        <i class="ri-user-line"></i>
                    </label>
                    <input required type="text" name="username" id="username-input" placeholder="Username">
                </div>

                <div class="input-group">
                    <label for="password-input">
                        <i class="ri-lock-line"></i>
                    </label>
                    <input required type="password" name="password" id="password-input" placeholder="Password">
                </div>

                <div class="input-group">
                    <label for="role-input">
                        <i class="ri-user-settings-line"></i>
                    </label>
                    <select name="role" id="role-input" required>
                        <option value="user">User</option>
                        <option value="shelter">Shelter</option>
                    </select>
                </div>

                <div class="input-group">
                    <label for="nama-input">
                        <i class="ri-user-3-line"></i>
                    </label>
                    <input required type="text" name="nama" id="nama-input" placeholder="Nama Lengkap/Nama Shelter">
                </div>

                <div class="input-group">
                    <label for="kontak-input">
                        <i class="ri-phone-line"></i>
                    </label>
                    <input required type="text" name="kontak" id="kontak-input" placeholder="Nomor Kontak">
                </div>

                <!-- Alamat -->
                <div class="input-group">
                    <label for="alamat-input">
                        <i class="ri-map-pin-line"></i>
                    </label>
                    <textarea required name="alamat" id="alamat-input" placeholder="Alamat"></textarea>
                </div>

                <div class="input-group">
                    <label for="kota-input">
                        <i class="ri-city-line"></i>
                    </label>
                    <input required type="text" name="kota" id="kota-input" placeholder="Kota">
                </div>

                <div class="input-group">
                    <label for="provinsi-input">
                        <i class="ri-map-pin-line"></i>
                    </label>
                    <input required type="text" name="provinsi" id="provinsi-input" placeholder="Provinsi">
                </div>

                <div class="input-group">
                    <label for="kodePos-input">
                        <i class="ri-map-pin-line"></i>
                    </label>
                    <input required type="text" name="kodePos" id="kodePos-input" placeholder="Kode Pos">
                </div>

                <!-- Tombol Register -->
                <button type="submit">Register</button>

            </form>

            <!-- Pesan notifikasi -->
            <div class="notification">
                <?php
                // Menampilkan semua error
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);

                // Koneksi ke database
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

                // Fungsi registrasi
                function register($pdo, $username, $password, $role, $nama, $kontak, $alamat, $kota, $provinsi, $kodePos) {
                    try {
                        $pdo->beginTransaction();

                        $queryAlamat = "INSERT INTO alamat (alamat, kota, provinsi, kode_pos) VALUES (?, ?, ?, ?)";
                        $stmtAlamat = $pdo->prepare($queryAlamat);
                        $stmtAlamat->execute([$alamat, $kota, $provinsi, $kodePos]);
                        $idAlamat = $pdo->lastInsertId();

                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        $queryAkun = "INSERT INTO akun (username, password, role) VALUES (?, ?, ?)";
                        $stmtAkun = $pdo->prepare($queryAkun);
                        $stmtAkun->execute([$username, $hashedPassword, $role]);
                        $idAkun = $pdo->lastInsertId();

                        if ($role === 'user') {
                            $queryPengguna = "INSERT INTO pengguna (id_alamat, id_akun, nama, kontak) VALUES (?, ?, ?, ?)";
                            $stmtPengguna = $pdo->prepare($queryPengguna);
                            $stmtPengguna->execute([$idAlamat, $idAkun, $nama, $kontak]);
                        } else if ($role === 'shelter') {
                            $queryShelter = "INSERT INTO shelter (id_alamat, id_akun, nama_shelter, kontak) VALUES (?, ?, ?, ?)";
                            $stmtShelter = $pdo->prepare($queryShelter);
                            $stmtShelter->execute([$idAlamat, $idAkun, $nama, $kontak]);
                        }

                        $pdo->commit();
                        // Setelah registrasi berhasil, arahkan ke halaman login
                        header("Location: login.php");
                        exit(); // Pastikan untuk menghentikan eksekusi lebih lanjut setelah redirect
                    } catch (Exception $e) {
                        $pdo->rollBack();
                        echo "<p style='color: red;'>Registrasi gagal: " . $e->getMessage() . "</p>";
                    }
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $role = $_POST['role'];
                    $nama = $_POST['nama'];
                    $kontak = $_POST['kontak'];
                    $alamat = $_POST['alamat'];
                    $kota = $_POST['kota'];
                    $provinsi = $_POST['provinsi'];
                    $kodePos = $_POST['kodePos'];

                    register($pdo, $username, $password, $role, $nama, $kontak, $alamat, $kota, $provinsi, $kodePos);
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
