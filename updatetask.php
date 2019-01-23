<?php
    require_once 'header.php';
    $hoy=date('Y-m-d');
    //////inicio de contenido
    if(!empty($_POST['actualizar'])){
        $queryUpdate=$pdo->prepare("UPDATE Intranet.scr_backlog SET ID_asignacion=$_POST[asignacion], ID_tester=$_POST[tester],status=$_POST[status] WHERE ID=$_POST[idtask]");
        $queryUpdate->execute();
        $queryResult=$pdo->query("SELECT * FROM Intranet.scr_backlog WHERE ID_project=$_POST[idpj] AND STATUS<>6");
        $row_count_totales = $queryResult->rowCount(); 
        $queryResult=$pdo->query("SELECT * FROM Intranet.scr_backlog WHERE ID_project=$_POST[idpj] AND STATUS=5");
        $row_count_terminados = $queryResult->rowCount(); 
        $porcentaje=($row_count_terminados/$row_count_totales)*100;
        $queryUpdate=$pdo->prepare("UPDATE Intranet.scr_project SET porcentaje=$porcentaje WHERE ID=$_POST[idpj]");
        $queryUpdate->execute();
        $queryUpdate=$pdo->prepare("INSERT INTO Intranet.scr_score(ID_project,ID_task,ID_asignacion,ID_tester,ID_status,fecha) VALUES ($_POST[idpj],$_POST[idtask],$_POST[asignacion],$_POST[tester],$_POST[status],'$hoy')");
        $queryUpdate->execute();
        if(($_POST['status']<>6 && $_POST['status']<>5) || $porcentaje==100){
            $queryUpdate=$pdo->prepare("UPDATE Intranet.scr_project SET status=$_POST[status] WHERE ID=$_POST[idpj]");
            $queryUpdate->execute();
        }
        if($_POST['status']==5){
            $queryUpdate=$pdo->prepare("UPDATE Intranet.scr_backlog SET ffinal='$hoy' WHERE ID=$_POST[idtask]");
            $queryUpdate->execute();
            
        }
        echo "<div class='alert alert-success'>";
        echo "    <strong>Exito!</strong>Actualizado con Exito!";
        echo "</div>";
        echo "<a href='gestionarproyecto.php?idpj=".$_POST['idpj']."' class='button'>Regresar</a>";
    }
    if(!empty($_GET['idtask'])){
        $idtask=$_GET['idtask'];
        $queryResult=$pdo->query("SELECT * FROM Intranet.scr_backlog WHERE ID=$idtask");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $desc=$row['descripcion'];
            $idasignacion=$row['ID_asignacion'];
            $idtester=$row['ID_tester'];
            $idstatus=$row['status'];
            $idpj=$row['ID_project'];
            echo "<h3>Informacion de BackLog</h3>";
            echo "<div class='alert alert-info'>";
            echo "    <strong>".$desc."</strong>";
            echo "</div>";
        }
        echo "<a href='gestionarproyecto.php?idpj=".$idpj."' class='button'>Regresar</a>";
    }
    
?>  
<form action="updatetask.php" method="post">
    <div class="row">
        <div class="col-xs-3">
            <label for="asignacion"></label>
            <select name="asignacion" id="asignacion" class="form-control" required="true">
                <option value="">Seleccione...</option>
                <?php
                    $queryResult=$pdo->query("SELECT ID, CONCAT(Nombre,' ',Apellido1,' ',Apellido2) as emp FROM sibware.personal WHERE status='S' AND IDDepartamento=6");
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                        if ($row['ID']==$idasignacion) {
                            echo "<option selected value='".$row['ID']."'>".$row['emp']."</option>";
                        }else{
                            echo "<option value='".$row['ID']."'>".$row['emp']."</option>";
                        }    
                    }

                ?>
            </select>
        </div>
        <div class="col-xs-3">
            <label for="tester"></label>
            <select name="tester" id="tester" class="form-control" required="true">
                <option value="">Seleccione...</option>
                <?php
                    $queryResult=$pdo->query("SELECT ID, CONCAT(Nombre,' ',Apellido1,' ',Apellido2) as emp FROM sibware.personal WHERE status='S'");
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                        if ($row['ID']==$idtester) {
                            echo "<option selected value='".$row['ID']."'>".$row['emp']."</option>";
                        }else{
                            echo "<option value='".$row['ID']."'>".$row['emp']."</option>";
                        }
                        
                    }
                ?>
            </select>
        </div>
        <div class="col-xs-3">
            <label for="status"></label>
            <select name="status" id="status" class="form-control" required="true">
                <option value="">Seleccione...</option>
                <?php
                    $queryResult=$pdo->query("SELECT ID, status FROM Intranet.scr_status ");
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                        if ($row['ID']==$idstatus) {
                            echo "<option selected value='".$row['ID']."'>".$row['status']."</option>";
                        }else{
                            echo "<option value='".$row['ID']."'>".$row['status']."</option>";
                        }
                        
                    }
                ?>
            </select>
            <input type="hidden" name="idtask" id="idtask" value="<?php echo $idtask ?>" readonly="true">
            <input type="hidden" name="idpj" id="idpj" value="<?php echo $idpj ?>" readonly="true">
        </div>
        <?PHP
        if($idstatus<>5){
        ECHO "<div class='col-xs-3'>
            <br><input type='submit' value='Actualizar' class='button' name='actualizar' id='actualizar'>
        </div>";
        }
        ?>
    </div>
</form>  

<?php
    /////fin de contenido
    require_once 'footer.php';
?>
