<?php
// Mulai session untuk mengecek status login
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Sertakan file koneksi.php
require('koneksi.php');

// Query untuk mengambil data dari tabel hewan_shelter dan bergabung dengan tabel shelter dan alamat
$sql = "
    SELECT hs.*, s.nama_shelter, a.alamat
    FROM hewan_shelter hs
    JOIN shelter s ON hs.id_shelter = s.id_shelter
    JOIN alamat a ON s.id_alamat = a.id_alamat
"; // Pastikan nama tabel sesuai dengan yang ada di database
$result = $conn->query($sql);

// Mengecek apakah query berhasil
if (!$result) {
    die("Query gagal: " . $conn->error); // Menampilkan pesan kesalahan jika query gagal
}

// Mengecek apakah ada data yang ditemukan
if ($result->num_rows > 0) {
    // Mulai output HTML
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
  <link rel="stylesheet" href="CSS/adopsi.css">
  <title>Adopsi Hewan</title>
  <style>
    /* Main content styling */
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #fbdbc6;
    }

    /* Center the title and the content */
    .content {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 20px;
      margin-top: 5rem;
      margin-bottom: 5rem;
    }

    h2 {
      font-size: 2rem;
      text-align: center;
      margin-bottom: 2rem;
    }

    .dog-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }

    .dog-card {
      border: 1px solid #ddd;
      border-radius: 10px;
      overflow: hidden;
      width: 250px;
      text-align: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .dog-card:hover {
      transform: scale(1.05);
    }

    .dog-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .dog-card .info {
      padding: 15px;
    }

    .dog-card .info h3 {
      font-size: 1.2rem;
      margin: 0 0 10px;
    }

    .dog-card .info p {
      font-size: 0.9rem;
      color: #555;
    }

    /* Tombol Adopsi */
    .adopt-btn {
      background-color: #28a745;
      color: white;
      padding: 12px 30px; /* Padding yang lebih besar */
      border: none;
      cursor: pointer;
      margin-top: 10px;
      font-size: 1rem;
      border-radius: 12px; /* Rounded sedikit */
      transition: background-color 0.3s ease;
    }

    .adopt-btn:hover {
      background-color: #218838; /* Mengubah warna saat hover */
    }

    /* Tombol disabled */
    .adopt-btn.disabled {
      background-color: #ccc;
      cursor: not-allowed;
    }

    .adopt-btn.disabled:hover {
      background-color: #ccc; /* Menonaktifkan efek hover pada tombol yang disabled */
    }
  </style>
</head>
<body>

  <?php require_once('header.php'); ?>
  
  <!-- Bagian untuk user -->
  <section class="adopsi section" id="adopsi">
    <div class="content">
        <h2>Adopsi Hewan</h2>
        <div class="dog-container">
        <?php
        // Loop untuk menampilkan data setiap hewan
        while ($row = $result->fetch_assoc()) {
            // Mengecek apakah status hewan sudah 'diadopsi'
            $isAdopted = ($row['status'] == 'diadopsi');
        ?>
            <div class="dog-card">
            <img src="assets/img/<?php echo $row['foto_hewan']; ?>" alt="Foto Hewan">
            <div class="info">
                <h3><?php echo $row['nama_hewan']; ?></h3>
                <p>Jenis: <?php echo $row['jenis_hewan']; ?></p>
                <p>Status: <?php echo $row['status']; ?></p>
                <p>Keterangan: <?php echo $row['keterangan_hewan']; ?></p>
                <p>Shelter: <?php echo $row['nama_shelter']; ?></p>
                <p>Alamat: <?php echo $row['alamat']; ?></p>

                <!-- Form untuk mengarahkan ke adopsi_form.php -->
                <form action="adopsi_form.php" method="POST">
                <input type="hidden" name="id_hewan" value="<?php echo $row['id_hewan']; ?>">
                <input type="hidden" name="id_shelter" value="<?php echo $row['id_shelter']; ?>">

                <!-- Menonaktifkan tombol adopsi jika status hewan sudah "diadopsi" atau jika pengguna belum login -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <button type="submit" class="adopt-btn <?php echo ($isAdopted ? 'disabled' : ''); ?>" <?php echo ($isAdopted ? 'disabled' : ''); ?>>
                        <?php echo ($isAdopted ? 'Sudah Diadopsi' : 'Adopsi'); ?>
                    </button>
                <?php else: ?>
                    <a href="login.php" class="adopt-btn">Login untuk Adopsi</a>
                <?php endif; ?>
                </form>
            </div>
            </div>
        <?php
        }
        ?>
        </div>
    </div>
   </section>

  <!-- ============= FOOTER ============ -->
  <?php require_once('footer.php'); ?>

  <!-- ============= MAIN JAVASCRIPT ============ -->
  <script src="script.js"></script>
</body>
</html>

<?php
} else {
    echo "Tidak ada hewan yang tersedia untuk adopsi.";
}

// Menutup koneksi
$conn->close();
?>
