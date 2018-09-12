<?php
    require_once 'header.php';
    //////inicio de contenido
    function generarCodigo($longitud) {
        $key = '';
        $pattern = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
        return $key;
       }
       $folio=generarCodigo(6);
       $folio="PLD-".$folio;
       if (!empty($_POST)) {
        $llave=generarCodigo(64);   
        $queryResult = $pdo->query("INSERT INTO Intranet.PLD_Qst (codigo,no_preguntas,llave,fecha) VALUES ('$_POST[clave]',$_POST[nopreguntas],'$llave','$hoy')");
        echo "<div class='alert alert-success'>";
        echo "    <strong>Exito!</strong> El Cuestionario ha sido creado con Exito! ahora debe asignar preguntas y respuestas en el icono";
        echo "</div>";
       }
?>    
<h3>Cuestionarios PLD</h3>
<form action="addqst.php" method="post">
<div class="row">
    <div class="col-xs-3">
        <label for="clave">clave</label><input type="text" name="clave" id="clave" class="form-control" readonly="true" value="<?PHP echo $folio ?>" required="true">
    </div>
    <div class="col-xs-2">
       <label for="nopreguntas">No. Preguntas</label><input type="number" name="nopreguntas" id="nopreguntas" class="form-control" min="0" max="10" required="true">
    </div>
    <div class="col-xs-3">
       <br><input type="submit" value="Agregar" class="button"><a href="qstpld.php" class="button">Regresar</a>
    </div>
</div>
</form>
<table class="table">
<tr><th>No.</th><th>Clave</th><th>No. de Preguntas</th><th>Acciones</th></tr>
<?PHP
    $queryResult = $pdo->query("SELECT * FROM Intranet.PLD_Qst");
    while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $fila++;
        echo "<tr><td>".$fila."</td><td>".$row['codigo']."</td><td>".$row['no_preguntas']."</td><td><a href='configqst.php?idqst=".$row['ID']."'><img src='img/icons/support.png'></a></td></tr>";
    }
?>
</table>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
