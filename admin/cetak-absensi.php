<?php
require 'config.php';
require 'fpdf/fpdf.php';

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',11);

$pdf->SetFillColor(39,40,34);
$pdf->SetTextColor(255,255,255);

$pdf->Cell(20,10,'NIS', 0, 0, 'C', true);
$pdf->Cell(30,10,'Nama', 0, 0, 'C', true);
$pdf->Cell(30,10,'Kelas', 0, 0, 'C', true);
$pdf->Cell(40,10,'Kehadiran', 0, 0, 'C', true);
$pdf->Cell(30,10,'Waktu', 0, 0, 'C', true);
$pdf->Cell(30,10,'Tanggal', 0, 0, 'C', true);
$pdf->Ln(10);


$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0,0);

/**
 * SQL : mengambil data dari database
 */

$sql = "SELECT SQL_CALC_FOUND_ROWS k.idkehadiran, a.nis, a.nama, a.kelas, k.kehadiran, k.jam, k.tanggal, k.nis 
FROM kehadiran AS k 
INNER JOIN siswa AS a 
on k.nis=a.nis";

# $db dari file config.php
$query = $db->query($sql);

$n = 22;
if ($query->num_rows > 0) {
    while ($row = $query->fetch_assoc()) {
    	$pdf->Cell(20,10, $row['nis'], 1, 0, 'C');
    	$pdf->Cell(30,10, $row['nama'], 1, 0, 'C');
		$pdf->Cell(30,10, $row['kelas'], 1, 0, 'C');
		$pdf->Cell(40,10, $row['kehadiran'], 1, 0, 'C');
		$pdf->Cell(30,10, $row['jam'], 1, 0, 'C');
		$pdf->Cell(30,10, $row['tanggal'], 1, 0, 'C');
		$pdf->Ln();

		$n = $n+10;
    }
}

$pdf->Output('I');
?>