<?php 
    session_start();
$title = "Formularios de contacto | LibreCripto";
    include_once 'includes/templates/headeraccess.php';  
?>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
</head>

    <main>
        <section class="seccion2 BackNar">
            <h2 class="titleAccount">Formularios</h2>
        </section>
        <div class="seccion2 contenedor">
            <p class="textPage">Contactanos completando el siguiente formulario ;)</p>
        </div>
        <div class="contenedor__login-register forms">
                        <form action="" method="POST" class="formulario__register forms">
                            <!--<h2>Contactanos</h2>-->
                            <div class="form-control">
                                <input type="text" placeholder="Nombre" pattern="[A-Za-z]{1,50}" autocomplete="off" maxlength="50" name="nombre" required>
                                <!--<span class="form-control__message">Solo tu nombre, no es necesario el apellido.</span>-->
                            </div>
                            <div class="form-control">
                                <input type="email" placeholder="Email" name="correo" maxlength="100" required>
                                <!--<span class="form-control__message">Asegurate de tener acceso a este correo.</span>-->
                            </div>
                            <!--<div class="form-control">
                                <input type="text" placeholder="Teléfono (opcional)" required>
                                <span class="form-control__message">Recordá incluir el código de área, por ej: 011-1111-1111</span>
                            </div>-->
                            <div class="select forms">
                                <label for="selectconsult">Motivo del contacto</label>
                                <select name="selectconsult" id="selectconsult" onchange="showInp(); showLog();" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="1">Sugerencias</option>
                                    <option value="2">Empleo</option>
                                    <option value="3">Problemas con tu cuenta</option>
                                    <option value="4">Problemas con usuarios</option>
                                </select>
                                <script type="text/javascript">
                                    function showLog(){
                                        var consult = document.getElementById('selectconsult');
                                        var consultselected = consult.options[consult.selectedIndex].text;
                                        document.getElementById("consultselected").value = consultselected;
                                        console.log(consultselected);
                                    }
                                </script>
                                <input type="hidden" id="consultselected" name="consultselected" value=" "></input>
                                <input id="username" type="text" name="username" autocomplete="off" placeholder="¿Cuál es tu nombre de usuario?" style="display: none"/>
                                <input id="pusername" type="text" name="pusername" autocomplete="off" placeholder="¿Cuál es el nombre de usuario con el cual tuviste un problema?" style="display: none"/>
                                <script type="text/javascript">
                                    function showInp(){
                                        var getSelectValue = document.getElementById("selectconsult").value;
                                        
                                        switch (getSelectValue) {
                                            case "1": 
                                            document.getElementById("username").style.display = "none";
                                            document.getElementById("pusername").style.display = "none";
                                            document.getElementById("username").removeAttribute("required", "required");
                                            document.getElementById("pusername").removeAttribute("required", "required");
                                            break;

                                            case "2": 
                                            document.getElementById("username").style.display = "none";
                                            document.getElementById("pusername").style.display = "none";
                                            document.getElementById("username").removeAttribute("required", "required");
                                            document.getElementById("pusername").removeAttribute("required", "required");
                                            break;

                                            case "3":
                                            document.getElementById("username").style.display = "inline-block";
                                            document.getElementById("username").setAttribute("required", "required");
                                            document.getElementById("pusername").style.display = "none"; 
                                            document.getElementById("pusername").removeAttribute("required", "required");
                                            break;
                                            
                                            case "4":
                                            document.getElementById("username").style.display = "inline-block";
                                            document.getElementById("username").setAttribute("required", "required");
                                            document.getElementById("pusername").style.display = "inline-block"; 
                                            document.getElementById("pusername").setAttribute("required", "required");
                                            break;
                                        }
                                    }
                                </script>
                            </div>
                            <textarea name="mensaje" id="qualifycomment" onKeyu maxlength="2000" required placeholder="Tu mensaje (máximo 2000 caracteres)"></textarea>
                            <span class="contador" id="contador">2000</span>
                            <script type="text/javascript">
                                var limit = 2000;
                                $(function() {
                                    $("#qualifycomment").on("input", function () {
                                        var init = $(this).val().length;
                                        total_characters = (limit - init);

                                        $('#contador').html(total_characters);
                                    });
                                });
                            </script>
                            <button class="Registrarse forms" name="sendconsult">Enviar mensaje</button>
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
                            if(isset($_POST['sendconsult'])){
                                $nombre = secure($_POST['nombre']);
                                $correo = secure($_POST['correo']);
                                //$telefono = empty($_POST['telefono']) ? NULL : secure($_POST['telefono']);
                                $motivo = secure($_POST['consultselected']);
                                $username = empty($_POST['username']) ? NULL : secure($_POST['username']);
                                $userproblem = empty($_POST['pusername']) ? NULL : secure($_POST['pusername']);
                                $mensaje = secure($_POST['mensaje']);
                                if(!empty($_POST['nombre']) && !empty($_POST['correo']) && !empty($_POST['mensaje'])){
                                    $query = "INSERT INTO contactos(fechacontacto, nombre, correo, motivo, username, userproblem, mensaje)
                                    VALUES(now(), '$nombre', '$correo', '$motivo', '$username', '$userproblem', '$mensaje')";
                                    $send = mysqli_query($connect, $query);
                                    if($send){
                                        echo '<script type="text/javascript">';
                                        echo 'setTimeout(function () {';
                                        echo 'swal("¡Mensaje enviado!","Responderemos a la brevedad a la casilla de correo indicada.","success").then( function(val) {';
                                        echo 'if (val == true) window.location.href = \'index.php\';';
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
        $mail->AddAddress('contacto@librecripto.com');
        $mail->AddReplyTo('info@librecripto.com','info-noreply');

        $mail->Subject = "Nueva consulta recibida";
        $mensajeHtml = nl2br($mensaje);
        $mail->Body = "
         <html>

         <body>

         <h3>Se acaba de recibir una nueva consulta desde la sección de formularios de contacto de LibreCripto.</h3>
                                                
                                        <p>Enviada por: $nombre</p>
                                        <p>Correo: $correo</p>
                                        <p>Motivo del mensaje: $motivo</p>
                                        <p>Usuario: $username</p>
                                        <p>Usuario con el que denuncia hubo un problema: $userproblem</p>
                                        <p>Mensaje: $mensaje</p>'
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
                                        echo 'if (val == true) window.location.href = \'https://librecripto.com/forms\';';
                                        echo '});';
                                        echo '}, 200);  </script>';
                                    }
                                }else{
                                    echo '<script type="text/javascript">';
                                    echo 'setTimeout(function () {';
                                    echo 'swal("¡Ups!","Parece que hay campos vacíos en tu formulario, por favor intentá nuevamente.","warning").then( function(val) {';
                                    echo 'if (val == true) window.location.href = \'https://librecripto.com/forms\';';
                                    echo '});';
                                    echo '}, 200);  </script>';
                                }
                            }
                            ?>
                        </form>
                    </div>
    </main>
<?php include_once 'includes/templates/footer.php'; ?>