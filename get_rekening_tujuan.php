<?php
// Koneksi ke database
$koneksi = mysqli_connect('localhost', 'root', '', 'papaw');

if (isset($_POST['id_shelter']) && isset($_POST['id_metode'])) {
    $id_shelter = $_POST['id_shelter'];
    $id_metode = $_POST['id_metode'];

    // Query untuk mendapatkan rekening tujuan berdasarkan shelter dan metode pembayaran
    $query_rekening = "SELECT rs.id_rekening, rs.nomor_rekening, rs.nama_pemilik_rekening
                       FROM rekening_shelter rs
                       WHERE rs.id_shelter = '$id_shelter' AND rs.id_metode = '$id_metode'";
    $result_rekening = mysqli_query($koneksi, $query_rekening);

    if (mysqli_num_rows($result_rekening) > 0) {
        $row_rekening = mysqli_fetch_assoc($result_rekening);
        $id_rekening = $row_rekening['id_rekening'];
        $nomor_rekening = $row_rekening['nomor_rekening'];
        $nama_pemilik_rekening = $row_rekening['nama_pemilik_rekening'];

        echo json_encode(array(
            'id_rekening' => $id_rekening,
            'nomor_rekening' => $nomor_rekening,
            'nama_pemilik_rekening' => $nama_pemilik_rekening
        ));
    } else {
        echo json_encode(array());
    }
}
?>