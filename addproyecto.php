<?php
    require_once 'header.php';
    //////inicio de contenido
    if(!empty($_POST['guardar'])){
        $hoy=date('Y-m-d');
        $queryInsert=$pdo->prepare("INSERT INTO Intranet.scr_project (proyecto,descripcion,id_owner,id_scr_master,finicial,ffinal_propuesta,status,porcentaje,id_area_de_impacto) VALUES ('$_POST[nombre]','$_POST[desc]',$_POST[onw],31,'$hoy','$_POST[ffinalp]',1,0,$_POST[area])");
        $queryInsert->execute();
        echo "<div class='alert alert-success'>";
        echo "    <strong>Exito!</strong>El proyecto fue guardado con Exito!";
        echo "</div>";

    }
?>    
<h3>Agregar Nuevo Proyecto</h3>
<form action="addproyecto.php" method="post">
    <div class="row">
        <div class="col-xs-3">
            <label for="nombre">Nombre o clave del Proyecto</label><input type="text" name="nombre" id="nombre" class="form-control" required="true">
        </div>
        <div class="col-xs-3">
            <label for="onw">Owner Product</label><select name="onw" id="onw" class="form-control" required="true">
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
            <label for="ffinalp">Fecha Final Propuesta</label><input type="date" name="ffinalp" id="ffinalp" class="form-control" required="true">
        </div>
        <div class="col-xs-3">
            <label for="area">Area de Impacto</label><select name="area" id="area" class="form-control" required="true">
                <option value="">Seleccione..</option>
                <?php
                    $queryResult=$pdo->query("SELECT ID, Nombre FROM sibware.personal_departamentos");
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='".$row['ID']."'>".$row['Nombre']."</option>";
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <label for="desc">Descripcion del Proyecto</label><textarea name="desc" id="desc" cols="30" rows="10" class="form-control" required="true" placeholder="Describa el proyecto aqui"></textarea>
        </div>
        <div class="col-xs-3">
            <br><input type="submit" value="Guardar" class="button" id="guardar" name="guardar"><a href="proyectos.php" class="button">Regresar</a>
        </div>
    </div>
</form>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
