<?php
session_start();
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

// Query untuk mengambil data shelter
$queryShelter = "SELECT * FROM shelter";
$stmtShelter = $pdo->query($queryShelter);
$shelters = $stmtShelter->fetchAll(PDO::FETCH_ASSOC);

// Variabel untuk notifikasi
$notif = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nama_laporan'])) {
    // Ambil data dari form
    $idAkun = $_SESSION['user_id'];

    // Query untuk mendapatkan id_pengguna berdasarkan id_akun
    $queryPengguna = "SELECT id_pengguna FROM pengguna WHERE id_akun = ?";
    $stmtPengguna = $pdo->prepare($queryPengguna);
    $stmtPengguna->execute([$idAkun]);
    $pengguna = $stmtPengguna->fetch(PDO::FETCH_ASSOC);

    if ($pengguna) {
        $idPengguna = $pengguna['id_pengguna'];

        $namaLaporan = $_POST['nama_laporan'];
        $jenisHewan = $_POST['jenis_hewan'];
        $fotoHewan = $_FILES['foto_hewan'];
        $keterangan = $_POST['keterangan'];
        $idShelter = $_POST['id_shelter'];
        $idAlamat = $_POST['id_alamat'];

        $uploadDir = 'assets/img/';
        $uploadFile = $uploadDir . basename($fotoHewan['name']);

        if (move_uploaded_file($fotoHewan['tmp_name'], $uploadFile)) {
            // Simpan data ke tabel `hewan`
            $queryHewan = "INSERT INTO hewan (jenis_hewan, foto) VALUES (?, ?)";
            $stmtHewan = $pdo->prepare($queryHewan);
            $stmtHewan->execute([$jenisHewan, $uploadFile]);

            $idHewan = $pdo->lastInsertId();

            // Tanggal laporan otomatis diisi tanggal hari ini
            $tanggalLaporan = date('Y-m-d'); // Format tanggal: YYYY-MM-DD

            // Simpan data ke tabel `laporan` dengan status_laporan default "pending" dan tanggal laporan
            $queryLaporan = "INSERT INTO laporan (nama_laporan, id_hewan, keterangan, id_shelter, id_alamat, id_pengguna, status_laporan, tanggal_laporan) 
                             VALUES (?, ?, ?, ?, ?, ?, 'pending', ?)";
            $stmtLaporan = $pdo->prepare($queryLaporan);

            $notif = $stmtLaporan->execute([$namaLaporan, $idHewan, $keterangan, $idShelter, $idAlamat, $idPengguna, $tanggalLaporan]) 
                ? "Laporan berhasil dikirim dengan status 'Pending' dan tanggal '$tanggalLaporan'!" 
                : "Gagal mengirim laporan.";
        } else {
            $notif = "Gagal mengunggah foto.";
        }
    } else {
        $notif = "ID pengguna tidak ditemukan.";
    }
}



// Endpoint untuk mengambil data alamat berdasarkan pencarian
if (isset($_GET['q'])) {
    $searchQuery = '%' . $_GET['q'] . '%';
    $queryAlamatSearch = "SELECT id_alamat, CONCAT(alamat, ', ', kota, ', ', provinsi, ', ', kode_pos) AS full_address FROM alamat WHERE alamat LIKE ? OR kota LIKE ? OR provinsi LIKE ? OR kode_pos LIKE ?";
    $stmtAlamatSearch = $pdo->prepare($queryAlamatSearch);
    $stmtAlamatSearch->execute([$searchQuery, $searchQuery, $searchQuery, $searchQuery]);

    $alamatSearchResults = $stmtAlamatSearch->fetchAll(PDO::FETCH_ASSOC);
    
    // Mengembalikan hasil pencarian dalam format JSON
    echo json_encode($alamatSearchResults);
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

    <title>Pelaporan Hewan - Papaw Care</title>
    <style>
        /* Menyembunyikan overlay secara default */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .overlay form {
            background: white;
            padding: 20px;
            margin: auto;
            transform: translateY(18%);
            border-radius: 8px;
            width: 90%;
            max-width: 400px;
        }
    </style>
</head>
<body>
    <?php require_once('header.php'); ?>

    <main class="main">
        <section class="pelaporan section" id="home">
            <div class="pelaporan_container container">
                <h1>Pelaporan Hewan</h1>
                <form method="POST" enctype="multipart/form-data">
                    <input type="text" name="nama_laporan" placeholder="Nama Laporan" required>
                    <input type="text" name="jenis_hewan" placeholder="Jenis Hewan" required>
                    <label for="foto_hewan">Unggah Foto Hewan</label>
                    <input type="file" name="foto_hewan" accept="image/*" required>
                    <textarea name="keterangan" placeholder="Keterangan Laporan" required></textarea>
                    <select name="id_shelter" required>
                        <option value="">Pilih Shelter</option>
                        <?php foreach ($shelters as $shelter): ?>
                            <option value="<?= $shelter['id_shelter'] ?>"><?= $shelter['nama_shelter'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" id="alamat" name="alamat" placeholder="Cari Alamat" required autocomplete="off">
                    <input type="hidden" id="id_alamat" name="id_alamat">
                    <div id="alamat-result" style="border: 1px solid #ccc; max-height: 200px; overflow-y: auto;"></div>
                    <button id="tambah-alamat-btn">Tambahkan Alamat</button>
                    <button type="submit">Kirim Laporan</button>
                </form>
            </div>
        </section>
    </main>

    <!-- Overlay Tambahkan Alamat -->
    <div id="overlay-alamat" class="overlay">
        <form id="form-tambah-alamat" method="POST">
            <h2>Tambahkan Alamat Baru</h2>
            <input type="text" name="alamat_baru" placeholder="Alamat" required>
            <input type="text" name="kota" placeholder="Kota" required>
            <input type="text" name="provinsi" placeholder="Provinsi" required>
            <input type="text" name="kode_pos" placeholder="Kode Pos" required>
            <button type="submit" name="submit_alamat">Tambahkan</button>
            <button type="button" id="close-overlay">Tutup</button>
        </form>
    </div>

    <!-- FOOTER -->
    <?php require_once('footer.php'); ?>
 
    <script>
        $(document).ready(function () {
            // Menangani input cari alamat
            $('#alamat').on('input', function () {
                var query = $(this).val();
                if (query.length > 2) {
                    $.get('pelaporan.php', { q: query }, function (data) {
                        var alamatData = JSON.parse(data);
                        var resultHTML = '';

                        if (alamatData.length > 0) {
                            alamatData.forEach(function (alamat) {
                                resultHTML += '<div class="alamat-item" data-id="' + alamat.id_alamat + '" data-address="' + alamat.full_address + '">' + alamat.full_address + '</div>';
                            });
                            $('#alamat-result').html(resultHTML).show();
                        } else {
                            $('#alamat-result').html('<div>No results found</div>').show();
                        }
                    });
                } else {
                    $('#alamat-result').hide();
                }
            });

            // Menangani pemilihan alamat dari hasil autocomplete
            $(document).on('click', '.alamat-item', function () {
                var address = $(this).data('address');
                var idAlamat = $(this).data('id');
                
                $('#alamat').val(address);
                $('#id_alamat').val(idAlamat);
                $('#alamat-result').hide();
            });

            // Menyembunyikan hasil autocomplete jika pengguna klik di luar
            $(document).click(function (e) {
                if (!$(e.target).closest('#alamat').length) {
                    $('#alamat-result').hide();
                }
            });

            // Tampilkan overlay
            $('#tambah-alamat-btn').click(() => $('#overlay-alamat').fadeIn());
            
            // Sembunyikan overlay
            $('#close-overlay').click(() => $('#overlay-alamat').fadeOut());
            $('#overlay-alamat').click((e) => {
                if (e.target.id === 'overlay-alamat') $('#overlay-alamat').fadeOut();
            });
        });
    </script>

    <script src="JS\script.js"></script>
</body>
</html>



