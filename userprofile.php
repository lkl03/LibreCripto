<?php
session_start();
require_once 'php/conexionverify.php';

?>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
</head>
<?php

    include 'php/conexion_be.php';	
    $user = filter_var($_GET['user'], (FILTER_SANITIZE_NUMBER_INT));
    $myuser = mysqli_query($conexion, "SELECT * FROM usuarios WHERE user = '".mysqli_real_escape_string($conexion, $user)."' ");
    $use = mysqli_fetch_array($myuser);
$usuarioxxx = $use['usuario'];
$title = "Perfil de @$usuarioxxx | LibreCripto";
    $myuserop = mysqli_query($conexion, "SELECT * FROM operaciones WHERE usersending = '".mysqli_real_escape_string($conexion, $user)."' ORDER BY operationid DESC");
    $useop = mysqli_fetch_array($myuserop);
    if($_SESSION['user'] == $user){
            echo "<script> window.location='https://librecripto.com/myprofile?user=".mysqli_real_escape_string($conexion, $user)."'; </script>";

        exit();
    }
?>
<?php

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
?>

    <main>
        <!--<section class="seccion2 BackNar">
            <h2 class="titleAccount">Mi Cuenta</h2>
        </section>-->
        <section class= "seccion contenedor home">
            <div class="usershowleftpanel" id="leftpaneluserprofile">
                <div class="userpshowbox">
                    <div class="usershowpic">
                        <img class="profpicshow" src="img/profilepics/<?php echo filter_var($use['avatar'] , FILTER_SANITIZE_STRING);?>" alt="avatar">
                    </div>
                <h3 class="userptitle"><span>@</span><?php echo filter_var($use['usuario'] , FILTER_SANITIZE_STRING);?></h3>
                <?php 
                        $fechareg = $use['fecha_reg'];
                        require 'php/Carbon/autoload.php';
                        use Carbon\Carbon;
                        use Carbon\CarbonInterval;
                        use Carbon\CarbonInterface;
                        $date = Carbon::parse($fechareg);
                        $date->locale('es');
                        $now = Carbon::now();
                        $diff = $date->diffForHumans($now, CarbonInterface::DIFF_RELATIVE_TO_NOW);
                        ?>
                        <li class="userpdate">
                            <a><i class="fas fa-chevron-right "></i></a>
                            <p>Miembro desde <span><?php echo $diff;?></span></p>
                        </li>
                <?php 
                    if($use['criptotop'] != filter_var('0', FILTER_SANITIZE_NUMBER_INT)) {?>
                        <div class="userpcriptotopmedalshow">
                            <img class="userpcriptotopmedal" src= "img/criptotopmedal.png" alt="Usuario Cripto Top"></img>
                        </div>
                <?php } ?>
                </div>
            </div>
            <div class="usershowrightpanel">
                <h3 class="userpstatstitle">Estadísticas de usuario</h3>
                <div class="statsBox">
                <ul class="userstats">
                        <?php 
                        $fechareg = $use['fecha_reg'];
                        if($useop != null){
                            $fechaop = $useop['fecha_qualify'];
                        }
                        require 'php/Carbon/autoload.php';
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
                        <li>Última operación: <span><?php if($useop == null){
                            echo 'Este usuario aún no realizó operaciones';
                        }else{
                            echo $diffop;
                        };?></span></li>
                        <?php
                        $pmqual = mysqli_query($conexion, "SELECT AVG(opqualify) as average_rating FROM operaciones WHERE usersending = '".mysqli_real_escape_string($conexion, $use['user'])."' AND opverif ='1' AND opstatus ='Confirmed and qualified' ORDER BY operationid");
                        $prom = mysqli_fetch_assoc($pmqual);
                        ?>
                        <li>Calificación promedio: <span><?php 
                            if($useop == null){
                            echo 'N/A';
                            }else{
                            echo round($prom['average_rating'], 2);};?> <i class="fa fa-star qualstar" aria-hidden="true"></i></span></li>
                        <li>Últimas 5 calificaciones:
                        <?php
                            $consult = mysqli_query($conexion, "SELECT * FROM operaciones WHERE usersending = '".mysqli_real_escape_string($conexion, $use['user'])."' AND opverif ='1' AND opstatus ='Confirmed and qualified' ORDER BY operationid ASC LIMIT 5");
                            if($useop == null){
                                echo '<span>N/A</span>';
                            }else{
                            while($lista = mysqli_fetch_array($consult)){
                                    $listqual= $lista['opqualify'];
                        ?>
                         <span><?php echo $listqual;?> <i class="fa fa-star qualstar" aria-hidden="true"></i> - <?php }};?></span></li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="seccion contenedor">
        <h3 class="titlePublish">Anuncios activos</h3>
        <?php
        $CantShow=10;
            $compag = (int)(!isset($_GET['publishpShow'])) ? 1 : $_GET['publishpShow'];
            $TotalReg = mysqli_query($conexion, "SELECT * FROM anuncios");
            $totalr = mysqli_num_rows($TotalReg);
            $TotalRegistro = ceil($totalr/$CantShow);
            $IncNum = (($compag +1)<=$TotalRegistro)?($compag +1):0;
            $consult = mysqli_query($conexion, "SELECT * FROM anuncios WHERE user = '".mysqli_real_escape_string($conexion, $use['user'])."' ORDER BY id_pub DESC LIMIT ".(($compag-1)*$CantShow)." , ".$CantShow);
            //$consultA = mysqli_query($conexion, $consult);
        ?>
        <div class="publishpShow">
            <?php
            while($lista = mysqli_fetch_array($consult)){
                    $userid = mysqli_real_escape_string($conexion, $lista['id']);
                    $usuariob = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id = '$userid'");
                    $use = mysqli_fetch_array($usuariob);
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
                                    <p class="publishCQuantity"><?php echo $lista['cantidad'];?></p>
                                    <p class="publishCCurrency"><?php echo filter_var($lista['moneda'] , FILTER_SANITIZE_STRING);?></p>
                                </div>
                                <p class="publishCFee">Fee <?php echo $lista['comision'];?>%</p>
                            </div>
                            <div class="publishPDetails">
                                <p class="publishCOperation"><?php echo filter_var($lista['operacion'] , FILTER_SANITIZE_STRING);?></p>
                                <div class="publishCMethod">
                                    <p class="publishCMethodAccepted">Acepta:</p><p class="publishCP2P"><?php echo filter_var($lista['p2p'] , FILTER_SANITIZE_STRING);?></p><p class="publishCF2F"><?php echo filter_var($lista['f2f'] , FILTER_SANITIZE_STRING);?></p>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php } ?>
        </div>
        <div class="publishPcontactbutton">
            <a href="https://librecripto.com/chat?user=<?php echo mysqli_real_escape_string($conexion, $use['user'])?>">Contactar</a>
        </div>
        </section>
    </main>
<?php include_once 'includes/templates/footer.php'; ?>