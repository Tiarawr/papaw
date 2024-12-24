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

    // Query untuk mengambil data adopsi yang terkait dengan shelter
    $query_adopsi = "SELECT a.id_adopsi, hs.nama_hewan, hs.jenis_hewan, a.status_adopsi, p.nama AS nama_pengadopsi, p.kontak, a.tanggal_adopsi
                 FROM adopsi a
                 JOIN hewan_shelter hs ON a.id_hewan = hs.id_hewan
                 JOIN pengguna p ON a.id_pengguna = p.id_pengguna
                 WHERE a.id_shelter = '$id_shelter'";
    $result_adopsi = mysqli_query($conn, $query_adopsi);
} else {
    echo "Data shelter tidak ditemukan.";
    exit();
}

// Proses perubahan status adopsi jika ada permintaan dari form
if (isset($_POST['update_status'])) {
    $id_adopsi = $_POST['id_adopsi'];
    $status = $_POST['status'];

    // Prepared statement untuk update adopsi
    $stmt_adopsi = $conn->prepare("UPDATE adopsi SET status_adopsi = ? WHERE id_adopsi = ?");
    $stmt_adopsi->bind_param("si", $status, $id_adopsi);
    $stmt_adopsi->execute();

    // Prepared statement untuk update hewan shelter
    if ($status == 'diterima') {
        $status_hewan = 'diadopsi';
    } else {
        $status_hewan = $status;
    }

    $stmt_hewan = $conn->prepare("UPDATE hewan_shelter SET status = ? WHERE id_hewan = (SELECT id_hewan FROM adopsi WHERE id_adopsi = ?)");
    $stmt_hewan->bind_param("si", $status_hewan, $id_adopsi);
    $stmt_hewan->execute();

    header("Location: " . $_SERVER['PHP_SELF']);
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
    <title>Laporan Adopsi</title>
</head>
<?php include 'shelter_header.php'; ?>
<body>
    <div class="wrapper">
        <h1>Laporan Adopsi</h1>
        
        <h2>Daftar Adopsi</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama Hewan</th>
                    <th>Jenis Hewan</th>
                    <th>Status</th>
                    <th>Nama Pengadopsi</th>
                    <th>Kontak</th>
                    <th>Tanggal Adopsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Periksa apakah ada data adopsi yang ditemukan
                if (mysqli_num_rows($result_adopsi) > 0) {
                    while ($row = mysqli_fetch_assoc($result_adopsi)) {
                ?>
                    <tr>
                        <!-- Tampilkan nama hewan dengan sanitasi -->
                        <td><?php echo htmlspecialchars($row['nama_hewan']); ?></td>

                        <!-- Tampilkan jenis hewan dengan sanitasi -->
                        <td><?php echo htmlspecialchars($row['jenis_hewan']); ?></td>

                        <!-- Tampilkan status adopsi dengan sanitasi -->
                        <td><?php echo htmlspecialchars($row['status_adopsi']); ?></td>

                        <!-- Tampilkan nama pengadopsi dengan sanitasi -->
                        <td><?php echo htmlspecialchars($row['nama_pengadopsi']); ?></td>

                        <!-- Tampilkan kontak pengadopsi dengan sanitasi -->
                        <td><?php echo htmlspecialchars($row['kontak']); ?></td>

                        <!-- Tampilkan tanggal adopsi dengan sanitasi -->
                        <td><?php echo htmlspecialchars($row['tanggal_adopsi']); ?></td>

                        <td>
                            <!-- Form untuk mengubah status adopsi -->
                            <form method="post" action="">
                                <input type="hidden" name="id_adopsi" value="<?php echo $row['id_adopsi']; ?>">
                                <select name="status">
                                    <option value="pending" <?php if ($row['status_adopsi'] == 'pending') echo 'selected'; ?>>Pending</option>
                                    <option value="diterima" <?php if ($row['status_adopsi'] == 'diterima') echo 'selected'; ?>>Diterima</option>
                                    <option value="ditolak" <?php if ($row['status_adopsi'] == 'ditolak') echo 'selected'; ?>>Ditolak</option>
                                </select>
                                <button type="submit" name="update_status">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php
                    }
                } else {
                ?>
                    <tr>
                        <!-- Pesan jika tidak ada data adopsi yang ditemukan -->
                        <td colspan="7">Belum ada adopsi yang ditemukan untuk shelter Anda.</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <!-- Tombol untuk kembali ke halaman shelter -->
        <a href="shelter.php" class="btn-back">Kembali ke Shelter</a>
    </div>

    <?php require_once('footer.php'); ?>
    <script src="JS\script.js"></script>
</body>
</html>

<?php
// Menutup koneksi ke database
mysqli_close($conn);
?>