<?php
    require_once 'header.php';
    //////inicio de contenido
    $hoy=date('Y-m-d');
if (!empty($_POST['subir'])) {
  if ($_FILES['archivo']["error"] > 0)
  {
    echo "Error: " . $_FILES['archivo']['error'] . "<br>";

  }
  else
  {
   
    $file=$_FILES['archivo']['name'];
    $file2="mailing.jpg";
    move_uploaded_file($_FILES['archivo']['tmp_name'],'attachmet/' . $file2);
    $queryResult = $pdo->prepare("INSERT INTO Intranet.imagenmail (archivo,fecha)VALUES ('$file','$hoy')");
    $queryResult->execute();    
    echo "<div class='alert alert-success'>";
    echo "    <strong>Exito! </strong> El archivo subio con exito!";
    echo "</div>";
  } 
}
if (!empty($_POST['asunto'])) {
    $name='CREDICOR';
	$subject=$_POST['asunto'];
    $message = file_get_contents('http://www.credicormexicano.com.mx/flayers/mailing.html');
    $from="intranet@credicor.com.mx";
    switch ($_POST['grupo']) {
        case 1:
            echo "Enviaste Mailing A: Inversionistas";
            $sql="SELECT
        email
    FROM
        2_prestamos A
    INNER JOIN 2_cliente B ON A.IDCliente = B.ID
    WHERE
    A.`status` = 'V'
    AND B.lEnvioAutomEmail = 'S'
    GROUP BY B.ID";  
            break;
        case 2:
            echo "Enviaste Mailing A: Acreditados";
            $sql="SELECT
        email
    FROM
        2_contratos A
    INNER JOIN 2_cliente B ON A.IDCliente = B.ID
    WHERE
        A.`status` = 'A'
    AND B.lEnvioAutomEmail = 'S'
    GROUP BY
        B.ID";  
            break;
        case 3:
            echo "Enviaste Mailing A: Arrendamientos Union";
            $sql="SELECT
        email
    FROM
        2_ap_contrato A
    INNER JOIN 2_cliente B ON A.IDCliente = B.ID
    WHERE
        A.`status` = 'A'
    AND B.lEnvioAutomEmail = 'S'
    GROUP BY
        B.ID";  
            break;
        case 4:
            echo "Enviaste Mailing A: Arrendamientos Cma"; 
            $sql="SELECT
        email
    FROM
        3_ap_contrato A
    INNER JOIN 3_cliente B ON A.IDCliente = B.ID
    WHERE
        A.`status` = 'A'
    AND B.lEnvioAutomEmail = 'S'
    GROUP BY
        B.ID";   
            break;
        case 5:
            echo "Enviaste Mailing A: Venta a Plazo";  
            $sql="SELECT
        email
    FROM
        3_vp_contrato A
    INNER JOIN 3_cliente B ON A.IDCliente = B.ID
    WHERE
        A.`status` = 'A'
    AND B.lEnvioAutomEmail = 'S'
    GROUP BY
        B.ID";    
            break;
        case 6:
            echo "Enviaste Mailing A: Empleados";  
            $sql="SELECT
        A.Email
    FROM
        sibware.usuarios A
    INNER JOIN sibware.personal B ON B.IDUsuario = A.ID
    WHERE
        B.`status` = 'S' and B.ID=31"; 
              
            break;    
    }
    $queryResult = $pdo->query($sql);
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $to=$row['Email'];
        
        include('correo.php');
        } 
    

}
?>    

  <!-- Indicators -->
  <form action="mailing.php" method="post" enctype="multipart/form-data">
  <div class="row">
    <div class="col-xs-4">
        <label for="asunto">Asunto</label><input type="text" placeholder="Asunto" required="true" name="asunto" id="asunto" class="form-control" />
    </div>
    <div class="col-xs-4">    
        <label for="grupo">Grupo</label>
        <select name="grupo" id="grupo" class="form-control" required="true">
        <option value="">Seleccione Grupo...</option>
          			<option value="1">Inversionistas</option>
          			<option value="2">Acreditados</option>
          			<option value="3">Arrendamientos CMU</option>
          			<option value="4">Arrendamientos CMA</option>
          			<option value="5">Venta Plazo</option>
          			<option value="6">Empleados</option>
        </select>
    </div>
    <div class="col-xs-2">
    <br><input type="submit"  value="Enviar" name="enviar" class="button" />
    </div>
  </div>
  <div class="row">  
    <div class="col-xs-4"> 
        <label for="archivo">Archivo de imagen</label><input type="file" name="archivo" id="archivo" accept="image/jpg" class="form-control">
    </div>  
    <div class="col-xs-2"> 
        <br><input type="submit" value="Subir archivo" name="subir" class="button">
    </div>
  </div>  
  </form>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
