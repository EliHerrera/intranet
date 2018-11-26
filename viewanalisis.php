<?php
    require_once 'header.php';
    //////inicio de contenido
    $hoy=date('y-m-d');
    if (!empty($_GET['idac'])) {
        $idac=$_GET['idac'];
        $emp=$_GET['emp'];
    }elseif(!empty($_POST)){
            $queryResult=$pdo->query("SELECT * FROM Intranet.comiteaprobacion WHERE idac=$_POST[idac] AND emp=$_POST[emp]");
            $row_count = $queryResult->rowCount(); 
            if($row_count>0){
                echo "<div class='alert alert-danger'>";
                echo "    <strong>Informacion!</strong> El Pre-Contrato ".$_POST['folio']." ya se encuetra para Aprobacion de Comite!";
                echo "</div> ";    
            }else{    
                $queryInsert=$pdo->prepare("INSERT INTO Intranet.comiteaprobacion (idac,idcte,ideje,cliente,ejecutivo,folio,emp,status,fecha) VALUES ($_POST[idac],$_POST[idcte],$_POST[ideje],'$_POST[cliente]','$_POST[ejecutivo]','$_POST[folio]',$_POST[emp],'P','$hoy')");
                #var_dump($queryInsert);
                $queryInsert->execute();    
                echo "<div class='alert alert-info'>";
                echo "    <strong>Informacion!</strong> El Pre-Contrato ".$_POST['folio']." ha sido seleccionado para Aprobacion de Comite!";
                echo "</div> ";
            }    

    }
    if ($emp==2) {
        $queryResult=$pdo->query("SELECT
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
        'CMU' AS Emp,
        CONCAT(
            C.Nombre,
            ' ',
            C.Apellido1,
            ' ',
            C.Apellido2
        ) AS Ejecutivo,
        A. STATUS,
        A.IDCliente AS idcte,
        B.IDEjecutivo AS ideje,
        A.Solicitado,
        A.IDOrigenRecursos,
        D.Nombre AS recursos,
        A.SaldoFinanciar,
        A.TipoTasa,
        A.Tasa,
        A.PAdicional,
        A.TasaTotal,
        A.Plazo,
        A.SPlazo,
        A.Revolvencias,
        A.Deposito,
        A.pEnganche,
        A.Sector,
        A.Descripcion,
        A.PComision,
        A.TipoContrato,
        E.tipo as tipocte
    FROM
        sibware.2_ac_analisiscredito A
    INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
    INNER JOIN sibware.personal C ON B.IDEjecutivo = C.ID
    INNER JOIN sibware.2_entorno_origenrecursos D ON A.IDOrigenRecursos = D.ID
    INNER JOIN sibware.2_entorno_tipocliente E ON B.IDTipoCliente=E.ID
    WHERE
        A.ID=$idac");
     
    }elseif ($emp==3) {
        $queryResult=$pdo->query("SELECT
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
        'CMA' AS Emp,
        CONCAT(
            C.Nombre,
            ' ',
            C.Apellido1,
            ' ',
            C.Apellido2
        ) AS Ejecutivo,
        A. STATUS,
        A.IDCliente AS idcte,
        B.IDEjecutivo AS ideje,
        A.Solicitado,
        A.IDOrigenRecursos,
        D.Nombre AS recursos,
        A.SaldoFinanciar,
        A.TipoTasa,
        A.Tasa,
        A.PAdicional,
        A.TasaTotal,
        A.Plazo,
        A.SPlazo,
        A.Revolvencias,
        A.Deposito,
        A.pEnganche,
        A.Sector,
        A.Descripcion,
        A.PComision,
        A.TipoContrato,
        E.tipo as tipocte
    FROM
        sibware.3_ac_analisiscredito A
    INNER JOIN sibware.3_cliente B ON A.IDCliente = B.ID
    INNER JOIN sibware.personal C ON B.IDEjecutivo = C.ID
    INNER JOIN sibware.3_entorno_origenrecursos D ON A.IDOrigenRecursos = D.ID
    INNER JOIN sibware.2_entorno_tipocliente E ON B.IDTipoCliente=E.ID
    WHERE
        A.ID=$idac");
    }
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $idcte=$row['idcte'];
        $cliente=$row['Cliente'];
        $ideje=$row['ideje'];
        $ejecutivo=$row['Ejecutivo'];
        $folio=$row['Folio'];
        $fechainicio=$row['FInicio'];
        $solicitado=$row['Solicitado'];
        $saldoafinanciar=$row['SaldoFinanciar'];
        $idOR=$row['IDOrigenRecursos'];
        $recursos=$row['Nombre'];
        $tipotasa=$row['TipoTasa'];
        $tasa=$row['Tasa'];
        $padicional=$row['PAdicional'];
        $tasatotal=$row['TasaTotal'];
        $plazo=$row['Plazo'];
        $tipoplazo=$row['SPlazo'];
        $revolvencia=$row['Revolvencias'];
        $deposito=$row['Deposito'];
        $penganche=$row['pEnganche'];
        $sector=$row['Sector'];
        $descripcion=$row['Descripcion'];
        $pcomision=$row['PComision'];
        $tipocontrato=$row['TipoContrato'];
        $tipocte=$row['tipocte'];

    }
    
?>    
<h3>Relacion de Pre-Contrato <?php echo " ".$folio; ?></h3>
<table class="table">
<tr><th colspan='2'>Cliente</th><td colspan="2"><?php echo $cliente ?></td><th>Folio</th><td><?php echo $folio ?></td><th>Fecha</th><td><?php echo $fechainicio ?></td></tr>
<tr><th colspan="2">Ejecutivo</th><td colspan="2"><?php echo $ejecutivo ?></td><th>Tipo Contrato</th><td><?php echo $tipocontrato ?></td><th>Tipo Cliente</th><td><?php echo $tipocte ?></td></tr>
<tr><th>Solicitado</th><td><?php echo number_format($solicitado,2) ?></td><th>A Financiar</th><td><?php echo number_format($saldoafinanciar,2) ?></td><th>Desposito</th><td><?php echo number_format($deposito,2) ?></td><th>% Enganche</th><td><?php echo $penganche ?></td></tr>
<tr><th>Plazo</th><td><?php echo $plazo ?></td><th>Tipo Plazo</th><td><?php echo $tipoplazo ?></td><th>Revolvencias</th><td><?php echo $revolvencia ?></td><th>% Comision</th><td><?php echo $pcomision ?></td></tr>
<tr><th>Tasa</th><td><?php echo $tasa ?></td><th>P. Adicional</th><td><?php echo $padicional ?></td><th>Tasa Total</th><td><?php echo $tasatotal ?></td><th>Tipo Tasa</th><td><?php echo $tipotasa ?></td></tr>
<tr><th>Sector</th><td><?php echo $sector ?></td><th>Descripcion</th><td colspan="6"><?php echo $descripcion ?></td></tr>
</table>
<form action="viewanalisis.php" method="post">
<div class="row">
    <div class="col-xs-2">
        <a href="comite.php" class="button">Regresar</a>
    </div>
    <div class="col-xs-2">
        <input type="text" name="idac" id="idac" value="<?php echo $idac ?>" required="true" hidden="true">
        <input type="text" name="emp" id="emp" value="<?php echo $emp ?>" required="true" hidden="true">
        <input type="text" name="idcte" id="idcte" value="<?php echo $idcte ?>" required="true" hidden="true">
        <input type="text" name="cliente" id="cliente" value="<?php echo $cliente ?>" required="true" hidden="true">
        <input type="text" name="ideje" id="ideje" value="<?php echo $ideje ?>" required="true" hidden="true">
        <input type="text" name="ejecutivo" id="ejecutivo" value="<?php echo $ejecutivo ?>" required="true" hidden="true">
        <input type="text" name="folio" id="folio" value="<?php echo $folio ?>" required="true" hidden="true">
        <input type="submit" value="Seleccionar para Comite" class="button">
    </div>
</div>
</form>

<?php
    /////fin de contenido
    require_once 'footer.php';
?>
