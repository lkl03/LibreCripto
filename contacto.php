<?php

    session_start();
$title = "Contacto | LibreCripto";
    if(!isset($_SESSION['user'])){
        include_once 'includes/templates/header.php';        
    }else{
        include_once 'includes/templates/headerlogged.php';
    }

?>

    <main>
        <section class="seccion2 BackNar">
            <h2 class="titleAccount">Contacto</h2>
        </section>
        <div class="seccion2 contenedor">
            <p class="textPage">Podes ponerte en contacto con nosotros a través de cualquiera de los siguientes métodos.</p>
        </div>
        <div class="seccion2 contenedor home">
            <div class="nosotrosContenedor1">
                    <h1 class="titleColumn"><i class="far fa-envelope"></i> Email</h1>
                    <p class="textColumn 1" id="textContacto">Podes escribirnos las 24 horas del día a <a href="mailto:contacto@librecripto.com" target="_blank">contacto@librecripto.com</a></p>
            </div>
            <div class="nosotrosContenedor2">
                <h1 class="titleColumn"><i class="fas fa-hashtag"></i> Redes</h1>
                <div class="textColumn 2">
                    <p id="textContacto">Nos encontras en las siguientes redes como <span>@Libre_Cripto</span></p>
                    <div style="display:flex">
                        <a href="https://www.facebook.com/libre_cripto" target="_blank" class="redes"><i class="fab fa-facebook-f "></i></a>
                        <a href="https://twitter.com/libre_cripto" target="_blank" class="redes"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/libre_cripto/" target="_blank" class="redes"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="nosotrosContenedor3">
                <h1 class="titleColumn"><i class="far fa-edit"></i> Formularios</h1>
                <p class="textColumn 3" id="textContacto">Si querés contactarte por alguno de los siguientes motivos: <span>problemas con usuarios, problemas con tu cuenta, sugerencias o empleo</span>, <a href="https://librecripto.com/forms" target="_blank">hace click acá</a></p>
            </div>
        </div>
    </main>

<?php include_once 'includes/templates/footer.php'; ?>