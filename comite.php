<?php
    require_once 'header.php';
    //////inicio de contenido
    if(!empty($_POST)){
        $fini=$_POST['fini'];
        $ffin=$_POST['ffin'];

    }
?>    
<h3>Relacion de Pre-Contratos</h3>
<form action="comite.php" method="post">
<div class="row">
    <div class="col-xs-3">
        <label for="fini">Desde</label><input type="date" name="fini" id="fini" class="form-control" required="true">
    </div>
    <div class="col-xs-3">
        <label for="ffin">Hasta</label><input type="date" name="ffin" id="ffin" class="form-control" required="true">
    </div>
    <div class="col-xs-2">
        <br><input type="submit" value="Buscar" class="button">
    </div>
</div>
</form>
<table class="table">
<tr><th>Cliente</th><th>Folio</th><th>Empresa</th><th>Ejecutivo</th><th>Opinion</th><th>Fecha</th><th>Acciones</th></tr>
<?php
    $queryResult=$pdo->query("SELECT
    A.ID,
	CONCAT(
		B.Nombre,
		' ',
		B.Apellido1,
		' ',
		B.Apellido2
	) AS Cliente,
	CONCAT(
		A.TipoContrato,
		'-',
		LPAD(A.FolioContrato, 6, 0)
	) AS Folio,
	A.FInicio,
	'CMU' as Emp,
	CONCAT(
		C.Nombre,
		' ',
		C.Apellido1,
		' ',
		C.Apellido2
	) AS Ejecutivo,
	A. STATUS
FROM
	sibware.2_ac_analisiscredito A
INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
INNER JOIN sibware.personal C ON B.IDEjecutivo = C.ID
WHERE
	A.FInicio >= '$fini'
AND A.FInicio <= '$ffin'
AND ISNULL(A.lAprobado)");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        if ($row['Folio']=="") {
            $folio="Sin Folio";
        }else{
            $folio=$row['Folio'];
        }
        switch ($row['STATUS']) {
            case 'NF':
                $opinion="No Favorable";
                break;
            case 'R':
                $opinion="Recomendacion";
                break;
            case 'FC':
                $opinion="Condicionada";
                break;
            case 'F':
                $opinion="Favorable";
                break;
            case 'NO':
                $opinion="No Otorgado";
                break;            
            default:
                $opinion="Sin Opinion Aun";
                break;
        }
        echo "<tr><td>".$row['Cliente']."</td><td>".$folio."</td><td>".$row['Emp']."</td><td>".$row['Ejecutivo']."</td><td>".$opinion."</td><td>".$row['FInicio']."</td><td><a href='viewanalisis.php?idac=".$row['ID']."&emp=2'>Revisar</a></td></tr>";
        
    }
    $queryResult=$pdo->query("SELECT
    A.ID,
	CONCAT(
		B.Nombre,
		' ',
		B.Apellido1,
		' ',
		B.Apellido2
	) AS Cliente,
	CONCAT(
		A.TipoContrato,
		'-',
		LPAD(A.FolioContrato, 6, 0)
	) AS Folio,
	A.FInicio,
	'CMA' as Emp,
	CONCAT(
		C.Nombre,
		' ',
		C.Apellido1,
		' ',
		C.Apellido2
	) AS Ejecutivo,
	A. STATUS
FROM
	sibware.3_ac_analisiscredito A
INNER JOIN sibware.3_cliente B ON A.IDCliente = B.ID
INNER JOIN sibware.personal C ON B.IDEjecutivo = C.ID
WHERE
	A.FInicio >= '$fini'
AND A.FInicio <= '$ffin'
AND ISNULL(A.lAprobado)");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        if ($row['Folio']=="") {
            $folio="Sin Folio";
        }else{
            $folio=$row['Folio'];
        }
        switch ($row['STATUS']) {
            case 'NF':
                $opinion="No Favorable";
                break;
            case 'R':
                $opinion="Recomendacion";
                break;
            case 'FC':
                $opinion="Condicionada";
                break;
            case 'F':
                $opinion="Favorable";
                break;
            case 'NO':
                $opinion="No Otorgado";
                break;            
            default:
                $opinion="Sin Opinion Aun";
                break;
        }
        echo "<tr><td>".$row['Cliente']."</td><td>".$folio."</td><td>".$row['Emp']."</td><td>".$row['Ejecutivo']."</td><td>".$opinion."</td><td>".$row['FInicio']."</td><td><a href='viewanalisis.php?idac=".$row['ID']."&emp=3'>Revisar</a></td></tr>";
        
    }
?>
</table>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
