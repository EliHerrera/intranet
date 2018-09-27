<?php
    if (empty($_POST)) {
        require_once 'cargarbi.php';
    } 
    
    require_once 'header.php';
    //////inicio de contenido
    require 'estiloconst.php'; 
    require 'menubi.php';
?>
<?PHP
    if (empty($_POST)) {
        echo "<div id='totCat'></div>";
    }
    
?>
<form action="" method="post">
    <div class="row">
        <div class="col-xs-3">
            <label for="col">Filtrar por :</label><select name="col" id="col" class="form-control" onchange="this.form.submit();return false;">
                <option value="">Seleccione...</option>
                <option value="1">Clientes...</option>
            </select>
        </div>
    </div>
</form>
<?PHP if ($_POST['col']==1) {
    $hoy=date('Y-m-d');
?> 
<table class="table">   
    <tr><th>Producto</th><th>Folio</th><th>Estatus</th><th>Cliente</th><th>Saldo</th><th>Ejectutivo</th><th>Sucursal</th></tr>
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
        SUM(A.SaldoCap) + SUM(A.SaldoInt) AS Saldo,
        CONCAT(
            E.Nombre,
            ' ',
            E.Apellido1,
            ' ',
            E.Apellido2
        ) AS Ejecutivo,
        F.Nombre as Sucursal
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

            echo "<tr><td>".$row['tipo']."</td><td>".$row['Folio']."</td><td>".$row['STATUS']."</td><td>".$row['Cliente']."</td><td>".number_format($row['Saldo'],2)."</td><td>".$row['Ejecutivo']."</td><td>".$row['Sucursal']."</td></tr>";
        }
    ?>

</table>
    <?PHP } ?>       
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
