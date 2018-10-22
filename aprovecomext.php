<?php
    require_once 'header.php';
    //////inicio de contenido
    $queryResult=$pdo->query("SELECT * FROM Intranet.com_extensionistas WHERE ID=$_GET[idcom]");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $ideje=$row['IDPersonal'];
        $comcr=$row['comcr'];
        $comap=$row['comap'];
        $comvp=$row['comvp'];
        $total=$comcr+$comap+$comvp;
        $periodo=$row['periodo'];
        $yy=$row['yy'];
        $fecha=date("Y-m-d H:i:s"); 
    }
    $queryinsert=$pdo->prepare("INSERT INTO Intranet.comisiones (fecha,mes,id_ejecutivo,total_comi_apvp,total_comi_vp,total_comi_cred,total_apagar,status,yy) VALUES('$fecha',$periodo,$ideje,$comap,$comvp,$comcr,$total,2,$yy)");
    
    $queryinsert->execute();
    $queryupdate=$pdo->prepare("UPDATE Intranet.com_extensionistas SET status=2 WHERE ID=$_GET[idcom]");
    $queryupdate->execute();
?> 


<?php
    /////fin de contenido
    require_once 'footer.php';
    header('Location: relcomisiones.php');
?>
