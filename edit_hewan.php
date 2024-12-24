<?php
// Koneksi ke database
require 'koneksi.php';

// Periksa apakah parameter id ada dalam URL
if (isset($_GET['id'])) {
    $idHewan = $_GET['id'];

    // Query untuk mendapatkan data hewan berdasarkan id
    $query = "SELECT * FROM hewan_shelter WHERE id_hewan = $idHewan";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $rowHewan = $result->fetch_assoc();
    } else {
        echo "Hewan tidak ditemukan.";
        exit();
    }
} else {
    echo "ID hewan tidak ditemukan.";
    exit();
}

// Proses update data hewan jika form dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaHewan = $_POST['nama_hewan'];
    $jenisHewan = $_POST['jenis'];
    $status = $_POST['status'];
    $keteranganHewan = $_POST['keterangan_hewan']; // Ambil keterangan_hewan dari form

    // Tangani unggahan foto
    if (isset($_FILES['foto']) && $_FILES['foto']['name'] != '') {
        $fotoHewan = $_FILES['foto']['name'];
        $tmpFoto = $_FILES['foto']['tmp_name'];
        $folderFoto = 'assets/img/';
        $uploadFoto = $folderFoto . basename($fotoHewan);

        if (move_uploaded_file($tmpFoto, $uploadFoto)) {
            // Hapus foto lama jika ada
            if ($rowHewan['foto_hewan'] != '') {
                unlink($folderFoto . $rowHewan['foto_hewan']);
            }
        } else {
            echo "Terjadi kesalahan saat mengunggah foto.";
            return;
        }
    } else {
        // Gunakan foto lama jika tidak ada yang diunggah
        $fotoHewan = $rowHewan['foto_hewan'];
    }

    // Query untuk mengupdate data hewan termasuk keterangan_hewan
    $updateQuery = "UPDATE hewan_shelter SET nama_hewan = '$namaHewan', jenis_hewan = '$jenisHewan', status = '$status', keterangan_hewan = '$keteranganHewan', foto_hewan = '$fotoHewan' WHERE id_hewan = $idHewan";

    if ($conn->query($updateQuery) === TRUE) {
        echo "Data hewan berhasil diupdate.";
        header("Location: shelter.php"); // Redirect ke halaman utama setelah berhasil update
        exit();
    } else {
        echo "Error: " . $updateQuery . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.css">
    <link rel="stylesheet" href="CSS/edit_hewan.css">
</head>
<body>
    <!-- ========== HEADER =========== -->
    <?php require_once('shelter_header.php') ?>

    <main class="main">
        <section class="edit_hewan section" id="edit_hewan">
            <div class="edit_hewan_container container">
                <div class="edit_hewan_data">
                    <div class="form_edit_hewan">
                        <h1 class="edit_hewan_title">Edit Hewan</h1>
                        <!-- Form untuk mengedit data hewan -->
                        <form method="post" action="edit_hewan.php?id=<?php echo $idHewan; ?>" enctype="multipart/form-data">
                            <label for="nama_hewan">Nama Hewan:</label><br>
                            <input type="text" name="nama_hewan" id="nama_hewan" value="<?php echo $rowHewan['nama_hewan']; ?>" required><br>

                            <label for="jenis">Jenis:</label><br>
                            <input type="text" name="jenis" id="jenis" value="<?php echo $rowHewan['jenis_hewan']; ?>" required><br>

                            <label for="status">Status:</label><br>
                            <select name="status" id="status">
                                <option value="tersedia" <?php if ($rowHewan['status'] == 'tersedia') echo 'selected'; ?>>Tersedia</option>
                                <option value="diadopsi" <?php if ($rowHewan['status'] == 'diadopsi') echo 'selected'; ?>>Diadopsi</option>
                            </select><br>

                            <!-- Keterangan Hewan -->
                            <label for="keterangan_hewan">Keterangan Hewan:</label><br>
                            <textarea name="keterangan_hewan" id="keterangan_hewan" rows="4" required><?php echo $rowHewan['keterangan_hewan']; ?></textarea><br>

                            <label for="foto">Foto Hewan:</label><br>
                            <input type="file" name="foto" id="foto"><br>

                            <!-- Tombol submit untuk mengirimkan form -->
                            <button type="submit">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- ============= FOOTER =========== -->
    <?php require_once('footer.php') ?>
</body>
</html>
