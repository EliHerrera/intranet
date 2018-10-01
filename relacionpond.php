<?php
    require_once 'header.php';
    //////inicio de contenido
    $queryResult=$pdo->query("SELECT * FROM Intranet.ponderacion WHERE ID=$_GET[idpon]");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $periodo=$row['periodo'];
        $yy=$row['yy'];
    }
?>    
<h3>Relacion de Tasas Ponderadas del mes de : <?PHP echo date("M-Y", mktime(0, 0, 0, $periodo, 1, $yy)); ?></h3>
<table class="table">
<tr><th>Producto</th><th>Tipo</th><th>Capital</th><th>Intereses</th><th>Tasa Pond.</th><th>Mes</th><th>Ejercicio</th></tr>
<?PHP
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A WHERE A.Producto='CR' AND A.IDMoneda=1 AND A.Empresa='CMU' AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>CR</td><td>ACTIVA TOTAL </td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A WHERE A.Producto='CR' AND A.IDMoneda=1 AND A.Empresa='CMU' AND A.TipoCartera='G' AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>CR</td><td>ACTIVA VIGENTE </td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.InteresFND) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.2_contratos_disposicion B ON A.IDDisposicion=B.ID WHERE A.Producto='CR' AND A.IDMoneda=1 AND A.Empresa='CMU' AND B.IDOrigenRecursos=2 AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>CR</td><td>FINANCIAMIENTO RURAL</td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.2_contratos_disposicion B ON A.IDDisposicion=B.ID WHERE A.Producto='CR' AND A.IDMoneda=2 AND A.Empresa='CMU' AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>CR</td><td>CARTERA EN DLS</td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN 2_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='CR' AND A.IDMoneda=1 AND B.IDTipoCliente<>2 AND A.Empresa='CMU' AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>CR</td><td>ACTIVA TOTAL S/PR </td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN 2_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='CR' AND A.IDMoneda=1 AND A.Empresa='CMU' AND A.TipoCartera='G' AND B.IDTipoCliente<>2  AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>CR</td><td>ACTIVA VIGENTE S/PR </td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.InteresFND) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN sibware.2_contratos_disposicion B ON A.IDDisposicion=B.ID INNER JOIN 2_cliente C ON A.IDCLiente=C.ID WHERE A.Producto='CR' AND A.IDMoneda=1 AND C.IDTipoCliente<>2  AND A.Empresa='CMU' AND B.IDOrigenRecursos=2 AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>CR</td><td>FINANCIAMIENTO RURAL S/PR</td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
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
    
echo "<tr><td>CR</td><td>CARTERA EN DLS S/PR</td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A WHERE A.Producto='IN' AND A.IDMoneda=1 AND A.Empresa='CMU' AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>IN</td><td>PASIVA MN </td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN 2_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='IN' AND A.IDMoneda=1 AND B.IDTipoCliente<>2 AND A.Empresa='CMU' AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>IN</td><td>PASIVA MN S/PR </td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A WHERE A.Producto='IN' AND A.IDMoneda=2 AND A.Empresa='CMU' AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>IN</td><td>PASIVA DLS(CC.E. en Dls) </td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN 2_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='IN' AND A.IDMoneda=2 AND B.IDTipoCliente<>2 AND A.Empresa='CMU' AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>IN</td><td>PASIVA DLS S/PR(CC.E. en Dls) </td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A WHERE A.Producto='VP' AND A.IDMoneda=1 AND A.Empresa='CMA' AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>VP</td><td>VENTA PLAZO</td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
$queryResult=$pdo->query("SELECT SUM(A.SaldoCap) as Cap,SUM(A.Interes) as Inte FROM Intranet.relacion_tasa_pond A INNER JOIN 3_cliente B ON A.IDCLiente=B.ID WHERE A.Producto='VP' AND A.IDMoneda=1 AND B.IDTipoCliente<>2 AND A.Empresa='CMA' AND A.Periodo=$periodo AND A.yy=$yy ");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $capital=$row['Cap'];
    $interes=$row['Inte'];
    $tasap=(($interes/$capital)*(360/$dpond))*100;
echo "<tr><td>VP</td><td>VENTA PLAZO S/PR </td><td>".number_format($capital,2)."</td><td>".number_format($interes,2)."</td><td>".number_format($tasap,2)."</td><td>".$periodo."</td><td>".$yy."</td></tr>";    
}
?>
</table>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
