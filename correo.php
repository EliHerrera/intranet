<?php
$subject="prueba";
$message="peruab de inatranet";
/*Lo primero es añadir al script la clase phpmailer desde la ubicación en que esté*/
require('phpmailer/class.phpmailer.php');
 
//Crear una instancia de PHPMailer
$mail = new PHPMailer();
//Definir que vamos a usar SMTP
$mail->IsSMTP();
//Esto es para activar el modo depuración. En entorno de pruebas lo mejor es 2, en producción siempre 0
// 0 = off (producción)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug  = 0;
//Ahora definimos gmail como servidor que aloja nuestro SMTP
$mail->Host       = 'mail.credicor.com.mx';
//El puerto será el 587 ya que usamos encriptación TLS
$mail->Port       = 465;
//Definmos la seguridad como TLS
$mail->SMTPSecure = 'tls';
//Tenemos que usar gmail autenticados, así que esto a TRUE
$mail->SMTPAuth   = true;
//Definimos la cuenta que vamos a usar. Dirección completa de la misma
$mail->Username   = "intranet@credicor.com.mx";
//Introducimos nuestra contraseña de gmail
$mail->Password   = "Intr4n3tCM!2018";
$mail->From = "intranet@credicor.com.mx"; // Mail de origen
$mail->FromName = "INTR@NET"; // Nombre del que envia
//Definimos el remitente (dirección y, opcionalmente, nombre)
//$mail->SetFrom(' infonavitmascercadeti@correo.infonavit.org.mx ', 'Infonavit');
//Esta línea es por si queréis enviar copia a alguien (dirección y, opcionalmente, nombre)
//$mail->AddReplyTo(' infonavitmascercadeti@correo.infonavit.org.mx ','Infonavit');
//Y, ahora sí, definimos el destinatario (dirección y, opcionalmente, nombre)
$mail->AddAddress('efren.almanza@credicor.com.mx', 'Efren Almanza Lamas');
//Definimos el tema del email
$mail->Subject = $subject;
//Para enviar un correo formateado en HTML lo cargamos con la siguiente función. Si no, puedes meterle directamente una cadena de texto.
//$mail->MsgHTML(file_get_contents('http://www.puntopixel.com.mx/infonavit.html'));
//Y por si nos bloquean el contenido HTML (algunos correos lo hacen por seguridad) una versión alternativa en texto plano (también será válida para lectores de pantalla)
$mail->AltBody = 'This is a plain-text message body';
$mail->Body =$message;
//Enviamos el correo
if(!$mail->Send()) {
  echo "Error: " . $mail->ErrorInfo;
} else {
  echo "Enviado correo con exito!";
}


?>