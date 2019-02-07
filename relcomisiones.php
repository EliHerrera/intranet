<?php
    require_once 'header.php';
    //////inicio de contenido
    $periodo=date("n", mktime(0, 0, 0, date('m')-1, date('d'), date('Y')));
    $yy=date('Y');
    $mes_anterior  = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
    $mes_actual=mktime(0, 0, 0, date("m"), date("d"),   date("Y"));
    $númeroDeDias = date("t",$mes_anterior);
    $mes_anteriormes=date("m",$mes_anterior);
    $mes_anterior= date("Y-m", $mes_anterior);
    $annio_ant=date("Y", $mes_anterior);
    $mes_actual=date("Y-m",$mes_actual);
    $fecha_inist=$mes_anterior."-01";
    $fecha_finst=$mes_anterior."-".$númeroDeDias;
    
    $queryResult = $pdo->prepare("SELECT * FROM Intranet.procesacomisiones A WHERE A.periodo=$periodo AND A.lActivo='S'");
    $queryResult->execute();
    $result = $queryResult->fetch(PDO::FETCH_ASSOC);
    
if(empty($result)){  
    $queryResult=$pdo->query("SELECT * FROM sibware.indicador_tipocambio WHERE Fecha='$hoy'");
    #var_dump($queryResult);
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $tc=$row['Paridad'];
    }
    $queryResult = $pdo->query("INSERT INTO Intranet.procesacomisiones (fecha,periodo,lActivo,yy) VALUES('$hoy',$periodo,'S',$yy)");
    $queryResult = $pdo->query("SELECT 
    A.ID as IDEje,
    A.IDSucursal,
    A.IDPuesto
FROM
    sibware.personal A
       
WHERE
    A.IDDepartamento = 1 AND A.status = 'S'");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $ideje=$row['IDEje'];
        $idsucursal=$row['IDSucursal'];
        $queryResult2=$pdo->query("SELECT A.SaldoCap, B.IDMoneda FROM 2_dw_images_contratos A INNER JOIN 2_contratos B ON A.IDContrato=B.ID where A.FImage='$fecha_inist' and A.IDEjecutivo=$ideje");
        while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
            $saldoCapCR=$row['SaldoCap'];
            $moneda=$row['IDMoneda'];
            
            
            if($moneda==2){
                $saldoCapCR=$saldoCapCR*$tc;
            }
            $SaldoCapCRIni=$SaldoCapCRIni+$saldoCapCR;
        }
        $queryResult2=$pdo->query("SELECT A.SaldoCap,A.SaldoInt,A.CapitalVenc,A.InteresVenc, IDMoneda FROM 2_dw_images_contratos A INNER JOIN 2_contratos B ON A.IDContrato=B.ID where A.FImage='$fecha_finst' and A.IDEjecutivo=$ideje");
        while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
            $saldoCapCR=$row['SaldoCap'];
            $saldoIntCR=$row['SaldoInt'];
            $saldoCapVencCR=$row['CapitalVenc'];
            $saldoIntVencCR=$row['InteresVenc'];
            $moneda=$row['IDMoneda'];
            if($moneda==2){
                $saldoCapCR=$saldoCapCR*$tc;
                $saldoIntCR=$saldoIntCR*$tc;
                $saldoCapVencCR=$saldoCapVencCR*$tc;
                $saldoIntVencCR=$saldoIntVencCR*$tc;
            }
            $SaldoVigenteCR=$SaldoVigenteCR+$saldoCapCR+$saldoIntCR;
            $SaldoVencCR=$SaldoVencCR+$saldoCapVencCR+$saldoIntVencCR;
            $imor=$SaldoVencCR/$SaldoVigenteCR;
            $SaldoCapCRFin=$SaldoCapCRFin+$saldoCapCR;
        }
        $queryResult2=$pdo->query("SELECT A.SaldoRenta, A.SaldoIvaRenta B.IDMoneda FROM 2_dw_images_ap A INNER JOIN 2_ap_contrato B ON A.IDContrato=B.ID where A.FImage='$fecha_inist' and A.IDEjecutivo=$ideje");
        while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
            $saldoRentaAPU=$row['SaldoRenta'];
            $saldoivaRentaApU=$row['SaldoIvaRenta'];
            $saldoRentaAPU=$saldoRentaAPU+$saldoivaRentaApU;
            $moneda=$row['IDMoneda'];
            
            
            if($moneda==2){
                $saldoRentaAPU=$saldoRentaAPU*$tc;
            }
            $SaldoRentaAPUIni=$SaldoRentaAPUIni+$saldoRentaAPU;
        }
        $queryResult2=$pdo->query("SELECT A.SaldoRenta, A.SaldoIvaRenta,A.RentaVenc, A.IDMoneda FROM 2_dw_images_ap A INNER JOIN 2_ap_contrato B ON A.IDContrato=B.ID where A.FImage='$fecha_finst' and A.IDEjecutivo=$ideje");
        while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
            $saldoRentaAPU=$row['SaldoRenta'];
            $saldoivaRentaApU=$row['SaldoIvaRenta'];
            $saldoRentaAPU=$saldoRentaAPU+$saldoivaRentaApU;
            $saldoRentaVencAPU=$row['RentaVenc'];
            $moneda=$row['IDMoneda'];
            if($moneda==2){
                $saldoRentaAPU=$saldoRentaAPU*$tc;
                $saldoRentaVencAPU=$saldoRentaVencAPU*$tc;
                
            }
            $SaldoVigenteAPU=$SaldoVigenteAPU+$saldoRentaAPU;
            $SaldoVencAPU=$SaldoVencAPU+$saldoRentaVencAPU;
            $imorAPU=$SaldoVencAPU/$SaldoVigenteAPU;
            $SaldoRentaAPUFin=$SaldoRentaAPUFin+$saldoRentaAPU;
        }
        $queryResult2=$pdo->query("SELECT A.SaldoRenta, A.SaldoIvaRenta B.IDMoneda FROM 3_dw_images_ap A INNER JOIN 3_ap_contrato B ON A.IDContrato=B.ID where A.FImage='$fecha_inist' and A.IDEjecutivo=$ideje");
        while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
            $saldoRentaAP=$row['SaldoRenta'];
            $saldoivaRentaAp=$row['SaldoIvaRenta'];
            $saldoRentaAP=$saldoRentaAP+$saldoivaRentaAp;
            $moneda=$row['IDMoneda'];
            
            
            if($moneda==2){
                $saldoRentaAP=$saldoRentaAP*$tc;
            }
            $SaldoRentaAPIni=$SaldoRentaAPIni+$saldoRentaAP;
        }
        $queryResult2=$pdo->query("SELECT A.SaldoRenta, A.SaldoIvaRenta,A.RentaVenc, A.IDMoneda FROM 3_dw_images_ap A INNER JOIN 3_ap_contrato B ON A.IDContrato=B.ID where A.FImage='$fecha_finst' and A.IDEjecutivo=$ideje");
        while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
            $saldoRentaAP=$row['SaldoRenta'];
            $saldoivaRentaAp=$row['SaldoIvaRenta'];
            $saldoRentaAP=$saldoRentaAP+$saldoivaRentaAp;
            $saldoRentaVencAP=$row['RentaVenc'];
            $moneda=$row['IDMoneda'];
            if($moneda==2){
                $saldoRentaAP=$saldoRentaAP*$tc;
                $saldoRentaVencAP=$saldoRentaVencAP*$tc;
                
            }
            $SaldoVigenteAP=$SaldoVigenteAP+$saldoRentaAP;
            $SaldoVencAP=$SaldoVencAP+$saldoRentaVencAP;
            $imorAP=$SaldoVencAP/$SaldoVigenteAP;
            $SaldoRentaAPFin=$SaldoRentaAPFin+$saldoRentaAP;
        }
        #### calculos VP
        $queryResult2=$pdo->query("SELECT A.SaldoRenta, A.SaldoIvaRenta B.IDMoneda FROM 3_dw_images_vp A INNER JOIN 3_vp_contrato B ON A.IDContrato=B.ID where A.FImage='$fecha_inist' and A.IDEjecutivo=$ideje");
        while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
            $saldoCapVP=$row['SaldoCap'];
            $saldoIntVP=$row['SaldoInt'];
            $saldoIvaIntVP=$row[''];
            $saldoRentaAP=$saldoRentaAP+$saldoivaRentaAp;
            $moneda=$row['IDMoneda'];
            
            
            if($moneda==2){
                $saldoRentaAP=$saldoRentaAP*$tc;
            }
            $SaldoRentaAPIni=$SaldoRentaAPIni+$saldoRentaAP;
        }
        $queryResult2=$pdo->query("SELECT A.SaldoRenta, A.SaldoIvaRenta,A.RentaVenc, A.IDMoneda FROM 3_dw_images_vp A INNER JOIN 3_vp_contrato B ON A.IDContrato=B.ID where A.FImage='$fecha_finst' and A.IDEjecutivo=$ideje");
        while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
            $saldoRentaAP=$row['SaldoRenta'];
            $saldoivaRentaAp=$row['SaldoIvaRenta'];
            $saldoRentaAP=$saldoRentaAP+$saldoivaRentaAp;
            $saldoRentaVencAP=$row['RentaVenc'];
            $moneda=$row['IDMoneda'];
            if($moneda==2){
                $saldoRentaAP=$saldoRentaAP*$tc;
                $saldoRentaVencAP=$saldoRentaVencAP*$tc;
                
            }
            $SaldoVigenteAP=$SaldoVigenteAP+$saldoRentaAP;
            $SaldoVencAP=$SaldoVencAP+$saldoRentaVencAP;
            $imorAP=$SaldoVencAP/$SaldoVigenteAP;
            $SaldoRentaAPFin=$SaldoRentaAPFin+$saldoRentaAP;
        }
        #### calculos VP
        $queryResult2 = $pdo->query("INSERT INTO sibware.comisiones (IDEjecutivo,IDSucursal,Producto,lAprobado,Periodo,YY) VALUES($ideje,$idsucursal,'IN','',$periodo,'$yy')");
        $queryResult2 = $pdo->query("INSERT INTO sibware.comisiones (IDEjecutivo,IDSucursal,Producto,SaldoIni,SaldoFin,lAprobado,PCv,Periodo,YY) VALUES($ideje,$idsucursal,'AP',$SaldoRentaAPIni,$SaldoRentaAPFin,'',$imorAP,$periodo,'$yy')");
        $queryResult2 = $pdo->query("INSERT INTO sibware.comisiones (IDEjecutivo,IDSucursal,Producto,SaldoIni,SaldoFin,lAprobado,PCv,Periodo,YY) VALUES($ideje,$idsucursal,'APU',$SaldoRentaAPUIni,$SaldoRentaAPUFin,'',$imorAPU,$periodo,'$yy')");
        $queryResult2 = $pdo->query("INSERT INTO sibware.comisiones (IDEjecutivo,IDSucursal,Producto,lAprobado,Periodo,YY) VALUES($ideje,$idsucursal,'VP','',$periodo,'$yy')");
        $queryResult2 = $pdo->query("INSERT INTO sibware.comisiones (IDEjecutivo,IDSucursal,Producto,SaldoIni,SaldoFin,lAprobado,PCv,Periodo,YY) VALUES($ideje,$idsucursal,'CR',$SaldoCapCRIni,$SaldoCapCRFin,'',$imor,$periodo,'$yy')");
    }
    echo "<div class='alert alert-success'>";
    echo "    <strong>Exito!</strong>Las comisiones han sido procesadas con Exito!";
    echo "</div>";
}
    if (!empty($_POST)) {
        $fini=$_POST['fini'];
        $ffin=$_POST['ffin'];
        if ($_SESSION['Nivel']>=2 || $_SESSION['IDDepartamento']==9) {
            $queryResult = $pdo->query("SELECT
        A.id_comision,
        CONCAT(
            B.Nombre,
            ' ',
            B.Apellido1,
            ' ',
            B.Apellido2
        ) AS Ejecutivo,
        A.fecha,
        A.total_comi_inv,
        A.total_comi_cred,
        A.total_comi_vp,
        A.total_comi_apvp,
        A.total_bono,
        A.total_apagar,
        A.mes,
        A.yy,
        A.status,
        B.ID as IDeje
    FROM
        Intranet.comisiones A
    INNER JOIN sibware.personal B ON A.id_ejecutivo = B.ID
    WHERE
        A.status <= 3 and A.status>=1 AND (A.fecha BETWEEN '$fini' AND '$ffin')");
        }elseif ($_SESSION['Nivel']==1) {
        $queryResult = $pdo->query("SELECT
        A.id_comision,
        CONCAT(
            B.Nombre,
            ' ',
            B.Apellido1,
            ' ',
            B.Apellido2
        ) AS Ejecutivo,
        A.fecha,
        A.total_comi_inv,
        A.total_comi_cred,
        A.total_comi_vp,
        A.total_comi_apvp,
        A.total_bono,
        A.total_apagar,
        A.mes,
        A.yy,
        A.status,
        B.ID as IDeje
    FROM
        Intranet.comisiones A
    INNER JOIN sibware.personal B ON A.id_ejecutivo = B.ID
    WHERE
        A.id_ejecutivo=$idpersonal and A.status=2 AND (A.fecha BETWEEN '$fini' AND '$ffin')");
        
        
        
        }  
    }elseif (!empty($_GET['idcomi'])&&!empty($_GET['baja'])&&$_GET['baja']=='B') {
        $queryResult2 = $pdo->query("SELECT A.id_comision,A.id_ejecutivo,A.mes,A.yy,C.email FROM Intranet.comisiones A INNER JOIN sibware.personal B ON A.id_ejecutivo=B.ID INNER JOIN sibware.usuarios C ON B.IDUsuario=C.ID WHERE A.id_comision=$_GET[idcomi]");
        while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
            $idcomi=$row['id_comision'];
            $y=$row['yy'];
            $ideje=$row['id_ejecutivo'];
            $mes=$row['mes'];
            $to=$row['email'];
        }
        $queryResult3 = $pdo->prepare("UPDATE Intranet.comisiones SET status=0 WHERE id_comision=$idcomi ");
        $queryResult3->execute();  
        $queryResult4 = $pdo->prepare("UPDATE sibware.comisiones SET lAprobado='' WHERE IDEjecutivo=$ideje AND YY=$y AND Periodo=$mes ");
        $queryResult4->execute();  
        echo "<div class='alert alert-danger'>";
        echo "    <strong>Aviso! </strong> Comision Eliminada!";
        echo "</div>";
    }elseif (!empty($_GET['idcomi'])&&!empty($_GET['baja'])&&$_GET['baja']=='N') {
        $queryResult3 = $pdo->prepare("UPDATE Intranet.comisiones SET status=2 WHERE id_comision=$_GET[idcomi] ");
        $queryResult3->execute(); 
        $name="Intranet Credicor Mexicano";
        $from="intranet@credicor.com.mx";
        $subject="COMISION APROBADA";
        $message=file_get_contents('https://intranet.credicormexicano.com.mx/comisionaprobada.html');
        //$to="efren.almanza@credicor.com.mx";
        include("correo.php");
        echo "<div class='alert alert-success'>";
        echo "    <strong>Exito! </strong> Comision Aprobada!";
        echo "</div>";
    }
?> 
<h3>Relacion de comisiones</h3>
<form method='POST' action='relcomisiones.php'>
<div class="row">
    <div class="col-xs-4">
        <label for='fini'>Desde</label><input type='date' name='fini' id='fini' required='true' class="form-control" min="2018-05-01">
    </div>
    <div class="col-xs-4">
        <label for='ffin'>hasta</label><input type='date' name='ffin' id='ffin' required='true' class="form-control">
    </div>
    <div class="col-xs-2">
        <br><input type='submit' value='Buscar' class='button'>
    </div>
    <?PHP if ($_SESSION['Nivel']>=2) {
        
     ?>
    <div class="col-xs-2">
        <br><a href="comisiones.php" class="button">Aprobar</a>
    </div>
<?PHP } ?>
</div>
</form> 
<table class='table'>
<tr><th>Ejecutivo</th><th>Fecha</th><th>Periodo</th><th>Año</th><th>Inversiones</th><th>Creditos</th><th>Venta a Plazo</th><th>Arrendamiento</th><th>Bonos</th><th>Total</th><th>Acciones</th></tr>
<?PHP
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {

    $cominv=number_format($row['total_comi_inv'],2);
    $comcred=number_format($row['total_comi_cred'],2);
    $comvp=number_format($row['total_comi_vp'],2);
    $comap=number_format($row['total_comi_apvp'],2);
    $bonos=number_format($row['total_bono'],2);
    $apagar=number_format($row['total_apagar'],2);
    $idejec=$row['IDeje'];
    echo "<tr><td>$row[Ejecutivo]</td><td>$row[fecha]</td><td>$row[mes]</td><td>$row[yy]</td><td>$cominv</td><td>$comcred</td><td>$comvp</td><td>$comap</td><td>$bonos</td><td>$apagar</td><td>";
    if ($row['status']>=2 ) {
        if ($idejec==42 || $idejec==18 || $idejec==39 || $idejec==52 || $idejec==28) {
            echo "<a href='detextencomisiones.php?idcomi=".$row[id_comision]."'><img src='img/icons/review.png'></a>";
        }else {

        
        ?>
        <a href="comisiones.php?idcomi=<?php echo $row[id_comision]; ?>"><img src="img/icons/review.png"></a>
        <?php
        }
    }elseif ($row['status']==1 ) {
        ?>
        <?php
            if ($_SESSION['IDDepartamento']==9) {
             
        ?>
         <a href="relcomisiones.php?idcomi=<?php echo $row[id_comision]; ?>&&baja=N"><img src="img/icons/aprove.png"></a>
         <?php
            }
         ?>
        <a href="relcomisiones.php?idcomi=<?php echo $row[id_comision]; ?>&&baja=B"><img src="img/icons/delete.png"></a>
        <?php
        
    }

    echo "</td></tr>";

}
?>

<?php
    /////fin de contenido
    require_once 'footer.php';
?>
