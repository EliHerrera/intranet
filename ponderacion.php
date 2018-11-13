<?php
    require_once 'header.php';
    $yy=date('Y');
    if (!empty($_GET)) {
            $p=$_GET['p'];
            $y=$_GET['y'];
            if ($idnivel>=2) {
                $deletequery=$pdo->prepare("DELETE FROM Intranet.relacion_tasa_pond WHERE Periodo=$p AND yy=$y ");
                $deletequery->execute();
                $deletequery=$pdo->prepare("DELETE FROM Intranet.ponderacion WHERE periodo=$p AND yy=$y ");
                $deletequery->execute();
            }
            echo "<div class='alert alert-danger'>";
            echo "    <strong>Aviso!</strong> Se ha eliminado el periodo ".$p." del año ".$y;
            echo "</div>";
    }
    if (!empty($_POST['periodo'])) {
        $queryResult=$pdo->query("SELECT
        *
    FROM
        Intranet.ponderacion
    WHERE
        lProcesada = 'S'
    AND yy = $yy
    AND periodo = $_POST[periodo]");
    $row_count = $queryResult->rowCount(); 
        if ($row_count>0) {
            echo "<div class='alert alert-danger'>";
            echo "    <strong>Aviso!</strong> Este Periodo ya esta Procesado";
            echo "</div>";

        }else {
        $queryResult=$pdo->query("SELECT sibware.gTIIE($_POST[periodo],$yy) as tiim");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $tiiem=$row['tiim'];
            }
        $queryResult=$pdo->query("SELECT * from Intranet.filtros_bi where periodo=$_POST[periodo] and yy=$yy");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $ffin=$row['ffin'];
                $fini=$row['fini'];
            }
            
        $queryResult=$pdo->query("SELECT
            A.IDCliente,
            A.IDContrato,
            A.IDDisposicion,
            A.SaldoCap,
            C.TipoTasa,
            C.Tasa,
            C.PAdicional,
            C.TipoCartera,
            C.IDMoneda,
            D.TasaOtros,
            D.IDOrigenRecursos,
            D.FDescuento
        FROM
            sibware.2_dw_images_contratos A
        INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
        INNER JOIN sibware.2_contratos C ON A.IDContrato = C.ID
        INNER JOIN sibware.2_contratos_disposicion D ON A.IDDisposicion = D.ID
        WHERE
            A.Fimage = '$ffin'
        AND C.STATUS <> 'C'
        AND C.STATUS <> '-'
        AND A.SaldoCap > 0");
       
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            
            if ($row['TipoTasa']=='Variable') {
                $tasa=$tiiem;
            }elseif ($row['TipoTasa']=='Fija') {
                $tasa=$row['Tasa'];
            }
            
            $padicional=$row['PAdicional'];
            $tasatot=$tasa+$padicional;
            $capital=$row['SaldoCap'];
            $interes=$capital*($tasatot/100)*$dpond/360;
            $datei= strtotime($fini);
            $datef= strtotime($ffin);
            $dated=$row['FDescuento'];
            $dated2= strtotime($dated);
            if ($row['IDOrigenRecursos']==2 && $dated2<=$datef ){
                    
                    $tasaotros=$row['TasaOtros'];
                    $tasatotOtros=$tasaotros;
                    $interesFND=$capital*($tasatotOtros/100)*$dpond/360;
                    
            }elseif ($row['IDOrigenRecursos']<>2) {
                $interesFND=0;
                $tasatotOtros=0;
            }
            
            $insertquery=$pdo->prepare("INSERT INTO Intranet.relacion_tasa_pond (IDCliente,IDContrato,IDDisposicion,SaldoCap,Interes,InteresFND,Tasa,PAdicional,TasaTot,TasaTotOtros,TipoCartera,IDMoneda,Producto,Empresa,Periodo,yy)
            VALUES ($row[IDCliente],$row[IDContrato],$row[IDDisposicion],$capital,$interes,$interesFND,$tasa,$padicional,$tasatot,$tasatotOtros,'$row[TipoCartera]',$row[IDMoneda],'CR','CMU',$_POST[periodo],$yy)");
            $insertquery->execute();
           
            
        }
        $queryResult=$pdo->query("SELECT
        A.IDCliente,
        A.IDPrestamo,
        C.Folio,
        A.SaldoProm,
        C.Tasa,
        C.SobreTasa,
        C.TasaTotal,
        C.IDMoneda
        FROM
            sibware.2_dw_images_in A
        INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
        INNER JOIN sibware.2_prestamos C ON A.IDPrestamo = C.ID
        WHERE
            A.Fimage = '$ffin'
        AND C. STATUS <> 'C'
        AND A.SaldoProm > 0");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $capital=$row['SaldoProm'];
            $tasa=$row['Tasa'];
            $padicional=$row['SobreTasa'];
            $tasatot=$row['TasaTotal'];
            $interes=$capital*($tasatot/100)*$dpond/360;
            $insertquery=$pdo->prepare("INSERT INTO Intranet.relacion_tasa_pond (IDCliente,IDContrato,SaldoCap,Interes,Tasa,PAdicional,TasaTot,IDMoneda,Producto,Empresa,Periodo,yy)
            VALUES ($row[IDCliente],$row[IDPrestamo],$capital,$interes,$tasa,$padicional,$tasatot,$row[IDMoneda],'IN','CMU',$_POST[periodo],$yy)");
            $insertquery->execute();
            
        }
        $queryResult=$pdo->query("SELECT
        A.IDCliente,
        A.IDContrato,
        A.IDDisposicion,
        C.TipoTasa,
        C.Tasa,
        C.PAdicional,
        C.IDMoneda,
        C.ValorBien,
        C.Deposito,
        C.Plazo  
        
    FROM
        sibware.2_dw_images_ap A
    INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
    INNER JOIN sibware.2_ap_contrato C ON A.IDContrato = C.ID
    
    
    WHERE
        A.Fimage = '$ffin'
    AND C. STATUS <> 'C'
    AND C. STATUS <> '-'
    AND C. STATUS <> 'P'");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            
            if ($row['TipoTasa']=='Variable') {
                $tasa=$tiiem;
            }elseif ($row['TipoTasa']=='Fija') {
                $tasa=$row['Tasa'];
            }
            $idcto=$row['IDContrato'];
            $idcte=$row['IDCliente'];
            $iddisp=$row['IDDisposicion'];
            $padicional=$row['PAdicional'];
            $idmoneda=$row['IDMoneda'];
            $TRenta=$row['Plazo'];
            $tasatot=$tasa+$padicional;
            $querymovrentas=$pdo->query("SELECT * FROM sibware.2_ap_disposicion_movs WHERE FInicial>='$fini' AND FInicial<='$ffin' and IDDisposicion=$iddisp");
            while ($row=$querymovrentas->fetch(PDO::FETCH_ASSOC)) {
                $rentaT=$row['renglon'];
                $rentaM=$row['Renta'];
                $iva=$row['IvaRenta'];
            }
            $campos = $querymovrentas->rowCount(); 
            if($campos==0){              
                $rentaT=$TRenta+1;
                $rentaM=0;
                $iva=0;
            }
            $queryrentas=$pdo->query("SELECT SUM(Renta) as iTR FROM sibware.2_ap_disposicion_movs WHERE  IDDisposicion=$iddisp");
            
            while ($row=$queryrentas->fetch(PDO::FETCH_ASSOC)) {
                $iTR=$row['iTR'];
            }
            
            $queryrentas=$pdo->query("SELECT SUM(Renta) as iPC FROM sibware.2_ap_disposicion_movs WHERE  IDDisposicion=$iddisp and renglon>$rentaT");
            while ($row=$queryrentas->fetch(PDO::FETCH_ASSOC)) {
                $iPC=$row['iPC'];
            }
            if (empty($iPC)) {
                $iPC=0;
            }
            $rentaR=$TRenta-$rentaT;
            if ($rentaR<0) {
                $rentaR=0;
            }
            $insertquery=$pdo->prepare("INSERT INTO Intranet.relacion_tasa_pond (IDCliente,IDContrato,IDDisposicion,RentaM,IVA,iTR,iPC,TRenta,RentaR,TotalR,Tasa,PAdicional,TasaTot,IDMoneda,Producto,Empresa,Periodo,yy)
            VALUES  ($idcte,$idcto,$iddisp,$rentaM,$iva,$iTR,$iPC,$rentaT,$rentaR,$TRenta,$tasa,$padicional,$tasatot,$idmoneda,'AP','CMU',$_POST[periodo],$yy)");
            $insertquery->execute();
        }
        $queryResult=$pdo->query("SELECT
        A.IDCliente,
        A.IDContrato,
        A.IDDisposicion,
        C.TipoTasa,
        C.Tasa,
        C.PAdicional,
        C.IDMoneda,
        C.ValorBien,
        C.Deposito,
        C.Plazo 
        
    FROM
        sibware.3_dw_images_ap A
    INNER JOIN sibware.3_cliente B ON A.IDCliente = B.ID
    INNER JOIN sibware.3_ap_contrato C ON A.IDContrato = C.ID
    
    WHERE
        A.Fimage = '$ffin'
    AND C. STATUS <> 'C'
    AND C. STATUS <> '-'
    AND C. STATUS <> 'P'");
    
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            if ($row['TipoTasa']=='Variable') {
                $tasa=$tiiem;
            }elseif ($row['TipoTasa']=='Fija') {
                $tasa=$row['Tasa'];
            }
            $idcto=$row['IDContrato'];
            $idcte=$row['IDCliente'];
            $iddisp=$row['IDDisposicion'];
            $padicional=$row['PAdicional'];
            $idmoneda=$row['IDMoneda'];
            $TRenta=$row['Plazo'];
            $tasatot=$tasa+$padicional;
            $querymovrentas=$pdo->query("SELECT * FROM sibware.3_ap_disposicion_movs WHERE FInicial>='$fini' AND FInicial<='$ffin' and IDDisposicion=$iddisp");
            
            while ($row=$querymovrentas->fetch(PDO::FETCH_ASSOC)) {
                $rentaT=$row['renglon'];
                $rentaM=$row['Renta'];
                $iva=$row['IvaRenta'];
            }
            $campos = $querymovrentas->rowCount(); 
            if($campos==0){
                $rentaT=$TRenta+1;
                $rentaM=0;
                $iva=0;
            }
            $queryrentas=$pdo->query("SELECT SUM(Renta) as iTR FROM sibware.3_ap_disposicion_movs WHERE  IDDisposicion=$iddisp");
            
            while ($row=$queryrentas->fetch(PDO::FETCH_ASSOC)) {
                $iTR=$row['iTR'];
            }
            
            $queryrentas=$pdo->query("SELECT SUM(Renta) as iPC FROM sibware.3_ap_disposicion_movs WHERE  IDDisposicion=$iddisp and renglon>$rentaT");
            while ($row=$queryrentas->fetch(PDO::FETCH_ASSOC)) {
                $iPC=$row['iPC'];
            }
            if (empty($iPC)) {
                $iPC=0;
            }
            $rentaR=$TRenta-$rentaT;
            if ($rentaR<0) {
                $rentaR=0;
            }
            $insertquery=$pdo->prepare("INSERT INTO Intranet.relacion_tasa_pond (IDCliente,IDContrato,IDDisposicion,RentaM,IVA,iTR,iPC,TRenta,RentaR,TotalR,Tasa,PAdicional,TasaTot,IDMoneda,Producto,Empresa,Periodo,yy)
            VALUES  ($idcte,$idcto,$iddisp,$rentaM,$iva,$iTR,$iPC,$rentaT,$rentaR,$TRenta,$tasa,$padicional,$tasatot,$idmoneda,'AP','CMA',$_POST[periodo],$yy)");
            $insertquery->execute();
        }
        $queryResult=$pdo->query("SELECT
        A.IDCliente,
        A.IDContrato,
        A.IDDisposicion,
        A.SaldoCap,
        A.SaldoInt,
        C.TipoTasa,
        C.Tasa,
        C.PAdicional,
        C.IDMoneda
    FROM
        sibware.3_dw_images_vp A
    INNER JOIN sibware.3_cliente B ON A.IDCliente = B.ID
    INNER JOIN sibware.3_vp_contrato C ON A.IDContrato = C.ID
    WHERE
        A.Fimage = '$ffin'
    AND C. STATUS <> 'C'
    AND C. STATUS <> '-'
    AND A.SaldoCap > 0");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                if ($row['TipoTasa']=='Variable') {
                    $tasa=$tiiem;
                }elseif ($row['TipoTasa']=='Fija') {
                    $tasa=$row['Tasa'];
                }
                $padicional=$row['PAdicional'];
                $tasatot=$tasa+$padicional;
                $capital=$row['SaldoCap'];
                $interes=$capital*($tasatot/100)*$dpond/360;
                $insertquery=$pdo->prepare("INSERT INTO Intranet.relacion_tasa_pond (IDCliente,IDContrato,IDDisposicion,SaldoCap,Interes,Tasa,PAdicional,TasaTot,IDMoneda,Producto,Empresa,Periodo,yy)
                VALUES ($row[IDCliente],$row[IDContrato],$row[IDDisposicion],$capital,$interes,$tasa,$padicional,$tasatot,$row[IDMoneda],'VP','CMA',$_POST[periodo],$yy)");
                $insertquery->execute();
                
            }
            $insertquery=$pdo->prepare("INSERT INTO Intranet.ponderacion (fini,ffin,lProcesada,periodo,yy,fechaproceso) VALUES ('$fini','$ffin','S',$_POST[periodo],$yy,'$hoy')");
            $insertquery->execute();
            echo "<div class='alert alert-success'>";
            echo "    <strong>Exito!</strong> Se Proceso con Exito!";
            echo "</div>";
        }
    }
    //////inicio de contenido
?>    
<h3>Generacion de Ponderacion de tasas</h3>
<form action="ponderacion.php" method="post">
<div class="row">
    <div class="col-xs-3">
        <label for="periodo">Mes a procesar</label><select name="periodo" id="periodo" class="form-control" required="true">
            <option value="">Selecione...</option>
            <option value="1">Enero</option>
            <option value="2">Febrero</option>
            <option value="3">Marzo</option>
            <option value="4">Abril</option>
            <option value="5">Mayo</option>
            <option value="6">Junio</option>
            <option value="7">Julio</option>
            <option value="8">Agosto</option>
            <option value="9">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
        </select>
    </div>
    <div class="col-xs-3">
        <br><input type="submit" value="Procesar" class="button">
    </div>
</div>
</form>
<table class="table">
<tr><th>Mes</th><th>Año</th><th>Fecha de Generacion</th><th>Estatus</th><th>Acciones</th></tr>
<?PHP   
    $queryResult=$pdo->query("SELECT
    ID,
	periodo,
	yy,
	fechaproceso,
	CASE
WHEN lProcesada = 'S' THEN
	'Procesada'
END AS STATUS
FROM
	Intranet.ponderacion
WHERE
    lProcesada = 'S'
    ORDER BY periodo,yy");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $idpond=$row['ID'];
        echo "<tr><td>".$row['periodo']."</td><td>".$row['yy']."</td><td>".$row['fechaproceso']."</td><td><a href='relacionpond.php?idpon=".$idpond."'>".$row['STATUS']."</a></td><td>";
        if ($idnivel>=2) {
            echo "<a href='ponderacion.php?p=".$row['periodo']."&y=".$row['yy']."'><img src='img/icons/delete.png' alt=''></a>";
        }
        echo "</td></tr>";
    }
?>

</table>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
