<?php
    $hoy=date('Y-m-d');
    $yy=date('Y');
    $periodo=date("n",strtotime($fini."- 1 month"));
    $periodoant=$periodo-1;
    require_once 'cn/cn.php';
    if (!empty($_POST['col'])) {
        $queryResult=$pdo->query("SELECT * from Intranet.filtros_bi where valor=$_POST[col]");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $ffin=$row['ffin'];
                $fini=$row['fini'];
                $texto=$row['texto'];
                
                
            }
        
        $yy=date("Y", strtotime($ffin));
        $periodo=date("n", strtotime($ffin));
        $periodoant=date("n",strtotime($ffin."- 1 month"));
        
        

    }else {
        // $yyinici=date('Y');
        // $fechaini = new DateTime();
        // $fechaini->modify('first day of this month');
        // $fini = $fechaini->format('Y-m-d'); 
        // $fechafin = new DateTime();
        // $fechafin->modify('last day of this month');
        // $ffin = $fechafin->format('Y-m-d'); 
        $fini='2018-01-01';
        $ffin='2018-12-31';
        $texto=date('Y');

    }
    $location="incidencias";
    require_once 'headerbi.php';
    require 'estiloconst.php'; 
    require 'menubi.php';
?> 
<div class="row">
  <div class='col-md-6' id="incidenciasn"></div>
  <div class='col-md-6' id="incidenciasr"></div>
</div>
<form action="" method="post">
    <div class="row">
        <div class="col-xs-3">
            <label for="col">Filtrar por :</label><select name="col" id="col" class="form-control" onchange="this.form.submit();return false;">
                <option value="">Seleccione...</option>
                <?PHP
                    $queryResultfil=$pdo->query("SELECT
                    *
                FROM
                    Intranet.filtros_bi A
                
                WHERE
                    A.lActivo = 'S' AND
                    A.periodo>0 AND
                    A.yy=$yy");
                    var_dump($queryResultfil);
                    while ($row=$queryResultfil->fetch(PDO::FETCH_ASSOC)) {
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
<table class="table">
<tr><th>Incidencias</th><th>Cantidad</th></tr>
<tr><td><a href="viewincidencia.php?b=a&fil=<?php echo $_POST['col'] ?>">Abiertos</a></td><td><a href="viewincidencia.php?b=a&fil=<?php echo $_POST['col'] ?>"><?php echo $tabiertos; ?></a></td></tr>
<tr><td><a href="viewincidencia.php?b=p&fil=<?php echo $_POST['col'] ?>">Procesos</a></td><td><a href="viewincidencia.php?b=p&fil=<?php echo $_POST['col'] ?>"><?php echo $tproceso; ?></a></td></tr>
<tr><td><a href="viewincidencia.php?b=c&fil=<?php echo $_POST['col'] ?>">Cerrados</a></td><td><a href="viewincidencia.php?b=c&fil=<?php echo $_POST['col'] ?>"><?php echo $tcerrados; ?></a></td></tr>
<tr><td><a href="viewincidencia.php?b=r&fil=<?php echo $_POST['col'] ?>">Riesgos</a></td><td><a href="viewincidencia.php?b=r&fil=<?php echo $_POST['col'] ?>"><?php echo $triesgo; ?></a></td></tr>
</table>

<?php
    /////fin de contenido
    
    require_once 'footer.php';
?>
