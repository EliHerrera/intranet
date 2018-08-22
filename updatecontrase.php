<?php
    require_once 'header.php';
    $idemp=0;
    if (!empty($_POST)) {
            $idemp=$_POST['user'];
            $idtipo=$_POST['tipo'];
            $idcon=$_POST['idcon'];
            $usr=$_POST['usr'];
            $pws=$_POST['pws'];
            $coment=$_POST['coment'];
            // $sql="UPDATE Intranet.admin_contrasenas  SET IDUsuario=$idemp,IDTipo=$idtipo,Password='$_POST[pws]',usuario='$_POST[usr]',observacion='$_POST[coment]' WHERE ID=$idcon";
            // echo $sql;
            $queryResult = $pdo->query("UPDATE Intranet.admin_contrasenas  SET IDUsuario=$idemp,IDTipo=$idtipo,Password='$_POST[pws]',usuario='$_POST[usr]',observacion='$_POST[coment]' WHERE ID=$idcon");

            echo "<div class='alert alert-success'>";
            echo "    <strong>Exito!</strong>El registro ha sido Guardado con Exito!";
            echo "</div>";

    }if (!empty($_GET['idcon'])) {
        
        $idcon=$_GET['idcon'];
        $queryResult = $pdo->query("SELECT * FROM Intranet.admin_contrasenas WHERE ID=$idcon");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $idemp=$row['IDUsuario'];
            $idtipo=$row['IDTipo'];
            $coment=$row['observacion'];
            $pws=$row['Password'];
            $usr=$row['usuario'];
        }
       

    }
    //////inicio de contenido
?>    
<h3>Control de Contraseñas</h3>
<form action="updatecontrase.php" method="post">
<div class="row">
    <div class="col-xs-4">
    <label for="user">Usuario</label>
    <select name="user" id="user" class="form-control" required="true">
        <option value="">Selecione Usuario...</option>
        <?PHP
            $queryResult = $pdo->query("SELECT A.ID,CONCAT(A.Nombre,' ',A.Apellido1,' ',A.Apellido2) as empleado FROM sibware.personal A WHERE A.`status`='S' ORDER BY empleado ASC");
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
    <input type="text" name="idcon" id="idcon" value="<?php echo $idcon ?>" hidden="true">
    </div>
</div>
<div class="row">
    <div class="col-xs-4">
                <label for="usr">Usuario</label><input type="text" value="<?PHP echo $usr ?>" name="usr" id="usr" required="true" class="form-control" placeholder="Escriba usuario">
    </div>
    <div class="col-xs-4">
                <label for="psw">Contraseña</label><input type="text" value="<?PHP echo $pws ?>" name="pws" id="pws" required="true" class="form-control" placeholder="Escriba Contraseña">
    </div>
</div>
<div class="row">
    <div class="col-xs-6">  
                <label for="coment">Comentarios</label><textarea name="coment" id="coment" cols="5" rows="10" class="form-control" placeholder="Agregue sus comentarios"><?PHP echo $coment ?></textarea>
    </div>
    <div class="col-xs-2">
                <br><input type="submit" value="Guardar"class="button">
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
