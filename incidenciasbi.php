<?php
    $hoy=date('Y-m-d');
    $location='S';
    $grafica='in';  
    $yy=date('Y');
    $periodo=date("n",strtotime($fini."- 1 month"));
    $periodoant=$periodo-1;
    require_once 'cn/cn.php';
    if (!empty($_POST)) {
        $queryResult=$pdo->query("SELECT * from Intranet.filtros_bi where valor=$_POST[col]");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $ffininci=$row['ffin'];
                $finiinci=$row['fini'];
                $textoinci=$row['texto'];
                
                
            }
        $yy=date("Y", strtotime($ffininci));
        $periodo=date("n", strtotime($ffininci));
        $periodoant=date("n",strtotime($ffininci."- 1 month"));
        
        

    }else {
        $yyinici=date('Y');
        $fechaini = new DateTime();
        $fechaini->modify('first day of this month');
        $finiinci = $fechaini->format('Y-m-d'); 
        $fechafin = new DateTime();
        $fechafin->modify('last day of this month');
        $ffininci = $fechafin->format('Y-m-d'); 

    }
    require_once 'cargarbi.php';
    require_once 'header.php';
    //////inicio de contenido
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

<?php
    /////fin de contenido
    
    require_once 'footer.php';
?>
