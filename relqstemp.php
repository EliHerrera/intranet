<?php
    require_once 'header.php';
    //////inicio de contenido
    function generarCodigo($longitud) {
        $key = '';
        $pattern = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
        return $key;
       }
    $periodo=date('Y');
    if (!empty($_GET)) {
        $idqst=$_GET['idqst'];
    }    
        $queryResult = $pdo->query("SELECT ID,codigo FROM Intranet.PLD_Qst WHERE ID=$idqst");
        while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            $codigo=$row['codigo'];
            $idqst=$row['ID'];
        }
    if (!empty($_GET['idrel'])) {
        echo $_GET['banda'];
        $idrel=$_GET['idrel'];
        if ($_GET['banda']==0) {
            $llave=generarCodigo(6);
            $queryResult = $pdo->query("UPDATE Intranet.RelQst SET  lActivo='S',llave='$llave' WHERE ID=$idrel");# code...
        }elseif ($_GET['banda']==1) {
            $queryResult = $pdo->query("UPDATE Intranet.RelQst SET  lActivo='N' WHERE ID=$idrel");
        }
        
        
    }
?>    
<h3>Integrantes de Examen : <?PHP echo $codigo ?></h3><a href="relqst.php" class="button">Asignar</a><a href="qstpld.php" class="button">Regresar</a>
<table class="table">
<tr><th>No.</th><th>Examen</th><th>Empleado</th><th>Calificacion</th><th>Status</th></tr>
<?PHP
    $queryResult = $pdo->query("SELECT B.codigo,CONCAT(C.Nombre,' ',C.Apellido1,' ',C.Apellido2) as Emp ,A.Calf, A.lActivo,A.ID from Intranet.RelQst A INNER JOIN Intranet.PLD_Qst B on A.IDQst=B.ID INNER JOIN sibware.personal C on A.IDPersonal=C.ID WHERE A.IDQst=$idqst AND A.periodo=$periodo");
    while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $fila++;
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
        $idrel=$row['ID'];
        echo "<tr><td>".$fila."</td><td>".$row['codigo']."</td><td>".$row['Emp']."</td><td>".$row['Calf']."</td><td><a href='relqstemp.php?idrel=".$idrel."&banda=".$bandA."&idqst=".$idqst."'>".$activo."</a></td></tr>";
    }
?>
</table>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
