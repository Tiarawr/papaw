-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Des 2024 pada 15.45
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `akademik`
--
CREATE DATABASE IF NOT EXISTS `akademik` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `akademik`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosen`
--

CREATE TABLE `dosen` (
  `id_dosen` int(4) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tgl_lahir` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dosen`
--

INSERT INTO `dosen` (`id_dosen`, `nama`, `tgl_lahir`) VALUES
(1, 'Dr. Andi Saputra', '0000-00-00'),
(2, 'Dr. Budi Santoso', '0000-00-00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mhs` int(4) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tgl_lahir` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mhs`, `nama`, `tgl_lahir`) VALUES
(1, 'Ani Wijaya', '2000-07-10'),
(2, 'Budi Setiawan', '1999-11-22'),
(2304, 'kim woyoung', '2001-06-10'),
(2918, 'artis amatiran', '2004-01-20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `matakuliah`
--

CREATE TABLE `matakuliah` (
  `id_mk` int(4) NOT NULL,
  `id_dosen` int(4) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `sks` smallint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `matakuliah`
--

INSERT INTO `matakuliah` (`id_mk`, `id_dosen`, `nama`, `sks`) VALUES
(1, 1, 'Matematika Dasar', 3),
(2, 1, 'Algoritma Pemrograman', 3),
(3, 2, 'Sistem Basis Data', 3),
(4, 2, 'Jaringan Komputer', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mhs_kontak`
--

CREATE TABLE `mhs_kontak` (
  `id_mhs` int(4) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `asal` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mhs_kontak`
--

INSERT INTO `mhs_kontak` (`id_mhs`, `no_telp`, `asal`) VALUES
(1, '08123456789', 'Bandung'),
(2, '08987654321', 'Jakarta');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perkuliahan`
--

CREATE TABLE `perkuliahan` (
  `id_mk` int(4) NOT NULL,
  `id_mhs` int(4) NOT NULL,
  `smt` smallint(2) NOT NULL,
  `nilai` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `perkuliahan`
--

INSERT INTO `perkuliahan` (`id_mk`, `id_mhs`, `smt`, `nilai`) VALUES
(1, 1, 1, 'A'),
(2, 1, 1, 'B'),
(3, 2, 1, 'A'),
(4, 2, 1, 'B');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id_dosen`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mhs`);

--
-- Indeks untuk tabel `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD PRIMARY KEY (`id_mk`),
  ADD KEY `id_dosen` (`id_dosen`);

--
-- Indeks untuk tabel `mhs_kontak`
--
ALTER TABLE `mhs_kontak`
  ADD UNIQUE KEY `id_mhs` (`id_mhs`);

--
-- Indeks untuk tabel `perkuliahan`
--
ALTER TABLE `perkuliahan`
  ADD KEY `id_mk` (`id_mk`),
  ADD KEY `id_mhs` (`id_mhs`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id_dosen` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mhs` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4982103;

--
-- AUTO_INCREMENT untuk tabel `matakuliah`
--
ALTER TABLE `matakuliah`
  MODIFY `id_mk` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD CONSTRAINT `matakuliah_ibfk_1` FOREIGN KEY (`id_dosen`) REFERENCES `dosen` (`id_dosen`);

--
-- Ketidakleluasaan untuk tabel `mhs_kontak`
--
ALTER TABLE `mhs_kontak`
  ADD CONSTRAINT `mhs_kontak_ibfk_1` FOREIGN KEY (`id_mhs`) REFERENCES `mahasiswa` (`id_mhs`);

--
-- Ketidakleluasaan untuk tabel `perkuliahan`
--
ALTER TABLE `perkuliahan`
  ADD CONSTRAINT `perkuliahan_ibfk_1` FOREIGN KEY (`id_mk`) REFERENCES `matakuliah` (`id_mk`),
  ADD CONSTRAINT `perkuliahan_ibfk_2` FOREIGN KEY (`id_mhs`) REFERENCES `mahasiswa` (`id_mhs`);
--
-- Database: `babikecap`
--
CREATE DATABASE IF NOT EXISTS `babikecap` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `babikecap`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `id_barang` char(4) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `harga` float DEFAULT NULL,
  `stok` smallint(3) DEFAULT NULL,
  `jenis` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_barang`
--

INSERT INTO `tbl_barang` (`id_barang`, `nama`, `harga`, `stok`, `jenis`) VALUES
('B001', 'Logitech K380 Keyboard', 400000, 7, 'Aksesoris Komputer'),
('B002', 'Kingston RAM DDR4 8GB', 530000, 5, 'Komponen Komputer'),
('B003', 'Kingston SSD 240GB', 490000, 6, 'Media Penyimpanan Data'),
('B004', 'Anti Virus Kaspersky', 50000, 15, 'Software'),
('B005', 'LED Monitor 24 inch', 0, 0, 'Aksesoris Komputer'),
('B006', 'USB Flash Drive 32GB', 120000, 9, 'Media Penyimpanan Data'),
('B007', 'Rexus Q20 Mouse', 55000, 4, 'Aksesoris Komputer'),
('B008', '2TB External Harddisk', 1000000, 1, 'Media Penyimpanan Data'),
('B009', 'Windows 10 License Key', 20000, 18, 'Software'),
('B010', 'Bracket Stand Laptop', 150000, 8, 'Aksesoris Komputer'),
('B011', 'Logitech C920 Webcam', 0, 2, 'Aksesoris Komputer'),
('B012', 'Microsoft Office 365', 95000, 12, 'Software'),
('B013', 'TP-LINK Router', 148000, 3, 'Jaringan'),
('B014', 'Cooling Pad', 115000, 10, 'Aksesoris Komputer'),
('B015', 'Modem Wifi', 630000, 8, 'Jaringan'),
('B016', 'In-ear Earphone', 299000, 10, 'Audio'),
('B017', 'Canon Printer', 0, 0, 'Printer'),
('B018', 'Logitech M331 Mouse', 200000, 14, 'Aksesoris Komputer'),
('B019', 'Barcode Scanner', 0, 11, 'Printer'),
('B020', 'Mechanical Keyboard', 3100000, 0, 'Aksesoris Komputer');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`id_barang`);
--
-- Database: `bumimanusia`
--
CREATE DATABASE IF NOT EXISTS `bumimanusia` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bumimanusia`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_karyawan`
--

CREATE TABLE `tbl_karyawan` (
  `nik` char(16) NOT NULL,
  `namaLengkap` varchar(100) NOT NULL,
  `usia` smallint(3) NOT NULL,
  `asal` varchar(100) DEFAULT NULL,
  `pekerjaan` varchar(100) NOT NULL,
  `gaji` float NOT NULL,
  `ttl` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_karyawan`
--

INSERT INTO `tbl_karyawan` (`nik`, `namaLengkap`, `usia`, `asal`, `pekerjaan`, `gaji`, `ttl`) VALUES
('1001200030004001', 'Jang Wonyoung', 20, 'Jakarta', 'Pemasaran', 9000000, 'Jakarta, 2004-03-15'),
('1001200030004002', 'Im Nayeon', 26, 'Bandung', 'Pelayan Toko', 5200000, 'Seoul, 1998-07-10'),
('1001200030004003', 'Bae Joo-hyun', 29, 'Surabaya', 'Manager Toko', 7500000, 'Daegu, 1994-03-29'),
('1001200030004004', 'Hwang Yeji', 25, 'Yogyakarta', 'Staf Gudang Toko', 4800000, 'Jeonju, 1999-05-26'),
('1001200030004005', 'Yoo Jimin', 24, 'Jakarta', 'Pelayan Toko', 5100000, 'Seoul, 2000-04-11'),
('1001200030004006', 'Kim Yong-sun', 30, 'Semarang', 'Supervisor Toko', 6800000, 'Seoul, 1993-02-21'),
('1001200030004007', 'Kim So-jung', 28, 'Medan', 'Kasir Toko', 5400000, 'Seoul, 1996-12-07'),
('1001200030004008', 'Park Sieun', 23, 'Bandung', 'Pelayan Toko', 5000000, 'Seoul, 2001-08-01'),
('1001200030004009', 'Choi Hyo-jung', 29, 'Jakarta', 'Manager Toko', 7300000, 'Anyang, 1995-07-28'),
('1001200030004010', 'Miyawaki Sakura', 26, 'Solo', 'Staf Gudang Toko', 4600000, 'Kagoshima, 1998-03-19'),
('1001200030004011', 'Ahn Hee-yeon', 31, 'Surabaya', 'Supervisor Toko', 6900000, 'Seoul, 1993-05-01'),
('1001200030004012', 'Kim Ji-yeon', 27, 'Bandung', 'Kasir Toko', 5300000, 'Daejeon, 1996-08-19'),
('1001200030004013', 'Jeon Hee-jin', 24, 'Jakarta', 'Pelayan Toko', 5200000, 'Seoul, 2000-10-19'),
('1001200030004014', 'Park Jiwon', 26, 'Makassar', 'Staf Gudang Toko', 4700000, 'Gwangju, 1998-05-19'),
('1001200030004015', 'Park Cho-rong', 33, 'Depok', 'Manager Toko', 7600000, 'Chungcheongbuk-do, 1991-03-03');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_karyawan`
--
ALTER TABLE `tbl_karyawan`
  ADD PRIMARY KEY (`nik`);
--
-- Database: `db_toko`
--
CREATE DATABASE IF NOT EXISTS `db_toko` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_toko`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `id_barang` char(4) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `harga` float DEFAULT NULL,
  `stok` smallint(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_barang`
--

INSERT INTO `tbl_barang` (`id_barang`, `nama`, `harga`, `stok`) VALUES
('B001', 'Logitech K380 Keyboard', 400000, 7),
('B002', 'Kingston RAM DDR4 8GB', 530000, 5),
('B003', 'Kingston SSD 240 GB', 490000, 6),
('B004', 'Anti Virus Kaspersky', 50000, 15),
('B005', 'LED Monitor 24 inch', 0, 4);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`id_barang`);
--
-- Database: `mahasiswa`
--
CREATE DATABASE IF NOT EXISTS `mahasiswa` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `mahasiswa`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` int(1) NOT NULL,
  `rombel` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama`, `kelas`, `rombel`) VALUES
('1212121', 'minji', 2, '1'),
('210001', 'Nani Hirunkit', 2, '1'),
('210002', 'Sky Wongravee', 2, '1'),
('210003', 'Budi Santoso', 1, '3'),
('210004', 'Dewi Kartika', 1, '1'),
('210005', 'Eko Prasetyo', 2, '2'),
('210006', 'Fajar Hidayat', 1, '3'),
('210007', 'Gita Sari', 2, '4'),
('210008', 'Hendra Wijaya', 1, '2'),
('210009', 'Ika Putri', 2, '1'),
('210010', 'Joko Santoso', 1, '4'),
('210011', 'Kartika Dewanti', 2, '3'),
('210012', 'Lukman Hakim', 1, '2'),
('210013', 'Maya Sari', 2, '1');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`);
--
-- Database: `papaw`
--
CREATE DATABASE IF NOT EXISTS `papaw` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `papaw`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `adopsi`
--

CREATE TABLE `adopsi` (
  `id_adopsi` int(11) NOT NULL,
  `id_hewan` int(11) DEFAULT NULL,
  `id_shelter` int(11) DEFAULT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `tanggal_adopsi` date DEFAULT NULL,
  `status_adopsi` enum('pending','diterima','ditolak') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `adopsi`
--

INSERT INTO `adopsi` (`id_adopsi`, `id_hewan`, `id_shelter`, `id_pengguna`, `tanggal_adopsi`, `status_adopsi`) VALUES
(1, 3, 2, 1, '2024-01-15', 'diterima'),
(2, 1, 4, 2, '2024-02-01', 'ditolak'),
(3, 2, 4, 3, '2024-02-10', 'diterima'),
(4, 4, 4, 4, '2024-12-21', 'diterima'),
(5, 2, 4, 4, '2024-12-25', 'pending'),
(6, 2, 4, 7, '2024-12-20', 'pending'),
(7, 2, 4, 4, '2024-12-03', 'pending'),
(8, 2, 4, 4, '2024-12-10', 'pending');

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun`
--

CREATE TABLE `akun` (
  `id_akun` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` enum('shelter','user') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `akun`
--

INSERT INTO `akun` (`id_akun`, `username`, `password`, `role`) VALUES
(1, 'happypets', 'hash123', 'shelter'),
(2, 'pawshelter', 'hash456', 'shelter'),
(3, 'petrescue', 'hash789', 'shelter'),
(4, 'Wonyoung', '$2y$10$bW9ow/iz5P7ASm6.VX2gT.71BabjF6EJ9hIYuck2uQLNfdqDTAiAi', 'user'),
(5, 'Pawcare', '$2y$10$3Wo1qs9j/KloZY.EmW9DVO69IlOpMRwhGMj1cxY7NWrATiszY0VjO', 'shelter'),
(6, 'sandoer', '$2y$10$WeryzvU1nVHQ03ONpFytjOSD2o8zsy3bk7G9saZi7vQ1Gjkw1H5UO', 'user'),
(7, 'Wonyoung', '$2y$10$PY4TjF1ghlHQbTsBmuojiOrSGaHjx12SC6CvbAbjkEJZMRbmIRE3i', 'shelter'),
(8, 'egiruna', '$2y$10$Btsc.9XMzGgHUgOVmaWI4.HXhPrV5ZskwgFLDQqGVxVup6fYuQbwi', 'user'),
(9, 'ati', '$2y$10$M0BaHIyGIQXpU9WFIXApcOFcQLO1b1VWztrF4mOvqsmkKKMX1s2pW', 'user'),
(10, 'uti', '$2y$10$gAP1RxwSqV8eIIZB/Zn/eOzBiY5wLeeavhoHQ.yWNn0VBVHJvCWFa', 'shelter'),
(11, 'tuan', '$2y$10$F4VYCfzGksKynJ9rcwYyvOKUdMzsV.PSGEvdv.R3fAgperhN0EGaC', 'user');

-- --------------------------------------------------------

--
-- Struktur dari tabel `alamat`
--

CREATE TABLE `alamat` (
  `id_alamat` int(11) NOT NULL,
  `alamat` varchar(200) DEFAULT NULL,
  `kota` varchar(50) DEFAULT NULL,
  `provinsi` varchar(50) DEFAULT NULL,
  `kode_pos` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `alamat`
--

INSERT INTO `alamat` (`id_alamat`, `alamat`, `kota`, `provinsi`, `kode_pos`) VALUES
(1, 'Jl. Gondang Raya No. 12', 'Semarang', 'Jawa Tengah', '50228'),
(2, 'Jl. Mangga No. 45', 'Semarang', 'Jawa Tengah', '50229'),
(3, 'Jl. Kenanga Selatan No. 9', 'Semarang', 'Jawa Tengah', '50228'),
(4, 'Jl. Raya Gunungpati KM. 3', 'Semarang', 'Jawa Tengah', '50228'),
(5, 'Perumahan Bintang Asri Blok C', 'Semarang', 'Jawa Tengah', '50228'),
(6, 'Jl. Nangka Barat No. 17', 'Semarang', 'Jawa Tengah', '50229'),
(7, 'Jl. Sukun No. 8', 'Semarang', 'Jawa Tengah', '50228'),
(8, 'Jl. Karanglo No. 20', 'Semarang', 'Jawa Tengah', '50229'),
(9, 'Perumahan Alam Indah Blok A1', 'Semarang', 'Jawa Tengah', '50228'),
(10, 'Jl. Kutilang No. 30', 'Semarang', 'Jawa Tengah', '50229'),
(11, 'Jl. Raya Mangunsari No. 5', 'Semarang', 'Jawa Tengah', '50228'),
(12, 'Jl. Pucang Gading No. 13', 'Semarang', 'Jawa Tengah', '50229'),
(13, 'Jl. Jeruk No. 22', 'Semarang', 'Jawa Tengah', '50228'),
(14, 'Jl. Raya Jatirejo No. 18', 'Semarang', 'Jawa Tengah', '50229'),
(15, 'Jl. Durian Selatan No. 6', 'Semarang', 'Jawa Tengah', '50228'),
(16, 'Jl. Manggis No. 25', 'Semarang', 'Jawa Tengah', '50228'),
(17, 'Jl. Tambora No. 7', 'Semarang', 'Jawa Tengah', '50229'),
(18, 'Perumahan Citra Mandiri Blok D', 'Semarang', 'Jawa Tengah', '50228'),
(19, 'Jl. Merpati No. 40', 'Semarang', 'Jawa Tengah', '50229'),
(20, 'Jl. Cemara No. 15', 'Semarang', 'Jawa Tengah', '50228'),
(21, 'Jl. Pandanaran No. 9', 'Semarang', 'Jawa Tengah', '50229'),
(22, 'Jl. Garuda No. 11', 'Semarang', 'Jawa Tengah', '50228'),
(23, 'Jl. Wonosari Raya No. 4', 'Semarang', 'Jawa Tengah', '50229'),
(24, 'Jl. Melati No. 14', 'Semarang', 'Jawa Tengah', '50228'),
(25, 'Jl. Dahlia No. 16', 'Semarang', 'Jawa Tengah', '50229'),
(26, 'Perumahan Bukit Permai Blok B2', 'Semarang', 'Jawa Tengah', '50228'),
(27, 'Jl. Cendana No. 31', 'Semarang', 'Jawa Tengah', '50229'),
(28, 'Jl. Anggrek No. 20', 'Semarang', 'Jawa Tengah', '50228'),
(29, 'Jl. Mawar No. 27', 'Semarang', 'Jawa Tengah', '50229'),
(30, 'Jl. Bunga Tanjung No. 5', 'Semarang', 'Jawa Tengah', '50228'),
(31, 'Jl. Cempaka No. 19', 'Semarang', 'Jawa Tengah', '50229'),
(32, 'Jl. Puri Asri No. 9', 'Semarang', 'Jawa Tengah', '50228'),
(33, 'Jl. Palm Indah No. 18', 'Semarang', 'Jawa Tengah', '50229'),
(34, 'Jl. Jati No. 14', 'Semarang', 'Jawa Tengah', '50228'),
(35, 'Jl. Pahlawan No. 21', 'Semarang', 'Jawa Tengah', '50229'),
(36, 'Perumahan Taman Gunungpati Blok E', 'Semarang', 'Jawa Tengah', '50228'),
(37, 'Jl. Diponegoro No. 3', 'Semarang', 'Jawa Tengah', '50229'),
(38, 'Jl. Sawo No. 15', 'Semarang', 'Jawa Tengah', '50228'),
(39, 'Jl. Mangunharjo No. 8', 'Semarang', 'Jawa Tengah', '50229'),
(40, 'Jl. Raya Kebun Jeruk No. 7', 'Semarang', 'Jawa Tengah', '50228'),
(41, 'Jl. Teratai No. 13', 'Semarang', 'Jawa Tengah', '50229'),
(42, 'Jl. Belimbing No. 10', 'Semarang', 'Jawa Tengah', '50228'),
(43, 'Jl. Selasih No. 17', 'Semarang', 'Jawa Tengah', '50229'),
(44, 'Jl. Gelatik No. 5', 'Semarang', 'Jawa Tengah', '50228'),
(45, 'Jl. Rajawali No. 30', 'Semarang', 'Jawa Tengah', '50229'),
(46, 'Jl. Angsana No. 8', 'Semarang', 'Jawa Tengah', '50228'),
(47, 'Jl. Kapuk No. 22', 'Semarang', 'Jawa Tengah', '50229'),
(48, 'Perumahan Green Valley Blok F', 'Semarang', 'Jawa Tengah', '50228'),
(49, 'Jl. Flamboyan No. 12', 'Semarang', 'Jawa Tengah', '50229'),
(50, 'Jl. Manggala No. 6', 'Semarang', 'Jawa Tengah', '50228'),
(51, 'Jl. Hewan Raya No. 1', 'Semarang', 'Jawa Tengah', '50228'),
(52, 'Jl. Kucing Indah No. 2', 'Semarang', 'Jawa Tengah', '50229'),
(53, 'Jl. Anjing Bahagia No. 3', 'Semarang', 'Jawa Tengah', '50230'),
(54, 'Jl. Pete Raya No.18, Sekaran', 'Semarang', 'Jawa Tengah', '50229'),
(55, 'Jl. Anggrek 45', 'Semarang', 'Jawa Tengah', '38278'),
(56, 'asdsd', 'sdaasdds', 'adsda', 'asdsd'),
(57, 'asdsd', 'sdaasdds', 'adsda', 'asdsd'),
(58, 'asdsd', 'sdaasdds', 'adsda', 'asdsd'),
(59, 'asdsd', 'sdaasdds', 'adsda', 'asdsd'),
(60, 'asdsd', 'sdaasdds', 'adsda', 'asdsd'),
(61, 'asdsd', 'sdaasdds', 'adsda', 'asdsd');

-- --------------------------------------------------------

--
-- Struktur dari tabel `artikel`
--

CREATE TABLE `artikel` (
  `id_artikel` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `penulis` varchar(100) DEFAULT NULL,
  `tanggal_publish` date DEFAULT NULL,
  `konten` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `artikel`
--

INSERT INTO `artikel` (`id_artikel`, `judul`, `penulis`, `tanggal_publish`, `konten`, `gambar`) VALUES
(1, 'Mengenal Lebih Dekat Masalah Hewan Terlantar Dampak Sosial dan Lingkungan', 'Prayoga Agus setiawan', '2024-11-27', '<p><strong>Mengenal Lebih Dekat Masalah Hewan Terlantar: Dampak Sosial dan Lingkungan</strong></p>\r\n\r\n<p>Hewan terlantar merupakan masalah serius yang seringkali diabaikan di banyak negara, termasuk di Indonesia. Hewan-hewan yang terabaikan ini, baik itu anjing, kucing, atau hewan lainnya, tidak hanya menimbulkan dampak sosial, tetapi juga dampak lingkungan yang signifikan. Penanganan masalah ini membutuhkan perhatian dari berbagai pihak, baik pemerintah, organisasi non-pemerintah (NGO), maupun masyarakat umum.</p>\r\n\r\n<p><strong>Apa itu Hewan Terlantar?</strong></p>\r\n\r\n<p>Hewan terlantar merujuk pada hewan yang tidak memiliki pemilik atau tinggal di luar rumah tanpa perlindungan yang layak. Penyebab hewan terlantar sangat bervariasi, mulai dari hewan yang dibuang oleh pemiliknya, hewan yang lahir di jalanan, hingga hewan yang terpaksa hidup tanpa pemilik setelah kehilangan keluarga atau tempat tinggalnya.</p>\r\n\r\n<p>Menurut data dari <em>World Health Organization (WHO)</em>, hewan yang terlantar dapat menjadi vektor penyakit, seperti rabies, yang dapat menular ke manusia. Hal ini menunjukkan bahwa penyelamatan dan perawatan hewan terlantar tidak hanya penting untuk kesejahteraan hewan itu sendiri, tetapi juga untuk kesehatan masyarakat.</p>\r\n\r\n<p><strong>Dampak Sosial dari Hewan Terlantar</strong></p>\r\n\r\n<p>Masalah hewan terlantar tidak hanya berdampak pada hewan itu sendiri, tetapi juga pada masyarakat di sekitar mereka. Salah satu dampak sosial yang paling mencolok adalah <strong>penyebaran penyakit zoonotik</strong>, yaitu penyakit yang dapat menular dari hewan ke manusia. Penyakit seperti <strong>rabies</strong>, <strong>tunggal</strong>, dan <strong>toxoplasmosis</strong> dapat disebarkan melalui kontak dengan hewan terlantar, yang seringkali tidak terkontrol atau tidak mendapat vaksinasi.</p>\r\n\r\n<p>Selain itu, kehadiran hewan-hewan terlantar juga sering menimbulkan ketidaknyamanan di masyarakat. Misalnya, banyak hewan terlantar yang mencari makanan di tempat sampah, menyebabkan lingkungan sekitar menjadi kotor dan tidak higienis. Hewan-hewan ini juga bisa menyerang atau menggigit orang, terutama anak-anak, yang dapat menyebabkan cedera atau infeksi.</p>\r\n\r\n<p>Sebagai contoh, di kota-kota besar Indonesia seperti Jakarta dan Surabaya, populasi anjing dan kucing terlantar semakin meningkat. Keberadaan mereka sering menyebabkan kekhawatiran bagi penduduk sekitar, terutama di daerah pemukiman yang padat penduduk.</p>\r\n\r\n<p><strong>Dampak Lingkungan dari Hewan Terlantar</strong></p>\r\n\r\n<p>Dampak lingkungan dari masalah hewan terlantar juga tidak bisa dipandang sebelah mata. Hewan-hewan ini dapat merusak ekosistem lokal dengan berbagai cara. Beberapa dampak lingkungan yang paling signifikan antara lain:</p>\r\n\r\n<ul>\r\n    <li><strong>Penurunan Keanekaragaman Hayati</strong>: Hewan liar atau terlantar dapat memangsa spesies lokal yang lebih kecil atau rentan, sehingga mengganggu keseimbangan ekosistem. Misalnya, anjing liar dapat memburu hewan-hewan kecil yang berperan penting dalam rantai makanan alami.</li>\r\n    <li><strong>Kontaminasi Lingkungan</strong>: Hewan-hewan terlantar sering kali membuang limbah mereka di tempat umum, mencemari air dan tanah dengan kotoran mereka, yang bisa menyebabkan penyebaran penyakit.</li>\r\n    <li><strong>Pertumbuhan Populasi Hewan Liar yang Tidak Terkontrol</strong>: Hewan terlantar, terutama kucing dan anjing, dapat berkembang biak dengan cepat, memperburuk masalah kelebihan populasi hewan liar. Tanpa intervensi yang tepat, jumlah hewan terlantar bisa meningkat pesat dan menjadi masalah yang lebih besar bagi lingkungan dan masyarakat.</li>\r\n</ul>\r\n\r\n<p><strong>Solusi untuk Mengatasi Masalah Hewan Terlantar</strong></p>\r\n\r\n<p>Untuk mengurangi dampak sosial dan lingkungan yang ditimbulkan oleh hewan-hewan terlantar, diperlukan kolaborasi antara masyarakat, organisasi penyelamat hewan, dan pemerintah. Beberapa solusi yang dapat diimplementasikan antara lain:</p>\r\n\r\n<ol>\r\n    <li><strong>Sterilisasi dan Vaksinasi</strong>: Program sterilisasi massal untuk hewan-hewan terlantar dapat membantu mengendalikan populasi mereka. Vaksinasi juga sangat penting untuk mencegah penyebaran penyakit seperti rabies.</li>\r\n    <li><strong>Penyuluhan kepada Masyarakat</strong>: Masyarakat perlu diberi edukasi mengenai pentingnya menjaga hewan peliharaan mereka dan tidak membuang hewan ke jalanan. Kampanye penyuluhan dapat membantu mengurangi jumlah hewan terlantar.</li>\r\n    <li><strong>Adopsi Hewan Terlantar</strong>: Program adopsi hewan terlantar adalah cara yang efektif untuk memberikan rumah bagi hewan yang terabaikan dan mengurangi jumlah hewan liar di jalanan. Banyak NGO yang menyediakan tempat penampungan dan bekerja sama dengan masyarakat untuk mencari rumah baru bagi hewan-hewan ini.</li>\r\n    <li><strong>Peningkatan Infrastruktur Penyelamatan Hewan</strong>: Peningkatan fasilitas penampungan dan rumah singgah untuk hewan-hewan terlantar dapat menjadi solusi jangka panjang yang membantu mereka mendapatkan perlindungan yang layak dan perhatian medis.</li>\r\n</ol>\r\n\r\n<p><strong>Kesimpulan</strong></p>\r\n\r\n<p>Masalah hewan terlantar adalah isu yang memerlukan perhatian serius dari semua pihak. Dampaknya tidak hanya mencakup kesejahteraan hewan itu sendiri, tetapi juga memiliki dampak sosial dan lingkungan yang luas. Dengan kolaborasi antara masyarakat, organisasi penyelamatan hewan, dan pemerintah, kita dapat menciptakan lingkungan yang lebih aman dan lebih peduli terhadap hewan yang terabaikan. Mari kita bersama-sama mengambil langkah nyata dalam menyelamatkan hewan terlantar, demi masa depan yang lebih baik bagi mereka dan kita semua.</p>\r\n\r\n<p><strong>Referensi</strong></p>\r\n\r\n<ul>\r\n    <li><em>World Health Organization (WHO)</em>. (2017). <strong>Rabies</strong>. Diakses dari: <a href=\"https://www.who.int/news-room/fact-sheets/detail/rabies\" target=\"_blank\">https://www.who.int/news-room/fact-sheets/detail/rabies</a></li>\r\n    <li><em>International Animal Rescue</em>. (2020). <strong>The Environmental Impact of Stray Animals</strong>. Diakses dari: <a href=\"https://www.internationalanimalrescue.org\" target=\"_blank\">https://www.internationalanimalrescue.org</a></li>\r\n    <li><em>Petfinder</em>. (2021). <strong>The Importance of Animal Adoption and Rescue</strong>. Diakses dari: <a href=\"https://www.petfinder.com\" target=\"_blank\">https://www.petfinder.com</a></li>\r\n</ul>\r\n', 'hewan-sakit.jpg'),
(2, '5 Langkah Sederhana untuk Membantu Hewan Terlantar di Sekitar Anda', 'Prayoga Agus Setiawan', '2024-11-27', '<p><strong>5 Langkah Sederhana untuk Membantu Hewan Terlantar di Sekitar Anda</strong></p>\r\n\r\n<p>Masalah hewan terlantar adalah isu yang kerap kali terabaikan, meskipun dampaknya sangat besar terhadap kesejahteraan hewan dan kesehatan masyarakat. Banyak hewan terlantar yang kesulitan untuk bertahan hidup di jalanan, sementara beberapa di antaranya menderita penyakit atau kelaparan. Namun, ada banyak hal yang dapat kita lakukan untuk membantu mereka, bahkan dalam cara yang sederhana. Berikut adalah lima langkah yang bisa Anda ambil untuk membantu hewan terlantar di sekitar Anda.</p>\r\n\r\n<p><strong>1. Berikan Makanan dan Air Bersih</strong></p>\r\n\r\n<p>Salah satu cara paling dasar untuk membantu hewan terlantar adalah dengan memberi mereka makanan dan air bersih. Banyak hewan yang terlantar berada dalam keadaan kelaparan dan dehidrasi, sehingga memberi mereka makanan dan air adalah langkah pertama yang bisa Anda lakukan untuk membantu mereka bertahan hidup.</p>\r\n\r\n<p>Namun, pastikan untuk memberikan makanan yang sesuai dengan kebutuhan hewan tersebut. Misalnya, anjing dan kucing membutuhkan makanan khusus yang dapat ditemukan di toko hewan peliharaan, sedangkan hewan liar seperti burung atau kelinci mungkin lebih cocok dengan makanan alami seperti biji-bijian atau rumput.</p>\r\n\r\n<p><strong>2. Bantu Menyediakan Tempat Perlindungan</strong></p>\r\n\r\n<p>Hewan yang hidup di jalanan seringkali kesulitan mencari tempat perlindungan dari cuaca ekstrem, baik itu hujan lebat atau panas terik. Anda bisa membantu dengan menyediakan tempat perlindungan sementara, seperti kardus atau tempat yang terlindung dari cuaca buruk. Untuk hewan yang lebih besar, seperti anjing, Anda bisa membuat kandang sementara atau menuntun mereka ke tempat penampungan hewan setempat.</p>\r\n\r\n<p>Jika Anda memiliki ruang di halaman rumah, Anda juga bisa membuat tempat penampungan kecil bagi hewan-hewan yang membutuhkan tempat berteduh, terutama pada malam hari atau saat cuaca buruk.</p>\r\n\r\n<p><strong>3. Cari Tempat Penampungan atau Hubungi Lembaga Penyelamatan Hewan</strong></p>\r\n\r\n<p>Jika Anda menemukan hewan terlantar yang membutuhkan perhatian lebih, seperti perawatan medis atau perlindungan yang lebih baik, langkah selanjutnya adalah mencari tempat penampungan hewan terdekat atau menghubungi organisasi penyelamatan hewan. Banyak organisasi non-pemerintah (NGO) yang menyediakan layanan penampungan, perawatan medis, serta adopsi untuk hewan-hewan yang terlantar.</p>\r\n\r\n<p>Di banyak kota besar, ada tempat penampungan hewan yang siap menerima hewan terlantar dan memberikan mereka perawatan yang dibutuhkan. Menghubungi lembaga-lembaga ini bisa menjadi langkah yang efektif dalam membantu hewan menemukan rumah yang aman.</p>\r\n\r\n<p><strong>4. Sterilisasi Hewan Terlantar</strong></p>\r\n\r\n<p>Sterilisasi adalah salah satu cara yang sangat efektif untuk mengurangi populasi hewan terlantar. Dengan menyterilkan hewan-hewan terlantar, Anda dapat mencegah mereka berkembang biak secara berlebihan, yang menjadi salah satu penyebab utama banyaknya hewan terlantar di jalanan.</p>\r\n\r\n<p>Jika Anda bekerja sama dengan organisasi penyelamatan hewan, mereka biasanya memiliki program sterilisasi massal yang dirancang untuk mengurangi populasi hewan liar secara berkelanjutan. Anda bisa mencari informasi tentang program sterilisasi lokal dan mengajak lebih banyak orang untuk berpartisipasi.</p>\r\n\r\n<p><strong>5. Adopsi Hewan Terlantar</strong></p>\r\n\r\n<p>Salah satu cara terbaik untuk membantu hewan terlantar adalah dengan mengadopsi mereka. Banyak hewan terlantar yang hanya membutuhkan kasih sayang dan perhatian untuk bisa memiliki kehidupan yang lebih baik. Jika Anda memiliki kemampuan untuk merawat hewan peliharaan, pertimbangkan untuk mengadopsi anjing, kucing, atau hewan lain yang terabaikan.</p>\r\n\r\n<p>Selain memberi mereka rumah yang aman, Anda juga membantu mengurangi jumlah hewan yang harus hidup di jalanan. Adopsi juga memberikan kesempatan bagi hewan-hewan tersebut untuk mendapatkan perawatan medis yang mereka butuhkan dan hidup dalam lingkungan yang penuh kasih sayang.</p>\r\n\r\n<p><strong>Kesimpulan</strong></p>\r\n\r\n<p>Menolong hewan terlantar tidak selalu membutuhkan usaha besar. Dengan langkah-langkah sederhana seperti memberi makanan, menyediakan tempat perlindungan, atau menghubungi organisasi penyelamatan hewan, Anda sudah dapat membuat perbedaan besar dalam hidup mereka. Setiap tindakan kecil yang Anda lakukan bisa menyelamatkan nyawa hewan terlantar dan membantu menciptakan dunia yang lebih baik bagi mereka. Mari kita semua bersama-sama mengambil langkah-langkah ini untuk memberikan bantuan kepada hewan-hewan yang membutuhkan.</p>\r\n\r\n<p><strong>Referensi</strong></p>\r\n\r\n<ul>\r\n    <li><em>Humane Society International</em>. (2022). \"How to Help Stray Animals\". Diakses dari: <a href=\"https://www.hsi.org/issues/stray-animals\" target=\"_blank\">https://www.hsi.org/issues/stray-animals</a></li>\r\n    <li><em>World Animal Protection</em>. (2021). \"The Stray Animal Crisis\". Diakses dari: <a href=\"https://www.worldanimalprotection.org.uk\" target=\"_blank\">https://www.worldanimalprotection.org.uk</a></li>\r\n    <li><em>Petfinder</em>. (2020). \"Adopting a Pet\". Diakses dari: <a href=\"https://www.petfinder.com\" target=\"_blank\">https://www.petfinder.com</a></li>\r\n</ul>\r\n', 'membantu-hewan.jpg'),
(3, 'Pentingnya Penyuluhan dalam Penyelamatan Hewan Terlantar', 'Prayoga Agus Setiawan', '2024-11-27', '<p><strong>Pentingnya Penyuluhan dalam Penyelamatan Hewan Terlantar</strong></p>\r\n\r\n<p>Penyelamatan hewan terlantar merupakan masalah yang tidak hanya mempengaruhi kesejahteraan hewan, tetapi juga berdampak pada kesehatan masyarakat dan lingkungan. Di banyak daerah, jumlah hewan terlantar yang semakin meningkat memerlukan perhatian lebih dari semua pihak, baik itu pemerintah, organisasi non-pemerintah (NGO), maupun masyarakat umum. Salah satu cara yang sangat efektif untuk mengatasi masalah ini adalah melalui <strong>penyuluhan</strong>. Penyuluhan yang baik dapat membantu mengubah perilaku masyarakat, meningkatkan kesadaran, dan mendorong tindakan nyata untuk melindungi hewan-hewan terlantar.</p>\r\n\r\n<p><strong>Apa Itu Penyuluhan dalam Penyelamatan Hewan Terlantar?</strong></p>\r\n\r\n<p>Penyuluhan adalah proses pendidikan yang bertujuan untuk meningkatkan pengetahuan, sikap, dan perilaku masyarakat terhadap isu-isu tertentu. Dalam konteks penyelamatan hewan terlantar, penyuluhan bertujuan untuk memberikan pemahaman yang lebih baik tentang masalah hewan terlantar, dampak yang ditimbulkannya, serta langkah-langkah yang dapat diambil untuk membantu mengurangi jumlah hewan yang hidup di jalanan.</p>\r\n\r\n<p>Penyuluhan ini bisa dilakukan oleh berbagai pihak, mulai dari pemerintah, lembaga penyelamatan hewan, hingga individu yang peduli dengan kesejahteraan hewan. Kegiatan penyuluhan dapat mencakup seminar, workshop, kampanye, distribusi materi informasi, serta pengorganisasian kegiatan sosial yang bertujuan untuk menyebarluaskan informasi kepada masyarakat luas.</p>\r\n\r\n<p><strong>Mengapa Penyuluhan Sangat Penting?</strong></p>\r\n\r\n<ol>\r\n    <li><strong>Meningkatkan Kesadaran Masyarakat</strong></li>\r\n    <p>Banyak orang yang tidak menyadari dampak serius yang ditimbulkan oleh populasi hewan terlantar yang semakin banyak. Penyuluhan dapat memberikan informasi mengenai bagaimana hewan-hewan terlantar bisa menularkan penyakit kepada manusia (seperti rabies), merusak lingkungan, dan menambah beban pada sistem kesehatan masyarakat. Dengan meningkatkan kesadaran, masyarakat dapat lebih peka terhadap masalah ini dan lebih cenderung untuk mengambil tindakan untuk mengurangi populasi hewan terlantar.</p>\r\n    \r\n    <li><strong>Mencegah Penyalahgunaan Hewan</strong></li>\r\n    <p>Sebagian besar hewan yang terlantar berasal dari pemilik yang tidak bertanggung jawab atau karena penelantaran. Penyuluhan juga berfungsi untuk mengedukasi masyarakat mengenai pentingnya memperlakukan hewan peliharaan dengan baik, melakukan sterilisasi untuk mencegah perkembangbiakan yang tidak terkendali, serta tidak membuang hewan ke jalanan. Hal ini dapat membantu mengurangi jumlah hewan yang terabaikan.</p>\r\n    \r\n    <li><strong>Mengajak Masyarakat untuk Terlibat dalam Program Penyelamatan</strong></li>\r\n    <p>Penyuluhan yang baik dapat menginspirasi masyarakat untuk lebih aktif dalam program penyelamatan hewan. Ini termasuk mengadopsi hewan terlantar, menjadi sukarelawan di tempat penampungan, atau mendukung program sterilisasi massal yang diadakan oleh organisasi penyelamatan hewan. Dengan melibatkan masyarakat, masalah hewan terlantar dapat ditangani dengan lebih efektif dan berkelanjutan.</p>\r\n    \r\n    <li><strong>Mendorong Pemerintah untuk Mengambil Tindakan</strong></li>\r\n    <p>Penyuluhan yang dilakukan secara intensif dapat mendorong pihak berwenang, seperti pemerintah daerah atau pusat, untuk memperhatikan masalah ini dan membuat kebijakan yang mendukung perlindungan terhadap hewan terlantar. Misalnya, dengan menyediakan dana untuk tempat penampungan hewan, melakukan program vaksinasi dan sterilisasi massal, atau mengimplementasikan aturan yang melarang penelantaran hewan.</p>\r\n</ol>\r\n\r\n<p><strong>Bentuk-Bentuk Penyuluhan yang Efektif</strong></p>\r\n\r\n<ul>\r\n    <li><strong>Kampanye Media Sosial</strong></li>\r\n    <p>Media sosial adalah platform yang sangat efektif untuk menyebarkan informasi kepada masyarakat luas. Kampanye penyuluhan melalui media sosial, seperti Facebook, Instagram, atau YouTube, dapat menjangkau banyak orang dalam waktu singkat. Dalam kampanye ini, video edukasi, gambar, dan artikel dapat dibagikan untuk meningkatkan kesadaran tentang penyelamatan hewan terlantar.</p>\r\n    \r\n    <li><strong>Pelatihan dan Workshop</strong></li>\r\n    <p>Pelatihan atau workshop untuk masyarakat bisa menjadi cara yang efektif untuk memberikan pengetahuan secara langsung tentang cara merawat hewan dengan baik, pentingnya sterilisasi, serta bagaimana cara melaporkan hewan terlantar kepada pihak yang berwenang. Kegiatan ini juga bisa memberikan informasi tentang organisasi-organisasi penyelamatan hewan yang ada di sekitar mereka.</p>\r\n    \r\n    <li><strong>Kampanye Edukasi di Sekolah dan Komunitas</strong></li>\r\n    <p>Mengedukasi anak-anak dan remaja sejak dini tentang pentingnya merawat hewan peliharaan dengan baik dan tidak membuang hewan ke jalanan adalah langkah yang sangat penting. Kampanye di sekolah dan komunitas dapat membantu menanamkan nilai-nilai tanggung jawab terhadap hewan kepada generasi muda, yang kelak akan menjadi orang dewasa yang lebih peduli terhadap kesejahteraan hewan.</p>\r\n    \r\n    <li><strong>Distribusi Materi Edukasi</strong></li>\r\n    <p>Menyebarkan brosur, pamflet, atau poster yang menginformasikan masyarakat mengenai cara merawat hewan peliharaan dengan baik dan mencegah hewan terlantar adalah langkah yang sederhana namun efektif. Materi edukasi ini bisa ditempatkan di tempat-tempat umum, seperti pasar, klinik hewan, dan pusat perbelanjaan.</p>\r\n</ul>\r\n\r\n<p><strong>Referensi</strong></p>\r\n\r\n<ul>\r\n    <li><em>World Animal Protection</em>. (2021). \"Why Animal Welfare Matters\". Diakses dari: <a href=\"https://www.worldanimalprotection.org.uk\" target=\"_blank\">https://www.worldanimalprotection.org.uk</a></li>\r\n    <li><em>Humane Society International</em>. (2022). \"Campaigns for Stray Animals\". Diakses dari: <a href=\"https://www.hsi.org/issues/stray-animals\" target=\"_blank\">https://www.hsi.org/issues/stray-animals</a></li>\r\n    <li><em>Petfinder</em>. (2020). \"How to Help Stray Animals\". Diakses dari: <a href=\"https://www.petfinder.com\" target=\"_blank\">https://www.petfinder.com</a></li>\r\n</ul>\r\n', 'penyuluhan.jpg'),
(4, 'Karakteristik dan Cara Membantu Kucing yang Terlantar', 'Prayoga Agus Setiawan', '2024-11-28', '<p><strong>Karakteristik dan Cara Membantu Kucing yang Terlantar</strong></p>\r\n\r\n<p>Kucing adalah hewan yang sering hidup di lingkungan perkotaan. Banyak kucing terlantar yang tidak memiliki tempat tinggal atau makanan yang cukup. Mereka biasanya terlihat berkeliaran di jalanan, tempat sampah, atau tempat umum lainnya.</p>\r\n    <p>Kucing terlantar sering kali tampak kurus dan memiliki bulu yang kusam. Mereka bisa terlihat waspada dan agresif, terutama jika mereka merasa terancam. Cara terbaik untuk membantu kucing terlantar adalah dengan memberi mereka makanan dan air, serta menghubungi organisasi penyelamatan hewan lokal untuk mendapatkan bantuan lebih lanjut.</p>\r\n    <p><strong>Referensi:</strong> International Cat Care. (2020). <a href=\"https://icatcare.org/advice/caring-for-stray-and-feral-cats/\" target=\"_blank\">Caring for Stray and Feral Cats</a>.</p>\r\n', 'cat.jpg'),
(5, 'Tantangan dan Cara Penanganan Anjing yang Terlantar', 'Prayoga Agus Setiawan', '2024-11-28', '<p><strong>Tantangan dan Cara Penanganan Anjing yang Terlantar</strong></p>\r\n\r\n<p>Anjing adalah makhluk yang sangat setia, namun banyak dari mereka yang terlantar karena berbagai alasan seperti kehilangan pemilik, atau tidak lagi diinginkan. Anjing terlantar menghadapi banyak tantangan, termasuk kelaparan, dehidrasi, dan risiko kecelakaan di jalanan.</p>\r\n    <p>Jika Anda menemukan anjing terlantar, langkah pertama adalah memastikan hewan tersebut tidak agresif sebelum mencoba menolong. Jika memungkinkan, berikan makanan dan air, dan cek apakah anjing tersebut memiliki kalung identifikasi. Hubungi pusat penyelamatan atau organisasi setempat untuk penanganan lebih lanjut.</p>\r\n    <p><strong>Referensi:</strong> American Humane. (2021). <a href=\"https://www.americanhumane.org/fact-sheet/stray-dogs/\" target=\"_blank\">How to Help Stray Dogs</a>.</p>\r\n', 'dog.jpg'),
(6, 'Membantu Hewan Kecil Lain yang Terlantar Seperti Kelinci, Burung, dan Lainnya', 'Prayoga Agus Setiawan', '2024-11-28', '<p><strong>Membantu Hewan Kecil Lain yang Terlantar Seperti Kelinci, Burung, dan Lainnya</strong></p>\r\n\r\n<p>Selain kucing dan anjing, ada banyak hewan kecil lain yang sering terlantar, seperti kelinci, burung, bahkan hamster. Hewan-hewan ini sering kali ditinggalkan karena pemiliknya tidak lagi mampu atau mau merawat mereka.</p>\r\n    <p>Kelinci dan hewan pengerat lainnya membutuhkan tempat berlindung yang aman, karena mereka rentan terhadap pemangsa. Burung terlantar sering kali mengalami kesulitan dalam mencari makanan, terutama di daerah perkotaan. Jika Anda menemukan hewan-hewan ini, cobalah untuk memberi mereka tempat yang aman dan makanan yang sesuai, dan hubungi organisasi penyelamatan hewan untuk penanganan lebih lanjut.</p>\r\n    <p><strong>Referensi:</strong> The Humane Society of the United States. (2022). <a href=\"https://www.humanesociety.org/resources/how-help-wildlife\" target=\"_blank\">How to Help Stray Small Animals</a>.</p>\r\n', 'rabbit.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `donasi`
--

CREATE TABLE `donasi` (
  `id_donasi` int(11) NOT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `id_shelter` int(11) DEFAULT NULL,
  `id_metode` int(11) DEFAULT NULL,
  `id_rekening` int(11) NOT NULL,
  `tanggal_submit` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `donasi`
--

INSERT INTO `donasi` (`id_donasi`, `id_pengguna`, `id_shelter`, `id_metode`, `id_rekening`, `tanggal_submit`) VALUES
(4, 4, 4, 1, 1, '2024-12-11'),
(5, 4, 4, 1, 1, '2024-12-12'),
(6, 4, 4, 1, 1, '2024-12-12'),
(7, 4, 4, 1, 1, '2024-12-12'),
(10, 4, 4, 1, 1, '2024-12-12'),
(11, 4, 4, 1, 1, '2024-12-12'),
(12, 4, 4, 1, 1, '2024-12-12'),
(13, 4, 4, 1, 1, '2024-12-12'),
(14, 4, 4, 1, 1, '2024-12-12'),
(15, 4, 4, 1, 1, '2024-12-12'),
(16, 4, 4, 1, 1, '2024-12-12'),
(17, 4, 4, 1, 1, '2024-12-12'),
(18, 4, 4, 1, 1, '2024-12-12'),
(19, 4, 4, 1, 1, '2024-12-12'),
(20, 4, 4, 1, 1, '2024-12-12'),
(22, 4, 4, 1, 1, '2024-12-12'),
(23, 4, 4, 1, 1, '2024-12-12'),
(24, 4, 4, 1, 1, '2024-12-12'),
(25, 4, 4, 1, 1, '2024-12-12'),
(26, 5, 4, 1, 1, '2024-12-12'),
(27, 5, 4, 1, 1, '2024-12-14'),
(28, 5, 4, 1, 1, '2024-12-15'),
(29, 5, 4, 1, 1, '2024-12-15'),
(31, 7, 4, 1, 1, '2024-12-15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hewan`
--

CREATE TABLE `hewan` (
  `id_hewan` int(11) NOT NULL,
  `jenis_hewan` varchar(50) DEFAULT NULL,
  `foto` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hewan`
--

INSERT INTO `hewan` (`id_hewan`, `jenis_hewan`, `foto`) VALUES
(1, 'Kucing', 'kucing1.jpg'),
(2, 'Anjing', 'anjing1.jpg'),
(3, 'Kelinci', 'kelinci1.jpg'),
(4, 'Kucing', 'assets/img/cats.jpg'),
(5, 'Kucing', 'assets/img/cats.jpg'),
(6, 'Kucing', 'assets/img/cats.jpg'),
(7, 'Kucing', 'assets/img/cats.jpg'),
(8, 'Kucing', 'assets/img/cats.jpg'),
(9, 'anjing', 'assets/img/Screenshot 2024-07-30 002332.png'),
(10, 'anjing', 'assets/img/Screenshot 2024-07-28 000522.png'),
(11, 'anjing', 'assets/img/Screenshot 2024-07-30 002332.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hewan_shelter`
--

CREATE TABLE `hewan_shelter` (
  `id_hewan` int(11) NOT NULL,
  `id_shelter` int(11) NOT NULL,
  `nama_hewan` varchar(100) DEFAULT NULL,
  `jenis_hewan` varchar(50) DEFAULT NULL,
  `status` enum('tersedia','diadopsi') DEFAULT NULL,
  `keterangan_hewan` text DEFAULT NULL,
  `foto_hewan` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hewan_shelter`
--

INSERT INTO `hewan_shelter` (`id_hewan`, `id_shelter`, `nama_hewan`, `jenis_hewan`, `status`, `keterangan_hewan`, `foto_hewan`) VALUES
(1, 4, 'Milo', 'Kucing', '', 'Kucing Persia umur 1 tahun', 'milo.jpg'),
(2, 4, 'Bruno', 'Anjing', '', 'Anjing Golden umur 2 tahun', 'bruno.jpg'),
(3, 2, 'Luna', 'Kucing', 'diadopsi', 'Kucing Anggora umur 8 bulan', 'luna.jpg'),
(4, 4, 'Bunny', 'Kelinci', 'diadopsi', 'Kelinci umur 6 bulan', 'Screenshot 2024-07-28 000522.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int(11) NOT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `id_hewan` int(11) DEFAULT NULL,
  `id_shelter` int(11) DEFAULT NULL,
  `nama_laporan` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status_laporan` enum('pending','proses','selesai') DEFAULT NULL,
  `id_alamat` int(11) DEFAULT NULL,
  `tanggal_laporan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`id_laporan`, `id_pengguna`, `id_hewan`, `id_shelter`, `nama_laporan`, `keterangan`, `status_laporan`, `id_alamat`, `tanggal_laporan`) VALUES
(5, 4, 8, 4, 'Hewan terlantar', 'Hewan terlantar', 'proses', 1, '2024-12-09'),
(6, 7, 9, 4, 'ngaku2 tuhan', 'ajshnjhd', 'selesai', 19, '2024-12-15'),
(7, 7, 10, 4, 'ngaku2 tuhan', 'ngaku2 tuhan', 'pending', 36, '2024-12-15'),
(8, 8, 11, 4, 'ngaku2 tuhan', 'aa', 'pending', 36, '2024-12-15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `metode_pembayaran`
--

CREATE TABLE `metode_pembayaran` (
  `id_metode` int(11) NOT NULL,
  `nama_metode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `metode_pembayaran`
--

INSERT INTO `metode_pembayaran` (`id_metode`, `nama_metode`) VALUES
(1, 'Dana'),
(2, 'ShopeePay'),
(3, 'Ovo'),
(4, 'Gopay'),
(5, 'BNI'),
(6, 'BRI'),
(7, 'Mandiri'),
(8, 'Seabank');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_donasi` int(11) DEFAULT NULL,
  `bukti_transfer` varchar(255) NOT NULL,
  `nominal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_donasi`, `bukti_transfer`, `nominal`) VALUES
(4, 4, 'assets/pembayaran/tracing sabito.jpg', 15000.00),
(5, 5, 'assets/pembayaran/Screenshot 2024-09-09 093956.png', 10000.00),
(6, 6, 'assets/pembayaran/Screenshot 2024-09-02 115709.png', 10000.00),
(7, 7, 'assets/pembayaran/Screenshot 2024-09-02 120047.png', 10000.00),
(8, 10, 'assets/pembayaran/Screenshot 2024-09-09 092848.png', 10000.00),
(9, 11, 'assets/pembayaran/Screenshot 2024-09-02 120054.png', 10000.00),
(10, 12, 'assets/pembayaran/Screenshot 2024-09-09 092811.png', 100000.00),
(11, 13, 'assets/pembayaran/Screenshot 2024-09-09 092811.png', 10000.00),
(12, 14, 'assets/pembayaran/Screenshot 2024-09-09 092811.png', 100000.00),
(13, 15, 'assets/pembayaran/Screenshot 2024-09-09 092834.png', 100000.00),
(14, 16, 'assets/pembayaran/Screenshot 2024-09-02 115709.png', 10000.00),
(15, 17, 'assets/pembayaran/Screenshot 2024-08-11 225556.png', 100000.00),
(16, 18, 'assets/pembayaran/Screenshot 2024-09-02 120047.png', 10000.00),
(17, 19, 'assets/pembayaran/Screenshot 2024-09-02 115709.png', 100000.00),
(18, 20, 'assets/pembayaran/Screenshot 2024-08-07 180324.png', 100000.00),
(19, 22, 'assets/pembayaran/Screenshot 2024-09-09 092736.png', 100000.00),
(20, 23, 'assets/pembayaran/Screenshot 2024-09-02 115709.png', 100000.00),
(21, 24, 'assets/pembayaran/Screenshot 2024-09-02 115709.png', 100000.00),
(22, 25, 'assets/pembayaran/675b052f48433_Screenshot 2024-09-02 115709.png', 100000.00),
(23, 26, 'assets/pembayaran/675b199990c79_Screenshot 2024-08-08 194707.png', 10000.00),
(24, 27, 'assets/pembayaran/675d826fb59f3_Screenshot 2024-09-02 115709.png', 100000.00),
(25, 28, 'assets/pembayaran/Screenshot 2024-08-07 180324.png', 10000000.00),
(26, 29, 'assets/pembayaran/Screenshot 2024-09-02 120054.png', 100000.00),
(27, 31, 'assets/pembayaran/Screenshot 2024-09-02 115709.png', 100000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `id_alamat` int(11) DEFAULT NULL,
  `id_akun` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `kontak` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `id_alamat`, `id_akun`, `nama`, `kontak`) VALUES
(1, NULL, NULL, 'John Doe', '081234567890'),
(2, NULL, NULL, 'Jane Smith', '081234567891'),
(3, NULL, NULL, 'Mike Johnson', '081234567892'),
(4, 54, 4, 'Jang Wonyoung', '082123456789'),
(5, 56, 6, 'sandoer', '08182912'),
(6, 58, 8, 'sandoer', '08182912178'),
(7, 59, 9, 'biskuat', '08182912178'),
(8, 61, 11, 'tuan', '08182912178');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekening_shelter`
--

CREATE TABLE `rekening_shelter` (
  `id_rekening` int(11) NOT NULL,
  `id_shelter` int(11) DEFAULT NULL,
  `id_metode` int(11) DEFAULT NULL,
  `nomor_rekening` varchar(255) DEFAULT NULL,
  `nama_pemilik_rekening` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rekening_shelter`
--

INSERT INTO `rekening_shelter` (`id_rekening`, `id_shelter`, `id_metode`, `nomor_rekening`, `nama_pemilik_rekening`) VALUES
(1, 4, 1, '0856789123411', 'Karina'),
(2, 4, 4, '8378267391', '1233123213');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat`
--

CREATE TABLE `riwayat` (
  `id_riwayat` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `id_artikel` int(11) NOT NULL,
  `tanggal_baca` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `riwayat`
--

INSERT INTO `riwayat` (`id_riwayat`, `user_id`, `id_artikel`, `tanggal_baca`) VALUES
(1, 4, 4, '2024-12-08 16:41:54'),
(2, 4, 2, '2024-12-08 17:00:04'),
(3, 4, 3, '2024-12-10 07:13:15'),
(4, 4, 4, '2024-12-15 18:07:16'),
(5, 4, 1, '2024-12-15 18:07:20'),
(6, 4, 4, '2024-12-15 18:07:20'),
(7, 4, 5, '2024-12-15 18:07:21'),
(8, 4, 6, '2024-12-15 18:07:22'),
(9, 4, 4, '2024-12-23 14:23:58'),
(10, 4, 3, '2024-12-24 11:35:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `shelter`
--

CREATE TABLE `shelter` (
  `id_shelter` int(11) NOT NULL,
  `id_alamat` int(11) DEFAULT NULL,
  `id_akun` int(11) DEFAULT NULL,
  `nama_shelter` varchar(100) DEFAULT NULL,
  `kontak` varchar(20) DEFAULT NULL,
  `deskripsi_shelter` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `shelter`
--

INSERT INTO `shelter` (`id_shelter`, `id_alamat`, `id_akun`, `nama_shelter`, `kontak`, `deskripsi_shelter`) VALUES
(1, 51, 1, 'Happy Pets Shelter', '081234567890', 'Shelter hewan dengan fasilitas lengkap'),
(2, 52, 2, 'Paw Shelter', '081234567891', 'Shelter khusus kucing dan anjing'),
(3, 53, 3, 'Pet Rescue Center', '081234567892', 'Pusat penyelamatan hewan terlantar'),
(4, 55, 5, 'Paw Care', '082123456789', 'Paw Care menjaga dan merawat hewan dengan penu kasih sayang'),
(6, 60, 10, 'abi', '08182912', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `adopsi`
--
ALTER TABLE `adopsi`
  ADD PRIMARY KEY (`id_adopsi`),
  ADD KEY `id_hewan` (`id_hewan`),
  ADD KEY `id_shelter` (`id_shelter`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indeks untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id_akun`);

--
-- Indeks untuk tabel `alamat`
--
ALTER TABLE `alamat`
  ADD PRIMARY KEY (`id_alamat`);

--
-- Indeks untuk tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id_artikel`);

--
-- Indeks untuk tabel `donasi`
--
ALTER TABLE `donasi`
  ADD PRIMARY KEY (`id_donasi`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_shelter` (`id_shelter`),
  ADD KEY `fk_id_metode` (`id_metode`),
  ADD KEY `fk_id_rekening` (`id_rekening`);

--
-- Indeks untuk tabel `hewan`
--
ALTER TABLE `hewan`
  ADD PRIMARY KEY (`id_hewan`);

--
-- Indeks untuk tabel `hewan_shelter`
--
ALTER TABLE `hewan_shelter`
  ADD PRIMARY KEY (`id_hewan`,`id_shelter`),
  ADD KEY `id_shelter` (`id_shelter`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_hewan` (`id_hewan`),
  ADD KEY `id_shelter` (`id_shelter`),
  ADD KEY `laporan_ibfk_4` (`id_alamat`);

--
-- Indeks untuk tabel `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  ADD PRIMARY KEY (`id_metode`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_donasi` (`id_donasi`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD KEY `id_alamat` (`id_alamat`),
  ADD KEY `id_akun` (`id_akun`);

--
-- Indeks untuk tabel `rekening_shelter`
--
ALTER TABLE `rekening_shelter`
  ADD PRIMARY KEY (`id_rekening`),
  ADD KEY `id_shelter` (`id_shelter`),
  ADD KEY `id_metode` (`id_metode`);

--
-- Indeks untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  ADD PRIMARY KEY (`id_riwayat`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `id_artikel` (`id_artikel`);

--
-- Indeks untuk tabel `shelter`
--
ALTER TABLE `shelter`
  ADD PRIMARY KEY (`id_shelter`),
  ADD KEY `id_alamat` (`id_alamat`),
  ADD KEY `id_akun` (`id_akun`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `adopsi`
--
ALTER TABLE `adopsi`
  MODIFY `id_adopsi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `akun`
--
ALTER TABLE `akun`
  MODIFY `id_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `alamat`
--
ALTER TABLE `alamat`
  MODIFY `id_alamat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT untuk tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id_artikel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `donasi`
--
ALTER TABLE `donasi`
  MODIFY `id_donasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `hewan`
--
ALTER TABLE `hewan`
  MODIFY `id_hewan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `hewan_shelter`
--
ALTER TABLE `hewan_shelter`
  MODIFY `id_hewan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  MODIFY `id_metode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `rekening_shelter`
--
ALTER TABLE `rekening_shelter`
  MODIFY `id_rekening` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `shelter`
--
ALTER TABLE `shelter`
  MODIFY `id_shelter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `adopsi`
--
ALTER TABLE `adopsi`
  ADD CONSTRAINT `adopsi_ibfk_1` FOREIGN KEY (`id_hewan`) REFERENCES `hewan` (`id_hewan`),
  ADD CONSTRAINT `adopsi_ibfk_2` FOREIGN KEY (`id_shelter`) REFERENCES `shelter` (`id_shelter`),
  ADD CONSTRAINT `adopsi_ibfk_3` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);

--
-- Ketidakleluasaan untuk tabel `donasi`
--
ALTER TABLE `donasi`
  ADD CONSTRAINT `donasi_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`),
  ADD CONSTRAINT `donasi_ibfk_2` FOREIGN KEY (`id_shelter`) REFERENCES `shelter` (`id_shelter`),
  ADD CONSTRAINT `fk_id_metode` FOREIGN KEY (`id_metode`) REFERENCES `metode_pembayaran` (`id_metode`),
  ADD CONSTRAINT `fk_id_rekening` FOREIGN KEY (`id_rekening`) REFERENCES `rekening_shelter` (`id_rekening`);

--
-- Ketidakleluasaan untuk tabel `hewan_shelter`
--
ALTER TABLE `hewan_shelter`
  ADD CONSTRAINT `hewan_shelter_ibfk_1` FOREIGN KEY (`id_hewan`) REFERENCES `hewan` (`id_hewan`),
  ADD CONSTRAINT `hewan_shelter_ibfk_2` FOREIGN KEY (`id_shelter`) REFERENCES `shelter` (`id_shelter`);

--
-- Ketidakleluasaan untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`),
  ADD CONSTRAINT `laporan_ibfk_2` FOREIGN KEY (`id_hewan`) REFERENCES `hewan` (`id_hewan`),
  ADD CONSTRAINT `laporan_ibfk_3` FOREIGN KEY (`id_shelter`) REFERENCES `shelter` (`id_shelter`),
  ADD CONSTRAINT `laporan_ibfk_4` FOREIGN KEY (`id_alamat`) REFERENCES `alamat` (`id_alamat`);

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_donasi`) REFERENCES `donasi` (`id_donasi`);

--
-- Ketidakleluasaan untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD CONSTRAINT `pengguna_ibfk_1` FOREIGN KEY (`id_alamat`) REFERENCES `alamat` (`id_alamat`),
  ADD CONSTRAINT `pengguna_ibfk_2` FOREIGN KEY (`id_akun`) REFERENCES `akun` (`id_akun`);

--
-- Ketidakleluasaan untuk tabel `rekening_shelter`
--
ALTER TABLE `rekening_shelter`
  ADD CONSTRAINT `rekening_shelter_ibfk_1` FOREIGN KEY (`id_shelter`) REFERENCES `shelter` (`id_shelter`),
  ADD CONSTRAINT `rekening_shelter_ibfk_2` FOREIGN KEY (`id_metode`) REFERENCES `metode_pembayaran` (`id_metode`);

--
-- Ketidakleluasaan untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  ADD CONSTRAINT `riwayat_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `akun` (`id_akun`),
  ADD CONSTRAINT `riwayat_ibfk_2` FOREIGN KEY (`id_artikel`) REFERENCES `artikel` (`id_artikel`);

--
-- Ketidakleluasaan untuk tabel `shelter`
--
ALTER TABLE `shelter`
  ADD CONSTRAINT `shelter_ibfk_1` FOREIGN KEY (`id_alamat`) REFERENCES `alamat` (`id_alamat`),
  ADD CONSTRAINT `shelter_ibfk_2` FOREIGN KEY (`id_akun`) REFERENCES `akun` (`id_akun`);
--
-- Database: `perpustakaan`
--
CREATE DATABASE IF NOT EXISTS `perpustakaan` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `perpustakaan`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(4) NOT NULL,
  `judul_buku` varchar(100) NOT NULL,
  `tahun_terbit` year(4) DEFAULT NULL,
  `penerbit` varchar(50) DEFAULT NULL,
  `pengarang` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `denda`
--

CREATE TABLE `denda` (
  `id_denda` int(4) NOT NULL,
  `id_pengembalian` int(4) NOT NULL,
  `jml_denda` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_peminjaman`
--

CREATE TABLE `detail_peminjaman` (
  `id_detail` int(4) NOT NULL,
  `id_peminjaman` int(4) NOT NULL,
  `id_buku` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` int(4) NOT NULL,
  `nama_mhs` varchar(100) NOT NULL,
  `prodi` varchar(30) NOT NULL,
  `kontak` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(4) NOT NULL,
  `nim` int(4) NOT NULL,
  `id_pstkwn` int(4) NOT NULL,
  `tgl_peminjaman` date NOT NULL,
  `tgl_jatuh_tempo` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_pengembalian` int(4) NOT NULL,
  `id_peminjaman` int(4) NOT NULL,
  `tgl_pengembalian` int(4) NOT NULL,
  `id_pstkwn` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pustakawan`
--

CREATE TABLE `pustakawan` (
  `id_pstkwn` int(4) NOT NULL,
  `nama_pstkwn` varchar(100) NOT NULL,
  `shift` varchar(10) NOT NULL,
  `kontak` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pustakawan`
--

INSERT INTO `pustakawan` (`id_pstkwn`, `nama_pstkwn`, `shift`, `kontak`) VALUES
(1, 'Budi jaya', 'Pagi', '08123456789'),
(2, 'Agus Sakti', 'Siang', '08129876543'),
(3, 'Wawan umpshot', 'Sore', '08129176543'),
(4, 'Bernard bear', 'Sore', '08129176123'),
(5, 'Dika', 'Malam', '08129111143');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indeks untuk tabel `denda`
--
ALTER TABLE `denda`
  ADD PRIMARY KEY (`id_denda`),
  ADD KEY `id_pengembalian` (`id_pengembalian`);

--
-- Indeks untuk tabel `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_peminjaman` (`id_peminjaman`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `nim` (`nim`),
  ADD KEY `id_pstkwn` (`id_pstkwn`);

--
-- Indeks untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id_pengembalian`),
  ADD KEY `id_peminjaman` (`id_peminjaman`),
  ADD KEY `fk_id_pstkwn` (`id_pstkwn`);

--
-- Indeks untuk tabel `pustakawan`
--
ALTER TABLE `pustakawan`
  ADD PRIMARY KEY (`id_pstkwn`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `denda`
--
ALTER TABLE `denda`
  MODIFY `id_denda` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  MODIFY `id_detail` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `nim` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id_pengembalian` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pustakawan`
--
ALTER TABLE `pustakawan`
  MODIFY `id_pstkwn` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `denda`
--
ALTER TABLE `denda`
  ADD CONSTRAINT `denda_ibfk_1` FOREIGN KEY (`id_pengembalian`) REFERENCES `pengembalian` (`id_pengembalian`);

--
-- Ketidakleluasaan untuk tabel `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD CONSTRAINT `detail_peminjaman_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`),
  ADD CONSTRAINT `detail_peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`);

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_pstkwn`) REFERENCES `pustakawan` (`id_pstkwn`);

--
-- Ketidakleluasaan untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `fk_id_pstkwn` FOREIGN KEY (`id_pstkwn`) REFERENCES `pustakawan` (`id_pstkwn`),
  ADD CONSTRAINT `pengembalian_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`);
--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data untuk tabel `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"papaw\",\"table\":\"donasi\"},{\"db\":\"papaw\",\"table\":\"pembayaran\"},{\"db\":\"papaw\",\"table\":\"rekening_shelter\"},{\"db\":\"papaw\",\"table\":\"pengguna\"},{\"db\":\"papaw\",\"table\":\"hewan_shelter\"},{\"db\":\"papaw\",\"table\":\"laporan\"},{\"db\":\"papaw\",\"table\":\"metode_pembayaran\"},{\"db\":\"papaw\",\"table\":\"akun\"},{\"db\":\"papaw\",\"table\":\"shelter\"},{\"db\":\"papaw\",\"table\":\"artikel\"}]');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

--
-- Dumping data untuk tabel `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'papaw', 'donasi', '[]', '2024-12-10 05:53:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data untuk tabel `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2024-12-24 14:44:00', '{\"Console\\/Mode\":\"show\",\"lang\":\"id\"}');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indeks untuk tabel `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indeks untuk tabel `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indeks untuk tabel `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indeks untuk tabel `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indeks untuk tabel `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indeks untuk tabel `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indeks untuk tabel `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indeks untuk tabel `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indeks untuk tabel `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indeks untuk tabel `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indeks untuk tabel `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indeks untuk tabel `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indeks untuk tabel `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indeks untuk tabel `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indeks untuk tabel `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indeks untuk tabel `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indeks untuk tabel `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
--
-- Database: `wa`
--
CREATE DATABASE IF NOT EXISTS `wa` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `wa`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `group_chat`
--

CREATE TABLE `group_chat` (
  `chat_id` int(11) NOT NULL,
  `nama_group` varchar(255) DEFAULT NULL,
  `chat_type` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `group_chat`
--

INSERT INTO `group_chat` (`chat_id`, `nama_group`, `chat_type`) VALUES
(3, 'Grup Keluarga', 'group');

-- --------------------------------------------------------

--
-- Struktur dari tabel `message`
--

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `waktu` datetime DEFAULT NULL,
  `chat_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `message`
--

INSERT INTO `message` (`message_id`, `content`, `waktu`, `chat_id`, `sender_id`) VALUES
(1, 'Halo, aku anakmu', '2024-11-14 21:50:46', 1, 100),
(2, 'kangen!', '2024-11-14 21:50:46', 1, 201),
(3, 'Selamat pagi, Budi Jaya', '2024-11-14 21:50:46', 2, 102),
(4, 'Mamah baru beli hadiah untuk kamu, love you!', '2024-11-14 21:50:46', 2, 220),
(5, 'Hei Budi, gimana kalau malam ini kita makan bareng?', '2024-11-14 21:50:46', 3, 201),
(6, 'haha', '2024-11-14 21:50:46', 3, 102),
(7, 'wkwk', '2024-11-14 21:50:46', 3, 220);

-- --------------------------------------------------------

--
-- Struktur dari tabel `private_chat`
--

CREATE TABLE `private_chat` (
  `chat_id` int(11) NOT NULL,
  `chat_type` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `private_chat`
--

INSERT INTO `private_chat` (`chat_id`, `chat_type`) VALUES
(1, 'private');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `no_telpon` varchar(13) DEFAULT NULL,
  `status` text DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `nama`, `no_telpon`, `status`, `profile_picture`) VALUES
(100, 'Penipu', '08123456789', 'Sedang di Tokyo', 'aa_profile.jpg'),
(102, 'Papah IM3', '0823457890', 'cinta anak', 'pp.jpg'),
(201, 'Viola Jelita', '0834567890', 'makan dulu', 'bb_profile.jpg'),
(220, 'Mamah baru', '08567182680', 'alhamdullilah', 'n.jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `group_chat`
--
ALTER TABLE `group_chat`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indeks untuk tabel `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indeks untuk tabel `private_chat`
--
ALTER TABLE `private_chat`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `user` (`user_id`);
--
-- Database: `whatsapp`
--
CREATE DATABASE IF NOT EXISTS `whatsapp` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `whatsapp`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `chat`
--

CREATE TABLE `chat` (
  `chat_id` int(11) NOT NULL,
  `chat_type` enum('private','group') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `chat`
--

INSERT INTO `chat` (`chat_id`, `chat_type`) VALUES
(1, 'private');

-- --------------------------------------------------------

--
-- Struktur dari tabel `message`
--

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `waktu` datetime NOT NULL,
  `chat_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `message`
--

INSERT INTO `message` (`message_id`, `content`, `waktu`, `chat_id`, `sender_id`) VALUES
(1, 'elzio liat mama', '2024-11-13 20:41:15', 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `nama` varchar(244) NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `status` varchar(30) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `nama`, `no_telp`, `status`, `profile_picture`) VALUES
(1, 'Bodie', '081234567890', 'hahaha lucu ', 'profile_pic.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_chat`
--

CREATE TABLE `user_chat` (
  `user_id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indeks untuk tabel `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `chat_id` (`chat_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `no_telp` (`no_telp`);

--
-- Indeks untuk tabel `user_chat`
--
ALTER TABLE `user_chat`
  ADD PRIMARY KEY (`user_id`,`chat_id`),
  ADD KEY `chat_id` (`chat_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `chat`
--
ALTER TABLE `chat`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `chat` (`chat_id`),
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `user` (`user_id`);

--
-- Ketidakleluasaan untuk tabel `user_chat`
--
ALTER TABLE `user_chat`
  ADD CONSTRAINT `user_chat_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `user_chat_ibfk_2` FOREIGN KEY (`chat_id`) REFERENCES `chat` (`chat_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
