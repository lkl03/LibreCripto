<?php
session_start();
?>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
</head>
<?php
$title = "Solicitud CriptoTop | LibreCripto";
    if(!isset($_SESSION['user'])){
        include_once 'includes/templates/headeraccess.php';
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () {';
        echo 'swal("Ups!","Debes iniciar sesión para estar aquí.","warning").then( function(val) {';
        echo 'if (val == true) window.location.href = \'https://librecripto.com/acceso\';';
        echo '});';
        echo '}, 200);  </script>';
        session_destroy();
        die();
    }else{
        include_once 'includes/templates/headerlogged.php';
    }

    include 'php/conexion_be.php';
    
    if(isset($_GET['user'])){
        $user = filter_var($_GET['user'], (FILTER_SANITIZE_NUMBER_INT));

        $myuser = mysqli_query($conexion, "SELECT * FROM usuarios WHERE user = '".mysqli_real_escape_string($conexion, $user)."' ");
        $use = mysqli_fetch_array($myuser);
        $myuserop = mysqli_query($conexion, "SELECT * FROM operaciones WHERE usersending = '".mysqli_real_escape_string($conexion, $user)."' ORDER BY operationid DESC");
        $useop = mysqli_fetch_array($myuserop);

        if($_SESSION['user'] != $user || $use['criptotop'] === filter_var('1' , FILTER_SANITIZE_NUMBER_INT)) {
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () {';
        echo 'swal("Ups!","No deberías estar en esta página","error").then( function(val) {';
        echo 'if (val == true) window.location.href = \'https://librecripto.com\';';
        echo '});';
        echo '}, 200);  </script>';
        exit();
        }
    }

?>
    <main>
        <section class="seccion2 BackNar">
            <h2 class="titleAccount">Solicitud CriptoTop</h2>
        </section>
        <div class="seccion contenedor">
            <p class="textPage ct">¿Querés convertirte en un usuario CriptoTop?</p>
            <p class="textct">¡Vas a contar con una insignia que verifique tu reputación como usuario destacado de LibreCripto, que además aparecerá junto a tus anuncios publicados y en tu perfil visible!</p>
            <p class="textct">Hace click en el botón de abajo para enviar tu petición. Verificaremos que cumplas con <a href="guias/requisitos.php" target="_blank">los requisitos para ser CriptoTop</a> y te enviaremos un correo para informarte si tu solicitud fue aprobada o rechazada.</p>
            <form action="" method="POST">
                <input type="hidden" name="id" value="<?php echo filter_var($_SESSION['id'] , FILTER_SANITIZE_NUMBER_INT);?>">
                <input type="hidden" name="nombre" value="<?php echo filter_var($_SESSION['nombre'] , FILTER_SANITIZE_STRING);?>">
                <input type="hidden" name="usuario" value="<?php echo filter_var($_SESSION['usuario'] , FILTER_SANITIZE_STRING);?>">
                <input type="hidden" name="correo" value="<?php echo filter_var($_SESSION['correo'] , FILTER_SANITIZE_EMAIL);?>">
                <?php
                include_once 'admin/php/connect.php';
                $consult = ("SELECT solicitud FROM criptotop WHERE usuariosol='".$_SESSION['usuario']."' AND estado='enviada'");
                $result = mysqli_query($connect, $consult);
                $row = mysqli_fetch_array($result);
                $cons = ("SELECT solicitud FROM criptotop WHERE usuariosol='".$_SESSION['usuario']."' AND estado='rechazada'");
                $res = mysqli_query($connect, $cons);
                $r = mysqli_fetch_array($res);
                if(!isset($row) || $row['solicitud'] == filter_var('0' , FILTER_SANITIZE_NUMBER_INT)){
                ?>
                <input type="submit" class="sendctsrequest" name="sendctsrequest" id="sendctsrequest" value="Solicitar rango CriptoTop">
                <?php
                }else if(isset($row) && $row['solicitud'] != filter_var('0' , FILTER_SANITIZE_NUMBER_INT)){
                ?>
                <button type="submit" class="sendctsrequest env"><i class="fas fa-sync fa-spin fa-fw"></i> Solicitud enviada</button>
                <?php
                }
                ?>
                <?php
                if(isset($r) && $r['solicitud'] != filter_var('0' , FILTER_SANITIZE_NUMBER_INT)){
                ?>
                <p class="textct">Una de tus solicitudes previas fue rechazada: por favor verificá que cumplas los requisitos antes de enviar una nueva solicitud.</p>
                <?php
                }
                ?>
            </form>
            <?php
            function secure($value){
                include 'admin/php/connect.php';
                $value = trim($value);
                $value = stripslashes($value);
                $value = htmlspecialchars($value);
                $value = mysqli_real_escape_string($connect, $value);
                return $value;
            }
            include_once 'admin/php/connect.php';
            if(isset($_POST['sendctsrequest'])){
                $idsol = secure($_POST['id']);
                $nombresol = secure($_POST['nombre']);
                $usuariosol = secure($_POST['usuario']);
                $correosol = secure($_POST['correo']);
                $estado = "enviada";
                $query = "INSERT INTO criptotop(idsol, nombresol, usuariosol, correosol, estado, fecha)
                VALUES('$idsol', '$nombresol', '$usuariosol', '$correosol', '$estado', now())";
                $send = mysqli_query($connect, $query);
                    if($send){
                        echo '<script type="text/javascript">';
                        echo 'setTimeout(function () {';
                        echo 'swal("¡Solicitud enviada!","Verificaremos que cumplas los requisitos para ser CriptoTop y te enviaremos un mail con el resultado.","success").then( function(val) {';
                        echo 'if (val == true) window.location.href = \'https://librecripto.com/criptotop?user='.$_SESSION['user'].'\';';
                        echo '});';
                        echo '}, 200);  </script>';
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
        $mail->AddAddress('librecripto@librecripto.com');
        $mail->AddReplyTo('info@librecripto.com','info-noreply');

        $mail->Subject = "Nueva solicitud CriptoTop recibida";
        $mensajeHtml = nl2br($mensaje);
        $mail->Body = "
         <html>

         <body>

         <h3>Se acaba de recibir una nueva solicitud desde la sección de solicitudes CriptoTop de LibreCripto.</h3>
                                                
                        <p>Enviada por: '$nombresol'</p>
                        <p>Usuario: '$usuariosol'</p>
                        <p>Correo: '$correosol'</p>
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
                        exit();
                    }else{
                        echo '<script type="text/javascript">';
                        echo 'setTimeout(function () {';
                        echo 'swal("¡Ups!","Algo salió mal, por favor intentá enviar tu mensaje nuevamente.","error").then( function(val) {';
                        echo 'if (val == true) window.location.href = \'https://librecripto.com/criptotop?user='.$_SESSION['user'].'\';';
                        echo '});';
                        echo '}, 200);  </script>';
                    }
            }
            ?>
        </div>
    </main>
<?php include_once 'includes/templates/footer.php'; ?>