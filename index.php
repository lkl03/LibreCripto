<?php 
    session_start();    
?>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
</head>

<?php
$title = "LibreCripto";
    if(!isset($_SESSION['user'])){
        include_once 'includes/templates/indexlogout.php';
        exit();   
    }else{
        include 'php/conexion_be.php';
        $consult = ("SELECT confirmedemail FROM usuarios WHERE user='".filter_var($_SESSION['user'] , FILTER_SANITIZE_NUMBER_INT)."'");
        $result = mysqli_query($conexion, $consult);
        $row = mysqli_fetch_array($result);
        if($row['confirmedemail'] == filter_var('0', FILTER_SANITIZE_NUMBER_INT)){        
            include_once 'includes/templates/headeraccess.php';   
            echo '<script type="text/javascript">';
            echo 'setTimeout(function () {';
            echo 'swal("¡Un paso más!","Por favor verificá tu correo para poder acceder","warning", {button: "Verificar",}).then( function(val) {';
            echo 'if (val == true) window.location.href = \'https://librecripto.com/verificacion\';';
            echo '});';
            echo '}, 200);  </script>';
            exit();
        }else{
            include_once 'includes/templates/indexlogged.php';
        }
    }
    mysqli_close($conexion);
?>