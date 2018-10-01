<?php
    require_once 'header.php';
    //////inicio de contenido
    $tipo=$_GET['tipo'];
    $periodo=$_GET['periodo'];
    $yy=$_GET['yy'];
    switch ($tipo) {
        case 1:
            $titulo='ACTIVA TOTAL';
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
            $titulo='ACTIVA VIGENTE';    
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
        AND A.TipoCartera='G'
        AND A.Periodo = $periodo
        AND A.yy = $yy");
            break;
        case 3:
            $titulo='FINANCIAMIENTO RURAL';    
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
        AND D.IDOrigenRecursos=2
        AND A.Periodo = $periodo
        AND A.yy = $yy");
            break;
        case 4:
            $titulo='CARTERA EN DLS';    
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
        AND A.IDMoneda = 2
        AND A.Empresa = 'CMU'
        AND A.Periodo = $periodo
        AND A.yy = $yy");
            break;
        case 5:
            $titulo='ACTIVA TOTAL S/PR';    
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
        AND B.IDTipoCliente<>2
        AND A.Periodo = $periodo
        AND A.yy = $yy");
            break;
        case 6:
            $titulo='ACTIVA VIGENTE S/PR';    
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
        AND A.TipoCartera='G'
        AND B.IDTipoCliente<>2
        AND A.Periodo = $periodo
        AND A.yy = $yy");
            break;
        case 7:
        $titulo='FINANCIAMIENTO RURAL S/PR';    
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
        AND D.IDOrigenRecursos=2
        AND B.IDTipoCliente<>2
        AND A.Periodo = $periodo
        AND A.yy = $yy");
            break;
        case 8:
        $titulo='CARTERA EN DLS S/PR';    
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
        AND A.IDMoneda = 2
        AND A.Empresa = 'CMU'
        AND B.IDTipoCliente<>2
        AND A.Periodo = $periodo
        AND A.yy = $yy");
            break;
        case 9:
            $titulo='PASIVA MN';    
            $queryResult=$pdo->query("SELECT
            CONCAT(
                B.Nombre,
                ' ',
                B.Apellido1,
                ' ',
                B.Apellido2
            ) AS Cliente,
            CONCAT(LPAD(C.Folio, 6, 0)) AS Folio,
            A.SaldoCap,
            A.Tasa,
            A.PAdicional,
            A.TasaTot,
            A.Interes,
            A.InteresFND
        FROM
            Intranet.relacion_tasa_pond A
        INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
        INNER JOIN sibware.2_prestamos C ON A.IDContrato = C.ID
        WHERE
        A.Producto = 'IN'
        AND A.IDMoneda = 1
        AND A.Empresa = 'CMU'
        AND A.Periodo = $periodo
        AND A.yy = $yy");
            break;   
        case 10:
        $titulo='PASIVA MN S/PR';    
            $queryResult=$pdo->query("SELECT
            CONCAT(
                B.Nombre,
                ' ',
                B.Apellido1,
                ' ',
                B.Apellido2
            ) AS Cliente,
            CONCAT(LPAD(C.Folio, 6, 0)) AS Folio,
            A.SaldoCap,
            A.Tasa,
            A.PAdicional,
            A.TasaTot,
            A.Interes,
            A.InteresFND
        FROM
            Intranet.relacion_tasa_pond A
        INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
        INNER JOIN sibware.2_prestamos C ON A.IDContrato = C.ID
        WHERE
        A.Producto = 'IN'
        AND A.IDMoneda = 1
        AND A.Empresa = 'CMU'
        AND B.IDTipoCliente<>2
        AND A.Periodo = $periodo
        AND A.yy = $yy");
            break;
        case 11:
            $titulo='PASIVA DLS';    
            $queryResult=$pdo->query("SELECT
            CONCAT(
                B.Nombre,
                ' ',
                B.Apellido1,
                ' ',
                B.Apellido2
            ) AS Cliente,
            CONCAT(LPAD(C.Folio, 6, 0)) AS Folio,
            A.SaldoCap,
            A.Tasa,
            A.PAdicional,
            A.TasaTot,
            A.Interes,
            A.InteresFND
        FROM
            Intranet.relacion_tasa_pond A
        INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
        INNER JOIN sibware.2_prestamos C ON A.IDContrato = C.ID
        WHERE
        A.Producto = 'IN'
        AND A.IDMoneda = 2
        AND A.Empresa = 'CMU'
        AND A.Periodo = $periodo
        AND A.yy = $yy");
            break;   
        case 12:
            $titulo='PASIVA EN DLS S/PR';    
            $queryResult=$pdo->query("SELECT
            CONCAT(
                B.Nombre,
                ' ',
                B.Apellido1,
                ' ',
                B.Apellido2
            ) AS Cliente,
            CONCAT(LPAD(C.Folio, 6, 0)) AS Folio,
            A.SaldoCap,
            A.Tasa,
            A.PAdicional,
            A.TasaTot,
            A.Interes,
            A.InteresFND
        FROM
            Intranet.relacion_tasa_pond A
        INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
        INNER JOIN sibware.2_prestamos C ON A.IDContrato = C.ID
        WHERE
        A.Producto = 'IN'
        AND A.IDMoneda = 2
        AND A.Empresa = 'CMU'
        AND B.IDTipoCliente<>2
        AND A.Periodo = $periodo
        AND A.yy = $yy");
            break;     
        case 13:
            $titulo='VENTA A PLAZO';    
            $queryResult=$pdo->query("SELECT
            CONCAT(
                B.Nombre,
                ' ',
                B.Apellido1,
                ' ',
                B.Apellido2
            ) AS Cliente,
            CONCAT('VP-', LPAD(C.Folio, 6, 0)) AS Folio,
            A.SaldoCap,
            A.Tasa,
            A.PAdicional,
            A.TasaTot,
            A.Interes,
            A.InteresFND
        FROM
            Intranet.relacion_tasa_pond A
        INNER JOIN sibware.3_cliente B ON A.IDCliente = B.ID
        INNER JOIN sibware.3_vp_contrato C ON A.IDContrato = C.ID
        WHERE
        A.Producto = 'VP'
        AND A.IDMoneda = 1
        AND A.Empresa = 'CMA'
        AND A.Periodo = $periodo
        AND A.yy = $yy");
            break;
        case 14:
            $titulo='VENTA A PLAZO S/PR';    
            $queryResult=$pdo->query("SELECT
            CONCAT(
                B.Nombre,
                ' ',
                B.Apellido1,
                ' ',
                B.Apellido2
            ) AS Cliente,
            CONCAT('VP-', LPAD(C.Folio, 6, 0)) AS Folio,
            A.SaldoCap,
            A.Tasa,
            A.PAdicional,
            A.TasaTot,
            A.Interes,
            A.InteresFND
        FROM
            Intranet.relacion_tasa_pond A
        INNER JOIN sibware.3_cliente B ON A.IDCliente = B.ID
        INNER JOIN sibware.3_vp_contrato C ON A.IDContrato = C.ID
        WHERE
        A.Producto = 'VP'
        AND A.IDMoneda = 1
        AND A.Empresa = 'CMA'
        AND B.IDTipoCliente<>2
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
        <input type="button" name="imprimir" value="Imprimir"  onClick="window.print();" class="button" />
    </div>
</div>   
<h3>Relacion Detallada <?PHP echo $titulo." ".date("M-Y", mktime(0, 0, 0, $periodo, 1, $yy)); ?></h3>
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
