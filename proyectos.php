<?php
    require_once 'header.php';
    //////inicio de contenido
    $hoy = date("Y-m-d");
?>    
<h3>Relacion de Proyectos</h3><a href="addproyecto.php" class="button">Agregar Proyecto</a>
<table class="table">
    <tr><th>Num.</th><th>Proyecto</th><th>Product Owner</th><th>Area Impacto</th><th>%</th><th>Box</th><th>Fecha Final</th><th>Dias Rest.</th></tr>
    <?php
        $queryResult=$pdo->query("SELECT
        A.ID,
        A.proyecto,
        A.porcentaje,
        A.ffinal_propuesta,
        A.finicial,
        C.status,
        A.status as idstatus,
        D.Nombre,
        CONCAT(
            B.Nombre,
            ' ',
            B.Apellido1,
            ' ',
            B.Apellido2
        ) AS ownerp
    FROM
        Intranet.scr_project A
    INNER JOIN sibware.personal B ON A.id_owner = B.ID
    INNER JOIN Intranet.scr_status C ON A.`status` = C.ID
    INNER JOIN sibware.personal_departamentos D ON A.id_area_de_impacto=D.ID
    WHERE
        A. STATUS > 0");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $num++;
            $idpj=$row['ID'];
            $proyecto=$row['proyecto'];
            $ffinal=$row['ffinal_propuesta'];
            $finicial=$row['finicial'];
            $porcentaje=$row['porcentaje'];
            $status=$row['status'];
            $owner=$row['ownerp'];
            $idstatus=$row['idstatus'];
            $datetime1 = date_create($finicial);
            $datetime2 = date_create($ffinal);
            $datetime3 = date_create($hoy);
            $interval1 = date_diff($datetime1, $datetime2);
            $interval2 = date_diff($datetime3, $datetime2);
            $areaimpacto=$row['Nombre'];
            $dias1=$interval1->format('%d');
            $dias2=$interval2->format('%d');
            if($dias1==0){
                $diasp=0;
            }else{
                $diasp=($dias2/$dias1)*100;
            }
            $idalert=0;
            if ($porcentaje<=50 && $diasp<=25) {
                $idalert=3;
            }elseif($porcentaje<=60 && $diasp<=50 ){
                $idalert=2;
            }else{
                $idalert=1;
            } 
            if($idstatus==5){
                $idalert=4;
            }elseif($idstatus==3){
                $idalert=3;
            }

            $queryResult2=$pdo->query("SELECT alertas FROM Intranet.scr_alert WHERE ID=$idalert"); 
            
            while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
                $class_alert=$row['alertas'];
            }  
            echo "<tr class='".$class_alert."'><td>".$num."</td><td><a href='gestionarproyecto.php?idpj=".$idpj."'>".$proyecto."</a></td><td>".$owner."</td><td>".$areaimpacto."</td><td>".number_format($porcentaje,2)."</td><td>".$status."</td><td>".$ffinal."</td><td>".$interval2->format('%R%a días')."</td></tr>";
            
        }
    ?>

</table>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
