<?php
include 'php/connect.php';	
include '../php/conexion_be.php';	

$id=$_POST["id"];
$userid=$_POST["userid"];
$nm=$_POST["nm"];
$us=$_POST["us"];
$cr=$_POST["cr"];
mysqli_query($connect, "UPDATE criptotop SET estado = 'aprobada' WHERE solicitud=$id");
mysqli_query($conexion, "UPDATE usuarios SET criptotop = '1' WHERE id=$userid");
require 'php/src/Exception.php';
                                                require 'php/src/PHPMailer.php';
                                                require 'php/src/SMTP.php';
                                                  
                                                $smtpHost = "c2410691.ferozo.com";
        $smtpUsuario = "info@librecripto.com";
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
        $mail->AddAddress($cr);
        $mail->AddReplyTo('no-reply@librecripto.com','no-reply');

        $mail->Subject = "Solicitud para CriptoTop aprobada";
        $mensajeHtml = nl2br($mensaje);
        $mail->Body = "
         <html>

         <body>

         <h3>¡Hola, $nm!</h3>
    
<p>¡Tu solicitud para ser CriptoTop fue aprobada!</p>
<p>Ya podes ver tu distinción en tu usuario de LibreCripto @$us. Aparecerá en tu cuenta y junto a tus anuncios publicados. ¡Recordá que también es visible para los demás usuarios!</p>
<p>Muchas gracias por ser parte activa del ecosistema LibreCripto y contribuir a él con tus operaciones ;)</p>

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