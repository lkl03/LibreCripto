<?php include_once 'includes/templates/header.php'; ?>

<main>
        <!--bienvenida-->
        <section class="seccion contenedor home">
            <div class="contenedorLeft title" data-aos="fade-right">
            <div class="text">
                <h2 class="title">Bienvenid<span>@</span> al</h2>
                <h2 class="welcome">
                    <span class="word orange">Mundo Cripto</span>
                    <span class="word orange">P2P</span>
                    <span class="word orange">F2F</span>
                </h2>
            </div>
<script type = text/javascript>
    var words = document.getElementsByClassName('word');
    var wordArray = [];
    var currentWord = 0;

    words[currentWord].style.opacity = 1;
    for (var i = 0; i < words.length; i++) {
    splitLetters(words[i]);
    }

    function changeWord() {
    var cw = wordArray[currentWord];
    var nw = currentWord == words.length-1 ? wordArray[0] : wordArray[currentWord+1];
    for (var i = 0; i < cw.length; i++) {
        animateLetterOut(cw, i);
    }
    
    for (var i = 0; i < nw.length; i++) {
        nw[i].className = 'letter behind';
        nw[0].parentElement.style.opacity = 1;
        animateLetterIn(nw, i);
    }
    
    currentWord = (currentWord == wordArray.length-1) ? 0 : currentWord+1;
    }

    function animateLetterOut(cw, i) {
    setTimeout(function() {
            cw[i].className = 'letter out';
    }, i*80);
    }

    function animateLetterIn(nw, i) {
    setTimeout(function() {
            nw[i].className = 'letter in';
    }, 340+(i*80));
    }

    function splitLetters(word) {
    var content = word.innerHTML;
    word.innerHTML = '';
    var letters = [];
    for (var i = 0; i < content.length; i++) {
        var letter = document.createElement('span');
        letter.className = 'letter';
        letter.innerHTML = content.charAt(i);
        word.appendChild(letter);
        letters.push(letter);
    }
    
    wordArray.push(letters);
    }

    changeWord();
    setInterval(changeWord, 4000);
</script>
            </div>
            <div class="contenedorRight" data-aos="fade-left">
                <img class="picHome" src="img/picture1b.png" alt="imagen portada">
            </div>
        </section>
        <!--primer texto-->
        <section class="seccion onda" data-aos="fade-up">
            <p class="whiteTexto contenedor">El comercio P2P (peer-to-peer) es la forma más efectiva para ingresar al mercado de las criptomonedas. La esencia del mismo radica en su descentralización, lo que garantiza un intercambio directo entre dos partes interesadas en llevar adelante
                la operación. El comercio F2F (face-to-face) supone dar un paso más adelante en esta operativa. Además de ser descentralizado, garantiza el total anonimato del acuerdo entre partes, respetando el motivo originario de las criptomonedas.
            </p>
        </section>
        <!--middle-->
        <section class="seccion contenedor middle">
            <div class="contenedorLeft" data-aos="zoom-in-down">
                <img class="picMiddle" src="img/picture2.png" alt="imagen middle">
            </div>
            <div class="contenedorRight">
                <h3 class="secondTitle" data-aos="fade-down">De efectivo a cripto: ¡Nunca había sido tan fácil!</h3>
                <p class="middleTexto" data-aos="fade-up">Hasta el momento, si alguien deseaba adquirir criptomonedas mediante dinero en efectivo, se veía obligado a digitalizar su dinero para poder llevar adelante la transacción, o iniciar un arduo proceso de búsqueda por toda la web hasta hallar un usuario interesado en aceptar su efectivo.
                    Desde <span>LibreCripto</span> proponemos simplificar totalmente esta tarea: a partir de ahora, creando tu cuenta vas a poder acceder a los anuncios de cientos de usuarios interesados en comprar o vender cripto de manera P2P o F2F. Además, vas a contar con la
                    seguridad de poder verificar perfiles reputados y confiables, a través de calificaciones provistas por los propios usuarios luego de otras transacciones realizadas en esta comunidad.</p>
            </div>
        </section>
        <!--segundotexto-->
        <section class="seccion onda" data-aos="fade-up">
            <h3 class="thirdTitle conteedor" data-aos="fade-down">Un paso adelante en la forma de adquirir criptomonedas.</h3>
            <p class="whiteTexto contenedor" data-aos="fade-down">En LibreCripto nos comprometimos con el futuro: entendemos a las criptomonedas como la próxima gran revolución digital y buscamos ofrecer un servicio acorde a tales expectativas.
            </p>
        </section>
        <!--tercertexto-->
        <section class="seccion">
            <h3 class="fourthTitle contenedor" data-aos="fade-down">Unite y se parte de la evolución</h3>
            <div class="seccion2 final" data-aos="fade-down">
                <div class="contenedor contenedorL">
                    <a href="https://librecripto.com/acceso" class="buttonL">Acceder</a>
                    <a href="https://librecripto.com/registro" class="buttonR">Crear cuenta</a>
                </div>
                <p id="finaltexto">Accedé o creá tu cuenta, 100% gratis. Siempre.</p>
            </div>
        </section>
    </main>
<?php include_once 'includes/templates/footer.php'; ?>