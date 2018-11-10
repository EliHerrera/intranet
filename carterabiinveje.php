<?php
    if (!empty($_POST['hoy'])) {
        $hoy=$_POST['hoy'];
        
    }else{
        $hoy=date('Y-m-d');
    }
    $location='carteraejeinv';    
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
  <div  id="carterainveje"></div>
  
</div>
<form action="carterabiinveje.php" method="post">
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
    $queryResultcateje=$pdo->query("SELECT
    CONCAT(
        C.Nombre,
        ' ',
        C.Apellido1,
        ' ',
        C.Apellido2
    ) AS Ejecutivo,
    SUM(A.SaldoProm) + SUM(A.SaldoInt) - SUM(A.SaldoRet) AS Saldo,
    A.IDEjecutivo,
    A.IDCliente
FROM
    sibware.2_dw_images_in A
INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
INNER JOIN sibware.personal C ON A.IDEjecutivo = C.ID
INNER JOIN sibware.2_prestamos D ON A.IDCliente = B.ID
WHERE
    A.FImage = '$hoy'
AND D.IDMoneda = 1
GROUP BY
    C.ID");
         while ($row=$queryResultcateje->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>".$row['Ejecutivo']."</td><td>".number_format($row['Saldo'],2)."</td></tr>";
        }  
    ?>

</table>

<?php
    /////fin de contenido
    require_once 'footer.php';
?>