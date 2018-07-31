<?php
$artista=$_POST['artista'];
$costo=$_POST['costo'];
$zona=$_POST['zona'];
$fila=$_POST['fila'];
$fecha_pres=$_POST['fecha_p'];
$hora=$_POST['hora'];
$asiento=$_POST['asiento'];
$operacion=$_POST['no_oper'];
$fecha_imp=date('d M y h:m');
  include('../Barcode.php');
  require('../fpdf.php');
  
  // -------------------------------------------------- //
  //                      USEFULL
  // -------------------------------------------------- //
  
  class eFPDF extends FPDF{
    function TextWithRotation($x, $y, $txt, $txt_angle, $font_angle=0)
    {
        $font_angle+=90+$txt_angle;
        $txt_angle*=M_PI/180;
        $font_angle*=M_PI/180;
    
        $txt_dx=cos($txt_angle);
        $txt_dy=sin($txt_angle);
        $font_dx=cos($font_angle);
        $font_dy=sin($font_angle);
    
        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',$txt_dx,$txt_dy,$font_dx,$font_dy,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
        if ($this->ColorFlag)
            $s='q '.$this->TextColor.' '.$s.' Q';
        $this->_out($s);
    }
  }

  // -------------------------------------------------- //
  //                  PROPERTIES
  // -------------------------------------------------- //
  
  $fontSize = 10;
  $marge    = 10;   // between barcode and hri in pixel
  $x        = 370;  // barcode center
  $y        = 590;  // barcode center
  $height   = 20;   // barcode height in 1D ; module size in 2D
  $width    = .8;    // barcode height in 1D ; not use in 2D
  $angle    = 270;   // rotation in degrees : nb : non horizontable barcode might not be usable because of pixelisation
  $anglea=360;
  $xa=150;
  $ya=200;
  $xf=240;
  $yf=400;
  setType($operacion,"string");
  $code1='913799923405';
  $code     = $code1; // barcode, of course ;)
  $type     = 'code39';
  $black    = '000000'; // color in hexa
  
  
  // -------------------------------------------------- //
  //            ALLOCATE FPDF RESSOURCE
  // -------------------------------------------------- //
    
  $pdf = new eFPDF('P', 'pt');
  $pdf->AddPage();
  
  // -------------------------------------------------- //
  //                      BARCODE
  // -------------------------------------------------- //
  
  $data = Barcode::fpdf($pdf, $black, $x, $y, $angle, $type, $operacion, $width, $height);
  
  // -------------------------------------------------- //
  //                      HRI
  // -------------------------------------------------- //
  
  $pdf->SetFont('Arial','B',$fontSize);
  $pdf->SetTextColor(0, 0, 0);
  $len = $pdf->GetStringWidth($data['hri']);
  Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge, $angle, $xt, $yt);
  $pdf->TextWithRotation($x + $xt, $y + $yt, $data['hri'], $angle);
  
  /**$pdf->Cell(80,100,$artista,0);**/
$pdf->TextWithRotation(400,480,$costo,180);
$pdf->TextWithRotation(340,480,$fila,180);
$pdf->TextWithRotation(300,480,$asiento,180);
$pdf->TextWithRotation(250,480,$zona,180);
$pdf->TextWithRotation(400,680,$costo,180);
$pdf->TextWithRotation(340,680,$fila,180);
$pdf->TextWithRotation(300,680,$asiento,180);
$pdf->TextWithRotation(250,680,$zona,180);
$pdf->SetFont('Arial','B',24);
 $pdf->TextWithRotation(320, 630, $artista, 180);
 $pdf->SetFont('Arial','B',16);
 $pdf->TextWithRotation(300,610,$fecha_pres,180);
 $pdf->TextWithRotation(290,590,$hora,180);
 $pdf->SetFont('Arial','B',12);
 $pdf->TextWithRotation(310,560,'Fecha de Impresion',180);
 $pdf->TextWithRotation(300,545, $fecha_imp, 180);

  $pdf->Output();
?>