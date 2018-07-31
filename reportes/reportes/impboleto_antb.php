<?php
$id=$_GET['id'];


$servidor  ="localhost"; // host
$usuario   ="keeptick_root"; 
$clave     ="Kde5p1d3rm4n25";
$basedatos ="keeptick_et";
 $conexion = mysql_connect($servidor, $usuario, $clave) or die(mysql_error());
   mysql_select_db($basedatos, $conexion) or die(mysql_error());
 $result=mysql_query("select ventas.id as folio, ventas.fecha_op as fecha, ventas.no_operacion as operacion, ventas.zona as zona, ventas.costo_b as costo_b, ventas.comision as comision, ventas.iva_com as iva_com, ventas.costo as costo, ventas.lugar as lugar, ventas.forma_pago as forma_pago, ventas.fila as fila,ventas.cuadrante as cuadrante,ventas.imp as imp, artista.nombre as artista, artista.fecha_pres as fecha, artista.hora as hora from ventas inner join artista on ventas.id_artista=artista.id
where ventas.id=$id");  
while ($row=mysql_fetch_array($result))
{

$idfolio=$row["folio"];
$operacion=$row["operacion"];
$zona=$row["zona"];
$artista=$row["artista"];
$fecha_pres=$row["fecha"];
$hora=$row["hora"];
$costo="$".$row["costo"];
$costob="$".$row["costo_b"];
$cargo=$row["comision"]+$row["iva_com"];
$cargo="$".$cargo;
$asiento=$row["lugar"];
$fila=$row["fila"];
$cuadrante=$row["cuadrante"];
$artista=$row["artista"];
$imp=$row['imp'];
}
mysql_free_result($result);
$imp=$imp+1;
$sqlUpdate = mysql_query("UPDATE ventas
SET ventas.imp = $imp 
WHERE ventas.id=$idfolio",$conexion);

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
  $y        = 120;  // barcode center
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
    
  $pdf = new eFPDF('P', 'pt',array(390,260) );
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
$pdf->TextWithRotation(20,60,$operacion,90);  
$pdf->TextWithRotation(80,20,$costo,180);
$pdf->TextWithRotation(220,20,$costob,180);
$pdf->TextWithRotation(160,20,$cargo,180);
$pdf->TextWithRotation(160,40,$cuadrante,180);
$pdf->TextWithRotation(140,40,$fila,180);
$pdf->TextWithRotation(80,40,$asiento,180);
$pdf->TextWithRotation(220,40,$zona,180);
$pdf->TextWithRotation(80,200,$costo,180);
$pdf->TextWithRotation(220,200,$costob,180);
$pdf->TextWithRotation(160,200,$cargo,180);
$pdf->TextWithRotation(160,220,$cuadrante,180);
$pdf->TextWithRotation(140,220,$fila,180);
$pdf->TextWithRotation(80,220,$asiento,180);
$pdf->TextWithRotation(220,220,$zona,180);
$pdf->SetFont('Arial','B',16);
 $pdf->TextWithRotation(160, 160, $artista, 180);
 $pdf->SetFont('Arial','B',14);
 $pdf->TextWithRotation(140,140,$fecha_pres,180);
 $pdf->TextWithRotation(135,120,$hora,180);
 $pdf->SetFont('Arial','B',12);
 $pdf->TextWithRotation(150,100,'Fecha de Impresion',180);
 $pdf->TextWithRotation(140,85, $fecha_imp, 180);

  $pdf->Output();
  
?>