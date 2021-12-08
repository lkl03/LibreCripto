<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</head>

<?php
$title = "Solicitud cambio de contraseña | LibreCripto";
include 'php/conexion_be.php';
include_once 'includes/templates/headeraccess.php';
if(isset($_POST['codigo'])) {
    function secure($value){
        include 'php/conexion_be.php';
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        $value = mysqli_real_escape_string($conexion, $value);
        return $value;
    }
    $email = secure($_POST['email']);
    $sql = mysqli_query($conexion, "SELECT correo,nombre,usuario FROM usuarios WHERE correo='".$email."'");
    $row = mysqli_fetch_array($sql);
    $correo = filter_var($row['correo'], FILTER_SANITIZE_EMAIL);
    $nombre = filter_var($row['nombre'], FILTER_SANITIZE_STRING);
    $usuario = filter_var($row['usuario'], FILTER_SANITIZE_STRING);
    $count = mysqli_num_rows($sql);
    if($count == filter_var('1', FILTER_SANITIZE_NUMBER_INT)) {
        $token = md5(rand(0,1000));
        $act = mysqli_query($conexion, "UPDATE usuarios SET token = '$token' WHERE correo = '".$email."'");
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () {';
        echo 'swal("¡Enlace enviado!","Hemos enviado a tu dirección de correo electrónico un enlace para reestablecer tu contraseña.","success", {button: "Continuar",}).then( function(val) {';
        echo 'if (val == true) window.location.href = \'https://librecripto.com/registro\';';
        echo '});';
        echo '}, 200);  </script>';
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

        $mail->Subject = "Solicitud de cambio de contraseña";
        $mensajeHtml = nl2br($mensaje);
        $mail->Body = "
         <html>

         <body>

         <h3>Hola, $nombre.</h3>
             
        <p>Solicitaste cambiar la contraseña de tu cuenta.</p>
        <p>Para hacerlo, </p><a href='https://librecripto.com/passwordresetnew?usuario=".$usuario."&token=".$token."'>por favor hace click acá.</a>
        <p>Si no fuiste vos quien hizo esta solicitud, por favor ignorá completamente este correo.</p>
        <p><b>-El equipo de LibreCripto.</b></p>'
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
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () {';
        echo 'swal("¡Correo no encontrado!","Por favor ingresa el correo electrónico con el que creaste tu cuenta en LibreCripto.","error", {button: "Intentar de nuevo",})';
        echo '}, 200);  </script>';
    }
}


?>

<main class="Access">

    <section class="seccion contenedor">
        <div class="formconfirm">
            <form action="" method="post">
                <div class="fillcode">
                    <label for="email">Correo electrónico</label>
                    <input type="email" autocomplete="off" name="email" id="email"  required/>
                </div>
                <div class="fillcodebtn">
                    <input type="submit" value= "Confirmar email" name="codigo"/>
                </div>
            </form>
        </div>
    </section>

</main>
<?php include_once 'includes/templates/footeraccess.php'; ?>