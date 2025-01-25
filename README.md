Papaw - Aplikasi Shelter Hewan

Deskripsi
Papaw adalah sebuah aplikasi berbasis web yang dirancang untuk mempermudah pengelolaan shelter hewan. Aplikasi ini bertujuan untuk membantu shelter dalam mengelola informasi hewan, mencatat adopsi, menerima donasi, serta memudahkan calon adopter dalam mencari hewan yang ingin diadopsi. Dengan Papaw, proses pengelolaan dan adopsi menjadi lebih efisien, transparan, dan ramah pengguna.
Fitur Utama

# Sisi Pengguna (User)
1. Donasi
Pengguna dapat memberikan donasi untuk mendukung operasional shelter.
Riwayat donasi tercatat di akun pengguna.

2.Adopsi Hewan
Mencari hewan berdasarkan jenis, ras, usia, dan lokasi shelter.
Mengajukan permohonan adopsi dengan status terperinci (dalam proses, disetujui, ditolak).

3. Artikel Edukasi
Membaca artikel dan tips tentang perawatan hewan peliharaan.

4.Pelaporan Hewan
Melaporkan hewan yang membutuhkan bantuan agar dapat ditangani oleh shelter.
Informasi pelaporan mencakup lokasi, foto, dan deskripsi kondisi hewan.

# Sisi Shelter

1.Manajemen Donasi
Melihat daftar donatur dan jumlah donasi yang diterima.
Mengelola penggunaan dana donasi.

2.Manajemen Adopsi
Melihat daftar calon adopter dan status pengajuan mereka.
Memproses permohonan adopsi.

3.Manajemen Pelaporan
Melihat laporan hewan yang membutuhkan bantuan.
Menindaklanjuti laporan dan memperbarui status penanganan.

4.Manajemen Hewan
Menambahkan, mengedit, dan menghapus data hewan.
Informasi hewan mencakup nama, jenis, ras, usia, deskripsi, dan status (tersedia/adopsi).

5.Dashboard Admin
Statistik donasi, adopsi, dan pelaporan.
Manajemen pengguna dan akses.

# Teknologi yang Digunakan

Frontend:
HTML, CSS, JavaScript
Framework: Bootstrap CSS untuk desain responsif

Backend:
PHP untuk logika server-side

Database:
MySQL untuk penyimpanan data

Integrasi:
Payment gateway untuk donasi.

# Cara Instalasi

Clone repository ini:
git clone https://github.com/username/papaw.git

Masuk ke direktori proyek:
cd papaw
-Atur server lokal (misalnya XAMPP atau MAMP) dan pastikan MySQL berjalan.
-Buat file config.php untuk konfigurasi database:

<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'password');
define('DB_NAME', 'papaw');
?>

import file papaw.sql ke dalam database Anda melalui phpMyAdmin atau command line:
mysql -u root -p papaw < papaw.sql

Buka aplikasi di browser dengan mengakses direktori proyek di server lokal Anda:
http://localhost/papaw


# - ENG VERS -

Papaw - Animal Shelter Application

Description

Papaw is a web-based application designed to facilitate animal shelter management. The application aims to assist shelters in managing animal information, recording adoptions, receiving donations, and helping potential adopters find animals to adopt. With Papaw, the management and adoption process becomes more efficient, transparent, and user-friendly.

Key Features

# User Side

1.Donations
Users can donate to support shelter operations.
Donation history is recorded in the user account.

2.Animal Adoption
Search for animals by type, breed, age, and shelter location.
Submit adoption requests with detailed statuses (in process, approved, rejected).

3.Educational Articles
Read articles and tips on pet care.

4.Animal Reporting
Report animals needing help so shelters can take action.
Reporting information includes location, photos, and a description of the animal's condition.

# Shelter Side

1.Donation Management
View the list of donors and the donations received.
Manage the usage of donation funds.

2.Adoption Management
View the list of potential adopters and the status of their applications.
Process adoption requests.

3.Reporting Management
View reports of animals needing help.
Follow up on reports and update handling status.

4.Animal Management
Add, edit, and delete animal data.
Animal information includes name, type, breed, age, description, and status (available/adopted).

5.Admin Dashboard
Statistics on donations, adoptions, and reports.
User and access management.

# Technology Used

Frontend:
HTML, CSS, JavaScript
Framework: Bootstrap CSS for responsive design

Backend:
PHP for server-side logic

Database:
MySQL for data storage

Integration:
Payment gateway for donations.

# Installation Steps

Clone this repository:

git clone https://github.com/username/papaw.git

Navigate to the project directory:

cd papaw

Set up a local server (e.g., XAMPP or MAMP) and ensure MySQL is running.

Create a config.php file for database configuration:

<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'password');
define('DB_NAME', 'papaw');
?>

Import the papaw.sql file into your database via phpMyAdmin or command line:

mysql -u root -p papaw < papaw.sql

Open the application in your browser by accessing the project directory on your local server:
