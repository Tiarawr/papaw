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

    // Cek apakah form edit rekening dikirimkan
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idRekening = $_POST['id_rekening'];
        $idMetode = $_POST['id_metode'];
        $nomorRekening = $_POST['nomor_rekening'];
        $namaPemilikRekening = $_POST['nama_pemilik_rekening'];

        // Update data rekening di database
        $queryEditRekening = "UPDATE rekening_shelter SET id_metode = ?, nomor_rekening = ?, nama_pemilik_rekening = ? WHERE id_rekening = ?";
        $stmtEditRekening = $pdo->prepare($queryEditRekening);
        $stmtEditRekening->execute([$idMetode, $nomorRekening, $namaPemilikRekening, $idRekening]);

        // Redirect kembali ke halaman profil shelter setelah berhasil mengedit
        header('Location: shelter_profile.php');
        exit();
    }
}
?>