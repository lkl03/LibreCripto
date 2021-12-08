<?php
session_start();
?>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/usersidebar.css">
</head>
<?php 
$title = "Mis Chats | LibreCripto";
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
    $thisuser = filter_var($_SESSION['user'], (FILTER_SANITIZE_NUMBER_INT));
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
  $use = mysqli_fetch_array($myuser);
  
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
<main>
<section class="seccion2 BackNar">
        <h2 class="titleAccount">Mis Chats</h2>
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
  <div class="wrapper">
    <section class="seccion2 users">
      <div class="search">
      <input type="hidden">
      </div>
      <div class="users-list">
  
      </div>
    </section>
  </div>
<section class= "seccion2 contenedor">
  <div class="userprofilebackto">
    <a href="market.php">Volver al Mercado</a>
  </div>
</section>

  <script src="js/usuarios.js"></script>

</main>
<?php include_once 'includes/templates/footernone.php'; ?>