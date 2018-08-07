<?php
    require_once 'header.php';
    $hoy = date("Y-m-d H:i:s"); 
    if (!empty($_GET['idtic'])) {
        $idtic=$_GET['idtic'];
        $queryResult = $pdo->query("INSERT INTO Intranet.msj_ticket (IDTicket,mensaje,IDUsuario,fecha,ligafile) VALUES ($_GET[idtic],'Esta revisando este ticket!',$id_personal,'$hoy','$file')");
    }
    if (!empty($_POST)) {          
           if ($_FILES['att']["error"] > 0)
	        {
                echo "Error: " . $_FILES['archivo']['error'] . "<br>";
                echo "<div class='alert alert-danger'>";
                echo "    <strong>Error!</strong>El archivo no cumple con las caracteritiscas permitidas!";
                echo "</div>";

	        }else{
                $idtic=$_POST['idtic'];               
		        $file=$_FILES['archivo']['name'];
                move_uploaded_file($_FILES['archivo']['tmp_name'],'attachmet/' . $_FILES['archivo']['name']); 
                $queryResult = $pdo->query("INSERT INTO Intranet.msj_ticket (IDTicket,mensaje,IDUsuario,fecha,ligafile) VALUES ($_POST[idtic],'$_POST[rep]',$id_personal,'$hoy','$file')");
                echo "<div class='alert alert-success'>";
                echo "    <strong>Exito!</strong>La Incidencia ha sido Registrada con Exito!";
                echo "</div>";
            }
           
    }
    $queryResult = $pdo->query("SELECT
        C.folio,
        CONCAT(
            B.Nombre,' ',
            B.Apellido1,' ',
            B.Apellido2
        ) AS Usuario,
        A.mensaje,
        A.fecha,
        A.ligafile
    FROM
        Intranet.msj_ticket A
    INNER JOIN sibware.personal B ON A.IDUsuario = B.ID
    INNER JOIN Intranet.ticket C ON A.IDTicket = C.ID_Ticket
    WHERE
        IDTicket=$idtic ");
    
?>  
<h3>Registro de Acciones</h3>  
<table class="table">
<tr><th>Folio</th><th>Fecha</th><th>Reporte</th><th>Usuario</th><th>Imagen</th></tr>
<?PHP
     while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
         echo "<tr><td>".$row['folio']."</td><td>".$row['fecha']."</td><td>".$row['mensaje']."</td><td>".$row['Usuario']."</td><td>";
         if ($row['ligafile']<>"") {
             echo "<a href='attachmet/".$row['ligafile']."' target='_blank' ><img src='img/icons/imagen.png' alt=''></a></td>";
         }
         
        echo "</tr>";
        $folio=$row['folio'];
     }
?>

</table>
<form action="ticketadmin2.php" method="post"  enctype="multipart/form-data">
<div class="row">

    <div class="col-xs-12">
    <input type="text" name="idtic" id="idtic" value="<?php echo $idtic ?> " hidden="true">
    <label for="rep">Descripcion de Falla</label>  
    <textarea name="rep" id="rep" cols="30" rows="10" class="form-control" required="true" placeholder="Describa detalladamente la falla" ></textarea> 
    </div>
</div>
<div class="row">
    <div class="col-xs-4">
    <label for="archivo">Adjunte alguna imagen(menor a 1MB)</label>
    <input type="file" name="archivo" id="archivo" accept="image/jpg" class="form-control"></input>
    
    </div>
    <div class="col-xs-2">
        <br></b><input type="reset" value="Restablecer" class="button">
    </div>
    <div class="col-xs-2">
        <br><input type="submit" value="Responder" class="button">
    </div>
    <div class="col-xs-2">
        <br><a href="tickets.php?idtic=<?PHP echo $idtic."&&folio=".$folio ?>" class="button">Cerrar Ticket</a>
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
