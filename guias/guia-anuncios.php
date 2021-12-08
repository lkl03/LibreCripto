<?php

    session_start();
$title = "Guía para Anuncios | LibreCripto";
    if(!isset($_SESSION['usuario'])){
        include_once '../includes/templates/ayudaheader.php';        
    }else{
        include_once '../includes/templates/ayudaheaderlogged.php';
    }

?>
    <main>
    <section class="seccion2 BackNar">
        <h2 class="titleAccount">Guía para la creación de anuncios</h2>
    </section>
    <section class="seccion2 contenedor guiaanuncios">
        <h3>¿Qué es un anuncio?</h3>
        <p>Un anuncio es la forma mediante la cual un usuario puede publicar una venta o compra de una criptomoneda en LibreCripto.</p>
        <h3>¿Cómo puedo publicar un anuncio?</h3>
        <p>Para publicar un anuncio debes acceder a la sección de "Mercado Cripto" y hacer click en el botón "Publicar un anuncio".</p>
        <img src="../img/picture10.png" alt="muestra1">
        <h3>Creando un anuncio</h3>
        <img src="../img/picture11.png" alt="muestra2">
        <p class="divisortext">Ubicación</p>
        <p>La ubicación de tu anuncio permite a los usuarios identificar de manera más simple anuncios cercanos a ellos, de modo que te permite obtener una visualización y posibilidad de alcance mas certera y precisa.</p> 
        <img src="../img/picture12.gif" alt="muestra3">
        <p>Podes elegir la provincia y la localidad en la que querés que tu anuncio sea categorizado. Por ejemplo, en la imagen se elige la Provincia de Buenos Aires con la localidad de Zona Norte. De este modo, cuando un usuario filtre su búsqueda con esos dos parámetros, podrá ver tu anuncio.</p>
        <p class="divisortext">Moneda, cantidad y porcentaje de comisión</p>
        <p>Podes elegir la criptomoneda que vas a comprar o vender, siendo ésta cualquiera de las 10 principales de acuerdo con su capitalización de mercado. También podes definir la cantidad de esta criptomoneda que vas a publicar. Por último, podes elegir un determinado porcentaje a cobrar al usuario con el que lleves a cabo la operación en caso de que así lo desees.</p> 
        <img src="../img/picture13.gif" alt="muestra4">
        <p>Continuando con el ejemplo anterior, en este caso se elige la criptomoneda Cardano (ADA), una cantidad de 500 y un porcentaje de comisión del 2.5%.</p> 
        <p class="divisortext">Definiendo la operación</p>
        <p>Por último, para completar el anuncio debes elegir si vas a vender la cantidad de criptomonedas que hayas seleccionado (en tal caso, buscando recibir dinero efectivo a cambio), o comprar esa cantidad de criptomonedas (en este caso, ofreces efectivo a cambio de un usuario que quiera vender esas criptomonedas). También debes elegir qué modalidad de comercio vas a utilizar en tu operación: P2P a través de un exchange como puede ser Binance, o F2F.</p> 
        <img src="../img/picture14.gif" alt="muestra5">
        <p class="epitext">Aquí se elige vender mediante el método F2F. De este modo, el usuario ofrece 500 monedas de Cardano mediante F2F a cualquier usuario interesado en llevar adelante el intercambio de efectivo a cripto.</p>
        <p>Una vez concluido todos los pasos, quedaría definido el anuncio:</p>
        <img src="../img/picture15.png" alt="muestra6">
        <p>De modo que ya es posible publicarlo:</p>
        <img src="../img/picture16.gif" alt="muestra7">
        <p>Si al momento de publicar tu anuncio dejaste algún campo vacío, se te alertará y podrás modificarlo:</p>
        <img src="../img/picture17.gif" alt="muestra7">
        <p>Una vez terminado, recibirás un email con la confirmación de que tu anuncio fue publicado y podrás verlo en el Mercado Cripto:</p>
        <img src="../img/picture18.png" alt="muestra8">
        <p>Y de este modo aparecerá para los demás usuarios:</p>
        <img src="../img/picture19.png" alt="muestra9">
        <p>¡Esperamos que te haya sido útil esta guía! ¡Estamos muy ansiosos porque publiques tus anuncios en LibreCripto! ;)</p>
    </section>

    </main>
<?php
    include_once '../includes/templates/ayudafooter.php';
?>