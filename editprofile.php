<?php
session_start();
require_once 'php/conexionverify.php';
?>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
</head>

<?php
$title = "Editar perfil | LibreCripto";
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
        include_once 'includes/templates/headeraccess.php';
    }

    include 'php/conexion_be.php';
    
    if(isset($_GET['user'])){
        $user = filter_var($_GET['user'], (FILTER_SANITIZE_NUMBER_INT));

        $myuser = mysqli_query($conexion, "SELECT * FROM usuarios WHERE user = '".mysqli_real_escape_string($conexion, $user)."' ");
        $use = mysqli_fetch_array($myuser);

        if($_SESSION['user'] != $user) {
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
        <section class= "seccion2 contenedor home">
        <div class="userdatafirstpanel">
                <h3 class="userfirsttitle">Personalizar</h3>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="userdataform">
                        <div>
                            <div class="userdatapic">
                                <label class="userdatapiclabel">Foto de perfil</label>
                                <img class="profpic" src="img/profilepics/<?php echo filter_var($use['avatar'] , FILTER_SANITIZE_STRING);?>" alt="avatar">
                                <input type="file" id="avatar" name="avatar"></input>
                                <label class="changepicbutton" for="avatar">Cambiar foto</label>
                            </div>
                        </div>
                        <div>
                            <div class="userdatainput">
                                <label for="nameInput">Nombre de Usuario</label>
                                <input type="text" name="usuario" id="nameInput" placeholder="Nombre de usuario" pattern="^[a-zA-Z0-9\_]{4,16}$" maxlength="16" value="<?php echo filter_var($use['usuario'] , FILTER_SANITIZE_STRING);?>">
                            </div>
                        </div>
                    </div>
                    <div class="userdatarefresh">
                        <input type="submit" value="Confirmar cambios" name="confirmar" id="submit1"></input>
                    </div>
                </form>
            </div>

            <?php
            if(isset($_POST['confirmar'])){
                function secure($value){
                    include 'php/conexion_be.php';
                    $value = trim($value);
                    $value = stripslashes($value);
                    $value = htmlspecialchars($value);
                    $value = mysqli_real_escape_string($conexion, $value);
                    return $value;
                }

                $usuario = secure($_POST['usuario']);

                $comprobation = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$usuario' AND user != '".mysqli_real_escape_string($conexion, $user)."'"));
                if(!empty($_POST['usuario']) || !empty($_POST['avatar'])){
                        if($comprobation == filter_var('0' , FILTER_SANITIZE_NUMBER_INT)){

                        $type = 'jpg';
                        $rfoto = $_FILES['avatar']['tmp_name'];
                        $tp = $_FILES['avatar']['type'];
                        $name = 'profilepic@'.$user.'.'.$type;
                        
                        if(is_uploaded_file($rfoto)){
                            if (!((strpos($tp, "jpeg") || strpos($tp, "jpg") || strpos($tp, "png")))){
                                echo '<script type="text/javascript">';
                                echo 'swal("Algo salió mal...","Solo se permiten archivos .JPG, .JPEG o .PNG. Por favor intentá de nuevo.","error")';
                                echo '</script>';
                            }else{
                                if(is_uploaded_file($rfoto)){
                                    $destino = 'img/profilepics/'.$name;
                                    $nombrea = $name;
                                    copy($rfoto, $destino);
                                }else{
                                    $nombrea = $use['avatar'];
                                }
        
                                $sql = mysqli_query($conexion, "UPDATE usuarios SET usuario = '$usuario', avatar= '$nombrea' WHERE user= '".mysqli_real_escape_string($conexion, $user)."'");
                                if($sql){
                                    echo '<script type="text/javascript">';
                                    echo 'setTimeout(function () {';
                                    echo 'swal("¡Datos actualizados exitosamente!","","success", {button: "Continuar",}).then( function(val) {';
                                    echo 'if (val == true) window.location.href = \'https://librecripto.com/editprofile?user='.$user.'\';';
                                    echo '});';
                                    echo '}, 200);  </script>';
                                }
                            }
                        }else{
                            $sqli = mysqli_query($conexion, "UPDATE usuarios SET usuario = '$usuario' WHERE user= '".mysqli_real_escape_string($conexion, $user)."'");
                            if($sqli){
                                echo '<script type="text/javascript">';
                                echo 'setTimeout(function () {';
                                echo 'swal("¡Datos actualizados exitosamente!","","success", {button: "Continuar",}).then( function(val) {';
                                echo 'if (val == true) window.location.href = \'https://librecripto.com/editprofile?user='.$user.'\';';
                                echo '});';
                                echo '}, 200);  </script>';
                            }
                        }        
                    }else {
                        echo '<script type="text/javascript">';
                        echo 'swal("Usuario ya registrado!","Por favor intentá con un nombre distinto","error")';
                        echo '</script>';
                    }
                }else{
                    echo '<script type="text/javascript">';
                    echo 'swal("Algo salió mal...","Revisá si algún campo quedó vacío e intentá de nuevo.","warning")';
                    echo '</script>';
                }
            }
            ?>

            <div class="userdatamiddlepanel">
                <h3 class="usermidtitle">Datos</h3>
                    <div>
                        <p class="userpasswordchangetext">Modificar información personal</p>
                        <div>
                            <div class="userdatainput">
                                <label for="nombreInput">Nombre</label>
                                <input type="text" name="nombre" id="nombreInput" placeholder="Nombre" value="<?php echo filter_var($use['nombre'] , FILTER_SANITIZE_STRING);?>" disabled>
                            </div>
                            <div class="userdatainput">
                                <label class="labelinfo">Email</label>
                                <input type="email" name="correo" id="emailInput" placeholder="Email" value="<?php echo filter_var($use['correo'] , FILTER_SANITIZE_EMAIL);?>" disabled>
                                <label for="emailInput" id="cambiaroverlay">Cambiar</label>
                                <div class="overlay" id="emailoverlay">
                                    <div class="publishannouncer" id="emailpublishannouncer">
                                        <a href="#" id="emailbtn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times"></i></a>
                                        <h3>Modificar email</h3>
                                        <form action="" method="post" id="formemail" enctype="multipart/form-data">
                                            <div class = "emailchanger">
                                                <input type="email" name="correo" id="emailInput" placeholder="Email" value="<?php echo filter_var($use['correo'] , FILTER_SANITIZE_EMAIL);?>">
                                            </div>
                                        <div class="userdatarefresh emailchange">
                                            <input type="submit" value="Modificar" name="modificarem"></input>
                                        </div>
                                        <?php
                                            if(isset($_POST['modificarem'])){
function secure($value){
                    include 'php/conexion_be.php';
                    $value = trim($value);
                    $value = stripslashes($value);
                    $value = htmlspecialchars($value);
                    $value = mysqli_real_escape_string($conexion, $value);
                    return $value;
                }
                                                $correo = secure($_POST ['correo']);
                                                $random = md5(rand(0,1000));
                                                if(!empty($_POST['correo'])){
                                                    $comprobationemail = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo = '$correo' AND user != '".mysqli_real_escape_string($conexion, $user)."'"));
                                                    if($comprobationemail == filter_var('0' , FILTER_SANITIZE_NUMBER_INT) && $correo != filter_var($use['correo'] , FILTER_SANITIZE_EMAIL)){
                                                        $sqlmail = mysqli_query($conexion, "UPDATE usuarios SET correo = '$correo', confirmedemail = '0', codigoverif = '".filter_var($random, FILTER_SANITIZE_NUMBER_INT)."', status = 'Cambió email' WHERE user= '".mysqli_real_escape_string($conexion, $user)."'");
                                                        if($sqlmail){
                                                            echo '<script type="text/javascript">';
                                                            echo 'setTimeout(function () {';
                                                            echo 'swal("¡Email actualizado!","Hemos enviado un correo a tu nueva dirección para que puedas verificar tu email. Por favor inicia sesión nuevamente y seguí los pasos indicados para completar la verificación. ","info", {button: "Continuar",}).then( function(val) {';
                                                            echo 'if (val == true) window.location.href = \'https://librecripto.com/registro\';';
                                                            echo '});';
                                                            echo '}, 200);  </script>';
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

        $mail->Subject = "Código único para verificación de nuevo correo electrónico";
        $mensajeHtml = nl2br($mensaje);
        $mail->Body = "
         <html>

         <body>

         <h3>¡Hola, $nombre!</h3> 
                                                            <p>Actualizaste tu correo electrónico. Con el siguiente código podrás verificar tu nueva dirección.</p>
                                                            
                                                            <h3>$random</h3>
                                                            
                                                            <p>Para completar la verificación deberás iniciar sesión en nuestro sitio con tus datos de usuario y allí ingresar el código.
                                                            Será necesario que verifiques tu nuevo correo para poder seguir accediendo a todas las funciones del sitio.</p>

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
                                                            session_destroy();
                                                        }
                                                    }else {
                                                        echo '<script type="text/javascript">';
                                                        echo 'swal("Email ya registrado!","Por favor intentá con un email diferente","error")';
                                                        echo '</script>';
                                                    }
                                                }else{
                                                    echo '<script type="text/javascript">';
                                                    echo 'swal("Algo salió mal...","Revisá si algún campo quedó vacío e intentá de nuevo.","warning")';
                                                    echo '</script>';
                                                }
                                                
                                            }
                                            ?>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="userdatainput">
                                <label class="labelinfo">Teléfono</label>
                                <input type="text" name="telefono" placeholder="No registrado" value="<?php echo filter_var($use['telefono'], FILTER_SANITIZE_STRING);?>" disabled>
                                <label for="phoneInput" id="cambiarphoneoverlay">Cambiar</label>
                                <div class="overlay" id="phoneoverlay">
                                    <div class="publishannouncer" id="phonepublishannouncer">
                                        <a href="#" id="phonebtn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times"></i></a>
                                        <h3>Modificar teléfono</h3>
                                        <form action="" method="post" id="formphone" enctype="multipart/form-data">
                                            <div class = "emailchanger">
                                                <input type="text" name="telefono" placeholder="No registrado" value="<?php echo filter_var($use['telefono'], FILTER_SANITIZE_STRING);?>" pattern="[0-9]+" title="¡Únicamente números del 1 al 9!">
                                            </div>
                                        
                                        <div class="userdatarefresh emailchange">
                                            <input type="submit" value="Modificar" name="modificartel"></input>
                                        </div>
                                        <?php
                                            if(isset($_POST['modificartel'])){
                                                $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
                                                if($telefono != filter_var($use['telefono'], FILTER_SANITIZE_STRING)){
                                                    $sqlphone = mysqli_query($conexion, "UPDATE usuarios SET telefono = '$telefono' WHERE user= '".mysqli_real_escape_string($conexion, $user)."'");
                                                    if($sqlphone){
                                                        echo '<script type="text/javascript">';
                                                        echo 'setTimeout(function () {';
                                                        echo 'swal("¡Teléfono actualizado exitosamente!","","success", {button: "Continuar",}).then( function(val) {';
                                                        echo 'if (val == true) window.location.href = \'https://librecripto.com/editprofile?user='.$user.'\';';
                                                        echo '});';
                                                        echo '}, 200);  </script>';
                                                    } else {
                                                    echo '<script type="text/javascript">';
                                                    echo 'swal("Algo salió mal...","No se pudo actualizar tu teléfono. Por favor intentá nuevamente.","error")';
                                                    echo '</script>';
                                                    }
                                                }else{
                                                    echo '<script type="text/javascript">';
                                                    echo 'swal("Algo salió mal...","No se pudo actualizar tu teléfono. Por favor intentá nuevamente.","error")';
                                                    echo '</script>';
                                                }
                                            }
                                        ?>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
            </div>



            <div class="userdatathirdpanel">
                <h3 class="userthirdtitle">Seguridad</h3>
                <form action="" method="post">

                    <?php 
                        if(isset($_POST['modificar'])){
                                $passActual = $_POST['passActual'];
                                $pass1 = $_POST['pass1'];
                                $pass2 = $_POST['pass2'];

                                $passActual = hash('sha512', $passActual);
                                $pass1 = hash('sha512', $pass1);
                                $pass2 = hash('sha512', $pass2);

                            if(!empty($_POST['passActual']) && !empty($_POST['pass1']) && !empty($_POST['pass2'])){


                                $sqlA = mysqli_query($conexion, "SELECT pass FROM usuarios WHERE user = '".mysqli_real_escape_string($conexion, $user)."'");
                                $rowA = mysqli_fetch_array($sqlA);

                                if($rowA['pass'] == $passActual) {

                                    if($pass1 == $pass2) {
                                            $update = mysqli_query($conexion, "UPDATE usuarios SET pass = '$pass1' WHERE user = '".mysqli_real_escape_string($conexion, $user)."'");
                                            if($update) {                     
                                                echo '<script type="text/javascript">';
                                                echo 'swal("¡Contraseña actualizada exitosamente!","Ya podés ingresar a tu cuenta utilizando tu nueva clave.","success")';
                                                echo '</script>';
                                        }
                                    }else {
                                        echo '<script type="text/javascript">';
                                        echo 'swal("Algo salió mal...","Las nuevas contraseñas no coinciden, intentá de nuevo.","warning")';
                                        echo '</script>';
                                    }
                                }else {
                                    echo '<script type="text/javascript">';
                                    echo 'swal("Algo salió mal...","La contraseña actual es incorrecta, intentá nuevamente.","warning")';
                                    echo '</script>';
                                }
                            }else{
                                echo '<script type="text/javascript">';
                                echo 'swal("Algo salió mal...","Revisá si algún campo quedó vacío e intentá de nuevo.","warning")';
                                echo '</script>';
                            }
                        }
                    ?>

                    <div>
                        <div>
                            <p class="userpasswordchangetext">Actualizar contraseña</p>
                            <div class="userdatainput">
                                <label for="passActual">Contraseña actual</label>
                                <div class="input-group">
                                    <input type="password" name="passActual" id="passActual" autocomplete="off">
                                    <div class="input-group-append">
                                        <button id="show_passwordActual" class="btn btn-primary" type="button" onclick="mostrarPasswordActual()"> <span class="fa fa-eye iconActual"></span> </button>
                                    </div>
                                </div>
                            </div>
                            <div class="userdatainput">
                                <label for="pass1">Nueva contraseña</label>
                                <div class="input-group">
                                    <input type="password" name="pass1" id="pass1" autocomplete="off">
                                    <div class="input-group-append">
                                        <button id="show_password1" class="btn btn-primary" type="button" onclick="mostrarPassword1()"> <span class="fa fa-eye icon1"></span> </button>
                                    </div>
                                </div> 
                            </div>
                            <div class="userdatainput">
                                <label for="pass2">Repetir contraseña nueva</label>
                                <div class="input-group">
                                <input type="password" name="pass2" id="pass2" autocomplete="off">
                                    <div class="input-group-append">
                                        <button id="show_password2" class="btn btn-primary" type="button" onclick="mostrarPassword2()"> <span class="fa fa-eye icon2"></span> </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="userdatarefresh" id="submit3">
                        <input type="submit" value="Modificar clave" name="modificar" id="submit3"></input>
                    </div>
                </form>
            </div>
        </section>
        <section class= "seccion2 contenedor">
            <div class="userprofilebackto">
                        <a href="https://librecripto.com/myprofile?user=<?php echo filter_var($_SESSION['user'] , FILTER_SANITIZE_NUMBER_INT);?>">Volver a Mi Cuenta</a>
            </div>
        </section>

    </main>

<?php include_once 'includes/templates/footereditprofile.php'; ?>