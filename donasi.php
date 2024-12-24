<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
$koneksi = mysqli_connect('localhost', 'root', '', 'papaw');

// Periksa koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit();
}

// Query untuk mendapatkan data shelter
$query_shelter = "SELECT * FROM shelter";
$result_shelter = mysqli_query($koneksi, $query_shelter);

// Proses submit form
if (isset($_POST['submit'])) {
    $id_akun = $_SESSION['user_id'];
    
    // Mendapatkan id_pengguna berdasarkan id_akun
    $query_pengguna = "SELECT id_pengguna FROM pengguna WHERE id_akun = '$id_akun'";
    $result_pengguna = mysqli_query($koneksi, $query_pengguna);
    
    if (mysqli_num_rows($result_pengguna) > 0) {
        $row_pengguna = mysqli_fetch_assoc($result_pengguna);
        $id_pengguna = $row_pengguna['id_pengguna'];
        
        $id_shelter = $_POST['id_shelter'];
        $id_metode = $_POST['id_metode'];
        $id_rekening = $_POST['id_rekening'];
        $nominal = $_POST['nominal'];
        $tanggal_submit = date("Y-m-d");

        // Upload bukti pembayaran
        $target_dir = "assets/pembayaran/";
        $target_file = $target_dir . basename($_FILES["bukti_transfer"]["name"]);
        move_uploaded_file($_FILES["bukti_transfer"]["tmp_name"], $target_file);

        // Simpan data donasi
        $query_donasi = "INSERT INTO donasi (id_pengguna, id_shelter, id_metode, id_rekening, tanggal_submit) 
                         VALUES ('$id_pengguna', '$id_shelter', '$id_metode', '$id_rekening', '$tanggal_submit')";
        if (mysqli_query($koneksi, $query_donasi)) {
            // Dapatkan id_donasi yang baru saja diinsert
            $id_donasi = mysqli_insert_id($koneksi);

            // Simpan data pembayaran
            $query_pembayaran = "INSERT INTO pembayaran (id_donasi, bukti_transfer, nominal) 
                                 VALUES ('$id_donasi', '$target_file', '$nominal')";
            if (mysqli_query($koneksi, $query_pembayaran)) {
                echo "Donasi berhasil disimpan.";
            } else {
                echo "Error saat menyimpan data pembayaran: " . mysqli_error($koneksi);
            }
        } else {
            echo "Error saat menyimpan data donasi: " . mysqli_error($koneksi);
        }
    } else {
        echo "ID pengguna tidak ditemukan.";
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
  <link rel="stylesheet" href="CSS/donasi.css">
  <title>Donasi untuk Shelter</title>
</head>
<body>
  
  <?php require_once('header.php'); ?>

  <!-- Donation Form Section -->
  <section class="donasi section" id="donasi">
    <div class="donasi-container">
        <div class="form-container">
            <h2>Form Donasi</h2>
            <form method="POST" enctype="multipart/form-data">
                <label for="id_shelter">Pilih Shelter:</label>
                <select name="id_shelter" id="id_shelter" required>
                    <option value="">Pilih Shelter</option>
                    <?php while ($row_shelter = mysqli_fetch_assoc($result_shelter)) { ?>
                        <option value="<?php echo $row_shelter['id_shelter']; ?>"><?php echo $row_shelter['nama_shelter']; ?></option>
                    <?php } ?>
                </select><br><br>

                <label for="id_metode">Pilih Metode Pembayaran:</label>
                <select name="id_metode" id="id_metode" required>
                    <option value="">Pilih Metode Pembayaran</option>
                </select><br><br>

                <label for="rekening_tujuan">Rekening Tujuan:</label>
                <input type="hidden" name="id_rekening" id="id_rekening">
                <span id="rekening_info"></span><br><br>

                <label for="nominal">Nominal Donasi:</label>
                <input type="number" name="nominal" id="nominal" required><br><br>

                <label for="bukti_transfer">Bukti Pembayaran:</label>
                <input type="file" name="bukti_transfer" id="bukti_transfer" required><br><br>

                <input type="submit" name="submit" value="Kirim Donasi" class="button">
            </form>
        </div>

        <div class="donasi_image_section">
            <img class="donasi_image" src="assets/donasi.png" alt="Shelter Image">
        </div>
    </div>
  </section>

  <?php require_once('footer.php'); ?>

  <script src="script.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>   
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const metodePembayaranSelect = document.getElementById("metode_pembayaran");
        const bankDetails = document.querySelector(".kotak_nama_pemilik");
        const rekeningDetails = document.querySelector(".kotak_nomor_rekening");
        const ewalletDetails = document.querySelector(".kotak_ewallet");

        // Toggle the visibility of payment method details
        metodePembayaranSelect.addEventListener("change", function() {
            const metodePembayaran = this.value;
            if (metodePembayaran === "bank") {
                bankDetails.style.display = "block";
                rekeningDetails.style.display = "block";
                ewalletDetails.style.display = "none";
            } else {
                bankDetails.style.display = "none";
                rekeningDetails.style.display = "none";
                ewalletDetails.style.display = "block";
            }
        });

        // Form submission handling
        const donasiForm = document.querySelector('#donasiForm');
        donasiForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const jumlahDonasi = document.getElementById('nominal').value;
            const metodePembayaran = document.getElementById('metode_pembayaran').value;
            let infoRekening = "";

            // Validate donation amount
            if (jumlahDonasi < 10000) {
                alert('Jumlah donasi minimal Rp 10.000!');
                return;
            }

            let infoDonasi = "Jumlah Donasi: Rp " + jumlahDonasi;

            if (metodePembayaran === "bank") {
                const namaPemilik = document.getElementById('nama_pemilik').value;
                const nomorRekening = document.getElementById('nomor_rekening').value;

                if (!namaPemilik || !nomorRekening) {
                    alert('Harap lengkapi detail rekening bank!');
                    return;
                }

                infoRekening = "Transfer ke Rekening: " + namaPemilik + " | No. Rekening: " + nomorRekening + " | Nominal: Rp " + jumlahDonasi;
            } else {
                const nomorEwallet = document.getElementById('nomor_ewallet').value;

                if (!nomorEwallet) {
                    alert('Harap lengkapi nomor E-Wallet!');
                    return;
                }

                infoRekening = "Transfer ke E-Wallet: " + nomorEwallet + " | Nominal: Rp " + jumlahDonasi;
            }

            // Display payment info
            document.getElementById('info_donasi').innerText = infoDonasi;
            document.getElementById('info_rekening').innerText = infoRekening;
            document.getElementById('info_pembayaran').style.display = "block";

            // Submit form after displaying payment info
            setTimeout(function() {
                donasiForm.submit();
            }, 2000);
        });
    });
  </script>
  <script>
    $(document).ready(function() {
        $('#id_shelter').change(function() {
            var id_shelter = $(this).val();
            if (id_shelter) {
                $.ajax({
                    url: 'get_metode_pembayaran.php',
                    type: 'POST',
                    data: { id_shelter: id_shelter },
                    success: function(response) {
                        $('#id_metode').html(response);
                        $('#rekening_info').text('');
                        $('#id_rekening').val('');
                    }
                });
            } else {
                $('#id_metode').html('<option value="">Pilih Metode Pembayaran</option>');
                $('#rekening_info').text('');
                $('#id_rekening').val('');
            }
        });

        $('#id_metode').change(function() {
            var id_shelter = $('#id_shelter').val();
            var id_metode = $(this).val();
            if (id_shelter && id_metode) {
                $.ajax({
                    url: 'get_rekening_tujuan.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { id_shelter: id_shelter, id_metode: id_metode },
                    success: function(response) {
                        if (response.id_rekening) {
                            $('#id_rekening').val(response.id_rekening);
                            $('#rekening_info').text(response.nomor_rekening + ' - ' + response.nama_pemilik_rekening);
                        } else {
                            $('#id_rekening').val('');
                            $('#rekening_info').text('');
                        }
                    }
                });
            } else {
                $('#id_rekening').val('');
                $('#rekening_info').text('');
            }
        });
    });
    </script>
    </script>
</body>
</html>
<?
// Close connection
$conn->close();
?>