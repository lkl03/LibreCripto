<?php 

    session_start();
    include 'conexion_be.php';
    $status = "Offline";
    $sql = mysqli_query($conexion, "UPDATE usuarios SET status = '$status' WHERE id='".$_SESSION['id']."'");
    if($sql){
        session_destroy();
        header("location: https://librecripto.com/acceso");
    }
?>