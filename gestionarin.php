<?php   
    require_once 'headerbi.php';
    require 'menubi.php';
    $hoy=date('Y-m-d');
    if (!empty($_POST['guardar'])) {
        $fil=$_POST['fil'];
        $queryInsert=$pdo->prepare("INSERT INTO Intranet.gestion_riesgos (ID_Ticket,fecha,impacto,seguimiento) VALUES($_POST[idticket],'$hoy','$_POST[impacto]','$_POST[seguimiento]')");
        $queryInsert->execute();
        echo "<div class='alert alert-success'>";
        echo "    <strong>Exito!</strong> Guardado con Exito!";
        echo "</div>";
    }
    if (!empty($_POST['actualizar'])) {
        $fil=$_POST['fil'];
        $queryUpdate=$pdo->prepare("UPDATE Intranet.gestion_riesgos SET impacto='$_POST[impacto]', seguimiento='$_POST[seguimiento]', fecha='$hoy' WHERE ID_Ticket=$_POST[idticket] ");
        $queryUpdate->execute();
        echo "<div class='alert alert-success'>";
        echo "    <strong>Exito!</strong> Actualizado con Exito!";
        echo "</div>";
    }
    if (!empty($_GET)) {
        $id_ticket=$_GET['idticket'];
        $fil=$_GET['fil'];
    }elseif(!empty($_POST)){
        $id_ticket=$_POST['idticket'];
        $fil=$_POST['fil'];

    }
        $queryResult=$pdo->query("SELECT
                                    A.ID_Ticket,
                                    A.fecha_alta,
                                    A.folio,
                                    C.macroproceso,
                                    A.Mensaje,
                                    CONCAT(D.Nombre,' ',D.Apellido1,' ',D.Apellido2) as usuario
                                FROM
                                    Intranet.ticket A
                                INNER JOIN Intranet.msj_ticket B ON A.ID_Ticket = B.IDTicket
                                INNER JOIN Intranet.r_macroproceso C on A.ID_Categoria=C.ID
                                INNER JOIN sibware.personal D on A.ID_Usuario=D.ID
                                WHERE
                                    A.ID_Ticket=$id_ticket");
                                while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                                    $idticket=$row['ID_Ticket'];
                                    $fecha_alta=$row['fecha_alta'];
                                    $folio=$row['folio'];
                                    $macroproceso=$row['macroproceso'];
                                    $acontecimineto=$row['Mensaje'];
                                    $usuario=$row['usuario'];
                                }    
                                $queryResult2=$pdo->query("SELECT
                                                A.mensaje
                                            FROM
                                                Intranet.msj_ticket A
                                            
                                            WHERE
                                                A.IDTicket = $idticket
                                                and A.IDUsuario=$idcontraloria
                                            "); 
                                            
                                while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
                                        $cambios=$row['mensaje'];
                                        
                                } 
                                $queryResult2=$pdo->query("SELECT
                                                *
                                            FROM
                                                Intranet.gestion_riesgos A
                                            
                                            WHERE
                                                A.ID_Ticket = $idticket
                                               
                                            "); 
                                            
                                $row_count = $queryResult2->rowCount(); 
                                while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
                                    $impacto=$row['impacto'];
                                    $seguimiento=$row['seguimiento'];
                                    
                                } 

                                   
    
    //////inicio de contenido
?>  
<h3>Comentarios para la Incidencia : <?php echo $folio; ?></h3> 
<div class="row">
  <div class="col-md-4"><?php echo "<strong>Fecha : </strong><p class='text-xs-left'>".$fecha_alta."</p>"; ?></div>
  <div class="col-md-4"><?php echo "<strong>Proceso : </strong><p class='text-xs-left'>".$macroproceso."</p>"; ?></div>
  <div class="col-md-4"><?php echo "<strong>Usuario : </strong><p class='text-xs-left'>".$usuario."</p>"; ?></div>
</div>
<br>
<div class="row">
  <div class="col-md-6"><?php echo "<strong>Acontecimiento : </strong><p class='text-xs-left'>".$acontecimineto."</p>"; ?></div>
  <div class="col-md-6"><?php echo "<strong>Cambios : </strong><p class='text-xs-left'>".$cambios."</p>"; ?></div>
</div>
<div class="row">
  <div class="col-md-6"><?php echo "<strong>Impacto o Modificacion en Políticas : </strong><p class='text-xs-left'>".$impacto."</p>"; ?></div>
  <div class="col-md-6"><?php echo "<strong>Seguimiento Contralor Normativo : </strong><p class='text-xs-left'>".$seguimiento."</p>"; ?></div>
</div>
<form action="gestionarin.php" method="post">
    <div class="row">
        <input type="text" name="fil" id="fil" required="true" hidden="true" value="<?php echo $fil ?>">                        
        <input type="text" name="idticket" id="idticket" value="<?php echo $idticket ?>" required="true" hidden="true">
        <div class="col-xs-6">
            <label for="impacto">Impacto</label><textarea name="impacto" id="impacto" cols="30" rows="5" placeholder="Ingresar informacion aqui" class="form-control" required="true"></textarea>
        </div>
        <div class="col-xs-6">
            <label for="seguimineto">Seguimiento</label><textarea name="seguimiento" id="seguimiento" cols="30" rows="5" placeholder="Ingresar informacion aqui" class="form-control" required="true"></textarea>
        </div>
    </div>
       
        
    
    <?php
    
    if($row_count==0){
    echo "<div class='row'>    
        <div class='col-xs-3'>
            <input type='submit' value='Guardar' id='guardar' name='guardar' class='button'>
        </div>";
    
    }elseif($row_count != 0){
    
    echo "  <div class='row'>    
        <div class='col-xs-3'>
            <input type='submit' value='Actualizar' id='actualizar' name='actualizar' class='button'>
        </div>";
    
    }
    
    ?>
        <div class="col-xs-2">   
            <a href="incidenciasg.php?b=<?php echo $_GET['b']; ?>&fil=<?php echo $fil; ?>" class="button">Regresar</a>
        </div>
    </div>
</form>


<?php
    /////fin de contenido
    require_once 'footer.php';
?>
