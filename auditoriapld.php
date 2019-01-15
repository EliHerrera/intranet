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
                    A.lActivo = 'S' ");
                    #var_dump($queryResultfil);
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
<tr><th>No. Socio</th><th>Socio</th><th>Municipio</th><th>Estado</th><th>Edad/Tiempo Constitucion</th><th>Grado</th><th>Inversion</th><th>Credito</th><th>AP</th><th>EF</th><th>CH</th><th>TR</th><th>Nacionalidad</th><th>Rel.</th><th>Inu.</th><th>Inv</th><th>CR</th><th>AP</th><th>PEPS</th><th>Actividad o Giro</th></tr>
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
	B.Nacionalidad,
	C.lPeps,
	E.Actividad
    
FROM
 2_cliente B 
INNER JOIN 2_pld_matriz C ON B.ID = C.IDCliente
INNER JOIN 2_entorno_actividadcnbv E ON B.IDActividadCNBV = E.ID
WHERE
B.status='S'
AND B.lProspecto='N'
AND B.FCliente<='$ffin'");
#var_dump($queryResult);
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $pcr='No';
    $pap='No';
    $pinv='No';
    $ef='No';
    $ch='No';
    $tr='No';
    $saldoap=0;
    $saldoinv=0;
    $saldocr=0;
    $relevante='No';
    $inusual='No';
    $idcte=$row['IDCte'];
    $nofolio=$row['consecutivo'];
    $socio=$row['Socio'];
    $municipio=$row['Municipio'];
    $estado=$row['Estado'];
    $edad=$row['FNacimiento'];
    $grado=$row['Grado'];
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
    
    $queryResult2=$pdo->query("SELECT
	*
FROM
	2_ad_bancomovs
WHERE
	FRegistro <= '$ffin'
AND FRegistro >= '$fini'    
AND Movimiento = 'DP'
AND IDContrato <> 0
AND IDClienteProv=$idcte");
while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
    
    if($row['FormaPago']=='EF'){
        $ef='Si';
    }if ($row['FormaPago']=='CH') {
        $ch='Si';
    }if ($row['FormaPago']=='TR') {
        $tr='Si';
    }
    
}
$queryResult3=$pdo->query("SELECT SUM(Autorizado) as SaldoCred FROM sibware.2_contratos WHERE IDCliente=$idcte AND status<>'-' AND status<>'C' AND FInicio BETWEEN '$fini' AND '$ffin'");
$row_count = $queryResult3->rowCount();
if($row_count>0){
    $pcr='Si';
    while ($row=$queryResult3->fetch(PDO::FETCH_ASSOC)) {
        $saldocr=$row['SaldoCred'];

    }
}
$queryResult4=$pdo->query("SELECT SUM(SaldoFinal) as SaldoAp FROM sibware.2_ap_contrato WHERE IDCliente=$idcte AND status<>'-' AND status<>'C' AND FInicio BETWEEN '$fini' AND '$ffin'");
$row_count = $queryResult4->rowCount();
if($row_count>0){
    $pap='Si';
    while ($row=$queryResult4->fetch(PDO::FETCH_ASSOC)) {
        $saldoap=$row['SaldoAp'];

    } 
}
$queryResult5=$pdo->query("SELECT SUM(SaldoProm) as SaldoIn FROM Intranet.paty WHERE IDCliente=$idcte AND FImage='$ffin'");
$row_count = $queryResult5->rowCount();
if($row_count>0){
    $pinv='Si';
    while ($row=$queryResult5->fetch(PDO::FETCH_ASSOC)) {
        $saldoinv=$row['SaldoIn'];

    } 
}
if ($saldoinv>0) {
    $pinv='Si';
}else {
    $pinv='No';
}
if ($saldoap>0) {
    $pap='Si';
}else {
    $pap='No';
}
if ($saldocr>0) {
    $pcr='Si';
}else {
    $pcr='No';
}
$queryResult6=$pdo->query("SELECT * from 2_pld_alertas where IDTipo=1 and `Status`='P' and FRegistro BETWEEN '$fini' and '$ffin' AND IDCliente=$idcte ");


$row_count = $queryResult6->rowCount();
if($row_count>0){
    $relevante='Si';
}else {
    $relevante='No';
}
$queryResult6=$pdo->query("SELECT * from 2_pld_alertas where IDTipo=2 and `Status`='P' and FRegistro BETWEEN '$fini' and '$ffin' AND IDCliente=$idcte ");


$row_count = $queryResult6->rowCount();
if($row_count>0){
    $inusual='Si';
}else {
    $inusual='No';
}
    echo "<tr><td>".$nofolio."</td><td>".$socio."</td><td>".$municipio."</td><td>".$estado."</td><td>".$edad."</td><td>".$grado."</td><td>".number_format($saldoinv,2)."</td><td>".number_format($saldocr,2)."</td><td>".number_format($saldoap,2)."</td><td>".$ef."</td><td>".$ch."</td><td>".$tr."</td><td>".$nacionalidad."</td><td>".$relevante."</td><td>".$inusual."</td><td>".$pinv."</td><td>".$pcr."</td><td>".$pap."</td><td>".$peps."</td><td>".$actividad."</td></tr>";
}   

?>
</table>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
