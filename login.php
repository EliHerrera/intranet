<?php

$messege=""; //Variable de mensaje inicializa a vacio
if (!empty($_POST)) {//compara si el formulario viene vacio
    require_once 'cn/cn.php';
    $user=$_POST['user'];
    $pass=$_POST['pass'];
    $queryResult = $pdo->query("SELECT *  from sibware.usuarios WHERE Usuario=:user and passw=PASSWORD(:passw)");
    $queryResult->prepare();

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
    <link rel="stylesheet" href="css/styles.css" />
<head>    
<body>
<div class="login-page">
      <div class="form">
        <img src="img/logos/logo_credicor-blanco.png" alt="">  
        <form class="register-form" method="POST">
          <input type="text" placeholder="name"/>
          <input type="password" placeholder="password"/>
          <input type="text" placeholder="email address"/>
          <button>create</button>
          <p class="message">Already registered? <a href="#">Sign In</a></p>
        </form>
        <form class="login-form" method="POST" action="login.php">
          <input type="text" placeholder="username" required="true" name="user"/>
          <input type="password" placeholder="password" required="true" name="pws" />
          <button>Ingresar</button>
          <p class="message"><a href="#">| Reestablecer Contraseña |</a></p>
          <p class="message"><?php echo $message; ?></p>
        </form>
      </div>
    </div>
</body>
</html>