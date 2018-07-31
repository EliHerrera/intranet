<?php
    require_once 'header.php';
    
    if (isset($_REQUEST['surtir']))  {

        if (!empty($_POST['checkbox'])) {
            
            $checkboxresult=$_POST['checkbox'];
            for ($i=0; $i < sizeof($checkboxresult) ; $i++) { 
            $queryResult = $pdo->query("UPDATE Intranet.articulo_papeleria A
             SET A.status='E' WHERE A.ID=$checkboxresult[$i]");
             $queryResult1=$pdo->query("SELECT llave FROM Intranet.articulo_papeleria WHERE id=$checkboxresult[$i] ");
             while ($row=$queryResult1->fetch(PDO::FETCH_ASSOC)) {
                 $queryResult2=$pdo->query("UPDATE Intranet.sol_papeleria A SET A.status='E' WHERE A.llave='$row[llave]'");
             }
            }
            echo "<div class='alert alert-success'>";
            echo "    <strong>Exito!</strong> Se procesaron los articulos Exito.";
            echo "</div>";    
        }
    }        
?>    


<form action="surtirpapeleria.php" method="POST">
<div class="row">
  <div class="col-xs-4">
    <label for="emp">Buscar por : </label><input type="text" name="emp" id="emp" placeholder="Nombre a buscar" class="form-control">
  </div>
  <div class="col-xs-4">
    <br><input type="submit" name="buscar" class="button" value="buscar">  <p>NOTA : Solo seran procesadas las casillas seleccionadas</p>
  </div>
</div>    
<h3>Articulos Pendientes por Entregar</h3><a href='apppapeleria.php' class="button" >Regresar</a><input type="submit" name="surtir" class="button" value="Entregar"> 
<table class="table">
<tr><th>Fecha</th><th>Nombre</th><th>Departamento</th><th>Cantidad</th><th>Articulo</th><th>Clave</th><th>Autorizar</th></tr>

<?php
if(isset($_REQUEST['buscar'])){
    $queryResult = $pdo->query("SELECT
A.ID,
B.fecha,
CONCAT(C.Nombre,' ',C.Apellido1,' ',C.Apellido2) as Personal,
D.nombre,
A.cant,
A.articulo,
A.clave
FROM
Intranet.articulo_papeleria A
INNER JOIN Intranet.sol_papeleria B ON A.llave = B.llave
INNER JOIN sibware.personal C on B.id_personal=C.ID
INNER JOIN sibware.personal_departamentos D on C.IDDepartamento=D.ID
WHERE
A.`status` = 'S'
and (C.Nombre like '%$_POST[emp]%' OR  C.Apellido1 like '%$_POST[emp]%' OR  C.nombre like '%$_POST[emp]%')
ORDER BY D.ID");

}else{
    $queryResult = $pdo->query("SELECT
	A.ID,
	B.fecha,
	CONCAT(C.Nombre,' ',C.Apellido1,' ',C.Apellido2) as Personal,
	D.nombre,
	A.cant,
	A.articulo,
	A.clave
FROM
	Intranet.articulo_papeleria A
INNER JOIN Intranet.sol_papeleria B ON A.llave = B.llave
INNER JOIN sibware.personal C on B.id_personal=C.ID
INNER JOIN sibware.personal_departamentos D on C.IDDepartamento=D.ID
WHERE
	A.`status` = 'S'
ORDER BY D.ID");
}
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $idart=$row['ID'];
	$nombre=$row['Personal'];
	$fecha=$row['fecha'];
	$depto=$row['nombre'];
	$cant=$row['cant'];
	$art=$row['articulo'];
	$clave=$row['clave'];
	
	echo"<tr><td>$fecha</td><td>$nombre</td><td>$depto</td><td>$cant</td><td>$art</td><td>$clave</td><td><input type='checkbox' name='checkbox[]' value='$idart'></td></tr>";

}
?>
</form>
</table>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
