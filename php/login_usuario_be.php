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
        session_start();

        include_once 'conexion_be.php';
        $correo = secure($_POST['correo']);
        $pass = secure($_POST['pass']);
        $pass = hash('sha512', $pass);
        $status = "Online";
        if(!empty($_POST['correo']) && !empty($_POST['pass'])){
            $validar_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo' and pass='$pass'");

            if(mysqli_num_rows($validar_login) > 0){
                while($row=mysqli_fetch_array($validar_login)){
                    if($correo = $row['correo'] && $pass = $row['pass']){
                        $_SESSION['correo'] = filter_var($row['correo'] , FILTER_SANITIZE_EMAIL);
                        $_SESSION['id'] = filter_var($row['id'] , FILTER_SANITIZE_NUMBER_INT);
                        $_SESSION['user'] = filter_var($row['user'] , FILTER_SANITIZE_NUMBER_INT);
                        $_SESSION['usuario'] = filter_var($row['usuario'] , FILTER_SANITIZE_STRING);
                        $_SESSION['avatar'] = filter_var($row['avatar'] , FILTER_SANITIZE_STRING);
                        $_SESSION['telefono'] = filter_var($row['telefono'] , FILTER_SANITIZE_STRING);
                        $_SESSION['pass'] = $row['pass'];
                        $_SESSION['nombre'] = filter_var($row['nombre'] , FILTER_SANITIZE_STRING);
                    }
                    $sql2 = mysqli_query($conexion, "UPDATE usuarios SET status = '$status' WHERE id='".$row['id']."'");
                }
                header("location: ../index.php");
                exit;
            }else{
                echo '<script type="text/javascript">';
                echo 'setTimeout(function () {';
                echo 'swal("Usuario no encontrado!","Por favor verifica los datos introducidos e intentá nuevamente.","error").then( function(val) {';
                echo 'if (val == true) window.location.href = \'../acceso.php\';';
                echo '});';
                echo '}, 200);  </script>';
            }
        }else{
            echo '<script type="text/javascript">';
            echo 'setTimeout(function () {';
            echo 'swal("¡Ups!","Parece que hay campos vacíos en tu formulario, por favor intentá nuevamente.","warning").then( function(val) {';
            echo 'if (val == true) window.location.href = \'../acceso.php\';';
            echo '});';
            echo '}, 200);  </script>';
            exit;
        }
    ?>