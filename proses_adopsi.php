<?php
session_start(); // Pastikan session dimulai
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Sertakan file koneksi.php
require ('koneksi.php');

// Mengecek apakah user sudah login dan memiliki id_akun
if (!isset($_SESSION['user_id'])) {
    echo "Anda harus login terlebih dahulu";
    exit;
}

// Mengambil id_akun dari session
$id_akun = $_SESSION['user_id'];

// Query untuk mendapatkan id_pengguna berdasarkan id_akun
$sql_pengguna = "SELECT id_pengguna FROM pengguna WHERE id_akun = ?";

// Menjalankan query dengan parameter
if ($stmt_pengguna = $conn->prepare($sql_pengguna)) {
    $stmt_pengguna->bind_param("i", $id_akun);
    $stmt_pengguna->execute();
    $result_pengguna = $stmt_pengguna->get_result();

    if ($result_pengguna->num_rows > 0) {
        $row_pengguna = $result_pengguna->fetch_assoc();
        $id_pengguna = $row_pengguna['id_pengguna'];

        // Mengecek apakah data dikirim melalui POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_hewan = $_POST['id_hewan'];
            $id_shelter = $_POST['id_shelter'];
            $tanggal_adopsi = $_POST['tanggal_adopsi'];
            
            // Set status_adopsi menjadi 'pending' secara default
            $status_adopsi = 'pending';

            // Query untuk mendapatkan informasi shelter, alamat, dan kontak shelter
            $sql = "
            SELECT h.nama_hewan, s.nama_shelter, al.alamat, s.kontak AS kontak_shelter
            FROM hewan_shelter h
            JOIN shelter s ON h.id_shelter = s.id_shelter
            JOIN alamat al ON s.id_alamat = al.id_alamat
            WHERE h.id_hewan = ? AND s.id_shelter = ?
            ";

            // Menjalankan query dengan parameter
            if ($stmt = $conn->prepare($sql)) {
                // Mengikat parameter
                $stmt->bind_param("ii", $id_hewan, $id_shelter);
                
                // Menjalankan query
                $stmt->execute();
                
                // Menyimpan hasil query
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Mendapatkan data shelter, alamat, nama hewan, dan kontak shelter
                    $row = $result->fetch_assoc();

                    // Query untuk menyimpan data adopsi ke tabel adopsi
                    $sql_insert = "INSERT INTO adopsi (id_hewan, id_shelter, tanggal_adopsi, status_adopsi, id_pengguna) 
                                   VALUES (?, ?, ?, ?, ?)";
                    
                    // Menjalankan query insert dengan parameter
                    if ($insert_stmt = $conn->prepare($sql_insert)) {
                        $insert_stmt->bind_param("iissi", $id_hewan, $id_shelter, $tanggal_adopsi, $status_adopsi, $id_pengguna);
                        $insert_stmt->execute();

                        // Mendapatkan ID adopsi yang baru saja dimasukkan
                        $id_adopsi = $conn->insert_id;

                    } else {
                        echo "Error: " . $conn->error;
                    }
                } else {
                    echo "Data tidak ditemukan.";
                }
                
                // Menutup statement
                $stmt->close();
            } else {
                echo "Error preparing the query: " . $conn->error;
            }
        } else {
            echo "Data tidak valid.";
        }
    } else {
        echo "ID pengguna tidak ditemukan.";
    }
    
    // Menutup statement
    $stmt_pengguna->close();
} else {
    echo "Error preparing the query: " . $conn->error;
}

// Menutup koneksi
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Form Adopsi Hewan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 40;
            padding-block: 5rem;
        }

        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group strong {
            display: inline-block;
            width: 200px;
            color: #555;
        }

        .form-footer {
            margin-top: 30px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px dashed #ccc;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 5px;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Styling khusus untuk pencetakan */
        @media print {
            button {
                display: none;
            }

            .form-container {
                border: none;
            }

            body {
                margin: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <?php require_once('header.php'); ?>
    <div class="form-container">
        <h2>Form Adopsi Hewan</h2>
        <div class="form-group">
            <strong>ID Adopsi:</strong> <?php echo $id_adopsi; ?>
        </div>
        <div class="form-group">
            <strong>ID Hewan:</strong> <?php echo $id_hewan; ?>
        </div>
        <div class="form-group">
            <strong>ID Shelter:</strong> <?php echo $id_shelter; ?>
        </div>
        <div class="form-group">
            <strong>Nama Hewan:</strong> <?php echo $row['nama_hewan']; ?>
        </div>
        <div class="form-group">
            <strong>Nama Shelter:</strong> <?php echo $row['nama_shelter']; ?>
        </div>
        <div class="form-group">
            <strong>Alamat Shelter:</strong> <?php echo $row['alamat']; ?>
        </div>
        <div class="form-group">
            <strong>Kontak Shelter:</strong> <?php echo $row['kontak_shelter']; ?>
        </div>
        <div class="form-group">
            <strong>Tanggal Kunjungan:</strong> <?php echo $tanggal_adopsi; ?>
        </div>
        <div class="form-group">
            <strong>Status Adopsi:</strong> Pending
        </div>
        <div class="form-footer">
            <p>Pengajuan Adopsi berhasil! Silakan cetak form ini.</p>
            <button onclick="window.print()">Cetak Form</button>
            <form action="generate_pdf.php" method="POST" target="_blank" style="display: inline;">
                <input type="hidden" name="id_adopsi" value="<?php echo $id_adopsi; ?>">
                <input type="hidden" name="id_hewan" value="<?php echo $id_hewan; ?>">
                <input type="hidden" name="id_shelter" value="<?php echo $id_shelter; ?>">
                <input type="hidden" name="tanggal_adopsi" value="<?php echo $tanggal_adopsi; ?>">
                <input type="hidden" name="status_adopsi" value="<?php echo $status_adopsi; ?>">
                <input type="hidden" name="id_pengguna" value="<?php echo $id_pengguna; ?>">
                <input type="hidden" name="nama_hewan" value="<?php echo $row['nama_hewan']; ?>">
                <input type="hidden" name="nama_shelter" value="<?php echo $row['nama_shelter']; ?>">
                <input type="hidden" name="alamat" value="<?php echo $row['alamat']; ?>">
                <input type="hidden" name="kontak_shelter" value="<?php echo $row['kontak_shelter']; ?>">
                <button type="submit">Download PDF</button>
            </form>
        </div>
    </div>
</body>
</html>
