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
<?php
// $to="efren.almanza@credicor.com.mx";
// $message="prueba mail";
// $subject="prueba de mail";
// require('phpmailer/class.phpmailer.php');
$mail = new PHPMailer();
$mail->From = "intranet@credicor.com.mx"; // Mail de origen
$mail->FromName = "Intranet Credicor Mexicano"; // Nombre del que envia
$mail->AddAddress("$to"); // Mail destino, podemos agregar muchas direcciones
$mail->AddReplyTo("intranet@credicor.com.mx"); // Mail de respuesta
$mail->WordWrap = 50; // Largo de las lineas
$mail->IsHTML(true); // Podemos incluir tags html
$mail->Subject = $subject;
$mail->Body =$message;
//$mail->AltBody = strip_tags($mail->Body); // Este es el contenido alternativo sin html
$mail->Mailer = "smtp";
$mail->Host = "13.66.56.161";
$mail->Port = 26;
$mail->SMTPAuth = true;
$mail->Username = "intranet@credicor.com.mx"; // SMTP username
$mail->Password = "Intr4n3tCM!2018"; // SMTP password
$mail->Send();
if ($mail->Send()){
$mensaje= "Correo enviado con exito;)";}
else{
$mensaje= "! Error en el envio de mail Contacte a su Soporte";}
$banderamsj=1;
?>
</body>
</html>