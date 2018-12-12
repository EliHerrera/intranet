<?php
    require_once 'header.php';
    //////inicio de contenido
    if($_GET['idac']){
        $idac=$_GET['idac'];
        $emp=$_GET['emp'];

        if ($emp==2) {
            $queryResult=$pdo->query("SELECT
            CONCAT(
                B.Nombre,
                ' ',
                B.Apellido1,
                ' ',
                B.Apellido2
            ) AS Cliente,
            CONCAT(
                A.TipoContrato,
                '-',
                LPAD(A.FolioContrato, 6, 0)
            ) AS Folio,
            A.FInicio,
            'CMU' AS Emp,
            CONCAT(
                C.Nombre,
                ' ',
                C.Apellido1,
                ' ',
                C.Apellido2
            ) AS Ejecutivo,
            A. STATUS,
            A.IDCliente AS idcte,
            B.IDEjecutivo AS ideje,
            A.Solicitado,
            A.IDOrigenRecursos,
            D.Nombre AS recursos,
            A.SaldoFinanciar,
            A.TipoTasa,
            A.Tasa,
            A.PAdicional,
            A.TasaTotal,
            A.Plazo,
            A.SPlazo,
            A.Revolvencias,
            A.Deposito,
            A.pEnganche,
            A.Sector,
            A.Descripcion,
            A.PComision,
            A.TipoContrato,
            E.tipo as tipocte
        FROM
            sibware.2_ac_analisiscredito A
        INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
        INNER JOIN sibware.personal C ON B.IDEjecutivo = C.ID
        INNER JOIN sibware.2_entorno_origenrecursos D ON A.IDOrigenRecursos = D.ID
        INNER JOIN sibware.2_entorno_tipocliente E ON B.IDTipoCliente=E.ID
        WHERE
            A.ID=$idac");
         
        }elseif ($emp==3) {
            $queryResult=$pdo->query("SELECT
            CONCAT(
                B.Nombre,
                ' ',
                B.Apellido1,
                ' ',
                B.Apellido2
            ) AS Cliente,
            CONCAT(
                A.TipoContrato,
                '-',
                LPAD(A.FolioContrato, 6, 0)
            ) AS Folio,
            A.FInicio,
            'CMA' AS Emp,
            CONCAT(
                C.Nombre,
                ' ',
                C.Apellido1,
                ' ',
                C.Apellido2
            ) AS Ejecutivo,
            A. STATUS,
            A.IDCliente AS idcte,
            B.IDEjecutivo AS ideje,
            A.Solicitado,
            A.IDOrigenRecursos,
            D.Nombre AS recursos,
            A.SaldoFinanciar,
            A.TipoTasa,
            A.Tasa,
            A.PAdicional,
            A.TasaTotal,
            A.Plazo,
            A.SPlazo,
            A.Revolvencias,
            A.Deposito,
            A.pEnganche,
            A.Sector,
            A.Descripcion,
            A.PComision,
            A.TipoContrato,
            E.tipo as tipocte
        FROM
            sibware.3_ac_analisiscredito A
        INNER JOIN sibware.3_cliente B ON A.IDCliente = B.ID
        INNER JOIN sibware.personal C ON B.IDEjecutivo = C.ID
        INNER JOIN sibware.3_entorno_origenrecursos D ON A.IDOrigenRecursos = D.ID
        INNER JOIN sibware.2_entorno_tipocliente E ON B.IDTipoCliente=E.ID
        WHERE
            A.ID=$idac");
        }
    }
?>    

<?php
    /////fin de contenido
    require_once 'footer.php';
?>
