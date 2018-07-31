<?php
    require_once 'header.php';
    //////inicio de contenido
    $idsol=$_GET['id'];
?> 
<h3> Relacion de Articulos de Papeleria</h3><a href='papeleria.php' class="button" >Regresar</a>
<table class="table" >
<tr><th>Fecha</th><th>Nombre</th><th>Departamento</th><th>Cantidad</th><th>Articulo</th><th>Clave</th><th>Estatus</th></tr>
<?php
$queryResult = $pdo->query("SELECT
A.ID,
B.fecha,
CONCAT(C.Nombre,' ',C.Apellido1,' ',C.Apellido2) as Personal,
D.Nombre,
A.cant,
A.articulo,
A.clave,
A.status
FROM
Intranet.articulo_papeleria A
INNER JOIN Intranet.sol_papeleria B ON A.llave = B.llave
INNER JOIN sibware.personal C on B.id_personal=C.ID
INNER JOIN sibware.personal_departamentos D on C.IDDepartamento=D.ID
WHERE
B.ID = $idsol and C.ID=$id_personal
ORDER BY D.ID");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $idart=$row['ID'];
	$nombre=$row['Personal'];
	$fecha=$row['fecha'];
	$depto=$row['Nombre'];
	$cant=$row['cant'];
	$art=$row['articulo'];
	$clave=$row['clave'];
	$status=$row['status'];
	if ($status=='R') {
		echo"<tr><td>$fecha</td><td>$nombre</td><td>$depto</td><td>$cant</td><td>$art</td><td>$clave</td><td><img alt='alt' src='img/icons/alert.png'></td></tr>";
	}elseif ($status=='S') {
		echo"<tr><td>$fecha</td><td>$nombre</td><td>$depto</td><td>$cant</td><td>$art</td><td>$clave</td><td><img alt='alt' src='img/icons/icon_ok.png'></td></tr>";
	}elseif ($status=='P') {
		echo"<tr><td>$fecha</td><td>$nombre</td><td>$depto</td><td>$cant</td><td>$art</td><td>$clave</td><td><img alt='alt' src='img/icons/pend.png'></td></tr>";
	}elseif ($status=='E') {
		echo"<tr><td>$fecha</td><td>$nombre</td><td>$depto</td><td>$cant</td><td>$art</td><td>$clave</td><td><img alt='alt' src='img/icons/icon_ok.png'></td></tr>";
	}
}

?>  
</table>    
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
