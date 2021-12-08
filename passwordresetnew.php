<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</head>

<?php 
$title = "Cambio de contraseña | LibreCripto";
if(isset($_GET['usuario']) AND isset($_GET['token'])){
    include 'php/conexion_be.php';
    include_once 'includes/templates/headeraccess.php';

    $usuario = filter_var($_GET['usuario'] , FILTER_SANITIZE_STRING);
    $token = filter_var($_GET['token'] , FILTER_SANITIZE_STRING);

    $sql = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='".mysqli_real_escape_string($conexion, $usuario)."'");
    $row = mysqli_fetch_array($sql);
    $correo = filter_var($row['correo'], FILTER_SANITIZE_EMAIL);
    $nombre = filter_var($row['nombre'], FILTER_SANITIZE_STRING);
    $usuario = filter_var($row['usuario'], FILTER_SANITIZE_STRING);
    if($row['token'] == mysqli_real_escape_string($conexion, $token)) {
?>
<?php 

if(isset($_POST['codigo'])){
    include 'php/conexion_be.php';

    $pass = $_POST['pass'];
    $pass = hash('sha512', $pass);

    $act = mysqli_query($conexion, "UPDATE usuarios SET pass = '$pass', token = '' WHERE usuario = '".mysqli_real_escape_string($conexion, $usuario)."'");
    if($act) {
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () {';
        echo 'swal("¡Contraseña actualizada!","Tu contraseña fue actualizada correctamente. ¡Ya podes acceder a tu cuenta!","success", {button: "Iniciar sesión",}).then( function(val) {';
        echo 'if (val == true) window.location.href = \'https://librecripto.com/registro\';';
        echo '});';
        echo '}, 200);  </script>';
    }
require 'php/src/Exception.php';
        require 'php/src/PHPMailer.php';
        require 'php/src/SMTP.php';
$mail=new PHPMailer();
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
        $mail->AddAddress($correo);
        $mail->AddReplyTo('no-reply@librecripto.com','no-reply');

        $mail->Subject = "Aviso de cambio de contraseña";
        $mensajeHtml = nl2br($mensaje);
        $mail->Body = "
         <html>

         <body>

         <h3>Hola, $nombre.</h3>
             
        <p>Recientemente la contraseña de tu cuenta @$usuario fue actualizada.</p>
        <p>Este email simplemente es para notificarte de este cambio y para informarte de que ya podes acceder a tu cuenta con tu nueva clave.</a>
        <p>Si no fuiste vos quien hizo este cambio y crees que tu cuenta puede estar en peligro, <a href='mailto:contacto@librecripto.com'>ponete en contacto de inmediato con nosotros</a></p>
        <p><b>-El equipo de LibreCripto.</b></p>
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
}
?>
    <main class="Access">

    <section class="seccion contenedor">
        <div class="formconfirm">
            <form action="" method="post">
                <div class="fillcode">
                    <label for="pass" id="labelpass">Reestablecer contraseña</label>
                    <div class="input-group">
                        <input type="password" name="pass" id="pass"  required/>
                        <div class="input-group-append">
                            <button id="show_passwordNew" class="btn btn-primary" type="button" onclick="mostrarPasswordNew()"> <span class="fa fa-eye icon"></span> </button>
                        </div>
                    </div>
                </div>
                <div class="fillcodebtn">
                    <input type="submit" value= "Confirmar nueva contraseña" name="codigo"/>
                </div>
            </form>
        </div>
    </section>

    </main>
<?php 
}else{
    echo '<script type="text/javascript">';
    echo 'setTimeout(function () {';
    echo 'swal("¡Ups!","¿Olvidaste tu contraseña? Debes acceder aquí mediante un código único.","warning", {button: "Solicitar",}).then( function(val) {';
    echo 'if (val == true) window.location.href = \'https://librecripto.com/passwordreset\';';
    echo '});';
    echo '}, 200);  </script>';  
}
}
?>
<?php include_once 'includes/templates/footeraccess.php'; ?>