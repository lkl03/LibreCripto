<?php 

    session_start();
    include 'connect.php';
    $status = "Offline";
    $sql = mysqli_query($connect, "UPDATE usuarios SET status = '$status' WHERE id='".$_SESSION['id']."'");
    if($sql){
        session_destroy();
        header("location: ../login.php");
    }
?>