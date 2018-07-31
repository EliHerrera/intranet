<?php
    require_once 'header.php';
    if (!empty($_GET['id'])) {
        if ($_GET['band']==0) {
            $queryResult = $pdo->query("DELETE FROM Intranet.vac_periodos WHERE ID=$_GET[id] ");
            echo "<div class='alert alert-danger'>";
            echo "<strong>Informacion!</strong> ha eliminado una Solicitud de Vacaciones.";
            echo "</div>";
        }elseif ($_GET['band']==1) {
            $queryResult = $pdo->query("UPDATE  Intranet.vac_periodos SET status='S' WHERE ID=$_GET[id] ");
            echo "<div class='alert alert-success'>";
            echo "    <strong>Exito!</strong>La solicitud ha sido Autorizada con Exito!";
            echo "</div>";
        }
    }
    if (!empty($_POST)) {
        $idemp=$_POST['emp'];
        $queryResult = $pdo->query("SELECT CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as empleado ,A.ID,A.dias,A.fechaini,A.fechafin,A.status from Intranet.vac_periodos A INNER JOIN sibware.personal B on A.IDEmpleado=B.ID WHERE A.IDEmpleado=$idemp AND A.fechaini>='$hoy'");
    } else {
        $queryResult = $pdo->query("SELECT CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as empleado ,A.ID,A.dias,A.fechaini,A.fechafin,A.status from Intranet.vac_periodos A INNER JOIN sibware.personal B on A.IDEmpleado=B.ID WHERE A.status='P'");# code...
    }
    //////inicio de contenido

?> 
<form action="revisavacrh.php" method="post">
<div class="col-xs-4">
    <label for="personalbk">Consultar por :</label><select class="form-control" name="emp" onchange="this.form.submit();return false;" required >
        <option value="">Selecione empleado...</option>
        <?PHP
            $queryResult1 = $pdo->query("SELECT A.ID,CONCAT(A.Nombre,' ',A.Apellido1,' ',A.Apellido2) as empleado FROM sibware.personal A WHERE A.`status`='S'");
            while ($row=$queryResult1->fetch(PDO::FETCH_ASSOC)) {
                $id_emp=$row['ID'];
		        $nombre=$row['empleado'];
		         if($id_emp==$idemp){echo "<option selected='selected' value=".$id_emp.">".$nombre."</option>";}
		        echo "<option value=".$id_emp.">".$nombre."</option>";
            }

        ?>
    </select>
</div>    
</form>   
<br><h3>Relacion de vacaciones</h3>
<table class="table">
<tr><th>Nombre</th><th>Dias</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Estatus</th><th>Acciones</th></tr>
<?php

 
 while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $empleado=$row['empleado']; 
    $idtrel=$row['ID'];
	$diasrel=$row['dias'];
	$fechainirel=$row['fechaini'];
	$fechafinrel=$row['fechafin'];
	$statusrel=$row['status'];
	if ($statusrel=='P') {
		$statusrel='Pendiente';
		echo"<tr><td>$empleado</td><td>$diasrel</td><td>$fechainirel</td><td>$fechafinrel</td><td>$statusrel</td><td><a href='revisavacrh.php?id=$idtrel&&band=1'><img alt='alt' src='img/icons/aprove.png'></a><a href='formatovac.php?id=$idtrel' target='_blank'><img alt='alt' src='img/icons/print.png'></a><a href='revisavacrh.php?id=$idtrel&&band=0' ><img alt='alt' src='img/icons/delete.png'></a></td></tr>";
	}elseif ($statusrel=='S') {
		$statusrel='Autorizada';
		echo"<tr><td>$empleado</td><td>$diasrel</td><td>$fechainirel</td><td>$fechafinrel</td><td>$statusrel</td><td><a href='#'><img alt='alt' src='img/icons/icon_ok.png'></a><a href='formatovac.php?id=$idtrel' target='_blank'><img alt='alt' src='img/icons/print.png'></a><a href='revisavacrh.php?id=$idtrel&&band=0' ><img alt='alt' src='img/icons/delete.png'></a></td></tr>";
	}
 }

?>
</table>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
