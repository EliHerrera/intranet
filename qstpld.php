<?php
    require_once 'header.php';
    //////inicio de contenido
?> 
<h3>Cuestionarios PLD</h3>
<div class="row">
    <div class="col-xs-3">
        <a href="addqst.php" class="button">Administrar</a>
    </div>
   
</div>
<table class="table">
<tr><th>No.</th><th>Clave</th><th>No. de Preguntas</th><th>Integrantes</th></tr>
<?PHP
    $queryResult = $pdo->query("SELECT * FROM Intranet.PLD_Qst");
    while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $fila++;
        echo "<tr><td>".$fila."</td><td>".$row['codigo']."</td><td>".$row['no_preguntas']."</td><td>0</td></tr>";
    }
?>
</table>

<?php
    /////fin de contenido
    require_once 'footer.php';
?>