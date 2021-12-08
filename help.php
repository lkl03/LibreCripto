<?php

    session_start();
$title = "Ayuda | LibreCripto";
    if(!isset($_SESSION['user'])){
        include_once 'includes/templates/header.php';        
    }else{
        include_once 'includes/templates/headerlogged.php';
    }

?>



<main>
    <section class="seccion2 BackNar">
        <h2 class="titleAccount">Ayuda</h2>
    </section>
    <section class="seccion2 contenedor">
        <li class="diviser">
            <a><i class="fas fa-chevron-right "></i></a>
            <a><i class="fas fa-chevron-right "></i></a>
            <p>Preguntas frecuentes</p>
        </li>

        <div class="cripButtonContenedor ">
            <div class="cripTitle ">Sobre criptomonedas</div>
            <nav class="cripBody ">
                <ul class="open ">
                    <li><span>¿Qué son las criptomonedas?</span> Las criptomonedas son activos digitales que funcionan como medio de intercambio de valor, pudiendo ser transferidas de persona a persona sin intermediarios con alta seguridad debido al respaldo por la tecnología blockchain, que es encriptada, segura, trazable y descentralizada, la cual funciona como una red pública donde se registran y verifican la totalidad de las transacciones hechas en todos los dispositivos que conforman dicha red.
                    </li>
                    <li><span>¿Qué es una wallet?</span> Una wallet es una billetera virtual donde se pueden gestionar las criptomonedas adquiridas. Es un software o hardware (llamado Ledger) diseñado exclusivamente para almacenar y gestionar las claves públicas y claves privadas de nuestras criptomonedas.</li>
                    <li><span>¿Cuántas criptomonedas existen?</span> Actualmente se considera que existen alrededor de 8.500 criptomonedas. Sin embargo, es apropiado aclarar que este número se modifica a diario mediante el surgimiento de diferentes proyectos con sus respectivas criptomonedas.</li>
                    <li><span>¿Cuál es la utilidad de las criptomonedas?</span> Las criptomonedas sirven como medio de intercambio, pero al igual que su cantidad, su utilidad aumenta constantemente. Hoy en día pueden ser utilizadas además de medio de intercambio, como reserva de valor, como instrumento de inversión, y recientemente surgieron los NFT, que son token únicos e irrepetibles asociados a un determinado producto u objeto.</li>
                    <li><span>¿Qué ventajas tienen las criptomonedas sobre el dinero común?</span> Las ventajas son varias: descentralización, anonimato, seguridad, emisión controlada, capacidad de ser reserva de valor, entre muchas otras.</li>
                    <li><span>¿Pueden las criptomonedas desplazar al dinero físico?</span> Ciertamente, aún falta bastante recorrido para que tal situación ocurra. Sin embargo, en LibreCripto creemos que esto sí es posible. Factores como facilidad en su operativa, la masiva adopción, y un mayor conocimiento de las criptomonedas por parte de las personas, influirán de manera positiva a que tal cambio ocurra.</li>
                    <li><span>¿Cómo puedo adquirir criptomonedas?</span> En Argentina existen muchas alternativas para adquirir criptomonedas. Pueden adquirirse mediante exchanges locales de manera física o virtual, o mediante vendedores particulares a través del comercio P2P o F2F.</li>
                </ul>
            </nav>
        </div>
        <div class="libButtonContenedor ">
            <div class="libTitle ">Sobre comercio P2P y F2F</div>
            <nav class="libBody ">
                <ul class="open ">
                    <li><span>¿Qué es el P2P?</span> El comercio P2P -peer-to-peer- refiere al comercio directo entre dos personas interesadas en llevar adelante una operación, sin ningún tipo de intermediarios, realizando la transacción desde un dispositivo virtual (PC, móvil, etc.).</li>
                    <li><span>¿Qué es el F2F?</span> El comercio F2F -face-to-face- supone dar un paso más adelante que el P2P, dando lugar a la modalidad 'cara a cara'. Es decir, conserva la base del P2P pero a diferencia de éste que su esencia radica en operar de manera remota, el intercambio entre las dos partes sucede de manera presencial. </li>
                    <li><span>¿Qué ventajas tienen estas modalidades de comercio?</span> La principal ventaja que tanto el P2P como el F2F suponen es la libertad que ofrecen respecto al costo de las transacciones. Además, se respeta el anonimato originario de las criptomonedas y la libertad de elección de los usuarios interesados en llevar adelante la operación de manera totalmente voluntaria.</li>
                    <li><span>¿Es seguro?</span> Ambos modos son seguros, en tanto las transacciones en el P2P son reguladas por exchanges como Binance, OkEx o similares, y en el F2F la transacción de efectivo a cripto sucede simultáneamente, con la posibilidad de verificar su concreción efectiva antes de abandonar el lugar donde la operación se llevó a cabo. Sin embargo, con el fin de evitar cualquier tipo de problema asociado con estas transacciones, te recomendamos leer nuestro apartado de <a href="guias/recaudos-seguridad.php" target="_blank">Recaudos a tomar a la hora de adquirir criptomonedas</a>.</li>
                </ul>
            </nav>
        </div>
        <div class="commerceButtonContenedor ">
            <div class="commerceTitle ">Sobre LibreCripto</div>
            <nav class="commerceBody ">
                <ul class="open ">
                    <li><span>¿Qué es LibreCripto?</span> LibreCripto es un sitio que ofrece a diferentes usuarios afines a la modalidad de comercio P2P y F2F la posibilidad de aumentar su acceso al mundo de las criptomonedas mediante un marketplace donde diferentes vendedores y operadores ofrecen operaciones para diferentes monedas.</li>
                    <li><span>¿Qué costo tiene utilizar LibreCripto?</span> Utilizar LibreCripto es y siempre será 100% gratuito para todos los usuarios.</li>
                    <li><span>¿Por qué debería utilizar LibreCripto?</span> Nuestro sitio ofrece la posibilidad de mejorar la seguridad y el reconocimiento para aquéllos usuarios interesados en el comercio de criptomonedas, con la posibilidad de gozar de un perfil reputado en base a las propias operaciones realizadas. Esto supone una gran ventaja respecto a otros medios de contacto de vendedores y compradores de criptomonedas en los cuales tales factores no se hacen presentes.</li>

                </ul>
            </nav>
        </div>
    </section>
    <section class="seccion2 contenedor">
        <li class="diviser">
            <a><i class="fas fa-chevron-right "></i></a>
            <a><i class="fas fa-chevron-right "></i></a>
            <p>Usuario y uso del sitio</p>
        </li>
        <div class="regButtonContenedor ">
            <div class="regTitle ">Registrarse</div>
            <nav class="regBody ">
                <ul class="open ">
                    <li>Para registrarte y crear tu nueva cuenta, accedé a la <a href="registro.php" target="_blank">sección de registro</a>. Es 100% gratis y sólo necesitas proporcionar tu nombre, correo electrónico, elegir un nombre de usuario y una contraseña. ¡Así de simple!
                    </li>
                </ul>
            </nav>
        </div>
        <div class="myaccButtonContenedor ">
            <div class="myaccTitle ">Mi cuenta </div>
            <nav class="myaccBody ">
                <ul class="open ">
                    <li><span>¿Cómo accedo a mi cuenta?</span> Una vez que hayas creado tu cuenta, podés iniciar sesión con ella mediante tu email y contraseña desde la sección de acceso de LibreCripto.</li>
                    <li><span>¿Cómo puedo editar mi perfil?</span> Podes editar tu perfil desde el panel "Mi Cuenta". Podes personalizar tu nombre de usuario, tu foto de perfil y modificar tu correo, tu número de teléfono o tu contraseña.</li>
                </ul>
            </nav>
        </div>
        <div class="usuButtonContenedor ">
            <div class="usuTitle ">Contactar otros usuarios </div>
            <nav class="usuBody ">
                <ul class="open ">
                    <li>Para contactar con otros usuarios, podes hacerlo desde el botón "Contactar" que aparece junto a cada anuncio publicado. De este modo se habilitará un chat con el usuario que haya publicado ese anuncio para que puedas hablar con él.
                    </li>
                </ul>
            </nav>
        </div>
        <div class="feeButtonContenedor ">
            <div class="feeTitle ">Anuncios </div>
            <nav class="feeBody ">
                <ul class="open ">
                    <li><span>¿Cómo puedo ver los anuncios publicados?</span> Podes ver todos los anuncios publicados accediendo a la sección de "Mercado Cripto".</li>
                    <li><span>¿Cómo puedo crear mi propio anuncio?</span> Para crear un anuncio, debes acceder a la sección de "Mercado Cripto" y hacer click en el botón "Publicar un anuncio". Te recomendamos leer nuestra <a href="guias/guia-anuncios.php" target="_blank">Guía para la creación de anuncios</a> para que puedas despejar todas tus dudas.</li>
                    <li><span>¿Qué es un usuario CriptoTop?</span> Un usuario CriptoTop es aquél que obtuvo tal distinción por su buen desempeño en las operaciones, ofreciendo un excelente servicio a los demás usuarios y destacándose por sus excelentes calificaciones y contribución al ecosistema LibreCripto. </li>
                    <li><span>¿Que es el fee que aparece en cada anuncio?</span> El fee que aparece junto a cada anuncio publicado significa un porcentaje de comisión: es un monto a cobrar determinado por cada usuario por llevar adelante la operación. Es totalmente independiente a LibreCripto y el sitio no obtiene ningun rédito por él.</li>
                </ul>
            </nav>
        </div>
        <div class="calButtonContenedor ">
            <div class="calTitle ">Calificaciones </div>
            <nav class="calBody ">
                <ul class="open ">
                    <li>Cada vez que completes una operación podrás calificar al usuario con el que la hayas llevado a cabo. Podrás puntuar su atención con 1 a 5 estrellas, y en caso de que lo desees, acompañar esta calificación con una breve reseña.
                    </li>
                </ul>
            </nav>
        </div>
    </section>
    <section class="seccion2 contenedor">
        <li class="diviser">
            <a><i class="fas fa-chevron-right "></i></a>
            <a><i class="fas fa-chevron-right "></i></a>
            <p>Políticas</p>
        </li>
        <div class="termButtonContenedor ">
            <div class="termTitle">Términos y condiciones</div>
            <nav class="termBody ">
                <ul class="open ">
                    <li> Hacé <a href="https://librecripto.com/terminos-y-condiciones" target="_blank">click acá</a> para leer nuestros Términos y Condiciones.  <!--Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi tempore molestiae beatae magnam ipsum commodi deserunt ut eos harum distinctio sit consequatur nihil at cum, rem repudiandae error natus pariatur.-->
                    </li>
                </ul>
            </nav>
        </div>
        <div class="privButtonContenedor">
            <div class="privTitle">Privacidad</div>
            <nav class="privBody">
                <ul class="open">
                    <li> Hacé <a href="https://librecripto.com/politica-de-privacidad" target="_blank">click acá</a> para leer nuestra Política de Privacidad.  <!--Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi tempore molestiae beatae magnam ipsum commodi deserunt ut eos harum distinctio sit consequatur nihil at cum, rem repudiandae error natus pariatur.-->
                    </li>
                </ul>
            </nav>
        </div>

    </section>
    <section class="seccion onda">
        <p class="contenedor textOnda hp"> <a href="https://librecripto.com/contacto">¿No encontraste lo que buscabas? Contactanos desde cualquiera de nuestras vías y responderemos tu inquietud.</a> </p>
    </section>
</main>

<?php include_once 'includes/templates/footer.php'; ?>