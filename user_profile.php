<?php
session_start();

// Koneksi database menggunakan PDO
$host = 'localhost';
$dbname = 'papaw';
$username = 'root';
$password = '';

try {
    // Membuat koneksi PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Cek apakah pengguna sudah login
if (isset($_SESSION['user_id'])) {
    $idAkun = $_SESSION['user_id']; // Ambil ID akun dari session

    // Mengambil id_pengguna berdasarkan id_akun
    $queryPengguna = "SELECT id_pengguna FROM pengguna WHERE id_akun = ?";
    $stmtPengguna = $pdo->prepare($queryPengguna);
    $stmtPengguna->execute([$idAkun]);
    $pengguna = $stmtPengguna->fetch(PDO::FETCH_ASSOC);

    if ($pengguna) {
        $idPengguna = $pengguna['id_pengguna'];

        // Mengambil data akun dari database
        $query = "SELECT akun.*, pengguna.*, alamat.* 
                FROM akun 
                JOIN pengguna ON akun.id_akun = pengguna.id_akun
                JOIN alamat ON pengguna.id_alamat = alamat.id_alamat
                WHERE akun.id_akun = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$idAkun]);
        $akun = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$akun) {
            header('location: login.php');
            exit();
        }

        // Ambil riwayat artikel yang dibaca oleh pengguna
        $riwayatArtikel = [];
        $queryRiwayat = "SELECT riwayat.*, artikel.judul 
                        FROM riwayat
                        JOIN artikel ON riwayat.id_artikel = artikel.id_artikel
                        WHERE riwayat.user_id = ? 
                        ORDER BY riwayat.tanggal_baca DESC";
        $stmtRiwayat = $pdo->prepare($queryRiwayat);
        $stmtRiwayat->execute([$idAkun]);
        $riwayatArtikel = $stmtRiwayat->fetchAll(PDO::FETCH_ASSOC);

        // Ambil riwayat laporan
        $riwayatLaporan = [];
        $queryLaporan = "SELECT * 
                        FROM laporan 
                        WHERE laporan.id_pengguna = ?";
        $stmtLaporan = $pdo->prepare($queryLaporan);
        $stmtLaporan->execute([$idPengguna]);
        $riwayatLaporan = $stmtLaporan->fetchAll(PDO::FETCH_ASSOC);

        // Query untuk riwayat adopsi
        $riwayatAdopsi = [];
        $queryAdopsi = "SELECT a.id_adopsi, a.tanggal_adopsi, a.status_adopsi, 
                            hs.nama_hewan, s.nama_shelter
                        FROM adopsi a
                        JOIN hewan_shelter hs ON a.id_hewan = hs.id_hewan
                        JOIN shelter s ON a.id_shelter = s.id_shelter
                        WHERE a.id_pengguna = ?
                        ORDER BY a.tanggal_adopsi DESC";
        $stmtAdopsi = $pdo->prepare($queryAdopsi);
        $stmtAdopsi->execute([$idPengguna]);
        $riwayatAdopsi = $stmtAdopsi->fetchAll(PDO::FETCH_ASSOC);

        // Query untuk mengambil riwayat donasi dengan join ke tabel yang diperlukan
        $riwayatDonasi = [];
        $queryDonasi = "SELECT d.id_donasi, d.tanggal_submit, d.id_shelter, 
                            mp.nama_metode, p.nominal, p.bukti_transfer,
                            s.nama_shelter
                        FROM donasi d
                        JOIN metode_pembayaran mp ON d.id_metode = mp.id_metode
                        JOIN pembayaran p ON d.id_donasi = p.id_donasi
                        JOIN shelter s ON d.id_shelter = s.id_shelter
                        WHERE d.id_pengguna = ?
                        ORDER BY d.tanggal_submit DESC";
        $stmtDonasi = $pdo->prepare($queryDonasi);
        $stmtDonasi->execute([$idPengguna]);
        $riwayatDonasi = $stmtDonasi->fetchAll(PDO::FETCH_ASSOC);

        // Fungsi untuk mengupdate data akun
        function updateAkun($pdo, $idPengguna, $nama, $kontak, $alamat, $kota, $provinsi, $kodePos)
        {
            try {
                // Mulai transaksi
                $pdo->beginTransaction();

                // Update data pengguna
                $queryPengguna = "UPDATE pengguna SET nama = ?, kontak = ? WHERE id_pengguna = ?";
                $stmtPengguna = $pdo->prepare($queryPengguna);
                $stmtPengguna->execute([$nama, $kontak, $idPengguna]);

                // Update data alamat
                $queryAlamat = "UPDATE alamat 
                                SET alamat = ?, kota = ?, provinsi = ?, kode_pos = ? 
                                WHERE id_alamat = (SELECT id_alamat FROM pengguna WHERE id_pengguna = ?)";
                $stmtAlamat = $pdo->prepare($queryAlamat);
                $stmtAlamat->execute([$alamat, $kota, $provinsi, $kodePos, $idPengguna]);

                // Commit transaksi
                $pdo->commit();
                return true;
            } catch (Exception $e) {
                // Rollback jika terjadi error
                $pdo->rollBack();
                return false;
            }
        }

        // Menangani request form update akun
        $updateSuccess = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = $_POST['nama'];
            $kontak = $_POST['kontak'];
            $alamat = $_POST['alamat'];
            $kota = $_POST['kota'];
            $provinsi = $_POST['provinsi'];
            $kodePos = $_POST['kodePos'];

            // Memanggil fungsi update akun
            $updateSuccess = updateAkun($pdo, $idPengguna, $nama, $kontak, $alamat, $kota, $provinsi, $kodePos);
        }
    } else {
        echo "ID pengguna tidak ditemukan.";
        exit();
    }
}
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
      <!-- Swiper Styles -->
      <!-- <link rel="stylesheet" type="text/css" href="https://unpkg.com/swiper/swiper-bundle.min.css"> -->

      <link rel="stylesheet" href="CSS\user_profile.css">
    <title>Halaman Akun</title>
</head>
<body>
    <!-- ============ HEADER ============ -->
    <?php require_once('header.php'); ?>

    <main class="main">
        <section class="user_profile section" id="user">
            <div class="profile_container container">
                <h2>Data Akun</h2>
                <form method="POST">
                    <label for="nama">Nama:</label>
                    <input type="text" name="nama" value="<?php echo $akun['nama']; ?>" required><br>

                    <label for="kontak">Kontak:</label>
                    <input type="text" name="kontak" value="<?php echo $akun['kontak']; ?>" required><br>

                    <label for="alamat">Alamat:</label>
                    <textarea name="alamat" required><?php echo $akun['alamat']; ?></textarea><br>

                    <label for="kota">Kota:</label>
                    <input type="text" name="kota" value="<?php echo $akun['kota']; ?>" required><br>

                    <label for="provinsi">Provinsi:</label>
                    <input type="text" name="provinsi" value="<?php echo $akun['provinsi']; ?>" required><br>

                    <label for="kodePos">Kode Pos:</label>
                    <input type="text" name="kodePos" value="<?php echo $akun['kode_pos']; ?>" required><br>

                    <button type="submit">Update Akun</button>
                    <!-- Menampilkan pesan sukses atau gagal saat update -->
                    <?php if (isset($updateSuccess)): ?>
                        <?php if ($updateSuccess): ?>
                            <p style="color: green;">Data akun berhasil diupdate!</p>
                        <?php else: ?>
                            <p style="color: red;">Update data akun gagal. Silakan coba lagi.</p>
                        <?php endif; ?>
                    <?php endif; ?>
                </form>
                
            </div>
        </section>
        <section class="laporan_history section" id="laporan_history">
            <div class="laporan_history_container container">
                <h2>Riwayat Laporan</h2>
                <?php if (count($riwayatLaporan) > 0): ?>
                    <ul>
                        <?php foreach ($riwayatLaporan as $laporan): ?>
                            <li><?php echo $laporan['nama_laporan']; /* ?> - Laporan pada <?php echo $laporan['tanggal_laporan']; */?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Tidak ada riwayat laporan.</p>
                <?php endif; ?>
            </div>
        </section>
        <section class="adopsi_history section" id="adopsi_history">
        <div class="adopsi_history_container container">
            <h2>Riwayat Adopsi</h2>
            <?php if (count($riwayatAdopsi) > 0): ?>
                <ul>
                    <?php foreach ($riwayatAdopsi as $adopsi): ?>
                        <li>
                            <?php echo htmlspecialchars($adopsi['nama_hewan']); ?> 
                            dari <?php echo htmlspecialchars($adopsi['nama_shelter']); ?> - 
                            Diadopsi pada <?php echo date('d F Y', strtotime($adopsi['tanggal_adopsi'])); ?> 
                            (Status: <?php echo htmlspecialchars($adopsi['status_adopsi']); ?>)
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Tidak ada riwayat adopsi.</p>
            <?php endif; ?>
        </div>
    </section>
        <section class="donasi_history section" id="donasi_history">
            <div class="donasi_history_container container">
                <h2>Riwayat Donasi</h2>
                <?php if (count($riwayatDonasi) > 0): ?>
                    <div class="donasi-list">
                        <?php foreach ($riwayatDonasi as $donasi): ?>
                            <div class="donasi-item">
                                <div class="donasi-details">
                                    <h3>Donasi ke <?php echo htmlspecialchars($donasi['nama_shelter']); ?></h3>
                                    <p>Tanggal: <?php echo date('d F Y', strtotime($donasi['tanggal_submit'])); ?></p>
                                    <p>Nominal: Rp <?php echo number_format($donasi['nominal'], 0, ',', '.'); ?></p>
                                    <p>Metode Pembayaran: <?php echo htmlspecialchars($donasi['nama_metode']); ?></p>
                                    <?php if ($donasi['bukti_transfer']): ?>
                                        <div class="bukti-transfer">
                                            <img src="<?php echo htmlspecialchars($donasi['bukti_transfer']); ?>" alt="Bukti Transfer">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="no-history">Tidak ada riwayat donasi.</p>
                <?php endif; ?>
            </div>
        </section>
        <section class="artikel_history section" id="artikel_history">
            <div class="artikel_history_container container">
                <h2>Riwayat Artikel</h2>
                <?php if (count($riwayatArtikel) > 0): ?>
                    <ul>
                        <?php foreach ($riwayatArtikel as $riwayat): ?>
                            <li><?php echo $riwayat['judul']; ?> - Dibaca pada <?php echo $riwayat['tanggal_baca']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Tidak ada riwayat artikel.</p>
                <?php endif; ?>
            </div>
        </section>
        <button ><a href="logout.php" class="button">Logout</a></button>
    </main>

    <script src="JS\script.js"></script>
</body>
</html>
