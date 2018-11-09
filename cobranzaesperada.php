<?php
    require_once 'header.php';
    if (!empty($_GET)) {
        $m=$_GET['m'];
        $y=$_GET['y'];
        $p=$_GET['p'];
        $e=$_GET['e'];
        if ($idnivel>=2) {
            $deletequery=$pdo->prepare("DELETE FROM Intranet.cobranzaesperada WHERE mesp=$m AND yyp=$y AND emp=$e AND producto='$p'");
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
        D.IDSucursal, 
        D.ID as IDEjecutivo,
        B.ID as IDCto         
        FROM
        sibware.2_contratos_disposicion A
        INNER JOIN sibware.2_contratos B ON A.IDContrato = B.ID
        INNER JOIN sibware.2_cliente C ON B.IDCliente = C.ID
        INNER JOIN sibware.personal D ON C.IDEjecutivo = D.ID
        INNER JOIN sibware.2_contratos_disposicion_movs E ON E.IDDisposicion = A.ID
        WHERE
        B.`status` <> 'C'
        AND B.`status` <> '-'
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
            sum(A.InteresOrdinario) As PagoInteres
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
            }  
            if (empty($pagocapital)) {
                $pagocapital=0;
            } 
            if (empty($pagointeres)) {
                $pagointeres=0;
            }        
            $tiie=$tasa+$padicional;
            $saldoprom=(($saldo*$diasp)-$pagocapital)/$diasp;
            $interes=($saldoprom*($tiie/100)/360)*$diasp;
            
            $queryInsert=$pdo->prepare("INSERT INTO Intranet.cobranzaesperada (IDContrato,IDDisposicion,IDEjecutivo,IDSucursal,Folio,Saldo,SaldoProm,Tasa,diasp,mes,yy,producto,emp,periodo,disposicion,fechapago,capitalesperado,capitalpagado,interesesperado,interespagado,mesp,yyp)
                                                                      VALUES($idcto,$iddisp,$idejecutivo,$idsucursal,'$folio',$saldo,$saldoprom,$tiie,$diasp,$mes,$yy,'CR',2,$periodo,$disposicion,'$fechapago',$capital,$pagocapital,$interes,$pagointeres,$mesp,$yyp) ");            
            $queryInsert->execute();           
        }
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
    <tr><th>Empresa</th><th>Producto</th><th>Mes</th><th>Año</th><th>Capital Esperado</th><th>Capital Recibido</th><th>Interes Esperado</th><th>Interes Pagado</th><th>Acciones</th></tr>
    <?php
        $queryResult=$pdo->query("SELECT
        mesp,
        yyp,
        emp,
        producto,
        SUM(capitalesperado) AS capitalesperado,
        SUM(capitalpagado) AS capitalpagado,
        SUM(interesesperado) AS interesesperado,
        SUM(interespagado) AS interespagado
    FROM
        Intranet.cobranzaesperada
    GROUP BY
        mesp
    AND yyp
    AND producto
    AND emp
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
            echo "<tr><td>".$empresa."</td><td><a href='viewcobesperada.php?mes=".$row['mesp']."&yy=".$row['yyp']."&pro=".$row['producto']."&emp=".$row['emp']."'>".$producto."</a></td><td>".$row['mes']."</td><td>".$row['yy']."</td><td>".number_format($row['capitalesperado'],2)."</td><td>".number_format($row['capitalpagado'],2)."</td><td>".number_format($row['interesesperado'],2)."</td><td>".number_format($row['interespagado'],2)."</td></td>><td>";
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
