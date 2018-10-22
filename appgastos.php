<?php
    require_once 'header.php';
    //////inicio de contenido
?>
<h3>Relacion de Gastos</h3> 
<form action="appgastos.php" method="post">
<div class="row">
    <div class="col-xs-3">
        <label for="fini">Desde</label><input type="date" name="fini" id="fini" class="form-control" required="true">
    </div>
    <div class="col-xs-3">
        <label for="ffin">Hasta</label><input type="date" name="ffin" id="ffin" class="form-control" required="true">
    </div>
    <div class="col-xs-2">
        <br><input type="submit" value="Buscar" class="button">
    </div>
</div>
</form>
<table class="table">
<tr><td colspan="3"><h4>Relacion de Gastos</h4> </td><td><a href='addgasto.php' class="button">Nueva Solicitud</a></td></tr>
<tr><th>Folio</th><th>Fecha</th><th>Empleado</th><th>Monto</th><th>Status</th><th>Acciones</th></tr>
<?php
    if (!empty($_POST)) {
        $fini=$_POST['fini'];
        $ffin=$_POST['ffin'];
        $queryResult = $pdo->query("SELECT
        A.ID,
        A.Folio,
        A.Fecha,
        CONCAT(
            B.Nombre,
            ' ',
            B.Apellido1,
            ' ',
            B.Apellido2
        ) AS Personal,
        A.Total,
        A. STATUS AS St,
        CASE
    WHEN A. STATUS = 1 THEN
        'Pendiente'
    WHEN A. STATUS = 2 THEN
        'Autorizada'
    WHEN A. STATUS = 3 THEN
        'Compras'
    ELSE
        'Error'
    END AS STATUS
    FROM
        Intranet.gastos A
    INNER JOIN sibware.personal B ON A.IDPersonal = B.ID
    INNER JOIN sibware.2_entorno_perfil_solicitudpagos C ON B.ID = C.IDPersonal
    WHERE
        A.Fecha BETWEEN '$fini'
    AND '$ffin'
    AND C.IDEncargado = $idpersonal");
        //var_dump($queryResult);
        while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            if ($row['St']==1) {
                $class='warning';
            }elseif ($row['St']==2) {
                $class='warning';
            }elseif ($row['St']==3) {
                $class='success';
            }else{
                $class='danger';
            }
            echo "<tr><td>".$row['Folio']."</td><td>".$row['Fecha']."</td><td>".$row['Personal']."</td><td>".$row['Total']."</td><td class='".$class."'>".$row['STATUS']."</td><td><a href='viewgastos2.php?idg=".$row['ID']."'><img src='img//icons/review.png'></a></td></tr>";
        }
    }
    
?>

</table>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>