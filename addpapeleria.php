<?php
    require_once 'header.php';
    
    function generarllave($longitud) {
        $key = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
        return $key;
   }
   
   if(!empty($_GET['idart'])){
    $queryResult = $pdo->query("DELETE FROM Intranet.articulo_papeleria WHERE ID=$_GET[idart]");   
    echo "<div class='alert alert-danger'>";
        echo "<strong>Informacion!</strong> ha eliminado el articulo seleccionado!.";
    echo "</div>";
        
        $id_emp=$_GET['id_emp'];
   }
   if (isset($_REQUEST['agregar']))  {
    $queryResult = $pdo->query("INSERT INTO Intranet.articulo_papeleria(
        IDPersonal,
        llave,
        cant,
        articulo,
        clave,
        status
        
    )
    VALUES
        (
            $_POST[emp],
            '$_SESSION[llave]',
            $_POST[cant],
            '$_POST[articulo]',
            '$_POST[clave]',
            'A')"); 
    echo "<div class='alert alert-info'>";
    echo "    <strong>Informacion!</strong> Articulo Insertado.";
    echo "</div> ";          
   }
   if (isset($_REQUEST['guardar']))  {

	$queryResult = $pdo->query("INSERT INTO Intranet.sol_papeleria(
	fecha,
	id_personal,
	llave,
	status
	
    )
    VALUES
	(
		'$hoy',
		$_POST[emp],
		'$_SESSION[llave]',
        'A')");
        $id_emp=0;
        unset($_SESSION["llave"]);
        echo "<div class='alert alert-success'>";
        echo "    <strong>Exito!</strong> Se guardo la solicitud con Exito.";
        echo "</div>";
   }
   if (!empty($_POST['emp'])) {
	    $id_emp=$_POST['emp'];
	    $cant=$_POST['cant'];
	    $articulo=$_POST['articulo'];
        $clave=$_POST['clave'];
        

	    if (empty($_SESSION['llave'])) {
            $llave=generarllave(32);            
            $_SESSION['llave']=$llave;
            
	    }
        $llave=$_SESSION['llave'];
        $queryResult = $pdo->query("SELECT
	        A.ID,
	        A.Nombre AS depto,
            CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as responsable
        FROM
	        sibware.personal_departamentos A
        INNER JOIN sibware.personal B ON B.IDDepartamento = A.ID
        WHERE
            B.id = $id_emp");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $depto=$row['depto'];
            $responsable=$row['responsable'];
        }    
    }
    //////inicio de contenido
?>    
    <?php echo "<h3>Responsable : ".$responsable." Area : ".$depto."</h3>"; ?>
    <form action="addpapeleria.php" method="post">
    <select name="emp" onchange="this.form.submit();return false;" required>
    <?php
        $queryResult = $pdo->query("SELECT A.ID,CONCAT(A.Nombre,' ',A.Apellido1,' ',A.Apellido2) as empleado FROM sibware.personal A WHERE A.`status`='S'");
    ?>
    
    <option value="">Seleccione Nombre...</option>
        <?php   
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $id=$row['ID'];
		        $nombre=$row['empleado'];
		        if($id_emp==$id){echo "<option selected='selected' value=".$id.">".$nombre."</option>";}
		        echo "<option value=".$id.">".$nombre."</option>";
            }
        ?>
    </select>
    
    <table class="table">
    <tr><th><label for="cant">Cantidad</label> </th><th><label for="articulo">Articulo</label> </th><th><label for="clave">Clave</label> </th><th><input type="text" name="keyw" value="<?php echo $_SESSION['llave'] ?> " id="keyw" hidden="true" ></th><td><a href='papeleria.php'><img alt='alt' src='img/icons/arrow-left.png'></a></td></tr>
    <tr><td><input type="number" name="cant" value="" required id="cant" min="1" ></td><td><input type="text" name="articulo" value="" required="true" placeholder="Escriba aqui Descripcion" id="articulo"></td><td><input type="text" name="clave" value="" id="clave" required="true" placeholder="Escriba aqui Clave SKU"></td><td><input type="submit" name="agregar" value="Agregar" class="button"></td></tr>
    </form>
    <tr><th colspan="4">Relacion de Articulos</th></tr>
    <tr><th>Reg.</th><th>Cant</th><th>Articulo</th><th>Clave</th><th>Eliminar</th></tr>
    <?php
    if(!empty($id_emp)){
        $queryResult = $pdo->query("SELECT A.ID as IDart,A.cant, A.articulo, A.clave, A.llave from Intranet.articulo_papeleria A where A.llave='$_SESSION[llave]' AND IDPersonal=$id_emp");
        
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $idart=$row['IDart'];
            $cant2=$row['cant'];
	        $articulo2=$row['articulo'];
	        $clave2=$row['clave'];
	        $reng++;
	        echo "<tr><td>$reng</td><td>$cant2</td><td>$articulo2</td><td>$clave2</td><td><a href='addpapeleria.php?idart=$idart&&id_emp=$id_emp'><img src='img/icons/delete.png'></a></td></tr>";	
        }
    }
    ?>
    </table>
    <form action="addpapeleria.php" method="post">
    <?php
    if ($reng>=1) {
        echo "<input type='text' id='emp' name='emp' value='$id_emp' hidden='true'> ";
        echo "<input type='submit' name='guardar' value='Guardar' class='button'>";# code...
    }
    
    ?>
    </form>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
