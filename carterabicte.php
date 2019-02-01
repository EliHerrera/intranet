<?php
     
    require_once 'headerbi.php';
    //////inicio de contenido
    //consulta tipo de cambio
    
    require 'estiloconst.php'; 
    require 'menubi.php';
    if (!empty($_POST['hoy'])) {
        $hoy=$_POST['hoy'];
        
    }
    $queryResult=$pdo->query("SELECT * FROM sibware.indicador_tipocambio WHERE Fecha='$hoy'");
    #var_dump($queryResult);
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $tc=$row['Paridad'];
    }//consulta tipo de cambio
    
?>
<h3>Relacion de Clientes al dia <?php echo $hoy; ?> </h3> 
<form action="carterabicte.php" method="post">
    <div class="row">
        <div class="col-xs-3">
            <a href="carterabi2.php" class="button">Regresar</a>
        </div>
        <div class="col-xs-3">            
           <label for="hoy">Buscar</label> <input type="date" name="hoy" id="hoy" class="form-control" required="true">
        </div>
</form>        
        <div class="col-xs-1">    
            <br><input type="submit" value="Buscar" class="button">
        </div>
        <form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
        <div class="col-xs-2">
        <br><a href="#"><img src="img/icons/export_to_excel.png" class="botonExcel" alt="expor to excel" /></a>
        <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
        </div>
        </form>
    </div>


<table class="table" id="Exportar_a_Excel">   
    <tr><th>Producto</th><th>Folio</th><th>Estatus</th><th>Cliente</th><th>Tipo Cte</th><th>Saldo</th><th>Moratorios</th><th>Ejectutivo</th><th>Sucursal</th></tr>
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
        B.IDMoneda,
        G.tipo as tipocte
    FROM
        sibware.2_dw_images_contratos A
    INNER JOIN sibware.2_contratos B ON A.IDContrato = B.ID
    INNER JOIN sibware.2_cliente C ON A.IDCliente = C.ID
    INNER JOIN sibware.2_entorno_tipocredito D ON B.IDTipoCredito = D.ID
    INNER JOIN sibware.personal E ON C.IDEjecutivo = E.ID
    INNER JOIN sibware.sucursal F ON C.IDSucursal = F.ID
    INNER JOIN sibware.2_entorno_tipocliente G ON C.IDTipoCliente=G.ID
    WHERE
        FImage = '$hoy'
    AND B. STATUS <> 'C'
    AND B. STATUS <> '-'
    GROUP BY
        A.IDContrato
    HAVING Saldo>0 ");
        
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
            echo "<tr><td>".$row['tipo']."</td><td>".$row['Folio']."</td><td>".$row['STATUS']."</td><td>".$row['Cliente']."</td><td>".$row['tipocte']."</td><td>".number_format($saldo,2)."</td><td>".number_format($moras,2)."</td><td>".$row['Ejecutivo']."</td><td>".$row['Sucursal']."</td></tr>";
        }
        $queryResult=$pdo->query("SELECT
        
        CONCAT(
            C.Nombre,
            ' ',
            C.Apellido1,
            ' ',
            C.Apellido2
        ) AS Cliente,
        CONCAT('AP-', LPAD(B.Folio, 6, 0)) AS Folio,
        CASE B. STATUS WHEN 'A' THEN 'ACTIVO' WHEN 'P' THEN 'Pagado' WHEN 'J' THEN 'Juridico' ELSE 'Otro' END as STATUS,
        SUM(A.SaldoRenta) + SUM(A.SaldoIvaRenta) AS Saldo, SUM(A.SaldoMora) + SUM(A.SaldoIvaMora)  as moras,
        CONCAT(
            E.Nombre,
            ' ',
            E.Apellido1,
            ' ',
            E.Apellido2
        ) AS Ejecutivo,
        F.Nombre as Sucursal,
        B.IDMoneda,
        G.tipo as tipocte
    FROM
        sibware.2_dw_images_ap A
    INNER JOIN sibware.2_ap_contrato B ON A.IDContrato = B.ID
    INNER JOIN sibware.2_cliente C ON A.IDCliente = C.ID
    INNER JOIN sibware.personal E ON C.IDEjecutivo = E.ID
    INNER JOIN sibware.sucursal F ON C.IDSucursal = F.ID
    INNER JOIN sibware.2_entorno_tipocliente G ON C.IDTipoCliente=G.ID
    WHERE
        FImage = '$hoy'
    AND B. STATUS <> 'C'
    AND B. STATUS <> '-'
    GROUP BY
        A.IDContrato
    HAVING Saldo>0 ");
        
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
            echo "<tr><td>APU</td><td>".$row['Folio']."</td><td>".$row['STATUS']."</td><td>".$row['Cliente']."</td><td>".$row['tipocte']."</td><td>".number_format($saldo,2)."</td><td>".number_format($moras,2)."</td><td>".$row['Ejecutivo']."</td><td>".$row['Sucursal']."</td></tr>";
        }
        $queryResult=$pdo->query("SELECT
        
        CONCAT(
            C.Nombre,
            ' ',
            C.Apellido1,
            ' ',
            C.Apellido2
        ) AS Cliente,
        CONCAT('AP-', LPAD(B.Folio, 6, 0)) AS Folio,
        CASE B. STATUS WHEN 'A' THEN 'ACTIVO' WHEN 'P' THEN 'Pagado' WHEN 'J' THEN 'Juridico' ELSE 'Otro' END as STATUS,
        SUM(A.SaldoRenta) + SUM(A.SaldoIvaRenta) AS Saldo, SUM(A.SaldoMora) + SUM(A.SaldoIvaMora)  as moras,
        CONCAT(
            E.Nombre,
            ' ',
            E.Apellido1,
            ' ',
            E.Apellido2
        ) AS Ejecutivo,
        F.Nombre as Sucursal,
        B.IDMoneda,
        G.tipo as tipocte
    FROM
        sibware.3_dw_images_ap A
    INNER JOIN sibware.3_ap_contrato B ON A.IDContrato = B.ID
    INNER JOIN sibware.3_cliente C ON A.IDCliente = C.ID
    INNER JOIN sibware.personal E ON C.IDEjecutivo = E.ID
    INNER JOIN sibware.sucursal F ON C.IDSucursal = F.ID
    INNER JOIN sibware.3_entorno_tipocliente G ON C.IDTipoCliente=G.ID
    WHERE
        FImage = '$hoy'
    AND B. STATUS <> 'C'
    AND B. STATUS <> '-'
    GROUP BY
        A.IDContrato
    HAVING Saldo>0");
        
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
            echo "<tr><td>AP</td><td>".$row['Folio']."</td><td>".$row['STATUS']."</td><td>".$row['Cliente']."</td><td>".$row['tipocte']."</td><td>".number_format($saldo,2)."</td><td>".number_format($moras,2)."</td><td>".$row['Ejecutivo']."</td><td>".$row['Sucursal']."</td></tr>";
        }    
        $queryResult=$pdo->query("SELECT
        
        CONCAT(
            C.Nombre,
            ' ',
            C.Apellido1,
            ' ',
            C.Apellido2
        ) AS Cliente,
        CONCAT('VP-', LPAD(B.Folio, 6, 0)) AS Folio,
        CASE B. STATUS WHEN 'A' THEN 'ACTIVO' WHEN 'P' THEN 'Pagado' WHEN 'J' THEN 'Juridico' ELSE 'Otro' END as STATUS,
        SUM(A.SaldoCap) + SUM(A.SaldoInt) + SUM(A.SaldoIvaInt) AS Saldo, SUM(A.SaldoMora) + SUM(A.SaldoIvaMora)  as moras,
        CONCAT(
            E.Nombre,
            ' ',
            E.Apellido1,
            ' ',
            E.Apellido2
        ) AS Ejecutivo,
        F.Nombre as Sucursal,
        B.IDMoneda,
        G.tipo as tipocte
    FROM
        sibware.3_dw_images_vp A
    INNER JOIN sibware.3_vp_contrato B ON A.IDContrato = B.ID
    INNER JOIN sibware.3_cliente C ON A.IDCliente = C.ID
    INNER JOIN sibware.personal E ON C.IDEjecutivo = E.ID
    INNER JOIN sibware.sucursal F ON C.IDSucursal = F.ID
    INNER JOIN sibware.2_entorno_tipocliente G ON C.IDTipoCliente=G.ID
    WHERE
        FImage = '$hoy'
    AND B. STATUS <> 'C'
    AND B. STATUS <> '-'
    GROUP BY
        A.IDContrato
    HAVING Saldo>0    ");
        
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
            echo "<tr><td>VP</td><td>".$row['Folio']."</td><td>".$row['STATUS']."</td><td>".$row['Cliente']."</td><td>".$row['tipocte']."</td><td>".number_format($saldo,2)."</td><td>".number_format($moras,2)."</td><td>".$row['Ejecutivo']."</td><td>".$row['Sucursal']."</td></tr>";
        }
            
    ?>

</table>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>