<script type="text/javascript">  
<?PHP $hoy=date('Y-m-d') ;
$fini='2018-01-01';
$ffin='2018-12-31';
###query de graficas
$queryResult=$pdo->query("SELECT SUM(A.Disposicion)as tot FROM sibware.2_contratos_disposicion A
        INNER JOIN sibware.2_contratos B on A.IDContrato=B.ID
        INNER JOIN sibware.2_entorno_tipocredito C on B.IDTipoCredito=C.ID
        AND A.FInicio BETWEEN '$fini' AND '$ffin'
        AND B.status<>'C'
        AND B.status<>'-'
        AND C.ID=1");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $totCC=$row['tot'];
        }
        $queryResult=$pdo->query("SELECT SUM(A.Disposicion)as tot FROM sibware.2_contratos_disposicion A
        INNER JOIN sibware.2_contratos B on A.IDContrato=B.ID
        INNER JOIN sibware.2_entorno_tipocredito C on B.IDTipoCredito=C.ID
        AND A.FInicio BETWEEN '$fini' AND '$ffin'
        AND B.status<>'C'
        AND B.status<>'-'
        AND C.ID=2");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $totSIM=$row['tot'];
        }
        $queryResult=$pdo->query("SELECT SUM(A.Disposicion)as tot FROM sibware.2_contratos_disposicion A
        INNER JOIN sibware.2_contratos B on A.IDContrato=B.ID
        INNER JOIN sibware.2_entorno_tipocredito C on B.IDTipoCredito=C.ID
        AND A.FInicio BETWEEN '$fini' AND '$ffin'
        AND B.status<>'C'
        AND B.status<>'-'
        AND C.ID=3");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $totREF=$row['tot'];
        }
        $queryResult=$pdo->query("SELECT SUM(A.Disposicion)as tot FROM sibware.2_contratos_disposicion A
        INNER JOIN sibware.2_contratos B on A.IDContrato=B.ID
        INNER JOIN sibware.2_entorno_tipocredito C on B.IDTipoCredito=C.ID
        AND A.FInicio BETWEEN '$fini' AND '$ffin'
        AND B.status<>'C'
        AND B.status<>'-'
        AND C.ID=4");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $totAV=$row['tot'];
        }
        $queryResult=$pdo->query("SELECT SUM(A.Disposicion)as tot FROM sibware.2_contratos_disposicion A
        INNER JOIN sibware.2_contratos B on A.IDContrato=B.ID
        INNER JOIN sibware.2_entorno_tipocredito C on B.IDTipoCredito=C.ID
        AND A.FInicio BETWEEN '$fini' AND '$ffin'
        AND B.status<>'C'
        AND B.status<>'-'
        AND C.ID=5");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $totPQ=$row['tot'];
        }
        $queryResult=$pdo->query("SELECT SUM(A.Disposicion)as tot FROM sibware.2_contratos_disposicion A
        INNER JOIN sibware.2_contratos B on A.IDContrato=B.ID
        INNER JOIN sibware.2_entorno_tipocredito C on B.IDTipoCredito=C.ID
        AND A.FInicio BETWEEN '$fini' AND '$ffin'
        AND B.status<>'C'
        AND B.status<>'-'
        AND C.ID=6");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $totDC=$row['tot'];
        } 
        $queryResult=$pdo->query("SELECT SUM(A.Saldo)as tot FROM sibware.2_ap_disposicion A
        INNER JOIN sibware.2_ap_contrato B ON A.IDContrato = B.ID
        AND A.FInicio BETWEEN '$fini' AND '$ffin'
        AND B.status<>'C'
        AND B.status<>'-'");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $totAPU=$row['tot'];
        }
        $queryResult=$pdo->query("SELECT SUM(A.Saldo)as tot FROM sibware.3_ap_disposicion A
        INNER JOIN sibware.3_ap_contrato B ON A.IDContrato = B.ID
        AND A.FInicio BETWEEN '$fini' AND '$ffin'
        AND B.status<>'C'
        AND B.status<>'-'");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $totAP=$row['tot'];
        }
        $queryResult=$pdo->query("SELECT SUM(A.SaldoFinal)as tot FROM sibware.3_vp_disposicion A
        INNER JOIN sibware.3_vp_contrato B ON A.IDContrato = B.ID
        AND A.FInicio BETWEEN '$fini' AND '$ffin'
        AND B.status<>'C'
        AND B.status<>'-'");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $totVP=$row['tot'];
        }
        $queryResult=$pdo->query("SELECT SUM(A.Disposicion)as tot FROM sibware.3_pr_disposicion A
        INNER JOIN sibware.3_pr_contrato B ON A.IDContrato = B.ID
        AND A.FInicio BETWEEN '$fini' AND '$ffin'
        AND B.status<>'C'
        AND B.status<>'-'");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $totPR=$row['tot'];
        }

###query de graficas
###graficas cartera
$queryResult=$pdo->query("SELECT sum(A.SaldoCap)+SUM(A.SaldoInt) as totc from 2_dw_images_contratos A inner join 2_contratos B ON A.IDContrato=B.ID where A.FImage='$hoy' AND IDMoneda=1");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $totCartera=$row['totc'];
}
$queryResult=$pdo->query("SELECT sum(A.SaldoCap)+SUM(A.SaldoInt) as totc from 2_dw_images_contratos A inner join 2_contratos B ON A.IDContrato=B.ID where A.FImage='$hoy' AND IDMoneda=2");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $totCarteradls=$row['totc'];
}
$totCartera=$totCartera+($totCarteradls*$tc);

$queryResult=$pdo->query("SELECT
sum(A.SaldoCap) + SUM(A.SaldoInt) AS totc
FROM
2_dw_images_contratos A
INNER JOIN 2_contratos B ON A.IDContrato = B.ID
WHERE
FImage = '$hoy'
AND B.IDTipoCredito = 1");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
$totCatCC=$row['totc'];
}
$queryResult=$pdo->query("SELECT
sum(A.SaldoCap) + SUM(A.SaldoInt) AS totc
FROM
2_dw_images_contratos A
INNER JOIN 2_contratos B ON A.IDContrato = B.ID
WHERE
FImage = '$hoy'
AND B.IDMoneda=1    
AND B.IDTipoCredito = 2");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
$totCatSIM=$row['totc'];
}
$queryResult=$pdo->query("SELECT
sum(A.SaldoCap) + SUM(A.SaldoInt) AS totc
FROM
2_dw_images_contratos A
INNER JOIN 2_contratos B ON A.IDContrato = B.ID
WHERE
FImage = '$hoy'
AND B.IDMoneda=2    
AND B.IDTipoCredito = 2");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
$totCatSIMdls=$row['totc'];
}
$totCatSIM=$totCatSIM+($totCatSIMdls*$tc);
$queryResult=$pdo->query("SELECT
sum(A.SaldoCap) + SUM(A.SaldoInt) AS totc
FROM
2_dw_images_contratos A
INNER JOIN 2_contratos B ON A.IDContrato = B.ID
WHERE
FImage = '$hoy'
AND B.IDTipoCredito = 3");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
$totCatREF=$row['totc'];
}
$queryResult=$pdo->query("SELECT
sum(A.SaldoCap) + SUM(A.SaldoInt) AS totc
FROM
2_dw_images_contratos A
INNER JOIN 2_contratos B ON A.IDContrato = B.ID
WHERE
FImage = '$hoy'
AND B.IDTipoCredito = 4");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
$totCatAV=$row['totc'];
}
$queryResult=$pdo->query("SELECT
sum(A.SaldoCap) + SUM(A.SaldoInt) AS totc
FROM
2_dw_images_contratos A
INNER JOIN 2_contratos B ON A.IDContrato = B.ID
WHERE
FImage = '$hoy'
AND B.IDTipoCredito = 5");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
$totCatPQ=$row['totc'];
}
$queryResult=$pdo->query("SELECT
sum(A.SaldoCap) + SUM(A.SaldoInt) AS totc
FROM
2_dw_images_contratos A
INNER JOIN 2_contratos B ON A.IDContrato = B.ID
WHERE
FImage = '$hoy'
AND B.IDTipoCredito = 6");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
$totCatDC=$row['totc'];
}
$queryResult=$pdo->query("SELECT
sum(A.SaldoRenta) + SUM(A.SaldoIvaRenta) AS totc
FROM
2_dw_images_ap A
INNER JOIN 2_ap_contrato B ON A.IDContrato = B.ID
WHERE
FImage = '$hoy'");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
$totCatAPU=$row['totc'];
}
$queryResult=$pdo->query("SELECT
sum(A.SaldoRenta) + SUM(A.SaldoIvaRenta) AS totc
FROM
3_dw_images_ap A
INNER JOIN 3_ap_contrato B ON A.IDContrato = B.ID
WHERE
FImage = '$hoy'");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
$totCatAP=$row['totc'];
}
$queryResult=$pdo->query("SELECT
sum(A.SaldoCap) + SUM(A.SaldoInt) + SUM(A.SaldoIvaInt) AS totc
FROM
3_dw_images_vp A
INNER JOIN 3_vp_contrato B ON A.IDContrato = B.ID
WHERE
FImage = '$hoy'");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
$totCatVP=$row['totc'];
}
$queryResult=$pdo->query("SELECT
sum(A.SaldoCap) + SUM(A.SaldoInt) + SUM(A.SaldoIvaInt) AS totc
FROM
3_dw_images_pr A
INNER JOIN 3_pr_contrato B ON A.IDContrato = B.ID
WHERE
FImage = '$hoy'");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
$totCatPR=$row['totc'];
}
$queryResult=$pdo->query("SELECT
sum(A.SaldoProm) + SUM(A.SaldoInt) - SUM(A.SaldoRet) AS totc
FROM
2_dw_images_in A

WHERE
FImage = '$hoy'");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
$totCatIN=$row['totc'];
}//grafcas de cartera

        
###graficas cartera

?>

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

</script>   

		