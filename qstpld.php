<?php
    require_once 'header.php';
    //////inicio de contenido
    $periodo=date('Y');
?> 
<h3>Cuestionarios PLD</h3>
<div class="row">
    <div class="col-xs-3">
        <a href="addqst.php" class="button">Administrar</a>
   
        <a href="relqst.php" class="button">Asignar</a>
    </div>
   
</div>
<table class="table">
<tr><th>No.</th><th>Clave</th><th>No. de Preguntas</th><th>Integrantes</th></tr>
<?PHP
    $queryResult = $pdo->query("SELECT * FROM Intranet.PLD_Qst");
    while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $fila++;
        $queryResult2 = $pdo->query("SELECT * FROM Intranet.RelQst WHERE IDQst=$row[ID] AND periodo=$periodo");
        $row_count = $queryResult2->rowCount(); 
        echo "<tr><td>".$fila."</td><td>".$row['codigo']."</td><td>".$row['no_preguntas']."</td><td><a href='relqstemp.php?idqst=".$row['ID']."'>".$row_count."</a></td></tr>";
    }
?>
</table>

<?php
    /////fin de contenido   
    require_once 'footer.php';
?>