<script type="text/javascript">  
<?PHP $hoy=date('Y-m-d') ;
$fini='2018-01-01';
$ffin='2018-12-31';

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


//inicio grafica cartera total
$(function () {
    $('#totCat').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Cartera al dia <?php echo $hoy; ?>'
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


</script>   

		