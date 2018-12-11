<?php
    require_once 'header.php';
    //////inicio de contenido
    $hoy=date('y-m-d');
    if (!empty($_GET['idac'] && empty($_GET['idimage']))) {
        $idac=$_GET['idac'];
        $emp=$_GET['emp'];
    }elseif(!empty($_GET['idimage'])){
        $idac=$_GET['idac'];
        $emp=$_GET['emp'];
        $idimage=$_GET['idimage'];
        $queryDelete=$pdo->prepare("DELETE FROM Intranet.comite_image WHERE ID=$idimage");
        $queryDelete->execute();
        echo "<div class='alert alert-danger'>";
        echo "    <strong>Aviso!</strong>Imagen Eliminada!";
        echo "</div>";
    }elseif(!empty($_POST['comite'])){
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

    }elseif (!empty($_POST['antecedentes'])) {
                $idac=$_POST['idac'];
                $emp=$_POST['emp'];
                $queryResult=$pdo->query("SELECT * FROM Intranet.comite_antecedentes WHERE IDAc=$idac AND emp=$emp");
                $row_count = $queryResult->rowCount(); 
                if ($row_count==0) {
                    $queryInsert=$pdo->query("INSERT INTO Intranet.comite_antecedentes (IDAc,emp,antecedentes) VALUES($_POST[idac],$_POST[emp],'$_POST[antecedente]') ");
                }elseif($row_count>0){
                    $queryUpdate=$pdo->query("UPDATE Intranet.comite_antecedentes SET antecedentes='$_POST[antecedente]' WHERE IDAc=$idac AND emp=$emp ");

                }
                if ($_FILES['imgen_neg']["error"] > 0)
                    {
                        echo "Error: " . $_FILES['imgen_neg']['error'] . "<br>";
                        echo "<div class='alert alert-danger'>";
                        echo "    <strong>Error!</strong>El archivo no cumple con las caracteritiscas permitidas!";
                        echo "</div>";

                    }else{
                        $file=$_FILES['imgen_neg']['name'];
                        move_uploaded_file($_FILES['imgen_neg']['tmp_name'],'img_comite/' . $_FILES['imgen_neg']['name']); 
                        if(!empty($file)){
                             $queryInsert=$pdo->prepare("INSERT INTO Intranet.comite_image (IDAc,emp,image,url,modulo) VALUES($_POST[idac],$_POST[emp],'$file','$file','antecedentes')");
                            #var_dump($queryInsert);
                            $queryInsert->execute();
                        }
                       
                    }    
                echo "<div class='alert alert-info'>";
                echo "    <strong>Informacion!</strong> Se Actualizo informacion Correctamente!";
                echo "</div> ";
        # code...
    }elseif (!empty($_POST['justificacion'])) {
        $idac=$_POST['idac'];
        $emp=$_POST['emp'];
        $queryResult=$pdo->query("SELECT * FROM Intranet.comite_justificacion WHERE IDAc=$idac AND emp=$emp");
        $row_count = $queryResult->rowCount(); 
        if ($row_count==0) {
            $queryInsert=$pdo->query("INSERT INTO Intranet.comite_justificacion (IDAc,emp,justificacion) VALUES($_POST[idac],$_POST[emp],'$_POST[detallejus]') ");
        }elseif($row_count>0){
            $queryUpdate=$pdo->query("UPDATE Intranet.comite_justificacion SET justificacion='$_POST[detallejus]' WHERE IDAc=$idac AND emp=$emp ");

        }
        if ($_FILES['image_jus']["error"] > 0)
            {
                echo "Error: " . $_FILES['image_jus']['error'] . "<br>";
                echo "<div class='alert alert-danger'>";
                echo "    <strong>Error!</strong>El archivo no cumple con las caracteritiscas permitidas!";
                echo "</div>";

            }else{
                $file=$_FILES['image_jus']['name'];
                move_uploaded_file($_FILES['image_jus']['tmp_name'],'img_comite/' . $_FILES['image_jus']['name']); 
                if(!empty($file)){
                     $queryInsert=$pdo->prepare("INSERT INTO Intranet.comite_image (IDAc,emp,image,url,modulo) VALUES($_POST[idac],$_POST[emp],'$file','$file','justificacion')");
                    #var_dump($queryInsert);
                    $queryInsert->execute();
                }
               
            }    
        echo "<div class='alert alert-info'>";
        echo "    <strong>Informacion!</strong> Se Actualizo informacion Correctamente!";
        echo "</div> ";
# code...
}elseif (!empty($_POST['garantia'])) {
    $idac=$_POST['idac'];
    $emp=$_POST['emp'];
    if ($_FILES['image_gar']["error"] > 0)
            {
                echo "Error: " . $_FILES['image_gar']['error'] . "<br>";
                echo "<div class='alert alert-danger'>";
                echo "    <strong>Error!</strong>El archivo no cumple con las caracteritiscas permitidas!";
                echo "</div>";

            }else{
                $file=$_FILES['image_gar']['name'];
                move_uploaded_file($_FILES['image_gar']['tmp_name'],'img_comite/' . $_FILES['image_gar']['name']); 
                if(!empty($file)){
                    $queryInsert=$pdo->prepare("INSERT INTO Intranet.comite_image (IDAc,emp,image,url,modulo) VALUES($_POST[idac],$_POST[emp],'$file','$file','garantia')");
                    #var_dump($queryInsert);
                    $queryInsert->execute();
                }
               
            }
            echo "<div class='alert alert-info'>";
            echo "    <strong>Informacion!</strong> Se Actualizo informacion Correctamente!";
            echo "</div> ";
}
    elseif(!empty($_POST['presentacion'])){
        $idac=$_POST['idac'];
        $emp=$_POST['emp'];
        $queryResult=$pdo->query("SELECT * FROM Intranet.comite_antecedentes WHERE IDAc=$idac AND emp=$emp");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $antecedentes=$row['antecedentes'];
        }
        $queryResult=$pdo->query("SELECT * FROM Intranet.comite_justificacion WHERE IDAc=$idac AND emp=$emp");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $justificacion=$row['justificacion'];
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
        <input type="submit" value="Presentacion" id="presentacion" name="presentacion" class="button">
    </div>
    <div class="col-xs-2">
        <input type="text" name="idac" id="idac" value="<?php echo $idac ?>" required="true" hidden="true">
        <input type="text" name="emp" id="emp" value="<?php echo $emp ?>" required="true" hidden="true">
        <input type="text" name="idcte" id="idcte" value="<?php echo $idcte ?>" required="true" hidden="true">
        <input type="text" name="cliente" id="cliente" value="<?php echo $cliente ?>" required="true" hidden="true">
        <input type="text" name="ideje" id="ideje" value="<?php echo $ideje ?>" required="true" hidden="true">
        <input type="text" name="ejecutivo" id="ejecutivo" value="<?php echo $ejecutivo ?>" required="true" hidden="true">
        <input type="text" name="folio" id="folio" value="<?php echo $folio ?>" required="true" hidden="true">
        <input type="submit" value="Seleccionar para Comite" class="button" id="comite" name="comite">
    </div>
</div>
</form>
<?php if(!empty($_POST['presentacion'])){ ?>

<div class="row">
<!-- Antecedentes -->
    <form action="viewanalisis.php" method="post" enctype="multipart/form-data">
    <div class="col-xs-6">
    <input type="text" name="idac" id="idac" value="<?php echo $idac ?>" required="true" hidden="true">
        <input type="text" name="emp" id="emp" value="<?php echo $emp ?>" required="true" hidden="true">
        <br><label for="antecedente">Antecedentes</label><textarea name="antecedente" id="antecedente" cols="10" rows="5" required="true" class="form-control"><?php echo $antecedentes; ?></textarea>
    </div>
    <div class="row">
            <div class="col-xs-4">
                <br><label for="imgen_neg">Fotos Negocio</label><input type="file" name="imgen_neg" id="imgen_neg" accept="image/jpg" class="form-control">
            </div>
            <div class="col-xs-4"> 
                <?php
                    $queryResult=$pdo->query("SELECT * FROM Intranet.comite_image WHERE IDAc=$idac AND emp=$emp and modulo='antecedentes'");
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                        echo "<br><p><a href='img_comite/".$row['image']."' target='_blank' >".$row['image']."</a><a href='viewanalisis.php?idimage=".$row['ID']."&idac=".$idac."&emp=".$emp."'><img src='img/icons/delete.png'></a></p>";
                    }
                ?>
                <input type="submit" value="Guardar" id="antecedentes" name="antecedentes" class="button">
            </div>
    </div>
    <!-- Antecedentes -->
    <!-- justificacion del credito -->

    <div class="col-xs-6">
        <br><label for="detallejus">Justificacion del Credito</label><textarea name="detallejus" id="detallejus" cols="10" rows="5" required="true" class="form-control"><?php echo $justificacion; ?></textarea>
    </div>
    <div class="row">
            <div class="col-xs-4">
                <br><label for="imgen_jus">Fotos Justificacion</label><input type="file" name="image_jus" id="image_jus" accept="image/jpg" class="form-control">
            </div>
            <div class="col-xs-4"> 
                <?php
                    $queryResult=$pdo->query("SELECT * FROM Intranet.comite_image WHERE IDAc=$idac AND emp=$emp and modulo='justificacion'");
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                        echo "<br><p><a href='img_comite/".$row['image']."' target='_blank' >".$row['image']."</a><a href='viewanalisis.php?idimage=".$row['ID']."&idac=".$idac."&emp=".$emp."'><img src='img/icons/delete.png'></a></p>";
                    }
                ?>
                <input type="submit" value="Guardar" id="justificacion" name="justificacion" class="button">
            </div>
    </div>
    <!-- justificacion del credito -->
    <!-- Garantias... -->
    <h4>Relacion de Garantias</h4>
    <table class="table">
    <tr><th>Tipo</th><th>Descripcion</th><th>Valor</th><th>Ubicacion</th><tr>
    <?php
        if($emp==2){
            $queryResult=$pdo->query("SELECT * FROM sibware.2_contratos_garantias WHERE IDAnalisis=$idac");
        }elseif ($emp==3) {
            $queryResult=$pdo->query("SELECT * FROM sibware.3_vp_garantias WHERE IDAnalisis=$idac");
        }
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>".$row['Tipo']."</td><td>".$row['Descripcion']."</td><td>".$row['Ubicacion']."</td><td>".$row['Valor']."</td></tr>";
        }
           
    ?>
    </table>
    <!--fotos Garantias -->
    <div class="row">
            <div class="col-xs-4">
                <label for="imgen_jus">Fotos Garantias</label><input type="file" name="image_gar" id="image_gar" accept="image/jpg" class="form-control">
            </div>
            <div class="col-xs-2"> 
                <?php
                    $queryResult=$pdo->query("SELECT * FROM Intranet.comite_image WHERE IDAc=$idac AND emp=$emp and modulo='garantia'");
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                        echo "<br><p><a href='img_comite/".$row['image']."' target='_blank' >".$row['image']."</a><a href='viewanalisis.php?idimage=".$row['ID']."&idac=".$idac."&emp=".$emp."'><img src='img/icons/delete.png'></a></p>";
                    }
                ?>
                <br><input type="submit" value="Guardar" id="garantia" name="garantia" class="button">
            </div>
    </div>
    <!--fotos garantias -->

    <!-- Garantias... -->
    </form>
    
<?php }?>    
</div>


<?php
    /////fin de contenido
    require_once 'footer.php';
?>
