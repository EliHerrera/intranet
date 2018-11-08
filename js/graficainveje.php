<script type="text/javascript">
    <?PHP

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
    $('#carterainveje').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Cartera Inversiones a la fecha de <?php echo $hoy ?>'
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
            name: 'Cartera Inversiones',
            data: [
            <?php    
                while ($row=$queryResultcateje->fetch(PDO::FETCH_ASSOC)) {
                    echo "['".$row['Ejecutivo']."  ',   ".$row['Saldo']."],";
                }    
            ?>    
            ]
        }]
    });
});



</script>