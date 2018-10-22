<?php
    require_once 'header.php';
    //////inicio de contenido
    $yy=date('Y');
    
    if(!empty($_GET['idcomi'])){
        $queryResult=$pdo->query("SELECT * FROM Intranet.comisiones WHERE id_comision=$_GET[idcomi]");
        
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $periodo=$row['mes'];
            $yy=$row['yy'];
            $idejecutivo=$row['id_ejecutivo'];
        }

        $queryResult=$pdo->query("SELECT * FROM Intranet.filtros_bi WHERE periodo=$periodo AND yy=$yy");
        
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $fini=$row['fini'];
            $ffin=$row['ffin'];
            $yy=$row['yy'];
            $periodo=$row['periodo'];
            $valor=$row['valor'];
            $texto=$row['texto'];
        }
        $queryResult=$pdo->query("SELECT * FROM Intranet.metas_colocacion WHERE periodo=$periodo AND yy=$yy");
        //var_dump($queryResult);
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $metaCR=$row['metaCR'];
            $metaAP=$row['metaAP'];
            $metaVP=$row['metaVP'];
            $metaIN=$row['metaIN'];
            $pComi=$row['pComi'];
            $pCumpli=$row['pCumpli'];
            define("pComi", $pComi);
            define("metaCR",$metaCR);
            define("metaAP",$metaAP);
            define("metaVP",$metaVP);
            define(pcumpli,$pCumpli);
        }
    }
    
?>  
<h3>Relacion de Comisiones por Colocacion <?php echo $texto; ?></h3>

<form action="extencomisiones.php" method="post">
    <div class="row">
    <div class="col-xs-2>">    
        <br><a href="relcomisiones.php" class="button">Regresar</a>
        <a href="solicitudch.php?idcomi=<?PHP echo $_GET['idcomi'] ?>" target="_blank" class="button">Solicitud</a>
        <input type="button" name="imprimir" value="Relacion"  onClick="window.print();" class="button" />
    </div>

    </div>
</form>
<table class="table">
    <tr><th>Producto</th><th>Monto Colocado</th><th>Meta</th><th>% de Cump.</th><th>Comision Cobrada</th><th>Periodo</th><th>Año</th></tr>
    <?php
    if(!empty($_GET)){
        $queryResult=$pdo->query("SELECT
        B.PApertura,
        B.NApertura,
        B.Autorizado,
        B.FInicio
    FROM
        sibware.2_contratos B 
    INNER JOIN sibware.2_cliente C ON B.IDCliente = C.ID
    INNER JOIN sibware.2_entorno_tipocliente E ON C.IDTipoCliente = E.ID
    WHERE
        B.FInicio BETWEEN '$fini'
    AND '$ffin'
    AND B. STATUS <> 'C'
    AND B. STATUS <> '-'
    AND (E.ID = 1 OR E.ID = 3)");
    
        $acumcolocado=0;
        $acumPCalcular=0;
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $colocado=$row['Autorizado'];
            $papertura=$row['PApertura'];
            $napertura=$row['NApertura'];
            $acumcolocado=$acumcolocado+$colocado;
            $acumapertura=$acumapertura+$napertura;
            $pCalcular=$papertura*100/pComi;
            $montoCal=($pCalcular/100)*$colocado;
            $acumPCalcular=$acumPCalcular+$montoCal;
            
        }
        $queryResult=$pdo->query("SELECT
        B.PApertura,
        B.NApertura,
        A.Disposicion,
        B.FInicio
    FROM
        sibware.2_contratos_disposicion A
    INNER JOIN sibware.2_contratos B ON A.IDContrato=B.ID 
    INNER JOIN sibware.2_cliente C ON B.IDCliente = C.ID
    INNER JOIN sibware.2_entorno_tipocliente E ON C.IDTipoCliente = E.ID
    WHERE
        A.FInicio BETWEEN '$fini'
    AND '$ffin'
    AND B. STATUS <> 'C'
    AND B. STATUS <> '-'
    AND (E.ID = 1 OR E.ID = 3)");  
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $dispuesto=$row['Disposicion'];
        $acumdispuesto=$acumdispuesto+$dispuesto;
    }  
        $pCol=($acumdispuesto/metaCR)*100;
        if ($pCol>=pcumpli) {
            $class='success';
        }elseif ($pCol<pcumpli) {
            $class='danger';
            $acumPCalcular=0;
        }
        $pColCR=$pCol;
        echo "<tr><td><a href='detallecomiext.php?valor=".$valor."&c=1'>Creditos</a></td><td>".number_format($acumcolocado,2)."</td><td>".number_format(metaCR,2)."</td><td class='".$class."'>%".number_format($pCol,2)."</td><td>".number_format($acumapertura,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";
        $queryResult=$pdo->query("SELECT
        B.PApertura,
        B.NApertura,
        B.plazo,
        A.FInicio,
        D.Renta
    FROM
        sibware.2_ap_disposicion A
    INNER JOIN sibware.2_ap_contrato B ON A.IDContrato = B.ID
    INNER JOIN sibware.2_cliente C ON B.IDCliente = C.ID
    INNER JOIN sibware.2_ap_disposicion_movs D ON A.ID = D.IDDisposicion
    INNER JOIN sibware.2_entorno_tipocliente E ON C.IDTipoCliente = E.ID
    WHERE
        (
            A.FInicio BETWEEN '$fini'
            AND '$ffin'
        )
    AND B. STATUS <> 'C'
    AND B. STATUS <> '-'
    AND (E.ID = 1 OR E.ID = 3)
    AND D.renglon = 1");
  
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $renta=$row['Renta'];
            $plazo=$row['plazo'];
            $colocado=$renta*$plazo;
            $papertura=$row['PApertura'];
            $napertura=$row['NApertura'];
            $acumcolocadoAP2=$acumcolocadoAP2+$colocado;
            $acumaperturaAP2=$acumaperturaAP2+$napertura;
            $pCalcular=$papertura*100/pComi;
            $montoCal=($pCalcular/100)*$colocado;
            $acumPCalcularAP2=$acumPCalcularAP2+$montoCal;
            
        }
        $queryResult=$pdo->query("SELECT
        B.PApertura,
        B.NApertura,
        B.plazo,
        A.FInicio,
        D.Renta
    FROM
        sibware.3_ap_disposicion A
    INNER JOIN sibware.3_ap_contrato B ON A.IDContrato = B.ID
    INNER JOIN sibware.3_cliente C ON B.IDCliente = C.ID
    INNER JOIN sibware.3_ap_disposicion_movs D ON A.ID = D.IDDisposicion
    INNER JOIN sibware.3_entorno_tipocliente E ON C.IDTipoCliente = E.ID
    WHERE
        (
            A.FInicio BETWEEN '$fini'
            AND '$ffin'
        )
    AND B. STATUS <> 'C'
    AND B. STATUS <> '-'
    AND (E.ID = 1 OR E.ID = 3)
    AND D.renglon = 1");
  
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $renta=$row['Renta'];
            $plazo=$row['plazo'];
            $colocado=$renta*$plazo;
            $papertura=$row['PApertura'];
            $napertura=$row['NApertura'];
            $acumcolocadoAP3=$acumcolocadoAP3+$colocado;
            $acumaperturaAP3=$acumaperturaAP3+$napertura;
            $pCalcular=$papertura*100/pComi;
            $montoCal=($pCalcular/100)*$colocado;
            $acumPCalcularAP3=$acumPCalcularAP3+$montoCal;
            
        }
        $acumcolocadoAP=0;
        $acumPCalcularAP=0;
        $acumcolocadoAP=$acumcolocadoAP2+$acumcolocadoAP3;
        $acumaperturaAP=$acumaperturaAP2+$acumaperturaAP3;
        $acumPCalcularAP=$acumPCalcularAP2+$acumPCalcularAP3;
        $pCol=($acumcolocadoAP/metaAP)*100;
        
        if ($pCol>=pcumpli) {
            $class='success';
        }elseif ($pCol<pcumpli) {
            $class='danger';
            $acumPCalcularAP=0;
        }
        $pColAP=$pCol;
        echo "<tr><td><a href='detallecomiext.php?valor=".$valor."&c=2'>Arrendamientos</a></td><td>".number_format($acumcolocadoAP,2)."</td><td>".number_format(metaAP,2)."</td><td class='".$class."'>%".number_format($pCol,2)."</td><td>".number_format($acumaperturaAP,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";
        $queryResult=$pdo->query("SELECT
        B.PApertura,
        B.NApertura,
        A.FInicio,
        A.SaldoFinal AS Dispuesto
    FROM
        sibware.3_vp_disposicion A
    INNER JOIN sibware.3_vp_contrato B ON A.IDContrato = B.ID
    INNER JOIN sibware.3_cliente C ON B.IDCliente = C.ID
    INNER JOIN sibware.3_entorno_tipocliente E ON C.IDTipoCliente = E.ID
    WHERE
        (
            A.FInicio BETWEEN '$fini'
            AND '$ffin'
        )
    AND B. STATUS <> 'C'
    AND B. STATUS <> '-'
    AND (E.ID = 1 OR E.ID = 3)");

        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $acumcolocadoVP=0;
            $acumPCalcularVP=0;
            $colocado=$row['Dispuesto'];
            $papertura=$row['PApertura'];
            $napertura=$row['NApertura'];
            $acumcolocadoVP=$acumcolocadoVP+$colocado;
            $acumaperturaVP=$acumapertura+$napertura;
            $pCalcular=$papertura*100/pComi;
            $montoCal=($pCalcular/100)*$colocado;
            $acumPCalcularVP=$acumPCalcularVP+$montoCal;
            
        }
        $pCol=($acumcolocadoVP/metaVP)*100;
        if ($pCol>=pcumpli) {
            $class='success';
        }elseif ($pCol<pcumpli) {
            $class='danger';
            $acumPCalcularVP=0;
        }
        $pColVP=$pCol;
        echo "<tr><td><a href='detallecomiext.php?valor=".$valor."&c=3'>Venta a Plazo</a></td><td>".number_format($acumcolocadoVP,2)."</td><td>".number_format(metaVP,2)."</td><td class='".$class."'>%".number_format($pCol,2)."</td><td>".number_format($acumaperturaVP,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";
    }
    ?>


</table>
<?php
    if(!empty($_GET['idcomi'])){
        if (empty($acumcolocado)) {
            $acumcolocado=0;
        }
        if (empty($acumPCalcular)) {
            $acumPCalcular=0;
        }
        if (empty($acumcolocadoAP)) {
            $acumcolocadoAP=0;
        }
        if (empty($acumPCalcularAP)) {
            $acumPCalcularAP=0;
        }
        if (empty($acumcolocadoVP)) {
            $acumcolocadoVP=0;
        }
        if (empty($acumPCalcularVP)) {
            $acumPCalcularVP=0;
        }
?>

<h3>Relacion de Comisiones Pagar</h3>
<table class="table">
<tr><th>Nombre</th><th>%P</th><th>%C</th><th>Creditos</th><th>Arrendamientos</th><th>Venta PLazo</th><th>Total</th><th>Acciones</th></tr>
<?php
    $queryResult=$pdo->Query("SELECT A.ID,CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as ejecutivo, C.alias as personal , A.porcp,A.porcc,A.comcr,A.comap,A.comvp,A.status FROM Intranet.com_extensionistas A INNER JOIN sibware.personal B ON A.IDpersonal=B.ID INNER JOIN Intranet.param_com_extensionistas C ON A.IDPersonal=C.IDPersonal WHERE A.periodo=$periodo AND A.yy=$yy AND A.IDPersonal=$idejecutivo");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $comap=$row['comap'];
        $comcr=$row['comcr'];
        $comvp=$row['comvp'];
        $total=$comap+$comvp+$comcr;
        $totalcr=$totalcr+$comcr;
        $totalap=$totalap+$comap;
        $totalvp=$totalvp+$comvp;
        $idcom=$row['ID'];
        echo "<tr><td>".$row['personal']."</td><td>".$row['porcp']."</td><td>".$row['porcc']."</td><td>".number_format($comcr,2)."</td><td>".number_format($comap,2)."</td><td>".number_format($comvp,2)."</td><td>".number_format($total,2)."</td>";
        if ($row['status']==1) {
            echo "<td><a href='extencomisiones.php?idcom=".$idcom."'><img src='img/icons/delete.png'></a><a href='aprovecomext.php?idcom=".$idcom."'><img src='img/icons/aprove.png'></a></td>";
        }elseif ($row['status']>1) {
            echo "<td><img src='img/icons/icon_ok.png'></td>";
        }
        
        echo "</tr>";
    }
    
?>

</table>
<h3>Relacion de Contratos Asignados</h3>
<table class="table">
<tr><th>Cliente</th><th>Folio</th><th>Producto</th><th>Monto</th><th>%Comision</th><th>$Comision Pagada</th><th>Asignado a : </th></tr>
<?php
    $queryResult=$pdo->query("SELECT CONCAT('CR-', LPAD(B.Folio, 6, 0)) AS Folio, CONCAT(C.Nombre,' ',C.Apellido1,
		' ',
		C.Apellido2
	) AS Cliente,
CONCAT(
		D.Nombre,
		' ',
		D.Apellido1,
		' ',
		D.Apellido2
	) AS Ejecutivo ,
    B.Autorizado,
    B.PApertura,
    B.NAPertura
    FROM Intranet.asignacion_ctos_ext A INNER JOIN sibware.2_contratos B ON A.IDContrato=B.ID INNER JOIN sibware.2_cliente C ON A.IDCliente=C.ID INNER JOIN sibware.personal D ON A.IDPersonal=D.ID WHERE periodo=$periodo AND yy=$yy AND Producto='cr'");
    //var_dump($queryResult);
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>".$row['Cliente']."</td><td>".$row['Folio']."</td><td>Creditos</td><td>".number_format($row['Autorizado'],2)."</td><td>%".number_format($row['PApertura'],2)."</td><td>$".number_format($row['NAPertura'],2)."</td><td>".$row['Ejecutivo']."</td></tr>";
    }
    $queryResult=$pdo->query("SELECT CONCAT('AP-', LPAD(B.Folio, 6, 0)) AS Folio, CONCAT(C.Nombre,' ',C.Apellido1,
		' ',
		C.Apellido2
	) AS Cliente,
CONCAT(
		D.Nombre,
		' ',
		D.Apellido1,
		' ',
		D.Apellido2
	) AS Ejecutivo ,
    B.Saldo as Autorizado,
    B.PApertura,
    B.NAPertura
    FROM Intranet.asignacion_ctos_ext A INNER JOIN sibware.2_ap_contrato B ON A.IDContrato=B.ID INNER JOIN sibware.2_cliente C ON A.IDCliente=C.ID INNER JOIN sibware.personal D ON A.IDPersonal=D.ID WHERE periodo=$periodo AND yy=$yy AND Producto='ap' AND Empresa='cmu'");
    //var_dump($queryResult);
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>".$row['Cliente']."</td><td>".$row['Folio']."</td><td>Arrendamientos</td><td>".number_format($row['Autorizado'],2)."</td><td>%".number_format($row['PApertura'],2)."</td><td>$".number_format($row['NAPertura'],2)."</td><td>".$row['Ejecutivo']."</td></tr>";
    }
    $queryResult=$pdo->query("SELECT CONCAT('AP-', LPAD(B.Folio, 6, 0)) AS Folio, CONCAT(C.Nombre,' ',C.Apellido1,
		' ',
		C.Apellido2
	) AS Cliente,
CONCAT(
		D.Nombre,
		' ',
		D.Apellido1,
		' ',
		D.Apellido2
	) AS Ejecutivo ,
    B.Saldo as Autorizado,
    B.PApertura,
    B.NAPertura
    FROM Intranet.asignacion_ctos_ext A INNER JOIN sibware.3_ap_contrato B ON A.IDContrato=B.ID INNER JOIN sibware.3_cliente C ON A.IDCliente=C.ID INNER JOIN sibware.personal D ON A.IDPersonal=D.ID WHERE periodo=$periodo AND yy=$yy AND Producto='ap' AND Empresa='cma'");
    //var_dump($queryResult);
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>".$row['Cliente']."</td><td>".$row['Folio']."</td><td>Arrendamientos</td><td>".number_format($row['Autorizado'],2)."</td><td>%".number_format($row['PApertura'],2)."</td><td>$".number_format($row['NAPertura'],2)."</td><td>".$row['Ejecutivo']."</td></tr>";
    }
    $queryResult=$pdo->query("SELECT CONCAT('VP-', LPAD(B.Folio, 6, 0)) AS Folio, CONCAT(C.Nombre,' ',C.Apellido1,
		' ',
		C.Apellido2
	) AS Cliente,
CONCAT(
		D.Nombre,
		' ',
		D.Apellido1,
		' ',
		D.Apellido2
	) AS Ejecutivo ,
    B.SaldoFinal as Autorizado,
    B.PApertura,
    B.NAPertura
    FROM Intranet.asignacion_ctos_ext A INNER JOIN sibware.3_vp_contrato B ON A.IDContrato=B.ID INNER JOIN sibware.3_cliente C ON A.IDCliente=C.ID INNER JOIN sibware.personal D ON A.IDPersonal=D.ID WHERE periodo=$periodo AND yy=$yy AND Producto='vp' AND Empresa='cma'");
    //var_dump($queryResult);
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>".$row['Cliente']."</td><td>".$row['Folio']."</td><td>Arrendamientos</td><td>".number_format($row['Autorizado'],2)."</td><td>%".number_format($row['PApertura'],2)."</td><td>$".number_format($row['NAPertura'],2)."</td><td>".$row['Ejecutivo']."</td></tr>";
    }
?>
</table>
<?php
    }
?>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>