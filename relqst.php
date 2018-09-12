<?php
    require_once 'header.php';
    //////inicio de contenido
    $periodo=date('Y');
    if (!empty($_POST)) {
        
        $queryResult = $pdo->query("INSERT INTO Intranet.RelQst (IDQst,IDPersonal,periodo) VALUES($_POST[idqst],$_POST[idemp],$periodo)");
        echo "<div class='alert alert-success'>";
        echo "    <strong>Exito!</strong> Asignacion EXitosa!";
        echo "</div>";
    }
?>    
    <h3>Asignacion de Examenes</h3>
    <form action="relqst.php" method="post">
    <div class="row">
        <div class="col-xs-4">
            <label for="idqst">Examen</label><select name="idqst" id="idqst" class="form-control" required="true">
                <option value="">Seleccione examen...</option>
                <?PHP
                    $queryResult = $pdo->query("SELECT * FROM Intranet.PLD_Qst"); 
                    while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='".$row['ID']."'>".$row['codigo']."</option>";
                    }
                ?>
            </select>
        </div>
        <div class="col-xs-4">
            <label for="idemp">Empleado</label><select name="idemp" id="idemp" class="form-control" required="true">
                <option value="">Seleccione empleado..</option>
                <?PHP
                    $queryResult = $pdo->query("SELECT A.ID,CONCAT(A.Nombre,' ',A.Apellido1,' ',A.Apellido2)as nombre FROM sibware.personal A LEFT JOIN Intranet.RelQst B ON A.ID = B.IDPersonal AND B.periodo=$periodo WHERE A.status='S' AND ISNULL(B.ID)");
                    while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='".$row['ID']."'>".$row['nombre']."</option>";
                    }
                ?>
            </select>
        </div>
        <div class="col-xs-3">
            <br><input type="submit" value="Relacionar" class="button">
        
            <a href="qstpld.php" class="button">Regresar</a>
        </div>
    </div>
    </form>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
