<?php
    require_once 'header.php';
    //////inicio de contenido
    $id_ejecutivo=null;
    $mes_actual=date('n' , mktime(0, 0, 0, date("m"), date("d"),   date("Y")));
    $periodo=date("n", mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))); //periodo a calcular$reserva=0.00;
    $yy=date('Y');
    
    $hoy=date('Y-m-d h:m');
    if($periodo==12 && $mes_actual==1){
        $yy=date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y')-1));
    }
    $yy="2019"; //editar esta linea para forzar a un año//
    $periodo=1;//editar esta linea paraforzar leer un periodo//
    $queryResult=$pdo->query("SELECT * FROM Intranet.comisiones_parametros WHERE yy=$yy and mes=$periodo");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $bono1=$row['bono1'];
        $bono2=$row['bono2'];
        $bono3=$row['bono4'];
        $pbasecre=$row['p1'];
        $pbasevp=$row['p2'];
        $pbaseap=$row['p3'];
        $pbasecte1=$row['bctep1'];
        $pbasecte2=$row['bctep2'];
        $pbasecte3=$row['bctep3'];
        $pbasecte4=$row['bctep4'];
        $pi28d=$row['pi28d'];
        $pi91d=$row['pi91d'];
        $pi180d=$row['pi180d'];
        $pi360d=$row['pi360d'];
        $metacr=$row['meta1'];
        $metaap=$row['meta2'];
        $metavp=$row['meta3'];
        $imor=$row['imor'];
    }
    if (!empty($_POST['usc'])) {
        $id_ejecutivo=$_POST['usc'];# code...
    }elseif (!empty($_GET['idcomi'])) {
        $queryResult = $pdo->query("SELECT * from Intranet.comisiones WHERE id_comision=$_GET[idcomi]");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $id_ejecutivo=$row['id_ejecutivo'];
            $yy=$row['yy'];
            $periodo=$row['mes'];
        }
        
        
    }
    if (!empty($_POST['compras'])) {
        $queryResult=$pdo->query("SELECT A.id_comision,A.id_ejecutivo, A.total_apagar, CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2)as emp FROM Intranet.comisiones A INNER JOIN sibware.personal B ON A.id_ejecutivo=B.ID  WHERE A.id_comision=$_POST[idcomi]");
        while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $emp=$row['emp'];
            $total=$row['total_apagar'];
            $idcom=$row['id_comision'];
            $id_ejec=$row['id_ejecutivo'];
            $total=$total*(.94333);
        }
        $queryResult = $pdo->prepare("INSERT INTO sibware.7_ad_autorizacionpagos (IDConcepto,IDPersonal,FechaPago,ImporteSolicitado,lAutorizado,IDMoneda,origen,Referencia,Beneficiario,Nombre,Modulo,Concepto,Status) VALUES (1,$id_ejec,'$hoy',$total,'N',1,'PV','PAGO PROVEEDORES','$emp','$emp','PD','COMISION POR INTERMEDIACION FINANCIERA','N') ");
        $queryResult->execute();
        $lastid = $pdo->lastInsertId();
        $queryResult1=$pdo->prepare("INSERT INTO sibware.7_ad_docs_solicitudpagos (IDAutorizacion,Descripcion,Comentario,Requerido,lDocumento) VALUES ($lastid,'COMISION POR INTERMEDIACION FINANCIERA','COMISION POR INTERMEDIACION FINANCIERA','S','N')");
        $queryResult1->execute();
        $queryResult1=$pdo->prepare("INSERT INTO sibware.7_ad_docs_solicitudpagos (IDAutorizacion,Descripcion,Comentario,Requerido,lDocumento) VALUES ($lastid,'RELACION DE PAGO DE COMISION','RELACION DE PAGO DE COMISION','S','N')");
        $queryResult1->execute();
        $queryResult = $pdo->prepare("UPDATE Intranet.comisiones SET status=3 WHERE id_comision=$_POST[idcomi] ");
        $queryResult->execute();
        echo "<div class='alert alert-success'>";
        echo "    <strong>Exito!</strong> Solicitud Fue enviada a compras con Exito!";
        echo "</div>";
        header('Location: relcomisiones.php');
    }
    if (!empty($id_ejecutivo)) {
                
                // $queryResult = $pdo->query("select * from sibware.personal_comisionesne A where A.IDPersonal='$id_ejecutivo'");
                // while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                //     $meta_lc=$row['MetaLC'];
                //     $plc=$row['PMetaLC'];
                //     $meta_ap=$row['MetaAP'];
                //     $pap=$row['PMetaAP'];
                //     $meta_vp=$row['MetaVP'];
                //     $pvp=$row['PMetaVP'];
                //     $meta_in=$row['MetaIN'];
                //     $pin=$row['PMetaIN'];
                //     $bono1=$row['Bono1'];		
                //     $bono2=$row['Bono2'];
                //     $factorPCv=$row['icv'];
                // }
                    $ajustei=.15;
                    $ajustelc=.45;
                    $ajusteap=.37;                    
                    $ajustevp=.55;
                    $reserva=0.00;
                    $argumeto='first day of january '.$yy;
                    $_date = new DateTime();
                    $_date->modify($argumeto);
                    $primerdia=$_date->format('Y-m-d');
                    $mes_anterior  = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
                    $mes_actual=mktime(0, 0, 0, date("m"), date("d"),   date("Y"));
                    $númeroDeDias = date("t",$mes_anterior);
                    $mes_anteriormes=date("m",$mes_anterior);
                    $mes_anterior= date("Y-m", $mes_anterior);
                    $annio_ant=date("Y", $mes_anterior);
                    $mes_actual=date("Y-m",$mes_actual);
                    $fecha_inist=$mes_anterior."-01";
                    $fecha_finst=$mes_anterior."-".$númeroDeDias;
                    #####calculo de saldos y dias
                    $queryResult = $pdo->query("SELECT
                        A.SaldoIni,
                        A.SaldoFin,
                        SUM(A.SaldoFin - A.SaldoIni) AS Diferencia
                        
                    FROM
                        sibware.comisiones A
                    
                    WHERE
                        A.Periodo = $periodo
                    AND A.IDEjecutivo = $id_ejecutivo
                    AND A.Producto = 'CR'
                    AND A.YY = '$yy'");



                        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                                            $saldoiniLC=$row['SaldoIni'];
                                            $SaldoFinLC=$row['SaldoFin'];
                                            $diferenciaLC=$row['Diferencia'];
                                            

                                        }
                        
                    if ($diferenciaLC>=$metacr) {
                            $bonocr=$bono1;
                        }   
                        $queryResult = $pdo->query("SELECT
                        A.SaldoIni,
                        A.SaldoFin,
                        SUM(A.SaldoFin - A.SaldoIni) AS Diferencia
                        
                    FROM
                        sibware.comisiones A
                    
                    WHERE
                        A.Periodo = $periodo
                    AND A.IDEjecutivo = $id_ejecutivo
                    AND A.Producto = 'VP'
                    AND A.YY = '$yy'");


                        
                        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                                            $saldoiniVP=$row['SaldoIni'];
                                            $SaldoFinVP=$row['SaldoFin'];
                                            $diferenciaVP=$row['Diferencia'];
                                            

                                        }
                        
                    if ($diferenciaVP>=$metavp) {
                            $bonovp=$bono1;
                        }
                        $queryResult = $pdo->query("SELECT
                        SUM(A.SaldoIni) as SaldoIni,
                        SUM(A.SaldoFin) as SaldoFin
                        
                        
                    FROM
                        sibware.comisiones A
                    
                    WHERE
                        A.Periodo = $periodo
                    AND A.IDEjecutivo = $id_ejecutivo
                    AND (A.Producto = 'AP' OR A.Producto ='APU')
                    AND A.YY='$yy'");


                        
                        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                                            $saldoiniAP=$row['SaldoIni'];
                                            $SaldoFinAP=$row['SaldoFin'];
                                            $diferenciaAP=$row['SaldoFin']-$row['SaldoIni'];
                                            

                                        }
                        
                    if ($diferenciaAP>=$metaAP) {
                            $bonoap=$bono1;
                        }
                        $queryResult = $pdo->query("SELECT
                        SUM(A.SaldoIni) as SaldoIni,
                        SUM(A.SaldoFin) as SaldoFin,
                        B.PMetaIN,
                        B.MetaIN
                        
                    FROM
                        sibware.comisiones A
                    INNER JOIN sibware.personal_comisionesne B ON A.IDEjecutivo = B.IDPersonal
                    WHERE
                        A.Periodo = $periodo
                    AND A.IDEjecutivo = $id_ejecutivo
                    AND A.Producto = 'IN'
                    AND A.YY='$yy'");


                        
                        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                                            $saldoiniIN=$row['SaldoIni'];
                                            $SaldoFinIN=$row['SaldoFin'];
                                            $diferenciaIN=$row['SaldoFin']-$row['SaldoIni'];
                                            $metaIN=$row['MetaIN'];

                                        }
                        
                    if ($diferenciaIN>=$metaIN) {
                            $ptoIN=3;
                            $pin=$pin;
                        }    
                    
     	
    }

            #### fin de calculos y dias
        
    
    
    if (!empty($_POST['aprobar'])) {
        $_POST['bon']= str_replace(',','',$_POST['bon']);
        $_POST['ap']= str_replace(',','',$_POST['ap']); 
        $_POST['vp']= str_replace(',','',$_POST['vp']); 
        $_POST['cr']= str_replace(',','',$_POST['cr']);   
        $_POST['inv']= str_replace(',','',$_POST['inv']);         
        $_POST['total']= str_replace(',','',$_POST['total']);
        $queryResult = $pdo->prepare("INSERT INTO Intranet.comisiones (
            total_comi_inv,
            total_comi_apvp,
            total_comi_vp,
            total_comi_cred,
            total_bono,
            mes,
            id_ejecutivo,
            total_apagar,
            status,
            fecha,
            yy
        )
        VALUES
            ($_POST[inv],$_POST[ap],$_POST[vp],$_POST[cr],$_POST[bon],$_POST[p],$_POST[usc],$_POST[total],1,'$hoy',$_POST[y])");
          
        $queryResult->execute();    
                $queryResult = $pdo->prepare("UPDATE sibware.comisiones
        SET lAprobado = 'S' WHERE IDEjecutivo=$_POST[usc] AND Periodo=$_POST[p] AND YY=$_POST[y]");
        $queryResult->execute();
        echo "<div class='alert alert-success'>";
        echo "    <strong>Exito!</strong> Comision Aprobada con Exito!";
        echo "</div>";
        
    }
    
?> 
<h3>Comisiones</h3>
<form action="comisiones.php" method="POST">
<div class="row">
    <div class="col-xs-5">
    <label for='usc'>Ejecutivo</label>
    <select name="usc" id="usc" class="form-control" onchange="this.form.submit();return false;">
        <option value="">Seleciones ejecutivo...</option>
        <?PHP
            if (!empty($_GET['idcomi'])) {
                $queryResult = $pdo->query("SELECT 
                A.ID,
                CONCAT(A.Nombre,' ',A.Apellido1,' ',A.Apellido2) as usc,
                A.IDSucursal,
                A.IDPuesto,
                A.lPatrimonial
            FROM
                sibware.personal A INNER JOIN sibware.comisiones B on A.ID=B.IDEjecutivo 
                
            WHERE
                A.IDDepartamento = 1 AND A.status = 'S' AND A.ID=$id_ejecutivo
                GROUP BY A.ID");
                

            }else{        
                    $queryResult = $pdo->query("SELECT 
                    A.ID,
                    CONCAT(A.Nombre,' ',A.Apellido1,' ',A.Apellido2) as usc,
                    A.IDSucursal,
                    A.IDPuesto,
                    A.lPatrimonial
                FROM
                    sibware.personal A INNER JOIN sibware.comisiones B on A.ID=B.IDEjecutivo 
                    
                WHERE
                    A.IDDepartamento = 1 AND A.status = 'S' AND B.Periodo=$periodo AND B.YY=$yy AND B.lAprobado<>'S'
                    GROUP BY A.ID");}
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                if ($id_ejecutivo==$row['ID']) {
                    echo"<option selected='selected' value='".$row['ID']."'>".$row['usc']."</option>";
                }else{
                    echo"<option value='".$row['ID']."'>".$row['usc']."</option>";
                }
            }
        ?>
    </select>
    </div>
    <div class="col-xs-2">
            <input type="text" name="p" id="p" readonly="true" value="<?PHP echo $periodo ?>" required="true" hidden="true">
            <input type="text" name="y" id="y" readonly="true" value="<?PHP echo $yy ?>" required="true" hidden="true">
        <?PHP if (!empty($_GET['idcomi'])) {

        }else{ ?>  
        <br><input type="submit" value="Aprobar" name="aprobar" id="aprobar" class="button">
       
        <?PHP }?>   
    </div>
    <div class="col-xs-2>">    
        <br><a href="relcomisiones.php" class="button">Regresar</a>
        <a href="solicitudch.php?idcomi=<?PHP echo $_GET['idcomi'] ?>" target="_blank" class="button">Solicitud</a>
        <input type="button" name="imprimir" value="Relacion"  onClick="window.print();" class="button" />
        <input type="text" name="idcomi" id="idcomi" readonly="true" value="<?PHP echo $_GET['idcomi'] ?>" required="true" hidden="true">
        <input type='submit' value='Enviar a Compras' class='button' name='compras' id='compras'>
    </div>
</div>

<h4>Relacion de bonos por Saldos de Cartera</h4>
<table class="table">
    <tr><th>Saldo Inicial</th><th>Saldos Final</th><th>Diferencia</th><th>Prod.</th><th>Meta</th><th>Bono Cartera</th><th>Bono IMOR</th><th>Bono Seguros</th></tr>
    <tr><td><?php echo number_format($saldoiniLC,2) ;?></td><td><?php echo  number_format($SaldoFinLC,2) ;?></td><td><?php echo number_format($diferenciaLC,2); ?></td><td>CR</td><td><?php echo number_format($metacr,2) ?></td><td><?php  echo number_format($bonocr,2)?></td><td>0</td><td>0</td></tr>	
	<tr><td><?php echo number_format($saldoiniAP,2) ?></td><td><?php echo  number_format($SaldoFinAP,2) ?></td><td><?php echo number_format($diferenciaAP,2) ?></td><td>AP</td><td><?php echo number_format($metaap,2) ?></td><td><?php  echo number_format($bonoap,2)?></td><td>0</td><td>0</td></tr>
	<tr><td><?php echo number_format($saldoiniVP,2) ?></td><td><?php echo  number_format($SaldoFinVP,2) ?></td><td><?php echo number_format($diferenciaVP,2) ?></td><td>VP</td><td><?php echo number_format($metavp,2) ?></td><td><?php  echo number_format($bonovp,2)?></td><td>0</td><td>0</td></tr>
	
	<?php $totaldecomisiones=$bonocr+$bonoap+$bonovp; ?>
	

</table> 
<h4>Relacion de Colocacion por Producto</h4>
<table class="table">
<tr><th>Cliente</th><th>Monto</th><th>Producto</th><th>% Cte</th><th>Comision</th></tr>
            <?php
                if (!empty($id_ejecutivo)) {
                    $queryResult=$pdo->query("SELECT
                    CONCAT(
                        B.Nombre,
                        ' ',
                        B.Apellido1,
                        ' ',
                        B.Apellido2
                    ) AS Cliente,
                    A.Autorizado,
                    A.FInicio,
                    B.ID as IDCte,
                    C.tipo
                        FROM
                            sibware.2_contratos A
                        INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
                        INNER JOIN sibware.2_entorno_tipocredito C ON A.IDTipoCredito=C.ID
                        WHERE
                            A.IDTipoCredito<>5
                        AND B.IDEjecutivo = $id_ejecutivo
                        AND FInicio BETWEEN '$fecha_inist'
                        AND '$fecha_finst'");  
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                        $idcte=$row['IDCte'];
                        $cte=$row['Cliente'];
                        $autorizado=$row['Autorizado']; 
                        $finicio=$row['FInicio'];
                        $tipopro=$row['tipo'];
                        $seismesesago = strtotime ( '-6 month' , strtotime ( $finicio ) ) ;
                        $seismesesago = date ( 'Y-m-d' , $seismesesago );
                        $queryResult2=$pdo->query("SELECT * FROM sibware.2_cliente A WHERE A.ID=$idcte AND A.FCliente BETWEEN '$fecha_inist' AND '$fecha_finst'");
                        $row_count = $queryResult2->rowCount();
                        $queryResult2=$pdo->query("SELECT * FROM sibware.2_contratos WHERE IDCliente=$idcte AND FInicio>='$seismesesago'");
                        $row_count2 = $queryResult2->rowCount();
                        $queryResult2=$pdo->query("SELECT * FROM sibware.2_ap_contrato WHERE IDCliente=$idcte AND status='A'");
                        $row_count3 = $queryResult2->rowCount();
                        
                        if ($row_count>=1) {
                            $pcte=$pbasecte1*100;
                            
                        }elseif ($row_count2==0) {
                            $pcte=$pbasecte2*100;
                        }elseif ($row_count3>=1) {
                            $pcte=$pbasecte3*100;
                        }else{
                            $pcte=$pbasecte4*100;
                        } 
                        $comisioncr=((($pcte*$pbasecre)/100)/100)*$autorizado;
                        $tcomisioncr=$tcomisioncr+$comisioncr;
                        echo "<tr><td>".$cte."</td><td>$".number_format($autorizado,2)."</td><td>".$tipopro."</td><td>".$pcte."</td><td>$".number_format($comisioncr,2)."</td></tr>";   
                    }

                }
            ?>


</table>                          
</form> 

<?php
    /////fin de contenido
    require_once 'footer.php';
?>
