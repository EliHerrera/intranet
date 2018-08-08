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