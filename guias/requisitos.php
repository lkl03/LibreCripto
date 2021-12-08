<?php

    session_start();
$title = "Requisitos CriptoTop | LibreCripto";
    if(!isset($_SESSION['usuario'])){
        include_once '../includes/templates/ayudaheader.php';        
    }else{
        include_once '../includes/templates/ayudaheaderlogged.php';
    }

?>
    <main>
    <section class="seccion2 BackNar">
        <h2 class="titleAccount">Requisitos para ser CriptoTop</h2>
    </section>
    <section class="seccion2 contenedor guiaanuncios">
        <h3>¿Qué es ser CriptoTop?</h3>
        <p>Es una distinción que otorgamos a los mejores usuarios de LibreCripto.</p>
        <h3>¿Cuáles son los requisitos para ser CriptoTop?</h3>
        <p>Debes cumplir con los siguientes requisitos:</p>
        <ul>
            <li>Más de 1 mes de antigüedad como usuario</li>
            <li>Más de 10 operaciones concretadas en tu cuenta</li>
            <li>Calificación promedio de operaciones de 4 estrellas o superior</li>
        </ul>
        <h3>¿Cómo puedo convertirme en CriptoTop?</h3>
        <p>Si cumplís con los requisitos mencionados, hace <a href="../criptotop.php?user=<?php echo $_SESSION['user']; ?>">click acá</a> para enviar una solicitud. Revisaremos que efectivamente tu usuario cumpla con los requisitos y en caso de que así sea, podrás ver reflejado en tu cuenta y en tus anuncios publicados la distinción de CriptoTop, ¡al igual que todos los usuarios de LibreCripto que interactúen con tu perfil y tus anuncios!.</p>
    </section>

    </main>
<?php
    include_once '../includes/templates/ayudafooter.php';
?>