<?php 
    include 'get-chat.php';
    if(isset($_SESSION['user'])){
        include 'conexion_be.php';
        $outgoing_id = $_SESSION['user'];
        $incoming_id = mysqli_real_escape_string($conexion, $_POST['incoming_id']);
        $message = mysqli_real_escape_string($conexion, $_POST['message']);
        if(mysqli_num_rows($query) == 0){
            $sqli = mysqli_query($conexion, "INSERT INTO chats (incoming_msg_id, outgoing_msg_id, msgdate) 
            VALUES ({$incoming_id}, {$outgoing_id}, now())") or die();
        }
        if(!empty($message)){
            $following = mysqli_query($conexion, "SELECT chatid FROM chats WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id}) OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id})") or die();
            $fw = mysqli_fetch_assoc($following);
            $sqlib = mysqli_query($conexion, "INSERT INTO messages (chatid, incoming_msg_id, outgoing_msg_id, msg, msgdate)
                                        VALUES ({$fw['chatid']}, {$incoming_id}, {$outgoing_id}, '{$message}', now())") or die();
$user = mysqli_query($conexion, "SELECT * FROM usuarios WHERE user = '".mysqli_real_escape_string($conexion, $incoming_id)."' ");
                        $use = mysqli_fetch_array($user);
                        if($use['status'] === 'Offline'){
                            $updoff = mysqli_query($conexion, "UPDATE usuarios SET newmessages = newmessages +1 WHERE user = '".mysqli_real_escape_string($conexion, $incoming_id)."'");
require 'src/Exception.php';
        require 'src/PHPMailer.php';
        require 'src/SMTP.php';
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
        $mail->AddAddress($use['correo']);
        $mail->AddReplyTo('no-reply@librecripto.com','no-reply');

        $mail->Subject = "¡Recibiste un nuevo mensaje!";
        $mensajeHtml = nl2br($mensaje);
        $mail->Body = "
         <html>

         <body>

         <h3>¡Hola, $use['nombre']!</h3>
            <p>Recibiste un nuevo mensaje de @$_SESSION['usuario']</p>
                                <p>Iniciá sesión en LibreCripto con tu cuenta y accedé al apartado de 'Mis Chats' para poder responderle ;)</p>
                                        
                                <p>¡Muchas gracias! Con tu participación contribuis a hacer de LibreCripto un mejor ecosistema cripto ;)</p>
                                        
                                <p>Saludos, <b>-El equipo de LibreCripto.</b></p>
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
                        }else{
                            $updon = mysqli_query($conexion, "UPDATE usuarios SET newmessages = newmessages +1 WHERE user = '".mysqli_real_escape_string($conexion, $incoming_id)."'");
                        }
            $sqliupd = mysqli_query($conexion, "UPDATE chats SET msgdate = now() WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id}) OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id})") or die();
        }
    }else{
        header("location: ../index.php");
    }


    
?>