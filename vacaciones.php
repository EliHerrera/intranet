<?php
    require_once 'header.php';
    if(!empty($_POST)){
        $desde=$_POST['desde'];
        $hasta=$_POST['hasta'];
        $diasrest=$_POST['restantes'];
        $desde1 = new DateTime($desde);
        $hasta1 = new DateTime($hasta);
        $diff = $desde1->diff($hasta1);
        $diassol=$diff->days;
        $diassol++;
        $idemp=$_POST['personalbk'];
        $comodin= date( "Y-m-d", strtotime($desde)  );
        
        for ($j=0; $j < $diassol; $j++) { 
            $comodin2=date( "Y-m-d", strtotime( "$comodin +$j day" )	);	
            
            $queryResult = $pdo->query("select sibware.2_EsDiaHabil('$comodin2') as habil");
            
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) { 
                $habil=$row['habil'];	}
            if ($habil==0) {
                $cont=$cont+1;

            } 			
            
        }
        
        $diassol=$diassol-$cont;
        if ($diassol==0) {
            echo "<div class='alert alert-info'>";
            echo "    <strong>Informacion!</strong> Los dias solicitados no pueden ser iguales a 0.";
            echo "</div> ";
        }elseif ($diassol>$diasrest) {
            echo "<div class='alert alert-info'>";
            echo "    <strong>Informacion!</strong> Los dias solicitados no pueden ser mayores a los dias restantes.";
            echo "</div> ";
        }elseif ($diassol<=$diasrest) {
            $queryResult = $pdo->query("INSERT INTO Intranet.vac_periodos(
                periodo,
                dias,
                IDEmpleado,
                STATUS,
                fechaini,
                fechafin,
                IDBackup
            )
            VALUES
                (
                    $_POST[periodo],
                    $diassol,
                    $id_personal,
                    'P',
                    '$desde',
                    '$hasta',
                    $idemp)");
            echo "<div class='alert alert-success'>";
            echo "    <strong>Exito!</strong> Se guardo la solicitud con Exito por ".$diassol." dias";
            echo "</div>";
        }           
        
    }
    if (!empty($_GET['id'])) {
        $queryResult = $pdo->query("DELETE FROM Intranet.vac_periodos WHERE ID=$_GET[id] AND IDEmpleado=$id_personal");
        echo "<div class='alert alert-danger'>";
        echo "<strong>Informacion!</strong> ha eliminado una Solicitud de Vacaciones.";
        echo "</div>";
    }
    if ($aniohoybis==0) {
        $ahoy=365;
    } else {
        $ahoy=366;
    }
    $queryResult = $pdo->query("SELECT
	CONCAT(
		A.Nombre,
		' ',
		A.Apellido1,
		' ',
		A.Apellido2
	) AS Personal,
	A.FIngreso,
	month(A.FIngreso) as mesing
FROM
	sibware.personal A
WHERE
	ID = $id_personal
AND STATUS = 'S'");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $personal=$row['Personal'];
	$fechaingreso=$row['FIngreso'];	
	$mesing=$row['mesing'];
}

$date1 = new DateTime($hoy);
$date2 = new DateTime($fechaingreso);
$diff = $date1->diff($date2);
$diastrans=$diff->days;
$periodo=$diastrans/$ahoy;
$periodo=floor($periodo);
$periodotop=$periodo+1;
$periodotop=$periodotop." year ";
$fechamax = strtotime ( $periodotop , strtotime ($fechaingreso ) ) ;
$fechamax = date ( 'Y-m-d' ,$fechamax ); 
$queryResult = $pdo->query("SELECT A.dias FROM Intranet.vac_parametros A where A.periodos=$periodo");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $diasco1=$row['dias'];
}
$queryResult = $pdo->query("SELECT * from Intranet.vac_especial A where A.IDPersonal=$id_personal");  
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $diasco2=$row['dias'];
}
if ($diasco2>=1) {
    $diasco=$diasco2;
}else{
    $diasco=$diasco1;
}
$queryResult = $pdo->query("SELECT
	IFNULL(SUM(A.dias), 0) AS dias
FROM
	Intranet.vac_periodos A
WHERE
	A.Periodo = $periodo
AND A.IDEmpleado = $id_personal AND (A.status='S' or A.status='P')");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
	$diasaut=$row['dias'];
}
$diasrest=$diasco-$diasaut;

//////inicio de contenido
?>  
<h3>Control de Vacaciones</h3> 
<form action="vacaciones.php" method="post" >
<div class="row">
  <div class="col-xs-4">
    <label for="emp">Nombre</label><input type="text" name="emp" id="emp" readonly class="form-control" value="<?php echo $personal ?>">
  </div>
  <div class="col-xs-2">
    <label for="periodo">Periodo</label><input type="number" class="form-control" readonly name=periodo id="periodo" value="<?php echo $periodo ?>">
  </div>
  <div class="col-xs-2">
    <label for="diasco">Dias Correspond.</label><input type="number" class="form-control" readonly name=diasco id="diaco" value="<?php echo $diasco ?>">
  </div>
  
  <div class="col-xs-2">
    <label for="diasau">Dias Autorizados.</label><input type="number" class="form-control" readonly name=diasau id="diasau" value="<?php echo $diasaut ?>">
  </div>
  <div class="col-xs-2">
    <label for="restantes">Dias Restantes</label><input type="number" class="form-control" readonly name=restantes id="restantes" value="<?php echo $diasrest ?>">
  </div>
  <div class="col-xs-3">
    <label for="desde">Desde</label><input type="date" class="form-control" name=desde id="desde" value="" min="<?PHP echo $hoy ?>" max="<?PHP echo $fechamax ?>" required="true">
  </div>
  <div class="col-xs-3">
    <label for="hasta">Hasta</label><input type="date" class="form-control" name=hasta id="hasta" value="" min="<?PHP echo $hoy ?>" max="<?PHP echo $fechamax ?>" required="true">
  </div>
  <!-- <div class="col-xs-2">
    <label for="diassol">Dias Solicitados.</label><input type="number" class="form-control" name=diassol id="diassol" value="<?php echo ""; ?>" min="1" max="<?php echo $diasrest ?>" required="true">
  </div> -->
  <div class="col-xs-4">
    <label for="personalbk">Personal BackUp</label><select class="form-control" name="personalbk" id="personalbk" required="true" >
        <option value="">Selecione su BackUp...</option>
        <?PHP
            $queryResult = $pdo->query("SELECT A.ID,CONCAT(A.Nombre,' ',A.Apellido1,' ',A.Apellido2) as empleado FROM sibware.personal A WHERE A.`status`='S'");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $id_emp=$row['ID'];
		        $nombre=$row['empleado'];
		         if($id_emp==$idemp){echo "<option selected='selected' value=".$id_emp.">".$nombre."</option>";}
		        echo "<option value=".$id_emp.">".$nombre."</option>";
            }

        ?>
    </select>
  </div>
  <div class="col-xs-2">
    <br><input type="submit" name="guardar" id="guardar" value="Solicitar" class="button">
  </div>  
</div>
</form>
 
<h3>Relacion de vacaciones</h3>

<table class="table">
<tr><th>Dias</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Estatus</th><th>Acciones</th></tr>
<?php

 $queryResult = $pdo->query("SELECT * from Intranet.vac_periodos A WHERE A.IDEmpleado=$id_personal and A.periodo=$periodo  ");
 while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $idtrel=$row['ID'];
	$diasrel=$row['dias'];
	$fechainirel=$row['fechaini'];
	$fechafinrel=$row['fechafin'];
	$statusrel=$row['status'];
	if ($statusrel=='P') {
		$statusrel='Pendiente';
		echo"<tr><td>$diasrel</td><td>$fechainirel</td><td>$fechafinrel</td><td>$statusrel</td><td><a href='formatovac.php?id=$idtrel' target='_blank'><img alt='alt' src='img/icons/print.png'></a><a href='vacaciones.php?id=$idtrel' ><img alt='alt' src='img/icons/delete.png'></a></td></tr>";
	}elseif ($statusrel=='S') {
		$statusrel='Autorizada';
		echo"<tr><td>$diasrel</td><td>$fechainirel</td><td>$fechafinrel</td><td>$statusrel</td><td><a href='#'><img alt='alt' src='img/icons/icon_ok.png'></a></td></tr>";
	}
 }

?>
</table>

<?php
    /////fin de contenido
    require_once 'footer.php';
?>
