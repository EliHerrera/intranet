<?php
    if (!empty($_GET['hoy'])) {
        $hoy=$_GET['hoy'];
        
    }else{
        $hoy=date('Y-m-d');
    }
    require_once 'headerbi.php';
    //////inicio de contenido
    //consulta tipo de cambio
    $queryResult=$pdo->query("SELECT * FROM sibware.indicador_tipocambio WHERE Fecha='$hoy'");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $tc=$row['Paridad'];
    }//consulta tipo de cambio
    require 'estiloconst.php'; 
    require 'menubi.php';
###inicio conetnido    
?>
<h3>Relacion de Cartera de Inversionistas a la fecha <?php echo $hoy; ?></h3>
<div class="col-xs-2">
            <a href="carterabiinveje.php" class="button">Regresar</a>
</div>
<div class="col-xs-2">
            <input type="button" name="imprimir" value="Imprimir"  onClick="window.print();" class="button" />
</div>
<table class="table">
</table>

<?php
    /////fin de contenido
    require_once 'footer.php';
?>