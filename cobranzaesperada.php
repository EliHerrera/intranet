<?php
    require_once 'header.php';
    if (!empty($_POST)) {
        $fecha=$_POST['yy']."-".$_POST['mes']."-01";
        $fechaini = new DateTime($fecha);
        $fechaini->modify('first day of this month');
        $fini=$fechaini->format('Y-m-d'); 
        $fechafin = new DateTime($fecha);
        $fechafin->modify('last day of this month');
        $ffin=$fechafin->format('Y-m-d'); 
        $queryResult=$pdo->query("SELECT sibware.gTIIE($_POST[mes],$_POST[yy]) as tiim");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $tiiem=$row['tiim'];
            }
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
        A.renglon,
        B.TasaTotal,
        B.TipoTasa,
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
        
        FROM
        2_contratos_disposicion A
        INNER JOIN 2_contratos B ON A.IDContrato = B.ID
        INNER JOIN 2_cliente C ON B.IDCliente = C.ID
        INNER JOIN personal D ON C.IDEjecutivo = D.ID
        INNER JOIN 2_contratos_disposicion_movs E ON E.IDDisposicion = A.ID
        WHERE
        B.`status` <> 'C'
        AND B.`status` <> '-'
        AND E.Fpago BETWEEN '$fini'
        AND '$ffin'");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $idCto=$row['ID'];
            $iddisp=$row['IDd'];
            $idCte=$row['IDCliente'];
            $tasa=$row['Tasa'];
            $pAdicional=$row['PAdicional'];
            $tTasa=$row['TipoTasa'];
            
            
            # code...
        }
      

        echo "<div class='alert alert-success'>";
        echo "    <strong>Exito!</strong> Procesado con Exito!";
        echo "</div>";
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

<?php
    /////fin de contenido
    require_once 'footer.php';
?>
