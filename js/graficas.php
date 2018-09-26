<script type="text/javascript">  
<?PHP $hoy=date('Y') ?>
$(function () {
    $('#uno').highcharts({
        title: {
            text: 'Colocacion por Mes Año <?php echo $hoy; ?>',
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

</script>   		