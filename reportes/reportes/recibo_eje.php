<?php

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
  $x        = 200;  // barcode center
  $y        = 170;  // barcode center
  $height   = 30;   // barcode height in 1D ; module size in 2D
  $width    = 1;    // barcode height in 1D ; not use in 2D
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
    
  $pdf = new eFPDF('P', 'mm','letter' );
  $pdf->AddPage();
  
  // -------------------------------------------------- //
  //                      BARCODE
  // -------------------------------------------------- //
  
 // $data = Barcode::fpdf($pdf, $black, $x, $y, $angle, $type, $operacion, $width, $height);
  
  // -------------------------------------------------- //
  //                      HRI
  // -------------------------------------------------- //
  
  //$pdf->SetFont('Arial','B',$fontSize);
 // $pdf->SetTextColor(0, 0, 0);
 // $len = $pdf->GetStringWidth($data['hri']);
 // Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge, $angle, $xt, $yt);
 // $pdf->TextWithRotation($x + $xt, $y + $yt, $data['hri'], $angle);
  
  /**$pdf->Cell(80,100,$artista,0);**/
  $pdf->SetFont('Arial','B',12);
$pdf->TextWithRotation(10,10,'HOLA MUNDO',360);  
$pdf->Image('logocm_pres.jpg',10,10);

  $pdf->Output();
    
  
?>