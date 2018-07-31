<?php
date_default_timezone_set("America/Mexico_City");
$fecha_imp=date('d M y h:m');
  include('reportes/Barcode.php');
  require('reportes/fpdf.php');
  require_once 'cn/cn.php';
$idvac=$_GET['id'];  
$queryResult = $pdo->query("SELECT
CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as Empleado,
  B.FIngreso,
  A.dias,
  A.fechaini,
  A.fechafin,
  A.status,
  A.periodo,
  B.id,
CONCAT(C.Nombre,' ',C.Apellido1,' ',C.Apellido2) as PersonalB
FROM
  Intranet.vac_periodos A
INNER JOIN sibware.personal B ON A.IDEmpleado = B.ID
INNER JOIN sibware.personal C on A.IdBackup=C.ID
WHERE
  A.ID = $idvac");
  while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $nombre=$row['Empleado'];
    $fechaing=$row['FIngreso'];
    $fechaini=$row['fechaini'];
    $fechafin=$row['fechafin'];
    $diassol=$row['dias'];
    $periodo=$row['periodo'];
    $id_personal=$row['id'];
    $personalB=$row['PersonalB'];

  }
  
  $queryResult = $pdo->query("SELECT A.dias FROM Intranet.vac_parametros A where A.periodos=$periodo");
  while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
      $diasco1=$row['dias'];
  }
  $queryResult = $pdo->query("SELECT * from Intranet.vac_especial A where A.IDPersonal=$id_personal");  
  while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
      $diasco2=$row['dias'];
  }
  if ($diasco2>=1) {
      $diasco=$diasco2;
  }else{
      $diasco=$diasco1;
  }
// termina calculo de dias especiales
$queryResult = $pdo->query("SELECT
  IFNULL(SUM(A.dias), 0) AS dias
FROM
  Intranet.vac_periodos A
WHERE
  A.Periodo = $periodo
AND A.IDEmpleado = $id_personal AND (A.status='S' or A.status='P')");
 
 while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
  $diasaut=$row['dias'];
}
//$diasrest=$diasco-$diasaut-$diassol;
$diasrest=$diasco-$diasaut;
$regresa=date( "Y-m-d", strtotime( "$fechafin +1 day" ) );
$queryResult = $pdo->query("select sibware.2_gDiaHabil('$regresa') as regresa");
 while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
      $regresa=$row['regresa'];  }


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
$pdf->SetFont('Arial','B',20);
$pdf->TextWithRotation(55,40,'SOLICITUD DE VACACIONES',360);  
$pdf->Image('img/logos/logo.png',10,10);
$pdf->SetFont('Arial','B',10);
$pdf->TextWithRotation(135,50,'FECHA : '.$fecha_imp,360);
$pdf->TextWithRotation(15,60,'NOMBRE : '.$nombre,360);
$pdf->TextWithRotation(15,70,'FECHA DE INGRESO : '.$fechaing,360);
$pdf->TextWithRotation(110,70,'DIAS CORRESPONDIENTES :'.$diasco,360);
$pdf->TextWithRotation(15,85,'Me permito solicitar a usted, me conceda disfrutar de mis Vacaciones a las que tengo derecho de acuerdo',360);
$pdf->TextWithRotation(15,90,'al articulo 76 LFT, por el periodo comprendido de:',360);
$pdf->SetFont('Arial','B',12);
$pdf->TextWithRotation(65,105,'DIAS DE VACACIONES A DISFRUTAR',360);
$pdf->SetFont('Arial','B',10);
$pdf->TextWithRotation(25,120,'DIAS SOLICITADOS : '.$diassol,360);
$pdf->TextWithRotation(25,130,'CORRESPONDIENTES DEL PERIODO DE '.$fechaini.' AL : '.$fechafin,360); 
$pdf->TextWithRotation(25,140,'DIAS PENDIENTES DE DISFRUTAR : '.$diasrest,360);
$pdf->TextWithRotation(25,150,'FECHA DE REINCORPORACION  A SUS LABORES :'.$regresa,360);
$pdf->TextWithRotation(95,170,'SOLICITANTE',360);
$pdf->TextWithRotation(85,185,$nombre,360);
$pdf->TextWithRotation(65,186,'_________________________________________',360);
$pdf->TextWithRotation(93,190,'Nombre y Firma',360);
$pdf->TextWithRotation(15,200,'Mientras duren sus vacaciones le reemplazara en sus funciones el (la):'.$personalB,360);
$pdf->TextWithRotation(45,230,'Jefe Inmediato',360);
$pdf->TextWithRotation(20,240,'_________________________________________',360);
$pdf->TextWithRotation(135,230,'Director General',360);
$pdf->TextWithRotation(110,240,'_________________________________________',360);
$pdf->TextWithRotation(53,250,'Vo.Bo.',360);
$pdf->TextWithRotation(138,250,'Autorizacion',360);
$pdf->TextWithRotation(15,260,'c.c.p. Recursos Humanos',360);
$pdf->TextWithRotation(15,265,'c.c.p. Expediente Personal',360);



  $pdf->Output();
    
  
?>