<?php
session_start();
?>
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</head>

<?php
    function secure($value){
        include 'php/conexion_be.php';
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        $value = mysqli_real_escape_string($conexion, $value);
        return $value;
    }

$title = "Verificar cuenta | LibreCripto";

    include 'php/conexion_be.php';
    $correo = filter_var($_SESSION['correo'], FILTER_SANITIZE_EMAIL);
    $nombre = filter_var($_SESSION['nombre'], FILTER_SANITIZE_STRING);
    $consult = ("SELECT confirmedemail FROM usuarios WHERE usuario='".mysqli_real_escape_string($conexion, $_SESSION['usuario'])."'");
    $result = mysqli_query($conexion, $consult);
    $row = mysqli_fetch_array($result);
    if($row['confirmedemail'] == filter_var('0', FILTER_SANITIZE_NUMBER_INT)){
        include_once 'includes/templates/headeraccess.php';
        if(isset($_POST['codigo'])) {
            $codigoverif = secure($_POST['verif']);
            $consult = mysqli_query($conexion, "SELECT codigoverif FROM usuarios WHERE usuario='".mysqli_real_escape_string($conexion, $_SESSION['usuario'])."'");
            $row = mysqli_fetch_array($consult);
            if($row['codigoverif'] == $codigoverif){
                echo '<script type="text/javascript">';
                echo 'setTimeout(function () {';
                echo 'swal("¡Verificación exitosa!","Tu cuenta ha sido verificada, ya podes acceder a todas las funciones del sitio.","success", {button: "Continuar",}).then( function(val) {';
                echo 'if (val == true) window.location.href = \'https://librecripto.com\';';
                echo '});';
                echo '}, 200);  </script>';
                $sql = mysqli_query($conexion, "UPDATE usuarios SET confirmedemail = '1' WHERE usuario='".mysqli_real_escape_string($conexion, $_SESSION['usuario'])."'");
                require 'php/src/Exception.php';
                require 'php/src/PHPMailer.php';
                require 'php/src/SMTP.php';
                
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

        $mail->Subject = "¡Cuenta verificada exitosamente!";
        $mensajeHtml = nl2br($mensaje);
        $mail->Body = "
         <html>

         <body>

         <h3>¡Felicidades, $nombre!</h3>
                     
                <p>Tu cuenta ha sido verificada correctamente. Ya podés acceder a todas las funciones de LibreCripto con tus datos de usuario.</p>

            
                <p>¡Te esperamos! <b>-El equipo de LibreCripto.</b></p>
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
                echo 'swal("¡Código incorrecto!","Por favor ingresa el código que fue enviado a tu correo electrónico. Si no aparece, prueba revisando la casilla de spam.","error", {button: "Intentar de nuevo",})';
                echo '}, 200);  </script>';
            }
            mysqli_close($conexion);
        }
    }else{
        $consult = ("SELECT confirmedemail FROM usuarios WHERE usuario='".mysqli_real_escape_string($conexion, $_SESSION['usuario'])."'");
        $result = mysqli_query($conexion, $consult);
        $row = mysqli_fetch_array($result);
            if($row['confirmedemail'] == filter_var('1', FILTER_SANITIZE_NUMBER_INT)){ 
            header("location: index.php");
        }
        mysqli_close($conexion);
    }
?>

<main class="Access">

    <section class="seccion contenedor">
        <div class="formconfirm">
            <form action="" method="post">
                <div class="fillcode">
                    <label for="verif">Código de verificación</label>
                    <input type="text" name="verif" id="verif" autocomplete="off" required/>
                </div>
                <div class="fillcodebtn">
                    <input type="submit" value= "Confirmar email" name="codigo"/>
                </div>
            </form>
        </div>
    </section>

</main>