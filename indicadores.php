<?PHP
    $hoy=date('Y-m-d');
    require_once 'cn/cn.php';
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Intr@net Credicor</title>
    <link rel="shortcut icon" href="http://wwww.ejemplo.org/img/favicon.ico" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="logo"><a href="index.php"><img src="img/logos/Imagotipo.png" alt="" height='45px' width="235px"  width="100" ></a></div>
<div class="contenido">
<h1>Tasa de Inversiones</h1>
<table class="table">
<?PHP
    $queryResult=$pdo->query("SELECT * from sibware.2_indicador_tablainversion WHERE IDMoneda=1 AND '$hoy' BETWEEN Desde and Hasta");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            //echo mssql_result($admin, $i, 'Cliente_ID'),
             //PHP_EOL;
             $idtabla=$row['ID'];
             $desde=$row['Desde'];
             $hasta=$row['Hasta'];
    }
?>
<tr><th colspan="5"><h3>De : <?PHP echo $desde ?> Hasta :  <?PHP echo $hasta ?></h3></th></tr> 
<tr><th><h3>Rango</th></th><th><h3>28 Dias</th></th><th><h3>91 Dias</th></th><th><h3>180 Dias</th></th><th><h3>360 Dias</th></th></tr>
<?PHP
    $queryResult=$pdo->query("SELECT format(ImporteLimite+1,0)as de,format(ImporteLimite,0) as ImporteLimite, d28,d91v,d180v,d360v from sibware.2_indicador_tablainversionmovs where IDTabla=$idtabla");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><th><h4> Desde : ".$row['de']." Hasta ".$row['ImporteLimite']."</h4></th><td><h3>".$row['d28']."</h3></td><td><h3>".$row['d91v']."</h3></td><td><h3>".$row['d180v']."</h3></td><td><h3>".$row['d360v']."</h3></td></tr>";
    }

?>   
</table>
</div>
<footer><img src="img/logos/imagotipo_credicor.png" alt=""></footer>    
</body>
</html>