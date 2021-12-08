<?php 
    include 'get-chat.php';
    if(isset($_SESSION['user'])){
        include 'conexion_be.php';
        $outgoing_id = $_SESSION['user'];
        $incoming_id = mysqli_real_escape_string($conexion, $_POST['incoming_id']);
        $message = mysqli_real_escape_string($conexion, $_POST['message']);
        if(mysqli_num_rows($query) == 0){
            $sqli = mysqli_query($conexion, "INSERT INTO chats (incoming_msg_id, outgoing_msg_id, msgdate) 
            VALUES ({$incoming_id}, {$outgoing_id}, now())") or die();
        }
        if(!empty($message)){
            $following = mysqli_query($conexion, "SELECT chatid FROM chats WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id}) OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id})") or die();
            $fw = mysqli_fetch_assoc($following);
            $sqlib = mysqli_query($conexion, "INSERT INTO messages (chatid, incoming_msg_id, outgoing_msg_id, msg, msgdate)
                                        VALUES ({$fw['chatid']}, {$incoming_id}, {$outgoing_id}, '{$message}', now())") or die();
            $sqliupd = mysqli_query($conexion, "UPDATE chats SET msgdate = now() WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id}) OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id})") or die();
        }
    }else{
        header("location: ../index.php");
    }


    
?>