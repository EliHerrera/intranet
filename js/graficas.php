<script type="text/javascript">  
<?PHP $hoy=date('Y-m-d') ?>
//inicio grafica colocacion
$(function () {
    $('#uno').highcharts({
        title: {
            text: 'Colocacion por Mes Año <?php echo date('Y'); ?>',
            x: -20 //center
        },
        subtitle: {
            text: 'Fuente: SIBWARE',
            x: -20
        },
        xAxis: {
            categories: ['Ene', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
        },
        yAxis: {
            title: {
                text: 'Colocacion ($)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '$'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: 'Cuenta Corriente  [$<?PHP echo number_format($totCC,2); ?>]',
            data: [
             <?php
                    include("colocadocc.php");

                ?>
            <?php echo $ene; ?>, <?php echo $feb; ?>, <?php echo $mar; ?>, <?php echo $abr; ?>, <?php echo $may; ?>, <?php echo $jun; ?>, <?php echo $jul; ?>, <?php echo $ago; ?>, <?php echo $sep; ?>, <?php echo $oct; ?>, <?php echo $nov; ?>, <?php echo $dic; ?>]
        }, {
            name: 'Simple  [$<?PHP echo number_format($totSIM,2); ?>]',
            data: [
              <?php
                    include("colocadosim.php");

                ?>
             <?php echo $ene; ?>, <?php echo $feb; ?>, <?php echo $mar; ?>, <?php echo $abr; ?>, <?php echo $may; ?>, <?php echo $jun; ?>, <?php echo $jul; ?>, <?php echo $ago; ?>, <?php echo $sep; ?>, <?php echo $oct; ?>, <?php echo $nov; ?>, <?php echo $dic; ?>]
        }, {
           name: 'Refaccionario  [$<?PHP echo number_format($totREF,2); ?>]',
            data: [
               <?php
                    include("colocadoref.php");

                ?> 
            <?php echo $ene; ?>, <?php echo $feb; ?>, <?php echo $mar; ?>, <?php echo $abr; ?>, <?php echo $may; ?>, <?php echo $jun; ?>, <?php echo $jul; ?>, <?php echo $ago; ?>, <?php echo $sep; ?>, <?php echo $oct; ?>, <?php echo $nov; ?>, <?php echo $dic; ?>]
        }, {
            name: 'Avio  [$<?PHP echo number_format($totAV,2); ?>]',
            data: [
               <?php
                    include("colocadoav.php");

                ?> 
            <?php echo $ene; ?>, <?php echo $feb; ?>, <?php echo $mar; ?>, <?php echo $abr; ?>, <?php echo $may; ?>, <?php echo $jun; ?>, <?php echo $jul; ?>, <?php echo $ago; ?>, <?php echo $sep; ?>, <?php echo $oct; ?>, <?php echo $nov; ?>, <?php echo $dic; ?>]
        }, {
            name: 'Quirografario  [$<?PHP echo number_format($totPQ,2); ?>]',
           data: [
               <?php
                    include("colocadopq.php");

                ?> 
            <?php echo $ene; ?>, <?php echo $feb; ?>, <?php echo $mar; ?>, <?php echo $abr; ?>, <?php echo $may; ?>, <?php echo $jun; ?>, <?php echo $jul; ?>, <?php echo $ago; ?>, <?php echo $sep; ?>, <?php echo $oct; ?>, <?php echo $nov; ?>, <?php echo $dic; ?>]
        }, {
            name: 'Directo con Colateral  [$<?PHP echo number_format($totDC,2); ?>]',
            data: [
               <?php
                    include("colocadodc.php");

                ?> 
            <?php echo $ene; ?>, <?php echo $feb; ?>, <?php echo $mar; ?>, <?php echo $abr; ?>, <?php echo $may; ?>, <?php echo $jun; ?>, <?php echo $jul; ?>, <?php echo $ago; ?>, <?php echo $sep; ?>, <?php echo $oct; ?>, <?php echo $nov; ?>, <?php echo $dic; ?>]
        }, {
            name: 'Arrendamiento CMU  [$<?PHP echo number_format($totAPU,2); ?>]',
            data: [
               <?php
                    include("colocadoapu.php");

                ?> 
            <?php echo $ene; ?>, <?php echo $feb; ?>, <?php echo $mar; ?>, <?php echo $abr; ?>, <?php echo $may; ?>, <?php echo $jun; ?>, <?php echo $jul; ?>, <?php echo $ago; ?>, <?php echo $sep; ?>, <?php echo $oct; ?>, <?php echo $nov; ?>, <?php echo $dic; ?>]
        }, {
            name: 'Arrendamiento CMA  [$<?PHP echo number_format($totAP,2); ?>]',
            data: [
               <?php
                    include("colocadoap.php");

                ?> 
            <?php echo $ene; ?>, <?php echo $feb; ?>, <?php echo $mar; ?>, <?php echo $abr; ?>, <?php echo $may; ?>, <?php echo $jun; ?>, <?php echo $jul; ?>, <?php echo $ago; ?>, <?php echo $sep; ?>, <?php echo $oct; ?>, <?php echo $nov; ?>, <?php echo $dic; ?>]
        },{
            name: 'Venta a Plazo  [$<?PHP echo number_format($totVP,2); ?>]',
            data: [
               <?php
                    include("colocadovp.php");

                ?> 
            <?php echo $ene; ?>, <?php echo $feb; ?>, <?php echo $mar; ?>, <?php echo $abr; ?>, <?php echo $may; ?>, <?php echo $jun; ?>, <?php echo $jul; ?>, <?php echo $ago; ?>, <?php echo $sep; ?>, <?php echo $oct; ?>, <?php echo $nov; ?>, <?php echo $dic; ?>]
        },{
            name: 'Prestamos  [$<?PHP echo number_format($totPR,2); ?>]',
            data: [
               <?php
                    include("colocadopr.php");

                ?> 
            <?php echo $ene; ?>, <?php echo $feb; ?>, <?php echo $mar; ?>, <?php echo $abr; ?>, <?php echo $may; ?>, <?php echo $jun; ?>, <?php echo $jul; ?>, <?php echo $ago; ?>, <?php echo $sep; ?>, <?php echo $oct; ?>, <?php echo $nov; ?>, <?php echo $dic; ?>]
        },]
    });
});
//fin de grafica de colocacion
//inicio grafica de colocacion barras
$(function () {
    $('#colfil').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Colocacion'
        },
        subtitle: {
            text: 'Credicor <?PHP echo "del ".$fini." a ".$ffin; ?>'
        },
        xAxis: {
            categories: ['Colocacion'],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Population (Pesos)',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' Pesos'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Cuenta Corriente [$<?PHP echo number_format($totCC,2); ?>]',
            data: [<?PHP echo $totCC; ?>]
        }, {
            name: 'Refaccionario [$<?PHP echo number_format($totREF,2); ?>]',
            data: [<?PHP echo $totREF; ?>]
        },{
            name: 'Avio [$<?PHP echo number_format($totAV,2); ?>]',
            data: [<?PHP echo $totAV; ?>]
        },{
            name: 'Colateral [$<?PHP echo number_format($totDC,2); ?>]',
            data: [<?PHP echo $totDC; ?>]
        },{
            name: 'Quirografario [$<?PHP echo number_format($totPQ,2); ?>]',
            data: [<?PHP echo $totPQ; ?>]
        },{
            name: 'Simple [$<?PHP echo number_format($totSIM,2); ?>]',
            data: [<?PHP echo $totSIM; ?>]
        },{
            name: 'Arrendamiento CMU [$<?PHP echo number_format($totAPU,2); ?>]',
            data: [<?PHP echo $totAPU; ?>]
        }, {
            name: 'Arrendamiento CMA [$<?PHP echo number_format($totAP,2); ?>]',
            data: [<?PHP echo $totAP;  ?>]
        }, {
            name: 'Venta a Plazo [$<?PHP echo number_format($totVP,2); ?>]',
            data: [<?PHP echo $totVP;  ?>]
        }, {
            name: 'Prestamos [$<?PHP echo number_format($totPR,2); ?>]',
            data: [<?PHP echo $totPR;  ?>]
        }]
    });
});
//fin grafica de colocacion barra
//inicio graficas PQs Home
<?php 
    $totPQa=$totCatPQ;
    $limitePQ=$totCartera*($limpq/100);
    $remanente=$limitePQ-$totPQa;
 ?>
$(function () {
    $('#dos').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Prestamos Quirografarios <?PHP echo date('Y'); ?>'
        },
        xAxis: {
            categories: ['PQs']
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Cartera Total',
            data: [<?PHP echo $totCartera ?>]
        }, {
            name: 'Limite <?PHP echo $limpq ?> %',
            data: [<?PHP echo $limitePQ ?>]
        }, {
            name: 'PQs',
            data: [<?PHP echo $totPQa ?>]
        }, {
            name: 'Remanente',
            data: [<?PHP echo $remanente ?>]
        }]
    });
});
 
//fin graficas PQs home
//inicio grafica cartera total
$(function () {
    $('#totCat').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Cartera'
        },
        subtitle: {
            text: 'Credicor Cartera <?PHP echo date('Y') ?>'
        },
        xAxis: {
            categories: ['Cartera'],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Population (Pesos)',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' Pesos'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Cuenta Corriente [$<?PHP echo number_format($totCatCC,2); ?>]',
            data: [<?PHP echo $totCatCC; ?>]
        }, {
            name: 'Refaccionario [$<?PHP echo number_format($totCatREF,2); ?>]',
            data: [<?PHP echo $totCatREF; ?>]
        },{
            name: 'Avio [$<?PHP echo number_format($totCatAV,2); ?>]',
            data: [<?PHP echo $totCatAV; ?>]
        },{
            name: 'Colateral [$<?PHP echo number_format($totCatDC,2); ?>]',
            data: [<?PHP echo $totCatDC; ?>]
        },{
            name: 'Quirografario [$<?PHP echo number_format($totCatPQ,2); ?>]',
            data: [<?PHP echo $totCatPQ; ?>]
        },{
            name: 'Simple [$<?PHP echo number_format($totCatSIM,2); ?>]',
            data: [<?PHP echo $totCatSIM; ?>]
        },{
            name: 'Arrendamiento CMU [$<?PHP echo number_format($totCatAPU,2); ?>]',
            data: [<?PHP echo $totCatAPU; ?>]
        },{
            name: 'Arrendamiento CMA [$<?PHP echo number_format($totCatAP,2); ?>]',
            data: [<?PHP echo $totCatAP; ?>]
        },{
            name: 'Venta a Plazo [$<?PHP echo number_format($totCatVP,2); ?>]',
            data: [<?PHP echo $totCatVP; ?>]
        },{
            name: 'Prestamos [$<?PHP echo number_format($totCatPR,2); ?>]',
            data: [<?PHP echo $totCatPR; ?>]
        },{
            name: 'Inversiones [$<?PHP echo number_format($totCatIN,2); ?>]',
            data: [<?PHP echo $totCatIN; ?>]
        }]
    });
});
//fin grafica cartera total
//graficas cartera por ejecutivos
<?PHP

        $etiqueta='Ejecutivos Creditos';
        $queryResultcateje=$pdo->query("SELECT
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
            AND D. STATUS <> 'P'
            GROUP BY
                C.ID");
            

?>  
$(function () {
    $('#carterafil').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Volumen de Cartera por <?PHP echo $etiqueta." ".date('Y-m-d')  ?>'
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
            name: 'Cartera',
            data: [
            <?PHP   
                while ($row=$queryResultcateje->fetch(PDO::FETCH_ASSOC)) {
                    $querydelete=$pdo->prepare("DELETE FROM Intranet.carterabi WHERE fecha='$hoy' AND tipo=1");
                    $querydelete->execute(); 
                    $queryInsert=$pdo->prepare("INSERT INTO Intranet.carterabi (IDEjecutivo,IDCliente,Saldo,Producto,fecha,Empresa,tipo) VALUES($row[IDEjecutivo],$row[IDCliente],$row[Saldo],'CR','$hoy',2,1)");
                    $queryInsert->execute();
                    echo "['".$row['Ejecutivo']." $".$row['Saldo']." ',   ".$row['Saldo']."],";
                }
                   
            ?>    
            ]
        }]
    });
});

//graficas cartera por ejecutivos
//garficas ejecutivos AP
<?PHP

        $etiqueta='Ejecutivos APU CMU';
        $queryResultcatejeAPU=$pdo->query("SELECT
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
    AND D. STATUS <> 'P'
    GROUP BY
        C.ID");
            

?>

$(function () {
    $('#carterafilEjeAPU').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Volumen de Cartera por <?PHP echo $etiqueta." ".date('Y')  ?>'
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
            name: 'Cartera',
            data: [
            <?PHP   
                while ($row=$queryResultcatejeAPU->fetch(PDO::FETCH_ASSOC)) { 
                    $queryInsert=$pdo->prepare("INSERT INTO Intranet.carterabi (IDEjecutivo,IDCliente,Saldo,Producto,fecha,Empresa,tipo) VALUES($row[IDEjecutivo],$row[IDCliente],$row[Saldo],'APU','$hoy',2,1)");
                    $queryInsert->execute();
                    echo "['".$row['Ejecutivo']." $".$row['Saldo']." ',   ".$row['Saldo']."],";
                }
                   
            ?>    
            ]
        }]
    });
});
<?PHP

        $etiqueta='Ejecutivos AP CMA';
        $queryResultcatejeAP=$pdo->query("SELECT
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
    AND D. STATUS <> 'P'
    GROUP BY
        C.ID");
            

?>
//garficas ejecutivos AP
$(function () {
    $('#carterafilEjeAP').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Volumen de Cartera por <?PHP echo $etiqueta." ".date('Y')  ?>'
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
            name: 'Cartera',
            data: [
            <?PHP   
                while ($row=$queryResultcatejeAP->fetch(PDO::FETCH_ASSOC)) { 
                    $queryInsert=$pdo->prepare("INSERT INTO Intranet.carterabi (IDEjecutivo,IDCliente,Saldo,Producto,fecha,Empresa,tipo) VALUES($row[IDEjecutivo],$row[IDCliente],$row[Saldo],'AP','$hoy',3,1)");
                    $queryInsert->execute();
                    echo "['".$row['Ejecutivo']." $".$row['Saldo']." ',   ".$row['Saldo']."],";
                }
                   
            ?>    
            ]
        }]
    });
});
//graficas ejecutivos AP
//Graficas Sucursal AP
<?PHP

        $etiqueta='Sucursal APU CMU';
        $queryResultcatsucAPU=$pdo->query("SELECT
        C.Nombre,
        SUM(A.SaldoRenta) + SUM(A.SaldoIvaRenta) AS Saldo,
        SUM(A.SaldoMora) + SUM(A.SaldoIvaMora) AS moras,
        C.ID as IDSucursal
    FROM
        sibware.2_dw_images_ap A
    INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
    INNER JOIN sibware.sucursal C ON B.IDSucursal = C.ID
    INNER JOIN sibware.2_ap_contrato D ON A.IDContrato = D.ID
    WHERE
        A.FImage = '$hoy'
    AND D.IDMoneda = 1
    AND D. STATUS <> 'C'
    AND D. STATUS <> '-'
    AND D. STATUS <> 'P'
    GROUP BY
        C.ID");
            

?>

$(function () {
    $('#carterafilSucAPU').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Volumen de Cartera por <?PHP echo $etiqueta." ".date('Y')  ?>'
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
            name: 'Cartera',
            data: [
            <?PHP   
                $querydelete=$pdo->prepare("DELETE FROM Intranet.carterabi WHERE fecha='$hoy' AND tipo=2");
                $querydelete->execute(); 
                while ($row=$queryResultcatsucAPU->fetch(PDO::FETCH_ASSOC)) { 
                    $queryInsert=$pdo->prepare("INSERT INTO Intranet.carterabi (IDSucursal,Saldo,Producto,fecha,Empresa,tipo) VALUES($row[IDSucursal],$row[Saldo],'APU','$hoy',2,2)");
                    $queryInsert->execute();
                    echo "['".$row['Ejecutivo']." $".$row['Saldo']." ',   ".$row['Saldo']."],";
                }
                   
            ?>    
            ]
        }]
    });
});
<?PHP

        $etiqueta='Sucursal AP CMA';
        $queryResultcatsucAP=$pdo->query("SELECT
        C.Nombre,
        SUM(A.SaldoRenta) + SUM(A.SaldoIvaRenta) AS Saldo,
        SUM(A.SaldoMora) + SUM(A.SaldoIvaMora) AS moras,
        C.ID as IDSucursal
    FROM
        sibware.3_dw_images_ap A
    INNER JOIN sibware.3_cliente B ON A.IDCliente = B.ID
    INNER JOIN sibware.sucursal C ON B.IDSucursal = C.ID
    INNER JOIN sibware.3_ap_contrato D ON A.IDContrato = D.ID
    WHERE
        A.FImage = '$hoy'
    AND D.IDMoneda = 1
    AND D. STATUS <> 'C'
    AND D. STATUS <> '-'
    AND D. STATUS <> 'P'
    GROUP BY
        C.ID");
            

?>

$(function () {
    $('#carterafilSucAP').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Volumen de Cartera por <?PHP echo $etiqueta." ".date('Y')  ?>'
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
            name: 'Cartera',
            data: [
            <?PHP   
                while ($row=$queryResultcatsucAP->fetch(PDO::FETCH_ASSOC)) { 
                    $queryInsert=$pdo->prepare("INSERT INTO Intranet.carterabi (IDSucursal,Saldo,Producto,fecha,Empresa,tipo) VALUES($row[IDSucursal],$row[Saldo],'AP','$hoy',3,2)");
                    $queryInsert->execute();
                    echo "['".$row['Ejecutivo']." $".$row['Saldo']." ',   ".$row['Saldo']."],";
                }
                   
            ?>    
            ]
        }]
    });
});
//Grafias Sucursal AP
//Graficas Ejecutivos VP
<?PHP

        $etiqueta='Ejecutivos Venta Plazo';
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
            

?>

$(function () {
    $('#carterafilEjeVP').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Volumen de Cartera por <?PHP echo $etiqueta." ".date('Y')  ?>'
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
            name: 'Cartera',
            data: [
            <?PHP   
                while ($row=$queryResultcatejeVP->fetch(PDO::FETCH_ASSOC)) { 
                    $queryInsert=$pdo->prepare("INSERT INTO Intranet.carterabi (IDEjecutivo,IDCliente,Saldo,Producto,fecha,Empresa,tipo) VALUES($row[IDEjecutivo],$row[IDCliente],$row[Saldo],'VP','$hoy',3,1)");
                    $queryInsert->execute();
                    echo "['".$row['Ejecutivo']." $".$row['Saldo']." ',   ".$row['Saldo']."],";
                }
                   
            ?>    
            ]
        }]
    });
});
//Graficas Ejecutivos VP
//Graficas todos los ejecutivos todos los productos

<?PHP

        $etiqueta='Ejecutivos Cartera Total';
        $queryResultcatejetodo=$pdo->query("SELECT
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
    GROUP BY
        B.ID");
            

?>

$(function () {
    $('#carterafiltodoseje').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Volumen de Cartera por <?PHP echo $etiqueta." ".date('Y')  ?>'
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
            name: 'Cartera',
            data: [
            <?PHP   
                while ($row=$queryResultcatejetodo->fetch(PDO::FETCH_ASSOC)) { 
                    
                    echo "['".$row['Ejecutivo']." $".$row['Saldo']." ',   ".$row['Saldo']."],";
                }
                $querydelete=$pdo->prepare("DELETE FROM Intranet.carterabi WHERE fecha='$hoy' and tipo=1");
                $querydelete->execute();    
            ?>    
            ]
        }]
    });
});
//Graficas todos los ejecutivos todos los productos
//Graficas por ejecutivos Inversiones
<?PHP

        $etiqueta='Ejecutivos Inversiones';
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
            

?>  
$(function () {
    $('#carterafilinv').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Volumen de Cartera por <?PHP echo $etiqueta." ".date('Y')  ?>'
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
            name: 'Cartera',
            data: [
            <?PHP   
                while ($row=$queryResultcateje->fetch(PDO::FETCH_ASSOC)) {
                    
                    echo "['".$row['Ejecutivo']." $".$row['Saldo']." ',   ".$row['Saldo']."],";
                }
                   
            ?>    
            ]
        }]
    });
});


//Graficas por ejecutivos Inversiones
//Grafias Sucursal VP
<?PHP

        $etiqueta='Sucursal Venta a Plazo';
        $queryResultcatsucVP=$pdo->query("SELECT
        C.Nombre,
        SUM(A.SaldoCap) + SUM(A.SaldoInt)+ SUM(A.SaldoIvaInt) AS Saldo,
        SUM(A.SaldoMora) + SUM(A.SaldoIvaMora) AS moras,
        C.ID as IDSucursal
    FROM
        sibware.3_dw_images_vp A
    INNER JOIN sibware.3_cliente B ON A.IDCliente = B.ID
    INNER JOIN sibware.sucursal C ON B.IDSucursal = C.ID
    INNER JOIN sibware.3_vp_contrato D ON A.IDContrato = D.ID
    WHERE
        A.FImage = '$hoy'
    AND D.IDMoneda = 1
    AND D. STATUS <> 'C'
    AND D. STATUS <> '-'
    AND D. STATUS <> 'P'
    GROUP BY
        C.ID");
            

?>

$(function () {
    $('#carterafilSucVP').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Volumen de Cartera por <?PHP echo $etiqueta." ".date('Y')  ?>'
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
            name: 'Cartera',
            data: [
            <?PHP   
                while ($row=$queryResultcatsucVP->fetch(PDO::FETCH_ASSOC)) { 
                    $queryInsert=$pdo->prepare("INSERT INTO Intranet.carterabi (IDSucursal,Saldo,Producto,fecha,Empresa,tipo) VALUES($row[IDSucursal],$row[Saldo],'VP','$hoy',3,2)");
                    $queryInsert->execute();
                    echo "['".$row['Nombre']."',   ".$row['Saldo']."],";
                }
                   
            ?>    
            ]
        }]
    });
});
//Grafias Sucursal VP
//Graficas cartera sucursal CR
<?PHP

        $etiqueta='Sucursal';
        $queryResultcateje=$pdo->query("SELECT
        C.Nombre, SUM(A.SaldoCap) + SUM(A.SaldoInt) AS Saldo,
        SUM(A.SaldoMora) + SUM(A.SaldoIvaMora) + SUM(A.SaldoPena) + SUM(A.SaldoIvaPena) AS moras,
        C.ID as IDSucursal
    FROM
        sibware.2_dw_images_contratos A
    INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
    INNER JOIN sibware.sucursal C ON B.IDSucursal = C.ID
    INNER JOIN sibware.2_contratos D ON A.IDContrato = D.ID
    WHERE
        A.FImage = '$hoy'
    AND D.IDMoneda = 1
    AND D. STATUS <> 'C'
    AND D. STATUS <> '-'
    AND D. STATUS <> 'P'
    GROUP BY
        C.ID");
            

?>  
$(function () {
    $('#carterafilsuc').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Volumen de Cartera por <?PHP echo $etiqueta." ".date('Y')  ?>'
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
            name: 'Cartera',
            data: [
            <?PHP   
                                
                while ($row=$queryResultcateje->fetch(PDO::FETCH_ASSOC)) { 
                    $queryInsert=$pdo->prepare("INSERT INTO Intranet.carterabi (IDSucursal,Saldo,Producto,fecha,Empresa,tipo) VALUES($row[IDSucursal],$row[Saldo],'CR','$hoy',2,2)");
                    $queryInsert->execute();
                    echo "['".$row['Nombre']."',   ".$row['Saldo']."],";
                }
                   
            ?>    
            ]
        }]
    });
});

//Graficas cartera sucursal
//Graficas todos los ejecutivos todos los productos

<?PHP

$etiqueta='Sucursal Cartera Total';
$queryResultcatejetodo=$pdo->query("SELECT
    B.Nombre
    AS Sucursal,
SUM(A.Saldo)  AS Saldo

FROM
Intranet.carterabi A
INNER JOIN sibware.sucursal B ON A.IDSucursal = B.ID

WHERE
A.fecha = '$hoy'
AND
A.tipo=2   
GROUP BY
B.ID");
    

?>

$(function () {
$('#carterafiltodosuc').highcharts({
chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false
},
title: {
    text: 'Volumen de Cartera por <?PHP echo $etiqueta." ".date('Y')  ?>'
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
    name: 'Cartera',
    data: [
    <?PHP   
        while ($row=$queryResultcatejetodo->fetch(PDO::FETCH_ASSOC)) { 
            
            echo "['".$row['Sucursal']."',   ".$row['Saldo']."],";
        }
        $querydelete=$pdo->prepare("DELETE FROM Intranet.carterabi WHERE fecha='$hoy' and tipo=2");
        $querydelete->execute();    
    ?>    
    ]
}]
});
});
//Graficas todos los sucursal todos los productos
//Graficas por sucuirsal Inversiones
<?PHP

        $etiqueta='Sucursal Inversiones';
        $queryResultcateje=$pdo->query("SELECT
                E.Nombre
                AS Sucursal,
                SUM(A.SaldoProm) + SUM(A.SaldoInt) - SUM(A.SaldoRet) AS Saldo
                
            FROM
                sibware.2_dw_images_in A
            INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
            INNER JOIN sibware.personal C ON A.IDEjecutivo = C.ID
            INNER JOIN sibware.2_prestamos D ON A.IDCliente = B.ID
            INNER JOIN sibware.sucursal E ON A.IDSucursal = E.ID
            WHERE
                A.FImage = '$hoy'
            AND D.IDMoneda = 1
            GROUP BY
                E.ID");
            

?>  
$(function () {
    $('#carterafilsucinv').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Volumen de Cartera por <?PHP echo $etiqueta." ".date('Y')  ?>'
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
            name: 'Cartera',
            data: [
            <?PHP   
                while ($row=$queryResultcateje->fetch(PDO::FETCH_ASSOC)) {
                    
                    echo "['".$row['Sucursal']."',   ".$row['Saldo']."],";
                }
                   
            ?>    
            ]
        }]
    });
});


//Graficas por Sucursal Inversiones
//graficas por producto
<?PHP

        $etiqueta='Productos';
        $queryResultcateje=$pdo->query("SELECT
        C.Tipo,
        SUM(A.SaldoCap) + SUM(A.SaldoInt) AS Saldo,
        SUM(A.SaldoMora) + SUM(A.SaldoIvaMora) + SUM(A.SaldoPena) + SUM(A.SaldoIvaPena) AS moras
    FROM
        sibware.2_dw_images_contratos A
    INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
    INNER JOIN sibware.2_contratos D ON A.IDContrato = D.ID
    INNER JOIN sibware.2_entorno_tipocredito C ON D.IDTipoCredito = C.ID
    WHERE
        A.FImage = '$hoy'
    AND D.IDMoneda = 1
    AND D. STATUS <> 'C'
    AND D. STATUS <> '-'
    AND D. STATUS <> 'P'
    GROUP BY
        C.ID");
    while ($row=$queryResultcateje->fetch(PDO::FETCH_ASSOC)) { 
        $queryInsert=$pdo->prepare("INSERT INTO Intranet.carterabi (Saldo,Producto,fecha,Empresa,tipo) VALUES($row[Saldo],'CR','$hoy',2,3)");
                    $queryInsert->execute();
    } 
    $queryResultcateje=$pdo->query("SELECT
        
        SUM(A.SaldoRenta) + SUM(A.SaldoIvaRenta) AS Saldo,
        SUM(A.SaldoMora) + SUM(A.SaldoIvaMora)  AS moras
    FROM
        sibware.2_dw_images_ap A
    INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
    INNER JOIN sibware.2_ap_contrato D ON A.IDContrato = D.ID
   
    WHERE
        A.FImage = '$hoy'
    AND D.IDMoneda = 1
    AND D. STATUS <> 'C'
    AND D. STATUS <> '-'
    AND D. STATUS <> 'P'
    "); 
    while ($row=$queryResultcateje->fetch(PDO::FETCH_ASSOC)) { 
        $queryInsert=$pdo->prepare("INSERT INTO Intranet.carterabi (Saldo,Producto,fecha,Empresa,tipo) VALUES($row[Saldo],'APU','$hoy',2,3)");
        $queryInsert->execute();
    }
    $queryResultcateje=$pdo->query("SELECT
        
        SUM(A.SaldoRenta) + SUM(A.SaldoIvaRenta) AS Saldo,
        SUM(A.SaldoMora) + SUM(A.SaldoIvaMora)  AS moras
    FROM
        sibware.3_dw_images_ap A
    INNER JOIN sibware.3_cliente B ON A.IDCliente = B.ID
    INNER JOIN sibware.3_ap_contrato D ON A.IDContrato = D.ID
   
    WHERE
        A.FImage = '$hoy'
    AND D.IDMoneda = 1
    AND D. STATUS <> 'C'
    AND D. STATUS <> '-'
    AND D. STATUS <> 'P'
    "); 
    while ($row=$queryResultcateje->fetch(PDO::FETCH_ASSOC)) { 
        $queryInsert=$pdo->prepare("INSERT INTO Intranet.carterabi (Saldo,Producto,fecha,Empresa,tipo) VALUES($row[Saldo],'AP','$hoy',3,3)");
        $queryInsert->execute();
    }  
    $queryResultcateje=$pdo->query("SELECT
        
        SUM(A.SaldoCap) + SUM(A.SaldoInt) AS Saldo,
        SUM(A.SaldoMora) + SUM(A.SaldoIvaMora)  AS moras
    FROM
        sibware.3_dw_images_vp A
    INNER JOIN sibware.3_cliente B ON A.IDCliente = B.ID
    INNER JOIN sibware.3_vp_contrato D ON A.IDContrato = D.ID
   
    WHERE
        A.FImage = '$hoy'
    AND D.IDMoneda = 1
    AND D. STATUS <> 'C'
    AND D. STATUS <> '-'
    AND D. STATUS <> 'P'
    "); 
    while ($row=$queryResultcateje->fetch(PDO::FETCH_ASSOC)) { 
        $queryInsert=$pdo->prepare("INSERT INTO Intranet.carterabi (Saldo,Producto,fecha,Empresa,tipo) VALUES($row[Saldo],'VP','$hoy',3,3)");
        $queryInsert->execute();
    } 
    $queryResultcateje=$pdo->query("SELECT
        
        SUM(A.SaldoProm) + SUM(A.SaldoInt) - SUM(A.SaldoRet) AS Saldo
        
    FROM
        sibware.2_dw_images_in A
    INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
    INNER JOIN sibware.2_prestamos D ON A.IDPrestamo = D.ID
   
    WHERE
        A.FImage = '$hoy'
    AND D.IDMoneda = 1
    
    "); 
    while ($row=$queryResultcateje->fetch(PDO::FETCH_ASSOC)) { 
        $queryInsert=$pdo->prepare("INSERT INTO Intranet.carterabi (Saldo,Producto,fecha,Empresa,tipo) VALUES($row[Saldo],'INV','$hoy',2,3)");
        $queryInsert->execute();
    }  
    $queryResultcateje=$pdo->query("SELECT
        A.Producto as Tipo,
        SUM(A.Saldo) AS Saldo
    FROM
        Intranet.carterabi A
    WHERE
        A.fecha = '$hoy'
    GROUP BY
    A.Producto
    ");    

?>  
$(function () {
    $('#carterafilpro').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Volumen de Cartera por <?PHP echo $etiqueta." ".date('Y')  ?>'
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
            name: 'Cartera',
            data: [
            <?PHP   
                while ($row=$queryResultcateje->fetch(PDO::FETCH_ASSOC)) { 
                
                    echo "['".$row['Tipo']."',   ".$row['Saldo']."],";
                }
                $querydelete=$pdo->prepare("DELETE FROM Intranet.carterabi WHERE fecha='$hoy' and tipo=3");
                $querydelete->execute();   
            ?>    
            ]
        }]
    });
});


//Graficas por producto
//Graficas finanzas

$(function () {
    $('#fi').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Tasas Ponderadas <?PHP echo date('Y');  ?>'
        },
        subtitle: {
            text: 'Source: Credicor '
        },
        xAxis: {
            categories: [
                '<?PHP echo $textopa ?>',
                
                '<?PHP echo $textop ?>'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'tasas (%)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.2f} %</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'ACTIVA',
            data: [<?PHP echo number_format($tasapasprpa,2).",".number_format($tasapaspr,2); ?>]

        }, {
            name: 'PASIVA',
            data: [<?PHP echo number_format($tasaacsprpa,2).",".number_format($tasaacspr,2); ?>]

        }, {
            name: 'SPRED',
            data: [<?PHP echo number_format($spreddpa,2).",".number_format($spredd,2); ?>]

        }, {
            name: 'FND',
            data: [<?PHP echo number_format($tasaFNDpa,2).",".number_format($tasaFND,2); ?>]

        }]
    });
});
//Graficas Finanzas
//graficas incidencias
$(function () {
    $('#incidenciasn').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: '<?php echo $ffininci; ?>'
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
            name: 'Incidencias',
            data: [
                ['Abiertos',   <?php echo $tabiertos ?>],
                ['Pendientes',       <?php echo $tproceso ?>],
                {
                    name: 'Cerrados',
                    y: <?php echo $tcerrados ?>,
                    sliced: true,
                    selected: true
                }
            ]
        }]
    });
});
$(function () {
    $('#incidenciasr').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Reporte de Incidencias de Riesgo, 2018'
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
            name: 'Incidencias',
            data: [
                ['Normales',   85.0],
                
                {
                    name: 'Riesgo',
                    y: 15.0,
                    sliced: true,
                    selected: true
                }
            ]
        }]
    });
});

//Graficas Incidencias

</script>   

		