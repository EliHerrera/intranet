<?php
    require_once 'header.php';
    //////inicio de contenido
    if(!empty($_GET['idpj'])){
    $queryResult=$pdo->query("SELECT A.proyecto, A.descripcion, CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as own FROM Intranet.scr_project A INNER JOIN sibware.personal B ON A.id_owner=B.ID WHERE A.ID=$_GET[idpj]");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $proyecto=$row['proyecto'];
            $desc=$row['descripcion'];
            $own=$row['own'];
            
        }
    }
?>  
<h3>Gestion de Proyectos</h3><a href="addtask.php" class="button">BackLogs</a>  
<table class="table">
    <tr><th>Proyecto</th><th>Descripcion</th><th>Product Owner</th></tr>
    <?php echo "<tr><td>".$proyecto."</td><td>".$desc."</td><td>".$own."</td></tr>"; ?>
</table>
<h4>Backlogs</h4>
<table class="table">
    <tr><th>Descripcion</th><th>Asignacion</th><th>Tester</th><th>Fecha Final Propuesta</th><th>Status</th></tr>
    <?php
        $queryResult=$pdo->query("SELECT A.descripcion,CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as tester,A.ffinal_propuesta,A.status FROM Intranet.scr_backlog A INNER JOIN sibware.personal B ON A.ID_tester=B.ID WHERE A.ID_project=$GET[idpj]");
        var_dump($queryResult);
    ?>
</table>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
