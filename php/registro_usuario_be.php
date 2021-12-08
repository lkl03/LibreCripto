<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="../css/main.css">
</head>

<?php
    function secure($value){
        include 'conexion_be.php';
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        $value = mysqli_real_escape_string($conexion, $value);
        return $value;
    }

    include_once 'conexion_be.php';

    $nombre = secure($_POST['nombre']);
    $usuario = secure($_POST['usuario']);
    $correo = secure($_POST['correo']);
    $telefono = secure($_POST['telefono']);
    $pass = secure($_POST['pass']);
    //Encriptado de contraseña
    $pass = hash('sha512', $pass);
    $random = md5(rand(0,1000));
    $user= rand(time(), 100000000);
    $status = "Registrado";
    if(!empty($_POST['nombre']) && !empty($_POST['usuario']) && !empty($_POST['correo']) && !empty($_POST['pass'])){    
        $query = "INSERT INTO usuarios(id, user, nombre, usuario, correo, telefono, pass, fecha_reg, avatar, codigoverif, status)
                    VALUES('id', '$user', '$nombre', '$usuario', '$correo', '$telefono', '$pass', now(), 'default.jpg', '$random', '$status')";


        //Verificar que el correo no se repita en la base de datos
        $verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo'");
        if(mysqli_num_rows($verificar_correo) > 0){
            echo '<script type="text/javascript">';
            echo 'setTimeout(function () {';
            echo 'swal("Este correo ya está registrado!","Por favor intentá con uno diferente.","error").then( function(val) {';
            echo 'if (val == true) window.location.href = \'../registro.php\';';
            echo '});';
            echo '}, 200);  </script>';
            exit();
        }

        //Verificar que el usuario no se repita en la base de datos
        $verificar_usuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario'");
        if(mysqli_num_rows($verificar_usuario) > 0){
            echo '<script type="text/javascript">';
            echo 'setTimeout(function () {';
            echo 'swal("Este usuario ya está registrado!","Por favor intentá con uno diferente.","error").then( function(val) {';
            echo 'if (val == true) window.location.href = \'../registro.php\';';
            echo '});';
            echo '}, 200);  </script>';
            exit();
        }

        $ejecutar = mysqli_query($conexion, $query);

        if($ejecutar){
            echo '<script type="text/javascript">';
            echo 'setTimeout(function () {';
            echo 'swal("¡Usuario registrado!","Ya podes iniciar sesión y verificar tu cuenta con el código que hemos enviado a tu correo para acceder a todas las funciones del sitio.","success").then( function(val) {';
            echo 'if (val == true) window.location.href = \'../registro.php\';';
            echo '});';
            echo '}, 200);  </script>';

            require 'src/Exception.php';
            require 'src/PHPMailer.php';
            require 'src/SMTP.php';
            
            $mail=new PHPMailer();
            $mail->CharSet = 'UTF-8';
            
            $body = '
    
            <h3>¡Hola, '.$nombre.'.!</h3>
            <p>Este es el código único para verificar tu cuenta.</p>
            
            <h3>'.$random.'</h3>
            
            <p>Para completar la verificación deberás iniciar sesión en nuestro sitio con tus datos de usuario y allí ingresar el código.
            Recordá que debes verificar tu cuenta para acceder a todas las funciones del sitio.</p>

            <p>¡Te esperamos! <b>-El equipo de LibreCripto.</b></p>';
            
            $mail->IsSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;
            $mail->SMTPDebug  = 0;
            $mail->SMTPAuth   = true;
            $mail->Username   = 'andgphdesign@gmail.com';
            $mail->Password   = 'oPHPzTglY9*1685t';
            $mail->SetFrom('andgphdesign@gmail.com', "Librecripto");
            $mail->AddReplyTo('no-reply@librecripto.com','no-reply');
            $mail->Subject    = 'Código único para verificación de cuenta';
            $mail->isHTML(true);
            $mail->MsgHTML($body);
            
            $mail->AddAddress(''.$correo.'', ''.$nombre.'');
            $mail->send();

        }else{
            echo '<script type="text/javascript">';
            echo 'setTimeout(function () {';
            echo 'swal("Algo salió mal...","No se pudo registrar tu usuario. Por favor intenta de nuevo.","error").then( function(val) {';
            echo 'if (val == true) window.location.href = \'../registro.php\';';
            echo '});';
            echo '}, 200);  </script>';
        }

        mysqli_close($conexion);
    }else{
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () {';
        echo 'swal("¡Ups!","Parece que hay campos vacíos en tu formulario, por favor intentá nuevamente.","warning").then( function(val) {';
        echo 'if (val == true) window.location.href = \'../registro.php\';';
        echo '});';
        echo '}, 200);  </script>';
        exit;
    }


?>
</main>