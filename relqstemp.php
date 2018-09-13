<?php
    require_once 'header.php';
    //////inicio de contenido
    $periodo=date('Y');
    if (!empty($_GET)) {
        $queryResult = $pdo->query("SELECT ID,codigo FROM Intranet.PLD_Qst WHERE ID=$_GET[idqst]");
        while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $codigo=$row['codigo'];
            $idqst=$row['ID'];
        }
    }
?>    
<h3>Integrantes de Examen : <?PHP echo $codigo ?></h3><a href="relqst.php" class="button">Asignar</a><a href="qstpld.php" class="button">Regresar</a>
<table class="table">
<tr><th>No.</th><th>Examen</th><th>Empleado</th><th>Calificacion</th></tr>
<?PHP
    $queryResult = $pdo->query("SELECT B.codigo,CONCAT(C.Nombre,' ',C.Apellido1,' ',C.Apellido2) as Emp ,A.Calf from Intranet.RelQst A INNER JOIN Intranet.PLD_Qst B on A.IDQst=B.ID INNER JOIN sibware.personal C on A.IDPersonal=C.ID WHERE A.IDQst=$idqst AND A.periodo=$periodo");
    while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $fila++;
        echo "<tr><td>".$fila."</td><td>".$row['codigo']."</td><td>".$row['Emp']."</td><td>".$row['Calf']."</td></tr>";
    }
?>
</table>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
