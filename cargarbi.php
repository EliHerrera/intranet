<?PHP
    $hoy=date('Y-m-d');
    $fini='2018-01-01';
    $ffin='2018-12-31';
    require_once 'cn/cn.php';
    
        $queryResult=$pdo->query("SELECT * FROM Intranet.filtros_bi WHERE valor='$_POST[col]' ");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $fini=$row['fini'];
            $ffin=$row['ffin'];
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
        $queryResult=$pdo->query("SELECT sum(SaldoCap)+SUM(SaldoInt) as totc from 2_dw_images_contratos where FImage='$hoy'");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $totCartera=$row['totc'];
        }
        $queryResult=$pdo->query("SELECT SUM(A.Disposicion)as tot FROM sibware.2_contratos_disposicion A
        INNER JOIN sibware.2_contratos B on A.IDContrato=B.ID
        INNER JOIN sibware.2_entorno_tipocredito C on B.IDTipoCredito=C.ID
        AND B.status<>'C'
        AND B.status<>'-'
        AND B.status<>'P'
        AND C.ID=5");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $totPQa=$row['tot'];
        }
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
    }
?>