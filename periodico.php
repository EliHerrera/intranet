<?php
    require_once 'header.php';
    if (!empty($_POST['fechab'])) {
        $hoy=$_POST['fechab'];
    }
    if (!empty($_POST['subir'])) {
        if ($_FILES['att']["error"] > 0)
        {
            echo "Error: " . $_FILES['archivo']['error'] . "<br>";
            echo "<div class='alert alert-danger'>";
            echo "    <strong>Error!</strong>El archivo no cumple con las caracteritiscas permitidas!";
            echo "</div>";

        }else{
            
            
            $file=$_FILES['archivo']['name'];
            move_uploaded_file($_FILES['archivo']['tmp_name'],'attachmet/' . $_FILES['archivo']['name']);               
            $queryResult = $pdo->query("INSERT INTO Intranet.periodico (archivo,fecha)VALUES ('$file','$hoy')");
            echo "<div class='alert alert-success'>";
            echo "    <strong>Exito!</strong>La Archivo ha subido con Exito!";
            echo "</div>";
        }
    }    
    //////inicio de contenido
?>
<h3>Periodico Financiero</h3>
<?PHP  if ($_SESSION['IDDepartamento']==6||$_SESSION['IDDepartamento']==10) { ?>
<form action="periodico.php" method="post" enctype="multipart/form-data">
<div class="row">
  <div class="col-xs-4">
            <input type="file" name="archivo" id="archivo"  class="form-control" ></input>
  </div> 
  <div class="col-xs-2">     
            <input type="submit" value="Subir archivo" name="subir" class="button"></input>
  </div>          
  <div class="col-xs-2">           
            <input type="submit" value="Enviar Periodico" name="periodico" class="button"></input>
  </div>          

</div>
</form>
<?PHP } ?>
<form action="periodico.php" method="POST" enctype="multipart/form-data">
<div class="row">
  <div class="col-xs-4">
      <input type="date" name="fechab" id="fechab" class="form-control" required="true">
  </div>
  <div class="col-xs-2">    
      <input type="submit" value="Buscar" class="button">
  </div>    
 </form>
<table class="table"> 
    <tr><td>Archivo</td><td>Fecha</td></tr>
    <?php
    
        $queryResult = $pdo->query("SELECT * FROM Intranet.periodico where fecha='$hoy'");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td><a href='attachmet/".$row['archivo']."' target='_blank'>".$row['archivo']."</a></td><td>".$row['fecha']."</td></tr>";
        }
    ?>


</table>    

<?php
    /////fin de contenido
    require_once 'footer.php';
?>
