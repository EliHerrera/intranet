<?php
    require_once 'header.php';
    //////inicio de contenido
    $periodo=date("n", mktime(0, 0, 0, date('m')-1, date('d'), date('Y')));
    $yy=date('Y');
    $queryResult = $pdo->prepare("SELECT * FROM Intranet.procesacomisiones A WHERE A.periodo=$periodo AND A.lActivo='S'");
    $queryResult->execute();
    $result = $queryResult->fetch(PDO::FETCH_ASSOC);
    
if(empty($result)){  
    $queryResult = $pdo->query("INSERT INTO Intranet.procesacomisiones (fecha,periodo,lActivo,yy) VALUES('$hoy',$periodo,'S',$yy)");
    $queryResult = $pdo->query("SELECT 
    A.ID,
    A.IDSucursal,
    A.IDPuesto
FROM
    sibware.personal A
       
WHERE
    A.IDDepartamento = 1 AND A.status = 'S'");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $queryResult2 = $pdo->query("INSERT INTO sibware.comisiones (IDEjecutivo,IDSucursal,Producto,lAprobado,Periodo,YY) VALUES($row[ID],$row[IDSucursal],'IN','',$periodo,'$yy')");
        $queryResult2 = $pdo->query("INSERT INTO sibware.comisiones (IDEjecutivo,IDSucursal,Producto,lAprobado,Periodo,YY) VALUES($row[ID],$row[IDSucursal],'AP','',$periodo,'$yy')");
        $queryResult2 = $pdo->query("INSERT INTO sibware.comisiones (IDEjecutivo,IDSucursal,Producto,lAprobado,Periodo,YY) VALUES($row[ID],$row[IDSucursal],'APU','',$periodo,'$yy')");
        $queryResult2 = $pdo->query("INSERT INTO sibware.comisiones (IDEjecutivo,IDSucursal,Producto,lAprobado,Periodo,YY) VALUES($row[ID],$row[IDSucursal],'VP','',$periodo,'$yy')");
        $queryResult2 = $pdo->query("INSERT INTO sibware.comisiones (IDEjecutivo,IDSucursal,Producto,lAprobado,Periodo,YY) VALUES($row[ID],$row[IDSucursal],'CR','',$periodo,'$yy')");
    }
    echo "<div class='alert alert-success'>";
    echo "    <strong>Exito!</strong>Las comisiones han sido procesadas con Exito!";
    echo "</div>";
}
    if (!empty($_POST)) {
        $fini=$_POST['fini'];
        $ffin=$_POST['ffin'];
        if ($_SESSION['IDDepartamento']==6) {
            $queryResult = $pdo->query("SELECT
        A.id_comision,
        CONCAT(
            B.Nombre,
            ' ',
            B.Apellido1,
            ' ',
            B.Apellido2
        ) AS Ejecutivo,
        A.fecha,
        A.total_comi_inv,
        A.total_comi_cred,
        A.total_comi_vp,
        A.total_comi_apvp,
        A.total_bono,
        A.total_apagar,
        A.mes,
        A.yy,
        A.status
    FROM
        Intranet.comisiones A
    INNER JOIN sibware.personal B ON A.id_ejecutivo = B.ID
    WHERE
        A.status <= 3 and A.status>=1 AND (A.fecha BETWEEN '$fini' AND '$ffin')");
        }
        
        
    }elseif (!empty($_GET['idcomi'])&&!empty($_GET['baja'])&&$_GET['baja']=='B') {
        $queryResult2 = $pdo->query("SELECT id_comision,id_ejecutivo,mes,yy FROM Intranet.comisiones WHERE id_comision=$_GET[idcomi]");
        while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
            $idcomi=$row['id_comision'];
            $y=$row['yy'];
            $ideje=$row['id_ejecutivo'];
            $mes=$row['mes'];
        }
        $queryResult3 = $pdo->prepare("UPDATE Intranet.comisiones SET status=0 WHERE id_comision=$idcomi ");
        $queryResult3->execute();  
        $queryResult4 = $pdo->prepare("UPDATE sibware.comisiones SET lAprobado='' WHERE IDEjecutivo=$ideje AND YY=$y AND Periodo=$mes ");
        $queryResult4->execute();  
        echo "<div class='alert alert-danger'>";
        echo "    <strong>Aviso! </strong> Comision Eliminada!";
        echo "</div>";
    }
?> 
<h3>Relacion de comisiones</h3>
<form method='POST' action='relcomisiones.php'>
<div class="row">
    <div class="col-xs-4">
        <label for='fini'>Desde</label><input type='date' name='fini' id='fini' required='true' class="form-control">
    </div>
    <div class="col-xs-4">
        <label for='ffin'>hasta</label><input type='date' name='ffin' id='ffin' required='true' class="form-control">
    </div>
    <div class="col-xs-2">
        <br><input type='submit' value='Buscar' class='button'>
    </div>
    <?PHP if ($_SESSION['Nivel']>=2) {
        
     ?>
    <div class="col-xs-2">
        <br><a href="comisiones.php" class="button">Aprobar</a>
    </div>
<?PHP } ?>
</div>
</form> 
<table class='table'>
<tr><th>Ejecutivo</th><th>Fecha</th><th>Periodo</th><th>Año</th><th>Inversiones</th><th>Creditos</th><th>Venta a Plazo</th><th>Arrendamiento</th><th>Bonos</th><th>Total</th><th>Acciones</th></tr>
<?PHP
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $cominv=number_format($row['total_comi_inv'],2);
    $comcred=number_format($row['total_comi_cred'],2);
    $comvp=number_format($row['total_comi_vp'],2);
    $comap=number_format($row['total_comi_apvp'],2);
    $bonos=number_format($row['total_bono'],2);
    $apagar=number_format($row['total_apagar'],2);
    echo "<tr><td>$row[Ejecutivo]</td><td>$row[fecha]</td><td>$row[mes]</td><td>$row[yy]</td><td>$cominv</td><td>$comcred</td><td>$comvp</td><td>$comap</td><td>$bonos</td><td>$apagar</td><td>";
    if ($row['status']>=2 ) {
        ?>
        <a href="comisiones.php?idcomi=<?php echo $row[id_comision]; ?>"><img src="img/icons/review.png"></a>
        <?php
    }elseif ($row['status']==1 ) {
        ?>
        <a href="relcomisiones.php?idcomi=<?php echo $row[id_comision]; ?>&&baja=B"><img src="img/icons/delete.png"></a>
        <?php
        
    }

    echo "</td></tr>";

}
?>

<?php
    /////fin de contenido
    require_once 'footer.php';
?>
