<?php
    require_once 'header.php';
    //////inicio de contenido
?>  
<h3>Relacion de Resultados de PLD</h3>
<table class="table">
<tr><th>Nombre</th><th>Calificacion</th><th>Periodo</th><th>Accion</th></tr>
<?PHP
    $queryResult = $pdo->query("SELECT B.codigo,CONCAT(C.Nombre,' ',C.Apellido1,' ',C.Apellido2) as Emp ,A.Calf, A.lActivo,A.ID, A.llave, A.IDPersonal,A.periodo from Intranet.RelQst A INNER JOIN Intranet.PLD_Qst B on A.IDQst=B.ID INNER JOIN sibware.personal C on A.IDPersonal=C.ID WHERE A.IDPersonal=$idpersonal");
    while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $idemp=$row['IDPersonal'];
        $yy=$row['periodo'];
        $fila++;
        $calf=$row['Calf'];
        
        $act=$row['lActivo'];
        if ($act=='S') {
            $activo='Activado';
            $bandA=1;
        }elseif ($act=='N') {
            $activo='Desactivado';
            $bandA=0;
        }else{
            $activo='Desactivado';
            $bandA=0;
        }
        if ($row['Calf']>=$puntopase) {
            $aprobo="SI";
        }elseif ($row['Calf']<$puntopase) {
            $aprobo="NO";
        }
        
        $idrel=$row['ID'];
        echo "<tr><td>".$row['Emp']."</td><td>".$row['Calf']."</td><td>".$yy."</td>";
        if (!empty($calf)) {
            echo "<td><a href='imprimirpld.php?idemp=".$idemp."&periodo=".$yy."' target='_blank'>".Imprimir."</a></td>";
        }else
        {
            echo "<td></td>";
        }       
        echo "</tr>";
    }
?>
</table>

<?php
    /////fin de contenido
    require_once 'footer.php';
?>