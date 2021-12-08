<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <title><?php echo $title ?></title>
    <meta name="description" content="contacto de usuarios y comercio de criptomonedas">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:title" content="LibreCripto">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://librecripto.com">
    <meta property="og:image" content="https://librecripto.com/img/content.png">
    <meta property="og:description" content="Comerciá tus criptomonedas como vos prefieras. Bienvenido a LibreCripto, bienvenido al mercado P2P y F2F." />
    <meta property="og:locale" content="es_ES" />

    <link rel="icon" href="favicon.ico">

    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;400;700&family=Nunito:wght@200;300;400;600&family=Raleway:wght@200;300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/fontawesome-all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <meta name="theme-color" content="#fe9416">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script type="text/javascript">
    $(window).load(function() {
        $(".loader").fadeOut("slow");
    });
    </script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-J8JNT9JNLG"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-J8JNT9JNLG');
</script>
</head>

    <body>
        <header class="site-header-log">
            <div class="contenedor clearfix">
                <div class="logo">
                    <a href="https://librecripto.com/">
                        <img src="../img/logo.svg" alt="logo librecripto">
                    </a>
                </div>
                <div class="menu-movil-log">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <nav class="navegacion-principal-log clearfix">
                    <ul class="show">
                        <li class="first">
                            <div class="accountMenu last">
                                <div class="hiusermini">
                                    <a href="#" class="firstLog">
                                    <div class="hiuser">
                                            <p class="logText">Hola, <?php echo $_SESSION['nombre']; ?>!</p>
                                            <img class="profpicheader" src="../img/profilepics/<?php echo $_SESSION['avatar']?>" alt="avatar">
                                        </div>
                                    </a>
                                    <a class="SplitUser"><i class="Arrow lastone fas fa-chevron-down"></i>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <div class="userpanelMin show">
                            <ul>
                                <li><a href="https://librecripto.com/market">Mercado Cripto</a></li>
                                <li><a href="https://librecripto.com/myprofile?user=<?php echo $_SESSION['user'];?>">Mi Cuenta</a></li>
                                <li><a class="logOut" href="../php/cerrar_sesion.php">Cerrar Sesión</a></li>
                            </ul>
                        </div>
                        <li><a href="https://librecripto.com/nosotros" class="first">Nosotros</a></li>
                        <li><a href="https://librecripto.com/help">Ayuda</a></li>
                        <li><a href="https://librecripto.com/contacto">Contacto</a></li>
                        <li class="last">
                            <div class="accountMenu last">
                                <a href="#" class="lastLog">
                                    <div class="hiuser">
                                        <p class="logText">Hola, <?php echo $_SESSION['nombre']; ?>!</p>
                                        <img class="profpicheader" src="../img/profilepics/<?php echo $_SESSION['avatar']?>" alt="avatar">
                                    </div>
                                </a>
                                <div>
                                    <a class="splitUser"><i class="lastone fas fa-chevron-down"></i>
                                </a>
                                </div>
                            </div>
                            <ul class="userpanel show"> 
                                <li><a href="https://librecripto.com/market">Mercado Cripto</a></li>
                                <li><a href="https://librecripto.com/myprofile?user=<?php echo $_SESSION['user'];?>">Mi Cuenta</a></li>
                                <li><a class="logOut" href="../php/cerrar_sesion.php">Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    </ul>
            </nav>
        </div>
    </header>