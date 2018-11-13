<?php
    require_once 'header.php';
    //////inicio de contenido
    $queryResult=$pdo->query("SELECT * FROM Intranet.ponderacion WHERE ID=$_GET[idpon]");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $periodo=$row['periodo'];
        $yy=$row['yy'];
    }
?>  
<div class="row">
    <div class="col-xs-3">
        <a href="ponderacion.php" class="button">Regresar</a>
        <input type="button" name="imprimir" value="Imprimir"  onClick="window.print();" class="button" />
    </div>
</div>  
<h3>Relacion de Tasas Ponderadas del mes de : <?PHP echo date("M-Y", mktime(0, 0, 0, $periodo, 1, $yy)); ?></h3>
<table class="table">
<tr><th colspan='7'>CREDICOR MEXICANO UNION DE CREDITO SA DE CV</th></tr>
<tr><th>Producto</th><th>Tipo</th><th>Capital</th><th>Intereses</th><th>Tasa Pond.</th><th>Mes</th><th>Ejercicio</th></tr>
<?PHP
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A WHERE A.Producto='CR' AND A.IDMoneda=1 AND A.Empresa='CMU' AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>CR</td><td><a href='relaciondetallepond.php?tipo=1&periodo=".$periodo."&yy=".$yy."'>ACTIVA TOTAL</a></td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A WHERE A.Producto='CR' AND A.IDMoneda=1 AND A.Empresa='CMU' AND A.TipoCartera='G' AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>CR</td><td><a href='relaciondetallepond.php?tipo=2&periodo=".$periodo."&yy=".$yy."'>ACTIVA VIGENTE</a> </td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.2_contratos_disposicion B ON A.IDDisposicion=B.ID WHERE A.Producto='CR' AND A.IDMoneda=1 AND A.Empresa='CMU' AND B.IDOrigenRecursos=2 AND A.Periodo=$periodo AND A.yy=$yy AND A.InteresFND>0 ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>CR</td><td><a href='relaciondetallepond.php?tipo=3&periodo=".$periodo."&yy=".$yy."'>FINANCIAMIENTO RURAL ACTIVA</a></td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.2_contratos_disposicion B ON A.IDDisposicion=B.ID WHERE A.Producto='CR' AND A.IDMoneda=1 AND A.TipoCartera='G' AND A.Empresa='CMU' AND B.IDOrigenRecursos=2 AND A.Periodo=$periodo AND A.yy=$yy AND A.InteresFND>0 ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>CR</td><td><a href='relaciondetallepond.php?tipo=15&periodo=".$periodo."&yy=".$yy."'>FINANCIAMIENTO RURAL VIGENTE ACTIVA</a></td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.InteresFND) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.2_contratos_disposicion B ON A.IDDisposicion=B.ID WHERE A.Producto='CR' AND A.IDMoneda=1 AND A.Empresa='CMU' AND B.IDOrigenRecursos=2 AND A.Periodo=$periodo AND A.yy=$yy AND A.InteresFND>0 ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>CR</td><td><a href='relaciondetallepond.php?tipo=3&periodo=".$periodo."&yy=".$yy."'>FINANCIAMIENTO RURAL PASIVA</a></td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.InteresFND) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.2_contratos_disposicion B ON A.IDDisposicion=B.ID WHERE A.Producto='CR' AND A.IDMoneda=1 AND A.TipoCartera='G' AND A.Empresa='CMU' AND B.IDOrigenRecursos=2 AND A.Periodo=$periodo AND A.yy=$yy AND A.InteresFND>0 ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>CR</td><td><a href='relaciondetallepond.php?tipo=15&periodo=".$periodo."&yy=".$yy."'>FINANCIAMIENTO RURAL VIGENTE PASIVA</a></td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.2_contratos_disposicion B ON A.IDDisposicion=B.ID WHERE A.Producto='CR' AND A.IDMoneda=2 AND A.Empresa='CMU' AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>CR</td><td><a href='relaciondetallepond.php?tipo=4&periodo=".$periodo."&yy=".$yy."'>CARTERA EN DLS</a></td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN 2_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='CR' AND A.IDMoneda=1 AND B.IDTipoCliente<>2 AND A.Empresa='CMU' AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>CR</td><td><a href='relaciondetallepond.php?tipo=5&periodo=".$periodo."&yy=".$yy."'>ACTIVA TOTAL S/PR </a></td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN 2_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='CR' AND A.IDMoneda=1 AND A.Empresa='CMU' AND A.TipoCartera='G' AND B.IDTipoCliente<>2  AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>CR</td><td><a href='relaciondetallepond.php?tipo=6&periodo=".$periodo."&yy=".$yy."'>ACTIVA VIGENTE S/PR </a></td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.InteresFND) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.2_contratos_disposicion B ON A.IDDisposicion=B.ID INNER JOIN 2_cliente C ON A.IDCLiente=C.ID WHERE A.Producto='CR' AND A.IDMoneda=1 AND C.IDTipoCliente<>2  AND A.Empresa='CMU' AND B.IDOrigenRecursos=2 AND A.InteresFND>0 AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>CR</td><td><a href='relaciondetallepond.php?tipo=7&periodo=".$periodo."&yy=".$yy."'>FINANCIAMIENTO RURAL S/PR</a></td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN 2_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='CR' AND A.IDMoneda=2 AND B.IDTipoCliente<>2 AND A.Empresa='CMU' AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    if ($capital==0 || $interes==0) {
        $tasap=0;
    }else{
       $tasap=(($interes/$capital)*(360/$dpond))*100; 
    }
    
echo "<tr><td>CR</td><td><a href='relaciondetallepond.php?tipo=8&periodo=".$periodo."&yy=".$yy."'>CARTERA EN DLS S/PR</a></td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A WHERE A.Producto='IN' AND A.IDMoneda=1 AND A.Empresa='CMU' AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>IN</td><td><a href='relaciondetallepond.php?tipo=9&periodo=".$periodo."&yy=".$yy."'>PASIVA MN</a></td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN 2_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='IN' AND A.IDMoneda=1 AND B.IDTipoCliente<>2 AND A.Empresa='CMU' AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>IN</td><td><a href='relaciondetallepond.php?tipo=10&periodo=".$periodo."&yy=".$yy."'>PASIVA MN S/PR</a> </td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A WHERE A.Producto='IN' AND A.IDMoneda=2 AND A.Empresa='CMU' AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>IN</td><td><a href='relaciondetallepond.php?tipo=11&periodo=".$periodo."&yy=".$yy."'>PASIVA DLS(CC.E. en Dls)</a> </td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN 2_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='IN' AND A.IDMoneda=2 AND B.IDTipoCliente<>2 AND A.Empresa='CMU' AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>IN</td><td><a href='relaciondetallepond.php?tipo=12&periodo=".$periodo."&yy=".$yy."'>PASIVA DLS S/PR(CC.E. en Dls)</a> </td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
echo "<tr><th>Producto</th><th>Tipo</th><th>Tasa Total</th><th>No. de Ctos</th><th>Tasa Prom.</th><th>Mes</th><th>Ejercicio</th></tr>";
$queryResult=$pdo->query("SELECT * FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.2_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='AP' AND A.IDMoneda=1 AND A.Empresa='CMU' AND A.Periodo=$periodo AND A.yy=$yy ");
$num_ctos = $queryResult->rowCount(); 
$queryResult=$pdo->query("SELECT SUM(A.TasaTot) as TasaTotal FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.2_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='AP' AND A.IDMoneda=1 AND  A.Empresa='CMU' AND A.Periodo=$periodo AND A.yy=$yy ");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $tasatotalAP=$row['TasaTotal'];
    $tasaPromAP=$tasatotalAP/$num_ctos;
    
echo "<tr><td>AP</td><td><a href='relaciondetallepond.php?tipo=16&periodo=".$periodo."&yy=".$yy."'>AP FUTUROS</a> </td><td>".number_format($tasatotalAP,2)."</td><td>".$num_ctos."</td><td>".number_format($tasaPromAP,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT * FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.2_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='AP' AND A.IDMoneda=1 AND B.IDTipoCliente<>2 AND A.Empresa='CMU' AND A.Periodo=$periodo AND A.yy=$yy ");
$num_ctos = $queryResult->rowCount(); 
$queryResult=$pdo->query("SELECT SUM(A.TasaTot) as TasaTotal FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.2_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='AP' AND A.IDMoneda=1 AND B.IDTipoCliente<>2 AND A.Empresa='CMU' AND A.Periodo=$periodo AND A.yy=$yy ");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $tasatotalAP=$row['TasaTotal'];
    $tasaPromAP=$tasatotalAP/$num_ctos;
    
echo "<tr><td>AP</td><td><a href='relaciondetallepond.php?tipo=17&periodo=".$periodo."&yy=".$yy."'>AP FUTUROS S/PR</a> </td><td>".number_format($tasatotalAP,2)."</td><td>".$num_ctos."</td><td>".number_format($tasaPromAP,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
echo "</table>";
echo "<table class='table'>";
echo "<tr><th colspan='7'>CREDICOR MEXICANO ARRENDADORA SA DE CV</th></tr>";
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A WHERE A.Producto='VP' AND A.IDMoneda=1 AND A.Empresa='CMA' AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>VP</td><td><a href='relaciondetallepond.php?tipo=13&periodo=".$periodo."&yy=".$yy."'>VENTA PLAZO</a></td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN 3_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='VP' AND A.IDMoneda=1 AND B.IDTipoCliente<>2 AND A.Empresa='CMA' AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>VP</td><td><a href='relaciondetallepond.php?tipo=14&periodo=".$periodo."&yy=".$yy."'>VENTA PLAZO S/PR</a> </td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
echo "<tr><th>Producto</th><th>Tipo</th><th>Tasa Total</th><th>No. de Ctos</th><th>Tasa Prom.</th><th>Mes</th><th>Ejercicio</th></tr>";
$queryResult=$pdo->query("SELECT * FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.3_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='AP' AND A.IDMoneda=1 AND A.Empresa='CMA' AND A.Periodo=$periodo AND A.yy=$yy ");
$num_ctos = $queryResult->rowCount(); 
$queryResult=$pdo->query("SELECT SUM(A.TasaTot) as TasaTotal FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.3_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='AP' AND A.IDMoneda=1 AND  A.Empresa='CMA' AND A.Periodo=$periodo AND A.yy=$yy ");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $tasatotalAP=$row['TasaTotal'];
    $tasaPromAP=$tasatotalAP/$num_ctos;
    
echo "<tr><td>AP</td><td><a href='relaciondetallepond.php?tipo=18&periodo=".$periodo."&yy=".$yy."'>AP FUTUROS</a> </td><td>".number_format($tasatotalAP,2)."</td><td>".$num_ctos."</td><td>".number_format($tasaPromAP,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT * FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.3_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='AP' AND A.IDMoneda=1 AND B.IDTipoCliente<>2 AND A.Empresa='CMA' AND A.Periodo=$periodo AND A.yy=$yy ");
$num_ctos = $queryResult->rowCount(); 
$queryResult=$pdo->query("SELECT SUM(A.TasaTot) as TasaTotal FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.3_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='AP' AND A.IDMoneda=1 AND B.IDTipoCliente<>2 AND A.Empresa='CMA' AND A.Periodo=$periodo AND A.yy=$yy ");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $tasatotalAP=$row['TasaTotal'];
    $tasaPromAP=$tasatotalAP/$num_ctos;
    
echo "<tr><td>AP</td><td><a href='relaciondetallepond.php?tipo=19&periodo=".$periodo."&yy=".$yy."'>AP FUTUROS S/PR</a> </td><td>".number_format($tasatotalAP,2)."</td><td>".$num_ctos."</td><td>".number_format($tasaPromAP,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
?>
</table>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
