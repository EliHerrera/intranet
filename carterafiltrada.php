<?PHP
//graficas cartera por ejecutivos
    if ($grafica=='cr') {
        if ($_POST['col']==2) {
            $queryResultcateje=$pdo->query("SELECT
        CONCAT(
            C.Nombre,
            ' ',
            C.Apellido1,
            ' ',
            C.Apellido2
        ) AS Ejecutivo,
        SUM(A.SaldoCap) + SUM(A.SaldoInt) AS Saldo,
        SUM(A.SaldoMora) + SUM(A.SaldoIvaMora) + SUM(A.SaldoPena) + SUM(A.SaldoIvaPena) AS moras
    FROM
        2_dw_images_contratos A
    INNER JOIN 2_cliente B ON A.IDCliente = B.ID
    INNER JOIN personal C ON B.IDEjecutivo = C.ID
    INNER JOIN 2_contratos D ON A.IDContrato = D.ID
    WHERE
        A.FImage = '$hoy'
    AND D.IDMoneda = 1
    AND D. STATUS <> 'C'
    AND D. STATUS <> '-'
    AND D. STATUS <> 'P'
    GROUP BY
        C.ID");
        
        $queryResultdls=$pdo->query("SELECT
        CONCAT(
            C.Nombre,
            ' ',
            C.Apellido1,
            ' ',
            C.Apellido2
        ) AS Ejecutivodls,
        SUM(A.SaldoCap) + SUM(A.SaldoInt) AS Saldodls,
        SUM(A.SaldoMora) + SUM(A.SaldoIvaMora) + SUM(A.SaldoPena) + SUM(A.SaldoIvaPena) AS morasdls
    FROM
        2_dw_images_contratos A
    INNER JOIN 2_cliente B ON A.IDCliente = B.ID
    INNER JOIN personal C ON B.IDEjecutivo = C.ID
    INNER JOIN 2_contratos D ON A.IDContrato = D.ID
    WHERE
        A.FImage = '$hoy'
    AND D.IDMoneda = 2
    AND D. STATUS <> 'C'
    AND D. STATUS <> '-'
    AND D. STATUS <> 'P'
    GROUP BY
        C.ID");
        $etiqueta='Ejecutivos';
        }    
        
        
    }    //graficas cartera por ejecutivos
?>    