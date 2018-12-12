<?php
    require_once 'header.php';
    //////inicio de contenido
    $hoy=date('y-m-d');
    if (!empty($_GET['idac']) && empty($_GET['idburo']) && empty($_GET['idfoda']))  {
        $idac=$_GET['idac'];
        $emp=$_GET['emp'];
        $queryResult=$pdo->query("SELECT * FROM Intranet.comiteaprobacion WHERE idac=$idac and emp=$emp");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $pendientes=$row['pendientes'];
        }
    
    }elseif (!empty($_POST['idac'])) {
        $idac=$_POST['idac'];
        $emp=$_POST['emp'];
        $queryResult=$pdo->query("SELECT * FROM Intranet.comiteaprobacion WHERE idac=$idac and emp=$emp");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $pendientes=$row['pendientes'];
        }
        if (!empty($_POST['buro'])) {
            $queryInsert=$pdo->prepare("INSERT INTO Intranet.comite_buro_credito (idac,emp,fecha,institucion,score,juicios,observacion,credito) VALUES ($idac,$emp,'$hoy','$_POST[institucion]','$_POST[score]','$_POST[juicios]','$_POST[observacion]',$_POST[credito])");
            $queryInsert->execute();
            $queryUpdate=$pdo->prepare("UPDATE Intranet.comiteaprobacion SET status='PR' WHERE idac=$idac AND emp=$emp");
            $queryUpdate->execute();
            echo "<div class='alert alert-info'>";
            echo "    <strong>Informacion!</strong> Se Actualizo informacion Correctamente!";
            echo "</div> ";            
        }elseif (!empty($_POST['foda'])) {
            $queryInsert=$pdo->prepare("INSERT INTO Intranet.comite_foda (idac,emp,fecha,fortaleza,debilidad) VALUES ($idac,$emp,'$hoy','$_POST[fortaleza]','$_POST[debilidad]')");
            $queryInsert->execute();
            $queryUpdate=$pdo->prepare("UPDATE Intranet.comiteaprobacion SET status='PR' WHERE idac=$idac AND emp=$emp");
            $queryUpdate->execute();
            echo "<div class='alert alert-info'>";
            echo "    <strong>Informacion!</strong> Se Actualizo informacion Correctamente!";
            echo "</div> ";            
        }elseif (!empty($_POST['pendientes'])) {
            $queryUpdate=$pdo->prepare("UPDATE Intranet.comiteaprobacion SET pendientes='$_POST[pendiente]' WHERE idac=$idac AND emp=$emp");
            $queryUpdate->execute();
            $queryUpdate=$pdo->prepare("UPDATE Intranet.comiteaprobacion SET status='PR' WHERE idac=$idac AND emp=$emp");
            $queryUpdate->execute();
            $queryResult=$pdo->query("SELECT * FROM Intranet.comiteaprobacion WHERE idac=$idac and emp=$emp");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $pendientes=$row['pendientes'];
            }
            echo "<div class='alert alert-info'>";
            echo "    <strong>Informacion!</strong> Se Actualizo informacion Correctamente!";
            echo "</div> ";            
        }elseif(!empty($_POST['listo'])){
            $queryUpdate=$pdo->prepare("UPDATE Intranet.comiteaprobacion SET status='C' WHERE idac=$idac AND emp=$emp");
            $queryUpdate->execute();
            echo "<div class='alert alert-success'>";
            echo "    <strong>Exito!</strong> Se Guardo Correctamente! Listo Para Comite";
            echo "</div> ";
        }
        
    }elseif (!empty($_GET['idburo'])) {
        $idburo=$_GET['idburo'];
        $idac=$_GET['idac'];
        $emp=$_GET['emp'];
        $queryDelete=$pdo->prepare("DELETE FROM Intranet.comite_buro_credito WHERE ID=$idburo");
        $queryDelete->execute();
        $queryResult=$pdo->query("SELECT * FROM Intranet.comiteaprobacion WHERE idac=$idac and emp=$emp");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $pendientes=$row['pendientes'];
        }
        echo "<div class='alert alert-danger'>";
        echo "    <strong>Aviso!</strong> Informacion Eliminada";
        echo "</div> ";
    }elseif (!empty($_GET['idfoda'])) {
        $idfoda=$_GET['idfoda'];
        $idac=$_GET['idac'];
        $emp=$_GET['emp'];
        $queryDelete=$pdo->prepare("DELETE FROM Intranet.comite_buro_credito WHERE ID=$idfoda");
        $queryDelete->execute();
        $queryResult=$pdo->query("SELECT * FROM Intranet.comiteaprobacion WHERE idac=$idac and emp=$emp");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $pendientes=$row['pendientes'];
        }
        echo "<div class='alert alert-danger'>";
        echo "    <strong>Aviso!</strong> Informacion Eliminada";
        echo "</div> ";
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
<form action="viewgestionarpres.php" method="post">
<div class="row">
    <div class="col-xs-2">
        <a href="autorizaciondecomite.php" class="button">Regresar</a>
    </div>
    
    <div class="col-xs-2">
        <input type="text" name="idac" id="idac" value="<?php echo $idac ?>" required="true" hidden="true">
        <input type="text" name="emp" id="emp" value="<?php echo $emp ?>" required="true" hidden="true">
        <input type="text" name="idcte" id="idcte" value="<?php echo $idcte ?>" required="true" hidden="true">
        <input type="text" name="cliente" id="cliente" value="<?php echo $cliente ?>" required="true" hidden="true">
        <input type="text" name="ideje" id="ideje" value="<?php echo $ideje ?>" required="true" hidden="true">
        <input type="text" name="ejecutivo" id="ejecutivo" value="<?php echo $ejecutivo ?>" required="true" hidden="true">
        <input type="text" name="folio" id="folio" value="<?php echo $folio ?>" required="true" hidden="true">
        <input type="submit" value="Listo" class="button" id="listo" name="listo">
    </div>
</div>

<h4>Buro de Credito</h4>
<div class="row">
    <div class="col-xs-3">   
        <label for="institucion">Institucion</label><input type="text" name="institucion" id="institucion" class="form-control">
    </div>
    <div class="col-xs-3">    
        <label for="score">Score</label><input type="text" name="score" id="score" class="form-control">
    </div>
    <div class="col-xs-3">    
        <label for="juicios">Juicios</label><input type="text" name="juicios" id="juicios" class="form-control">
    </div>
    <div class="col-xs-3">    
        <label for="credito">Credito</label><input type="number" name="credito" id="credito" class="form-control">
    </div>
    <div class="col-xs-6">    
        <label for="observacion">Observaciones</label><textarea name="observacion" id="observacion" cols="10" rows="5" class="form-control"></textarea>
    </div>
    <div class="col-xs-2">    
        <br><input type="submit" value="Guardar" name="buro" id="buro" class="button">
    </div>
    
</div>
<br>    
<table class="table">
<tr><th>Institucion</th><th>Score</th><th>Juicios</th><th>Credito</th><th>Observaciones</th><th>Acciones</th></tr>
<?php   
    $queryResult=$pdo->query("SELECT * FROM Intranet.comite_buro_credito WHERE idac=$idac and emp=$emp");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>".$row['institucion']."</td><td>".$row['score']."</td><td>".$row['juicios']."</td><td>".number_format($row['credito'],2)."</td><td>".$row['observacion']."</td><td><a href='viewgestionarpres.php?idac=".$idac."&emp=".$emp."&idburo=".$row['ID']."'><img src='img/icons/delete.png'></a></td></tr>";
    }
?>
</table>
<h4>Matriz FODA</h4>
<div class="row">
    <div class="col-xs-6">
        <label for="fortaleza">Fortaleza</label><textarea name="fortaleza" id="fortaleza" cols="10" rows="5" class="form-control"></textarea>
    </div>
    <div class="col-xs-6">
        <label for="debilidad">Debilidad</label><textarea name="debilidad" id="debilidad" cols="10" rows="5" class="form-control"></textarea>
    </div>
    <div class="col-xs-2">    
        <br><input type="submit" value="Guardar" name="foda" id="foda" class="button">
    </div>
</div>
<br>
<table class="table">
<tr><th>FORTALEZA</th><th>DEBILIDADES</th><th>Acciones</th></tr>
<?php   
    $queryResult=$pdo->query("SELECT * FROM Intranet.comite_foda WHERE idac=$idac and emp=$emp");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>".$row['fortaleza']."</td><td>".$row['debilidad']."</td><td><a href='viewgestionarpres.php?idac=".$idac."&emp=".$emp."&idfoda=".$row['ID']."'><img src='img/icons/delete.png'></a></td></tr>";
    }
?>
</table>
<h4>Pendientes</h4>
<div class="row">
    <div class="col-xs-6">
        <label for="pendiente">Pendientes</label><textarea name="pendiente" id="pendiente" cols="10" rows="5" class="form-control"><?php echo $pendientes; ?></textarea>
    </div>
    <div class="col-xs-2">    
        <br><input type="submit" value="Guardar" name="pendientes" id="pendientes" class="button">
    </div>
</div>
</form>



<?php
    /////fin de contenido
    require_once 'footer.php';
?>
