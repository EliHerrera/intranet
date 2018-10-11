<?php
    $hoy=date('Y-m-d');
    $location='S';
    $grafica='cr';    
    if (empty($_POST)) {
        require_once 'cargarbi.php';
    } 
    
    require_once 'header.php';
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
    if($_POST['col']==2){
        echo "<div id='carterafil'></div>";
        echo "<div id='carterafilEjeAPU' ></div>";
        echo "<div id='carterafilEjeAP'></div>";
        echo "<div id='carterafilEjeVP'></div>";
    }
    if($_POST['col']==3){
        echo "<div id='carterafilsuc'></div>";
        echo "<div id='carterafilSucAPU' ></div>";
        echo "<div id='carterafilSucAP'></div>";
        echo "<div id='carterafilSucVP'></div>";
    }
    if($_POST['col']==4){
        echo "<div id='carterafilpro'></div>";
    }
    
    
?>
<form action="" method="post">
    <div class="row">
        <div class="col-xs-3">
            <label for="col">Filtrar por :</label><select name="col" id="col" class="form-control" onchange="this.form.submit();return false;">
                <option value="">Seleccione...</option>
                <option value="1">Clientes</option>
                <option value="2">Ejecutivo</option>                
                <option value="3">Sucursal</option>                
                <option value="4">Producto</option>
            </select>
        </div>
        <div class="col-xs-2">
            <br><input type="button" name="imprimir" value="Imprimir"  onClick="window.print();" class="button" />
        </div>
    </div>
</form>
<?PHP if ($_POST['col']==1) {
    
?> 
<table class="table">   
    <tr><th>Producto</th><th>Folio</th><th>Estatus</th><th>Cliente</th><th>Saldo</th><th>Moratorios</th><th>Ejectutivo</th><th>Sucursal</th></tr>
    <?php
        $queryResult=$pdo->query("SELECT
        D.tipo,
        CONCAT(
            C.Nombre,
            ' ',
            C.Apellido1,
            ' ',
            C.Apellido2
        ) AS Cliente,
        CONCAT('CR-', LPAD(B.Folio, 6, 0)) AS Folio,
        CASE B. STATUS WHEN 'A' THEN 'ACTIVO' WHEN 'P' THEN 'Pagado' WHEN 'J' THEN 'Juridico' ELSE 'Otro' END as STATUS,
        SUM(A.SaldoCap) + SUM(A.SaldoInt) AS Saldo, SUM(A.SaldoMora) + SUM(A.SaldoIvaMora) + SUM(A.SaldoPena) + SUM(A.SaldoIvaPena) as moras,
        CONCAT(
            E.Nombre,
            ' ',
            E.Apellido1,
            ' ',
            E.Apellido2
        ) AS Ejecutivo,
        F.Nombre as Sucursal,
        B.IDMoneda
    FROM
        2_dw_images_contratos A
    INNER JOIN 2_contratos B ON A.IDContrato = B.ID
    INNER JOIN 2_cliente C ON A.IDCliente = C.ID
    INNER JOIN 2_entorno_tipocredito D ON B.IDTipoCredito = D.ID
    INNER JOIN personal E ON C.IDEjecutivo = E.ID
    INNER JOIN sucursal F ON C.IDSucursal = F.ID
    WHERE
        FImage = '$hoy'
    AND B. STATUS <> 'C'
    AND B. STATUS <> '-'
    AND B. STATUS <> 'P'
    GROUP BY
        A.IDContrato");
        
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            if ($row['IDMoneda']==2) {
                $saldo=$row['Saldo'];
                $saldo=$saldo*$tc;
                $moras=$row['moras'];
                $moras=$moras*$tc;

            }else {
                $saldo=$row['Saldo'];
                $moras=$row['moras'];
            }
            echo "<tr><td>".$row['tipo']."</td><td>".$row['Folio']."</td><td>".$row['STATUS']."</td><td>".$row['Cliente']."</td><td>".number_format($saldo,2)."</td><td>".number_format($moras,2)."</td><td>".$row['Ejecutivo']."</td><td>".$row['Sucursal']."</td></tr>";
        }
    ?>

</table>
    <?PHP } ?> 
    <?PHP if ($_POST['col']==2) {
       
    ?> 
    <table class="table">
        <tr><th>Ejecutivo</th><th>Saldos</th><th>Moratorios</th></tr>
  
    <?PHP
    while ($row=$queryResultcateje->fetch(PDO::FETCH_ASSOC)) { 
                
        echo "<tr><td>".$row['Ejecutivo']."</td><td>".$row['Saldo']."</td><td>".$row['moras']."</td></tr>";
    }
    
 } ?>
    </table>         
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
