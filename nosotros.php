<?php

    session_start();
$title = "Sobre Nosotros | LibreCripto";
    if(!isset($_SESSION['user'])){
        include_once 'includes/templates/header.php';        
    }else{
        include_once 'includes/templates/headerlogged.php';
    }

?>

    <main>
        <section class="seccion2 BackNar">
            <h2 class="titleAccount">Sobre nosotros</h2>
        </section>
        <div class="seccion2 contenedor">
            <p class="textPage">Somos LibreCripto. Nuestro principal objetivo es transformar el modo por el cual las personas acceden a las criptomonedas. Buscamos potenciar la posibilidad de acceder a la próxima era del dinero; la era cripto. </p>
            <p class="textPage">Queremos y creemos posible multiplicar el alcance que las criptomonedas poseen sobre la vida común de cada individuo, acercando la próxima gran revolución tecnológica a la cotidianidad de cada uno de nosotros. Sobre tal
            premisa fundamos y preservamos nuestro proyecto. </p> 
        </div>
        <div class="seccion2 contenedor home">
            <div class="nosotrosContenedor1">
                <h1 class="titleColumn"><i class="far fa-lightbulb"></i> Nuestra idea</h1>
                <p class="textColumn 1">Transformar el modo en que se adquieren criptomonedas en la actualidad. Poder acercar el mundo cripto a toda persona que se interese por él, simplificando el acceso al dinero del futuro.</p>
            </div>
            <div class="nosotrosContenedor2">
                <h1 class="titleColumn"><i class="fas fa-users"></i> Fundación</h1>
                <p class="textColumn 2">LibreCripto surge a comienzos de 2021, como una tímida idea que fue creciendo a medida que se avanzaba en su desarrollo. Hoy en día constituimos un equipo que día a día trabaja con la premisa de ofrecer un mejor servicio para todos nuestros usuarios.</p>
            </div>
            <div class="nosotrosContenedor3">
                <h1 class="titleColumn"><i class="far fa-hand-paper"></i> Compromisos</h1>
                <p class="textColumn 3">Nos comprometemos a posibilitar el alcance del mundo cripto a toda persona, a transformar completamente el acceso de cualquier individuo a sus criptomonedas y ofreciendo, siempre, un servicio de calidad 100% gratuito.</p>
            </div>
        </div>
        <section class="seccion onda">
            <p class="contenedor textQuote">"Después de todo, en el mundo moderno, el dinero fiduciario como los billetes y monedas, ya no son lo más importante. Los diferentes tipos de crédito y tarjetas son sustitutos. Así que creo que podemos olvidarnos del dinero tangible y de los
                bancos para abrir un sistema de cuentas que desplace al dinero actual." <span id="author">-F. Hayek</span></p>
        </section>
    </main>

<?php include_once 'includes/templates/footer.php'; ?>