<?php
$artista=$_POST['artista'];
$costo=$_POST['costo'];
$zona=$_POST['zona'];
$asiento=$_POST['asiento'];
$operacion=$_POST['no_oper'];
require('../fpdf.php');

$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,10,$artista);
$pdf->Cell(40,20,$costo);
$pdf->Cell(40,30,$zona);
$pdf->Cell(40,40,$asiento);
$pdf->Cell(40,60,$operacion);

$pdf->Output();


?>
