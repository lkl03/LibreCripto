<?php
    session_start();
    include 'conexion_be.php';
    $outgoing_id = $_SESSION['user'];
    $sql = "SELECT * FROM usuarios WHERE user = {$outgoing_id}  ORDER BY user DESC";
    $query = mysqli_query($conexion, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "No users are available to chat";
    }elseif(mysqli_num_rows($query) > 0){
        include 'datalisting.php';
    }
    echo $out;
?>