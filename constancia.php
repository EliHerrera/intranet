
<?php
date_default_timezone_set("America/Mexico_City");

$fecha_imp=date('d M y h:m');
  include('reportes/Barcode.php');
  require('reportes/fpdf.php');
  require_once 'cn/cn.php';
$idexm=$_GET['idcuest'];  
$queryResult = $pdo->query("SELECT CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as Emp,A.fecha_ap, A.periodo FROM Intranet.RelQst A INNER JOIN sibware.personal B on A.IDPersonal=B.ID where A.ID=$idexm");
  
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $nombre=$row['Emp'];
    $fecha_ap=$row['fecha_ap'];
    $periodo=$row['periodo'];
  }
 
  
  $queryResult = $pdo->query("SELECT * FROM Intranet.cursos where periodo=$periodo and ID=1");
  while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
      $curso=$row['curso'];
      $exp=$row['expositor'];
      $firmaexp=$row['firma_ex'];
  }
  $queryResult = $pdo->query("SELECT CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as director,A.firma_director FROM Intranet.parametros A INNER JOIN sibware.personal B ON A.id_director=B.ID ");
  while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
      $director=$row['director'];
      $firmaexp=$row['firma_director'];
  }
  


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
    
  $pdf = new eFPDF('L', 'mm','letter' );
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
   
$pdf->AddFont('Montserrat-Bold','B','Montserrat-Bold.php');  
$pdf->SetFont('Montserrat-Bold','B',20);
$pdf->TextWithRotation(55,40,'CREDICOR MEXICANO UNION DE CREDITO SA DE CV',360);
$pdf->SetFont('Montserrat-Bold','B',15);
$pdf->TextWithRotation(125,50,'Otorga la Presente',360);  
$pdf->SetFont('Montserrat-Bold','B',40);
$pdf->TextWithRotation(85,70,'C O N S T A N C I A',360);  
$pdf->Image('img/logos/logo.png',100,15);
$pdf->SetFont('Montserrat-Bold','B',20);
$pdf->TextWithRotation(145,82,'a',360); 
$pdf->TextWithRotation(80,94,$nombre,360);
$pdf->SetFont('Montserrat-Bold','B',15);
$pdf->TextWithRotation(110,110,'Por su Participacion en el curso',360);
$pdf->SetFont('Montserrat-Bold','B',20);
$pdf->TextWithRotation(50,130,'ACTUALIZACION EN PREVENCION DE LAVADO DE DINERO',360);
$pdf->TextWithRotation(90,140,'Y FINANCIAMIENTO AL TERRORISMO',360);
$pdf->SetFont('Montserrat-Bold','B',15);
$pdf->TextWithRotation(107,150,$fecha_ap,360);
$pdf->SetFont('Montserrat-Bold','B',15);
$pdf->Image('img/logos/firma_jorge.png',50,165);
$pdf->TextWithRotation(15,190,'C.P. '.$director,360);
$pdf->TextWithRotation(45,195,'Director General',360);
$pdf->Image('img/logos/firma_paty.jpg',170,160);
$pdf->TextWithRotation(155,190,'C.P. '.$exp,360);
$pdf->TextWithRotation(165,195,'Expositor/Oficial de cumplimiento',360);





  $pdf->Output();
    
  
?>