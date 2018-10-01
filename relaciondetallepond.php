<?php
    require_once 'header.php';
    //////inicio de contenido
    $tipo=$_GET['tipo'];
    $periodo=$_GET['periodo'];
    $yy=$_GET['yy'];
    switch ($tipo) {
        case 1:
            $queryResult=$pdo->query("SELECT
            CONCAT(
                B.Nombre,
                ' ',
                B.Apellido1,
                ' ',
                B.Apellido2
            ) AS Cliente,
            CONCAT('CR-', LPAD(C.Folio, 6, 0)) AS Folio,
            D.Renglon,
            A.SaldoCap,
            A.Tasa,
            A.PAdicional,
            A.TasaTot,
            A.Interes,
            A.InteresFND
        FROM
            Intranet.relacion_tasa_pond A
        INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
        INNER JOIN sibware.2_contratos C ON A.IDContrato = C.ID
        INNER JOIN sibware.2_contratos_disposicion D ON A.IDDisposicion = D.ID
        WHERE
            A.Producto = 'CR'
        AND A.IDMoneda = 1
        AND A.Empresa = 'CMU'
        AND A.Periodo = $periodo
        AND A.yy = $yy");
            break;
        case 2:
            $queryResult=$pdo->query("SELECT
            CONCAT(
                B.Nombre,
                ' ',
                B.Apellido1,
                ' ',
                B.Apellido2
            ) AS Cliente,
            CONCAT('CR-', LPAD(C.Folio, 6, 0)) AS Folio,
            D.Renglon,
            A.SaldoCap,
            A.Tasa,
            A.PAdicional,
            A.TasaTot,
            A.Interes,
            A.InteresFND
        FROM
            Intranet.relacion_tasa_pond A
        INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
        INNER JOIN sibware.2_contratos C ON A.IDContrato = C.ID
        INNER JOIN sibware.2_contratos_disposicion D ON A.IDDisposicion = D.ID
        WHERE
            A.Producto = 'CR'
        AND A.IDMoneda = 1
        AND A.Empresa = 'CMU'
        AND A.Periodo = $periodo
        AND A.yy = $yy");
            break;
        default:
        echo "<div class='alert alert-danger'>";
        echo "    <strong>Aviso!</strong> No existe Informacion Para Mostrar";
        echo "</div>";
            break;
    }
?> 
<div class="row">
    <div class="col-xs-3">
        <a href="ponderacion.php" class="button">Regresar</a>
        <a href="#" class="button">Imprimir</a>
    </div>
</div>   

<table class="table">
<tr><th>No.</th><th>Cliente</th><th>Folio</th><th>Disp</th><th>Saldo Capital</th><th>Tasa</th><th>S.T.</th><th>Tasa T.</th><th>Interes</th><th>Interes FND</th></tr>
<?PHP
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $fila++;
        echo "<tr><td>".$fila."</td><td>".$row['Cliente']."</td><td>".$row['Folio']."</td><td>".$row['Renglon']."</td><td>".number_format($row['SaldoCap'],2)."</td><td>".$row['Tasa']."</td><td>".$row['PAdicional']."</td><td>".$row['TasaTot']."</td><td>".number_format($row['Interes'],2)."</td><td>".number_format($row['InteresFND'],2)."</td></tr>";
    }
?>
</table>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
