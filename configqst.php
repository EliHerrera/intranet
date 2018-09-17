<?php
    require_once 'header.php';
    //////inicio de contenido
    function generarCodigo($longitud) {
        $key = '';
        $pattern = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
        return $key;
       }
    if (!empty($_POST['pregunta'])) {
        $clave=generarCodigo(6);
        $queryResult = $pdo->query("INSERT INTO Intranet.PLD_Cuest (IDQst,Pregunta,codigo,llave,clave) VALUES ($_POST[idqst],'$_POST[pregunta]','$_POST[clave]','$_POST[llave]','$clave')");
        $lastId = $pdo->lastInsertId();        
        $queryResult = $pdo->query("INSERT INTO Intranet.PLD_Answer (IDCuest,Respuesta,lAcertivo) VALUES ($lastId,'$_POST[r1]','$_POST[acertivo1]')");
        $queryResult = $pdo->query("INSERT INTO Intranet.PLD_Answer (IDCuest,Respuesta,lAcertivo) VALUES ($lastId,'$_POST[r2]','$_POST[acertivo2]')");
        $queryResult = $pdo->query("INSERT INTO Intranet.PLD_Answer (IDCuest,Respuesta,lAcertivo) VALUES ($lastId,'$_POST[r3]','$_POST[acertivo3]')");
        $queryResult = $pdo->query("INSERT INTO Intranet.PLD_Answer (IDCuest,Respuesta,lAcertivo) VALUES ($lastId,'$_POST[r4]','$_POST[acertivo4]')");
        echo "<div class='alert alert-success'>";
        echo "    <strong>Exito!</strong> Pregunta Registrada con Exito!";
        echo "</div>";
    }
    if (!empty($_GET)||!empty($_POST)) {
        if (!empty($_GET['idqst'])){
            $idqst=$_GET['idqst'];
        }elseif (!empty($_POST['idqst'])) {
            $idqst=$_POST['idqst'];
        }
        $queryResult = $pdo->query("SELECT * FROM Intranet.PLD_Qst WHERE ID=$idqst");
        while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $llave=$row['llave'];
            $idqst=$row['ID'];
            $folio=$row['codigo'];
            $cont=$row['no_preguntas'];
        }
        $queryResult = $pdo->query("SELECT * FROM Intranet.PLD_Cuest WHERE IDQst=$idqst AND llave='$llave' AND codigo='$folio'");
        $row_count = $queryResult->rowCount(); 
        
        
    }
?> 
<?PHP 
    if($cont>$row_count){
?>
<h3>Agregar preguntas y respuestas del cuestionario <?PHP echo $folio  ?></h3>
<form action="configqst.php" method="post">
<input type="hidden" name="clave" value="<?PHP echo $folio  ?>" required="true">
<input type="hidden" name="llave" value="<?PHP echo $llave  ?>" required="true">
<input type="hidden" name="idqst" value="<?PHP echo $idqst  ?>" required="true">
<div class="row">
    <div class="col-xs-10">
        <label for="pregunta">Pregunta</label><input type="text" name="pregunta" id="pregunta" class="form-control" required="true" placeholder="Escriba pregunta tal y como desea qu aparezca en el cuestionario">
    </div>
</div> 
<div class="row">
    <div class="col-xs-6">
        <label for="r1">1).-</label><input type="text" name="r1" id="r1" class="form-control" required="true" placeholder="Escriba respuesta">
    </div>
    <div class="col-xs-2">
        <label for="acertivo1">Acertivo</label><select name="acertivo1" id="acertivo1" class="form-control" required="true">
            <option value="">...</option>
            <option value="S">Si</option>
            <option value="N">No</option>

        </select>
    </div>
</div> 
<div class="row">
    <div class="col-xs-6">
        <label for="r2">2).-</label><input type="text" name="r2" id="r2" class="form-control" required="true" placeholder="Escriba respuesta">
    </div>
    <div class="col-xs-2">
        <label for="acertivo2">Acertivo</label><select name="acertivo2" id="acertivo2" class="form-control" required="true">
            <option value="">...</option>
            <option value="S">Si</option>
            <option value="N">No</option>

        </select>
    </div>
</div><div class="row">
    <div class="col-xs-6">
        <label for="r3">3).-</label><input type="text" name="r3" id="r3" class="form-control" required="true" placeholder="Escriba respuesta">
    </div>
    <div class="col-xs-2">
        <label for="acertivo3">Acertivo</label><select name="acertivo3" id="acertivo3" class="form-control" required="true">
            <option value="">...</option>
            <option value="S">Si</option>
            <option value="N">No</option>

        </select>
    </div>
</div><div class="row">
    <div class="col-xs-6">
        <label for="r4">4).-</label><input type="text" name="r4" id="r4" class="form-control" required="true" placeholder="Escriba respuesta">
    </div>
    <div class="col-xs-2">
        <label for="acertivo4">Acertivo</label><select name="acertivo4" id="acertivo4" class="form-control" required="true">
            <option value="">...</option>
            <option value="S">Si</option>
            <option value="N">No</option>

        </select>
    </div>
    <div class="col-xs-3">
        <br><input type="submit" value="Agregar" class="button">
    </div>
</div>  
</form>
<?PHP
    }
?>
<h3>Cuestionario <?PHP echo $folio ?></h3><a href="addqst.php" class="button">Regresar</a>
<table class="table">
    <?PHP   
      #$queryResult = $pdo->query("SELECT * FROM Intranet.PLD_Cuest WHERE IDQst=$idqst AND llave='$llave' AND codigo='$folio'"); 
      
      while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
          $fila++;
       echo "<tr><th>Pregunta</th></tr>";    
          echo "<tr><td>".$fila.").-".$row['Pregunta']."</td></tr>";
          echo "<tr><th>Respuesta</th><th>Correcta</th></tr>";
          $queryResult2 = $pdo->query("SELECT Respuesta, CASE WHEN lAcertivo='S' THEN 'Si' WHEN lAcertivo='N' THEN 'No' END as Acertivo FROM Intranet.PLD_Answer WHERE IDCuest=$row[ID]");
          while($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
              echo "<tr><td>".$row['Respuesta']."</td><td>".$row['Acertivo']."</td></tr>";
          }
      }  
    ?>
</table>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
