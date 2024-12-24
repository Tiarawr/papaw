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
    $userId = $_SESSION['user_id']; // Ambil ID pengguna dari session

    // Mengambil data shelter, akun, dan alamat berdasarkan ID akun pengguna
    $queryShelter = "SELECT s.*, a.username, al.alamat, al.kota, al.provinsi, al.kode_pos 
                    FROM shelter s
                    INNER JOIN akun a ON s.id_akun = a.id_akun
                    INNER JOIN alamat al ON s.id_alamat = al.id_alamat
                    WHERE s.id_akun = ?";
    $stmtShelter = $pdo->prepare($queryShelter);
    $stmtShelter->execute([$userId]);
    $shelter = $stmtShelter->fetch(PDO::FETCH_ASSOC);

    if ($shelter === false) {
        // Jika data shelter tidak ditemukan
        echo "Data shelter tidak ditemukan.";
        exit();
    }

    // Fungsi untuk memperbarui shelter dan akun
    function updateShelterAkun($pdo, $userId, $username, $password, $namaShelter, $kontak, $deskripsiShelter, $alamat, $kota, $provinsi, $kodePos)
    {
        try {
            // Mulai transaksi
            $pdo->beginTransaction();

            // Update data shelter (termasuk kontak dan deskripsi)
            $queryShelter = "UPDATE shelter SET nama_shelter = ?, kontak = ?, deskripsi_shelter = ? WHERE id_akun = ?";
            $stmtShelter = $pdo->prepare($queryShelter);
            $stmtShelter->execute([$namaShelter, $kontak, $deskripsiShelter, $userId]);

            // Jika password diisi, update password akun
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Enkripsi password
                $queryAkun = "UPDATE akun SET password = ? WHERE id_akun = ?";
                $stmtAkun = $pdo->prepare($queryAkun);
                $stmtAkun->execute([$hashedPassword, $userId]);
            }

            // Update data alamat
            $queryAlamat = "UPDATE alamat SET alamat = ?, kota = ?, provinsi = ?, kode_pos = ? 
                            WHERE id_alamat = (SELECT id_alamat FROM shelter WHERE id_akun = ?)";
            $stmtAlamat = $pdo->prepare($queryAlamat);
            $stmtAlamat->execute([$alamat, $kota, $provinsi, $kodePos, $userId]);

            // Commit transaksi
            $pdo->commit();
            return true; // Berhasil update
        } catch (Exception $e) {
            // Rollback jika terjadi error
            $pdo->rollBack();
            return false; // Gagal update
        }
    }

    // Menangani request form update
    $updateSuccess = false;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $namaShelter = $_POST['nama_shelter'];
        $kontak = $_POST['kontak'];
        $deskripsiShelter = $_POST['deskripsi_shelter'];
        $alamat = $_POST['alamat'];
        $kota = $_POST['kota'];
        $provinsi = $_POST['provinsi'];
        $kodePos = $_POST['kode_pos'];

        // Panggil fungsi untuk update
        $updateSuccess = updateShelterAkun($pdo, $userId, $username, $password, $namaShelter, $kontak, $deskripsiShelter, $alamat, $kota, $provinsi, $kodePos);

        // Jika berhasil update, ambil ulang data yang terbaru dari database
        if ($updateSuccess) {
            $stmtShelter->execute([$userId]);
            $shelter = $stmtShelter->fetch(PDO::FETCH_ASSOC);
        }
    }

    // Mengambil data rekening shelter
    $queryRekening = "SELECT rs.*, mp.nama_metode 
                      FROM rekening_shelter rs
                      INNER JOIN metode_pembayaran mp ON rs.id_metode = mp.id_metode
                      WHERE rs.id_shelter = ?";
    $stmtRekening = $pdo->prepare($queryRekening);
    $stmtRekening->execute([$shelter['id_shelter']]);
    $rekeningList = $stmtRekening->fetchAll(PDO::FETCH_ASSOC);

    // Menangani request form tambah rekening
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_rekening'])) {
        $idMetode = $_POST['id_metode'];
        $nomorRekening = $_POST['nomor_rekening'];
        $namaPemilikRekening = $_POST['nama_pemilik_rekening'];

        // Menyimpan data rekening ke database
        $queryTambahRekening = "INSERT INTO rekening_shelter (id_shelter, id_metode, nomor_rekening, nama_pemilik_rekening) 
                                VALUES (?, ?, ?, ?)";
        $stmtTambahRekening = $pdo->prepare($queryTambahRekening);
        $stmtTambahRekening->execute([$shelter['id_shelter'], $idMetode, $nomorRekening, $namaPemilikRekening]);

        // Refresh data rekening setelah penambahan
        $stmtRekening->execute([$shelter['id_shelter']]);
        $rekeningList = $stmtRekening->fetchAll(PDO::FETCH_ASSOC);
    }

    // Menangani request form edit rekening
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_rekening'])) {
        $idRekening = $_POST['id_rekening'];

        // Ambil data rekening berdasarkan id_rekening
        $queryRekening = "SELECT * FROM rekening_shelter WHERE id_rekening = ?";
        $stmtRekening = $pdo->prepare($queryRekening);
        $stmtRekening->execute([$idRekening]);
        $rekening = $stmtRekening->fetch(PDO::FETCH_ASSOC);

    }
    // Menangani request form hapus rekening
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_rekening'])) {
        $idRekening = $_POST['id_rekening'];

        // Hapus data rekening dari database
        $queryHapusRekening = "DELETE FROM rekening_shelter WHERE id_rekening = ?";
        $stmtHapusRekening = $pdo->prepare($queryHapusRekening);
        $stmtHapusRekening->execute([$idRekening]);

        // Refresh data rekening setelah penghapusan
        $stmtRekening->execute([$shelter['id_shelter']]);
        $rekeningList = $stmtRekening->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="CSS/shelter_profile.css">
    <title>Profil Shelter</title>
</head>
<body>
    <!-- ============ HEADER ============ -->
    <?php require_once('shelter_header.php'); ?>

    <main class="main">
        <section class="shelter_profile section" id="profile">
            <div class="profile_container container">
                <h2>Update Profil Shelter</h2>
                <form method="POST">
                    <!-- Form untuk Update Shelter -->
                    <label for="nama_shelter">Nama Shelter:</label>
                    <input type="text" name="nama_shelter" value="<?php echo $shelter['nama_shelter']; ?>" required><br>

                    <!-- Form untuk Kontak Shelter -->
                    <label for="kontak">Kontak:</label>
                    <input type="text" name="kontak" value="<?php echo $shelter['kontak']; ?>" required><br>

                    <!-- Form untuk Deskripsi Shelter -->
                    <label for="deskripsi_shelter">Deskripsi Shelter:</label>
                    <textarea name="deskripsi_shelter" required><?php echo $shelter['deskripsi_shelter']; ?></textarea><br>

                    <!-- Form untuk Update Akun -->
                    <label for="username">Username:</label>
                    <input type="text" name="username" value="<?php echo $shelter['username']; ?>" required><br>

                    <label for="password">Password Baru:</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengganti"><br>

                    <!-- Form untuk Update Alamat -->
                    <label for="alamat">Alamat:</label>
                    <textarea name="alamat" required><?php echo $shelter['alamat']; ?></textarea><br>

                    <label for="kota">Kota:</label>
                    <input type="text" name="kota" value="<?php echo $shelter['kota']; ?>" required><br>

                    <label for="provinsi">Provinsi:</label>
                    <input type="text" name="provinsi" value="<?php echo $shelter['provinsi']; ?>" required><br>

                    <label for="kode_pos">Kode Pos:</label>
                    <input type="text" name="kode_pos" value="<?php echo $shelter['kode_pos']; ?>" required><br>

                    <button type="submit" name="update_profile">Update Profile</button>

                    <!-- Menampilkan pesan sukses atau gagal saat update -->
                    <?php if (isset($updateSuccess)): ?>
                        <?php if ($updateSuccess): ?>
                            <p style="color: green;">Data berhasil diperbarui!</p>
                        <?php else: ?>
                            <p style="color: red;">Update data gagal. Silakan coba lagi.</p>
                        <?php endif; ?>
                    <?php endif; ?>
                </form>

                <!-- Menampilkan daftar rekening shelter -->
                <h2>Daftar Rekening Shelter</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Metode Pembayaran</th>
                            <th>Nomor Rekening</th>
                            <th>Nama Pemilik Rekening</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rekeningList as $rekening): ?>
                            <tr>
                                <td><?php echo $rekening['nama_metode']; ?></td>
                                <td><?php echo $rekening['nomor_rekening']; ?></td>
                                <td><?php echo isset($rekening['nama_pemilik_rekening']) ? $rekening['nama_pemilik_rekening'] : ''; ?></td>
                                <td>
                                    <form method="POST">
                                        <input type="hidden" name="id_rekening" value="<?php echo $rekening['id_rekening']; ?>">
                                        <button type="submit" name="edit_rekening">Edit</button>
                                        <button type="submit" name="hapus_rekening">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                 <!-- Tampilkan form edit rekening dengan data yang akan diedi -->
                <h2>Edit Rekening Shelter</h2>
                <form method="POST" action="edit_rekening.php">
                    <input type="hidden" name="id_rekening" value="<?php echo $rekening['id_rekening']; ?>">

                    <label for="id_metode">Metode Pembayaran:</label>
                    <select name="id_metode" required>
                        <?php
                        $queryMetode = "SELECT * FROM metode_pembayaran";
                        $stmtMetode = $pdo->query($queryMetode);
                        while ($metode = $stmtMetode->fetch(PDO::FETCH_ASSOC)) {
                            $selected = ($metode['id_metode'] == $rekening['id_metode']) ? 'selected' : '';
                            echo '<option value="' . $metode['id_metode'] . '" ' . $selected . '>' . $metode['nama_metode'] . '</option>';
                        }
                        ?>
                    </select><br>

                    <label for="nomor_rekening">Nomor Rekening:</label>
                    <input type="text" name="nomor_rekening" value="<?php echo $rekening['nomor_rekening']; ?>" required><br>

                    <label for="nama_pemilik_rekening">Nama Pemilik Rekening:</label>
                    <input type="text" name="nama_pemilik_rekening" value="<?php echo $rekening['nama_pemilik_rekening']; ?>" required><br>

                    <button type="submit">Simpan</button>
                </form>

                

                <h2>Tambah Rekening Shelter</h2>
                <form method="POST">
                    <label for="id_metode">Metode Pembayaran:</label>
                    <select name="id_metode" required>
                        <option value="">Pilih Metode Pembayaran</option>
                        <?php
                        // Mengambil daftar metode pembayaran dari database
                        $queryMetode = "SELECT * FROM metode_pembayaran";
                        $stmtMetode = $pdo->query($queryMetode);
                        while ($metode = $stmtMetode->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $metode['id_metode'] . '">' . $metode['nama_metode'] . '</option>';
                        }
                        ?>
                    </select><br>

                    <label for="nomor_rekening">Nomor Rekening:</label>
                    <input type="text" name="nomor_rekening" required><br>

                    <label for="nama_pemilik_rekening">Nama Pemilik Rekening:</label>
                    <input type="text" name="nama_pemilik_rekening" required><br>

                    <button type="submit" name="tambah_rekening">Tambah Rekening</button>
                </form>
            </div>
        </section>

        <button><a href="logout.php" class="button">Logout</a></button>
    </main>

    <script src="JS/script.js"></script>
</body>
</html>