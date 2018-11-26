<?php
    require_once 'header.php';
    //////inicio de contenido
    if (!empty($_GET['mes'])) {
        $mes=$_GET['mes'];
        $yy=$_GET['yy'];
        $pro=$_GET['pro'];
        $emp=$_GET['emp'];
        if ($emp==2) {
            $empresa='CMU';
        }elseif ($emp==3) {
            $empresa='CMA';
        }
        switch ($pro) {
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
        $queryResult=$pdo->query("SELECT * FROM Intranet.cobranzaesperada WHERE mesp=$mes AND yyp=$yy AND producto='$pro' AND emp=$emp ");
        
    }
?>    
<h3>Cobranza Esperada <?php echo "de ".$producto." mes ".$mes." año ".$yy ?></h3><a href="cobranzaesperada.php" class="button">Regresar</a>
<table class="table">
<tr><th>Cliente</th><th>Folio</th><th>Disp</th><th>Tipo Cliente</th><th>Ejecutivo</th><th>Sucursal</th><th>Capital/Renta Esperado</th><th>Capital/Renta Recibido</th><th>Interes Esperado</th><th>Interes Pagado</th><th>Moras Pagadas</th><th>Fecha Pago</th></tr>
<?php   
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
        $capitalesperado=$row['capitalesperado'];
        $ivacapitalesperado=$row['IvaCapitalEsperado'];
        $rentaesperada=$row['RentaEsperada'];
        $capitalpagado=$row['capitalpagado'];
        $rentapagada=$row['RentaPagada'];
        $ivacapitalpagado=$row['IvaCapitalPagado'];
        $interesesperado=$row['interesesperado'];
        $ivainteresesperado=$row['IvaInteresEsperado'];
        $interespagado=$row['interespagado'];
        $ivainterespagado=$row['IvaInteresPagado'];
        $capitalesperado=$capitalesperado+$ivacapitalesperado+$rentaesperada;
        $capitalpagado=$capitalpagado+$ivacapitalpagado+$rentapagada;
        $interesesperado=$interesesperado+$ivainteresesperado;
        $interespagado=$interespagado+$ivainterespagado;
        $moraspagadas=$row['moraspagadas'];
        
        echo "<tr><td>".$row['cliente']."</td><td>".$row['Folio']."</td><td>".$row['disposicion']."</td><td>".$row['tipocte']."</td><td>".$row['ejecutivo']."</td><td>".$row['sucursal']."</td><td>".number_format($capitalesperado,2)."</td><td>".number_format($capitalpagado,2)."</td><td>".number_format($interesesperado,2)."</td><td>".number_format($interespagado,2)."</td><td>".number_format($moraspagadas,2)."</td><td>".$row['fechapago']."</td></tr>";
        }
?>
</table>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
