<?php
session_start();
require_once 'php/conexionverify.php';

?>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
</head>

<?php
$title = "Mi Perfil | LibreCripto";


    if(!isset($_SESSION['user'])){
        include_once 'includes/templates/headeraccess.php';
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () {';
        echo 'swal("Ups!","Debes iniciar sesión para estar aquí.","warning").then( function(val) {';
        echo 'if (val == true) window.location.href = \'https://librecripto.com/acceso\';';
        echo '});';
        echo '}, 200);  </script>';
        session_destroy();
        die();
    }else{
        include_once 'includes/templates/headerlogged.php';
    }

    include 'php/conexion_be.php';
    
    if(isset($_GET['user'])){
        $user = filter_var($_GET['user'], (FILTER_SANITIZE_NUMBER_INT));

        $myuser = mysqli_query($conexion, "SELECT * FROM usuarios WHERE user = '".mysqli_real_escape_string($conexion, $user)."' ");
        $use = mysqli_fetch_array($myuser);
        $myuserop = mysqli_query($conexion, "SELECT * FROM operaciones WHERE usersending = '".mysqli_real_escape_string($conexion, $user)."' ORDER BY operationid DESC");
        $useop = mysqli_fetch_array($myuserop);

        if($_SESSION['user'] != $user) {
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () {';
        echo 'swal("Ups!","No deberías estar en esta página","error").then( function(val) {';
        echo 'if (val == true) window.location.href = \'https://librecripto.com\';';
        echo '});';
        echo '}, 200);  </script>';
        exit();
        }
    }

?>
    <main class= "spanorange">
        <section class="seccion2 BackNar">
            <h2 class="titleAccount">Mi Cuenta</h2>
        </section>
        <section class= "seccion contenedor home">
            <div class="usershowleftpanel">
                <div class="usershowbox">
                    <div class="usershowpic">
                        <img class="profpicshow" src="img/profilepics/<?php echo filter_var($use['avatar'] , FILTER_SANITIZE_STRING);?>" alt="avatar">
                    </div>
                    <div>
                        <h3 class="usertitle"><span>@</span><?php echo filter_var($use['usuario'] , FILTER_SANITIZE_STRING);?></h3>
                    </div>
                    <?php 
                        if($use['criptotop'] != filter_var('0', FILTER_SANITIZE_NUMBER_INT)) {?>
                            <div class="criptotopmedalshow">
                                <img class="criptotopmedal" src= "img/criptotopmedal.png" alt="Usuario Cripto Top"></img>
                            </div>
                    <?php } ?>
                </div>
            </div>

            <div class="usershowrightpanel">
                <h3 class="userstatstitle">Mis estadísticas</h3>
                <div class="statsBox">
                    <ul class="userstats">
                        <?php 
                        $fechareg = $use['fecha_reg'];
                        if($useop != null){
                            $fechaop = $useop['fecha_qualify'];
                        }
                        require 'php/Carbon/autoload.php';
                        use Carbon\Carbon;
                        use Carbon\CarbonInterval;
                        use Carbon\CarbonInterface;
                        $now = Carbon::now(new DateTimeZone('America/Argentina/Buenos_Aires'));
                        $date = Carbon::create($fechareg, 'America/Argentina/Buenos_Aires');
                        $date->locale('es');
                        if($useop != null){
                            $dateop = Carbon::create($fechaop, 'America/Argentina/Buenos_Aires');
                            $dateop->locale('es');
                            $diffop = $dateop->diffForHumans($now, CarbonInterface::DIFF_RELATIVE_TO_NOW);
                        }
                        $diff = $date->diffForHumans($now, CarbonInterface::DIFF_ABSOLUTE, false, 2);
                        ?>
                        <li>Registrado desde el <span><?php echo ($date->locale('es')->dayName);?> <?php echo ($date->locale('es')->day);?> de <?php echo ($date->locale('es')->monthName);?> de <?php echo ($date->locale('es')->year);?></span>
                        <li>Operaciones concretadas: <span><?php echo $use['operations'];?></span></li>
                        <li>Última operación: 
                        <span>
                        <?php
                        if($useop == null){
                            echo '¡Todavía no hiciste ninguna operación!';
                        }else{
                            echo $diffop;
                        };
                        ?>
                        </span></li>
                        <?php
                        $pmqual = mysqli_query($conexion, "SELECT AVG(opqualify) as average_rating FROM operaciones WHERE usersending = '$user' AND opverif ='1' AND opstatus ='Confirmed and qualified' ORDER BY operationid");
                        $prom = mysqli_fetch_assoc($pmqual);
                        ?>
                        <li>Calificación promedio: 
                            <span>
                            <?php 
                            if($useop == null){
                            echo 'N/A';
                            }else{
                            echo round($prom['average_rating'], 2);};?> <i class="fa fa-star qualstar" aria-hidden="true"></i>
                            </span></li>
                        <li>Últimas 5 calificaciones:
                        <?php
                            $consult = mysqli_query($conexion, "SELECT * FROM operaciones WHERE usersending = '$user' AND opverif ='1' AND opstatus ='Confirmed and qualified' ORDER BY operationid ASC LIMIT 5");
                            if($useop == null){
                                echo '<span>N/A</span>';
                            }else{
                            while($lista = mysqli_fetch_array($consult)){
                                    $listqual= $lista['opqualify'];
                        ?>
                         <span>
                             <?php echo $listqual;?> <i class="fa fa-star qualstar" aria-hidden="true"></i> - <?php }};?></span></li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="seccion3 contenedor">
            <div class="usereditprofilegoto">
                <a href="https://librecripto.com/editprofile?user=<?php echo filter_var($_SESSION['user'] , FILTER_SANITIZE_NUMBER_INT);?>">Editar perfil</a>
            </div>
        </section>
    </main>
<?php include_once 'includes/templates/footer.php'; ?>