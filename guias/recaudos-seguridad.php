<?php

    session_start();
$title = "Seguridad en P2P y F2F | LibreCripto";
    if(!isset($_SESSION['usuario'])){
        include_once '../includes/templates/ayudaheader.php';        
    }else{
        include_once '../includes/templates/ayudaheaderlogged.php';
    }

?>
<main>
    <section class="seccion2 BackNar">
        <h2 class="titleAccount">Seguridad en el comercio P2P y F2F</h2>
    </section>
    <section class="seccion2 contenedor recaudos">
        <p>En LibreCripto creemos que tu seguridad a la hora de realizar una operación es lo mas importante. Ya sea que vendas o compres criptomonedas, es importante que tomes en cuenta algunas medidas con la finalidad de preveer cualquier tipo de percance a la hora de llevar adelante tu operación. </p>
    </section>
    <section class="seccion2 contenedor recaudos">
        <p class="divisortext">En caso de que operes P2P...</p>
        <p>Hay distintas plataformas que ofrecen este tipo de operaciones. Nuestra recomendacion es que utilices una confiable y con reputación, de modo que tus activos estén protegidos cuando lleves adelante la transacción y en caso de que surja cualquier inconveniente, te hayes respaldado y no corras ningún riesgo con tu dinero.</p>
        <p>Uno de estos sitios, y el más utilizado por excelencia, es <a href="https://p2p.binance.com/es-AR" target="_blank">Binance P2P.</a> Desde allí podes comerciar tus criptomonedas por dinero físico y de manera segura ya que la propia plataforma de Binance se encarga de operar como mediador en toda la transacción.</p>
        <p>Como medida de seguridad, te recomendamos que cuando contactes a un usuario a través de LibreCripto para comerciar P2P, verifiques que sus credenciales se asemejen a las presentadas en la plataforma donde vas a llevar adelante el intercambio, de modo que una vez concluida puedas calificarlo correctamente en LibreCripto y además contribuir así a mejorar la seguridad para próximos usuarios. ;)</p>
        <p>También te recomendamos que ya sea Binance o cualquier otro semejante, siempre utilices plataformas seguras que bloqueen los depósitos a la hora de llevar adelante la transacción y el intercambio sea monitoreado, de modo que así puedas evitar caer en estafas o robos.</p>
    </section>
    <section class="seccion2 contenedor recaudos">
        <p class="divisortext">En caso de que operes F2F...</p>
        <p>Algunos tips a tener en cuenta a la hora de comerciar criptomonedas con esta modalidad:</p>
        <ul>
            <li>Verificá la reputación del usuario con el que vas a llevar adelante la operación.</li>
            <li>Chequeá la dirección a donde va a concurrir la transacción antes de asistir.</li>
            <li>Ponete de acuerdo con el otro usuario para que el intercambio suceda al mismo tiempo. Por ejemplo, si vos entregas efectivo, que al mismo tiempo el otro usuario envie las criptomonedas equivalentes a tu wallet.</li>
            <li>No te retires del lugar de la transacción sin haber recibido tus criptomonedas.</li>
            <li>NUNCA entregues tu celular: para realizar la transferencia de criptomonedas únicamente van a necesitar tu dirección de wallet, si entregas tu celular pueden acceder a robar tus datos de acceso y de ese modo estarías poniendo en peligro todo tu dinero.</li>
            <li>En caso de que lo consideres pertinente, solicitá al usuario con el que vas a llevar adelante la operación toda la información que consideres necesaria.</li>
            <li>No te olvides de calificar al usuario una vez concluida la operación, de ese modo contribuís a mejorar la seguridad general para todos los usuarios de LibreCripto ;)</li>
        </ul>
    </section>
    <section class="seccion2 contenedor recaudos">
        <p>¡Esperamos que estos tips te sirvan y te ayuden en tu operatoria a través de LibreCripto! Si necesitás más ayuda al respecto podes hacer <a href= "../ayuda.php" target="_blank">click acá</a> y si tuviste algún inconveniente podes contactarnos haciendo <a href="../forms.php" target="_blank"> click acá</a>. Nos pondremos en contacto para ayudarte lo mas pronto posible.</p>
    </section>
</main>
<?php
    include_once '../includes/templates/ayudafooter.php';
?>