<?php
session_start(); // Mulai sesi untuk memeriksa apakah pengguna sudah login
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.css">

    <link rel="stylesheet" href="CSS\shelter.css">
    <title>Shelter name</title>
</head>
<body>
    <!-- ============== HEADER ============= -->
    <?php require_once('shelter_header.php'); ?>

    <!-- ============  MAIN ================ -->
    <main class="main">
        <section class="shelter section" id="home-shelter">
            <div class="shelter_container container">
            <?php
            // Pastikan pengguna sudah login
            if (!isset($_SESSION['user_id'])) {
                // Jika tidak ada sesi pengguna yang login, arahkan ke halaman login
                header('Location: login.php');
                exit();
            }

            // Ambil ID akun shelter dari sesi yang aktif
            $idAkunLogin = $_SESSION['user_id']; // Anggap ID akun shelter disimpan dalam sesi dengan nama 'user_id'

            // Koneksi ke database
            require 'koneksi.php';

            // Query untuk mendapatkan id_shelter berdasarkan id_akun
            $queryShelter = "SELECT id_shelter, nama_shelter FROM shelter WHERE id_akun = $idAkunLogin";
            $resultShelter = $conn->query($queryShelter);

            if ($resultShelter->num_rows > 0) {
                $rowShelter = $resultShelter->fetch_assoc();
                $shelterId = $rowShelter["id_shelter"];
                $shelterName = $rowShelter["nama_shelter"];

                // Query statistik hewan, adopsi pending, dan donasi
                $queryJumlahHewan = "SELECT COUNT(*) as jumlah_hewan FROM hewan_shelter WHERE id_shelter = $shelterId";
                $resultJumlahHewan = $conn->query($queryJumlahHewan);
                $jumlahHewan = $resultJumlahHewan->fetch_assoc()["jumlah_hewan"];

                $queryAdopsiPending = "SELECT COUNT(*) as adopsi_pending FROM adopsi WHERE id_shelter = $shelterId AND status_adopsi = 'pending'";
                $resultAdopsiPending = $conn->query($queryAdopsiPending);
                $adopsiPending = $resultAdopsiPending->fetch_assoc()["adopsi_pending"];

                $queryJumlahDonasi = "SELECT COUNT(*) as jumlah_donasi FROM donasi WHERE id_shelter = $shelterId";
                $resultJumlahDonasi = $conn->query($queryJumlahDonasi);
                $jumlahDonasi = $resultJumlahDonasi->fetch_assoc()["jumlah_donasi"];

                echo "<div class='home_data'>";
                echo "<h2>Statistik Shelter: " . $shelterName . "</h2> <br>";
                echo "<div class='home_description'>";
                echo "Statistik untuk Shelter ID: " . $shelterId . "<br>";
                echo "Shelter: " . $shelterName . "<br>";
                echo "Jumlah Hewan: " . $jumlahHewan . "<br>";
                echo "Adopsi Pending: " . $adopsiPending . "<br>";
                echo "Jumlah Donasi: " . $jumlahDonasi . "<br>";
                echo "</div>";
                echo "</div>";

                // Query untuk menampilkan daftar hewan
                $queryHewan = "SELECT * FROM hewan_shelter WHERE id_shelter = $shelterId";
                $resultHewan = $conn->query($queryHewan);
            } else {
                echo "Tidak ada data shelter untuk akun ini.";
            }

            $conn->close();
            ?>

            </div>
        </section>

            <!-- Daftar Hewan -->
            <section class="hewan-list container">
                <h2 class="tambah_hewan_title">Daftar Hewan di Shelter</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Hewan</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Keterangan Hewan</th> <!-- Menambahkan kolom keterangan_hewan -->
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($rowHewan = $resultHewan->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $rowHewan['id_hewan'] . "</td>";
                            echo "<td>" . $rowHewan['nama_hewan'] . "</td>";
                            echo "<td>" . $rowHewan['jenis_hewan'] . "</td>";
                            echo "<td>" . ($rowHewan['status'] == 'tersedia' ? 'Tersedia' : 'Diadopsi') . "</td>";
                            echo "<td>" . $rowHewan['keterangan_hewan'] . "</td>"; // Menampilkan keterangan_hewan
                            echo "<td><img src='assets/img/" . $rowHewan['foto_hewan'] . "' alt='" . $rowHewan['nama_hewan'] . "' width='100'></td>";
                            echo "<td>
                                    <a href='edit_hewan.php?id=" . $rowHewan['id_hewan'] . "'>Edit</a> |
                                    <a href='#' onclick='konfirmasiHapus(" . $rowHewan['id_hewan'] . ")'>Hapus</a>
                                </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>


           <!-- Form Tambah Hewan -->
           <section class="form-tambah-hewan">
                <div class="tambah_hewan_container container">
                    <div class="tambah_hewan_data">
                        <div class="form_tambah_hewan">
                            <h2 class="tambah_hewan_title">Tambah Hewan</h2>
                            <form action="tambah_hewan.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id_shelter" value="<?php echo $shelterId; ?>">

                                <label for="nama_hewan">Nama Hewan:</label><br>
                                <input type="text" name="nama_hewan" id="nama_hewan" required><br>

                                <label for="jenis">Jenis:</label><br>
                                <input type="text" name="jenis" id="jenis" required><br>

                                <label for="status">Status:</label><br>
                                <select name="status" id="status">
                                    <option value="tersedia">Tersedia</option>
                                    <option value="diadopsi">Diadopsi</option>
                                </select><br>

                                <label for="keterangan_hewan">Keterangan Hewan:</label><br>
                                <textarea name="keterangan_hewan" id="keterangan_hewan" required></textarea><br>

                                <label for="foto">Foto Hewan:</label><br>
                                <input type="file" name="foto" id="foto" required><br>

                                <button type="submit">Tambah Hewan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
    </main>
    <!-- Overlay dan Custom Dialog -->
    <div id="overlay" class="overlay" style="display: none;">
        <div class="dialog">
            <p>Apakah Anda yakin ingin menghapus hewan ini?</p>
            <button id="btnYes" class="btnYes">Ya</button>
            <button id="btnNo" class="btnNo">Tidak</button>
        </div>
    </div>




    <!-- ============ FOOTER =============== -->
    <?php require_once('footer.php'); ?>

    <script>
    function konfirmasiHapus(idHewan) {
        console.log("Fungsi konfirmasiHapus dipanggil");  // Verifikasi bahwa fungsi dipanggil
        var overlay = document.getElementById("overlay");
        overlay.style.display = "flex";  // Menampilkan overlay

        // Menangani aksi jika tombol "Ya" ditekan
        document.getElementById("btnYes").onclick = function() {
            console.log("Menghapus hewan dengan ID: " + idHewan);  // Verifikasi ID
            window.location.href = "hapus_hewan.php?id=" + idHewan;
        };

        // Menangani aksi jika tombol "Tidak" ditekan
        document.getElementById("btnNo").onclick = function() {
            overlay.style.display = "none";  // Menutup overlay jika "Tidak"
        };
    }
    </script>

    <!-- ============ JAVASCRIPT ============ -->
    <script src="main.js"></script>
</body>
</html>