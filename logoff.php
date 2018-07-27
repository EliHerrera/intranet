<?php
//Script para cerrar session

session_start();
unset($_SESSION["usuario"]);
unset($_SESSION["contraseña"]);
unset($_SESSION["llave"]);
session_destroy();
header("Location: login.php");
exit;
?>