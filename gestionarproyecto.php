<?php
    require_once 'header.php';
    //////inicio de contenido
    if(!empty($_GET['idpj'])){
    $queryResult=$pdo->query("SELECT A.proyecto, A.descripcion, CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as own FROM Intranet.scr_project A INNER JOIN sibware.personal B ON A.id_owner=B.ID WHERE A.ID=$_GET[idpj]");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $proyecto=$row['proyecto'];
            $desc=$row['descripcion'];
            $own=$row['own'];
            
        }
    }
?>  
<h3>Gestion de Proyectos</h3><a href="addtask.php?idpj=<?php echo $_GET['idpj'] ?>" class="button">BackLogs</a><a href="proyectos.php" class="button">Regresar</a>  
<div class="row">
    <div class="col-xs-3">
        <h5><strong>Proyecto</strong></h5>
    </div>
    <div class="col-xs-6">
        <h5><strong>Descripcion</strong></h5>
    </div>
    <div class="col-xs-3">
        <h5><strong>Product Owner</strong></h5>
    </div>
</div>
<div class="row">
    <div class="col-xs-3">
        <p><?php echo $proyecto ?></p>
    </div>
    <div class="col-xs-6">
        <p><?php echo $desc ?></p>
    </div>
    <div class="col-xs-3">
        <p><?php echo $own ?></p>            
    </div>
</div>    
   <h4>Backlogs</h4>
<table class="table">
    <tr><th>Descripcion</th><th>Asignacion</th><th>Tester</th><th>Fecha Final Propuesta</th><th>Status</th><th>Dias Rest.</th></tr>
    <?php
        $queryResult=$pdo->query("SELECT
        A.ID,
        A.ID_asignacion,
        A.descripcion,
        CONCAT(
            B.Nombre,
            ' ',
            B.Apellido1,
            ' ',
            B.Apellido2
        ) AS tester,
        A.ffinal_propuesta,
        C.STATUS,
        A.STATUS as idstatus,
        A.finicial
    FROM
        Intranet.scr_backlog A
    INNER JOIN sibware.personal B ON A.ID_tester = B.ID
    INNER JOIN Intranet.scr_status C ON A.`status` = C.ID
    WHERE
        A.ID_project = $_GET[idpj]");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $descpt=$row['descripcion'];
            $idasignacion=$row['ID_asignacion'];
            $tester=$row['tester'];
            $ffinalpt=$row['ffinal_propuesta'];
            $statust=$row['STATUS'];
            $finicial=$row['finicial'];
            $idtask=$row['ID'];
            $idstatus=$row['idstatus'];
            $datetime1 = date_create($finicial);
            $datetime2 = date_create($ffinalpt);
            $datetime3 = date_create($hoy);
            $interval1 = date_diff($datetime1, $datetime2);
            $interval2 = date_diff($datetime3, $datetime2);
            $areaimpacto=$row['Nombre'];
            $dias1=$interval1->format('%d');
            $dias2=$interval2->format('%d');
            if($dias1<=0){
                $diasp=0;
            }else{
                $diasp=($dias2/$dias1)*100;
            }
            
            $idalert=0;
            if ( $diasp<=25) {
                $idalert=3;
            }elseif($diasp<=50 ){
                $idalert=2;
            }else{
                $idalert=1;
            }
            if ($idstatus==5) {
                $idalert=1;
            }
            if ($idstatus==3 || $dias2<=0) {
                $idalert=3;
            }elseif($idstatus==5){
                $idalert=4;
               
            }    
            $queryResult1=$pdo->query("SELECT CONCAT(
                B.Nombre,
                ' ',
                B.Apellido1,
                ' ',
                B.Apellido2
            ) AS asignacion FROM sibware.personal B WHERE ID=$idasignacion");
            while ($row=$queryResult1->fetch(PDO::FETCH_ASSOC)) {
                $asignacion=$row['asignacion'];
            }
            $queryResult2=$pdo->query("SELECT alertas FROM Intranet.scr_alert WHERE ID=$idalert"); 
            
            while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
                $class_alert=$row['alertas'];
            } 
            echo "<tr class='".$class_alert."'><td>".$descpt."</td><td>".$asignacion."</td><td>".$tester."</td><td>".$ffinalpt."</td><td><a href='updatetask.php?idtask=".$idtask."'>".$statust."</a></td>";
            if($idstatus==5){
               echo "<td>0 dias</td>";
            }else{
                echo "<td>".$interval2->format('%R%a días')."</td>"; 
            }
            
            echo "</tr>";
        }
        
    ?>
</table>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
