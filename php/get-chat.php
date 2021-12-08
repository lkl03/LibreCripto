<?php 
    require 'Carbon/autoload.php';
    use Carbon\Carbon;
    use Carbon\CarbonInterval;
    use Carbon\CarbonInterface;
    session_start();
    if(isset($_SESSION['user'])){
        include 'conexion_be.php';
        $outgoing_id = $_SESSION['user'];
        $incoming_id = mysqli_real_escape_string($conexion, $_POST['incoming_id']);
        $output = "";
        $sql = "SELECT * FROM messages LEFT JOIN usuarios ON usuarios.user = messages.outgoing_msg_id
                WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
        $query = mysqli_query($conexion, $sql);
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                if($row['outgoing_msg_id'] === $outgoing_id){
                    $msgdate = $row['msgdate'];
                    $now = Carbon::now(new DateTimeZone('America/Argentina/Buenos_Aires'));
                    $date = Carbon::create($msgdate, 'America/Argentina/Buenos_Aires');
                    $date->locale('es');
                    $diff = $date->diffForHumans($now, CarbonInterface::DIFF_RELATIVE_TO_NOW);
                    $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'. $row['msg'] .'</p>
                                    
                                </div>
                                <p class="date">'.$diff.'</p>
                                </div>';
                }else{
                    $fmsgdate = $row['msgdate'];
                    $fnow = Carbon::now(new DateTimeZone('America/Argentina/Buenos_Aires'));
                    $fdate = Carbon::create($fmsgdate, 'America/Argentina/Buenos_Aires');
                    $fdate->locale('es');
                    $fdiff = $fdate->diffForHumans($fnow, CarbonInterface::DIFF_RELATIVE_TO_NOW);
                    $output .= '<div class="chat incoming">
                                <img src="img/profilepics/'. $row['avatar'] .'" alt="">
                                <div class="details">
                                    <p>'. $row['msg'] .'</p>
                                    
                                </div>
                                </div>
                                <p class="incdate">'.$fdiff.'</p>
                                ';
                }
            }
        }else{
            $output .= '<div class="text">Todavía no hay ningún mensaje por acá...</div>';
        }
        echo $output;
    }else{
        header("location: ../index.php");
    }

?>