<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require ('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_hewan = $_POST['id_hewan'];
    $id_shelter = $_POST['id_shelter'];

    // Query untuk mengambil data hewan berdasarkan id_hewan
    $sql = "SELECT * FROM hewan_shelter WHERE id_hewan = $id_hewan";
    $result = $conn->query($sql);

    // Mengecek apakah data ditemukan
    if ($result->num_rows > 0) {
        $hewan = $result->fetch_assoc();
    } else {
        echo "Hewan tidak ditemukan.";
        exit;
    }
} else {
    echo "Data tidak valid.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="CSS/adopsi_form.css">
  <title>Form Adopsi Hewan</title>
  <style>
    /* Styling untuk form dan tampilan */
    .content {
      padding: 20px;
      background-color: #fbdbc6;
      margin-top: 5rem;
    }

    .adoption-form {
      background-color: #fff;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      max-width: 800px;
      margin: 0 auto;
    }

    .adoption-form h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .hewan-info {
      display: flex;
      gap: 20px;
      margin-bottom: 20px;
    }

    .hewan-info img {
      max-width: 200px;
      max-height: 200px;
      object-fit: cover;
      border-radius: 10px;
    }

    .hewan-details {
      flex: 1;
    }

    .hewan-details h3 {
      margin: 0;
      font-size: 1.5rem;
    }

    .hewan-details p {
      margin: 5px 0;
    }

    label {
      font-weight: bold;
      margin: 10px 0 5px;
    }

    input[type="date"], .submit-btn {
      padding: 10px;
      width: 100%;
      font-size: 1rem;
      margin-bottom: 20px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .submit-btn {
      background-color: #28a745;
      color: white;
      cursor: pointer;
    }

    .submit-btn:hover {
      background-color: #218838;
    }

    /* Tombol Batal */
    .cancel-btn {
      background-color: #ccc;
      color: #333;
      cursor: pointer;
      padding: 12px 25px; /* Lebar dan tinggi tombol lebih besar */
      font-size: 1rem;
      border: 1px solid #bbb;
      border-radius: 8px; /* Sedikit rounded */
    }

    .cancel-btn:hover {
      background-color: #aaa;
    }
  </style>
</head>
<body>

  <?php require_once('header.php'); ?>

  <div class="content">
    <div class="adoption-form">
      <h2>Form Adopsi Hewan</h2>

      <div class="hewan-info">
        <!-- Gambar Hewan dan Keterangan -->
        <img src="assets/img/<?php echo $hewan['foto_hewan']; ?>" alt="Foto Hewan">
        <div class="hewan-details">
          <h3><?php echo $hewan['nama_hewan']; ?></h3>
          <p>Jenis: <?php echo $hewan['jenis_hewan']; ?></p>
          <p>Status: <?php echo $hewan['status']; ?></p>
          <p>Keterangan: <?php echo $hewan['keterangan_hewan']; ?></p>
        </div>
      </div>

      <!-- Form untuk memilih tanggal kunjungan dan tombol cetak -->
      <form action="proses_adopsi.php" method="POST">
        <input type="hidden" name="id_hewan" value="<?php echo $hewan['id_hewan']; ?>">
        <input type="hidden" name="id_shelter" value="<?php echo $hewan['id_shelter']; ?>">
        <label for="tanggal_adopsi">Pilih Tanggal Kunjungan:</label>
        <input type="date" id="tanggal_adopsi" name="tanggal_adopsi" required>
        <button type="submit" class="submit-btn">Cetak Form</button>
      </form>

      <!-- Tombol Batal untuk kembali ke adopsi.php -->
      <form action="adopsi.php" method="get">
        <button type="submit" class="cancel-btn">Batal</button>
      </form>
    </div>
  </div>

</body>
</html>

<?php
// Menutup koneksi
$conn->close();
?>
