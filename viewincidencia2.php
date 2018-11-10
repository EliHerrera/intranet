<?php
require_once 'headerbi.php';
require 'menubi.php';
if (!empty($_GET['idtic'])) {
    $idtic=$_GET['idtic'];
}    
    $queryResult = $pdo->query("SELECT
    C.folio,
    CONCAT(
        B.Nombre,' ',
        B.Apellido1,' ',
        B.Apellido2
    ) AS Usuario,
    A.mensaje,
    A.fecha,
    A.ligafile
FROM
    Intranet.msj_ticket A
INNER JOIN sibware.personal B ON A.IDUsuario = B.ID
INNER JOIN Intranet.ticket C ON A.IDTicket = C.ID_Ticket
WHERE
    IDTicket=$idtic ");
  
?>  
<h3>Registro de Acciones</h3>
<div class="col-xs-2">   
    <a href="incidenciasbi.php" class="button">Regresar</a>
</div>
<div class="col-xs-2">
    <input type="button" name="imprimir" value="Imprimir"  onClick="window.print();" class="button" />
</div>  
<table class="table">
<tr><th>Folio</th><th>Fecha</th><th>Reporte</th><th>Usuario</th><th>Imagen</th></tr>
<?PHP
 while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
     echo "<tr><td>".$row['folio']."</td><td>".$row['fecha']."</td><td>".$row['mensaje']."</td><td>".$row['Usuario']."</td><td>";
     if ($row['ligafile']<>"") {
         echo "<a href='attachmet/".$row['ligafile']."' target='_blank' ><img src='img/icons/imagen.png' alt=''></a></td>";
     }
     
    echo "</tr>";
    $folio=$row['folio'];
 }
?>

</table>
