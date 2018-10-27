<?php
 
    session_start();
    set_time_limit(0);
    date_default_timezone_set("America/Mexico_City");
    $hoy=date('Y-m-d');
    $id_personal=$_SESSION['IDPersonal'];
    if(isset($_SESSION["IDPersonal"])){
        $inactivo = 10000;
           
          if(isset($_SESSION['tiempo']) ) {
          $vida_session = time() - $_SESSION['tiempo'];
              if($vida_session > $inactivo)
              {
                    unset($_SESSION["IDPersonal"]); 
                    unset($_SESSION["IDDepartamento"]);
                      session_destroy();
                  echo '
                      <script language="JavaScript" type="text/javascript">
                          alert("Se termino el tiempo de la sesion");
                           window.location="index.php";
                      </script> ';
              }
          }
          $_SESSION['tiempo'] = time();  
       }
       if (empty($_SESSION['IDPersonal'])) {
        header("Location: logoff.php");
        }
    $idnivel=$_SESSION['Nivel'];
    $iddepto=$_SESSION['IDDepartamento'];
    $idpersonal=$_SESSION['IDPersonal'];
    
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
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>  
  </head>
<body>
<div class="contenido">

<?php
$id_personal=$_GET['idemp'];
$periodo=$_GET['periodo'];
$correctas=0;
$queryResult=$pdo->query("SELECT CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as Empleado, C.fecha_ap,  A.IDRespuesta,A.IDQst,A.codigo FROM Intranet.PLD_Resultados A INNER JOIN sibware.personal B ON A.IDPersonal=B.ID INNER JOIN Intranet.RelQst C ON A.IDPersonal=C.IDPersonal WHERE A.IDpersonal=$id_personal and A.periodo=$periodo");
//var_dump($queryResult);
while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $emp=$row['Empleado'];
    $fecha=$row['fecha_ap'];
    $idqst=$row['IDQst'];
    $codigo=$row['codigo'];
    $queryResult2=$pdo->query("SELECT * FROM Intranet.PLD_Answer WHERE ID=$row[IDRespuesta] ");
    while($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
        if($row['lAcertivo']=='S'){
            $correctas++;
        }
    }
}
$queryResult = $pdo->query("SELECT * FROM Intranet.PLD_Cuest WHERE IDQst=$idqst");
$row_count = $queryResult->rowCount();
$calf=($correctas/$row_count)*10;
echo "<h3>Examen no ".$codigo." Fecha : ".$fecha." Empleado : ".$emp."</h3>";
echo "<div class='alert alert-success'>";
echo "    <strong>Tuviste </strong>".$correctas."/".$row_count." Respuestas Correctas Tu calificacion es de : ".number_format($calf,2);
echo "</div>";
$queryResult=$pdo->query("SELECT A.IDQst,B.codigo,B.llave,B.ID FROM Intranet.RelQst A INNER JOIN Intranet.PLD_Qst B ON A.IDQst=B.ID WHERE A.IDPersonal=$id_personal AND A.periodo=$periodo and A.lActivo='N'");
while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $codigo=$row['codigo'];
    $idqst=$row['ID'];
    $llave=$row['llave'];
}
//Inicia la impresion del cuestionario
$queryResult=$pdo->query("SELECT ID as IDq, Pregunta, clave FROM Intranet.PLD_Cuest WHERE IDQst=$idqst ");
while($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
    $clave=$row['clave'];
    $qst++;
    $idpregunta=$row['IDq'];
    echo "<p>".$qst.") ".$row['Pregunta']."</p>";
    $cont=0;
    $queryResult1=$pdo->query("SELECT ID as IDw, Respuesta,lAcertivo  FROM Intranet.PLD_Answer WHERE IDCuest=$idpregunta ");
    while($row=$queryResult1->fetch(PDO::FETCH_ASSOC)) {
        $idw=$row['IDw'];
        $respuesta=$row['Respuesta'];
        $acertivo=$row['lAcertivo'];
        if ($acertivo=='S') {
            $idwc=$idw;
            $respuestac=$respuesta;
        }
        $queryResult2=$pdo->query("SELECT * FROM  Intranet.PLD_Resultados WHERE IDpersonal=$id_personal AND IDPregunta=$idpregunta");
        $bandera = $queryResult2->rowCount(); 
        while($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
            
            if($row['IDRespuesta']==$idwc){
                $mensaje='Correcta!';
                $class="alert alert-info";
                $cont++;
                
            }elseif(($row['IDRespuesta']<>$idwc) && ($cont==0)){
                $mensaje='Incorrecta! La respuesta Correcta es : '.$respuestac;
                $class="alert alert-danger";
            }
            $idr=$row['IDRespuesta'];
        } 
        if($idw==$idr){
        echo "<div class='radio'>";
        echo "    <label><input type='radio' name='".$clave."' checked>".$respuesta."</label>";
        echo "</div>";
        
        }elseif ($idw<>$idr) {
        echo "<div class='radio disabled'>";
        echo "    <label><input type='radio' name='".$clave."' disabled>".$respuesta."</label>";
        echo "</div>";
        }
         
       
    }echo "<div class='".$class."'>".$mensaje."</div>";  

}
//aqui termina la impresion del cuestionario
$row_count='N';
echo "<input name='button' type='button' onclick='window.close();' value='Cerrar' class='button' /> ";
echo "<a href='javascript:window.print(); void 0;' class='button'>Imprimir</a> ";
die();
    
?>
</table>

<?php
    /////fin de contenido
    require_once 'footer.php';
?>