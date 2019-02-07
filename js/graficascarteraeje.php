<script type="text/javascript">
<?PHP 
$queryResult=$pdo->query("SELECT * FROM sibware.indicador_tipocambio WHERE Fecha='$hoy'");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $tc=$row['Paridad'];
    }
$queryResult=$pdo->query("SELECT
 CONCAT(
     C.Nombre,
     ' ',
     C.Apellido1,
     ' ',
     C.Apellido2
 ) AS Ejecutivo,
 SUM(A.SaldoCap) + SUM(A.SaldoInt) AS Saldo,
 SUM(A.SaldoMora) + SUM(A.SaldoIvaMora) + SUM(A.SaldoPena) + SUM(A.SaldoIvaPena) AS moras,
 A.IDEjecutivo,
 A.IDCliente
FROM
 sibware.2_dw_images_contratos A
INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
INNER JOIN sibware.personal C ON A.IDEjecutivo = C.ID
INNER JOIN sibware.2_contratos D ON A.IDContrato = D.ID
WHERE
 A.FImage = '$hoy'
AND D.IDMoneda = 1
AND D. STATUS <> 'C'
AND D. STATUS <> '-'
GROUP BY
 C.ID
 HAVING Saldo>0");
 $queryResult2=$pdo->query("SELECT
 CONCAT(
     C.Nombre,
     ' ',
     C.Apellido1,
     ' ',
     C.Apellido2
 ) AS Ejecutivo,
 SUM(A.SaldoCap) + SUM(A.SaldoInt) AS Saldo,
 SUM(A.SaldoMora) + SUM(A.SaldoIvaMora) + SUM(A.SaldoPena) + SUM(A.SaldoIvaPena) AS moras,
 A.IDEjecutivo,
 A.IDCliente
FROM
 sibware.2_dw_images_contratos A
INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
INNER JOIN sibware.personal C ON A.IDEjecutivo = C.ID
INNER JOIN sibware.2_contratos D ON A.IDContrato = D.ID
WHERE
 A.FImage = '$hoy'
AND D.IDMoneda = 2
AND D. STATUS <> 'C'
AND D. STATUS <> '-'
GROUP BY
 C.ID
 HAVING Saldo>0"); 
 $querydelete=$pdo->prepare("DELETE FROM Intranet.carterabi WHERE fecha='$hoy' AND tipo=1");
 $querydelete->execute(); 
 while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {    
    $queryInsert=$pdo->prepare("INSERT INTO Intranet.carterabi (IDEjecutivo,Saldo,Producto,fecha,Empresa,tipo,IDMoneda) VALUES($row[IDEjecutivo],$row[Saldo],'CR','$hoy',2,1,1)");
    $queryInsert->execute();
 }
 while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) { 
     $saldodls=$row['Saldo'];
     $saldodls=$saldodls*$tc;   
    $queryInsert=$pdo->prepare("INSERT INTO Intranet.carterabi (IDEjecutivo,Saldo,Producto,fecha,Empresa,tipo,IDMoneda) VALUES($row[IDEjecutivo],$saldodls,'CR','$hoy',2,1,2)");
    $queryInsert->execute();
 }
 $queryResult=$pdo->query("SELECT
 CONCAT(
     C.Nombre,
     ' ',
     C.Apellido1,
     ' ',
     C.Apellido2
 ) AS Ejecutivo,
 SUM(A.SaldoRenta) + SUM(A.SaldoIvaRenta) AS Saldo,
 SUM(A.SaldoMora) + SUM(A.SaldoIvaMora) AS moras,
 A.IDEjecutivo,
 A.IDCliente
FROM
 sibware.2_dw_images_ap A
INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
INNER JOIN sibware.personal C ON A.IDEjecutivo = C.ID
INNER JOIN sibware.2_ap_contrato D ON A.IDContrato = D.ID
WHERE
 A.FImage = '$hoy'
AND D.IDMoneda = 1
AND D. STATUS <> 'C'
AND D. STATUS <> '-'

GROUP BY
 C.ID
 HAVING Saldo>0");
 while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {    
    $queryInsert=$pdo->prepare("INSERT INTO Intranet.carterabi (IDEjecutivo,Saldo,Producto,fecha,Empresa,tipo,IDMoneda) VALUES($row[IDEjecutivo],$row[Saldo],'AP','$hoy',2,1,1)");
    $queryInsert->execute();
 }
 $queryResult=$pdo->query("SELECT
 CONCAT(
     C.Nombre,
     ' ',
     C.Apellido1,
     ' ',
     C.Apellido2
 ) AS Ejecutivo,
 SUM(A.SaldoRenta) + SUM(A.SaldoIvaRenta) AS Saldo,
 SUM(A.SaldoMora) + SUM(A.SaldoIvaMora) AS moras,
 A.IDEjecutivo,
 A.IDCliente
FROM
 sibware.3_dw_images_ap A
INNER JOIN sibware.3_cliente B ON A.IDCliente = B.ID
INNER JOIN sibware.personal C ON A.IDEjecutivo = C.ID
INNER JOIN sibware.3_ap_contrato D ON A.IDContrato = D.ID
WHERE
 A.FImage = '$hoy'
AND D.IDMoneda = 1
AND D. STATUS <> 'C'
AND D. STATUS <> '-'

GROUP BY
 C.ID
 HAVING Saldo>0");
 while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {    
    $queryInsert=$pdo->prepare("INSERT INTO Intranet.carterabi (IDEjecutivo,Saldo,Producto,fecha,Empresa,tipo,IDMoneda) VALUES($row[IDEjecutivo],$row[Saldo],'AP','$hoy',3,1,1)");
    $queryInsert->execute();
 }
 $queryResult=$pdo->query("SELECT
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

GROUP BY
 C.ID
 HAVING Saldo>0");
 while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {    
    $queryInsert=$pdo->prepare("INSERT INTO Intranet.carterabi (IDEjecutivo,Saldo,Producto,fecha,Empresa,tipo,IDMoneda) VALUES($row[IDEjecutivo],$row[Saldo],'VP','$hoy',3,1,1)");
    $queryInsert->execute();
 }
 ?>

<?php
 $queryResult3=$pdo->query("SELECT
        CONCAT(
            B.Nombre,
            ' ',
            B.Apellido1,
            ' ',
            B.Apellido2
        ) AS Ejecutivo,
        SUM(A.Saldo)  AS Saldo
        
    FROM
        Intranet.carterabi A
    INNER JOIN sibware.personal B ON A.IDEjecutivo = B.ID
    
    WHERE
        A.fecha = '$hoy'
    AND
        A.tipo=1  
    AND 
       A.Empresa=3     
    GROUP BY
        B.ID");
            


$queryResult2=$pdo->query("SELECT
        CONCAT(
            B.Nombre,
            ' ',
            B.Apellido1,
            ' ',
            B.Apellido2
        ) AS Ejecutivo,
        SUM(A.Saldo)  AS Saldo
        
    FROM
        Intranet.carterabi A
    INNER JOIN sibware.personal B ON A.IDEjecutivo = B.ID
    
    WHERE
        A.fecha = '$hoy'
    AND
        A.tipo=1  
    AND 
       A.Empresa=2     
    GROUP BY
        B.ID");
            

?>
$(function () {
    $('#carteraejecmu').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Cartera Total CMU a <?php echo $hoy; ?>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Cartera Total CMU',
            data: [
                <?php
                while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {   
                echo "['".$row['Ejecutivo']."',   ".$row['Saldo']."],";
                }
                ?>
            ]
        }]
    });
});
$(function () {
    $('#carteraejecma').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Cartera Total CMA a <?php echo $hoy; ?>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Cartera Total CMA',
            data: [
                <?php
                while ($row=$queryResult3->fetch(PDO::FETCH_ASSOC)) {   
                echo "['".$row['Ejecutivo']."',   ".$row['Saldo']."],";
                }
                ?>
                
            ]
        }]
    });
});

</script> 

              