<?php
$cryboleto=$_GET['klave'];
$claveboleto=md5($cryboleto);
$hostname_CN = "localhost";
$database_CN = "keeptick_et";
$username_CN = "keeptick_root"; 
$password_CN = "Kde5p1d3rm4n25";
$conexion=mysql_pconnect($hostname_CN, $username_CN, $password_CN) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db($database_CN,$conexion);
$result=mysql_query("select ventas.costo_b as costob, ventas.comision as comision, ventas.iva_com as iva, ventas.costo as total, ventas.zona as zona, ventas.lugar as lugar,ventas.fila as fila, ventas.cuadrante as seccion, ventas.fecha_op as fecha, ventas.no_operacion as operacion, ventas.no_vta as folio,ventas.cva_lib as cry, clientes.nombre as registo from ventas inner join clientes on ventas.id_web=clientes.id_user
where  ventas.cva_lib='$cryboleto' and ventas.download=0",$conexion);
$updatestatus=mysql_query("update ventas set ventas.status=3, ventas.download=1 where ventas.cva_lib='$cryboleto' and ventas.status=2",$conexion);

while ($row=mysql_fetch_array($result))
{
$costo=$row["costob"];
$comision=$row["comision"];
$iva=$row["iva"];
$cargo=$comision+$iva;
$total=$row["total"];
$zona=$row["zona"];
$fila=$row["fila"];
$lugar=$row["lugar"];
$seccion=$row["seccion"];
$fechaop=$row["fecha"];
$operacion=$row["operacion"];
$folio=$row["folio"];
$cry=$row["cry"];
$cliente=$row["registo"];

}
$fecha_imp=date('d M y h:m');
$artista="1F SASHA BENNY y ERIK";
$fecha_pres="31 de Mayo 2013";
$hora="21:00 Hrs";

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
  $x        = 320;  // barcode center
  $y        = 480;  // barcode center
  $height   = 60;   // barcode height in 1D ; module size in 2D
  $width    = 2;    // barcode height in 1D ; not use in 2D
  $angle    = 360;   // rotation in degrees : nb : non horizontable barcode might not be usable because of pixelisation
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
  $pdf->Image('logo.jpg',1,1,-300);
  $pdf->Image('pol.jpg',1,680,-300);
  $pdf->Image('face.jpg',1,580,-300);
  $pdf->Image('web.jpg',1,630,-300);
  $pdf->Image('qr_img.png',70,610,-300);
  $pdf->SetFont('Arial','B',$fontSize);
  $pdf->SetTextColor(0, 0, 0);
  $len = $pdf->GetStringWidth($data['hri']);
  Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge, $angle, $xt, $yt);
  $pdf->TextWithRotation($x + $xt, $y + $yt, $data['hri'], $angle);
  
  /**$pdf->Cell(80,100,$artista,0);**/
  $pdf->SetFont('Arial','B',18);
  $pdf->TextWithRotation(340,220,'Costo $',360);
  $pdf->TextWithRotation(340,260,'Cargo $',360);
  $pdf->TextWithRotation(340,300,'Total $',360);
  $pdf->TextWithRotation(420,220,$costo.'.00',360);
  $pdf->TextWithRotation(420,260,$cargo,360);
  $pdf->TextWithRotation(420,300,$total,360);
$pdf->TextWithRotation(380,400,$fila,360);
$pdf->TextWithRotation(430,400,$lugar,360);
$pdf->TextWithRotation(220,400,$zona,360);
$pdf->TextWithRotation(280,400,$seccion,360);

$pdf->SetFont('Arial','B',24);
 $pdf->TextWithRotation(100, 180, $artista, 360);
 $pdf->SetFont('Arial','B',18);
 $pdf->TextWithRotation(100,220,$fecha_pres,360);
 $pdf->TextWithRotation(100,260,$hora,360);
 $pdf->SetFont('Arial','B',18);
 $pdf->TextWithRotation(100,300,'Fecha de Descarga',360);
 $pdf->TextWithRotation(100,340, $fecha_imp, 360);
 $pdf->TextWithRotation(80,380,'Localidades :',360);
 $pdf->TextWithRotation(220,380,'Zona',360);
 $pdf->TextWithRotation(280,380,'Seccion',360);
 $pdf->TextWithRotation(380,380,'Fila',360);
 $pdf->TextWithRotation(430,380,'Lugar',360);
 $pdf->TextWithRotation(80,430,'Registro :',360);
 $pdf->TextWithRotation(180,430,$cliente,360);
 $pdf->SetFont('Arial','B',10);
 $pdf->TextWithRotation(180,550,'Sello de Seguridad:',360);
 $pdf->TextWithRotation(280,550,$cryboleto,360);

  $pdf->Output();
  mysql_close($conexion);  
  
?>