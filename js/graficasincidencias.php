<script type="text/javascript">  
<?PHP 
###query de graficas
#Graficas de Incidencias

    $tabiertos=0;
    $tproceso=0;
    $tcerrados=0;    
    $queryResult=$pdo->query("SELECT * from Intranet.ticket A where A.fecha_alta BETWEEN '$fini' and '$ffin'");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        if($row['Estatus']=='A'){
            $tabiertos++; 
        }elseif ($row['Estatus']=='C') {
            $tcerrados++;
        }elseif ($row['Estatus']=='P') {
            $tproceso++;
        }
        $ttotales=$tabiertos+$tproceso+$tcerrados;
       
    }
    $queryResult=$pdo->query("SELECT
    *
FROM
    Intranet.ticket A
INNER JOIN Intranet.msj_ticket B ON A.ID_Ticket = B.IDTicket
WHERE
    (
        A.fecha_alta BETWEEN '$fini'
        AND '$ffin'
    )
AND B.IDUsuario = $idcontraloria
AND A.ID_Usuario<>$idcontraloria");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $triesgo++;
}
$tnormales=$ttotales-$triesgo;
#Grafcas de Incidencias

###query de graficas

?>

//graficas incidencias
$(function () {
    $('#incidenciasn').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: '<?php echo $texto; ?>'
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
            text: '<?php echo $texto ?>'
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
                ['Normales',   <?PHP echo $tnormales ?>],
                
                {
                    name: 'Riesgo',
                    y: <?PHP echo $triesgo ?>,
                    sliced: true,
                    selected: true
                }
            ]
        }]
    });
});

//Graficas Incidencias

</script>   

		