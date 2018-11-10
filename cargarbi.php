<?PHP
    $hoy=date('Y-m-d');
    $fini='2018-01-01';
    $ffin='2018-12-31';
    require_once 'cn/cn.php';
    $queryResult=$pdo->query("SELECT * FROM Intranet.parametros");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $dialimpape=$row['dialimpape'];
        $piva=$row['piva'];
        $puntopase=$row['calfap'];
        $limpq=$row['limpq'];
        $dpond=$row['diaspond'];
        $idcontraloria=$row['id_contraloria'];
    }
    
        if ($grafica=='c') {//carga filtros de colocacion
            $queryResult=$pdo->query("SELECT * FROM Intranet.filtros_bi WHERE valor='$_POST[col]' ");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $fini=$row['fini'];
                $ffin=$row['ffin'];
            }
        }//carga filtros de colocacion
        //consulta tipo de cambio
        $queryResult=$pdo->query("SELECT * FROM sibware.indicador_tipocambio WHERE Fecha='$hoy'");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $tc=$row['Paridad'];
        }
        //consulta tipo de cambio
    if($grafica=='h'||$grafica=='c'){      
    //Consultas colocacion    
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
        //graficas de colocacion
    }    
if($grafica=='h'||$grafica=='cr'){    
        //graficas de cartera
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
    
}  
#Graficas de finanzas 
if ($grafica=='fi') {
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
}            
# Graficas finanzas 
#Graficas de Incidencias
    if ($grafica=='inc') {
        $tabiertos=0;
        $tproceso=0;
        $tcerrados=0;
        
        
        $queryResult=$pdo->query("SELECT * from Intranet.ticket A where A.fecha_alta BETWEEN '$finiinci' and '$ffininci'");
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
            A.fecha_alta BETWEEN '$finiinci'
            AND '$ffininci'
        )
    AND B.IDUsuario = $idcontraloria
    AND A.ID_Usuario<>$idcontraloria");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $triesgo++;
    }
    }
#Grafcas de Incidencias
?>