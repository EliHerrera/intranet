<?php
    
    $location='cartera';    
    require_once 'headerbi.php';
    //////inicio de contenido
    //consulta tipo de cambio
    $queryResult=$pdo->query("SELECT * FROM sibware.indicador_tipocambio WHERE Fecha='$hoy'");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $tc=$row['Paridad'];
    }//consulta tipo de cambio
    require 'estiloconst.php'; 
    require 'menubi.php';
?>
<?PHP
    if (empty($_POST)) {
        echo "<div id='totCat'></div>";
    }
?>
<div class="row">
    <div class="col-xs-2">
        <a href="carterabieje.php" class="button">Ejecutivos</a>
    </div>
    <div class="col-xs-2">    
        <a href="#" class="button">Producto</a>
    </div>
    <div class="col-xs-2">
        <a href="#" class="button">Sucursal</a>
    </div>
    <div class="col-xs-2">
        <a href="carterabicte.php" class="button">Clientes</a>
    </div>
</div>    
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
