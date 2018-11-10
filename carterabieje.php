<?php
    if (!empty($_POST['hoy'])) {
        $hoy=$_POST['hoy'];
        
    }else{
        $hoy=date('Y-m-d');
    }
    $location='carteraeje';    
    require_once 'headerbi.php';
    //////inicio de contenido
    //consulta tipo de cambio
    $queryResult=$pdo->query("SELECT * FROM sibware.indicador_tipocambio WHERE Fecha='$hoy'");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $tc=$row['Paridad'];
    }//consulta tipo de cambio
    require 'estiloconst.php'; 
    require 'menubi.php';
    
?>
<div class="row">
  <div class='col-md-6' id="carteraejecmu"></div>
  <div class='col-md-6' id="carteraejecma"></div>
</div>
<form action="carterabieje.php" method="post">
    <div class="row">
        <div class="col-xs-2">
            <a href="carterabi2.php" class="button">Regresar</a>
        </div>
        <div class="col-xs-3">
            <label for="hoy">Buscar</label>
            <input type="date" name="hoy" id="hoy" class="form-control" required="true">
        </div>
        <div class="col-xs-2">
            <br><input type="submit" class="button" value="Buscar">
        </div>
    </div>
    <div class="row">    
        <div class="col-xs-2">
            <a href="carterabiinveje.php" class="button">Inversiones</a>
        </div>
        <div class="col-xs-2">
            <a href="#" class="button">Arrendamiento</a>
        </div>
        <div class="col-xs-2">
            <a href="carterabivpeje.php" class="button">Venta a Plazo</a>
        </div>

    </div>
</form>
<table class="table">
    <tr><th>Ejecutivo</th><th>Saldo</th><th>Empresa</th></tr>
<?php
    $queryResult=$pdo->query("SELECT
    CONCAT(
        B.Nombre,
        ' ',
        B.Apellido1,
        ' ',
        B.Apellido2
    ) AS Ejecutivo,
    SUM(A.Saldo)  AS Saldo,
    Empresa
    
FROM
    Intranet.carterabi A
INNER JOIN sibware.personal B ON A.IDEjecutivo = B.ID

WHERE
    A.fecha = '$hoy'
AND
    A.tipo=1 
AND
    A.Empresa=2    
GROUP BY
    B.ID");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {  
    if($row['Empresa']==2){
        $emp='CMU';
    }elseif ($row['Empresa']==3) {
        $emp='CMA';
    }
    echo "<tr><td>".$row['Ejecutivo']."</td><td>".number_format($row['Saldo'],2)."</td><td>".$emp."</td></tr>";
}  
$queryResult=$pdo->query("SELECT
    CONCAT(
        B.Nombre,
        ' ',
        B.Apellido1,
        ' ',
        B.Apellido2
    ) AS Ejecutivo,
    SUM(A.Saldo)  AS Saldo,
    Empresa
    
FROM
    Intranet.carterabi A
INNER JOIN sibware.personal B ON A.IDEjecutivo = B.ID

WHERE
    A.fecha = '$hoy'
AND
    A.tipo=1 
AND
    A.Empresa=3   
GROUP BY
    B.ID");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {  
    if($row['Empresa']==2){
        $emp='CMU';
    }elseif ($row['Empresa']==3) {
        $emp='CMA';
    }
    echo "<tr><td>".$row['Ejecutivo']."</td><td>".number_format($row['Saldo'],2)."</td><td>".$emp."</td></tr>";
}              
?>    

</table>
<?php
    $querydelete=$pdo->prepare("DELETE FROM Intranet.carterabi WHERE fecha='$hoy' AND tipo=1");
    $querydelete->execute(); 
?>  
<?php
    /////fin de contenido
    require_once 'footer.php';
?>