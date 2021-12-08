<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</head>

<?php

session_start();

    if(!isset($_SESSION['user'])){
        include_once 'includes/templates/headeraccess.php';
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () {';
        echo 'swal("Ups!","Debes iniciar sesión para estar aquí.","warning").then( function(val) {';
        echo 'if (val == true) window.location.href = \'acceso.php\';';
        echo '});';
        echo '}, 200);  </script>';
        session_destroy();
        die();
    }else{
        include_once 'includes/templates/headeraccess.php';
    }
?>

<?php 
        function secure($value){
            include 'php/conexion_be.php';
            $value = trim($value);
            $value = stripslashes($value);
            $value = htmlspecialchars($value);
            $value = mysqli_real_escape_string($conexion, $value);
            return $value;
        }

include_once 'php/conexion_be.php';

if(isset($_POST['codigo'])) {
    $codigoverif = secure($_POST['codigoverif']);

    $consultusuario = mysqli_query($conexion,"SELECT codeverif FROM usuarios WHERE usuario = $_SESSION['usuario']");
    $row = mysqli_fetch_array($consultusuario);

    if($row['codigoverif'] == $codigoverif) {
        echo "Felicidades, email verificado";
        $sql = mysqli_query($conexion, "UPDATE usuarios SET confirmedemail = '1' WHERE usuario = $_SESSION['usuario']");
    }else {
        echo "El codigo no coincide";
    } 
    mysqli_close($conexion);
}
?>
<form action="" method="POST">
    <div>
        <input type="text" placeholder="Codigo de seguridad" name="codigoverif" required>
        <input type="submit" value="Confirmar email" name="codigo">
    </div>
</form>