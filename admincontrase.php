<?php
    require_once 'header.php';
    $idemp=0;
    if (!empty($_POST)) {
        $idemp=$_POST['user'];

    }if (!empty($_GET['idcon'])) {
        $idcon=$_GET['idcon'];
        $queryResult = $pdo->query("DELETE FROM Intranet.admin_contrasenas WHERE ID=$idcon");
        $idemp=$_GET['idemp'];
        echo "<div class='alert alert-danger'>";
        echo "    <strong>Exito!</strong>El registro ha sido Eliminado!";
        echo "</div>";

    }
    //////inicio de contenido
?>    
<h3>Control de Contraseñas</h3>
<form action="admincontrase.php" method="post">
<div class="row">
    <div class="col-xs-4">
    <label for="user">Usuario</label>
    <select name="user" id="user" class="form-control" onchange="this.form.submit();return false;" required>
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
    <div class="col-xs-2">
    <br><a href="addcontrase.php" class="button">Nuevo</a>
    </div>
</div>
</form>
<table class="table">
<tr><th>Tipo</th><th>Usuario</th><th>Password</th><th>Acciones</th></tr>
<?PHP
    $queryResult = $pdo->query("SELECT A.ID,B.Tipo, A.usuario, A.`Password`   from Intranet.admin_contrasenas A INNER JOIN Intranet.tipo_contrasenas B on A.IDTipo=B.ID where A.IDUsuario=$idemp");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>".$row['Tipo']."</td><td>".$row['usuario']."</td><td>".$row['Password']."</td><td><a href='admincontrase.php?idcon=".$row['ID']."&&idemp=".$idemp."'><img src='img/icons/delete.png'></a></td></tr>";
    }
?>    
</table>



<?php
    /////fin de contenido
    require_once 'footer.php';
?>
