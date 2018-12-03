<?php
    if (!empty($_GET['date'])) {
        $hoy=$_GET['date'];
        
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
<div class="col-xs-1">
            <a href="carterabivpeje.php" class="button">Regresar</a>
</div>
<div class="col-xs-2">
            <input type="button" name="imprimir" value="Imprimir"  onClick="window.print();" class="button" />
</div>
<form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
        <div class="col-xs-1">
            <a href="#"><img src="img/icons/export_to_excel.png" class="botonExcel" alt="expor to excel" /></a>
        <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
        </div>
        </form>
<table class="table" id="Exportar_a_Excel">
<tr><th>Ejecutivo</th><th>Cliente</th><th>Folio</th><th>Tipo Cte</th><th>Saldo</th><th>Sucursal</th></tr>
<?php
    if (empty($_GET['ideje'])) {
        $queryResultcatejeVP=$pdo->query("SELECT
        CONCAT(
            C.Nombre,
            ' ',
            C.Apellido1,
            ' ',
            C.Apellido2
        ) AS Ejecutivo,
        CONCAT(
            B.Nombre,
            ' ',
            B.Apellido1,
            ' ',
            B.Apellido2
        ) AS Cliente,
        CONCAT('VP-', LPAD(D.Folio, 6, 0)) AS Folio,
        SUM(A.SaldoCap) + SUM(A.SaldoInt) + SUM(A.SaldoIvaInt) AS Saldo,
        SUM(A.SaldoMora) + SUM(A.SaldoIvaMora) AS moras,
        A.IDEjecutivo,
        A.IDCliente,
        E.Nombre
        FROM
        sibware.3_dw_images_vp A
        INNER JOIN sibware.3_cliente B ON A.IDCliente = B.ID
        INNER JOIN sibware.personal C ON A.IDEjecutivo = C.ID
        INNER JOIN sibware.3_vp_contrato D ON A.IDContrato = D.ID
        INNER JOIN sibware.sucursal E ON A.IDSucursal=E.ID
        WHERE
        A.FImage = '$hoy'
        AND D.IDMoneda = 1
        AND D. STATUS <> 'C'
        AND D. STATUS <> '-'
        AND D. STATUS <> 'P'
        GROUP BY
        D.ID");
    }elseif (!empty($_GET['ideje'])) {
        $queryResultcatejeVP=$pdo->query("SELECT
        CONCAT(
            C.Nombre,
            ' ',
            C.Apellido1,
            ' ',
            C.Apellido2
        ) AS Ejecutivo,
        CONCAT(
            B.Nombre,
            ' ',
            B.Apellido1,
            ' ',
            B.Apellido2
        ) AS Cliente,
        CONCAT('VP-', LPAD(D.Folio, 6, 0)) AS Folio,
        SUM(A.SaldoCap) + SUM(A.SaldoInt) + SUM(A.SaldoIvaInt) AS Saldo,
        SUM(A.SaldoMora) + SUM(A.SaldoIvaMora) AS moras,
        A.IDEjecutivo,
        A.IDCliente,
        E.Nombre
        FROM
        sibware.3_dw_images_vp A
        INNER JOIN sibware.3_cliente B ON A.IDCliente = B.ID
        INNER JOIN sibware.personal C ON A.IDEjecutivo = C.ID
        INNER JOIN sibware.3_vp_contrato D ON A.IDContrato = D.ID
        INNER JOIN sibware.sucursal E ON A.IDSucursal=E.ID
        WHERE
        A.FImage = '$hoy'
        AND D.IDMoneda = 1
        AND D. STATUS <> 'C'
        AND D. STATUS <> '-'
        AND D. STATUS <> 'P'
        AND A.IDEjecutivo=$_GET[ideje]
        GROUP BY
        D.ID");
    }
    
 while ($row=$queryResultcatejeVP->fetch(PDO::FETCH_ASSOC)) {
     echo "<tr><td>".$row['Ejecutivo']."</td><td>".$row['Folio']."</td><td>".$row['Cliente']."</td><td>".$row['Tipo']."</td><td>".number_format($row['Saldo'],2)."</td><td>".$row['Nombre']."</td></tr>";
 }   
?>
</table>

<?php
    /////fin de contenido
    require_once 'footer.php';
?>