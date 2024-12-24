<?php
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $db_name = 'papaw';
    $conn = new mysqli( $host, $username, $password, $db_name);

    if(!$conn) {
        die("koneksi gagal :".mysqli_connect_error());
    }
?>