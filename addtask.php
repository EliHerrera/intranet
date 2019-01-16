<?php
    require_once 'header.php';
    //////inicio de contenido
    if(!empty($_POST['guardar'])){
        $hoy=date('Y-m-d');
        $queryInsert=$pdo->prepare("INSERT INTO Intranet.scr_backlog (ID_project,ID_asignacion,ID_tester,descripcion,finicial,ffinal_propuesta,status,fasignacion) VALUES ($_POST[idpj],$_POST[asignacion],$_POST[tester],'$_POST[desc]','$hoy','$_POST[ffinalp]',1,'$hoy')");
        $queryInsert->execute();
        $queryResult=$pdo->query("SELECT * FROM Intranet.scr_backlog WHERE ID_project=$_POST[idpj] AND STATUS<>6");
        $row_count_totales = $queryResult->rowCount(); 
        $queryResult=$pdo->query("SELECT * FROM Intranet.scr_backlog WHERE ID_project=$_POST[idpj] AND STATUS=5");
        $row_count_terminados = $queryResult->rowCount(); 
        $porcentaje=($row_count_terminados/$row_count_totales)*100;
        $queryUpdate=$pdo->prepare("UPDATE Intranet.scr_project SET porcentaje=$porcentaje WHERE ID=$_POST[idpj]");
        $queryUpdate->execute();
        echo "<div class='alert alert-success'>";
        echo "    <strong>Exito!</strong>El proyecto fue guardado con Exito!";
        echo "</div>";
        $idpj=$_POST['idpj'];

    }
    if(!empty($_GET['idpj'])){
        $idpj=$_GET['idpj'];
        $queryResult=$pdo->query("SELECT * FROM Intranet.scr_project WHERE ID=$idpj");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $fechamax=$row['ffinal_propuesta'];
        }
    }
?>    
<h3>Agregar BackLogs</h3>
<form action="addtask.php" method="post">
    <div class="row">
        <div class="col-xs-3">
        <label for="asignacion">Asignar</label><select name="asignacion" id="asignacion" class="form-control" required="true">
                <option value="">Seleccione..</option>
                <?php
                    $queryResult=$pdo->query("SELECT ID, CONCAT(Nombre,' ',Apellido1,' ',Apellido2) as emp FROM sibware.personal WHERE status='S' AND IDDepartamento=6");
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='".$row['ID']."'>".$row['emp']."</option>";
                    }
                ?>
            </select>
        </div>
        <div class="col-xs-3">
            <label for="tester">Tester</label><select name="tester" id="tester" class="form-control" required="true">
                <option value="">Seleccione..</option>
                <?php
                    $queryResult=$pdo->query("SELECT ID, CONCAT(Nombre,' ',Apellido1,' ',Apellido2) as emp FROM sibware.personal WHERE status='S'");
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='".$row['ID']."'>".$row['emp']."</option>";
                    }
                ?>
            </select>
        </div>
        <div class="col-xs-3">
            <label for="ffinalp">Fecha Final Propuesta</label><input type="date" name="ffinalp" id="ffinalp" class="form-control" required="true" max="<?PHP echo $fechamax ?>">
        </div>
        <div class="col-xs-3">
            <input type="hidden" name="idpj"  id="idpj" class="form-control" readonly="true" required="true" hidden="true" value="<?php echo $idpj ?>" >        
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <label for="desc">Descripcion del BackLog</label><textarea name="desc" id="desc" cols="30" rows="10" class="form-control" required="true" placeholder="Describa el BackLog"></textarea>
        </div>
        <div class="col-xs-3">
            <br><input type="submit" value="Guardar" class="button" id="guardar" name="guardar"><a href="gestionarproyecto.php?idpj=<?php echo $idpj ?>" class="button">Regresar</a>
        </div>
    </div>
</form>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
