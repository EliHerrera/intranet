<?php
    require_once 'header.php';
    //////inicio de contenido
?>

<form action="directorio.php" method="post" >

    <label for="fname" class="col-sm-2 col-form-label">Buscar</label>
    
        <input type="text" name="fname" id='fname' placeholder="Nombre a buscar" class="form-control-plaintext"><input type="submit" value="Buscar" class="button"  >  </form>
    

</form>    
<table class="table">
<td colspan='7'><h3>Directorio Interno Credicor Mexicano</h3></a></td></tr>
<tr><th>Usuario</th>
<th>Departamento</th>
<th>Sucursal</th>
<th>Telefono</th>
<th>Extension</th>
<th>Correo</th>
</tr>
<?php
if (!empty($_POST)) {
    $queryResult=$pdo->query("SELECT
A.ID,
	CONCAT(
		A.Nombre,
		' ',
		A.Apellido1,
		' ',
		A.Apellido2
	) AS Usuario,
	B.Nombre as Depto,
	C.Nombre as Sucursal,
	C.Telefono1 as Telefono,
	A.Extension,
	A.Email
FROM
	sibware.personal A
INNER JOIN sibware.personal_departamentos B on A.IDDepartamento = B.ID INNER JOIN sibware.sucursal C ON A.IDSucursal = C.ID where  NOT ISNULL (A.Extension) AND A.`status` = 'S' AND (A.Nombre LIKE '$_POST[fname]'OR A.Apellido1 LIKE '$_POST[fname]' OR A.Apellido2 LIKE '$_POST[fname]') ORDER BY B.Nombre,Usuario,C.Nombre ");
}else{
$queryResult=$pdo->query("SELECT
A.ID,
	CONCAT(
		A.Nombre,
		' ',
		A.Apellido1,
		' ',
		A.Apellido2
	) AS Usuario,
	B.Nombre as Depto,
	C.Nombre as Sucursal,
	C.Telefono1 as Telefono,
	A.Extension,
	A.Email
FROM
	sibware.personal A
INNER JOIN sibware.personal_departamentos B on A.IDDepartamento = B.ID INNER JOIN sibware.sucursal C ON A.IDSucursal = C.ID where  NOT ISNULL (A.Extension) AND A.`status` = 'S' ORDER BY B.Nombre,Usuario,C.Nombre ");
}

      
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $id= $row['ID'];
        $usuario=$row['Usuario'];
        $depto=$row['Depto'];
        $suc=$row['Sucursal'];
        $tel=$row['Telefono'];
        $ext=$row['Extension'];
        $email=$row['Email'];
        
                 echo "  
                         <tr><td>$usuario</td>
                        <td>$depto</td>
                        <td>$suc</td>
                        <td>$tel</td>
                        <td>$ext</td>
                        <td>$email</td>
                        
                       ";
     	 }
    	 	
?>	
</table>
<?php    
    /////fin de contenido
    require_once 'footer.php';
?>
