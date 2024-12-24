<?php
// File: tambah_hewan.php

// Koneksi ke database
require 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $shelterId = $_POST["id_shelter"];
    $namaHewan = $_POST["nama_hewan"];
    $jenisHewan = $_POST["jenis"];
    $status = $_POST["status"];
    $keterangan_hewan = $_POST['keterangan_hewan'];  // Ambil keterangan_hewan

    // Menangani upload foto
    $foto = $_FILES["foto"]["name"];
    $tempFoto = $_FILES["foto"]["tmp_name"];
    $folderFoto = "assets/img/" . $foto;
    
    // Pindahkan file foto ke folder tujuan
    if (move_uploaded_file($tempFoto, $folderFoto)) {
        // Query untuk menambahkan data hewan ke database
        $query = "INSERT INTO hewan_shelter (id_shelter, nama_hewan, jenis_hewan, status, keterangan_hewan, foto_hewan) 
                  VALUES ('$shelterId', '$namaHewan', '$jenisHewan', '$status', '$keterangan_hewan', '$foto')";
        
        if ($conn->query($query) === TRUE) {
            echo "Data hewan berhasil ditambahkan.";
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    } else {
        echo "Error saat mengunggah foto.";
    }
    
    $conn->close();
    
    // Redirect kembali ke halaman utama setelah menambahkan data
    header("Location: shelter.php");
    exit();
}
?>
