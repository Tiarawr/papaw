<?php
session_start();
require 'koneksi.php';

// Periksa apakah session user_id tersedia
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil id_akun dari session
$id_akun = $_SESSION['user_id'];

// Query untuk mengambil id_shelter berdasarkan id_akun
$query_shelter = "SELECT id_shelter FROM shelter WHERE id_akun = '$id_akun'";
$result_shelter = mysqli_query($conn, $query_shelter);

if (mysqli_num_rows($result_shelter) > 0) {
    $row_shelter = mysqli_fetch_assoc($result_shelter);
    $id_shelter = $row_shelter['id_shelter'];

    // Query untuk mengambil data donasi yang terkait dengan shelter
    $query_donasi = "SELECT d.id_donasi, p.nama, p.kontak, pm.nominal, d.tanggal_submit, pm.bukti_transfer 
                     FROM donasi d
                     JOIN pengguna p ON d.id_pengguna = p.id_pengguna
                     JOIN pembayaran pm ON d.id_donasi = pm.id_donasi
                     WHERE d.id_shelter = '$id_shelter'";
    $result_donasi = mysqli_query($conn, $query_donasi);
} else {
    echo "Data shelter tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.css">
    <link rel="stylesheet" href="CSS/donasi_pelaporan.css">
    <title>Donasi Pelaporan</title>
</head>
<?php include 'shelter_header.php'; ?>
<body>
    <div class="wrapper">
        <h1>Donasi Pelaporan</h1>
        
        <h2>Daftar Donasi</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama Donatur</th>
                    <th>Kontak</th>
                    <th>Bukti Pembayaran</th>
                    <th>Nominal</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Periksa apakah ada data donasi yang ditemukan
                if (mysqli_num_rows($result_donasi) > 0) {
                    while ($row = mysqli_fetch_assoc($result_donasi)) {
                ?>
                    <tr>
                        <!-- Tampilkan nama donatur dengan sanitasi -->
                        <td><?php echo htmlspecialchars($row['nama']); ?></td>

                        <!-- Tampilkan kontak donatur dengan sanitasi -->
                        <td><?php echo htmlspecialchars($row['kontak']); ?></td>

                        <!-- Tampilkan bukti pembayaran sebagai link atau teks -->
                        <td><a href="<?php echo htmlspecialchars($row['bukti_transfer']); ?>" target="_blank">Lihat Bukti</a></td>

                        <!-- Format nominal dengan pemisah ribuan -->
                        <td><?php echo number_format($row['nominal'], 0, ",", "."); ?></td>

                        <!-- Tampilkan tanggal donasi dengan sanitasi -->
                        <td><?php echo htmlspecialchars($row['tanggal_submit']); ?></td>
                    </tr>
                <?php
                    }
                } else {
                ?>
                    <tr>
                        <!-- Pesan jika tidak ada data donasi yang ditemukan -->
                        <td colspan="5">Belum ada donasi yang ditemukan untuk shelter Anda.</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <!-- Tombol untuk kembali ke halaman shelter -->
        <a href="shelter.php" class="btn-back">Kembali ke Shelter</a>
    </div>
    <script src="JS\script.js"></script>
</body>
</html>

<?php
// Menutup koneksi ke database
mysqli_close($conn);
?>