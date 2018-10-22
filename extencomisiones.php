<?php
    require_once 'header.php';
    //////inicio de contenido
    $yy=date('Y');
    
    if (!empty($_GET['idcom'])) {
        $deletequery=$pdo->prepare("DELETE FROM Intranet.com_extensionistas WHERE ID=$_GET[idcom]");
        $deletequery->execute(); 
        echo "<div class='alert alert-danger'>";
        echo "    <strong>Aviso! </strong> Comision Eliminada!";
        echo "</div>";
    }
    if (!empty($_POST['calcular'])) {
        
        $periodo=$_POST['periodo'];
        $yy=$_POST['yy'];
        $pColCR=$_POST['pColCR'];
        $pColAP=$_POST['pColAP'];
        $pColVP=$_POST['pColVP'];
        $queryResult=$pdo->query("SELECT * FROM Intranet.param_com_extensionistas");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $idpersonalcom=$row['IDPersonal'];
            $porcc=$row['porcc'];
            $porcp=$row['porcp'];

            $queryResult2=$pdo->query("SELECT * FROM Intranet.com_extensionistas WHERE yy=$yy AND periodo=$periodo AND IDPersonal=$idpersonalcom");
            $row_count = $queryResult2->rowCount(); 
            if ($row_count==0) {
                $queryResult3=$pdo->query("SELECT B.Autorizado,B.PAPertura,B.NAPertura,A.IDPersonal FROM Intranet.asignacion_ctos_ext A INNER JOIN sibware.2_contratos B ON A.IDContrato=B.ID WHERE A.periodo=$periodo AND A.yy=$yy AND Producto='cr'");
                //var_dump($queryResult3);
                $row_count2 = $queryResult3->rowCount(); 
                if ($row_count2==0) {
                    $accr=0;
                    $acaccr=0;
                }else{
                        while ($row=$queryResult3->fetch(PDO::FETCH_ASSOC)) {
                            $autorizado=$row['Autorizado'];
                            $pAp=$row['PAPertura'];
                            $mAp=$row['NAPertura'];
                            $idpersonalasignado=$row['IDPersonal'];
                            $pCalcular=$pAp*100/pComi;
                            $montoCal=($pCalcular/100)*$autorizado;
                            $accr=$accr+$autorizado;
                            $acaccr=$acaccr+$montoCal;
                        }
                    }        
                $queryResult3=$pdo->query("SELECT B.Saldo as Autorizado,B.PAPertura,B.NAPertura,A.IDPersonal FROM Intranet.asignacion_ctos_ext A INNER JOIN sibware.2_ap_contrato B ON A.IDContrato=B.ID WHERE A.periodo=$periodo AND A.yy=$yy AND Producto='apu'");
                $row_count2 = $queryResult3->rowCount();
                if ($row_count2==0) {
                    $acap=0;
                    $acacap=0;
                }else{
                    while ($row=$queryResult3->fetch(PDO::FETCH_ASSOC)) {
                            $autorizado=$row['Autorizado'];
                            $pAp=$row['PAPertura'];
                            $mAp=$row['NAPertura'];
                            $idpersonalasignado=$row['IDPersonal'];
                            $pCalcular=$pAp*100/pComi;
                            $montoCal=($pCalcular/100)*$autorizado;
                            $acap=$acap+$autorizado;
                            $acacap=$acacap+$montoCal;
                    }
                }    
                
                $queryResult3=$pdo->query("SELECT B.Saldo as Autorizado,B.PAPertura,B.NAPertura,A.IDPersonal FROM Intranet.asignacion_ctos_ext A INNER JOIN sibware.3_ap_contrato B ON A.IDContrato=B.ID WHERE A.periodo=$periodo AND A.yy=$yy AND Producto='ap'");
                $row_count2 = $queryResult3->rowCount();
                $row_count2 = $queryResult3->rowCount();
                if ($row_count2==0) {
                    $acap=0;
                    $acacap=0;
                }else{
                        while ($row=$queryResult3->fetch(PDO::FETCH_ASSOC)) {
                            $autorizado=$row['Autorizado'];
                            $pAp=$row['PAPertura'];
                            $mAp=$row['NAPertura'];
                            $idpersonalasignado=$row['IDPersonal'];
                            $pCalcular=$pAp*100/pComi;
                            $montoCal=($pCalcular/100)*$autorizado;
                            $acap=$acap+$autorizado;
                            $acacap=$acacap+$montoCal;
                        }
                    }    
                $queryResult3=$pdo->query("SELECT B.SaldoFinal as Autorizado,B.PAPertura,B.NAPertura,A.IDPersonal FROM Intranet.asignacion_ctos_ext A INNER JOIN sibware.3_vp_contrato B ON A.IDContrato=B.ID WHERE A.periodo=$periodo AND A.yy=$yy AND Producto='vp'");
                $row_count2 = $queryResult3->rowCount();
                if ($row_count2==0) {
                    $acvp=0;
                    $acacvp=0;
                }else{
                        while ($row=$queryResult3->fetch(PDO::FETCH_ASSOC)) {
                            $autorizado=$row['Autorizado'];
                            $pAp=$row['PAPertura'];
                            $mAp=$row['NAPertura'];
                            $idpersonalasignado=$row['IDPersonal'];
                            $pCalcular=$pAp*100/pComi;
                            $montoCal=($pCalcular/100)*$autorizado;
                            $acvp=$acvp+$autorizado;
                            $acacvp=$acacvp+$montoCal;
                        }
                    }
                if ($idpersonalcom==$idpersonalasignado) {
                    $porc=$porcp;
                }else{
                    $porc=$porcc;
                }  
                $comcr=$acaccr*($porc/100);   
                $comvp=$acacvp*($porc/100);   
                $comap=$acacap*($porc/100);   
                $pColCR;
                $pColAP;
                $pColVP;
                if ($pColCR<90) {
                    $comcr=0;
                }
                if ($pColAP<90) {
                    $comap=0;
                }
                if ($pColVP<90) {
                    $comvp=0;
                }
                $insertquery=$pdo->prepare("INSERT INTO Intranet.com_extensionistas (IDPersonal,porcp,porcc,accr,acaccr,comcr,acap,acacap,comap,acvp,acacvp,comvp,periodo,yy,status) VALUES ($idpersonalcom,$porcp,$porcc,$accr,$acaccr,$comcr,$acap,$acacap,$comap,$acvp,$acacvp,$comvp,$periodo,$yy,1)");
                $insertquery->execute(); 
                //var_dump($insertquery);
               
            }


        }
        echo "<div class='alert alert-success'>";
        echo "    <strong>Exito! </strong> Comisiones Calculadas!";
        echo "</div>";
    }
    if(!empty($_POST['col'])){
        $queryResult=$pdo->query("SELECT * FROM Intranet.filtros_bi WHERE valor=$_POST[col]");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $fini=$row['fini'];
            $ffin=$row['ffin'];
            $yy=$row['yy'];
            $periodo=$row['periodo'];
            $valor=$row['valor'];
            $texto=$row['texto'];
        }
        $queryResult=$pdo->query("SELECT * FROM Intranet.metas_colocacion WHERE periodo=$periodo AND yy=$yy");
        //var_dump($queryResult);
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $metaCR=$row['metaCR'];
            $metaAP=$row['metaAP'];
            $metaVP=$row['metaVP'];
            $metaIN=$row['metaIN'];
            $pComi=$row['pComi'];
            $pCumpli=$row['pCumpli'];
            define("pComi", $pComi);
            define("metaCR",$metaCR);
            define("metaAP",$metaAP);
            define("metaVP",$metaVP);
            define(pcumpli,$pCumpli);
        }
    }
    
?>  
<h3>Relacion de Comisiones por Colocacion <?php echo $texto; ?></h3>

<form action="extencomisiones.php" method="post">
    <div class="row">
        <div class="col-xs-3">
            <label for="col">Periodo</label><select name="col" id="col" class="form-control"  onchange="this.form.submit();return false;">
                <option value="">Selecione periodo...</option>
                <?php
                    $queryResult=$pdo->query("SELECT * FROM Intranet.filtros_bi WHERE yy=$yy and periodo>0");
                    
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='".$row['valor']."'>".$row['texto']."</option>";
                    }
                ?>
            </select>
        </div>

    </div>
</form>
<table class="table">
    <tr><th>Producto</th><th>Monto Colocado</th><th>Meta</th><th>% de Cump.</th><th>Comision Cobrada</th><th>Periodo</th><th>Año</th></tr>
    <?php
    if(!empty($_POST)){
        $queryResult=$pdo->query("SELECT
        B.PApertura,
        B.NApertura,
        B.Autorizado,
        B.FInicio
    FROM
        sibware.2_contratos B 
    INNER JOIN sibware.2_cliente C ON B.IDCliente = C.ID
    INNER JOIN sibware.2_entorno_tipocliente E ON C.IDTipoCliente = E.ID
    WHERE
        B.FInicio BETWEEN '$fini'
    AND '$ffin'
    AND B. STATUS <> 'C'
    AND B. STATUS <> '-'
    AND (E.ID = 1 OR E.ID = 3)");
        $acumcolocado=0;
        $acumPCalcular=0;
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $colocado=$row['Autorizado'];
            $papertura=$row['PApertura'];
            $napertura=$row['NApertura'];
            $acumcolocado=$acumcolocado+$colocado;
            $acumapertura=$acumapertura+$napertura;
            $pCalcular=$papertura*100/pComi;
            $montoCal=($pCalcular/100)*$colocado;
            $acumPCalcular=$acumPCalcular+$montoCal;
            
        }
        $queryResult=$pdo->query("SELECT
        B.PApertura,
        B.NApertura,
        A.Disposicion,
        B.FInicio
    FROM
        sibware.2_contratos_disposicion A
    INNER JOIN sibware.2_contratos B ON A.IDContrato=B.ID 
    INNER JOIN sibware.2_cliente C ON B.IDCliente = C.ID
    INNER JOIN sibware.2_entorno_tipocliente E ON C.IDTipoCliente = E.ID
    WHERE
        A.FInicio BETWEEN '$fini'
    AND '$ffin'
    AND B. STATUS <> 'C'
    AND B. STATUS <> '-'
    AND (E.ID = 1 OR E.ID = 3)");  
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $dispuesto=$row['Disposicion'];
        $acumdispuesto=$acumdispuesto+$dispuesto;
    }  
        $pCol=($acumdispuesto/metaCR)*100;
        if ($pCol>=pcumpli) {
            $class='success';
        }elseif ($pCol<pcumpli) {
            $class='danger';
            $acumPCalcular=0;
        }
        $pColCR=$pCol;
        echo "<tr><td><a href='detallecomiext.php?valor=".$valor."&c=1'>Creditos</a></td><td>".number_format($acumcolocado,2)."</td><td>".number_format(metaCR,2)."</td><td class='".$class."'>%".number_format($pCol,2)."</td><td>".number_format($acumapertura,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";
        $queryResult=$pdo->query("SELECT
        B.PApertura,
        B.NApertura,
        B.plazo,
        A.FInicio,
        D.Renta
    FROM
        sibware.2_ap_disposicion A
    INNER JOIN sibware.2_ap_contrato B ON A.IDContrato = B.ID
    INNER JOIN sibware.2_cliente C ON B.IDCliente = C.ID
    INNER JOIN sibware.2_ap_disposicion_movs D ON A.ID = D.IDDisposicion
    INNER JOIN sibware.2_entorno_tipocliente E ON C.IDTipoCliente = E.ID
    WHERE
        (
            A.FInicio BETWEEN '$fini'
            AND '$ffin'
        )
    AND B. STATUS <> 'C'
    AND B. STATUS <> '-'
    AND (E.ID = 1 OR E.ID = 3)
    AND D.renglon = 1");
  
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $renta=$row['Renta'];
            $plazo=$row['plazo'];
            $colocado=$renta*$plazo;
            $papertura=$row['PApertura'];
            $napertura=$row['NApertura'];
            $acumcolocadoAP2=$acumcolocadoAP2+$colocado;
            $acumaperturaAP2=$acumaperturaAP2+$napertura;
            $pCalcular=$papertura*100/pComi;
            $montoCal=($pCalcular/100)*$colocado;
            $acumPCalcularAP2=$acumPCalcularAP2+$montoCal;
            
        }
        $queryResult=$pdo->query("SELECT
        B.PApertura,
        B.NApertura,
        B.plazo,
        A.FInicio,
        D.Renta
    FROM
        sibware.3_ap_disposicion A
    INNER JOIN sibware.3_ap_contrato B ON A.IDContrato = B.ID
    INNER JOIN sibware.3_cliente C ON B.IDCliente = C.ID
    INNER JOIN sibware.3_ap_disposicion_movs D ON A.ID = D.IDDisposicion
    INNER JOIN sibware.3_entorno_tipocliente E ON C.IDTipoCliente = E.ID
    WHERE
        (
            A.FInicio BETWEEN '$fini'
            AND '$ffin'
        )
    AND B. STATUS <> 'C'
    AND B. STATUS <> '-'
    AND (E.ID = 1 OR E.ID = 3)
    AND D.renglon = 1");
  
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $renta=$row['Renta'];
            $plazo=$row['plazo'];
            $colocado=$renta*$plazo;
            $papertura=$row['PApertura'];
            $napertura=$row['NApertura'];
            $acumcolocadoAP3=$acumcolocadoAP3+$colocado;
            $acumaperturaAP3=$acumaperturaAP3+$napertura;
            $pCalcular=$papertura*100/pComi;
            $montoCal=($pCalcular/100)*$colocado;
            $acumPCalcularAP3=$acumPCalcularAP3+$montoCal;
            
        }
        $acumcolocadoAP=0;
        $acumPCalcularAP=0;
        $acumcolocadoAP=$acumcolocadoAP2+$acumcolocadoAP3;
        $acumaperturaAP=$acumaperturaAP2+$acumaperturaAP3;
        $acumPCalcularAP=$acumPCalcularAP2+$acumPCalcularAP3;
        $pCol=($acumcolocadoAP/metaAP)*100;
        
        if ($pCol>=pcumpli) {
            $class='success';
        }elseif ($pCol<pcumpli) {
            $class='danger';
            $acumPCalcularAP=0;
        }
        $pColAP=$pCol;
        echo "<tr><td><a href='detallecomiext.php?valor=".$valor."&c=2'>Arrendamientos</a></td><td>".number_format($acumcolocadoAP,2)."</td><td>".number_format(metaAP,2)."</td><td class='".$class."'>%".number_format($pCol,2)."</td><td>".number_format($acumaperturaAP,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";
        $queryResult=$pdo->query("SELECT
        B.PApertura,
        B.NApertura,
        A.FInicio,
        A.SaldoFinal AS Dispuesto
    FROM
        sibware.3_vp_disposicion A
    INNER JOIN sibware.3_vp_contrato B ON A.IDContrato = B.ID
    INNER JOIN sibware.3_cliente C ON B.IDCliente = C.ID
    INNER JOIN sibware.3_entorno_tipocliente E ON C.IDTipoCliente = E.ID
    WHERE
        (
            A.FInicio BETWEEN '$fini'
            AND '$ffin'
        )
    AND B. STATUS <> 'C'
    AND B. STATUS <> '-'
    AND (E.ID = 1 OR E.ID = 3)");

        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $acumcolocadoVP=0;
            $acumPCalcularVP=0;
            $colocado=$row['Dispuesto'];
            $papertura=$row['PApertura'];
            $napertura=$row['NApertura'];
            $acumcolocadoVP=$acumcolocadoVP+$colocado;
            $acumaperturaVP=$acumapertura+$napertura;
            $pCalcular=$papertura*100/pComi;
            $montoCal=($pCalcular/100)*$colocado;
            $acumPCalcularVP=$acumPCalcularVP+$montoCal;
            
        }
        $pCol=($acumcolocadoVP/metaVP)*100;
        if ($pCol>=pcumpli) {
            $class='success';
        }elseif ($pCol<pcumpli) {
            $class='danger';
            $acumPCalcularVP=0;
        }
        $pColVP=$pCol;
        echo "<tr><td><a href='detallecomiext.php?valor=".$valor."&c=3'>Venta a Plazo</a></td><td>".number_format($acumcolocadoVP,2)."</td><td>".number_format(metaVP,2)."</td><td class='".$class."'>%".number_format($pCol,2)."</td><td>".number_format($acumaperturaVP,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";
    }
    ?>


</table>
<?php
    if(!empty($_POST['col'])){
        if (empty($acumcolocado)) {
            $acumcolocado=0;
        }
        if (empty($acumPCalcular)) {
            $acumPCalcular=0;
        }
        if (empty($acumcolocadoAP)) {
            $acumcolocadoAP=0;
        }
        if (empty($acumPCalcularAP)) {
            $acumPCalcularAP=0;
        }
        if (empty($acumcolocadoVP)) {
            $acumcolocadoVP=0;
        }
        if (empty($acumPCalcularVP)) {
            $acumPCalcularVP=0;
        }
?>
<form action="extencomisiones.php" method="post">
    <input type="text" name="accr" id="accr" value="<?php echo $acumcolocado  ?>" readonly="true" hidden="true">
    <input type="text" name="acaccr" id="acaccr" value="<?php echo $acumPCalcular ?>" readonly="true" hidden="true" >
    <input type="text" name="acap" id="acap" value="<?php echo $acumcolocadoAP  ?>" readonly="true" hidden="true">
    <input type="text" name="acacap" id="acacap" value="<?php echo $acumPCalcularAP  ?>" readonly="true" hidden="true" >
    <input type="text" name="acvp" id="acvp" value="<?php echo $acumcolocadoVP ?>" readonly="true" hidden="true">
    <input type="text" name="acacvp" id="acacvp" value="<?php echo $acumPCalcularVP  ?>" readonly="true" hidden="true" >
    <input type="text" name="periodo" id="periodo" value="<?php echo $periodo ?>" readonly="true" hidden="true">
    <input type="text" name="yy" id="yy" value="<?php echo $yy ?>" readonly="true" hidden="true">
    <input type="text" name="pColCR" id="pColCR" value="<?php echo $pColCR ?>" readonly="true" hidden="true">
    <input type="text" name="pColAP" id="pColAP" value="<?php echo $pColAP ?>" readonly="true" hidden="true">
    <input type="text" name="pColVP" id="pColVP" value="<?php echo $pColVP ?>" readonly="true" hidden="true">
    <input type="submit" value="calcular" class="button" name="calcular" id="calcular">
</form>
<h3>Relacion de Comisiones Pagar</h3>
<table class="table">
<tr><th>Nombre</th><th>%P</th><th>%C</th><th>Creditos</th><th>Arrendamientos</th><th>Venta PLazo</th><th>Total</th><th>Acciones</th></tr>
<?php
    $queryResult=$pdo->Query("SELECT A.ID,CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as ejecutivo, C.alias as personal , A.porcp,A.porcc,A.comcr,A.comap,A.comvp,A.status FROM Intranet.com_extensionistas A INNER JOIN sibware.personal B ON A.IDpersonal=B.ID INNER JOIN Intranet.param_com_extensionistas C ON A.IDPersonal=C.IDPersonal WHERE periodo=$periodo AND yy=$yy");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $comap=$row['comap'];
        $comcr=$row['comcr'];
        $comvp=$row['comvp'];
        $total=$comap+$comvp+$comcr;
        $totalcr=$totalcr+$comcr;
        $totalap=$totalap+$comap;
        $totalvp=$totalvp+$comvp;
        $idcom=$row['ID'];
        echo "<tr><td>".$row['personal']."</td><td>".$row['porcp']."</td><td>".$row['porcc']."</td><td>".number_format($comcr,2)."</td><td>".number_format($comap,2)."</td><td>".number_format($comvp,2)."</td><td>".number_format($total,2)."</td>";
        if ($row['status']==1) {
            echo "<td><a href='extencomisiones.php?idcom=".$idcom."'><img src='img/icons/delete.png'></a><a href='aprovecomext.php?idcom=".$idcom."'><img src='img/icons/aprove.png'></a></td>";
        }elseif ($row['status']>1) {
            echo "<td><img src='img/icons/icon_ok.png'></td>";
        }
        
        echo "</tr>";
    }
    $rescr=$acumapertura-$totalcr;
    $resap=$acumaperturaAP-$totalap;
    $resvp=$acumaperturaVP-$totalvp;
    if ($rescr<0) {
        $classcr='danger';
    }else{
        $classcr='success';
    }
    if ($resap<0) {
        $classap='danger';
    }else{
        $classap='success';
    }
    if ($resvp<0) {
        $classvp='danger';
    }else{
        $classvp='success';
    }
?>
<tr><td colspan="2">Remanente por Utilizar</td><td></td><td class="<?php echo $classcr ?>"><?PHP echo  number_format($rescr,2) ?></td><td class=" <?php echo $classap ?>"><?PHP echo number_format($resap,2) ?></td><td class=" <?php echo $classvp ?>"><?PHP echo  number_format($resvp,2) ?></td><td></td></tr>
</table>
<h3>Relacion de Contratos Asignados</h3>
<table class="table">
<tr><th>Cliente</th><th>Folio</th><th>Producto</th><th>Monto</th><th>%Comision</th><th>$Comision Pagada</th><th>Asignado a : </th></tr>
<?php
    $queryResult=$pdo->query("SELECT CONCAT('CR-', LPAD(B.Folio, 6, 0)) AS Folio, CONCAT(C.Nombre,' ',C.Apellido1,
		' ',
		C.Apellido2
	) AS Cliente,
CONCAT(
		D.Nombre,
		' ',
		D.Apellido1,
		' ',
		D.Apellido2
	) AS Ejecutivo ,
    B.Autorizado,
    B.PApertura,
    B.NAPertura
    FROM Intranet.asignacion_ctos_ext A INNER JOIN sibware.2_contratos B ON A.IDContrato=B.ID INNER JOIN sibware.2_cliente C ON A.IDCliente=C.ID INNER JOIN sibware.personal D ON A.IDPersonal=D.ID WHERE periodo=$periodo AND yy=$yy AND Producto='cr'");
    //var_dump($queryResult);
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>".$row['Cliente']."</td><td>".$row['Folio']."</td><td>Creditos</td><td>".number_format($row['Autorizado'],2)."</td><td>%".number_format($row['PApertura'],2)."</td><td>$".number_format($row['NAPertura'],2)."</td><td>".$row['Ejecutivo']."</td></tr>";
    }
    $queryResult=$pdo->query("SELECT CONCAT('AP-', LPAD(B.Folio, 6, 0)) AS Folio, CONCAT(C.Nombre,' ',C.Apellido1,
		' ',
		C.Apellido2
	) AS Cliente,
CONCAT(
		D.Nombre,
		' ',
		D.Apellido1,
		' ',
		D.Apellido2
	) AS Ejecutivo ,
    B.Saldo as Autorizado,
    B.PApertura,
    B.NAPertura
    FROM Intranet.asignacion_ctos_ext A INNER JOIN sibware.2_ap_contrato B ON A.IDContrato=B.ID INNER JOIN sibware.2_cliente C ON A.IDCliente=C.ID INNER JOIN sibware.personal D ON A.IDPersonal=D.ID WHERE periodo=$periodo AND yy=$yy AND Producto='ap' AND Empresa='cmu'");
    //var_dump($queryResult);
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>".$row['Cliente']."</td><td>".$row['Folio']."</td><td>Arrendamientos</td><td>".number_format($row['Autorizado'],2)."</td><td>%".number_format($row['PApertura'],2)."</td><td>$".number_format($row['NAPertura'],2)."</td><td>".$row['Ejecutivo']."</td></tr>";
    }
    $queryResult=$pdo->query("SELECT CONCAT('AP-', LPAD(B.Folio, 6, 0)) AS Folio, CONCAT(C.Nombre,' ',C.Apellido1,
		' ',
		C.Apellido2
	) AS Cliente,
CONCAT(
		D.Nombre,
		' ',
		D.Apellido1,
		' ',
		D.Apellido2
	) AS Ejecutivo ,
    B.Saldo as Autorizado,
    B.PApertura,
    B.NAPertura
    FROM Intranet.asignacion_ctos_ext A INNER JOIN sibware.3_ap_contrato B ON A.IDContrato=B.ID INNER JOIN sibware.3_cliente C ON A.IDCliente=C.ID INNER JOIN sibware.personal D ON A.IDPersonal=D.ID WHERE periodo=$periodo AND yy=$yy AND Producto='ap' AND Empresa='cma'");
    //var_dump($queryResult);
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>".$row['Cliente']."</td><td>".$row['Folio']."</td><td>Arrendamientos</td><td>".number_format($row['Autorizado'],2)."</td><td>%".number_format($row['PApertura'],2)."</td><td>$".number_format($row['NAPertura'],2)."</td><td>".$row['Ejecutivo']."</td></tr>";
    }
    $queryResult=$pdo->query("SELECT CONCAT('VP-', LPAD(B.Folio, 6, 0)) AS Folio, CONCAT(C.Nombre,' ',C.Apellido1,
		' ',
		C.Apellido2
	) AS Cliente,
CONCAT(
		D.Nombre,
		' ',
		D.Apellido1,
		' ',
		D.Apellido2
	) AS Ejecutivo ,
    B.SaldoFinal as Autorizado,
    B.PApertura,
    B.NAPertura
    FROM Intranet.asignacion_ctos_ext A INNER JOIN sibware.3_vp_contrato B ON A.IDContrato=B.ID INNER JOIN sibware.3_cliente C ON A.IDCliente=C.ID INNER JOIN sibware.personal D ON A.IDPersonal=D.ID WHERE periodo=$periodo AND yy=$yy AND Producto='vp' AND Empresa='cma'");
    //var_dump($queryResult);
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>".$row['Cliente']."</td><td>".$row['Folio']."</td><td>Arrendamientos</td><td>".number_format($row['Autorizado'],2)."</td><td>%".number_format($row['PApertura'],2)."</td><td>$".number_format($row['NAPertura'],2)."</td><td>".$row['Ejecutivo']."</td></tr>";
    }
?>
</table>
<?php
    }
?>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>