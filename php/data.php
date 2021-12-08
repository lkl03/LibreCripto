<?php
    require 'Carbon/autoload.php';
    use Carbon\Carbon;
    use Carbon\CarbonInterval;
    use Carbon\CarbonInterface;
    while($row = mysqli_fetch_assoc($query)){
        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['user']}
                OR outgoing_msg_id = {$row['user']}) AND (outgoing_msg_id = {$outgoing_id} 
                OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
        $query2 = mysqli_query($conexion, $sql2);
        if((mysqli_num_rows($query2) == 0)) {
            echo '¡Todavía no empezaste ningún chat!';
        }
        $row2 = mysqli_fetch_array($query2);
        ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
        ($outgoing_id == $row['id']) ? $hid_me = "hide" : $hid_me = "";
        $output = mysqli_query($conexion, "SELECT * FROM chats WHERE (incoming_msg_id = {$_SESSION['user']} OR outgoing_msg_id = {$_SESSION['user']}) ORDER BY msgdate DESC");
        while($out = mysqli_fetch_array($output)){ 
            if($out['incoming_msg_id'] == $_SESSION['user']){
                $var = $out['outgoing_msg_id'];
            }elseif($out['outgoing_msg_id'] == $_SESSION['user']){
                $var = $out['incoming_msg_id'];
            }
            $userx = mysqli_query($conexion, "SELECT * FROM usuarios WHERE user = '$var'");
            $usx = mysqli_fetch_array($userx);
            $chatx = mysqli_query($conexion, "SELECT * FROM messages WHERE chatid = {$out['chatid']} ORDER BY msg_id DESC");
            $chx = mysqli_fetch_array($chatx);
            (mysqli_num_rows($query2) > 0) ? $result = $chx['msg'] : $result ="No hay ningún mensaje disponible";
            (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
            if(isset($chx['outgoing_msg_id'])){
                ($outgoing_id == $chx['outgoing_msg_id']) ? $you = "Vos: " : $you = "";
            }else{
                $you = "";
            }
            $msgdate = $chx['msgdate'];
            $now = Carbon::now(new DateTimeZone('America/Argentina/Buenos_Aires'));
            $date = Carbon::create($msgdate, 'America/Argentina/Buenos_Aires');
            $date->locale('es');
            $diff = $date->diffForHumans($now, CarbonInterface::DIFF_RELATIVE_TO_NOW);
            echo '<a href="chat.php?user='. $usx['user'] .'">
            <div class="content">
            <img src="img/profilepics/'. $usx['avatar'] .'" alt="">
            <div class="details">
                <span>@'. $usx['usuario'].'</span>
                <p>'. $you . $result .'</p>
            </div>
            </div>
            <div class="status-dot">'.$diff.'</i></div>
        </a>';
    }
}
?>