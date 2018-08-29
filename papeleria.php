<?php
    require_once 'header.php';
    //////inicio de contenido
   
    
    
?>    

<table class="table" >
<tr><td colspan="3"><h4>Relacion de Solicitudes de Papeleria</h4> </td><td>
<?PHP	
$dia=date('d');
if ($dia<=$dialimpape) {
	echo "<a href='addpapeleria.php' class='button'>Nueva Solicitud</a>";
}else{
	echo "<div class='alert alert-warning'>";
        echo "    <strong>Aviso!</strong>Solo podras registrar solicitudes los primeros ".$dialimpape." dias naturales de c/mes!";
        echo "</div>";
}
	
?>	
</td></tr>
<tr><th>Fecha</th><th>Nombre</th><th>Estatus</th><th>Acciones</th></tr>
<?php

$queryResult = $pdo->query("SELECT
	CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as Personal,
	A.fecha,
	A.status,
	A.ID
FROM
	Intranet.sol_papeleria A INNER JOIN sibware.personal B on A.id_personal=B.ID
WHERE
	A.id_personal = $id_personal");

while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
	$nombre=$row['Personal'];
	$fecha=$row['fecha'];
	$status=$row['status'];
	$idsol=$row['ID'];
	if ($status=='P') {
        $status='Pendiente';
        
		echo"<tr><td>".$fecha."</td><td>".$nombre."</td><td>".$status."</td><td><a href='viewpapeleria.php?id=".$idsol."'><img alt='alt' src='img/icons/pend.png'></a></td></tr>";

	}elseif ($status=='E') {
		$status='Entregada';
		echo"<tr><td>$fecha</td><td>$nombre</td><td>$status</td><td><img alt='alt' src='img/icons/icon_ok.png'></td></tr>";

	}elseif ($status=='R') {
		$status='Rechazada';
		echo"<tr><td>".$fecha."</td><td>".$nombre."</td><td>".$status."</td><td><a href='viewpapeleria.php?id=".$idsol."'><img alt='alt' src='img/icons/alert.png'></a></td></tr>";

	}elseif ($status=='S') {
		$status='Aprobada';
		echo"<tr><td>".$fecha."</td><td>".$nombre."</td><td>".$status."</td><td><a href='viewpapeleria.php?id=".$idsol."'><img alt='alt' src='img/icons/aprove.png'></a></td></tr>";

	}elseif ($status=='A') {
		$status='Pendiente';
		echo"<tr><td>".$fecha."</td><td>".$nombre."</td><td>".$status."</td><td><a href='viewpapeleria.php?id=".$idsol."'><img alt='alt' src='img/icons/pend.png'></a></td></tr>";

	}
}
?>
</table>

<?php
    /////fin de contenido
    require_once 'footer.php';
?>
