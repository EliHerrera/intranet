<?php
    if (!empty($_POST['hoy'])) {
        $hoy=$_POST['hoy'];
        
    }else{
        $hoy=date('Y-m-d');
    }
    $location='carteraejevp';    
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
<div class="row">
  <div  id="carteravpeje"></div>
  
</div>
<form action="carterabivpeje.php" method="post">
    <div class="row">
        <div class="col-xs-2">
            <a href="carterabieje.php" class="button">Regresar</a>
        </div>
        <div class="col-xs-3">
            <label for="hoy">Buscar</label>
            <input type="date" name="hoy" id="hoy" class="form-control" required="true">
        </div>
        <div class="col-xs-2">
            <br><input type="submit" class="button" value="Buscar">
        </div>
        

    </div>
</form>
<table class="table">
    <tr><th>Ejecutivo</th><th>Saldo</th></tr>
    <?php
$queryResultcatejeVP=$pdo->query("SELECT
CONCAT(
    C.Nombre,
    ' ',
    C.Apellido1,
    ' ',
    C.Apellido2
) AS Ejecutivo,
SUM(A.SaldoCap) + SUM(A.SaldoInt) + SUM(A.SaldoIvaInt) AS Saldo,
SUM(A.SaldoMora) + SUM(A.SaldoIvaMora) AS moras,
A.IDEjecutivo,
A.IDCliente
FROM
sibware.3_dw_images_vp A
INNER JOIN sibware.3_cliente B ON A.IDCliente = B.ID
INNER JOIN sibware.personal C ON A.IDEjecutivo = C.ID
INNER JOIN sibware.3_vp_contrato D ON A.IDContrato = D.ID
WHERE
A.FImage = '$hoy'
AND D.IDMoneda = 1
AND D. STATUS <> 'C'
AND D. STATUS <> '-'
AND D. STATUS <> 'P'
GROUP BY
C.ID");
       

         while ($row=$queryResultcatejeVP->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>".$row['Ejecutivo']."</td><td>".number_format($row['Saldo'],2)."</td></tr>";
        }  
    ?>

</table>

<?php
    /////fin de contenido
    require_once 'footer.php';
?>