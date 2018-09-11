<?php
    require_once 'header.php';
    $folio=null;  
    $hoy=date("Y-m-d H:i:s"); 
    $gtotal=0;
    if(!empty($_GET['idconc'])){
        $queryResult = $pdo->query("DELETE from Intranet.GastosDetalle WHERE ID=$_GET[idconc]");
        echo "<div class='alert alert-danger'>";
        echo "    <strong>Aviso!</strong> Concepto Eliminado con Exito!";
        echo "</div>";

    }
    if (!empty($_POST['guardar'])) {
        $queryResult = $pdo->query("INSERT INTO Intranet.gastos (Folio,Fecha,IDPersonal,Total,Status) VALUES('$_SESSION[folio]','$hoy',$idpersonal,$_POST[Tot],1)");
        $lastid = $pdo->lastInsertId();
        $queryResult=$pdo->query("UPDATE Intranet.GastosDetalle SET IDGastos=$lastid WHERE folio=$_SESSION[folio] ");
        #var_dump($queryResult);
        echo "<div class='alert alert-success'>";
        echo "    <strong>Exito!</strong> Solicitud Fue Guardada con Exito!";
        echo "</div>";
        unset($_SESSION["folio"]);
        unset($_SESSION["gtotal"]);
    }
    if (!empty($_POST['agregar'])) {
        if ($_POST['tiva']==$piva) {
            $total=$_POST['total'];
            $subtot=$total/(1+($piva/100));
            $iva=$subtot*($piva/100);
        } elseif ($_POST['tiva']==0) {
            $total=$_POST['total'];
            $subtot=$total;
            $iva=0;
        }
        if(empty($_POST['comensal'])){
            $comensales=0;
        }else {
            $comensales=$_POST['comensal'];
        }
        if (empty($_POST['origen'])) {
            $origen='NA';
        }else{
            $origen=$_POST['origen'];
        }
        if (empty($_POST['destino'])) {
            $destino='NA';
        }else{
            $destino=$_POST['destino'];
        }
        $queryResult = $pdo->query("INSERT INTO Intranet.GastosDetalle (Num,concepto,IDCliente,TipoEmp,motivo,subtotal,IVA,total,folio,IDPersonal,fecha,comensales,origen,destino) VALUES ('$_POST[folioinv]', $_POST[concepto], $_POST[idcte],$_POST[emp],' $_POST[motivo]',$subtot,$iva,$total,'$_SESSION[folio]',$idpersonal,'$_POST[fecha]',$comensales,'$origen','$destino')");    
        #var_dump($queryResult);
        // $gtotal=$gtotal+$total;
        // $_SESSION['gtotal']=$gtotal;
        echo "<div class='alert alert-info'>";
        echo "    <strong>Exito!</strong> Concepto Agregado con Exito!";
        echo "</div>";
    }
    //////inicio de contenido
?>    
<?php
  
 
    function generarCodigo($longitud) {
        $key = '';
        $pattern = '1234567890';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
        return $key;
       }

       if (empty($_SESSION['folio'])) {
          $folio=generarCodigo(6);
          $_SESSION['folio']=$folio; # code...
       }
       
  $queryResult = $pdo->query("SELECT CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as Personal  FROM sibware.personal B  WHERE B.ID=$idpersonal");
  while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
      $personal=$row['Personal'];
  }
 ?>
 <h3>Relacion de Gastos</h3> 
 <form action="addgasto.php" method="post">
 <div class="row">
     <div class="col-xs-4">
         <label for="nombre">Nombre</label><input type="text" name="nombre" id="nombre" class="form-control" value="<?PHP echo $personal ?>" readonly="true">
     </div>
     <div  class="col-xs-2">
        <label for="folio">Folio</label><input type="text" name="folio" id="folio" value="<?PHP echo $_SESSION['folio'] ?>" class="form-control" readonly="true">
     </div>
 </div>
 <div class="row">
     <div class="col-xs-3">
         <label for="fecha">Fecha</label><input type="date" name="fecha" id="fecha" class="form-control" required="true">
     </div>
     <div class="col-xs-2">
         <label for="folioinv">Fact/Nota/Recibo</label><input type="text" name="folioinv" id="folioinv" required="true" class="form-control" placeholder="Escriba numero de Nota">
     </div>
     <div class="col-xs-2">
         <label for="concepto">Concepto</label><select name="concepto" id="concepto" class="form-control" required="true" onchange="this.form.submit();return false;">
             <option value="">Seleccione uno...</option>
             <?php
             $queryResult=$pdo->query("SELECT * FROM Intranet.concepto_gasto");
             while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
             if ($row['ID']==$_POST['concepto']) {
                echo "<option selected='selected' value='".$row['ID']."'>".$row['concepto']."</option>";
             }else{    
                echo "<option value='".$row['ID']."'>".$row['concepto']."</option>";
                }
             }
             ?>
         </select>
     </div>
     <?PHP
        if ($_POST['concepto']==1||$_POST['concepto']==7||$_POST['concepto']==8) {
            echo "<div class='col-xs-1'>";
            echo    "<label for='comensal'>No. de Comensales</label><input type='number' name='comensal' id='comensal' class='form-control' required='true'>";
            echo "</div>";
        }
     ?>
     <div class="col-xs-4">
         <label for="idcte">Socio/Prospecto</label><select name="idcte" id="idcte" class="form-control" required="true" onchange="this.form.submit();return false;" >
             <option value="">Seleccione uno...</option>
             <?PHP 
             if ($_POST['emp']==2) {
                $queryResult = $pdo->query("SELECT A.IDCte,CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as Nombre FROM sibware.pipeline_prospec A INNER JOIN sibware.2_cliente B ON A.IDCte=B.ID  WHERE A.IDEjecutivo=21 and A.Emp=2 GROUP BY A.IDCte ORDER BY A.Nombre ASC ") ;
                while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                    if ($row['IDCte']==$_POST['idcte']) {
                        echo "<option selected='selected' value='".$row['IDCte']."'>[CMU]".$row['Nombre']."</option>";# code...
                    }else{
                        echo "<option value='".$row['IDCte']."'>[CMU]".$row['Nombre']."</option>";
                    }
                    
                }
             }elseif ($_POST['emp']==3) {
                $queryResult = $pdo->query("SELECT A.IDCte,CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as Nombre FROM sibware.pipeline_prospec A INNER JOIN sibware.3_cliente B ON A.IDCte=B.ID  WHERE A.IDEjecutivo=21 and A.Emp=3 GROUP BY A.IDCte ORDER BY A.Nombre ASC ") ;
                while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                    if ($row['IDCte']==$_POST['idcte']) {
                        echo "<option selected='selected' value='".$row['IDCte']."'>[CMA]".$row['Nombre']."</option>";
                    } else {
                        echo "<option value='".$row['IDCte']."'>[CMA]".$row['Nombre']."</option>";
                    }
                    
                    
                }
             }
             ?>
         </select>
     </div>
     
     
 </div> 
 <?PHP
        if ($_POST['concepto']==6) {
            echo "<div class='row'>";
            echo "<div class='col-xs-3'>";
            echo    "<label for='origen'>Origen</label><input type='text' name='origen' id='origen' class='form-control' required='true'>";
            echo "</div>";
            echo "<div class='col-xs-3'>";
            echo    "<label for='destino'>Destino</label><input type='text' name='destino' id='destino' class='form-control' required='true'>";
            echo "</div>";
            echo "</div>";
        }
     ?>
 <div class="row">
     <div class="col-xs-2">
         <label for="total">Total</label><input type="number" name="total" id="total" class="form-control" required="true">
     </div>
     <div class="col-xs-2">
         <label for="tiva">Tipo IVA</label><select name="tiva" id="tiva" class="form-control" required="true">
             <option value="">Tipo IVA...</option>
             <option value="0">0%</option>
             <option value="16">16%</option>
             <option value="0">Excento</option>
         </select>
     </div>
     <div class="col-xs-5">
         <label for="motivo">Motivo</label><textarea name="motivo" id="motivo" cols="70" rows="2" placeholder="Capture el Motivo" class="form-control" required="true"></textarea>
     </div>
     <div class="col-xs-2">
         <label for="emp">Empresa</label><select name="emp" id="emp" class="form-control" required="true" onchange="this.form.submit();return false;">
             <option value="">...</option>
             <?PHP
                if ($_POST['emp']==2) {
                    echo "<option selected='selected' value='2'>CMU</option>";
                    echo "<option value='3'>CMA</option>";
                }elseif ($_POST['emp']==3) {
                    echo "<option selected='selected' value='3'>CMA</option>";
                    echo "<option value='2'>CMU</option>";
                }else{
                    echo "<option value='2'>CMU</option>";
                    echo "<option value='3'>CMA</option>";
                }
             ?>
             
             
         </select>
     </div>
     <div class="col-xs-1">
         <br><input type="submit" value="Agregar" id="agregar" name="agregar" class="button">
     </div>
 </div>   
 </form>
 <table class="table">
     <tr><th>No.</th><th>Numero</th><th>Concepto</th><th>Cliente</th><th>Empresa</th><th>Motivo</th><th>Total</th><th>Eliminar</th></tr>
        <?php
             $fila=0;
            $queryResult = $pdo->query("SELECT A.ID, A.Num, C.concepto, CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as Cte, IF(A.TipoEmp=2,'CMU',IF(A.TipoEmp=3,'CMA','OTRA')) as TipoEmp, A.Motivo, A.Total  FROM Intranet.GastosDetalle A INNER JOIN sibware.2_cliente B ON A.IDCliente=B.ID INNER JOIN Intranet.concepto_gasto C ON A.concepto=C.ID WHERE A.folio=$_SESSION[folio] AND A.IDPersonal=$idpersonal AND A.TipoEmp=2 ");
            #var_dump($queryResult);
            while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $fila++;
                echo "<tr><td>".$fila."</td><td>".$row['Num']."</td><td>".$row['concepto']."</td><td>".$row['Cte']."</td><td>".$row['TipoEmp']."</td><td>".$row['Motivo']."</td><td>".$row['Total']."</td><td><a href='addgasto.php?idconc=".$row['ID']."'><img src='img/icons/delete.png'</a></td></tr>";
                $gtotal=$gtotal+$row['Total'];
            } 
            $queryResult = $pdo->query("SELECT A.ID, A.Num, C.concepto, CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as Cte, IF(A.TipoEmp=2,'CMU',IF(A.TipoEmp=3,'CMA','OTRA')) as TipoEmp, A.Motivo, A.Total  FROM Intranet.GastosDetalle A INNER JOIN sibware.3_cliente B ON A.IDCliente=B.ID INNER JOIN Intranet.concepto_gasto C ON A.concepto=C.ID WHERE A.folio=$_SESSION[folio] AND A.IDPersonal=$idpersonal AND A.TipoEmp=3");
            while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $fila++;
                echo "<tr><td>".$fila."</td><td>".$row['Num']."</td><td>".$row['concepto']."</td><td>".$row['Cte']."</td><td>".$row['TipoEmp']."</td><td>".$row['Motivo']."</td><td>".$row['Total']."</td><td><a href='addgasto.php?idconc=".$row['ID']."'><img src='img/icons/delete.png'</a></td></tr>";
                $gtotal=$gtotal+$row['Total'];
            }    
        ?>
 </table>
 <form action="addgasto.php" method="post">
            <input type="hidden" name="Tot" value="<?PHP echo $gtotal ?>">
            <?PHP
            if ($fila>0) {
                echo "<input type='submit' value='Guardar' class='button' name='guardar' id='guardar'>";
            }
            
            ?>
            <a href="gastos.php" class="button">Regresar</a>
 </form>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
