<?php
    require_once 'header.php';
    //////inicio de contenido
    $caso=$_GET['c'];
    $queryResult=$pdo->query("SELECT * FROM Intranet.filtros_bi WHERE valor=$_GET[valor]");
                        
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                        $fini=$row['fini'];
                        $ffin=$row['ffin'];
                        $texto=$row['texto'];
                        $yy=$row['yy'];
                        $valor=$row['valor'];
                        $periodo=$row['periodo'];
                    }
?> 
<h3>Relacion de Detalle de Autorzados <?php echo $texto ?> </h3>
<form action="extencomisiones.php" method="post">
<input type="text" name="col" id="col" value="<?php echo $valor ?>" hidden="true">
<input type="submit" value="Regresar" class="button"></form>
<table class="table">
<tr><th>Cliente</th><th>Folio</th><th>Autorizado</th><th>Fecha Inicio</th><th>Asignado</th><th>Acciones</th></tr>
<?php
switch ($caso) {
    case 1:
    $queryResult=$pdo->query("SELECT
	CONCAT('CR-', LPAD(B.Folio, 6, 0)) AS Folio,
	CONCAT(
		C.Nombre,
		' ',
		C.Apellido1,
		' ',
		C.Apellido2
	) AS Cliente,
CONCAT(
		D.Nombre,
		' ',
		D.Apellido1,
		' ',
		D.Apellido2
	) AS Ejecutivo,
	B.PApertura,
	B.NApertura,
	B.Autorizado,
	B.FInicio,
    B.ID
FROM
	sibware.2_contratos B
INNER JOIN sibware.2_cliente C ON B.IDCliente = C.ID
INNER JOIN sibware.personal D ON C.IDEjecutivo=D.ID
INNER JOIN sibware.2_entorno_tipocliente E ON C.IDTipoCliente = E.ID
WHERE
	B.FInicio BETWEEN '$fini'
AND '$ffin'
AND B. STATUS <> 'C'
AND B. STATUS <> '-'
AND (E.ID = 1 OR E.ID = 3)");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $idcto=$row['ID'];
    $folio=$row['Folio'];
    $cliente=$row['Cliente'];
    $finicio=$row['FInicio'];
    $autorizado=$row['Autorizado'];
    $queryResult2=$pdo->query("SELECT CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) AS Asignado, A.ID as IDasignacion FROM Intranet.asignacion_ctos_ext A INNER JOIN sibware.personal B ON A.IDPersonal=B.ID WHERE A.IDContrato=$idcto AND A.periodo=$periodo AND A.yy=$yy AND A.Producto='cr' AND A.Empresa='cmu' ");
    $asignado=NULL;
    while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
        $asignado=$row['Asignado'];
        $idasignacion=$row['IDasignacion'];
    }
    echo "<tr><td>".$cliente."</td><td>".$folio."</td><td>".number_format($autorizado,2)."</td><td>".$finicio."</td><td>".$asignado."</td>";
    if (empty($asignado)) {
        echo "<td><a href='asignacionext.php?idcto=".$idcto."&periodo=".$periodo."&yy=".$yy."&valor=".$valor."&pro=cr&emp=cmu'>Asignar</a></td>";
    }else{
        echo "<td><a href='asignacionext.php?idasignacion=".$idasignacion."'>Eliminar</a></td>";
    }
    
    echo "</tr>";
}
        break;
    case 2:
    $queryResult=$pdo->query("SELECT
	CONCAT('AP-', LPAD(B.Folio, 6, 0)) AS Folio,
	CONCAT(
		C.Nombre,
		' ',
		C.Apellido1,
		' ',
		C.Apellido2
	) AS Cliente,
	B.PApertura,
	B.NApertura,
	B.plazo,
	A.FInicio,
	D.Renta,
	CONCAT(
		F.Nombre,
		' ',
		F.Apellido1,
		' ',
		F.Apellido2
	) AS Ejecutivo,
    B.ID,
    B.FInicio

FROM
	sibware.2_ap_disposicion A
INNER JOIN sibware.2_ap_contrato B ON A.IDContrato = B.ID
INNER JOIN sibware.2_cliente C ON B.IDCliente = C.ID
INNER JOIN sibware.2_ap_disposicion_movs D ON A.ID = D.IDDisposicion
INNER JOIN sibware.2_entorno_tipocliente E ON C.IDTipoCliente = E.ID
INNER JOIN sibware.personal F ON C.IDEjecutivo = F.ID
WHERE
	(
		A.FInicio BETWEEN '$fini'
		AND '$ffin'
	)
AND B. STATUS <> 'C'
AND B. STATUS <> '-'
AND (E.ID = 1 OR E.ID = 3)
AND D.renglon = 1;");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $renta=$row['Renta'];
    $plazo=$row['plazo'];
    $idcto=$row['ID'];
    $folio=$row['Folio'];
    $cliente=$row['Cliente'];
    $finicio=$row['FInicio'];
    $autorizado=$renta*$plazo;
    $queryResult2=$pdo->query("SELECT CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) AS Asignado, A.ID as IDasignacion FROM Intranet.asignacion_ctos_ext A INNER JOIN sibware.personal B ON A.IDPersonal=B.ID WHERE A.IDContrato=$idcto AND A.periodo=$periodo AND A.yy=$yy AND A.Producto='apu' AND A.Empresa='cmu' ");
    $asignado=NULL;
    while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
        $asignado=$row['Asignado'];
        $idasignacion=$row['IDasignacion'];
    }
    echo "<tr><td>".$cliente."</td><td>".$folio."</td><td>".number_format($autorizado,2)."</td><td>".$finicio."</td><td>".$asignado."</td>";
    if (empty($asignado)) {
        echo "<td><a href='asignacionext.php?idcto=".$idcto."&periodo=".$periodo."&yy=".$yy."&valor=".$valor."&pro=apu&emp=cmu'>Asignar</a></td>";
    }else{
        echo "<td><a href='asignacionext.php?idasignacion=".$idasignacion."'>Eliminar</a></td>";
    }
}
$queryResult=$pdo->query("SELECT
	CONCAT('AP-', LPAD(B.Folio, 6, 0)) AS Folio,
	CONCAT(
		C.Nombre,
		' ',
		C.Apellido1,
		' ',
		C.Apellido2
	) AS Cliente,
	B.PApertura,
	B.NApertura,
	B.plazo,
	A.FInicio,
	D.Renta,
	CONCAT(
		F.Nombre,
		' ',
		F.Apellido1,
		' ',
		F.Apellido2
	) AS Ejecutivo,
    B.ID,
    B.FInicio

FROM
	sibware.3_ap_disposicion A
INNER JOIN sibware.3_ap_contrato B ON A.IDContrato = B.ID
INNER JOIN sibware.3_cliente C ON B.IDCliente = C.ID
INNER JOIN sibware.3_ap_disposicion_movs D ON A.ID = D.IDDisposicion
INNER JOIN sibware.3_entorno_tipocliente E ON C.IDTipoCliente = E.ID
INNER JOIN sibware.personal F ON C.IDEjecutivo = F.ID
WHERE
	(
		A.FInicio BETWEEN '$fini'
		AND '$ffin'
	)
AND B. STATUS <> 'C'
AND B. STATUS <> '-'
AND (E.ID = 1 OR E.ID = 3)
AND D.renglon = 1;");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $idcto=$row['ID'];
    $folio=$row['Folio'];
    $cliente=$row['Cliente'];
    $finicio=$row['FInicio'];
    $renta=$row['Renta'];
    $plazo=$row['plazo'];
    $autorizado=$renta*$plazo;
    $queryResult2=$pdo->query("SELECT CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) AS Asignado, A.ID as IDasignacion FROM Intranet.asignacion_ctos_ext A INNER JOIN sibware.personal B ON A.IDPersonal=B.ID WHERE A.IDContrato=$idcto AND A.periodo=$periodo AND A.yy=$yy AND A.Producto='ap' AND A.Empresa='cma' ");
    $asignado=NULL;
    while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
        $asignado=$row['Asignado'];
        $idasignacion=$row['IDasignacion'];
    }
    echo "<tr><td>".$cliente."</td><td>".$folio."</td><td>".number_format($autorizado,2)."</td><td>".$finicio."</td><td>".$asignado."</td>";
    if (empty($asignado)) {
        echo "<td><a href='asignacionext.php?idcto=".$idcto."&periodo=".$periodo."&yy=".$yy."&valor=".$valor."&pro=ap&emp=cma'>Asignar</a></td>";
    }else{
        echo "<td><a href='asignacionext.php?idasignacion=".$idasignacion."'>Eliminar</a></td>";
    }
}
    break;
    case 3:
    $queryResult=$pdo->query("SELECT
	CONCAT('VP-', LPAD(B.Folio, 6, 0)) AS Folio,
	CONCAT(
		C.Nombre,
		' ',
		C.Apellido1,
		' ',
		C.Apellido2
	) AS Cliente,
	B.PApertura,
	B.NApertura,
	A.FInicio,
	B.SaldoFinal AS Disposicion,
	CONCAT(
		F.Nombre,
		' ',
		F.Apellido1,
		' ',
		F.Apellido2
	) AS Ejecutivo,
    B.ID as IDCto,
    B.FInicio
FROM
	sibware.3_vp_disposicion A
INNER JOIN sibware.3_vp_contrato B ON A.IDContrato = B.ID
INNER JOIN sibware.3_cliente C ON B.IDCliente = C.ID
INNER JOIN sibware.3_entorno_tipocliente E ON C.IDTipoCliente = E.ID
INNER JOIN sibware.personal F ON C.IDEjecutivo = F.ID
WHERE
	(
		A.FInicio BETWEEN '$fini'
		AND '$ffin'
	)
AND B. STATUS <> 'C'
AND B. STATUS <> '-'
AND (E.ID = 1 OR E.ID = 3)");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $idcto=$row['IDCto'];
    $folio=$row['Folio'];
    $cliente=$row['Cliente'];
    $finicio=$row['FInicio'];
    $queryResult2=$pdo->query("SELECT CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) AS Asignado, A.ID as IDasignacion FROM Intranet.asignacion_ctos_ext A INNER JOIN sibware.personal B ON A.IDPersonal=B.ID WHERE A.IDContrato=$idcto AND A.periodo=$periodo AND A.yy=$yy AND A.Producto='vp' AND A.Empresa='cma'");
    $asignado=NULL;
    $autorizado=$row['Disposicion'];
    while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
        $asignado=$row['Asignado'];
        $idasignacion=$row['IDasignacion'];
    }
    echo "<tr><td>".$cliente."</td><td>".$folio."</td><td>".number_format($autorizado,2)."</td><td>".$finicio."</td><td>".$asignado."</td>";
    if (empty($asignado)) {
        echo "<td><a href='asignacionext.php?idcto=".$idcto."&periodo=".$periodo."&yy=".$yy."&valor=".$valor."&pro=vp&emp=cma'>Asignar</a></td>";
    }else{
        echo "<td><a href='asignacionext.php?idasignacion=".$idasignacion."'>Eliminar</a></td>";
    }
}
    break;
    default:
        # code...
        break;
}
    


?>    
</table>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>