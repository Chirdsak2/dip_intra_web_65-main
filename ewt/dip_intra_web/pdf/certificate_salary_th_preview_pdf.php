<?php
require('pdf/fpdf.php');

$pdf = new FPDF();

$pdf->AddPage();
$pdf->AddFont('test','','courier.php');

$pdf->SetFont('test','',20);
$pdf->Cell(0,10,'Create PHP to PDF',0,1,'C');

$pdf->Output();
?>