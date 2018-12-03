<script type="text/javascript">
    <?PHP
$queryResultcatejeCR=$pdo->query("SELECT
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
    $('#carteracreje').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Volumen de Cartera por Ejecutivo Creditos al dia : <?PHP echo $hoy  ?>'
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
                while ($row=$queryResultcatejeCR->fetch(PDO::FETCH_ASSOC)) { 
                    
                    echo "['".$row['Ejecutivo']." ',   ".$row['Saldo']."],";
                }
                   
            ?>    
            ]
        }]
    });
});



</script>