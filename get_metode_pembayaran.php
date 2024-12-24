<?php
session_start();
// Koneksi ke database
$koneksi = mysqli_connect('localhost', 'root', '', 'papaw');

if (isset($_POST['id_shelter'])) {
    $id_shelter = $_POST['id_shelter'];

    // Query untuk mendapatkan metode pembayaran berdasarkan shelter
    $query_metode = "SELECT mp.id_metode, mp.nama_metode 
                     FROM metode_pembayaran mp
                     INNER JOIN rekening_shelter rs ON mp.id_metode = rs.id_metode
                     WHERE rs.id_shelter = '$id_shelter'";
    $result_metode = mysqli_query($koneksi, $query_metode);

    echo "<option value=''>Pilih Metode Pembayaran</option>";
    while ($row_metode = mysqli_fetch_assoc($result_metode)) {
        echo "<option value='" . $row_metode['id_metode'] . "'>" . $row_metode['nama_metode'] . "</option>";
    }
}
?>