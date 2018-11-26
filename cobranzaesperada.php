<?php
    require_once 'header.php';
    if (!empty($_GET)) {
        $m=$_GET['m'];
        $y=$_GET['y'];
        $p=$_GET['p'];
        $e=$_GET['e'];
        if ($idnivel>=2) {
            $deletequery=$pdo->prepare("DELETE FROM Intranet.cobranzaesperada WHERE mesp=$m AND yyp=$y ");
            $deletequery->execute();
        }
        echo "<div class='alert alert-danger'>";
            echo "    <strong>Aviso!</strong> Se ha eliminado el periodo ".$m." del año ".$y;
            echo "</div>";
    }           
    if (!empty($_POST)) {
    $mesp=$_POST['mes'];
    $yyp=$_POST['yy'];    
    $queryResult=$pdo->query("SELECT * FROM Intranet.cobranzaesperada WHERE mesp=$_POST[mes] AND yyp=$_POST[yy]");
    $row_count = $queryResult->rowCount(); 
    if ($row_count>0) {
        echo "<div class='alert alert-danger'>";
        echo "    <strong>Aviso!</strong> Este Periodo ya esta Procesado";
        echo "</div>";

    }else {
        $fecha=$_POST['yy']."-".$_POST['mes']."-01";
        $fechaini = new DateTime($fecha);
        $fechaini->modify('first day of this month');
        $fini=$fechaini->format('Y-m-d'); 
        $fechafin = new DateTime($fecha);
        $fechafin->modify('last day of this month');
        $ffin=$fechafin->format('Y-m-d'); 
        
        ###inicio calculo de creditos
        $queryResult=$pdo->query("SELECT
        CONCAT(
            D.Nombre,
            ' ',
            D.Apellido1,
            ' ',
            D.Apellido2
        ) AS Ejecutivo,
        CONCAT(
            C.Nombre,
            ' ',
            C.Apellido1,
            ' ',
            C.Apellido2
        ) AS Socio,
        CONCAT('CR-', LPAD(B.Folio, 6, 0)) AS Folio,
        A.renglon as Disp,
        A.ID as IDDisp,
        B.Tasa,            
	    B.PAdicional,
        B.TasaTotal,
        B.TipoTasa,
        E.FInicial,
        E.FFinal,
        DATEDIFF(E.FFinal,E.FInicial) as dias,
        E.Saldo,
        E.Capital,
        E.FInicial,
        E.FFinal,
        E.FPago,
        E.renglon as Periodo,
        MONTH(E.FFinal) as mes,
        YEAR(E.FFinal) as yy,
        C.IDSucursal, 
        D.ID as IDEjecutivo,
        B.ID as IDCto,   
        C.ID as IDCte,
        F.Nombre as Sucursal,
        G.tipo as TipoCte      
        FROM
        sibware.2_contratos_disposicion A
        INNER JOIN sibware.2_contratos B ON A.IDContrato = B.ID
        INNER JOIN sibware.2_cliente C ON B.IDCliente = C.ID
        INNER JOIN sibware.sucursal F ON C.IDSucursal=F.ID
        INNER JOIN sibware.2_entorno_tipocliente G ON C.IDTipoCliente=G.ID
        INNER JOIN sibware.personal D ON C.IDEjecutivo = D.ID
        INNER JOIN sibware.2_contratos_disposicion_movs E ON E.IDDisposicion = A.ID
        WHERE
        B.status <> 'C'
        AND B.status <> '-'
        AND B.status<>'P'
        AND E.Fpago BETWEEN '$fini'
        AND '$ffin'");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $idcto=$row['IDCto'];
            $idejecutivo=$row['IDEjecutivo'];
            $idsucursal=$row['IDSucursal'];
            $folio=$row['Folio'];
            $padicional=$row['PAdicional']; 
            $tipotasa=$row['TipoTasa'];
            $saldo=$row['Saldo'];
            $diasp=$row['dias'];
            $iddisp=$row['IDDisp'];
            $finicial=$row['FInicial'];
            $ffinal=$row['FFinal'];
            $periodo=$row['Periodo'];
            $disposicion=$row['Disp'];
            $fechapago=$row['FPago'];
            $mes=$row['mes'];
            $yy=$row['yy'];
            $capital=$row['Capital'];
            $idcte=$row['IDCte'];
            $cliente=$row['Socio'];
            $ejecutivo=$row['Ejecutivo'];
            $sucursal=$row['Sucursal'];
            $tipocte=$row['TipoCte'];
            $queryResult2=$pdo->query("SELECT sibware.gTIIE($mes,$yy) as tiim");
            while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
                $tiiem=$row['tiim']; 
            }    
            if ($tipotasa=='Variable') {
                $tasa=$tiiem;
            } else {
                $tasa=$row['Tasa'];
            } 
            $queryResult3=$pdo->query("SELECT
            sum(A.Capital) AS PagoCapital,
            sum(A.InteresOrdinario) As PagoInteres,
            (sum(A.InteresMoratorio)+SUM(A.IvaInteresMoratorio)+sum(A.Pena)+sum(A.IvaPena)) as PagoMoras
            FROM
                sibware.2_contratos_disposicion_pagos_detalle A
            INNER JOIN sibware.2_contratos_disposicion_pagos B ON A.IDMov = B.ID
            WHERE
                A.IDDisposicion = $iddisp
            AND B.FPago >= '$finicial'
            AND B.Fpago <= '$ffinal'"); 
            while ($row=$queryResult3->fetch(PDO::FETCH_ASSOC)) {
                   $pagocapital=$row['PagoCapital']; 
                   $pagointeres=$row['PagoInteres'];
                   $pagomoras=$row['PagoMoras'];
            }  
            if (empty($pagocapital)) {
                $pagocapital=0;
            } 
            if (empty($pagointeres)) {
                $pagointeres=0;
            } 
            if(empty($pagomoras)){
                $pagomoras=0;
            }       
            $tiie=$tasa+$padicional;
            $saldoprom=(($saldo*$diasp)-$pagocapital)/$diasp;
            $interes=($saldoprom*($tiie/100)/360)*$diasp;
            
            $queryInsert=$pdo->prepare("INSERT INTO Intranet.cobranzaesperada (IDContrato,IDDisposicion,IDEjecutivo,IDSucursal,Folio,Saldo,SaldoProm,Tasa,diasp,mes,yy,producto,emp,periodo,disposicion,fechapago,capitalesperado,capitalpagado,interesesperado,interespagado,moraspagadas,mesp,yyp,cliente,IDCliente,ejecutivo,sucursal,tipocte,IvaCapitalEsperado,IvaCapitalPagado,RentaEsperada,IvaRentaEsperada,RentaPagada,IvaRentaPagada,IvaInteresEsperado,IvaInteresPagado)
                                                                      VALUES($idcto,$iddisp,$idejecutivo,$idsucursal,'$folio',$saldo,$saldoprom,$tiie,$diasp,$mes,$yy,'CR',2,$periodo,$disposicion,'$fechapago',$capital,$pagocapital,$interes,$pagointeres,$pagomoras,$mesp,$yyp,'$cliente',$idcte,'$ejecutivo','$sucursal','$tipocte',0,0,0,0,0,0,0,0) ");            
            $queryInsert->execute();           
        }
        ##fin calculo de creditos
        ###inicio calculo de ap cmu
        $queryResult=$pdo->query("SELECT
        CONCAT(
            D.Nombre,
            ' ',
            D.Apellido1,
            ' ',
            D.Apellido2
        ) AS Ejecutivo,
        CONCAT(
            C.Nombre,
            ' ',
            C.Apellido1,
            ' ',
            C.Apellido2
        ) AS Socio,
        CONCAT('AP-', LPAD(B.Folio, 6, 0)) AS Folio,
        A.renglon as Disp,
        A.ID as IDDisp,
        B.Tasa,            
	    B.PAdicional,
        B.TasaTotal,
        B.TipoTasa,
        E.FInicial,
        E.FFinal,
        DATEDIFF(E.FFinal,E.FInicial) as dias,
        E.Renta,
        E.IvaRenta,
        E.FInicial,
        E.FFinal,
        E.FInicial as FPago,
        E.renglon as Periodo,
        MONTH(E.FInicial) as mes,
        YEAR(E.FInicial) as yy,
        C.IDSucursal, 
        D.ID as IDEjecutivo,
        B.ID as IDCto,   
        C.ID as IDCte,
        F.Nombre as Sucursal,
        G.tipo as TipoCte      
        FROM
        sibware.2_ap_disposicion A
        INNER JOIN sibware.2_ap_contrato B ON A.IDContrato = B.ID
        INNER JOIN sibware.2_cliente C ON B.IDCliente = C.ID
        INNER JOIN sibware.sucursal F ON C.IDSucursal=F.ID
        INNER JOIN sibware.2_entorno_tipocliente G ON C.IDTipoCliente=G.ID
        INNER JOIN sibware.personal D ON C.IDEjecutivo = D.ID
        INNER JOIN sibware.2_ap_disposicion_movs E ON E.IDDisposicion = A.ID
        WHERE
        B.status <> 'C'
        AND B.status <> '-'
        AND B.status<>'P'
        AND E.FInicial BETWEEN '$fini'
        AND '$ffin'");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $idcto=$row['IDCto'];
            $idejecutivo=$row['IDEjecutivo'];
            $idsucursal=$row['IDSucursal'];
            $folio=$row['Folio'];
            $padicional=$row['PAdicional']; 
            $tipotasa=$row['TipoTasa'];
            #$saldo=$row['Saldo'];
            $diasp=$row['dias'];
            $iddisp=$row['IDDisp'];
            $finicial=$row['FInicial'];
            $ffinal=$row['FFinal'];
            $periodo=$row['Periodo'];
            $disposicion=$row['Disp'];
            $fechapago=$row['FPago'];
            $mes=$row['mes'];
            $yy=$row['yy'];
            $renta=$row['Renta'];
            $ivarenta=$row['IvaRenta'];
            $idcte=$row['IDCte'];
            $cliente=$row['Socio'];
            $ejecutivo=$row['Ejecutivo'];
            $sucursal=$row['Sucursal'];
            $tipocte=$row['TipoCte'];
            $queryResult2=$pdo->query("SELECT sibware.gTIIE($mes,$yy) as tiim");
            while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
                $tiiem=$row['tiim']; 
            }    
            if ($tipotasa=='Variable') {
                $tasa=$tiiem;
            } else {
                $tasa=$row['Tasa'];
            } 
            $queryResult3=$pdo->query("SELECT
            sum(A.Renta) AS PagoRenta,
            sum(A.IvaRenta) As PagoIvaRenta,
            (sum(A.InteresMoratorio)+SUM(A.IvaInteresMoratorio)) as PagoMoras
            FROM
                sibware.2_ap_disposicion_pagos_detalle A
            INNER JOIN sibware.2_ap_disposicion_pagos B ON A.IDMov = B.ID
            WHERE
                A.IDDisposicion = $iddisp
            AND B.FPago >= '$finicial'
            AND B.FPago <= '$ffinal'"); 
            while ($row=$queryResult3->fetch(PDO::FETCH_ASSOC)) {
                   $pagorenta=$row['PagoRenta']; 
                   $pagoivarenta=$row['PagoIvaRenta'];
                   $pagomorasap=$row['PagoMoras'];
            }  
            if (empty($pagorenta)) {
                $pagorenta=0;
            } 
            if (empty($pagoivarenta)) {
                $pagoivarenta=0;
            }  
            if(empty($pagomorasap)){
                $pagomorasap=0;
            }      
            $tiie=$tasa+$padicional;
            // $saldoprom=(($saldo*$diasp)-$pagocapital)/$diasp;
            // $interes=($saldoprom*($tiie/100)/360)*$diasp;
            
            $queryInsert=$pdo->prepare("INSERT INTO Intranet.cobranzaesperada (IDContrato,IDDisposicion,IDEjecutivo,IDSucursal,Folio,Saldo,SaldoProm,Tasa,diasp,mes,yy,producto,emp,periodo,disposicion,fechapago,capitalesperado,capitalpagado,interesesperado,interespagado,rentaesperada,rentapagada,IvaRentaEsperada,IvaRentaPagada,moraspagadas,mesp,yyp,cliente,IDCliente,ejecutivo,sucursal,tipocte,IvaCapitalEsperado,IvaCapitalPagado,IvaInteresEsperado,IvaInteresPagado)
                                                                      VALUES($idcto,$iddisp,$idejecutivo,$idsucursal,'$folio',0,0,$tiie,$diasp,$mes,$yy,'AP',2,$periodo,$disposicion,'$fechapago',0,0,0,0,$renta,$pagorenta,$ivarenta,$pagoivarenta,$pagomoras,$mesp,$yyp,'$cliente',$idcte,'$ejecutivo','$sucursal','$tipocte',0,0,0,0) ");            
            $queryInsert->execute();           
        }
        ##fin calculo de ap cmu
        ###inicio calculo de ap cma
        $queryResult=$pdo->query("SELECT
        CONCAT(
            D.Nombre,
            ' ',
            D.Apellido1,
            ' ',
            D.Apellido2
        ) AS Ejecutivo,
        CONCAT(
            C.Nombre,
            ' ',
            C.Apellido1,
            ' ',
            C.Apellido2
        ) AS Socio,
        CONCAT('AP-', LPAD(B.Folio, 6, 0)) AS Folio,
        A.renglon as Disp,
        A.ID as IDDisp,
        B.Tasa,            
	    B.PAdicional,
        B.TasaTotal,
        B.TipoTasa,
        E.FInicial,
        E.FFinal,
        DATEDIFF(E.FFinal,E.FInicial) as dias,
        E.Renta,
        E.IvaRenta,
        E.FInicial,
        E.FFinal,
        E.FInicial as FPago,
        E.renglon as Periodo,
        MONTH(E.FInicial) as mes,
        YEAR(E.FInicial) as yy,
        C.IDSucursal, 
        D.ID as IDEjecutivo,
        B.ID as IDCto,   
        C.ID as IDCte,
        F.Nombre as Sucursal,
        G.tipo as TipoCte      
        FROM
        sibware.3_ap_disposicion A
        INNER JOIN sibware.3_ap_contrato B ON A.IDContrato = B.ID
        INNER JOIN sibware.3_cliente C ON B.IDCliente = C.ID
        INNER JOIN sibware.sucursal F ON C.IDSucursal=F.ID
        INNER JOIN sibware.3_entorno_tipocliente G ON C.IDTipoCliente=G.ID
        INNER JOIN sibware.personal D ON C.IDEjecutivo = D.ID
        INNER JOIN sibware.3_ap_disposicion_movs E ON E.IDDisposicion = A.ID
        WHERE
        B.status <> 'C'
        AND B.status <> '-'
        AND B.status<>'P'
        AND E.FInicial BETWEEN '$fini'
        AND '$ffin'");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $idcto=$row['IDCto'];
            $idejecutivo=$row['IDEjecutivo'];
            $idsucursal=$row['IDSucursal'];
            $folio=$row['Folio'];
            $padicional=$row['PAdicional']; 
            $tipotasa=$row['TipoTasa'];
            #$saldo=$row['Saldo'];
            $diasp=$row['dias'];
            $iddisp=$row['IDDisp'];
            $finicial=$row['FInicial'];
            $ffinal=$row['FFinal'];
            $periodo=$row['Periodo'];
            $disposicion=$row['Disp'];
            $fechapago=$row['FPago'];
            $mes=$row['mes'];
            $yy=$row['yy'];
            $renta=$row['Renta'];
            $ivarenta=$row['IvaRenta'];
            $idcte=$row['IDCte'];
            $cliente=$row['Socio'];
            $ejecutivo=$row['Ejecutivo'];
            $sucursal=$row['Sucursal'];
            $tipocte=$row['TipoCte'];
            $queryResult2=$pdo->query("SELECT sibware.gTIIE($mes,$yy) as tiim");
            while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
                $tiiem=$row['tiim']; 
            }    
            if ($tipotasa=='Variable') {
                $tasa=$tiiem;
            } else {
                $tasa=$row['Tasa'];
            } 
            $queryResult3=$pdo->query("SELECT
            sum(A.Renta) AS PagoRenta,
            sum(A.IvaRenta) As PagoIvaRenta,
            (sum(A.InteresMoratorio)+SUM(A.IvaInteresMoratorio)) as PagoMoras
            FROM
                sibware.3_ap_disposicion_pagos_detalle A
            INNER JOIN sibware.2_ap_disposicion_pagos B ON A.IDMov = B.ID
            WHERE
                A.IDDisposicion = $iddisp
            AND B.FPago >= '$finicial'
            AND B.FPago <= '$ffinal'"); 
            while ($row=$queryResult3->fetch(PDO::FETCH_ASSOC)) {
                   $pagorenta=$row['PagoRenta']; 
                   $pagoivarenta=$row['PagoIvaRenta'];
                   $pagomorasap=$row['PagoMoras'];
            }  
            if (empty($pagorenta)) {
                $pagorenta=0;
            } 
            if (empty($pagoivarenta)) {
                $pagoivarenta=0;
            }   
            if (empty($pagomorasap)) {
                $pagomorasap=0;
            }      
            $tiie=$tasa+$padicional;
            // $saldoprom=(($saldo*$diasp)-$pagocapital)/$diasp;
            // $interes=($saldoprom*($tiie/100)/360)*$diasp;
            
            $queryInsert=$pdo->prepare("INSERT INTO Intranet.cobranzaesperada (IDContrato,IDDisposicion,IDEjecutivo,IDSucursal,Folio,Saldo,SaldoProm,Tasa,diasp,mes,yy,producto,emp,periodo,disposicion,fechapago,capitalesperado,capitalpagado,interesesperado,interespagado,rentaesperada,rentapagada,IvaRentaEsperada,IvaRentaPagada,moraspagadas,mesp,yyp,cliente,IDCliente,ejecutivo,sucursal,tipocte,IvaCapitalEsperado,IvaCapitalPagado,IvaInteresEsperado,IvaInteresPagado)
                                                                      VALUES($idcto,$iddisp,$idejecutivo,$idsucursal,'$folio',0,0,$tiie,$diasp,$mes,$yy,'AP',3,$periodo,$disposicion,'$fechapago',0,0,0,0,$renta,$pagorenta,$ivarenta,$pagoivarenta,$pagomorasap,$mesp,$yyp,'$cliente',$idcte,'$ejecutivo','$sucursal','$tipocte',0,0,0,0) ");            
            $queryInsert->execute();           
        }
        ##fin calculo de ap cma
        ###inicio calculo de vp cma
        $queryResult=$pdo->query("SELECT
        CONCAT(
            D.Nombre,
            ' ',
            D.Apellido1,
            ' ',
            D.Apellido2
        ) AS Ejecutivo,
        CONCAT(
            C.Nombre,
            ' ',
            C.Apellido1,
            ' ',
            C.Apellido2
        ) AS Socio,
        CONCAT('VP-', LPAD(B.Folio, 6, 0)) AS Folio,
        A.renglon as Disp,
        A.ID as IDDisp,
        B.Tasa,            
	    B.PAdicional,
        B.TasaTotal,
        B.TipoTasa,
        E.FInicial,
        E.FFinal,
        DATEDIFF(E.FFinal,E.FInicial) as dias,
        E.Saldo,
        E.Capital,
        E.IvaCapital,
        E.FInicial,
        E.FFinal,
        E.FFinal as FPago,
        E.renglon as Periodo,
        MONTH(E.FFinal) as mes,
        YEAR(E.FFinal) as yy,
        C.IDSucursal, 
        D.ID as IDEjecutivo,
        B.ID as IDCto,   
        C.ID as IDCte,
        F.Nombre as Sucursal,
        G.tipo as TipoCte      
        FROM
        sibware.3_vp_disposicion A
        INNER JOIN sibware.3_vp_contrato B ON A.IDContrato = B.ID
        INNER JOIN sibware.3_cliente C ON B.IDCliente = C.ID
        INNER JOIN sibware.sucursal F ON C.IDSucursal=F.ID
        INNER JOIN sibware.3_entorno_tipocliente G ON C.IDTipoCliente=G.ID
        INNER JOIN sibware.personal D ON C.IDEjecutivo = D.ID
        INNER JOIN sibware.3_vp_disposicion_movs E ON E.IDDisposicion = A.ID
        WHERE
        B.status <> 'C'
        AND B.status <> '-'
        AND B.status<>'P'
        AND E.FFinal BETWEEN '$fini'
        AND '$ffin'");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $idcto=$row['IDCto'];
            $idejecutivo=$row['IDEjecutivo'];
            $idsucursal=$row['IDSucursal'];
            $folio=$row['Folio'];
            $padicional=$row['PAdicional']; 
            $tipotasa=$row['TipoTasa'];
            $saldo=$row['Saldo'];
            $diasp=$row['dias'];
            $iddisp=$row['IDDisp'];
            $finicial=$row['FInicial'];
            $ffinal=$row['FFinal'];
            $periodo=$row['Periodo'];
            $disposicion=$row['Disp'];
            $fechapago=$row['FPago'];
            $mes=$row['mes'];
            $yy=$row['yy'];
            $capital=$row['Capital'];
            $ivacapital=$row['IvaCapital'];
            $idcte=$row['IDCte'];
            $cliente=$row['Socio'];
            $ejecutivo=$row['Ejecutivo'];
            $sucursal=$row['Sucursal'];
            $tipocte=$row['TipoCte'];
            $queryResult2=$pdo->query("SELECT sibware.gTIIE($mes,$yy) as tiim");
            while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
                $tiiem=$row['tiim']; 
            }    
            if ($tipotasa=='Variable') {
                $tasa=$tiiem;
            } else {
                $tasa=$row['Tasa'];
            } 
            $queryResult3=$pdo->query("SELECT
            sum(A.Capital) AS PagoCapital,
            sum(A.InteresOrdinario) As PagoInteres,
            sum(A.IvaCapital) as IvaPagoCapital,
            sum(A.IvaInteresOrdinario) as IvaPagoInteres,
            (sum(A.InteresMoratorio)+SUM(A.IvaInteresMoratorio)) as PagoMoras
            FROM
                sibware.3_vp_disposicion_pagos_detalle A
            INNER JOIN sibware.3_vp_disposicion_pagos B ON A.IDMov = B.ID
            WHERE
                A.IDDisposicion = $iddisp
            AND B.FPago >= '$finicial'
            AND B.Fpago <= '$ffinal'"); 
            while ($row=$queryResult3->fetch(PDO::FETCH_ASSOC)) {
                   $pagocapital=$row['PagoCapital']; 
                   $pagointeres=$row['PagoInteres'];
                   $ivapagocapital=$row['IvaPagoCapital'];
                   $ivapagointeres=$row['IvaPagoInteres'];
                   $pagomorasvp=$row['PagoMoras'];
            }  
            if (empty($pagocapital)) {
                $pagocapital=0;
            } 
            if (empty($pagointeres)) {
                $pagointeres=0;
            } 
            if (empty($ivapagointeres)) {
                $ivapagointeres=0;
            } 
            if (empty($ivapagocapital)) {
                $ivapagocapital=0;
            } 
            if(empty($pagomorasvp)) {
                $pagomorasvp=0;
            }
                
            $tiie=$tasa+$padicional;
            $saldoprom=(($saldo)-$pagocapital);
            $interes=($saldoprom*($tiie/100)/360)*$diasp;
            $ivainteres=$interes*.16;
            
            $queryInsert=$pdo->prepare("INSERT INTO Intranet.cobranzaesperada (IDContrato,IDDisposicion,IDEjecutivo,IDSucursal,Folio,Saldo,SaldoProm,Tasa,diasp,mes,yy,producto,emp,periodo,disposicion,fechapago,capitalesperado,capitalpagado,interesesperado,interespagado,moraspagadas,mesp,yyp,cliente,IDCliente,ejecutivo,sucursal,tipocte,IvaCapitalEsperado,IvaCapitalPagado,RentaEsperada,IvaRentaEsperada,RentaPagada,IvaRentaPagada,IvaInteresEsperado,IvaInteresPagado)
                                                                      VALUES($idcto,$iddisp,$idejecutivo,$idsucursal,'$folio',$saldo,$saldoprom,$tiie,$diasp,$mes,$yy,'VP',3,$periodo,$disposicion,'$fechapago',$capital,$pagocapital,$interes,$pagointeres,$pagomorasvp,$mesp,$yyp,'$cliente',$idcte,'$ejecutivo','$sucursal','$tipocte',$ivacapital,$ivapagocapital,0,0,0,0,$ivainteres,$ivapagointeres) ");            
            $queryInsert->execute();           
        }
        ##fin calculo de vp cma
        echo "<div class='alert alert-success'>";
        echo "    <strong>Exito!</strong> Procesado con Exito!";
        echo "</div>";
    }
}  
?>
<?php    

?>
<form action="cobranzaesperada.php" method="post">
<div class="row">
    <div class="col-xs-3">
        <label for="mes">Mes</label>
        <select name="mes" id="mes" class="form-control" required="true">
            <option value="">Seleciones mes...</option>
            <option value="01">Enero</option>
            <option value="02">Febrero</option>
            <option value="03">Marzo</option>
            <option value="04">Abril</option>
            <option value="05">Mayo</option>
            <option value="06">Junio</option>
            <option value="07">Julio</option>
            <option value="08">Agosto</option>
            <option value="09">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
        </select>
    </div>
    <div class="col-xs-3">
        <label for="yy">Año</label>
        <select name="yy" id="yy" class="form-control" required="true">
            <option value="">Seleciones año...</option>
            <?php
                $queryResult=$pdo->query("SELECT * FROM Intranet.yys");                
                while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='".$row['yy']."'>".$row['yy']."</option>";
                }
            ?>
        </select> 
    </div>
    <div class="col-xs-2">
        <br><input type="submit" value="Procesar" id="procesar" class="button">
    </div>
</div>
    
</form>
<h3>Cobranza Esperada</h3>
<table class="table">
    <tr><th>Empresa</th><th>Producto</th><th>Mes</th><th>Año</th><th>Capital/Renta Esperado</th><th>Capital/Renta Recibido</th><th>Interes Esperado</th><th>Interes Pagado</th><th>Acciones</th></tr>
    <?php
        $queryResult=$pdo->query("SELECT
        mesp,
        yyp,
        emp,
        producto,
        SUM(capitalesperado) + SUM(RentaEsperada) + SUM(IvaCapitalEsperado) AS capitalesperado,
	    SUM(capitalpagado) + SUM(RentaPagada) + SUM(IvaCapitalPagado) AS capitalpagado,
	    SUM(interesesperado) AS interesesperado,
	    SUM(interespagado) AS interespagado
    FROM
        Intranet.cobranzaesperada
    GROUP BY
    emp,
	producto,
	mesp,
	yyp
    ORDER BY
        emp ASC ");
        
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            if ($row['emp']==2) {
                $empresa='CMU';
            }elseif ($row['emp']==3) {
                $empresa='CMA';
            }
            switch ($row['producto']) {
                case 'CR':
                    $producto='Creditos';
                    break;
                case 'AP':
                    $producto='Arrendamientos';
                    break;
                case 'VP':
                    $producto='Venta Plazo';
                    break;
                case 'PR':
                    $producto='Prestamos';
                    break;
                
                default:
                    $producto='NA';
                    break;
            }
            echo "<tr><td>".$empresa."</td><td><a href='viewcobesperada.php?mes=".$row['mesp']."&yy=".$row['yyp']."&pro=".$row['producto']."&emp=".$row['emp']."'>".$producto."</a></td><td>".$row['mesp']."</td><td>".$row['yyp']."</td><td>".number_format($row['capitalesperado'],2)."</td><td>".number_format($row['capitalpagado'],2)."</td><td>".number_format($row['interesesperado'],2)."</td><td>".number_format($row['interespagado'],2)."</td></td><td>";
            if ($idnivel>=2) {
                echo "<a href='cobranzaesperada.php?m=".$row['mesp']."&y=".$row['yyp']."&p=".$row['producto']."&e=".$row['emp']."'><img src='img/icons/delete.png' alt=''></a>";
            }
            echo "</td></tr>";
        }
    ?>

</table>

<?php
    /////fin de contenido
    require_once 'footer.php';
?>
