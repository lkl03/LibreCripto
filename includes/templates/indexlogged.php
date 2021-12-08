<?php
session_start();
$thisuser = $_SESSION['user'];
$opconsult = ("SELECT opverif FROM operaciones WHERE usertoconfirm='$thisuser' ORDER BY operationid DESC");
$opresult = mysqli_query($conexion, $opconsult);
$oprow = mysqli_fetch_array($opresult);
    if($oprow == null){
        include 'includes/templates/headerlogged.php'; 
    }else{
        if($oprow['opverif'] == 0){
        include_once 'includes/templates/headerloggedop.php'; 
    }else{
        include 'includes/templates/headerlogged.php'; 
    }  
}


?>
<main>
        <!--bienvenida-->
        <section class="seccion2 BackNar">
            <h2 class="titleLogged">¡Bienvenid@ <?php echo $_SESSION['nombre']?>! ¡Qué bueno verte otra vez!</h2>
        </section>
        <!--primer texto-->
        <section class="seccion">
            <h3 class="titleCriptoAdvice seccion2 contenedor">Así se encuentran las principales criptomonedas en este momento.</h3>
            <div class="widgetPC">
                <script type="text/javascript" src="https://files.coinmarketcap.com/static/widget/coinPriceBlock.js"></script>
                <div id="coinmarketcap-widget-coin-price-block" coins="1,1027,2010,1839,52,5426,6636,74,4172,825,3408,4943" currency="USD" theme="light" transparent="false" show-symbol-logo="true"></div>
                <p class="textAdvice">Cotizaciones en dólar estadounidense (USD) --- Refrescando la página podes actualizar los precios</p>
            </div>
            <div class="widgetMobile">
                <script>
                    ! function() {
                        var e = document.getElementsByTagName("script"),
                            t = e[e.length - 1],
                            n = document.createElement("script");

                        function r() {
                            var e = crCryptocoinPriceWidget.init({
                                base: "USD",
                                items: "BTC,LINK,ETH,USDT,BNB,ADA,DOGE,XRP,DOT,USDC,UNI,LTC",
                                backgroundColor: "FFFFFF",
                                streaming: "1",
                                rounded: "1",
                                boxShadow: "1",
                                border: "1"
                            });
                            t.parentNode.insertBefore(e, t)
                        }
                        n.src = "https://co-in.io/es/widget/pricelist.js?items=BTC%2CETH%2CUSDT%2CBNB%2CADA%2CDOGE%2CXRP%2CDOT%2CUSDC%2CUNI", n.async = !0, n.readyState ? n.onreadystatechange = function() {
                            "loaded" != n.readyState && "complete" != n.readyState || (n.onreadystatechange = null, r())
                        } : n.onload = function() {
                            r()
                        }, t.parentNode.insertBefore(n, null)
                    }();
                </script>
                <p class="textAdvice">Cotizaciones en dólar estadounidense (USD) --- Tocando cada cotización podes ver más información de la misma</p>
            </div>
        </section>

        <!--tercertexto-->
        <section class="seccion3">
            <div class="redirectSpace">
                <div class="contenedorMercado">
                        <a class="goMercado" href="https://librecripto.com/market">Ir al Mercado Cripto</a>
                </div>
                <div class="contenedorAccount">
                    <a class="goAccount" href="https://librecripto.com/myprofile?user=<?php echo $_SESSION['user'];?>">Ir a Mi Cuenta</a>
                </div>
            </div>
            </div>
        </section>
    </main>
<?php include_once 'includes/templates/footer.php'; ?>