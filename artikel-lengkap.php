<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.css">
    <!-- Slick CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link rel="stylesheet" href="CSS/artikel-lengkap.css">
    <title>
        <?php
        // Koneksi ke database
        $conn = new mysqli('localhost', 'root', '', 'papaw');

        // Cek koneksi
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Ambil ID artikel dari URL (parameter id_artikel)
        $id_artikel = isset($_GET['id_artikel']) ? (int)$_GET['id_artikel'] : 0;

        // Query untuk mendapatkan artikel lengkap berdasarkan id_artikel
        $sql = "SELECT * FROM artikel WHERE id_artikel = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_artikel);  // "i" menunjukkan tipe data integer
        $stmt->execute();
        $result = $stmt->get_result();

        // Menampilkan artikel dan set title
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo $row['judul']; // Set title sesuai dengan judul artikel
        } else {
            echo "Artikel Tidak Ditemukan";
        }

        $conn->close();
        ?>
    </title>
</head>
<body>
    <!--==================== HEADER ====================-->
    <?php require_once('header.php'); ?>
    <!-- ============ MAIN ================= -->
    <main class="main">
        <section class="artikel_lengkap section">
            <div class="artikel_container container">
                <div class="artikel_left">
                    <?php
                    // Koneksi database
                    $host = 'localhost';
                    $dbname = 'papaw';
                    $username = 'root';
                    $password = '';

                    try {
                        // Menghapus bagian port
                        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    } catch (PDOException $e) {
                        die("Koneksi gagal: " . $e->getMessage());
                    }

                    // Cek apakah pengguna sudah login
                    if (isset($_SESSION['user_id'])) {
                        $userId = $_SESSION['user_id']; // Ambil ID pengguna dari session

                        // Koneksi ke database
                        $conn = new mysqli('localhost', 'root', '', 'papaw');
                        if ($conn->connect_error) {
                            die("Koneksi gagal: " . $conn->connect_error);
                        }

                        // Ambil ID artikel dari URL
                        $id_artikel = isset($_GET['id_artikel']) ? (int)$_GET['id_artikel'] : 0;

                        // Query untuk mendapatkan artikel lengkap berdasarkan id_artikel
                        $sql = "SELECT * FROM artikel WHERE id_artikel = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $id_artikel);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Menampilkan artikel
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            echo "<h1>" . $row['judul'] . "</h1>";

                            // Menampilkan gambar dengan tag <img> yang benar
                            echo "<div class='swiper-slide article-card'>";
                            echo "<img src='assets/img/" . $row['gambar'] . "' alt='" . $row['judul'] . "' class='article-image'>";
                            echo "<p><strong>Penulis:</strong> " . $row['penulis'] . " | <strong>Tanggal:</strong> " . $row['tanggal_publish'] . "</p>";
                            echo "<div>" . $row['konten'] . "</div>";
                            echo "</div>";

                            // Insert riwayat artikel yang dibaca oleh pengguna
                            $sqlRiwayat = "INSERT INTO riwayat (user_id, id_artikel) VALUES (?, ?)";
                            $stmtRiwayat = $conn->prepare($sqlRiwayat);
                            $stmtRiwayat->bind_param("ii", $userId, $id_artikel);
                            $stmtRiwayat->execute();
                        } else {
                            echo "<p>Artikel tidak ditemukan.</p>";
                        }

                        $conn->close();
                    } else {
                        // Pengguna tidak login
                        echo "<p>Anda harus login untuk melihat artikel.</p>";
                    }
                    ?>
                </div>
                <div class="artikel_right">
                    <?php
                        // Koneksi ke database
                        $conn = new mysqli('localhost', 'root', '', 'papaw');

                        // Cek koneksi
                        if ($conn->connect_error) {
                            die("Koneksi gagal: " . $conn->connect_error);
                        }

                        // Ambil ID artikel dari URL (parameter id_artikel)
                        $id_artikel = isset($_GET['id_artikel']) ? (int)$_GET['id_artikel'] : 0;

                        // Query untuk mendapatkan artikel lengkap berdasarkan id_artikel
                        $sql = "SELECT * FROM artikel WHERE id_artikel != ? ORDER BY tanggal_publish DESC LIMIT 3";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $id_artikel);  // "i" menunjukkan tipe data integer
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Menampilkan artikel di artikel_right
                        echo "<h4>Artikel Terkini</h4>";
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<div class='artikel-item'>";
                                echo "<a href='artikel-lengkap.php?id_artikel=" . $row['id_artikel'] . "'>";
                                echo "<img src='assets/img/" . $row['gambar'] . "' alt='" . $row['judul'] . "' class='artikel-thumbnail'>";
                                echo "<p>" . $row['judul'] . "</p>";
                                echo "</a>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>Tidak ada artikel lainnya.</p>";
                        }
                        

                        $conn->close();
                    ?>
                </div>
            </div>

        </section>
    </main>

    <!--==================== FOOTER ====================-->
    <?php require_once('footer.php'); ?>

      <script src="JS/script.js"></script>
</body>
</html>
