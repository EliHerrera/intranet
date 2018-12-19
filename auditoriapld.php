<?php
    require_once 'header.php';
    $yy=date('Y');
    
    //////inicio de contenido
    $queryResult=$pdo->query("SELECT * FROM sibware.indicador_tipocambio WHERE Fecha='$hoy'");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $tc=$row['Paridad'];
    }
    if (!empty($_POST['col'])) {
        $queryResult=$pdo->query("SELECT * from Intranet.filtros_bi where valor=$_POST[col]");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $ffin=$row['ffin'];
                $fini=$row['fini'];
                $texto=$row['texto'];
                
                
            }
        }        
?>    
<h3>Relacion de Clientes al periodo <?php echo $texto; ?></h3>
<form action="" method="post">
    <div class="row">
        <div class="col-xs-5">
        <label for="col">Periodo</label>
            <select name="col" id="col" class="form-control" onchange="this.form.submit();return false;">
                <option value="">Seleccione Periodo...</option>
                <?PHP
                    $queryResultfil=$pdo->query("SELECT
                    *
                FROM
                    Intranet.filtros_bi A
                
                WHERE
                    A.lActivo = 'S' AND
                    A.periodo>0 AND
                    A.yy=$yy");
                    var_dump($queryResultfil);
                    while ($row=$queryResultfil->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='".$row['valor']."'>".$row['texto']."</option>";
                    }
                ?> 
            </select>
</form>            
        </div>
        <div class="row">   
        <form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
        <div class="col-xs-1">
        <br><a href="#"><img src="img/icons/export_to_excel.png" class="botonExcel" alt="expor to excel" /></a>
        <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
        </div>
        </form>
</div>
    </div>

<table class="table" id="Exportar_a_Excel">
<tr><th>No. Socio</th><th>Socio</th><th>Municipo</th><th>Estado</th><th>Edad/Tiempo Costitucion</th><th>Grado</th><th>Inversion</th><th>Credito</th><th>AP</th><th>EF</th><th>CH</th><th>TR</th><th>Nacionalidad</th><th>Rel.</th><th>Inu.</th><th>Inv</th><th>CR</th><th>AP</th><th>PEPS</th><th>Actividad o Giro</th></tr>
<?php
    $queryResult=$pdo->query("SELECT
    B.ID as IDCte,
	lPAD(B.consecutivo,4,0) as consecutivo,
	CONCAT(
		B.Nombre,
		' ',
		B.Apellido1,
		' ',
		B.Apellido2
	) AS Socio,
	B.Municipio,
	B.Estado,
	B.FNacimiento,
	C.Grado,
	SUM(A.Autorizado) AS Saldo,
	B.Nacionalidad,
	C.lPeps,
	E.Actividad,
    A.IDMoneda
FROM
	2_contratos A
INNER JOIN 2_cliente B ON A.IDCliente = B.ID
INNER JOIN 2_pld_matriz C ON A.IDCliente = C.IDCliente
INNER JOIN 2_entorno_actividadcnbv E ON B.IDActividadCNBV = E.ID
WHERE
	A.FInicio <= '$ffin'
AND A.`status` <> '-'
AND A.`status` <> 'C'
AND A.`status` <> 'P'
GROUP BY
    B.ID,A.IDMoneda");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $idcte=$row['IDCte'];
    $nofolio=$row['consecutivo'];
    $socio=$row['Socio'];
    $municipio=$row['Municipio'];
    $estado=$row['Estado'];
    $edad=$row['FNacimiento'];
    $grado=$row['Grado'];
    $saldocr=$row['Saldo'];
    $saldoap=0;
    $saldoinv=0;
    if($row['IDMoneda']==2){
        $saldocr=$saldocr*$tc;
    }
    $nacionalidad=$row['Nacionalidad'];
    $peps=$row['lPeps'];
    if($peps=='S'){
        $peps='Si';
    }elseif ($peps=='N') {
        $peps='No';
    }else{
        $peps='NA';
    }
    $actividad=$row['Actividad'];
    $pcr='Si';
    $pap='No';
    $pinv='No';
    $queryResult2=$pdo->query("SELECT
	*
FROM
	2_ad_bancomovs
WHERE
	FRegistro <= '$ffin'
AND Movimiento = 'DP'
AND Modulo = 'CR'
AND IDContrato <> 0
AND IDClienteProv=$idcte");
while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
    $ef='No';
    $ch='No';
    $tr='No';
    $relevante='No';
    $inusual='No';
    if($row['FormaPago']=='EF'){
        $ef='Si';
    }if ($row['FormaPago']=='CH') {
        $ch='Si';
    }if ($row['FormaPago']=='TR') {
        $tr='Si';
    }if ($row['lRelevantes']=='S') {
        $relevante='Si';
    }if ($row['lInusuales']=='S') {
        $inusual='Si';
    }
    
}

    echo "<tr><td>".$nofolio."</td><td>".$socio."</td><td>".$municipio."</td><td>".$estado."</td><td>".$edad."</td><td>".$grado."</td><td>".number_format($saldoinv,2)."</td><td>".number_format($saldocr,2)."</td><td>".number_format($saldoap,2)."</td><td>".$ef."</td><td>".$ch."</td><td>".$tr."</td><td>".$nacionalidad."</td><td>".$inusual."</td><td>".$relevante."</td><td>".$pinv."</td><td>".$pcr."</td><td>".$pap."</td><td>".$peps."</td><td>".$actividad."</td></tr>";
}   
$queryResult=$pdo->query("SELECT
    B.ID as IDCte,
	lPAD(B.consecutivo,4,0) as consecutivo,
	CONCAT(
		B.Nombre,
		' ',
		B.Apellido1,
		' ',
		B.Apellido2
	) AS Socio,
	B.Municipio,
	B.Estado,
	B.FNacimiento,
	C.Grado,
	SUM(A.Saldo) AS Saldo,
	B.Nacionalidad,
	C.lPeps,
	E.Actividad,
    A.IDMoneda
FROM
	2_ap_contrato A
INNER JOIN 2_cliente B ON A.IDCliente = B.ID
INNER JOIN 2_pld_matriz C ON A.IDCliente = C.IDCliente
INNER JOIN 2_entorno_actividadcnbv E ON B.IDActividadCNBV = E.ID
WHERE
	A.FInicio <= '$ffin'
AND A.`status` <> '-'
AND A.`status` <> 'C'
AND A.`status` <> 'P'
GROUP BY
    B.ID,A.IDMoneda");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $idcte=$row['IDCte'];
    $nofolio=$row['consecutivo'];
    $socio=$row['Socio'];
    $municipio=$row['Municipio'];
    $estado=$row['Estado'];
    $edad=$row['FNacimiento'];
    $grado=$row['Grado'];
    $saldoap=$row['Saldo'];
    $saldocr=0;
    $saldoinv=0;
    
    if($row['IDMoneda']==2){
        $saldoap=$saldoap*$tc;
    }
    $nacionalidad=$row['Nacionalidad'];
    $peps=$row['lPeps'];
    if($peps=='S'){
        $peps='Si';
    }elseif ($peps=='N') {
        $peps='No';
    }else{
        $peps='NA';
    }
    $actividad=$row['Actividad'];
    $pcr='No';
    $pap='Si';
    $pinv='No';
    $queryResult2=$pdo->query("SELECT
	*
FROM
	2_ad_bancomovs
WHERE
	FRegistro <= '$ffin'
AND Movimiento = 'DP'
AND Modulo = 'AP'
AND IDContrato <> 0
AND IDClienteProv=$idcte");
while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
    $ef='No';
    $ch='No';
    $tr='No';
    $relevante='No';
    $inusual='No';
    if($row['FormaPago']=='EF'){
        $ef='Si';
    }if ($row['FormaPago']=='CH') {
        $ch='Si';
    }if ($row['FormaPago']=='TR') {
        $tr='Si';
    }if ($row['lRelevantes']=='S') {
        $relevante='Si';
    }if ($row['lInusuales']=='S') {
        $inusual='Si';
    }
    
}

    echo "<tr><td>".$nofolio."</td><td>".$socio."</td><td>".$municipio."</td><td>".$estado."</td><td>".$edad."</td><td>".$grado."</td><td>".number_format($saldoinv,2)."</td><td>".number_format($saldocr,2)."</td><td>".number_format($saldoap,2)."</td><td>".$ef."</td><td>".$ch."</td><td>".$tr."</td><td>".$nacionalidad."</td><td>".$inusual."</td><td>".$relevante."</td><td>".$pinv."</td><td>".$pcr."</td><td>".$pap."</td><td>".$peps."</td><td>".$actividad."</td></tr>";
} 
$queryResult=$pdo->query("SELECT
A.IDCliente as IDCte,
B.consecutivo,
CONCAT(
    B.Nombre,
    ' ',
    B.Apellido1,
    ' ',
    B.Apellido2
) AS Socio,
B.Municipio,
B.Estado,
B.FNacimiento,
C.Grado,
SUM(A.SaldoProm) + SUM(A.SaldoInt) - SUM(A.SaldoRet) AS Saldo,
B.Nacionalidad,
C.lPeps,
E.Actividad,
D.IDMoneda
FROM
2_dw_images_in A
INNER JOIN 2_cliente B ON A.IDCliente = B.ID
INNER JOIN 2_pld_matriz C ON A.IDCliente = C.IDCliente
INNER JOIN 2_prestamos D ON A.IDCliente = D.IDCliente
INNER JOIN 2_entorno_actividadcnbv E ON B.IDActividadCNBV = E.ID
WHERE
A.FImage = '$ffin'
GROUP BY
D.IDCliente,
D.IDMoneda");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $idcte=$row['IDCte'];
    $nofolio=$row['consecutivo'];
    $socio=$row['Socio'];
    $municipio=$row['Municipio'];
    $estado=$row['Estado'];
    $edad=$row['FNacimiento'];
    $grado=$row['Grado'];
    $saldoinv=$row['Saldo'];
    $saldoap=0;
    $saldocr=0;
    if($row['IDMoneda']==2){
        $saldoinv=$saldoinv*$tc;
    }
    $nacionalidad=$row['Nacionalidad'];
    $peps=$row['lPeps'];
    if($peps=='S'){
        $peps='Si';
    }elseif ($peps=='N') {
        $peps='No';
    }else{
        $peps='NA';
    }
    $actividad=$row['Actividad'];
    $pcr='No';
    $pap='No';
    $pinv='Si';
    $queryResult2=$pdo->query("SELECT
	*
FROM
	2_ad_bancomovs
WHERE
	FRegistro <= '$ffin'
AND Movimiento = 'DP'
AND Modulo = 'IN'
AND IDContrato <> 0
AND IDClienteProv=$idcte");
while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
    $ef='No';
    $ch='No';
    $tr='No';
    $relevante='No';
    $inusual='No';
    if($row['FormaPago']=='EF'){
        $ef='Si';
    }if ($row['FormaPago']=='CH') {
        $ch='Si';
    }if ($row['FormaPago']=='TR') {
        $tr='Si';
    }if ($row['lRelevantes']=='S') {
        $relevante='Si';
    }if ($row['lInusuales']=='S') {
        $inusual='Si';
    }
    
}

    echo "<tr><td>".$nofolio."</td><td>".$socio."</td><td>".$municipio."</td><td>".$estado."</td><td>".$edad."</td><td>".$grado."</td><td>".number_format($saldoinv,2)."</td><td>".number_format($saldocr,2)."</td><td>".number_format($saldoap,2)."</td><td>".$ef."</td><td>".$ch."</td><td>".$tr."</td><td>".$nacionalidad."</td><td>".$inusual."</td><td>".$relevante."</td><td>".$pinv."</td><td>".$pcr."</td><td>".$pap."</td><td>".$peps."</td><td>".$actividad."</td></tr>";
}    
?>
</table>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
