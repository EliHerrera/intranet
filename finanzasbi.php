<?php
    $hoy=date('Y-m-d');
    $location='S';
    $grafica='fi';  
    $yy=date('Y');
    $periodo=date("n",strtotime($fini."- 1 month"));
    $periodoant=$periodo-1;
    require_once 'cn/cn.php';
    if (!empty($_POST)) {
        $queryResult=$pdo->query("SELECT * from Intranet.filtros_bi where valor=$_POST[col]");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $ffin=$row['ffin'];
                $fini=$row['fini'];
            }
        $yy=date("Y", strtotime($fini));
        $periodo=date("n", strtotime($fini));
        $periodoant=date("n",strtotime($fini."- 1 month"));
        
        

    }
    require_once 'cargarbi.php';
    require_once 'header.php';
    //////inicio de contenido
    require 'estiloconst.php'; 
    require 'menubi.php';
    

?>  
    <div id="fi"></div>
    <form action="" method="post">
    <div class="row">
        <div class="col-xs-3">
            <label for="col">Filtrar por :</label><select name="col" id="col" class="form-control" onchange="this.form.submit();return false;">
                <option value="">Seleccione...</option>
                <?PHP
                    $queryResult=$pdo->query("SELECT
                    *
                FROM
                    Intranet.filtros_bi A
                INNER JOIN Intranet.ponderacion B ON A.yy = B.yy AND A.periodo=B.periodo
                WHERE
                    A.lActivo = 'S'");
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
