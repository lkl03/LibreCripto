<?php
session_start();
?>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/starstyle.css">
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="js/jquery.rating.pack.js"></script>
    <script>
    $(document).ready(function(){
        $('input.star').rating();
    });
    </script>
</head>
<?php 
$title = "Calificar operación | LibreCripto";
include 'php/conexion_be.php';
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
    if(isset($_GET['user']) AND isset($_GET['operationid'])){
        include_once 'includes/templates/headercalificar.php';
    
        $user = filter_var($_GET['user'], (FILTER_SANITIZE_NUMBER_INT));
        $opconsult = ("SELECT usuarios.*, operaciones.* FROM usuarios INNER JOIN operaciones ON usuarios.user = operaciones.usertoconfirm WHERE usertoconfirm='".mysqli_real_escape_string($conexion, $user)."' ORDER BY operationid DESC");
    
        $op = mysqli_query($conexion, $opconsult);
        $row = mysqli_fetch_array($op);
        $opid = filter_var($row['operationid'] , FILTER_SANITIZE_NUMBER_INT) ?? NULL;
        $usid = filter_var($row['usersending'] , FILTER_SANITIZE_NUMBER_INT) ?? NULL;
        $usus = filter_var($row['usuariosending'], FILTER_SANITIZE_STRING) ?? NULL;
        $idan = filter_var($row['id_pub'] , FILTER_SANITIZE_NUMBER_INT) ?? NULL;
        $opsconsult = ("SELECT usuarios.*, operaciones.* FROM usuarios INNER JOIN operaciones ON usuarios.user = operaciones.usersending WHERE usersending='".mysqli_real_escape_string($conexion, $usid)."' ORDER BY operationid DESC");
        $ops = mysqli_query($conexion, $opsconsult);
        $rows = mysqli_fetch_array($ops);
        $uscr = filter_var($rows['correo'] , FILTER_SANITIZE_EMAIL) ?? NULL;
        $usnm = filter_var($rows['nombre'] , FILTER_SANITIZE_STRING) ?? NULL;
    }
}
$thisuser = $_SESSION['user'];
$opconsult = ("SELECT usuariosending, opverif, operationid FROM operaciones WHERE usertoconfirm='".mysqli_real_escape_string($conexion, $thisuser)."' ORDER BY operationid DESC");
$opresult = mysqli_query($conexion, $opconsult);
$oprow = mysqli_fetch_array($opresult);
    if($oprow == null){
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () {';
        echo 'swal("Ups!","No deberías estar en esta página","error").then( function(val) {';
        echo 'if (val == true) window.location.href = \'https://librecripto.com/registro\';';
        echo '});';
        echo '}, 200);  </script>';
        session_destroy();
        die();
    }else{
        if($oprow['opverif'] == filter_var('1' , FILTER_SANITIZE_NUMBER_INT)){
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () {';
        echo 'swal("¡Ups!","Parece que ya calificaste a este usuario...","error", {button: "Volver",}).then( function(val) {';
        echo 'if (val == true) window.location.href = \'https://librecripto.com/myoperations?user='.$_SESSION['user'].'\';';
        echo '});';
        echo '}, 200);  </script>';
        die();
        }else{
?>
<main>
<section class="seccion2 contenedor">
        <div class="qualifyform">
            <h3 class="qualifytitle">¿Cómo calificás a <span>@<?php echo $row['usuariosending']?></span>?</h3>
            <form action="" method="post">
                <div class="star_content">
                    <input name="rate" value="1" type="radio" class="star"/> 
                    <input name="rate" value="2" type="radio" class="star"/> 
                    <input name="rate" value="3" type="radio" class="star"/> 
                    <input name="rate" value="4" type="radio" class="star"/> 
                    <input name="rate" value="5" type="radio" class="star"/>
                </div>
                <h3 class="qualifytitle">¿Te gustaría dejar una breve reseña?</h3>
                <textarea name="qualifycomment" id="qualifycomment" onKeyu maxlength="160" placeholder="¿Qué te pareció la atención de @<?php echo $row['usuariosending']?>? (Máximo 160 caracteres)"></textarea>
                <span class="contador" id="contador">160</span>
                <script type="text/javascript">
                    var limit = 160;
                    $(function() {
                        $("#qualifycomment").on("input", function () {
                            //al cambiar el texto del txt_detalle
                            var init = $(this).val().length;
                            total_characters = (limit - init);

                            $('#contador').html(total_characters);
                        });
                    });
                </script>
        </div>
            <input type="submit" name="submitRatingStar" id="qualifysubmit" class="btn-submit" value="Enviar"></input>
            </form>
        <?php
                if (isset($_POST['submitRatingStar'])) {
                    $opqualify = $_POST['rate'];
                    $opmsg = $_POST['qualifycomment'];
                    $status = "Confirmed and qualified";
                    $query = mysqli_query($conexion, "UPDATE operaciones SET opstatus ='".mysqli_real_escape_string($conexion, $status)."', opverif='1', opqualify = '".mysqli_real_escape_string($conexion, $opqualify)."', opmsg = '".mysqli_real_escape_string($conexion, $opmsg)."', fecha_qualify= now() WHERE usertoconfirm= '".mysqli_real_escape_string($conexion, $thisuser)."' AND operationid= '".mysqli_real_escape_string($conexion, $opid)."' AND opverif='0'");

                    if($query){
                        echo '<script type="text/javascript">';
                        echo 'setTimeout(function () {';
                        echo 'swal("¡Éxito!","Completaste tu operación con @'.$row['usuariosending'].'. ¡Gracias por tu calificación!","success", {button: "Continuar",}).then( function(val) {';
                        echo 'if (val == true) window.location.href = \'https://librecripto.com/myoperations?user='.$_SESSION['user'].'\';';
                        echo '});';
                        echo '}, 200);  </script>';
                        $sql = mysqli_query($conexion, "UPDATE usuarios SET operations = operations+1 WHERE user= '".mysqli_real_escape_string($conexion, $usid)."'");
                        $delan = mysqli_query($conexion, "DELETE FROM anuncios WHERE id_pub= '".mysqli_real_escape_string($conexion, $idan)."' AND user='".mysqli_real_escape_string($conexion, $usid)."'");
                        $delch = mysqli_query($conexion, "DELETE FROM chats WHERE incoming_msg_id= '".mysqli_real_escape_string($conexion, $usid)."' AND outgoing_msg_id='".mysqli_real_escape_string($conexion, $user)."'");
                        $delmsg = mysqli_query($conexion, "DELETE FROM messages WHERE (incoming_msg_id = '".mysqli_real_escape_string($conexion, $usid)."' OR outgoing_msg_id = '".mysqli_real_escape_string($conexion, $usid)."') AND (outgoing_msg_id = '".mysqli_real_escape_string($conexion, $user)."' OR incoming_msg_id = '".mysqli_real_escape_string($conexion, $user)."')");
$usuario = filter_var($_SESSION['usuario'], FILTER_SANITIZE_STRING);
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
        $mail->AddAddress($uscr);
        $mail->AddReplyTo('no-reply@librecripto.com','no-reply');

        $mail->Subject = "¡Recibiste una calificación!";
        $mensajeHtml = nl2br($mensaje);
        $mail->Body = "
         <html>

         <body>

         <h3>¡Hola, @$usus!</h3>
                                
                        <p>¡<b>@$usuario</b> acaba de calificarte!</p>
                        <p>Visitá tu sección de 'Mis operaciones' y vas a poder el puntaje y la reseña recibida. </p>
                        <p>Recordá que el anuncio que seleccionaste para la operación ha sido dado de baja, y tu chat con @$usuario fue cerrado.</p>
                            
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
                        exit();
                    }else{
                        echo '<script type="text/javascript">';
                        echo 'setTimeout(function () {';
                        echo 'swal("Algo salió mal...","No se pudo procesar tu calificacion. Por favor, intentá de nuevo.","error").then( function(val) {';
                        echo 'if (val == true) window.location.href = \'https://librecripto.com/calificar?user='.$_SESSION['user'].'&operationid='.$row['operationid'].'\';';
                        echo '});';
                        echo '}, 200);  </script>';
                    }
                    echo '<div class="alert alert-success">Rating recibido: <strong>'.$_POST['rate'].'</strong>.</div>';
                }
            }
        }
        ?>
</section>