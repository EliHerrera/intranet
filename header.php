<?php
    session_start();
    set_time_limit(0);
    if(isset($_SESSION["IDPersonal"])){
        $inactivo = 1000;
           
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
    echo $idnivel;
    echo $iddepto;
    echo $idpersonal;
    require_once 'cn/cn.php';
    $queryResult=$pdo->query("SELECT CONCAT(Nombre,' ',Apellido1,' ',Apellido2) as nombre from personal where ID=$idpersonal");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $nombre=$row['nombre'];
    }
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Intr@net Credicor</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<header>

<?php        echo "<div class='user'>BIENVENIDO <strong>".$nombre."</strong>   <a href='#'><img src='img/icons/user.png' alt='' height='12px' width='12px'></a> <a href='#'><img src='img/icons/notification.png' alt='' height='10px' width='10px'></a> <a href='logoff.php'>CERRAR SESION </a> </div>"; ?>
        
</header>
    <div class="logo"><a href="index.php"><img src="img/logos/Imagotipo.png" alt="" height='45px' width="235px"  width="100" ></a></div>
    <nav>
    <div class="menu">
		<ul>
            <?php   
                    $queryResult=$pdo->query("SELECT  id,menu,enlace,icon from Intranet.menus where depto=0 and nivel<=3  and status='S' and tipo='P' and id<>63");
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li><a href='".$row['enlace']."'><img src='img/icons/".$row['icon']."' alt='' height='20px' width='20px'></br>".$row['menu']."</a>";
                        echo "<ul>";
                        $queryResult1=$pdo->query("SELECT menu as menu2,enlace as enlace2 from Intranet.menus where (depto=$iddepto or depto=0) and nivel<=$idnivel and status='S'  and idpadre=$row[id]");
                        while ($row=$queryResult1->fetch(PDO::FETCH_ASSOC)) {
                            echo "<li><a href='".$row['enlace2']."'>".$row['menu2']."</a></li>";
                        }
						 
                            
                        echo "</ul>";    
                        echo "</li>";

                    }
            ?>
                        
			
        </ul>
    </div>
</nav>
<div class="contenido">