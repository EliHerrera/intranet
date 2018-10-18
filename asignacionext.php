<?php
    require_once 'header.php';
    //////inicio de contenido
    $idcto=$_GET['idcto'];
    $periodo=$_GET['periodo'];
    $yy=$_GET['yy'];
    $valor=$_GET['valor'];
    $emp=$_GET['emp'];
    $pro=$_GET['pro'];
    if (!empty($_POST)) {
        //var_dump($_POST);
        $valor=$_POST['valor'];
        $inserquery=$pdo->prepare("INSERT INTO Intranet.asignacion_ctos_ext (IDContrato,IDCliente,Fecha,periodo,yy,IDpersonal,Producto,Empresa) VALUES($_POST[idcto],$_POST[idcte],'$_POST[finicio]',$_POST[periodo],$_POST[yy],$_POST[personal],'$_POST[pro]','$_POST[emp]')");
        $inserquery->execute();
        //var_dump($inserquery);
        echo "<div class='alert alert-success'>";
        echo "    <strong>Exito! </strong> Contrato Asignado correctamente!";
        echo "</div>";
    }
    if(!empty($_GET['idasignacion'])){
        $deleteQuery=$pdo->prepare("DELETE FROM Intranet.asignacion_ctos_ext WHERE ID=$_GET[idasignacion]");
        //var_dump($deleteQuery);
        $deleteQuery->execute();
        echo "<div class='alert alert-danger'>";
        echo "    <strong>Aviso! </strong>Has eliminado una Asignacion!";
        echo "</div>";
    }
    
?> 
<h3>Asignacion de Contratos  </h3>
<form action="extencomisiones.php" method="post">
<input type="text" name="col" id="col" value="<?php echo $valor ?>" hidden="true">
<input type="submit" value="Regresar" class="button"></form>
<table class="table">
<tr><th>Cliente</th><th>Folio</th><th>Ejecutivo</th></tr>
<?php
switch ($pro) {
    case 'cr':
        $queryResult=$pdo->query("SELECT CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as Cliente, CONCAT(C.Nombre,' ',C.Apellido1,' ',C.Apellido2) as Ejecutivo, CONCAT('CR-', LPAD(A.Folio, 6, 0)) AS Folio, B.ID as IDCte, A.FInicio FROM sibware.2_contratos A INNER JOIN sibware.2_cliente B ON A.IDCliente=B.ID INNER JOIN sibware.personal C ON B.IDEjecutivo=C.ID WHERE A.ID=$idcto");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $idcte=$row['IDCte'];
            $fecha=$row['FInicio'];
            echo "<tr><td>".$row['Cliente']."</td><td>".$row['Folio']."</td><td>".$row['Ejecutivo']."</td></tr>";
        }
        break;
        case 'vp':
    $queryResult=$pdo->query("SELECT CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as Cliente, CONCAT(C.Nombre,' ',C.Apellido1,' ',C.Apellido2) as Ejecutivo, CONCAT('VP-', LPAD(A.Folio, 6, 0)) AS Folio, B.ID as IDCte, A.FInicio FROM sibware.3_vp_contrato A INNER JOIN sibware.3_cliente B ON A.IDCliente=B.ID INNER JOIN sibware.personal C ON B.IDEjecutivo=C.ID WHERE A.ID=$idcto");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $idcte=$row['IDCte'];
            $fecha=$row['FInicio'];
            echo "<tr><td>".$row['Cliente']."</td><td>".$row['Folio']."</td><td>".$row['Ejecutivo']."</td></tr>";
        }
        break;
        case 'ap':
    $queryResult=$pdo->query("SELECT CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as Cliente, CONCAT(C.Nombre,' ',C.Apellido1,' ',C.Apellido2) as Ejecutivo, CONCAT('AP-', LPAD(A.Folio, 6, 0)) AS Folio, B.ID as IDCte, A.FInicio FROM sibware.3_ap_contrato A INNER JOIN sibware.3_cliente B ON A.IDCliente=B.ID INNER JOIN sibware.personal C ON B.IDEjecutivo=C.ID WHERE A.ID=$idcto");
    //var_dump($queryResult);
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $idcte=$row['IDCte'];
            $fecha=$row['FInicio'];
            echo "<tr><td>".$row['Cliente']."</td><td>".$row['Folio']."</td><td>".$row['Ejecutivo']."</td></tr>";
        }
        break;
        case 'apu':
    $queryResult=$pdo->query("SELECT CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as Cliente, CONCAT(C.Nombre,' ',C.Apellido1,' ',C.Apellido2) as Ejecutivo, CONCAT('AP-', LPAD(A.Folio, 6, 0)) AS Folio, B.ID as IDCte, A.FInicio FROM sibware.2_ap_contrato A INNER JOIN sibware.2_cliente B ON A.IDCliente=B.ID INNER JOIN sibware.personal C ON B.IDEjecutivo=C.ID WHERE A.ID=$idcto");
    //var_dump($queryResult);
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $idcte=$row['IDCte'];
            $fecha=$row['FInicio'];
            echo "<tr><td>".$row['Cliente']."</td><td>".$row['Folio']."</td><td>".$row['Ejecutivo']."</td></tr>";
        }
        break;
    default:
        # code...
        break;
}
    
?>
</table>
<form action="asignacionext.php" method="post">
    <div class="row">
        <div class="col-xs-4">
            <input type="text" name="idcto" id="idcto" value="<?php echo $idcto ?>" hidden="true">
            <input type="text" name="idcte" id="idcte" value="<?php echo $idcte ?>" hidden="true">
            <input type="text" name="finicio" id="finicio" value="<?php echo $fecha ?>" hidden="true">
            <input type="text" name="periodo" id="periodo" value="<?php echo $periodo ?>" hidden="true">
            <input type="text" name="yy" id="yy" value="<?php echo $yy ?>" hidden="true">
            <input type="text" name="pro" id="pro" value="<?php echo $pro ?>" hidden="true">
            <input type="text" name="emp" id="emp" value="<?php echo $emp ?>" hidden="true">
            <input type="text" name="valor" id="valor" value="<?php echo $valor ?>" hidden="true">
            <label for="personal">Asignar a :</label>
            <select name="personal" id="personal" class="form-control" required="true">
                <option value="">Selecione...</option>
                <?php
                    $queryResult=$pdo->Query("SELECT A.ID,CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as ejecutivo, A.IDPersonal, A.alias as alias FROM Intranet.param_com_extensionistas A INNER JOIN sibware.personal B ON A.IDPersonal=B.ID");
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='".$row['IDPersonal']."'>".$row['alias']."</option>";
                    }
                ?>
            </select>
        </div>
        <div class="col-xs-3">
            <br><input type="submit" value="Asignar" class="button" >
        </div>
    </div>
    
</form>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
