<?php
session_start();
require 'koneksi.php'; // Pastikan file koneksi.php berada di direktori yang benar

// Periksa apakah pengguna memiliki role 'shelter'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'shelter') {
    header("Location: login.php");
    exit;
}

// Ambil data laporan dari database
$query = "SELECT laporan.*, hewan.jenis_hewan 
          FROM laporan 
          JOIN hewan ON laporan.id_hewan = hewan.id_hewan 
          ORDER BY tanggal_laporan DESC";
$result = $conn->query($query);

if (!$result) {
    die("Query gagal: " . $conn->error);
}

// Proses perubahan status laporan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_laporan'], $_POST['status_laporan'])) {
    $idLaporan = intval($_POST['id_laporan']);
    $statusLaporan = $conn->real_escape_string($_POST['status_laporan']);

    // Update status laporan
    $updateQuery = "UPDATE laporan SET status_laporan = '$statusLaporan' WHERE id_laporan = $idLaporan";
    if ($conn->query($updateQuery)) {
        $notif = "Status laporan berhasil diperbarui!";
    } else {
        $notif = "Gagal memperbarui status laporan: " . $conn->error;
    }
    header("Location: shelter_pelaporan.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="CSS/pelaporan.css">
    <link rel="stylesheet" href="CSS/shelter_pelaporan.css">
    <title>Daftar Laporan - Shelter</title>
    <style>
        /* Tambahan style untuk tabel */
        .pelaporan_container table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            background: white;
            border-radius: 8px;
        }
        .pelaporan_container table th, .pelaporan_container table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        .pelaporan_container table th {
            background-color: var(--input-color);
        }
        .pelaporan_container form select,
        .pelaporan_container form button {
            margin: 5px 0;
        }

        /* Tambahan CSS untuk mencegah footer menimpa konten */
        /* body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        main {
            flex: 1;
        }
        footer {
            background: #f1f1f1;
            padding: 10px 0;
            text-align: center;
        } */
    </style>
</head>
<body>
    <?php require_once('shelter_header.php'); ?>

    <main class="main">
        <section class="pelaporan section" id="laporan">
            <div class="pelaporan_container container">
                <h1>Daftar Laporan</h1>
                <?php if (isset($notif)) { echo "<p>$notif</p>"; } ?>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Laporan</th>
                            <th>Jenis Hewan</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Tanggal Laporan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php $no = 1; ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($row['nama_laporan']); ?></td>
                                    <td><?= htmlspecialchars($row['jenis_hewan']); ?></td>
                                    <td><?= htmlspecialchars($row['keterangan']); ?></td>
                                    <td><?= htmlspecialchars($row['status_laporan']); ?></td>
                                    <td><?= htmlspecialchars($row['tanggal_laporan']); ?></td>
                                    <td>
                                        <form method="POST" action="">
                                            <input type="hidden" name="id_laporan" value="<?= $row['id_laporan']; ?>">
                                            <select name="status_laporan">
                                                <option value="pending" <?= $row['status_laporan'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                <option value="proses" <?= $row['status_laporan'] === 'proses' ? 'selected' : ''; ?>>Proses</option>
                                                <option value="selesai" <?= $row['status_laporan'] === 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                                            </select>
                                            <button type="submit">Ubah</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">Tidak ada laporan ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <?php require_once('footer.php'); ?>
    <script src="JS/script.js"></script>
</body>
</html>
