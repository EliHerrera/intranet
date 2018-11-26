<?php
$fini='2018-11-01';
$ffin='2018-11-31';
if (!empty($_POST['col'])) {
    $queryResult=$pdo->query("SELECT * FROM Intranet.filtros_bi WHERE valor='$_POST[col]' ");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $fini=$row['fini'];
                $ffin=$row['ffin'];
            }
}
$queryResult=$pdo->query("SELECT * FROM sibware.2_prestamos A WHERE (A.FTermino BETWEEN '$fini' and '$ffin') and A.status<>'C'");
$totalinv= $queryResult->rowCount(); 
$queryResult=$pdo->query("SELECT * FROM sibware.2_prestamos A WHERE (A.FTermino BETWEEN '$fini' and '$ffin') and A.status='V'");
$totalvig= $queryResult->rowCount(); 
$inv=100-(($totalvig/$totalinv)*100);
$queryResult=$pdo->query("SELECT * FROM	sibware.2_contratos_solicitud_cheque A WHERE (A.FInicio BETWEEN '$fini'	AND '$ffin'	) AND A.status <> 'N'");
$totaldis= $queryResult->rowCount();
$queryResult=$pdo->query("SELECT * FROM	sibware.2_contratos_solicitud_cheque A WHERE (A.FInicio BETWEEN '$fini'	AND '$ffin'	) AND A.status <> 'N' and A.status<>'F'");
$totaldisp= $queryResult->rowCount();	
$dis=100-(($totaldisp/$totaldis)*100);
$queryResult=$pdo->query("SELECT * from sibware.2_ap_disposicion_movs A INNER JOIN 2_ap_disposicion B on A.IDDisposicion=B.ID INNER JOIN 2_ap_contrato C on B.IDContrato=C.ID where C.status<>'-' and C.status<>'C' and C.status<>'P' and A.FInicial BETWEEN '$fini' and '$ffin'");
$totalfapu=$queryResult->rowCount();
$queryResult=$pdo->query("SELECT * from sibware.3_ap_disposicion_movs A INNER JOIN 3_ap_disposicion B on A.IDDisposicion=B.ID INNER JOIN 3_ap_contrato C on B.IDContrato=C.ID where C.status<>'-' and C.status<>'C' and C.status<>'P' and A.FInicial BETWEEN '$fini' and '$ffin' ");
$totalfapc=$queryResult->rowCount();
$totalfap=$totalfapu+$totalfapc;
$queryResult=$pdo->query("SELECT * from sibware.2_ap_disposicion_movs A INNER JOIN 2_ap_disposicion B on A.IDDisposicion=B.ID INNER JOIN 2_ap_contrato C on B.IDContrato=C.ID where C.status<>'-' and C.status<>'C' and C.status<>'P' and A.FInicial BETWEEN '$fini' and '$ffin' and A.lfacturado<>'S'");
$totalfsapu=$queryResult->rowCount();
$queryResult=$pdo->query("SELECT * from sibware.3_ap_disposicion_movs A INNER JOIN 3_ap_disposicion B on A.IDDisposicion=B.ID INNER JOIN 3_ap_contrato C on B.IDContrato=C.ID where C.status<>'-' and C.status<>'C' and C.status<>'P' and A.FInicial BETWEEN '$fini' and '$ffin' and A.lfacturado<>'S'");
$totalfsapc=$queryResult->rowCount();	
$totalfsap=$totalfsapu+$totalfsapc;
$fap=100-(($totalfsap/$totalfap)*100);
$queryResult=$pdo->query("SELECT * from sibware.3_vp_disposicion_movs A INNER JOIN 3_vp_disposicion B on A.IDDisposicion=B.ID INNER JOIN 3_vp_contrato C on B.IDContrato=C.ID where C.status<>'-' and C.status<>'C' and C.status<>'P' and A.FInicial BETWEEN '$fini' and '$ffin' ");
$totalfvp=$queryResult->rowCount();	
$queryResult=$pdo->query("SELECT * from sibware.3_vp_disposicion_movs A INNER JOIN 3_vp_disposicion B on A.IDDisposicion=B.ID INNER JOIN 3_ap_contrato C on B.IDContrato=C.ID where C.status<>'-' and C.status<>'C' and C.status<>'P' and A.FInicial BETWEEN '$fini' and '$ffin' and A.lfacturado<>'S'");
$totalfsvp=$queryResult->rowCount();	
$fvp=100-(($totalfsvp/$totalfvp)*100);

?>

<script type="text/javascript">
$(function () {

var gaugeOptions = {

    chart: {
        type: 'solidgauge'
    },

    title: null,

    pane: {
        center: ['50%', '85%'],
        size: '140%',
        startAngle: -90,
        endAngle: 90,
        background: {
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
            innerRadius: '60%',
            outerRadius: '100%',
            shape: 'arc'
        }
    },

    tooltip: {
        enabled: false
    },

    // the value axis
    yAxis: {
        stops: [
            [0.1, '#DF5353'], // red
            [0.5, '#DDDF0D'], // yellow
            [0.9, '#55BF3B'] // green 
        ],
        lineWidth: 0,
        minorTickInterval: null,
        tickPixelInterval: 400,
        tickWidth: 0,
        title: {
            y: -70
        },
        labels: {
            y: 16
        }
    },

    plotOptions: {
        solidgauge: {
            dataLabels: {
                y: 5,
                borderWidth: 0,
                useHTML: true
            }
        }
    }
};

// Inversiones
$('#container-inv').highcharts(Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 100,
        title: {
            text: 'Inversiones'
        }
    },

    credits: {
        enabled: false
    },

    series: [{
        name: 'Inversiones',
        data: [<?php echo number_format($inv,2); ?>],
        dataLabels: {
            format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                   '<span style="font-size:12px;color:silver">Pendientes</span></div>'
        },
        tooltip: {
            valueSuffix: 'Pendientes x Renovar'
        }
    }]

}));

// Colocacion
$('#container-col').highcharts(Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 100,
        title: {
            text: 'Contratos'
        }
    },

    series: [{
        name: 'Contratos',
        data: [<?php echo number_format($dis,2); ?>],
        dataLabels: {
            format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y:.1f}</span><br/>' +
                   '<span style="font-size:12px;color:silver">* Precontratos</span></div>'
        },
        tooltip: {
            valueSuffix: 'Precontratos'
        }
    }]

}));

// Facturacion AP
$('#container-ap').highcharts(Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 100,
        title: {
            text: 'Facturacion AP'
        }
    },

    series: [{
        name: 'Facturacion AP',
        data: [<?php echo number_format($fap,2); ?>],
        dataLabels: {
            format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y:.1f}</span><br/>' +
                   '<span style="font-size:12px;color:silver">* Facturacion AP</span></div>'
        },
        tooltip: {
            valueSuffix: 'Facturacion AP'
        }
    }]

}));

// Facturacion VP
$('#container-vp').highcharts(Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 100,
        title: {
            text: 'Facturacion VP'
        }
    },

    series: [{
        name: 'Facturacion VP',
        data: [<?php echo number_format($fvp,2); ?>],
        dataLabels: {
            format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y:.1f}</span><br/>' +
                   '<span style="font-size:12px;color:silver">* Facturacion VP</span></div>'
        },
        tooltip: {
            valueSuffix: 'Facturacion VP'
        }
    }]

}));



});
</script> 

              