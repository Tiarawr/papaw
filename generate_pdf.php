<?php
require('fpdf/fpdf.php'); // Pastikan sudah menginstall FPDF

header('Content-Type: application/pdf');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'FORM ADOPSI HEWAN', 0, 1, 'C');
        $this->Ln(10);
    }
}

// Inisialisasi PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Ambil data dari POST
$id_adopsi = $_POST['id_adopsi'];
$id_hewan = $_POST['id_hewan'];
$id_shelter = $_POST['id_shelter'];
$nama_hewan = $_POST['nama_hewan'];
$nama_shelter = $_POST['nama_shelter'];
$alamat = $_POST['alamat'];
$kontak_shelter = $_POST['kontak_shelter'];
$tanggal_adopsi = $_POST['tanggal_adopsi'];
$status_adopsi = $_POST['status_adopsi'];

// Tambahkan informasi ke PDF
$pdf->Cell(0, 10, 'ID Adopsi: ' . $id_adopsi, 0, 1);
$pdf->Cell(0, 10, 'ID Hewan: ' . $id_hewan, 0, 1);
$pdf->Cell(0, 10, 'ID Shelter: ' . $id_shelter, 0, 1);
$pdf->Cell(0, 10, 'Nama Hewan: ' . $nama_hewan, 0, 1);
$pdf->Cell(0, 10, 'Nama Shelter: ' . $nama_shelter, 0, 1);
$pdf->Cell(0, 10, 'Alamat Shelter: ' . $alamat, 0, 1);
$pdf->Cell(0, 10, 'Kontak Shelter: ' . $kontak_shelter, 0, 1);
$pdf->Cell(0, 10, 'Tanggal Kunjungan: ' . $tanggal_adopsi, 0, 1);
$pdf->Cell(0, 10, 'Status Adopsi: ' . ucfirst($status_adopsi), 0, 1);

// Tambahkan tempat tanda tangan
$pdf->Ln(20);
$pdf->Cell(0, 10, 'Tanda Tangan Petugas Shelter', 0, 1, 'R');
$pdf->Ln(20);
$pdf->Cell(0, 10, 'PAPAW CARE', 0, 1, 'R');

$pdf->Ln(20);
$pdf->Cell(0, 10, 'Tanda Tangan Calon Adopter', 0, 1, 'L');
$pdf->Ln(20);
$pdf->Cell(0, 10, '________________', 0, 1, 'L');

// Output PDF
$pdf->Output('Form_Adopsi_' . $id_adopsi . '.pdf', 'D');
?>