<?php
    $queryResult=$pdo->query("SELECT * FROM Intranet.parametros");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            
            $dpond=$row['diaspond'];
        }
    $queryResult=$pdo->query("SELECT
        texto
    FROM
        Intranet.filtros_bi A
    
    WHERE
        A.lActivo = 'S'
        AND periodo=$periodo
        AND yy=$yy");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            
            $textop=$row['texto'];
        }
        $queryResult=$pdo->query("SELECT
        texto
    FROM
        Intranet.filtros_bi A
    
    WHERE
        A.lActivo = 'S'
        AND periodo=$periodoant
        AND yy=$yy");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            
            $textopa=$row['texto'];
        }
        $queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.2_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='CR' AND A.IDMoneda=1 AND B.IDTipoCliente<>2 AND A.Empresa='CMU' AND A.Periodo=$periodo AND A.yy=$yy ");
        
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $capital=$row['Cap'];
                $interes=$row['Inte'];
                $tasapaspr=(($interes/$capital)*(360/$dpond))*100;
            }
            // echo $tasapaspr."</br>";
            // echo $periodo."<br>";
            // echo $periodoant."<br>";
            // die();
    
        $queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.2_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='CR' AND A.IDMoneda=1 AND B.IDTipoCliente<>2 AND A.Empresa='CMU' AND A.Periodo=$periodoant AND A.yy=$yy ");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $capital=$row['Cap'];
                $interes=$row['Inte'];
                $tasapasprpa=(($interes/$capital)*(360/$dpond))*100;
            } 
        $queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.2_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='IN' AND A.IDMoneda=1 AND B.IDTipoCliente<>2 AND A.Empresa='CMU' AND A.Periodo=$periodo AND A.yy=$yy ");
    
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $capital=$row['Cap'];
                $interes=$row['Inte'];
                $tasaacspr=(($interes/$capital)*(360/$dpond))*100;    
        }
        $queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.2_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='IN' AND A.IDMoneda=1 AND B.IDTipoCliente<>2 AND A.Empresa='CMU' AND A.Periodo=$periodoant AND A.yy=$yy ");
    
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $capital=$row['Cap'];
                $interes=$row['Inte'];
                $tasaacsprpa=(($interes/$capital)*(360/$dpond))*100;    
        }
        $spredd=$tasapaspr-$tasaacspr;
        $spreddpa=$tasapasprpa-$tasaacsprpa;
        $queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.InteresFND) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.2_contratos_disposicion B ON A.IDDisposicion=B.ID WHERE A.Producto='CR' AND A.IDMoneda=1 AND A.Empresa='CMU' AND B.IDOrigenRecursos=2 AND A.Periodo=$periodo AND A.yy=$yy AND A.InteresFND>0 ");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $capital=$row['Cap'];
            $interes=$row['Inte'];
            $tasaFND=(($interes/$capital)*(360/$dpond))*100;
        } 
        $queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.InteresFND) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.2_contratos_disposicion B ON A.IDDisposicion=B.ID WHERE A.Producto='CR' AND A.IDMoneda=1 AND A.Empresa='CMU' AND B.IDOrigenRecursos=2 AND A.Periodo=$periodoant AND A.yy=$yy AND A.InteresFND>0 ");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $capital=$row['Cap'];
            $interes=$row['Inte'];
            $tasaFNDpa=(($interes/$capital)*(360/$dpond))*100;
        }
        $queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.2_contratos_disposicion B ON A.IDDisposicion=B.ID WHERE A.Producto='CR' AND A.IDMoneda=1 AND A.Empresa='CMU' AND B.IDOrigenRecursos=2 AND A.Periodo=$periodo AND A.yy=$yy AND A.InteresFND>0 ");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $capital=$row['Cap'];
            $interes=$row['Inte'];
            $tasaFNDac=(($interes/$capital)*(360/$dpond))*100;
        } 
        $queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.2_contratos_disposicion B ON A.IDDisposicion=B.ID WHERE A.Producto='CR' AND A.IDMoneda=1 AND A.Empresa='CMU' AND B.IDOrigenRecursos=2 AND A.Periodo=$periodoant AND A.yy=$yy AND A.InteresFND>0 ");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $capital=$row['Cap'];
            $interes=$row['Inte'];
            $tasaFNDacpa=(($interes/$capital)*(360/$dpond))*100;
        }
        $spreddFND=$tasaFNDac-$tasaFND;
        $spreddpaFND=$tasaFNDacpa-$tasaFNDpa;
    
?>
<script type="text/javascript"> 
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

        },{
            name: 'ACTIVA FND',
            data: [<?PHP echo number_format($tasaFNDacpa,2).",".number_format($tasaFNDac,2); ?>]

        }, {
            name: 'PASIVA FND',
            data: [<?PHP echo number_format($tasaFNDpa,2).",".number_format($tasaFND,2); ?>]

        }, {
            name: 'SPRED FND',
            data: [<?PHP echo number_format($spreddpaFND,2).",".number_format($spreddFND,2); ?>]

        }]
    });
});

</script>