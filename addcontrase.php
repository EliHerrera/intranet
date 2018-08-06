<?php
    require_once 'header.php';
    $idemp=0;
    if (!empty($_POST)) {
            $idemp=$_POST['user'];
            $idtipo=$_POST['tipo'];
            $queryResult = $pdo->query("INSERT INTO Intranet.admin_contrasenas (IDUsuario,IDTipo,Password,usuario,observacion) VALUES ($idemp,$idtipo,'$_POST[pws]','$_POST[usr]','$_POST[coment]')");
            echo "<div class='alert alert-success'>";
            echo "    <strong>Exito!</strong>El registro ha sido Guardado con Exito!";
            echo "</div>";

    }if (!empty($_GET['idcon'])) {
        $idemp=$_GET['idemp'];
        $idcon=$_GET['idcon'];
        $queryResult = $pdo->query("DELETE FROM Intranet.admin_contrasenas WHERE ID=$idcon");
        echo "<div class='alert alert-danger'>";
        echo "    <strong>Exito!</strong>El registro ha sido Eliminado!";
        echo "</div>";

    }
    //////inicio de contenido
?>    
<h3>Control de Contraseñas</h3>
<form action="addcontrase.php" method="post">
<div class="row">
    <div class="col-xs-4">
    <label for="user">Usuario</label>
    <select name="user" id="user" class="form-control" required="true">
        <option value="">Selecione Usuario...</option>
        <?PHP
            $queryResult = $pdo->query("SELECT A.ID,CONCAT(A.Nombre,' ',A.Apellido1,' ',A.Apellido2) as empleado FROM sibware.personal A WHERE A.`status`='S'");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $id_emp=$row['ID'];
		        $nombre=$row['empleado'];
		         if($id_emp==$idemp){echo "<option selected='selected' value=".$id_emp.">".$nombre."</option>";}
		        echo "<option value=".$id_emp.">".$nombre."</option>";
            }

        ?>
    </select>
    </div>
    <div class="col-xs-4">
    <label for="tipo">Tipo de Contraseña</label>
    <select name="tipo" id="tipo" class="form-control" required="true">
            <option value="">Selecione tipo...</option>
            <?PHP
                $queryResult = $pdo->query("SELECT A.ID,A.Tipo FROM Intranet.tipo_contrasenas A ");
                while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                    $id_tipo=$row['ID'];
                    $nombre=$row['Tipo'];
                    if($id_tipo==$idtipo){echo "<option selected='selected' value=".$id_tipo.">".$nombre."</option>";}
                    echo "<option value=".$id_tipo.">".$nombre."</option>";
                }
            ?>
    </select>
    </div>
</div>
<div class="row">
    <div class="col-xs-4">
                <label for="usr">Usuario</label><input type="text" name="usr" id="usr" required="true" class="form-control" placeholder="Escriba usuario">
    </div>
    <div class="col-xs-4">
                <label for="psw">Contraseña</label><input type="text" name="pws" id="pws" required="true" class="form-control" placeholder="Escriba Contraseña">
    </div>
</div>
<div class="row">
    <div class="col-xs-6">  
                <label for="coment">Comentarios</label><textarea name="coment" id="coment" cols="5" rows="10" class="form-control" placeholder="Agregue sus comentarios"></textarea>
    </div>
    <div class="col-xs-2">
                <br><input type="submit" value="Agregar"class="button">
    </div>
    <div class="col-xs-2">
                <br><input type="reset" value="Restablecer"class="button">
    </div>
    <div class="col-xs-2">
                <br><a href="admincontrase.php" class="button">Regresar</a>
    </div>
</div>
</form>
<table class="table">
<tr><th>Tipo</th><th>Usuario</th><th>Password</th><th>Acciones</th></tr>
<?PHP
    $queryResult = $pdo->query("SELECT A.ID,B.Tipo, A.usuario, A.`Password`   from Intranet.admin_contrasenas A INNER JOIN Intranet.tipo_contrasenas B on A.IDTipo=B.ID where A.IDUsuario=$idemp");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>".$row['Tipo']."</td><td>".$row['usuario']."</td><td>".$row['Password']."</td><td><a href='addcontrase.php?idcon=".$row['ID']."&&idemp=".$idemp."'><img src='img/icons/delete.png'></a></td></tr>";
    }
?>    
</table>



<?php
    /////fin de contenido
    require_once 'footer.php';
?>
