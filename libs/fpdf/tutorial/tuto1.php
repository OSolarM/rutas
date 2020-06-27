<?php
require('../fpdf.php');

$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,10,'¡Hola, Mundo!');
$pdf->Output();
?>
