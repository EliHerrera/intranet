<?php
    require_once 'header.php';
    //////inicio de contenido
   
   $periodo=date('Y'); 
   $row_count = 0;
    if (!empty($_POST['contestar'])) {
        $queryResult=$pdo->query("SELECT ID,clave,IDQst FROM Intranet.PLD_Cuest WHERE codigo='$_POST[codigo]'");
        
        while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $clave2=$row['clave'];
            $idpregunta=$row['ID'];
            $idrespuesta=$_POST[$clave2];
            $idqst2=$row['IDQst'];  
            $queryResult2=$pdo->query("SELECT * FROM Intranet.PLD_Resultados WHERE IDPersonal=$idpersonal AND IDPregunta=$idpregunta AND IDRespuesta=$idrespuesta AND codigo='$_POST[codigo]' AND periodo=$periodo ");   
            $bandera = $queryResult2->rowCount();
            if ($bandera==0) {
                $queryResult2=$pdo->query("INSERT INTO Intranet.PLD_Resultados (IDPersonal,IDPregunta,IDRespuesta,codigo,periodo,IDQst) VALUES ($idpersonal,$idpregunta,$idrespuesta,'$_POST[codigo]',$periodo,$idqst2)");# code...
            }       
            
        }
        $correctas=0;
        $queryResult=$pdo->query("SELECT IDRespuesta FROM Intranet.PLD_Resultados WHERE IDpersonal=$idpersonal and periodo=$periodo");
        while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $queryResult2=$pdo->query("SELECT * FROM Intranet.PLD_Answer WHERE ID=$row[IDRespuesta] ");
            while($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
                if($row['lAcertivo']=='S'){
                    $correctas++;
                }
            }
        }
        $queryResult = $pdo->query("SELECT * FROM Intranet.PLD_Cuest WHERE IDQst=$idqst2");
        $row_count = $queryResult->rowCount();
        $calf=($correctas/$row_count)*10;
        setlocale(LC_ALL, 'es_ES').': ';
        $fecha_ap=iconv('ISO-8859-1', 'UTF-8', strftime('%A %d de %B de %Y', time())); 
        $queryResult = $pdo->query("UPDATE Intranet.RelQst SET Calf=$calf, lActivo='N',fecha_ap='$fecha_ap' WHERE IDPersonal=$idpersonal AND periodo=$periodo");
        echo "<p>Examen no ".$_POST[codigo]." Fecha : ".$hoy." Empleado : ".$nombre."</p>";
        echo "<div class='alert alert-success'>";
        echo "    <strong>Tuviste </strong>".$correctas."/".$row_count." Respuestas Correctas Tu calificacion es de : ".number_format($calf,2);
        echo "</div>";
        $queryResult=$pdo->query("SELECT A.IDQst,B.codigo,B.llave,B.ID FROM Intranet.RelQst A INNER JOIN Intranet.PLD_Qst B ON A.IDQst=B.ID WHERE A.IDPersonal=$idpersonal AND A.periodo=$periodo and A.lActivo='N'");
        while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $codigo=$row['codigo'];
            $idqst=$row['ID'];
            $llave=$row['llave'];
        }
        ##Inicia ipresion de cuestionario
        $queryResult=$pdo->query("SELECT ID as IDq, Pregunta, clave FROM Intranet.PLD_Cuest WHERE IDQst=$idqst ");
while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $clave=$row['clave'];
    $qst++;
    $idpregunta=$row['IDq'];
    echo "<p>".$qst.") ".$row['Pregunta']."</p>";
    $cont=0;
    $queryResult1=$pdo->query("SELECT ID as IDw, Respuesta,lAcertivo  FROM Intranet.PLD_Answer WHERE IDCuest=$idpregunta ");
    while($row=$queryResult1->fetch(PDO::FETCH_ASSOC)) {
        $idw=$row['IDw'];
        $respuesta=$row['Respuesta'];
        $acertivo=$row['lAcertivo'];
        if ($acertivo=='S') {
            $idwc=$idw;
            $respuestac=$respuesta;
        }
        $queryResult2=$pdo->query("SELECT * FROM  Intranet.PLD_Resultados WHERE IDpersonal=$idpersonal AND IDPregunta=$idpregunta");
        $bandera = $queryResult2->rowCount(); 
        while($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
        
            if($row['IDRespuesta']==$idwc){
                $mensaje='Correcta!';
                $class="alert alert-info";
                $cont++;
            }elseif(($row['IDRespuesta']<>$idwc) && ($cont==0)){
                $mensaje='Incorrecta! La respuesta Correcta es : '.$respuestac;
                $class="alert alert-danger";
            }
            $idr=$row['IDRespuesta'];
        } 
        if($idw==$idr){
        echo "<div class='radio'>";
        echo "    <label><input type='radio' name='".$clave."' checked>".$respuesta."</label>";
        echo "</div>";
        
        }elseif ($idw<>$idr) {
        echo "<div class='radio disabled'>";
        echo "    <label><input type='radio' name='".$clave."' disabled>".$respuesta."</label>";
        echo "</div>";
        }
         
       
    }echo "<div class='".$class."'>".$mensaje."</div>";  

}
        ##termina impresion de cuestionario
        $row_count='N';
        echo "<a href='cuestionario.php' class='button'>Finalizar</a>";
        echo "<a href='javascript:window.print(); void 0;' class='button'>Imprimir</a> ";
        die();
    }
$queryResult=$pdo->query("SELECT A.IDQst,B.codigo,B.llave,B.ID FROM Intranet.RelQst A INNER JOIN Intranet.PLD_Qst B ON A.IDQst=B.ID WHERE A.IDPersonal=$idpersonal AND A.periodo=$periodo and A.lActivo='S'"); 

$codigo=null;
$idqst=0;
$llave=null;
while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $codigo=$row['codigo'];
    $idqst=$row['ID'];
    $llave=$row['llave'];
}  

if(!empty($_POST['llave'])){
    $queryResult=$pdo->query("SELECT * FROM Intranet.RelQst WHERE llave='$_POST[llave]' AND Calf IS NULL;");
    
    $row_count = $queryResult->rowCount(); 
    
}

?>    
<h3>Cuestionario : <?PHP echo $codigo ?></h3>

  <form action="cuestionario.php" method="post">
  <div class="row">
    <div class="col-xs-3">
        <?PHP 
        if ($row_count==0) {
            echo "<label for='llave'>LLAVE</label><input type='text' name='llave' id='llave' class='form-control'>";
        }
        ?>
            <input type="hidden" name="codigo" id="codigo" value="<?PHP echo $codigo ?>" required="true" readonly="true" class="form-control">
    </div>
  </div>
    <?PHP
    if($row_count<>0) {  
        $queryResult=$pdo->query("SELECT ID as IDq, Pregunta, clave FROM Intranet.PLD_Cuest WHERE IDQst=$idqst ");
        while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $clave=$row['clave'];
            $qst++;
            echo "<p>".$qst.") ".$row['Pregunta']."</p>";
            $queryResult1=$pdo->query("SELECT ID as IDw, Respuesta  FROM Intranet.PLD_Answer WHERE IDCuest=$row[IDq] ");
            while($row=$queryResult1->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='radio'>";
                echo "    <label><input type='radio' name='".$clave."' value='".$row['IDw']."'>".$row['Respuesta']."</label>";
                echo "</div>";

            }

        }
    }    
    ?>
    
    <div class="row">
        <div class="col-xs-3">
            <?PHP
                if ($row_count==0) {
                    echo "<input type='submit' value='Enviar' id='enviar' name='enviar' class='button'>";
                }          
                if($row_count<>0){
                    echo "<input type='submit' value='Contestar' id='contestar' name='contestar' class='button'>";
                }    
            ?>
        </div>
    </div>
  </form>
<?php
   /////fin de contenido
    require_once 'footer.php';
?>
