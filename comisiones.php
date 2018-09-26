<?php
    require_once 'header.php';
    //////inicio de contenido
    $id_ejecutivo=null;
    $periodo=date("n", mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))); //periodo a calcular
    
    //$periodo=10;
    $reserva=0.00;
    $yy=date('Y');
    // $yy="2017";
    $hoy=date('Y-m-d h:m');
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
    if (!empty($id_ejecutivo)) {
                
                $queryResult = $pdo->query("select * from sibware.personal_comisionesne A where A.IDPersonal='$id_ejecutivo'");
                while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                    $meta_lc=$row['MetaLC'];
                    $plc=$row['PMetaLC'];
                    $meta_ap=$row['MetaAP'];
                    $pap=$row['PMetaAP'];
                    $meta_vp=$row['MetaVP'];
                    $pvp=$row['PMetaVP'];
                    $meta_in=$row['MetaIN'];
                    $pin=$row['PMetaIN'];
                    $bono1=$row['Bono1'];		
                    $bono2=$row['Bono2'];
                    $factorPCv=$row['icv'];
                }
                    $ajustei=.15;
                    $ajustelc=.40;
                    $ajusteap=.50;
                    $ajustevp=.40;
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
                        SUM(A.SaldoFin - A.SaldoIni) AS Diferencia,
                        B.MetaLC
                    FROM
                        sibware.comisiones A
                    INNER JOIN sibware.personal_comisionesne B ON A.IDEjecutivo = B.IDPersonal
                    WHERE
                        A.Periodo = $periodo
                    AND A.IDEjecutivo = $id_ejecutivo
                    AND A.Producto = 'CR'
                    AND A.YY = '$yy'");



                        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                                            $saldoiniLC=$row['SaldoIni'];
                                            $SaldoFinLC=$row['SaldoFin'];
                                            $diferenciaLC=$row['Diferencia'];
                                            $metaLC=$row['MetaLC'];

                                        }
                        
                    if ($diferenciaLC>=$metaLC) {
                            $ptoLC=3;
                        }elseif (($diferenciaLC<$metaLC) AND($diferenciaLC>0)) {
                            $ptoLC=2;
                        }elseif ($diferenciaLC<=0) {
                            $ptoLC=0;
                        }     
                        $queryResult = $pdo->query("SELECT
                        A.SaldoIni,
                        A.SaldoFin,
                        SUM(A.SaldoFin - A.SaldoIni) AS Diferencia,
                        B.MetaVP
                    FROM
                        sibware.comisiones A
                    INNER JOIN sibware.personal_comisionesne B ON A.IDEjecutivo = B.IDPersonal
                    WHERE
                        A.Periodo = $periodo
                    AND A.IDEjecutivo = $id_ejecutivo
                    AND A.Producto = 'VP'
                    AND A.YY = '$yy'");


                        
                        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                                            $saldoiniVP=$row['SaldoIni'];
                                            $SaldoFinVP=$row['SaldoFin'];
                                            $diferenciaVP=$row['Diferencia'];
                                            $metaVP=$row['MetaVP'];

                                        }
                        
                    if ($diferenciaVP>=$metaVP) {
                            $ptoVP=3;
                        }elseif (($diferenciaVP<$metaVP) AND($diferenciaVP>0)) {
                            $ptoVP=2;
                        }elseif ($diferenciaVP<=0) {
                            $ptoVP=0;
                        }      
                        $queryResult = $pdo->query("SELECT
                        SUM(A.SaldoIni) as SaldoIni,
                        SUM(A.SaldoFin) as SaldoFin,
                        B.MetaAP
                        
                    FROM
                        sibware.comisiones A
                    INNER JOIN sibware.personal_comisionesne B ON A.IDEjecutivo = B.IDPersonal
                    WHERE
                        A.Periodo = $periodo
                    AND A.IDEjecutivo = $id_ejecutivo
                    AND (A.Producto = 'AP' OR A.Producto ='APU')
                    AND A.YY='$yy'");


                        
                        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                                            $saldoiniAP=$row['SaldoIni'];
                                            $SaldoFinAP=$row['SaldoFin'];
                                            $diferenciaAP=$row['SaldoFin']-$row['SaldoIni'];
                                            $metaAP=$row['MetaAP'];

                                        }
                        
                    if ($diferenciaAP>=$metaAP) {
                            $ptoAP=3;
                        }elseif (($diferenciaAP<$metaAP) AND($diferenciaAP>0)) {
                            $ptoAP=2;
                        }elseif ($diferenciaAP<=0) {
                            $ptoAP=0;
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
                        }elseif (($diferenciaIN<$metaIN) AND($diferenciaIN>0)) {
                            $ptoIN=2;
                        }elseif ($diferenciaIN<=0) {
                            $ptoIN=0;
                        } 
                              
                    if (($ptoLC==3 AND $ptoAP==3 AND $ptoVP==3)OR($ptoLC==2 AND $ptoAP==3 AND $ptoVP==3)) {
                            $porc=0.80;
                        } 
                    elseif (($ptoLC==2 AND $ptoAP==3 AND $ptoVP==2)OR($ptoLC==3 AND $ptoAP==2 AND $ptoVP==3)OR($ptoLC==3 AND $ptoAP==2 AND $ptoVP==2)) {
                            $porc=0.70;
                        }          
                    elseif (($ptoLC==2 AND $ptoAP==2 AND $ptoVP==2)OR($ptoLC==0 AND $ptoAP==3 AND $ptoVP==3)OR($ptoLC==0 AND $ptoAP==3 AND $ptoVP==2)) {
                            $porc=0.60;
                        }
                    elseif (($ptoLC==0 AND $ptoAP==2 AND $ptoVP==3)OR($ptoLC==3 AND $ptoAP==2 AND $ptoVP==0)OR($ptoLC==3 AND $ptoAP==0 AND $ptoVP==2) OR ($ptoLC==2 AND $ptoAP==3 AND $ptoVP==0) OR ($ptoLC==2 AND $ptoAP==2 AND $ptoVP==0)) {
                            $porc=0.50;
                        }   
                    elseif (($ptoLC==0 AND $ptoAP==0 AND $ptoVP==3)OR($ptoLC==0 AND $ptoAP==2 AND $ptoVP==2)) {
                            $porc=0.40;
                        }  
                    elseif (($ptoLC==0 AND $ptoAP==3 AND $ptoVP==0)OR($ptoLC==0 AND $ptoAP==2 AND $ptoVP==0)) {
                            $porc=0.30;
                        }   
                    elseif ($ptoLC==0 AND $ptoAP==0 AND $ptoVP==2) {
                            $porc=0.20;
                        }  
                    elseif ($ptoLC==2 AND $ptoAP==0 AND $ptoVP==0) {
                            $porc=0.10;
                        }  
                    elseif ($ptoLC==0 AND $ptoAP==0 AND $ptoVP==0) {
                            $porc=0;
                        } 
                    elseif ($ptoLC==3 AND $ptoAP==0 AND $ptoVP==0) {
                            $porc=.40;
                        }else{
                            echo "<div class='alert alert-warning'>";
                            echo "    <strong>Aviso! </strong> El escenario de % de comision de este ejecutivo no esta configurado o no existe!";
                            echo "</div>";
                        }	 
                    if ($ptoIN==3) {
                            $porcIN=.80;
                        }elseif ($ptoIN==2) {
                            $porcIN=.40;
                        }     
                    if ($porc==0) {
                                                # code...
                        $porcomi=0;
                    }    
                    else{                                                   
                    $porcomi=($porc/100);
                    }
                    if ($porcIN==0) {
                                                # code...
                        $porcomIN=0;
                    }    
                    else{                                                   
                    $porcomIN=($porcIN/100);
                    $queryResult = $pdo->query("SELECT
                        A.lPatrimonial
                    FROM
                        sibware.personal A
                    WHERE
                        A.ID = $id_ejecutivo");
                        
                        
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
     				 	$patrimonial=$row['lPatrimonial'];
     				 }
     	
    }

            #### fin de calculos y dias
        
    }
    
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
    </div>
</div>


<table class="table">
    <tr><th>Saldo Inicial</th><th>Saldos Final</th><th>Diferencia</th><th>Prod.</th><th>Meta</th><th>%</th><td>Comision</th></tr>
    <tr><td><?php echo number_format($saldoiniLC,2) ;?></td><td><?php echo  number_format($SaldoFinLC,2) ;?></td><td><?php echo number_format($diferenciaLC,2); ?></td><td>CR</td><td><?php echo number_format($metaLC,2) ?></td><td><?php echo $porcomi ?></td><td><?php $comisionLC=$porcomi*$diferenciaLC; if ($comisionLC<0) {$comisionLC=0;} echo number_format($comisionLC,2) ?></td></tr>	
	<tr><td><?php echo number_format($saldoiniAP,2) ?></td><td><?php echo  number_format($SaldoFinAP,2) ?></td><td><?php echo number_format($diferenciaAP,2) ?></td><td>AP</td><td><?php echo number_format($metaAP,2) ?></td><td><?php echo $porcomi ?></td><td><?php $comisionAP=$porcomi*$diferenciaAP; if ($comisionAP<0) {$comisionAP=0;} echo number_format($comisionAP,2) ?></td></tr>
	<tr><td><?php echo number_format($saldoiniVP,2) ?></td><td><?php echo  number_format($SaldoFinVP,2) ?></td><td><?php echo number_format($diferenciaVP,2) ?></td><td>VP</td><td><?php echo number_format($metaVP,2) ?></td><td><?php echo $porcomi ?></td><td><?php $comisionVP=$porcomi*$diferenciaVP; if ($comisionVP<0) {$comisionVP=0;} echo number_format($comisionVP,2) ?></td></tr>
	<tr><td><?php echo number_format($saldoiniIN,2) ?></td><td><?php echo  number_format($SaldoFinIN,2) ?></td><td><?php echo number_format($diferenciaIN,2) ?></td><td>IN</td><td><?php echo number_format($metaIN,2) ?></td><td><?php echo $porcomIN ?></td><td><?php $comisionIN=$porcomIN*$diferenciaIN; if ($comisionIN<0) {$comisionIN=0;} echo number_format($comisionIN,2) ?></td></tr>
	<?php $totaldecomisiones=$comisionAP+$comisionIN+$comisionLC+$comisionVP; ?>
	<tr><th colspan="6">Total de Comisiones</th><th><?php echo number_format($totaldecomisiones,2); ?></th></tr>	
    <?php
        if(!empty($_POST['usc'])){
          $bonosemnopatfnd=0;
          $bonosempat=0;
          $totalbonoinv=0;
          $bonosemnopat=0; 
            if($patrimonial=='S'){
                $queryResult = $pdo->query("SELECT CONCAT(
                                B.Nombre,
                                ' ',
                                B.Apellido1,
                                ' ',
                                B.Apellido2
                            ) AS Socio,
                            SUM(A.Importe) AS Importe,
                            A.Plazo
                        FROM
                            2_prestamos A
                        INNER JOIN 2_cliente B ON A.IDCliente = B.ID
                        WHERE
                            (
                                A.Finicio BETWEEN '$fecha_inist'
                                AND '$fecha_finst'
                            )
                        AND (
                            A.TipoInstruccion = 'D'
                            OR A.TipoInstruccion = 'I'
                        )
                        AND (
                            B.FCliente BETWEEN '$fecha_inist'
                            AND '$fecha_finst'
                        )
                        
                        AND B.IDEjecutivo = $id_ejecutivo
                        And A.plazo=91
                        GROUP BY
                            A.IDCliente");
                        
                        ###cclaculo de bonos semestrales    
                        if ($periodo==2) {
                            $queryResult2 = $pdo->query("SELECT SaldoIni  FROM sibware.comisiones where Periodo=1 and YY='$yy' and IDEjecutivo=$id_ejecutivo and Producto='IN'");
                            
                           
                            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                                    $saldoiniINBonoSem=$row['SaldoIni'];
                                	
                            }
                            $queryResult2 = $pdo->query("SELECT SaldoFin  FROM sibware.comisiones where Periodo=6 and YY='$yy' and IDEjecutivo=$id_ejecutivo and Producto='IN'");
                            
                            
                            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                                    $saldoFinINBonoSem=$row['SaldoFin'];
                                	
                            }
                        }
                        if ($periodo==12) {
                            $queryResult2 = $pdo->query("SELECT SaldoIni  FROM sibware.comisiones where Periodo=7 and YY='$yy' and IDEjecutivo=$id_ejecutivo and Producto='IN'");
                            
                            
                            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                        
                                    $saldoiniINBonoSem=$row['SaldoIni'];
                                	
                            }
                            $queryResult2 = $pdo->query("SELECT SaldoFin  FROM sibware.comisiones where Periodo=12 and YY='$yy' and IDEjecutivo=$id_ejecutivo and Producto='IN'");
                            
                            
                            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                                    $saldoFinINBonoSem=$row['SaldoFin'];
                                	
                            }
                        }
                        $contbonosem=0;
                        $diferenciaINBonoSem=$saldoFinINBonoSem-$saldoiniINBonoSem;
                        $metaIN=$metaIN*18;
                        if ($metaIN<$diferenciaLCBonoSem) {
                            $contbonosem=$contbonosem+1;
                        }
                        if ($contbonosem==1) {
                            $bonosempat=$bono2;
                        }  
                        ###fin bonos semesrales          
                //fin patrimonial        
             }elseif($patrimonial=='N'){
                if ($periodo==6) {
                    $queryResult2 = $pdo->query("SELECT SaldoIni  FROM sibware.comisiones where Periodo=1 and YY='$yy' and IDEjecutivo=$id_ejecutivo and Producto='CR'");
                    
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $saldoiniLCBonoSem=$row['SaldoIni'];
                        }	
                    }
                    $queryResult2 = $pdo->query("SELECT SaldoFin  FROM sibware.comisiones where Periodo=6 and YY='$yy' and IDEjecutivo=$id_ejecutivo and Producto='CR'");
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $saldoFinLCBonoSem=$row['SaldoFin'];
                        }	
                    }
                    $queryResult2 = $pdo->query("SELECT SaldoIni  FROM sibware.comisiones where Periodo=1 and YY='$yy' and IDEjecutivo=$id_ejecutivo and Producto='VP'");
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $saldoiniVPBonoSem=$row['SaldoIni'];
                        }	
                    }
                    $queryResult2 = $pdo->query("SELECT SaldoFin  FROM sibware.comisiones where Periodo=6 and YY='$yy' and IDEjecutivo=$id_ejecutivo and Producto='VP'");
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $saldoFinVPBonoSem=$row['SaldoFin'];
                        }	
                    }
                    $queryResult2 = $pdo->query("SELECT SUM(SaldoIni) as SaldoIni  FROM sibware.comisiones where Periodo=1 and YY='$yy' and IDEjecutivo=$id_ejecutivo and Producto='AP'");
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $saldoiniAPBonoSem=$row['SaldoIni'];
                        }	
                    }
                    $queryResult2 = $pdo->query("SELECT SUM(SaldoFin) as SaldoFin  FROM sibware.comisiones where Periodo=6 and YY='$yy' and IDEjecutivo=$id_ejecutivo and Producto='AP'");
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $saldoFinAPBonoSem=$row['SaldoFin'];
                        }	
                    }		
                  
                }
                if ($periodo==12) {
                    $queryResult2 = $pdo->query("SELECT SaldoIni  FROM sibware.comisiones where Periodo=7 and YY='$yy' and IDEjecutivo=$id_ejecutivo and Producto='CR'");
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $saldoiniLCBonoSem=$row['SaldoIni'];
                        }	
                    }
                    $queryResult2 = $pdo->query("SELECT SaldoFin  FROM sibware.comisiones where Periodo=12 and YY='$yy' and IDEjecutivo=$id_ejecutivo and Producto='CR'");
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $saldoFinLCBonoSem=$row['SaldoFin'];
                        }	
                    }
                    $queryResult2 = $pdo->query("SELECT SaldoIni  FROM sibware.comisiones where Periodo=7 and YY='$yy' and IDEjecutivo=$id_ejecutivo and Producto='VP'");
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $saldoiniVPBonoSem=$row['SaldoIni'];
                        }	
                    }
                    $queryResult2 = $pdo->query("SELECT SaldoFin  FROM sibware.comisiones where Periodo=12 and YY='$yy' and IDEjecutivo=$id_ejecutivo and Producto='VP'");
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $saldoFinVPBonoSem=$row['SaldoFin'];
                        }	
                    }
                    $queryResult2 = $pdo->query("SELECT SUM(SaldoIni) as SaldoIni  FROM sibware.comisiones where Periodo=7 and YY='$yy' and IDEjecutivo=$id_ejecutivo and Producto='AP'");
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $saldoiniAPBonoSem=$row['SaldoIni'];
                        }	
                    }
                    $queryResult2 = $pdo->query("SELECT SUM(SaldoFin) as SaldoFin  FROM sibware.comisiones where Periodo=12 and YY='$yy' and IDEjecutivo=$id_ejecutivo and Producto='AP'");
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $saldoFinAPBonoSem=$row['SaldoFin'];
                        }	
                    }
            
                  
                }
                $contbonosem=0;
                $diferenciaLCBonoSem=$saldoFinLCBonoSem-$saldoiniLCBonoSem;
                $metaLC=$metaLC*6;
                if ($metaLC<$diferenciaLCBonoSem) {
                    $contbonosem=$contbonosem+1;
                }
                $diferenciaVPBonoSem=$saldoFinVPBonoSem-$saldoiniVPBonoSem;
                $metaVP=$metaVP*6;
                if ($metaVP<$diferenciaVPBonoSem) {
                    $contbonosem=$contbonosem+1;
                }
                $diferenciaAPBonoSem=$saldoFinAPBonoSem-$saldoiniAPBonoSem;
                $metaAP=$metaAP*6;
                if ($metaAP<$diferenciaAPBonoSem) {
                    $contbonosem=$contbonosem+1;
                }
                if ($contbonosem==3) {
                    $bonosemnopat=$bono1;
                }
                if ($periodo==2) {		
                    $fechacadi=$year.'-01-01';
                    $fechacadf=$year.'-06-30';
                    }
                    if ($periodo==12) {		
                    $fechacadi=$year.'-07-01';
                    $fechacadf=$year.'-12-31';
                    }
                    $sql="SELECT
                *
            FROM
                2_contratos A
            WHERE
                A.IDOrigenRecursos = 2
            AND A.IDEjecutivo = $id_ejecutivo
            AND A.FInicio BETWEEN '$fechacadi' AND '$fechacadf'";
            $queryResult3 = $pdo->query($sql);
            $numcontfnd=$queryResult3->num_rows;
            
            $sql="SELECT
                *
            FROM
                2_contratos A
            WHERE
            A.IDEjecutivo = $id_ejecutivo
            AND A.FInicio BETWEEN '$fechacadi' AND '$fechacadf'";
            $queryResult3 = $pdo->query($sql);
            $numcontnofnd=$queryResult3->num_rows;
            if ($numcontfnd==0) {
                $bonosemnopatfnd=0;
            }elseif ($numcontfnd==$numcontnofnd) {
                $bonosemnopatfnd=$bono2;
            }
             } //fin no patrimonial
        }
        
	?>    
     
<?PHP $totalbonos=$bonosemnopatfnd+$bonosempat+$totalbonoinv+$bonosemnopat; 
        $grantotal=$totaldecomisiones+$totalbonos;  ?>
</table>
<div class="row">
    <div class="col-xs-2">
    <label for="inv">Comision Inv</label><input type="text" name="inv" id="inv" value="<?PHP echo number_format($comisionIN,2) ?>" class="form-control" readonly="true">
    </div>
    <div class="col-xs-2">
    <label for="ap">Comision AP</label><input type="text" name="ap" id="ap" value="<?PHP echo number_format($comisionAP,2)  ?>" class="form-control" readonly="true">
    </div>
    <div class="col-xs-2">
    <label for="vp">Comision VP</label><input type="text" name="vp" id="vp" value="<?PHP echo number_format($comisionVP,2) ?>" class="form-control" readonly="true">
    </div>
    <div class="col-xs-2">
    <label for="cr">Comision CR</label><input type="text" name="cr" id="cr" value="<?PHP echo number_format($comisionLC,2)  ?>" class="form-control" readonly="true">
    </div>
    <div class="col-xs-2">
    <label for="bon">Comision bonos</label><input type="text" name="bon" id="bon" value="<?PHP echo number_format($totalbonos,2)  ?>" class="form-control" readonly="true">
    </div>
    <div class="col-xs-2">
    <label for="total">Comision total</label><input type="text" name="total" id="total" value="<?PHP echo number_format($grantotal,2) ?>" class="form-control" readonly="true">
    </div>
    
</div>    
</form> 

<?php
    /////fin de contenido
    require_once 'footer.php';
?>
