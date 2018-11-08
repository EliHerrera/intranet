<script type="text/javascript">  
<?PHP $hoy=date('Y-m-d') ;
$fini='2018-01-01';
$ffin='2018-12-31';
###query de graficas
if (!empty($_POST['col'])) {
    $queryResult=$pdo->query("SELECT * FROM Intranet.filtros_bi WHERE valor='$_POST[col]' ");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $fini=$row['fini'];
                $ffin=$row['ffin'];
            }
}
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

</script>   

		