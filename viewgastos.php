<?php
    require_once 'header.php';
    if (!empty($_POST['guardar'])) {
        $queryResult = $pdo->query("UPDATE Intranet.gastos SET Status=2 WHERE ID=$_POST[idg] ");
        echo "<div class='alert alert-success'>";
        echo "    <strong>Exito!</strong> Solicitud Fue Autorizada con Exito!";
        echo "</div>";
    }
    if (!empty($_POST['compras'])) {
        $queryResult=$pdo->query("SELECT A.ID,A.IDPersonal, A.Total, CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2)as emp FROM Intranet.gastos A INNER JOIN sibware.personal B ON A.IDPersonal=B.ID  WHERE A.ID=$_POST[idg]");
        while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $emp=$row['emp'];
            $total=$row['Total'];
            $idcom=$row['ID'];
        }
        $queryResult = $pdo->query("INSERT INTO sibware.5_ad_autorizacionpagos (IDConcepto,IDPersonal,FechaPago,ImporteSolicitado,lAutorizado,IDMoneda,origen,Referencia,Beneficiario,Nombre,Modulo,Concepto,Status) VALUES (1,$idpersonal,'$hoy',$total,'N',1,'PV','PAGO PROVEEDORES','$emp','$emp','PD','REMBOLSO DE MANTTO. DE CARTERA','N') ");
        
        $lastid = $pdo->lastInsertId();
        $queryResult=$pdo->query("SELECT CONCAT('[',B.concepto,'] ',CONCAT(C.Nombre,' ',C.Apellido1,' ',C.Apellido2)) as Descr FROM Intranet.GastosDetalle A INNER JOIN Intranet.concepto_gasto B ON A.concepto=B.ID INNER JOIN sibware.2_cliente C ON A.IDCliente=C.ID WHERE A.IDGastos=$idcom AND A.TipoEmp=2 ");
        while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $desc=$row['Descr'];
            $queryResult1=$pdo->query("INSERT INTO sibware.5_ad_docs_solicitudpagos (IDAutorizacion,Descripcion,Comentario,Requerido,lDocumento) VALUES ($lastid,'$desc','$desc','S','N')");
        }
        $queryResult=$pdo->query("SELECT CONCAT('[',B.concepto,'] ',CONCAT(C.Nombre,' ',C.Apellido1,' ',C.Apellido2)) as Descr FROM Intranet.GastosDetalle A INNER JOIN Intranet.concepto_gasto B ON A.concepto=B.ID INNER JOIN sibware.3_cliente C ON A.IDCliente=C.ID WHERE A.IDGastos=$idcom AND A.TipoEmp=3 ");
        while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $desc=$row['Descr'];
            $queryResult1=$pdo->query("INSERT INTO sibware.5_ad_docs_solicitudpagos (IDAutorizacion,Descripcion,Comentario,Requerido,lDocumento) VALUES ($lastid,'$desc','$desc','S','N')");
        }
        $queryResult = $pdo->query("UPDATE Intranet.gastos SET Status=3 WHERE ID=$_POST[idg] ");
        echo "<div class='alert alert-success'>";
        echo "    <strong>Exito!</strong> Solicitud Fue enviada a compras con Exito!";
        echo "</div>";
    }


?> 
<h3>Relacion de Gastos</h3> 
<table class="table">
     <tr><th>No.</th><th>Numero</th><th>Concepto</th><th>Cliente</th><th>Empresa</th><th>Motivo</th><th>Total</th></tr>
        <?php
        if (!empty($_GET)) {
            
        
            $fila=0;
            $queryResult=$pdo->query("SELECT * FROM Intranet.gastos WHERE ID=$_GET[idg]");
            while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $status=$row['Status'];
            }
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
            if ($fila>0 && $status==1) {
                echo "<input type='submit' value='Autorizar' class='button' name='guardar' id='guardar'>";
            }
            if ($status==2) {
                echo "<input type='submit' value='Enviar a Compras' class='button' name='compras' id='compras'>";
            }
            ?>
            <a href="gastos.php" class="button">Regresar</a>
 </form>   

<?php
    /////fin de contenido
    require_once 'footer.php';
?>
