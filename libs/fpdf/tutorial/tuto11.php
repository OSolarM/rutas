<?php
require('../fpdf.php');

$pdf=new FPDF("P", "mm", "Letter");
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,5,'Comprobante Arriendo Cancha', 0, 1, 'C');
$pdf->ln(5);

$ancho = 45;

$pdf->Cell($ancho);
$pdf->Cell(25,5,'Usuario', 1, 0, 'R');
$pdf->Cell(75,5,'Juan Perez',  1, 1, 'L');

$pdf->Cell($ancho);
$pdf->Cell(25,5,'Cancha', 1, 0, 'R');
$pdf->Cell(75,5,'Juan Perez',  1, 1, 'L');

$pdf->Cell($ancho);
$pdf->Cell(25,5,'Fecha', 1, 0, 'R');
$pdf->Cell(75,5,'Juan Perez',  1, 1, 'L');

$pdf->Cell($ancho);
$pdf->Cell(25,5,'Horario', 1, 0, 'R');
$pdf->Cell(75,5,'Juan Perez',  1, 1, 'L');

$pdf->Cell($ancho);
$pdf->Cell(25,5,'Precio', 1, 0, 'R');
$pdf->Cell(75,5,'$5.000',  1, 1, 'L');

$pdf->Output();
?>
