<?php
    require_once 'header.php';
    if (!empty($_POST)) {
        $queryResult = $pdo->query("UPDATE Intranet.gastos SET Status=2 WHERE ID=$_POST[idg] ");
        echo "<div class='alert alert-success'>";
        echo "    <strong>Exito!</strong> Solicitud Fue Autorizada con Exito!";
        echo "</div>";
    }

?> 
<h3>Relacion de Gastos</h3> 
<table class="table">
     <tr><th>No.</th><th>Numero</th><th>Concepto</th><th>Cliente</th><th>Empresa</th><th>Motivo</th><th>Total</th></tr>
        <?php
        if (!empty($_GET)) {
            
        
            $fila=0;
            $queryResult = $pdo->query("SELECT A.ID, A.Num, C.concepto, CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as Cte, IF(A.TipoEmp=2,'CMU',IF(A.TipoEmp=3,'CMA','OTRA')) as TipoEmp, A.Motivo, A.Total  FROM Intranet.GastosDetalle A INNER JOIN sibware.2_cliente B ON A.IDCliente=B.ID INNER JOIN Intranet.concepto_gasto C ON A.concepto=C.ID WHERE A.IDGastos=$_GET[idg]");
            #var_dump($queryResult);
            while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $fila++;
                echo "<tr><td>".$fila."</td><td>".$row['Num']."</td><td>".$row['concepto']."</td><td>".$row['Cte']."</td><td>".$row['TipoEmp']."</td><td>".$row['Motivo']."</td><td>".$row['Total']."</td></tr>";
                
            } 
        }      
        ?>
 </table>
 <form action="viewgastos.php" method="post">
            <input type="hidden" name="idg" id="idg" value="<?PHP echo $_GET['idg'] ?>">
            <?PHP
            if ($fila>0) {
                echo "<input type='submit' value='Autorizar' class='button' name='guardar' id='guardar'>";
            }
            
            ?>
            <a href="gastos.php" class="button">Regresar</a>
 </form>   

<?php
    /////fin de contenido
    require_once 'footer.php';
?>
