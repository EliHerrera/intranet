<?php
    require_once 'header.php';
    //////inicio de contenido
    if(!empty($_POST)){
        $fini=$_POST['fini'];
        $ffin=$_POST['ffin'];

    }
?>    
<h3>Relacion de Contratos para Comite</h3>
<form action="autorizaciondecomite.php" method="post">
<div class="row">
    <div class="col-xs-3">
        <label for="fini">Desde</label><input type="date" name="fini" id="fini" class="form-control" required="true">
    </div>
    <div class="col-xs-3">
        <label for="ffin">Hasta</label><input type="date" name="ffin" id="ffin" class="form-control" required="true">
    </div>
    <div class="col-xs-2">
        <br><input type="submit" value="Buscar" class="button">
    </div>
</div>
</form>
<table class="table">
<tr><th>Cliente</th><th>Folio</th><th>Empresa</th><th>Ejecutivo</th><th>Fecha</th><th>Estatus</th><th>Acciones</th></tr>
<?php
$queryResult=$pdo->query("SELECT * FROM Intranet.comiteaprobacion WHERE fecha>='$fini' AND fecha<='$ffin'");
while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {

if ($row['emp']==2) {
    $emp='CMU';
}elseif ($row['emp']==3) {
    $emp='CMA';
}
if($row['status']=='P'){
    $status='Pendiente';
}elseif ($row['status']=='PR') {
    $status='Gestionando Presentacion';
}elseif ($row['status']=='C') {
    $status="Comite";
}elseif($row['status']=='A'){
    $status='Aprobado';
}elseif ($row['status']=='R') {
    $status='Rechazado';
}elseif ($row['status']=='L') {
    $status='Listo';
}else{
    $status='Sin Gestionar';
}
    echo "<tr><td>".$row['cliente']."</td><td>".$row['folio']."</td><td>".$emp."</td><td>".$row['ejecutivo']."</td><td>".$row['fecha']."</td><td>".$status."</td><td>";
    if ($row['status']=='P'||$row['status']=='PR') {
        echo "<a href='viewgestionarpres.php?idac=".$row['idac']."&emp=".$row['emp']."'>Gestionar</a>";
    }    
}   echo "</td></tr>";
?>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
