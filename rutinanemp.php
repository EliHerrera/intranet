<?php
    require_once 'header.php';
    //////inicio de contenido
?>  
<?php  
$queryResult=$pdo->query("SELECT * FROM Intranet.rutinanemp  ");
while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $idsol=$row['idsol'];
    $rfc=$row['RFC'];
    $nemp=$row['nemp'];
    $queryUpdate=$pdo->prepare("UPDATE sibware.3_cliente_principales_accionistas SET RFC='$rfc',NEmpleados=$nemp WHERE ID=$idsol");
    $queryUpdate->execute();
    echo "<div class='alert alert-success'>";
            echo "    <strong>Aviso!</strong> Actualizado con exito";
            echo "</div>";
}
?>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
