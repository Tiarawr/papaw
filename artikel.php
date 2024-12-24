<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.css">
    <!-- Slick CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link rel="stylesheet" href="CSS/artikel.css">
    <title>Artikel</title>
</head>
<body>
          <!--==================== HEADER ====================-->
    <?php require_once('header.php'); ?>

    <main class="main">
    <div class="container">
        <!-- Form pencarian -->
        <form action="artikel.php" method="get" class="search-form mb-4">
            <input type="text" name="search" placeholder="Cari artikel..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">Cari</button>
        </form>

        <div class="articles-grid">
            <?php
            // Koneksi ke database
            $conn = new mysqli('localhost', 'root', '', 'papaw');

            // Cek koneksi
            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }

            // Mengambil query pencarian (jika ada)
            $search_query = isset($_GET['search']) ? $_GET['search'] : '';

            // Query untuk mengambil artikel, jika ada kata kunci pencarian
            if ($search_query) {
                $sql = "SELECT * FROM artikel WHERE judul LIKE ? OR konten LIKE ? ORDER BY tanggal_publish DESC";
                $stmt = $conn->prepare($sql);
                $search_term = "%" . $search_query . "%";
                $stmt->bind_param("ss", $search_term, $search_term);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                $sql = "SELECT * FROM artikel ORDER BY tanggal_publish DESC";
                $result = $conn->query($sql);
            }

            // Menampilkan artikel
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Artikel dibungkus dalam <a> untuk mengarah ke artikel lengkap
                    echo "<div class='article-card' style='background-image: url(\"assets/img/" . $row['gambar'] . "\");'>";
                    echo "<a href='artikel-lengkap.php?id_artikel=" . $row['id_artikel'] . "' class='article-overlay'>";
                    echo "<div class='article-content'>";
                    echo "<p>" . substr($row['konten'], 0, 100) . "...</p>";
                    echo "</div>";
                    echo "</a>";
                    echo "</div>";
                }
            } else {
                echo "<p>Tidak ada artikel yang ditemukan untuk kata kunci: <strong>" . htmlspecialchars($search_query) . "</strong></p>";
            }

            $conn->close();
            ?>
        </div>
    </div>
    </main>
    
    <!--==================== FOOTER ====================-->
    <?php require_once('footer.php'); ?>

    <script src="JS/script.js"></script>
</body>
</html>
