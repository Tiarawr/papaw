<?php
// Koneksi ke database
require 'koneksi.php';

// Periksa apakah parameter id ada dalam URL
if (isset($_GET['id'])) {
    $idHewan = $_GET['id'];

    // Query untuk menghapus data hewan
    $deleteQuery = "DELETE FROM hewan_shelter WHERE id_hewan = $idHewan";

    if ($conn->query($deleteQuery) === TRUE) {
        echo "Data hewan berhasil dihapus.";
    } else {
        echo "Error: " . $deleteQuery . "<br>" . $conn->error;
    }
}

// Redirect kembali ke halaman utama setelah menghapus
header("Location: index.php");
exit();
?>