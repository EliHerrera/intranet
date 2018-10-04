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
        AND A.InteresFND>0
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
        AND A.InteresFND>0
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
        case 15:
            $titulo='FINANCIAMIENTO RURAL VIGENTE';    
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
        AND A.TipoCartera='G'
        AND A.InteresFND>0
        AND A.Periodo = $periodo
        AND A.yy = $yy");
            break; 
        case 16:
            $titulo='AP FUTUROS';    
            $queryResult=$pdo->query("SELECT
            CONCAT(
                B.Nombre,
                ' ',
                B.Apellido1,
                ' ',
                B.Apellido2
            ) AS Cliente,
            CONCAT('AP-', LPAD(C.Folio, 6, 0)) AS Folio,
            A.TRenta,
            A.TotalR,
            A.RentaR,
            A.RentaM,
            A.IVA,
            A.iTR,
            C.ValorBien,
            C.Deposito,
            D.SaldoFinal AS VR,
            A.iPC,
            A.TasaTot
        FROM
            Intranet.relacion_tasa_pond A
        INNER JOIN sibware.2_cliente B ON A.IDCLiente = B.ID
        INNER JOIN sibware.2_ap_contrato C ON A.IDContrato = C.ID
        INNER JOIN sibware.2_ap_valorresidual D ON A.IDContrato = D.IDContrato
        WHERE
            A.Producto = 'AP'
        AND A.IDMoneda = 1
        AND A.Empresa = 'CMU'
        AND A.Periodo = $periodo
        AND A.yy = $yy");
            break;  
        case 17:
            $titulo='AP FUTUROS S/PR';    
            $queryResult=$pdo->query("SELECT
            CONCAT(
                B.Nombre,
                ' ',
                B.Apellido1,
                ' ',
                B.Apellido2
            ) AS Cliente,
            CONCAT('AP-', LPAD(C.Folio, 6, 0)) AS Folio,
            A.TRenta,
            A.TotalR,
            A.RentaR,
            A.RentaM,
            A.IVA,
            A.iTR,
            C.ValorBien,
            C.Deposito,
            D.SaldoFinal AS VR,
            A.iPC,
            A.TasaTot
        FROM
            Intranet.relacion_tasa_pond A
        INNER JOIN sibware.2_cliente B ON A.IDCLiente = B.ID
        INNER JOIN sibware.2_ap_contrato C ON A.IDContrato = C.ID
        INNER JOIN sibware.2_ap_valorresidual D ON A.IDContrato = D.IDContrato
        WHERE
            A.Producto = 'AP'
        AND A.IDMoneda = 1
        AND A.Empresa = 'CMU'
        AND B.IDTipoCliente<>2
        AND A.Periodo = $periodo
        AND A.yy = $yy");
            break;  
        case 18:
            $titulo='AP FUTUROS';    
            $queryResult=$pdo->query("SELECT
            CONCAT(
                B.Nombre,
                ' ',
                B.Apellido1,
                ' ',
                B.Apellido2
            ) AS Cliente,
            CONCAT('AP-', LPAD(C.Folio, 6, 0)) AS Folio,
            A.TRenta,
            A.TotalR,
            A.RentaR,
            A.RentaM,
            A.IVA,
            A.iTR,
            C.ValorBien,
            C.Deposito,
            D.SaldoFinal AS VR,
            A.iPC,
            A.TasaTot
        FROM
            Intranet.relacion_tasa_pond A
        INNER JOIN sibware.2_cliente B ON A.IDCLiente = B.ID
        INNER JOIN sibware.2_ap_contrato C ON A.IDContrato = C.ID
        INNER JOIN sibware.2_ap_valorresidual D ON A.IDContrato = D.IDContrato
        WHERE
            A.Producto = 'AP'
        AND A.IDMoneda = 1
        AND A.Empresa = 'CMA'
        AND A.Periodo = $periodo
        AND A.yy = $yy");
            break;  
        case 19:
            $titulo='AP FUTUROS S/PR';    
            $queryResult=$pdo->query("SELECT
            CONCAT(
                B.Nombre,
                ' ',
                B.Apellido1,
                ' ',
                B.Apellido2
            ) AS Cliente,
            CONCAT('AP-', LPAD(C.Folio, 6, 0)) AS Folio,
            A.TRenta,
            A.TotalR,
            A.RentaR,
            A.RentaM,
            A.IVA,
            A.iTR,
            C.ValorBien,
            C.Deposito,
            D.SaldoFinal AS VR,
            A.iPC,
            A.TasaTot
        FROM
            Intranet.relacion_tasa_pond A
        INNER JOIN sibware.2_cliente B ON A.IDCLiente = B.ID
        INNER JOIN sibware.2_ap_contrato C ON A.IDContrato = C.ID
        INNER JOIN sibware.2_ap_valorresidual D ON A.IDContrato = D.IDContrato
        WHERE
            A.Producto = 'AP'
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
<?PHP
if ($tipo<15) {
    echo "<tr><th>No.</th><th>Cliente</th><th>Folio</th><th>Disp</th><th>Saldo Capital</th><th>Tasa</th><th>S.T.</th><th>Tasa T.</th><th>Interes</th><th>Interes FND</th></tr>";
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $fila++;
        echo "<tr><td>".$fila."</td><td>".$row['Cliente']."</td><td>".$row['Folio']."</td><td>".$row['Renglon']."</td><td>".number_format($row['SaldoCap'],2)."</td><td>".$row['Tasa']."</td><td>".$row['PAdicional']."</td><td>".$row['TasaTot']."</td><td>".number_format($row['Interes'],2)."</td><td>".number_format($row['InteresFND'],2)."</td></tr>";
    }

}
elseif($tipo>15 && $tipo <20) {
    echo "<tr><th>No.</th><th>Cliente</th><th>Folio</th><th>Total Renta</th><th>Rentas Pendientes </th><th>Renta</th><th>Ingresos Por Rentas</th><th>MOI</th><th>Depositos</th><th>VR</th><th>Saldo</th><th>Utilidad</th><th>Tasa Total</th></tr>";
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $fila++;
        $renta=$row['RentaM'];
        $iva=$row['IVA'];
        $totalRenta=$renta+$iva;
        $moi=$row['ValorBien'];
        $itr=$row['iTR'];
        $iPC=$row['iPC'];
        $itr=$itr+$iPC;
        $deposito=$row['Deposito'];
        $vr=$row['VR'];
        $utilidad=$itr+$deposito+$vr-$moi;
        echo "<tr><td>".$fila."</td><td>".$row['Cliente']."</td><td>".$row['Folio']."</td><td>".$row['TotalR']."</td><td>".$row['RentaR']."</td><td>".number_format($renta,2)."</td><td>".number_format($itr,2)."</td><td>".number_format($moi,2)."</td><td>".number_format($deposito,2)."</td><td>".number_format($vr,2)."</td><td>".number_format($row['iPC'],2)."</td><td>".number_format($utilidad,2)."</td><td>".number_format($row['TasaTot'],2)."</td></tr>";
    }
}
?>
</table>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
