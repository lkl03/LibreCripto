<?php
session_start();
require_once 'php/conexionverify.php';

?>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/usersidebar.css">
</head>
<?php 
$title = "Mi Panel | LibreCripto";
include 'php/conexion_be.php';
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
    $thisuser = $_SESSION['user'];
    $opconsult = ("SELECT opverif FROM operaciones WHERE usertoconfirm='".mysqli_real_escape_string($conexion, $thisuser)."' ORDER BY operationid DESC");
    $opresult = mysqli_query($conexion, $opconsult);
    $oprow = mysqli_fetch_array($opresult);
        if($oprow == null){
            include 'includes/templates/headerlogged.php'; 
        }else{
            if($oprow['opverif'] == filter_var('0', FILTER_SANITIZE_NUMBER_INT)){
            include_once 'includes/templates/headerloggedop.php'; 
        }else{
            include 'includes/templates/headerlogged.php'; 
        }    
    }
}
 
if(isset($_GET['user'])){
    $user = filter_var($_GET['user'], (FILTER_SANITIZE_NUMBER_INT));

    $myuser = mysqli_query($conexion, "SELECT * FROM usuarios WHERE user = '".mysqli_real_escape_string($conexion, $user)."' ");
    $usef = mysqli_fetch_array($myuser);
    $myuserop = mysqli_query($conexion, "SELECT * FROM operaciones WHERE usersending = '".mysqli_real_escape_string($conexion, $user)."' AND opverif ='1' AND opstatus ='Confirmed and qualified' ORDER BY operationid DESC");
    $useop = mysqli_fetch_array($myuserop);


    if(filter_var($_SESSION['user'] , FILTER_SANITIZE_NUMBER_INT) != filter_var($user , FILTER_SANITIZE_NUMBER_INT)) {
    echo '<script type="text/javascript">';
    echo 'setTimeout(function () {';
    echo 'swal("Ups!","No deberías estar en esta página","error").then( function(val) {';
    echo 'if (val == true) window.location.href = \'https://librecripto.com/acceso\';';
    echo '});';
    echo '}, 200);  </script>';
    session_destroy();
    die();
    }
}
?>
<main class="spanorange">
<section class="seccion2 BackNar">
        <h2 class="titleAccount">Mi Panel</h2>
</section>
<div class="usersidebar">
        <div class="page-wrapper chiller-theme">
            <a id="show-sidebar" class="btn btn-sm btn-dark mya" href="#">
                <i class="fas fa-bars"></i>
            </a>
            <nav id="sidebar" class="sidebar-wrapper">
                <div class="sidebar-content">
                    <div class="sidebar-brand">
                        <div id="close-sidebar">
                        <i class="fas fa-times"></i>
                        </div>
                    </div>
                <!-- sidebar-menu  -->
                    <div class="sidebar-menu">
                        <ul>
                            <li class="header-menu">
                                <span>Mercado Cripto</span>
                            </li>
                            <li class="sidebar-dropdown">
                                <a href="https://librecripto.com/market">
                                <i i class="fa fa-exchange-alt"></i>
                                <span>Panel general</span>
                                </a>
                            </li>
                            <li class="sidebar-dropdown arrow active">
                                <a>
                                <i class="fa fa-user"></i>
                                <span onclick="window.location.href='https://librecripto.com/mydashboard?user=<?php echo $_SESSION['user'];?>'">Panel de Usuario</span>
                                </a>
                                <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                    <a href="https://librecripto.com/myannouncements?user=<?php echo filter_var($_SESSION['user'] , FILTER_SANITIZE_NUMBER_INT);?>">Mis Anuncios
                                    </a>
                                    </li>
                                    <li>
                                    <a href="https://librecripto.com/mychats?user=<?php echo filter_var($_SESSION['user'] , FILTER_SANITIZE_NUMBER_INT);?>">Mis Chats</a>
                                    </li>
                                    <li>
                                    <a href="https://librecripto.com/myoperations?user=<?php echo filter_var($_SESSION['user'] , FILTER_SANITIZE_NUMBER_INT);?>">Mis Operaciones</a>
                                    </li>
                                </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- sidebar-content  -->
            </nav>
        </div>
</div>
<section class="seccion2 contenedor home">
    <div class="mdanuncios">
        <h2 class="mdtitle">Mis anuncios</h2>
        <?php
            $consult = mysqli_query($conexion, "SELECT * FROM anuncios WHERE user = '".mysqli_real_escape_string($conexion, $user)."' ORDER BY id_pub DESC") ?? NULL;
        ?>
        <div class="publishmShow md">
            <?php
            while($lista = mysqli_fetch_array($consult)){
                    $userid = mysqli_real_escape_string($conexion, filter_var($lista['id'], FILTER_SANITIZE_NUMBER_INT));
                    $usuariob = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id = '".mysqli_real_escape_string($conexion, $userid)."'");
                    $use = mysqli_fetch_array($usuariob);
                    $idpub = mysqli_real_escape_string($conexion, $lista['id_pub']);
            ?>
                    <div class="publishContainer">
                        <div class="publish">
                            <div class="publishCInfo">
                                <?php $date = $lista['fecha']; ?>
                                <p class="publishCDate">Publicado el <?php echo date('d/m/Y', strtotime($date))?> a las <?php echo date('G:i', strtotime($date))?></p> 
                                <div class="publishCZone"><p class="publishCProv">En <?php echo filter_var($lista['provincia'] , FILTER_SANITIZE_STRING);?></p> <p class="publishCLoc"><?php echo filter_var($lista['localidad'] , FILTER_SANITIZE_STRING);?></p></div>
                            </div>
                            <div class="publishPDisplay">
                                <div class="publishCOffer">
                                    <p class="publishCQuantity"><?php echo $lista['cantidad']?></p>
                                    <p class="publishCCurrency"><?php echo filter_var($lista['moneda'] , FILTER_SANITIZE_STRING);?></p>
                                </div>
                                <p class="publishCFee">Fee <?php echo $lista['comision']?>%</p>
                            </div>
                            <div class="publishPDetails">
                                <p class="publishCOperation"><?php echo filter_var($lista['operacion'] , FILTER_SANITIZE_STRING);?></p>
                                <div class="publishCMethod">
                                    <p class="publishCMethodAccepted">Aceptas:</p><p class="publishCP2P"><?php echo filter_var($lista['p2p'] , FILTER_SANITIZE_STRING);?></p><p class="publishCF2F"><?php echo filter_var($lista['f2f'] , FILTER_SANITIZE_STRING);?></p>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php }?>        
        </div>
        <div class="userprofilebackto md">
            <a href="https://librecripto.com/myannouncements?user=<?php echo filter_var($_SESSION['user'] , FILTER_SANITIZE_NUMBER_INT);?>">Ver más</a>
        </div>
    </div>
    <div class="mdchats">
        <h2 class="mdtitle">Mis chats</h2>
        <div class="wrapper md">
            <section class="seccion2 users">
            <div class="search">
            <input type="hidden">
            </div>
            <div class="users-list">

            </div>
            </section>
            <script src="js/usuarios.js"></script>
        </div>
        <div class="userprofilebackto md">
            <a href="https://librecripto.com/mychats?user=<?php echo filter_var($_SESSION['user'] , FILTER_SANITIZE_NUMBER_INT);?>">Ver más</a>
        </div>
    </div>
</section>
<section class="seccion2 contenedor home">
    <div class="mddata">
        <h2 class="mdtitle">Mis datos</h2>
        <div class="statsBox md">
            <ul class="userstats">
                <?php  
                    $fechareg = $usef['fecha_reg'];
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
                    <li>Operaciones concretadas: <span><?php echo filter_var($usef['operations'] , FILTER_SANITIZE_NUMBER_INT);?></span></li>
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
                    $pmqual = mysqli_query($conexion, "SELECT AVG(opqualify) as average_rating FROM operaciones WHERE usersending = '".mysqli_real_escape_string($conexion, $user)."' AND opverif ='1' AND opstatus ='Confirmed and qualified' ORDER BY operationid");
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
                        $consult = mysqli_query($conexion, "SELECT * FROM operaciones WHERE usersending = '".mysqli_real_escape_string($conexion, $user)."' AND opverif ='1' AND opstatus ='Confirmed and qualified' ORDER BY operationid ASC LIMIT 5");
                        if($useop == null){
                            echo '<span>N/A</span>';
                        }else{
                        while($lista = mysqli_fetch_array($consult)){
                            $listqual= $lista['opqualify'];
                        ?>
                        <span>
                            <?php echo $listqual;?> <i class="fa fa-star qualstar" aria-hidden="true"></i> - <?php }};?></span></li>
                </ul>
                <?php 
                    if($usef['criptotop'] != filter_var('0', FILTER_SANITIZE_NUMBER_INT)) {?>
                        <div class="criptotopmedalshow">
                            <img class="criptotopmedal md" src= "img/criptotopmedal.png" alt="Usuario Cripto Top"></img>
                        </div>
                <?php } ?>
        </div>        
        <div class="userprofilebackto md">
            <a href="https://librecripto.com/myprofile?user=<?php echo filter_var($_SESSION['user'] , FILTER_SANITIZE_NUMBER_INT);?>">Ver más</a>
        </div>
    </div>
    <div class="mdoperaciones">
        <h2 class="mdtitle">Mis operaciones</h2>
        <div class="opbox">
            <p>Última</p>
            <div class="lastop">
                <?php
                if($useop == null){
                    echo 'No tenes operaciones aún!';
                }else{
                ?>
                <?php
                $consult = mysqli_query($conexion, "SELECT usuarios.usuario, usuarios.avatar, operaciones.usertoconfirm FROM usuarios INNER JOIN operaciones ON usuarios.user = operaciones.usertoconfirm WHERE usersending = '".mysqli_real_escape_string($conexion, $thisuser)."' AND opverif ='1' AND opstatus ='Confirmed and qualified' ORDER BY operationid DESC LIMIT 1");
                $con = mysqli_fetch_assoc($consult);
                $ava = filter_var($con['avatar'] , FILTER_SANITIZE_STRING);
                ?>
                <p class="dbuser">Con <span>@<?php echo filter_var($con['usuario'] , FILTER_SANITIZE_STRING);?></span> <span><?php echo $diffop;?></span> <span>Recibiste <?php echo $useop['opqualify']?> <i class="fa fa-star qualstar" aria-hidden="true"></i></span></p> <div class="dbavatar"><img src="img/profilepics/<?php echo filter_var($ava , FILTER_SANITIZE_STRING);?>" alt=""></div>
                </div>
                <p>Calificaciones</p>
                <div class="lastop">
                <?php
                    $consult = mysqli_query($conexion, "SELECT * FROM operaciones WHERE usersending = '".mysqli_real_escape_string($conexion, $user)."' AND opverif ='1' AND opstatus ='Confirmed and qualified' ORDER BY operationid DESC");
                    while($lista = mysqli_fetch_array($consult)){
                    $listqual= $lista['opqualify'];
                    $listfecha = $lista['fecha_qualify'];
                    $datelistop = Carbon::create($listfecha, 'America/Argentina/Buenos_Aires');
                    $datelistop->locale('es');
                    $difflistop = $datelistop->diffForHumans($now, CarbonInterface::DIFF_RELATIVE_TO_NOW);
                ?>
                <div class="dbqualifications"><p><?php echo $listqual;?> <i class="fa fa-star qualstar" aria-hidden="true"></i> (<?php echo $difflistop ?>) </p></div><?php };?>
            <?php }; ?>
            </div>
        </div>
        <div class="userprofilebackto md">
            <a href="https://librecripto.com/myoperations?user=<?php echo filter_var($_SESSION['user'] , FILTER_SANITIZE_NUMBER_INT);?>">Ver más</a>
        </div>
    </div>

</section>
</main>
<?php include_once 'includes/templates/footerdashboard.php'; ?>