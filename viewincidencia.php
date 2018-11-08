<?php
require_once 'headerbi.php';
require 'menubi.php';
switch ($_GET['b']) {
    case 'a':
       $band='A';
        break;
    case 'p':
        $band='P';
         break;
    case 'c':
         $band='C';
          break;
    case 'r':
          $band='R';
           break;
         
    default:
        $band='N';
        break;
}
if (empty($_GET['fil'])) {
    $fini='2018-01-01';
    $ffin='2018-12-31';
}else{
    $queryResult=$pdo->query("SELECT * from Intranet.filtros_bi where valor=$_GET[fil]");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $ffin=$row['ffin'];
                $fini=$row['fini'];
                $texto=$row['texto'];
            }
}
if ($band<>'R') {
    $queryResult=$pdo->query("SELECT * from Intranet.ticket A where A.fecha_alta BETWEEN '$fini' and '$ffin' AND Estatus='$band'");

}elseif ($band=='R') {
    $queryResult=$pdo->query("SELECT
    *
FROM
    Intranet.ticket A
INNER JOIN Intranet.msj_ticket B ON A.ID_Ticket = B.IDTicket
WHERE
    (
        A.fecha_alta BETWEEN '$fini'
        AND '$ffin'
    )
AND B.IDUsuario = $idcontraloria
AND A.ID_Usuario<>$idcontraloria");# code...

}

?> 
<h3>Relacion de Incidencias</h3>
<div class="col-xs-2">   
    <a href="incidenciasbi.php" class="button">Regresar</a>
</div>
<div class="col-xs-2">
    <input type="button" name="imprimir" value="Imprimir"  onClick="window.print();" class="button" />
</div>
<table class="table">
<tr><th>Folio</th><th>Nombre</th><th>Fecha</th><th>Incidencia</th><th>Estatus</th></tr>
<?php
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
        
        echo "<tr><td><a href='viewincidencia2.php?idtic=".$row['ID_Ticket']."'>".$row['folio']."</a></td><td>".$row['Empleado']."</td><td>".$row['fecha_alta']."</td><td>".$row['Titulo']."</td><td>".$status."</td><td></tr>"; 
  }
?>
</table>         
<?php
    /////fin de contenido
    require_once 'footer.php';
?>