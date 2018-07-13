<?php
//Script para cerrar session

session_start();
unset($_SESSION["usuario"]);
unset($_SESSION["contraseña"]);
session_destroy();
header("Location: login.php");
exit;
?>