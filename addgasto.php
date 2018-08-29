<?php
    require_once 'header.php';
    if (!empty($_POST['agregar'])) {
        echo "<div class='alert alert-success'>";
        echo "    <strong>Exito!</strong>Concepto Agregado con Exito!";
        echo "</div>";
    }
    //////inicio de contenido
?>    
<?php
  $folio=null;  
  $hoy=date("Y-m-d H:i:s"); 
 
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
     <div class="col-xs-3">
         <label for="concepto">Concepto</label><select name="concepto" id="concepto" class="form-control" required="true">
             <option value="">Seleccione uno...</option>
             <option value="0">0%</option>
         </select>
     </div>
     <div class="col-xs-3">
         <label for="idcte">Socio/Prospecto</label><select name="idcte" id="idcte" class="form-control" required="true" >
             <option value="">Seleccione uno...</option>
             <option value="0">0%</option>
         </select>
     </div>
     
 </div> 
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
     <div class="col-xs-6">
         <label for="motivo">Motivo</label><textarea name="motivo" id="motivo" cols="70" rows="2" placeholder="Capture el Motivo" class="form-control" required="true"></textarea>
     </div>
     <div class="col-xs-1">
         <br><input type="submit" value="Agregar" id="agregar" name="agregar" class="button">
     </div>
 </div>   
 </form>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
