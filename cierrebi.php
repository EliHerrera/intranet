<?php
    $location="cierrebi";
    require_once 'headerbi.php';
    require 'estiloconst.php'; 
    require 'menubi.php';
?>

    <div style="width: 600px; height: 400px; margin: 0 auto">
	<div id="container-inv" style="width: 300px; height: 200px; float: left"></div>
    <div id="container-col" style="width: 300px; height: 200px; float: left"></div>
    <div id="container-ap" style="width: 300px; height: 200px; float: left"></div>
	<div id="container-vp" style="width: 300px; height: 200px; float: left"></div>
</div>
    <form action="cierrebi.php" method="post">
    <div class="row">
        <div class="col-xs-3">
            <label for="col">Filtrar por :</label><select name="col" id="col" class="form-control" onchange="this.form.submit();return false;">
                <option value="">Seleccione...</option>
                <?PHP
                    $queryResult=$pdo->query("SELECT * FROM Intranet.filtros_bi WHERE lActivo='S'");
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='".$row['valor']."'>".$row['texto']."</option>";
                    }
                ?> 
            </select>
        </div>
        <div class="col-xs-2">
            <br><input type="button" name="imprimir" value="Imprimir"  onClick="window.print();" class="button" />
        </div>
    </div>
</form>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
