<?php
require_once 'cn/cn.php';
$messege=""; //Variable de mensaje inicializa a vacio
if (!empty($_POST)) {//compara si el formulario viene vacio
    $user=$_POST['user'];
    $pass=$_POST['pass'];
    $queryResult = $pdo->query("SELECT *  from sibware.usuarios WHERE Usuario='$user' and passw=PASSWORD('$pass')");
    // echo $messege='entro!';
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
</head>
<body>
<div class="container">
<form action="login.php" method='post'>
    <label for="user">Usuario</label><input type='text' name='user' id='user' required='true' placeholder='Usuario' /><br/> 
    <label for="pass">Contraseña</label><input type='password' name='pass' id='pass' required='true' placeholder='Contraseña'  /><br/>  
    <input type='submit' name='enviar' id='enviar' value='Ingresar' /><br/>   
</form>
<div></div>

</div>
    
</body>
</html>