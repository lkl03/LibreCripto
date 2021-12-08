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
$title = "Mis Operaciones | LibreCripto";
include 'php/conexion_be.php';
require 'php/Carbon/autoload.php';
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonInterface;
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
    $opconsult = ("SELECT usuariosending, opverif, operationid FROM operaciones WHERE usertoconfirm='$thisuser' ORDER BY operationid DESC");
    $opresult = mysqli_query($conexion, $opconsult);
    $oprow = mysqli_fetch_array($opresult);
        if($oprow == null){
            include 'includes/templates/headerlogged.php'; 
        }else{
            if($oprow['opverif'] == 0){
            include_once 'includes/templates/headerlogged.php';
            echo '<script type="text/javascript">';
            echo 'setTimeout(function () {';
            echo 'swal("¡Tenés una operación pendiente!","Por favor calificá a @'.$oprow['usuariosending'].' antes de continuar.","warning", {button: "Calificar",}).then( function(val) {';
            echo 'if (val == true) window.location.href = \'https://librecripto.com/calificar?user='.$thisuser.'&operationid='.$oprow['operationid'].'\';';
            echo '});';
            echo '}, 200);  </script>';
            die();
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
        <h2 class="titleAccount">Mis Operaciones</h2>
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
<section class="seccion contenedor">
    <div class="mddata home">
        <div class="activeoppanel">
            <h3 class="mdtitle">Operaciones activas</h3>
            <div class="opbox" id="activeopbox">
            <!--<p class="mdtitle">Nada por aquí!</p>-->
                <?php
                    function secure($value){
                        include 'php/conexion_be.php';
                        $value = trim($value);
                        $value = stripslashes($value);
                        $value = htmlspecialchars($value);
                        $value = mysqli_real_escape_string($conexion, $value);
                        return $value;
                    }
                    $cnx = mysqli_query($conexion, "SELECT usuarios.*, operaciones.* FROM (usuarios INNER JOIN operaciones ON usuarios.user = operaciones.usertoconfirm) WHERE usersending = '".mysqli_real_escape_string($conexion, $thisuser)."' AND opverif ='0' AND opstatus ='Waiting for confirmation' ORDER BY operationid DESC");
                    while($list = mysqli_fetch_array($cnx)){
                        $dt = $list['fecha_send'];
                        $ous = filter_var($list['usertoconfirm'] , FILTER_SANITIZE_NUMBER_INT);
                        $nw = Carbon::now(new DateTimeZone('America/Argentina/Buenos_Aires'));
                        $dtx = Carbon::create($dt, 'America/Argentina/Buenos_Aires');
                        $dtx->locale('es');
                        $dfdtx = $dtx->diffForHumans($nw, CarbonInterface::DIFF_RELATIVE_TO_NOW);
                        $opid = mysqli_real_escape_string($conexion, $list['operationid']);
                        $us = mysqli_real_escape_string($conexion, $list['nombre']);
                        $em = mysqli_real_escape_string($conexion, $list['correo']);
                        $th = secure($_SESSION['usuario']);
                        $oumsg = mysqli_query($conexion, "SELECT * FROM messages WHERE outgoing_msg_id = $ous ORDER BY msg_id ASC");
                        $oumsgarr = mysqli_fetch_array($oumsg);
                        $chid=filter_var($oumsgarr['chatid'] , FILTER_SANITIZE_NUMBER_INT);
                        $chim=filter_var($oumsgarr['incoming_msg_id'] , FILTER_SANITIZE_NUMBER_INT);
                        $chom=filter_var($oumsgarr['outgoing_msg_id'] , FILTER_SANITIZE_NUMBER_INT);
                        $chmd=$oumsgarr['msgdate'];
                        ?>
                            <p class="activeoptext">Tenes una operación con confirmación pendiente de <span>@<?php echo filter_var($list['usuario'] , FILTER_SANITIZE_STRING);?></span></p>
                            <div class="activeopbuttons form-control">
                                <button class="waitingopbutton"><i class="fas fa-sync fa-spin fa-fw"></i> Esperando confirmación...</button>
                                <button class="cancelopbutton" name="cancelopbutton" onclick="cargarData('<?php echo filter_var($opid , FILTER_SANITIZE_NUMBER_INT); ?>', '<?php echo filter_var($us , FILTER_SANITIZE_STRING); ?>', '<?php echo filter_var($em , FILTER_SANITIZE_EMAIL); ?>', '<?php echo filter_var($th , FILTER_SANITIZE_STRING); ?>', '<?php echo filter_var($chid , FILTER_SANITIZE_NUMBER_INT); ?>', '<?php echo filter_var($chim , FILTER_SANITIZE_NUMBER_INT); ?>', '<?php echo filter_var($chom , FILTER_SANITIZE_NUMBER_INT); ?>', '<?php echo filter_var($chmd , FILTER_SANITIZE_NUMBER_INT); ?>');"><i class="fas fa-times"></i></button>
                                <span class="form-control__message" id="info">Enviamos un correo a @<?php echo $list['usuario']?> <?php echo $dfdtx?> </span>
                            </div>
                        <script type="text/javascript">
                            function cargarData(id, us, em, th, chid, chim, chom, chmd) {
                                var url="canceloperation.php";
                                swal({
                                    title: "¿Querés cancelar esta operación?",
                                    text: "Le avisaremos al usuario seleccionado sobre la cancelación y tu chat con él será reestablecido.",
                                    icon: "warning",
                                    buttons:{
                                        cancel: "No, volver",
                                        confirm: "Sí, cancelar",
                                    }
                                }).then((result) => {
                                    if (result) {
                                        $.ajax({
                                            type: 'POST',
                                            url:url,
                                            data:{id: id, us: us, em: em, th: th, chid: chid, chim: chim, chom: chom, chmd: chmd},
                                            success:function(){
                                                swal({
                                                    title: 'Operación cancelada',
                                                    text: '¿Querés intentar de nuevo?',
                                                    icon: 'success',
                                                    button: 'Continuar',
                                                }).then((value) => {
                                                    location.reload();
                                                });
                                            }
                                        });
                                    }
                                });
                            };
                        </script>
                <?php
                }
                
                ?>
            </div>
        </div>
        <div class="confirmoppanel">
            <h3 class="mdtitle">Crear operación</h2>
            <p class="confirmoptext">¿Tenes alguna operación pendiente?</p>
            <button class="confirmopbutton" id="confirmopbutton"><i class="fas fa-check"></i> Confirmar operación</button>
        </div>
        <div class="overlay" id="overlay">
            <div class="publishannouncer" id="publishannouncer">
                <a href="#" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times"></i></a>
                <p class="pmo">¿Con cuál de estos usuarios tenés una operación?</p>
                <form action="" method="POST" name="operationsform" id="operationsform">
                <div class="wrapper">
                    <div class="seccion2 users">
                        <div class="search">
                            <input type="hidden">
                        </div>
                        <div class="users-list">
                        
                        </div>
                    </div>
                </div>
                <p class="plmo">Por favor seleccioná un único usuario por operación</p>
                <button type="button" disabled class="continuebutton" id="continuebutton">Continuar</button>   
            </div>
        </div>
        <div class="overlay" id="newoverlay">
            <div class="publishannouncer" id="newpublishannouncer">
                <p class="pmo">¿Con cuál de tus anuncios realizaste la operación?</p>
                <?php
                    $consult = mysqli_query($conexion, "SELECT * FROM anuncios WHERE user = '".mysqli_real_escape_string($conexion, $user)."' ORDER BY id_pub DESC");
                ?>
                <div class="publishmShow mo">
                    <?php
                        while($lista = mysqli_fetch_array($consult)){
                                $userid = mysqli_real_escape_string($conexion, $lista['id']);
                                $usuariob = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id = '".mysqli_real_escape_string($conexion, $userid)."'");
                                $use = mysqli_fetch_array($usuariob);
                                $idpub = mysqli_real_escape_string($conexion, $lista['id_pub']);
                    ?>
                        <div class="publishContainer mo">
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
                                <input type="checkbox" id="<?php echo "$idpub"?>" class="selectannouncebutton" name="selectannouncebutton" value="<?php echo "$idpub"?>" onClick="P2P(this)">
                            </div>
                        </div>
                    <?php }?> 
                </div>
                <p class="plmo">Por favor seleccioná un único anuncio por operación</p>
                <div class="actionbuttons">
                    <a href="#" id="new-btn-cerrar-popup" class="btn-volver dos">Volver</a>
                    <input type="submit" disabled class="continuebutton dos" id="publicar" name="publicar" value="Confirmar operación">
                    </form>
                    <?php

                    if(isset($_POST['publicar'])){
                        $usuariosending = secure($_SESSION['usuario']);
                        $usersending = mysqli_real_escape_string($conexion, $_SESSION['user']);
                        $usertoconfirm = mysqli_real_escape_string($conexion, $_POST['userlistchecked']);
                        $pubid = mysqli_real_escape_string($conexion, $_POST['selectannouncebutton']);
                        $status = "Waiting for confirmation";

                        $query = "INSERT INTO operaciones(usuariosending, usersending, usertoconfirm, id_pub, fecha_send, opstatus)
                        VALUES('$usuariosending', '$usersending', '$usertoconfirm', '$pubid', now(), '$status')";
    
                        $ejecutar = mysqli_query($conexion, $query);
                        if($ejecutar){
                            $consult = mysqli_query($conexion, "SELECT usuarios.*, operaciones.usertoconfirm FROM usuarios INNER JOIN operaciones ON usuarios.user = operaciones.usertoconfirm WHERE usersending = '".mysqli_real_escape_string($conexion, $thisuser)."' AND opverif ='0' AND opstatus ='Waiting for confirmation' ORDER BY operationid DESC LIMIT 1");
                            $con = mysqli_fetch_assoc($consult);
                            $cof = filter_var($con['usertoconfirm'] , FILTER_SANITIZE_NUMBER_INT);
                            $ava = filter_var($con['usuario'] , FILTER_SANITIZE_STRING);
                            $deletechat = mysqli_query($conexion, "DELETE FROM chats WHERE incoming_msg_id = '".mysqli_real_escape_string($conexion, $user)."' AND outgoing_msg_id = '".mysqli_real_escape_string($conexion, $cof)."'");
                            echo '<script type="text/javascript">';
                            echo 'setTimeout(function () {';
                            echo 'swal("¡Operación confirmada!","Enviamos una notificación a @'.$ava.' para que califique tu servicio. Tu chat con él fue cerrado y tu anuncio seguirá vigente hasta que recibas la calificación.","success").then( function(val) {';
                            echo 'if (val == true) window.location.href = \'https://librecripto.com/myoperations?user='.$_SESSION['user'].'\';';
                            echo '});';
                            echo '}, 200);  </script>';
    $correo = filter_var($con['correo'], FILTER_SANITIZE_EMAIL);
    $nombre = filter_var($con['nombre'], FILTER_SANITIZE_STRING);
                            require 'php/src/Exception.php';
                            require 'php/src/PHPMailer.php';
                            require 'php/src/SMTP.php';
                            $mail->CharSet = 'UTF-8';
        
        $smtpHost = "c2410691.ferozo.com";
        $smtpUsuario = "librecripto@librecripto.com";
        $smtpClave = "Lk3209lk";  // Mi contraseña

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->IsHTML(true);
        $mail->CharSet = "utf-8";

        $mail->Host = $smtpHost;
        $mail->Username = $smtpUsuario;
        $mail->Password = $smtpClave;


        $mail->From = $smtpUsuario;
        $mail->FromName = 'LibreCripto';
        $mail->AddAddress($correo);
        $mail->AddReplyTo('no-reply@librecripto.com','no-reply');

        $mail->Subject = "¡Tenés una operación por calificar!";
        $mensajeHtml = nl2br($mensaje);
        $mail->Body = "
         <html>

         <body>

         <h3>¡Hola, $nombre!</h3>
                                
                            <p><b>@$usuariosending</b> confirmó una operación con vos, y está a la espera de tu calificación.</p>
                            <p>Cuando inicies sesión en tu cuenta, verás un aviso para que puedas puntuar a este usuario y dejar una breve reseña si así lo deseas.</p>
                            
                            
                            <p>¡Muchas gracias! Con tu calificación contribuis a hacer de LibreCripto un mejor ecosistema cripto ;)</p>
                            
                            <p>Atentamente <b>-El equipo de LibreCripto.</b></p>
                            <a href='https://librecripto.com/forms'>(Si tuviste algún problema con la operación por favor ponete en contacto con nosotros).</a>
         </body>

         </html>

        <br />";

        $mail->SMTPOptions = array(
         'ssl' => array(
         'verify_peer' => false,
         'verify_peer_name' => false,
         'allow_self_signed' => true
         )
        );

        $estadoEnvio = $mail->Send();
                            exit();
                        }else{
                            echo '<script type="text/javascript">';
                            echo 'setTimeout(function () {';
                            echo 'swal("Algo salió mal...","No se pudo confirmar tu operación. Por favor, intentá de nuevo.","error").then( function(val) {';
                            echo 'if (val == true) window.location.href = \'https://librecripto.com/myoperations?user='.$_SESSION['user'].'\';';
                            echo '});';
                            echo '}, 200);  </script>';
                        }
                    }
                    ?>   
                </div>
            </div>
        </div>
    </div>
</section>
<section class="seccion contenedor home">
    <div class="mdoperaciones">
        <h2 class="mdtitle">Mi información</h2>
        <div class="opbox">
            <p>Estadísticas</p>
            <div class="lastop" id="opstats">
                <div class="usstats">
                    <p><span><?php echo filter_var($usef['operations'] , FILTER_SANITIZE_NUMBER_INT);?></span> operaciones concretadas </p>
                        <?php
                            $pmqual = mysqli_query($conexion, "SELECT AVG(opqualify) as average_rating FROM operaciones WHERE usersending = '".mysqli_real_escape_string($conexion, $user)."' AND opverif ='1' AND opstatus ='Confirmed and qualified' ORDER BY operationid");
                            $prom = mysqli_fetch_assoc($pmqual);
                        ?>
                        <p>Calificación promedio: 
                            <span>
                                <?php 
                                    if($useop == null){
                                        echo 'N/A';
                                    }else{
                                        echo round($prom['average_rating'], 2);
                                    };
                                ?> 
                                <i class="fa fa-star qualstar" aria-hidden="true"></i>
                            </span>
                        </p>
                </div>
            </div>
            <div class="lastop" id="ctop">
                <div class="">
                        <?php 
                            if($usef['criptotop'] == filter_var('0', FILTER_SANITIZE_NUMBER_INT)){
                            ?>
                                <div class="criptotopmedalshow ox">
                                    <p class="criptotoptext">¿Cumplís con los <a href="https://librecripto.com/guias/requisitos" target="_blank">requisitos para ser Cripto Top</a>? ¡Envianos <a href="https://librecripto.com/criptotop?user=<?php echo $_SESSION['user']?>" target="_blank">una solicitud</a> y convertite en uno!</p>
                                    <img class="criptotopmedal md ox gr" src= "img/criptotopmedal.png" alt="Usuario Cripto Top"></img>
                                </div>
                            <?php
                            }else{
                            ?>
                                <div class="criptotopmedalshow ox">
                                    <p class="criptotoptext">¡Ya sos Cripto Top! Mantené tu buena calificación y seguí operando para conservar tu rango</p>
                                    <img class="criptotopmedal md ox" src= "img/criptotopmedal.png" alt="Usuario Cripto Top"></img>
                                </div>
                        <?php
                            };
                        ?>
                </div>
            </div>
        </div>

    </div>
    <div class="mdoperaciones">
        <h2 class="mdtitle">Calificaciones</h2>
        <div class="opbox">
            <div class="lastop" id="opcalification">
                <?php
                if($useop == null){
                    echo 'No tenes operaciones aún!';
                }else{
                ?>
                    <?php
                    $cons = mysqli_query($conexion, "SELECT usuarios.*, usuarios.*, operaciones.* FROM usuarios INNER JOIN operaciones ON usuarios.user = operaciones.usertoconfirm WHERE usersending = '".mysqli_real_escape_string($conexion, $user)."' AND opverif ='1' AND opstatus ='Confirmed and qualified' ORDER BY operationid DESC");
                    while($lista = mysqli_fetch_array($cons)){
                    $listqual= $lista['opqualify'];
                    $listfecha = $lista['fecha_qualify'];
                    $datelistop = Carbon::create($listfecha, 'America/Argentina/Buenos_Aires');
                    $datelistop->locale('es');
                    $now = Carbon::now(new DateTimeZone('America/Argentina/Buenos_Aires'));
                    $difflistop = $datelistop->diffForHumans($now, CarbonInterface::DIFF_RELATIVE_TO_NOW);
                    ?>
                    <div class="opwho">
                        <p class="dbdate"><?php echo $difflistop;?></p> 
                        <p class="dbname">Por <span>@<?php echo filter_var($lista['usuario'] , FILTER_SANITIZE_STRING);?></span></p> 
                        <div id="dbopavatar"><img src="img/profilepics/<?php echo filter_var($lista['avatar'] , FILTER_SANITIZE_STRING);?>" alt="Avatar"></div>
                    </div>
                    <div class="ophow">
                        <p class="ophowqual"><span>Recibiste <?php echo $listqual?> <i class="fa fa-star qualstar" aria-hidden="true"></i></span></p> <p class="ophowmsg">" <span><?php echo filter_var($lista['opmsg'] , FILTER_SANITIZE_STRING);?></span>"</p>
                    </div>
                    <?php };?>
                <?php };?>
            </div>
            <p class="opboxadvice">Sólo vos podes ver las reseñas, pero tu puntuación es visible para todos los usuarios</p>
        </div>
    </div>
</section>
<script src="js/usuarioslist.js"></script>

<?php include_once 'includes/templates/footerop.php'; ?>