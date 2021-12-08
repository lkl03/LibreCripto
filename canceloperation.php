<?php
include 'php/conexion_be.php';	
$id=$_POST["id"];
$us=$_POST["us"];
$em=$_POST["em"];
$th=$_POST["th"];
$chid=$_POST["chid"];
$chim=$_POST["chim"];
$chom=$_POST["chom"];
$chmd=$_POST["chmd"];
mysqli_query($conexion, "DELETE FROM operaciones WHERE operationid=$id");
mysqli_query($conexion, "INSERT INTO chats(chatid, incoming_msg_id, outgoing_msg_id, msgdate) VALUES('$chid', '$chim', '$chom', '$chmd')");
require 'php/src/Exception.php';
require 'php/src/PHPMailer.php';
require 'php/src/SMTP.php';

$mail->CharSet = 'UTF-8';
        
        $smtpHost = "c2410691.ferozo.com";
        $smtpUsuario = "librecripto@librecripto.com";
        $smtpClave = "Lk3209lk";  // Mi contraseña

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->IsHTML(true);
        $mail->CharSet = "utf-8";

        $mail->Host = $smtpHost;
        $mail->Username = $smtpUsuario;
        $mail->Password = $smtpClave;


        $mail->From = $smtpUsuario;
        $mail->FromName = 'LibreCripto';
        $mail->AddAddress($em);
        $mail->AddReplyTo('no-reply@librecripto.com','no-reply');

        $mail->Subject = "La operación con @$th fue cancelada";
        $mensajeHtml = nl2br($mensaje);
        $mail->Body = "
         <html>

         <body>

         <h3>¡Hola, $us!</h3>
    
<p><b>@$th</b> canceló la operación, por lo que ya no es necesario que lo califiques.</p>
<p>Tu chat con él ha sido habilitado nuevamente. ¡Está atent@ por si la operación vuelve a ser enviada!</p>

<p>Saludos!<b>-El equipo de LibreCripto.</b></p>
         </body>

         </html>

        <br />";

        $mail->SMTPOptions = array(
         'ssl' => array(
         'verify_peer' => false,
         'verify_peer_name' => false,
         'allow_self_signed' => true
         )
        );

        $estadoEnvio = $mail->Send();

?>