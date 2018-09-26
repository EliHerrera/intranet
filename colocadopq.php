<?php

//enero Cuenta Corriente
$queryResult = $pdo->query("SELECT
    SUM(A.Disposicion) AS Colocado
FROM
    sibware.2_contratos_disposicion A
INNER JOIN  sibware.2_contratos B on A.IDContrato=B.ID
INNER JOIN sibware.2_cliente C on B.IDCliente=C.ID
WHERE
    (
        A.FInicio >= '2018-01-01'
        AND A.FInicio <= '2018-01-31'
    )
AND B.IDTipoCredito=5
AND B.`status`<>'C' AND B.status<>'-'");
                    
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {

                        if(empty($row['Colocado'])){$ene=0;}else{$ene=$row['Colocado'];}
                    }



//febrero   cuenta corriente
$queryResult = $pdo->query("SELECT
    SUM(A.Disposicion) AS Colocado
FROM
    sibware.2_contratos_disposicion A
INNER JOIN  sibware.2_contratos B on A.IDContrato=B.ID
INNER JOIN sibware.2_cliente C on B.IDCliente=C.ID
WHERE
    (
        A.FInicio >= '2018-02-01'
        AND A.FInicio <= '2018-02-28'
    )
AND B.IDTipoCredito=5
AND B.`status`<>'C' AND B.status<>'-'");
                    
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {

                        if(empty($row['Colocado'])){$feb=0;}else{$feb=$row['Colocado'];}
                    }                    
                        # code...
                    
//marzo   cuenta corriente                 
 $queryResult = $pdo->query("SELECT
    SUM(A.Disposicion) AS Colocado
FROM
    sibware.2_contratos_disposicion A
INNER JOIN  sibware.2_contratos B on A.IDContrato=B.ID
INNER JOIN sibware.2_cliente C on B.IDCliente=C.ID
WHERE
    (
        A.FInicio >= '2018-03-01'
        AND A.FInicio <= '2018-03-31'
    )
AND B.IDTipoCredito=5
AND B.`status`<>'C' AND B.status<>'-'");
                    
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {

                        if(empty($row['Colocado'])){$mar=0;}else{$mar=$row['Colocado'];}}                    
                        # code...                    
//abril   cuenta corriente                 
 $queryResult = $pdo->query("SELECT
    SUM(A.Disposicion) AS Colocado
FROM
    sibware.2_contratos_disposicion A
INNER JOIN  sibware.2_contratos B on A.IDContrato=B.ID
INNER JOIN sibware.2_cliente C on B.IDCliente=C.ID
WHERE
    (
        A.FInicio >= '2018-04-01'
        AND A.FInicio <= '2018-04-30'
    )
AND B.IDTipoCredito=5
AND B.`status`<>'C' AND B.status<>'-'");
                    
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {

                        if(empty($row['Colocado'])){$abr=0;}else{$abr=$row['Colocado'];}}                     
                        # code...
//mayo   cuenta corriente                 
 $queryResult = $pdo->query("SELECT
    SUM(A.Disposicion) AS Colocado
FROM
    sibware.2_contratos_disposicion A
INNER JOIN  sibware.2_contratos B on A.IDContrato=B.ID
INNER JOIN sibware.2_cliente C on B.IDCliente=C.ID
WHERE
    (
        A.FInicio >= '2018-05-01'
        AND A.FInicio <= '2018-05-31'
    )
AND B.IDTipoCredito=5
AND B.`status`<>'C' AND B.status<>'-'");
                    
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {

                        if(empty($row['Colocado'])){$may=0;}else{$may=$row['Colocado'];}}                   
                        # code...

//junio   cuenta corriente                 
 $queryResult = $pdo->query("SELECT
    SUM(A.Disposicion) AS Colocado
FROM
    sibware.2_contratos_disposicion A
INNER JOIN  sibware.2_contratos B on A.IDContrato=B.ID
INNER JOIN sibware.2_cliente C on B.IDCliente=C.ID
WHERE
    (
        A.FInicio >= '2018-06-01'
        AND A.FInicio <= '2018-06-30'
    )
AND B.IDTipoCredito=5
AND B.`status`<>'C' AND B.status<>'-'");
                    
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {

                        if(empty($row['Colocado'])){$jun=0;}else{$jun=$row['Colocado'];}}                    
                        # code...
//julio   cuenta corriente                 
 $queryResult = $pdo->query("SELECT
    SUM(A.Disposicion) AS Colocado
FROM
    sibware.2_contratos_disposicion A
INNER JOIN  sibware.2_contratos B on A.IDContrato=B.ID
INNER JOIN sibware.2_cliente C on B.IDCliente=C.ID
WHERE
    (
        A.FInicio >= '2018-07-01'
        AND A.FInicio <= '2018-07-31'
    )
AND B.IDTipoCredito=5
AND B.`status`<>'C' AND B.status<>'-'");
                    
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {

                        if(empty($row['Colocado'])){$jul=0;}else{$jul=$row['Colocado'];}}                    
                        # code...

//agosto   cuenta corriente                 
 $queryResult = $pdo->query("SELECT
    SUM(A.Disposicion) AS Colocado
FROM
    sibware.2_contratos_disposicion A
INNER JOIN  sibware.2_contratos B on A.IDContrato=B.ID
INNER JOIN sibware.2_cliente C on B.IDCliente=C.ID
WHERE
    (
        A.FInicio >= '2018-08-01'
        AND A.FInicio <= '2018-08-31'
    )
AND B.IDTipoCredito=5
AND B.`status`<>'C' AND B.status<>'-'");
                    
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {

                        if(empty($row['Colocado'])){$ago=0;}else{$ago=$row['Colocado'];}}                     
                        # code...

//septiembre   cuenta corriente                 
 $queryResult = $pdo->query("SELECT
    SUM(A.Disposicion) AS Colocado
FROM
    sibware.2_contratos_disposicion A
INNER JOIN  sibware.2_contratos B on A.IDContrato=B.ID
INNER JOIN sibware.2_cliente C on B.IDCliente=C.ID
WHERE
    (
        A.FInicio >= '2018-09-01'
        AND A.FInicio <= '2018-09-30'
    )
AND B.IDTipoCredito=5
AND B.`status`<>'C' AND B.status<>'-'");
                    
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {

                        if(empty($row['Colocado'])){$sep=0;}else{$sep=$row['Colocado'];}}                    
                        # code...

//octubre   cuenta corriente                 
 $queryResult = $pdo->query("SELECT
    SUM(A.Disposicion) AS Colocado
FROM
    sibware.2_contratos_disposicion A
INNER JOIN  sibware.2_contratos B on A.IDContrato=B.ID
INNER JOIN sibware.2_cliente C on B.IDCliente=C.ID
WHERE
    (
        A.FInicio >= '2018-10-01'
        AND A.FInicio <= '2018-10-31'
    )
AND B.IDTipoCredito=5
AND B.`status`<>'C' AND B.status<>'-'");
                    
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) { 

                        if(empty($row['Colocado'])){$oct=0;}else{$oct=$row['Colocado'];}}                   
                        # code...


//noviembre   cuenta corriente                 
 $queryResult = $pdo->query("SELECT
    SUM(A.Disposicion) AS Colocado
FROM
    sibware.2_contratos_disposicion A
INNER JOIN  sibware.2_contratos B on A.IDContrato=B.ID
INNER JOIN sibware.2_cliente C on B.IDCliente=C.ID
WHERE
    (
        A.FInicio >= '2018-11-01'
        AND A.FInicio <= '2018-11-30'
    )
AND B.IDTipoCredito=5
AND B.`status`<>'C' AND B.status<>'-'");
                    
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {

                        if(empty($row['Colocado'])){$nov=0;}else{$nov=$row['Colocado'];}}                   
                        # code...
//julio   cuenta corriente                 
 $queryResult = $pdo->query("SELECT
    SUM(A.Disposicion) AS Colocado
FROM
    sibware.2_contratos_disposicion A
INNER JOIN  sibware.2_contratos B on A.IDContrato=B.ID
INNER JOIN sibware.2_cliente C on B.IDCliente=C.ID
WHERE
    (
        A.FInicio >= '2018-12-01'
        AND A.FInicio <= '2018-12-31'
    )
AND B.IDTipoCredito=5
AND B.`status`<>'C' AND B.status<>'-'");
                    
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {

                        if(empty($row['Colocado'])){$dic=0;}else{$dic=$row['Colocado'];}}                   
                        # code...






                ?>