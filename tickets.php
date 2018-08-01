<?php
    require_once 'header.php';
    if (!empty($_POST['tic'])) {
        $queryResult = $pdo->query("SELECT A.ID_Ticket, CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as Empleado, A.folio,A.fecha_alta,A.Estatus,A.Titulo FROM Intranet.ticket A INNER JOIN sibware.personal B ON A.ID_Usuario=B.ID  WHERE A.folio=$_POST[tic] ");
    }elseif (!empty($_GET['idtic'])) {
        $queryResult = $pdo->query("SELECT A.ID_Ticket, CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as Empleado, A.folio,A.fecha_alta,A.Estatus,A.Titulo FROM Intranet.ticket A INNER JOIN sibware.personal B ON A.ID_Usuario=B.ID  WHERE A.ID_Ticket=$_GET[idtic] ");
    }elseif(!empty($_GET['band'])) {
        $queryResult = $pdo->query("SELECT A.ID_Ticket, CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as Empleado, A.folio,A.fecha_alta,A.Estatus,A.Titulo FROM Intranet.ticket A INNER JOIN sibware.personal B ON A.ID_Usuario=B.ID  WHERE (A.Estatus='A' OR A.Estatus='P') ");
    }else{
        $queryResult = $pdo->query("SELECT A.ID_Ticket, CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as Empleado, A.folio,A.fecha_alta,A.Estatus,A.Titulo FROM Intranet.ticket A INNER JOIN sibware.personal B ON A.ID_Usuario=B.ID  WHERE A.ID_Usuario=$id_personal ");
    } 
    
    
   
    //////inicio de contenido
?>    
<form action="tickets.php" method="post">
<div class="row">
  <div class="col-xs-4">
    <label for="tic">Numero de Folio</label><input type="text" name="tic" id="tic" class="form-control" value="" placeholder="Folio a Buscar" required="true">
  </div>
  <div clas="col-xs-2">
    <br><input type="submit" value="Buscar" class="button">  
  </div>
</div>  
</form>
    <h3>Relacion de Incidencias</h3><a href="tickets.php" class="button">Restablecer</a><a href="ticketadmin.php" class="button">Agregar Incidencia</a>
    <?PHP
        if ($_SESSION['IDDepartamento']==6||$_SESSION['IDDepartamento']==10) {
            echo "<a href='tickets.php?band=xcxcfdtrybcrr!' class='button'>Administrar</a>";
        }
        
    ?>
    <table class="table">
    <tr><th>Folio</th><th>Nombre</th><th>Fecha</th><th>Incidencia</th><th>Estatus</th><th>Acciones</th></tr>
    <?PHP
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        if ($row['Estatus']=='A') {
            $status="Abierto";        
        } elseif($row['Estatus']=='C') {
            $status="Cerrado";
        }elseif($row['Estatus']=='S') {
            $status="Pendiente";
        }elseif($row['Estatus']=='P') {
            $status="Proceso";
        }
            
            echo "<tr><td><a href='tickets.php?idtic=".$row['ID_Ticket']."'>".$row['folio']."</a></td><td>".$row['Empleado']."</td><td>".$row['fecha_alta']."</td><td>".$row['Titulo']."</td><td>".$status."</td><td><a href='tickets.php?idtic=".$row['ID_Ticket']."'><img src='img/icons/review.png'></a>";
           if ($_SESSION['IDDepartamento']==6||$_SESSION['IDDepartamento']==10) {
               echo "<a href='tickets.php?idtic=".$row['ID_Ticket']."'><img src='img/icons/support.png'></a>";
           }
            echo "</td></tr>";
        }

     ?>

    </table>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
