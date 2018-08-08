<?php
    require_once 'header.php';
    $hoy = date("Y-m-d H:i:s"); 
    if (!empty($_POST)) {
        function generarCodigo($longitud) {
            $key = '';
            $pattern = '1234567890';
            $max = strlen($pattern)-1;
            for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
            return $key;
           }
           $folio=generarCodigo(6);
           $queryResult = $pdo->query("INSERT INTO Intranet.ticket(Titulo,Mensaje,Estatus,fecha_alta,ID_Usuario,ID_Sucursal,ID_Categoria,ID_Prioridad,folio)
                                                           VALUES ('$_POST[asunto]','$_POST[rep]','A','$hoy',$_POST[emp],$_POST[suc],$_POST[cat],$_POST[nivel],'$folio')");
           $queryResult = $pdo->query("SELECT LAST_INSERT_ID()");
           $lastId = $queryResult->fetchColumn();
           
           if ($_FILES['att']["error"] > 0)
	        {
                echo "Error: " . $_FILES['archivo']['error'] . "<br>";
                echo "<div class='alert alert-danger'>";
                echo "    <strong>Error!</strong>El archivo no cumple con las caracteritiscas permitidas!";
                echo "</div>";

	        }else{
                
                
		        $file=$_FILES['archivo']['name'];
		        move_uploaded_file($_FILES['archivo']['tmp_name'],'attachmet/' . $_FILES['archivo']['name']);               
                $queryResult = $pdo->query("INSERT INTO Intranet.msj_ticket (IDTicket,mensaje,IDUsuario,fecha,ligafile) VALUES ($lastId,'$_POST[rep]',$_POST[emp],'$hoy','$file')");
                $to="sistemas@credicor.com.mx";
                $name="Intranet Credicor Mexicano";
                $subject="NUEVO REPORTE CON FOLIO ".$folio;
                $message=$_POST[rep]." ATTE : ".$nombre;
                $from="intranet@credicor.com.mx";
                require('correo.php');
                $queryResult = $pdo->query("SELECT B.email from sibware.personal A INNER JOIN sibware.usuarios B on A.IDUsuario=B.ID where A.ID=$id_personal");
                while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                    $to=$row['email'];
                }
                
                $subject="NUEVO REPORTE REGISTRADO CON FOLIO ".$folio;
                $message="Gracias por registrar la incidencia, se está revisando y será atendido a la brevedad en un lapso no mayor a 24 Hrs dependiendo de su Grado de Prioridad y el trabajo del área de TI…Saludos y Gracias! Buen día 😊";
                require('correo.php');
                echo "<div class='alert alert-success'>";
                echo "    <strong>Exito!</strong>La Incidencia ha sido Registrada con Exito!";
                echo "</div>";
                
            }
           
    }
?>  
<h3>Agregar Incidencia</h3>  
<form action="ticketadmin.php" method="post"  enctype="multipart/form-data">
<div class="row">
  <div class="col-xs-4">
    <label for="emp">Usuario</label>
    <select name="emp" id="emp" class="form-control" required="true">
    <?PHP $queryResult = $pdo->query("SELECT A.ID,CONCAT(A.Nombre,' ',A.Apellido1,' ',A.Apellido2) as usuario FROM sibware.personal A WHERE A.`status`='S'"); ?>
        <option value="">Selecione usuario...</option>
        <?PHP
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                if ($row['ID']==$id_personal) {
                    echo "<option selected='selected' value='".$row['ID']."'>".$row['usuario']."</option>";
                }else{
                    echo "<option value='".$row['ID']."'>".$row['usuario']."</option>";
                }
                
            }
        ?>
    </select>
  </div>
  <div class="col-xs-4">
    <label for="suc">Sucursal</label>
    <select name="suc" id="suc" class="form-control" required="true">
    <?PHP $queryResult = $pdo->query("SELECT * FROM sibware.sucursal") ?>
        <option value="">Selecione Sucursal...</option>
        <?PHP
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='".$row['ID']."'>".$row['Nombre']."</option>";
            }
        ?>
    </select>
  </div>
  <div class="col-xs-4">
    <label for="cat">Categoria</label>
    <select name="cat" id="cat" class="form-control" required="true">
    <?PHP $queryResult = $pdo->query("SELECT * FROM Intranet.r_macroproceso C WHERE C.lactivo='S'  and C.lmostrar='S'") ?>
        <option value="">Selecione Categoria...</option>
        <?PHP
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='".$row['ID']."'>".$row['macroproceso']."</option>";
            }
        ?>    
    </select>
  </div>
</div> 
<div class="row">
  <div class="col-xs-2">
    <label for="nivel">Nivel de Prioridad</label>
    <select name="nivel" id="nivel" class="form-control" required="true">
    <?PHP $queryResult = $pdo->query("SELECT * FROM Intranet.nivel_ticket"); ?>
        <option value="">Nivel...</option>
        <?PHP
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='".$row['ID']."'>".$row['Nivel']."</option>";
            }
        ?>
    </select>
  </div>
  <div class="col-xs-10">
    <label for="asunto">Asunto</label>
    <input type="text" name="asunto" id="asunto" class="form-control" required="true" placeholder="Titulo del reporte">
  </div>
</div> 
<div class="row">
    <div class="col-xs-12">
    <label for="rep">Descripcion de Falla</label>  
    <textarea name="rep" id="rep" cols="30" rows="10" class="form-control" required="true" placeholder="Describa detalladamente la falla" ></textarea> 
    </div>
</div>
<div class="row">
    <div class="col-xs-5">
    <label for="archivo">Adjunte alguna imagen(menor a 1MB)</label>
    <input type="file" name="archivo" id="archivo" accept="image/jpg" class="form-control"></input>
    
    </div>
    <div class="col-xs-2">
        <br></b><input type="reset" value="Restablecer" class="button">
    </div>
    <div class="col-xs-2">
        <br><input type="submit" value="Guardar" class="button">
    </div>
    <div class="col-xs-2">
        <br><a href="tickets.php" class="button">Regresar</a>
    </div>
<div>
</form>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
