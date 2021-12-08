<?php
session_start();
?>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/usersidebar.css">
    <script type="text/javascript" src="https://files.coinmarketcap.com/static/widget/coinMarquee.js"></script>
</head>

<?php
$title = "Mercado Cripto | LibreCripto";
require 'php/Carbon/autoload.php';
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonInterface;
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
        $thisuser = $_SESSION['user'];
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
?>

<main>
    <section class="seccion2 BackNar">
        <h2 class="titleAccount">Mercado Cripto</h2>
    </section>
    <div id="coinmarketcap-widget-marquee" coins="1,1027,2010,1839,52,5426,6636,74,4172,7083,825,3408,4687,4943" currency="USD" theme="light" transparent="false" show-symbol-logo="true"></div>    
    <div class="usersidebar">
        <div class="page-wrapper chiller-theme">
            <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
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
                                    <a href="https://librecripto.com/myannouncements?user=<?php echo $_SESSION['user'];?>">Mis Anuncios
                                    </a>
                                    </li>
                                    <li>
                                    <a href="https://librecripto.com/mychats?user=<?php echo $_SESSION['user'];?>">Mis Chats</a>
                                    </li>
                                    <li>
                                    <a href="https://librecripto.com/myoperations?user=<?php echo $_SESSION['user'];?>">Mis Operaciones</a>
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
    <section class= "seccion contenedor">
        <h3 class="titlePublish">Anuncios generales</h3>
            <button class="filterButton" id="filterbutton">Búsqueda personalizada <i class="fas fa-search"></i></button>
            <div class="overlay" id="filteroverlay">
                <div class="publishannouncer filter" id="filterpublishannouncer">
                    <a href="#" id="filterbtn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times"></i></a>
                    <h3>Buscar un anuncio</h3>
                    <form accept-charset="utf-8" method="POST">
                        <div class="filterSearch">
                            <input type="text" name="busqueda" id="busqueda" value="" placeholder="" maxlength="200" autocomplete="off" onKeyUp="buscar();" /><i class="fas fa-search"></i>
                            <p class="filterinfo"><span>¿Cómo funciona?</span> Escribí el término por el cual querés filtrar los anuncios; puede ser por nombre de usuario, provincia, localidad, criptomoneda, operación (Compra/Venta) o método (P2P/F2F). Se mostrarán todos los anuncios relacionados con la búsqueda que hayas realizado.</p>
                        </div>
                    </form>
                    <div class="publishShow">
                        <div id="resultadoBusqueda"></div>
                    </div>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $("#resultadoBusqueda").html('');
                        });
                        function buscar() {
                            var textoBusqueda = $("input#busqueda").val();
                            if (textoBusqueda != "") {
                                $.post("buscar.php", {valorBusqueda: textoBusqueda}, function(mensaje) {
                                    $("#resultadoBusqueda").html(mensaje);
                                }); 
                            } else { 
                                ("#resultadoBusqueda").html('');
                            };
                        };
                    </script>
                </div>
            </div>
            <div class="overlay" id="overlay">
                <div class="publishannouncer" id="publishannouncer">
                    <a href="#" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times"></i></a>
                    <h3>Publicar un anuncio</h3>
                    <h4>Gratis, de inmediato y con la más alta exposición</h4>
                    <form name="publishform" class="publishform" id="publishform" method="POST" action="" onsubmit="return validateForm()">
                        <div name="publish" class="contenedor-inputs">
                            <div class="thirdone">
                                <div class="locationtitle">
                                    <p>Ubicación</p><i class="helplocbutton fa fa-question-circle" aria-hidden="true"></i>
                                </div>
                                <div class="location">
                                        <div class="locationselector">
                                            <div class="loc1">
                                                <p>Provincia</p>
                                                <select name="provincia" id="provincia" onchange="cambia_localidad();show_provincia();disabledprovloc();">
                                                    <option value="0" disabled selected>Seleccionar provincia</option>
                                                    <option value="1">Ciudad Autónoma de Buenos Aires</option>
                                                    <option value="2">Provincia de Buenos Aires</option>                                
                                                    <option value="3">Córdoba</option>
                                                    <option value="4">Santa Fe</option>
                                                    <option value="5">Mendoza</option>
                                                    <option value="6">Tucumán</option>
                                                    <option value="7">Entre Ríos</option>
                                                    <option value="8">Salta</option>
                                                    <option value="9">Misiones</option>
                                                    <option value="10">Chaco</option>
                                                    <option value="11">Corrientes</option>
                                                    <option value="12">Santiago del Estero</option>
                                                    <option value="13">San Juan</option>
                                                    <option value="14">Jujuy</option>
                                                    <option value="15">Río Negro</option>
                                                    <option value="16">Chubut</option>
                                                    <option value="17">Neuquén</option>
                                                    <option value="18">Formosa</option>
                                                    <option value="19">San Luis</option>
                                                    <option value="20">Catamarca</option>
                                                    <option value="21">La Rioja</option>
                                                    <option value="22">La Pampa</option>
                                                    <option value="23">Santa Cruz</option>
                                                    <option value="24">Tierra del Fuego</option>
                                                </select>
                                                <script type="text/javascript">
                                                    function show_provincia(){
                                                        var provincia = document.getElementById('provincia');
                                                        var selected = provincia.options[provincia.selectedIndex].text;
                                                        document.getElementById("selected").value = selected;
                                                        console.log(selected);
                                                    }
                                                </script>
                                                <input type="hidden" id="selected" name="selected" value=" "></input>
                                            </div>
                                            <div class="loc2">
                                                <p>Localidad</p>
                                                <select name="localidad" id="localidad" disabled> 
                                                    <option value=" " selected>Seleccionar localidad</option>
                                                </select>
                                            </div>
                                                <script type="text/javascript">
                                                    var localidad_1=new Array("Seleccionar localidad", "Comuna 1","Comuna 2","Comuna 3","Comuna 4","Comuna 5","Comuna 6","Comuna 7","Comuna 8","Comuna 9","Comuna 10","Comuna 11","Comuna 12","Comuna 13","Comuna 14","Comuna 15",);
                                                    var localidad_2=new Array("Seleccionar localidad","Zona Norte","Zona Oeste","Zona Sur", "Zona Gran La Plata", "Otros");
                                                    var localidad_3=new Array("Seleccionar localidad","Gran Córdoba","Gran Río Cuarto","Colón","Punilla","Gral San Martín", "Otros");
                                                    var localidad_4=new Array("Seleccionar localidad","Rosario","La Capital","General López","General Obligado", "San Lorenzo", "Otros");
                                                    var localidad_5=new Array("Seleccionar localidad","Capital","Guaymallén","Las Heras","Godoy Cruz","San Rafael", "Maipú", "Otros");
                                                    var localidad_6=new Array("Seleccionar localidad","Capital","Cruz Alta","Tafí Viejo","Chicligasta","Yerba Buena", "Otros");
                                                    var localidad_7=new Array("Seleccionar localidad","Paraná","Concordia","Gualeguaychú","Uruguay","Federación", "Colón", "Otros");
                                                    var localidad_8=new Array("Seleccionar localidad","Capital","Gral José de San Martín","Orán","Anta","General Güemes", "Rivadavia", "Otros");
                                                    var localidad_9=new Array("Seleccionar localidad","Capital","Oberá","Igüazú","Eldorado","Guaraní", "San Ignacio", "Otros");
                                                    var localidad_10=new Array("Seleccionar localidad","San Fernando","Comandante Fernández","General Güemes","Libertador Gral San Martín","Chacabuco", "Almirante Brown", "Otros");
                                                    var localidad_11=new Array("Seleccionar localidad","Capital","Goya","Santo Tomé","Paso de los Libres","Bella Vista", "Ituzaingó", "Otros");
                                                    var localidad_12=new Array("Seleccionar localidad","Juan Francisco Borges","Banda","Río Hondo","Robles", "Otros");
                                                    var localidad_13=new Array("Seleccionar localidad","Capital","Rawson","Chimbas","Rivadavia","Pocito", "Santa Lucía", "Otros");
                                                    var localidad_14=new Array("Seleccionar localidad","Dr. Manuel Belgrano","El Carmen","San Pedro","Ledesma","Palpalá", "Humahuaca", "Otros");
                                                    var localidad_15=new Array("Seleccionar localidad","General Roca","Bariloche","Adolfo Alsina","Avellaneda","San Antonio", "Otros");
                                                    var localidad_16=new Array("Seleccionar localidad","Rawson","Escalante","Biedma","Futaulefú","Cushamen", "Otros");
                                                    var localidad_17=new Array("Seleccionar localidad","Confluencia","Zapala","Lácar","Pehuenches", "Otros");
                                                    var localidad_18=new Array("Seleccionar localidad","Formosa","Pilcomayo","Patiño","Pirané", "Otros");
                                                    var localidad_19=new Array("Seleccionar localidad","Juan Martín de Pueyrredon","General Pedernera","Junín","Chacabuco","Ayacucho", "Coronel Pringles", "Otros");
                                                    var localidad_20=new Array("Seleccionar localidad","Capital","Belén","Valle Viejo","La Paz","Tinogasta", "Otros");
                                                    var localidad_21=new Array("Seleccionar localidad","Capital","Chilecito","Arauco","Famatina", "Otros");
                                                    var localidad_22=new Array("Seleccionar localidad","Capital","Maracó","Realicó","Utracán", "Otros");
                                                    var localidad_23=new Array("Seleccionar localidad","Güer Aike","Deseado","Lago Argentino","Corpen Aike", "Otros");
                                                    var localidad_24=new Array("Seleccionar localidad","Río Grande","Ushuaia","Tolhuin");
                                                    
                                                    var todaLocalidad = [
                                                    [],
                                                    localidad_1,
                                                    localidad_2,
                                                    localidad_3,
                                                    localidad_4,
                                                    localidad_5,
                                                    localidad_6,
                                                    localidad_7,
                                                    localidad_8,
                                                    localidad_9,
                                                    localidad_10,
                                                    localidad_11,
                                                    localidad_12,
                                                    localidad_13,
                                                    localidad_14,
                                                    localidad_15,
                                                    localidad_16,
                                                    localidad_17,
                                                    localidad_18,
                                                    localidad_19,
                                                    localidad_20,
                                                    localidad_21,
                                                    localidad_22,
                                                    localidad_23,
                                                    localidad_24,

                                                    ];

                                                    function cambia_localidad(){ 
                                                        var provincia 
                                                        provincia = document.publishform.provincia[document.publishform.provincia.selectedIndex].value 
                                                        if (provincia != 0) {
                                                            mi_localidad=todaLocalidad[provincia]
                                                            num_localidad = mi_localidad.length 
                                                            document.publishform.localidad.length = num_localidad 
                                                            for(i=0;i<num_localidad;i++){ 
                                                                document.publishform.localidad.options[i].value=mi_localidad[i] 
                                                                document.publishform.localidad.options[i].text=mi_localidad[i] 
                                                            }
                                                        }else{ 
                                                            document.publishform.localidad.length = 1 
                                                            document.publishform.localidad.options[0].value = " " 
                                                            document.publishform.localidad.options[0].text = "Seleccionar localidad" 
                                                        } 
                                                        document.publishform.localidad.options[0].selected = true 
                                                        document.publishform.localidad.options[0].disabled = true 
                                                }
                                                function disabledprovloc(){
                                                    var provincia
                                                    var localidad = document.getElementById('localidad')
                                                    if(provincia != 0){
                                                        localidad.disabled = false
                                                    }
                                                }
                                            </script>
                                        </div>
                                </div>
                            </div>
                            <div class="secondthree">
                                <div class="currency">
                                    <p>Moneda</p>
                                    <div class="currencyselector">
                                        <select name="currency" id="currency" onchange="show_moneda();">
                                            <option value="0" selected disabled>Seleccionar moneda</option>   
                                            <option value="1">Dólar estadounidense (USD)</option>                                
                                            <option value="2">Bitcoin (BTC)</option>
                                            <option value="3">Ethereum (ETH)</option>
                                            <option value="4">Binance Coin (BNB)</option>
                                            <option value="5">Cardano (ADA)</option>
                                            <option value="6">Dogecoin (DOGE)</option>
                                            <option value="7">XRP (XRP)</option>
                                            <option value="8">Polkadot (DOT)</option>
                                            <option value="9">Uniswap (UNI)</option>
                                            <option value="10">Litecoin (LTC)</option>
                                            <option value="11">Chainlink (LINK)</option>
                                            <option value="12">Tether (USDT)</option>
                                            <option value="13">USD Coin (USDC)</option>
                                            <option value="14">Binance USD (BUSD)</option>
                                            <option value="15">DAI (DAI)</option>
                                        </select>
                                        <script type="text/javascript">
                                            function show_moneda(){
                                                var currency = document.getElementById('currency');
                                                var currencyselected = currency.options[currency.selectedIndex].text;
                                                document.getElementById("currencyselected").value = currencyselected;
                                                console.log(currencyselected);
                                            }
                                        </script>
                                        <input type="hidden" id="currencyselected" name="currencyselected" value=" "></input>
                                    </div>
                                </div>
                                <div class="quantfeecontainer">
                                    <div class="quantity">
                                        <p>Cantidad</p>
                                        <div class="quantityselector">
                                            <input type="number" name="quantity" id="quantIndicator" value="0" step="0.1" min="0">
                                        </div>
                                    </div>
                                    <div class="fee">
                                        <div class="feeptitle">
                                            <p>Porcentaje de Comisión</p><i class="helpfeebutton fa fa-question-circle" aria-hidden="true"></i>
                                        </div>
                                        <div class="feeselector">
                                            <input type="number" name="fee" id="feeIndicator" value="0" step="0.1" min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="firsttwo">
                                <div class="operationcheck">
                                    <div class="operationtitle">
                                        <p>Elegir Operación</p><i class="helpopbutton fa fa-question-circle" aria-hidden="true"></i>
                                    </div>
                                    <input type="radio" id="checkCompra" name="operation" value="Compra">
                                    <label for="checkCompra">Comprar</label>

                                    <input type="radio" id="checkVenta" name="operation" value="Venta">
                                    <label for="checkVenta">Vender</label>
                                </div>
                                <div class="methodcheck">
                                    <div class="methodtitle">
                                        <p>Elegir Método</p><i class="helpmetbutton fa fa-question-circle" aria-hidden="true"></i>
                                    </div>
                                    <input type="checkbox" id="checkP2P" name="p2p" value="" onClick="P2P(this)">
                                    <label for="checkP2P">P2P</label>

                                    <input type="checkbox" id="checkF2F" name="f2f" value=""onClick="F2F(this)">
                                    <label for="checkF2F">F2F</label>
                                </div>
                            </div>
                        </div>
                        <p>Si necesitás ayuda podés revisar nuestra <span><a href="https://librecripto.com/guias/guia-anuncios" target="_blank">Guía para la creación de anuncios</a></span></p>
                        <input type="submit" id="publicar" name="publicar" class="btn-submit" value="Publicar">
                        <script type="text/javascript">
                        function validateForm() {
                            var provincia = document.forms["publishform"]["provincia"].value;
                            var localidad = document.forms["publishform"]["localidad"].value;
                            var currency = document.forms["publishform"]["currency"].value;
                            var quantity = document.forms["publishform"]["quantity"].value;
                            var fee = document.forms["publishform"]["fee"].value;
                            var operation = document.forms["publishform"]["operation"].value;
                            var p2p = document.forms["publishform"]["p2p"].value;
                            var f2f = document.forms["publishform"]["f2f"].value;
                            if (provincia == "0" || localidad == " " || currency == "0" || quantity == "0" || fee == "" || (operation != "Compra" && operation != "Venta") || (p2p == "" && f2f == "")) {
                                setTimeout(function () {
                                swal("¡Ups!","Parece que hay opciones sin seleccionar. Por favor completá todos los campos para poder publicar tu anuncio.","error", {button: "Intentar de nuevo",})
                                }, 200);
                                return false;
                            }
                        }
                        </script>
                    </form>
                </div>
            </div>
            <?php 
$correo = filter_var($_SESSION['correo'], FILTER_SANITIZE_EMAIL);
    $nombre = filter_var($_SESSION['nombre'], FILTER_SANITIZE_STRING);
                if(isset($_POST['publicar'])){
                    function secure($value){
                        include 'php/conexion_be.php';
                        $value = trim($value);
                        $value = stripslashes($value);
                        $value = htmlspecialchars($value);
                        $value = mysqli_real_escape_string($conexion, $value);
                        return $value;
                    }
                    $usuario = filter_var($_SESSION['usuario'] , FILTER_SANITIZE_STRING);
                    $id = filter_var($_SESSION['id'] , FILTER_SANITIZE_NUMBER_INT);
                    $user = filter_var($_SESSION['user'] , FILTER_SANITIZE_NUMBER_INT);
                    $provincia = secure($_POST['selected']);
                    $localidad = empty($_POST['localidad']) ? NULL : secure($_POST['localidad']);
                    $currency = secure($_POST['currencyselected']);
                    $quantity = mysqli_real_escape_string($conexion, $_POST['quantity']);
                    $fee = mysqli_real_escape_string($conexion, $_POST['fee']);
                    $operation = empty($_POST['operation']) ? NULL : secure($_POST['operation']);
                    $p2p = empty($_POST['p2p']) ? NULL : secure($_POST['p2p']);
                    $f2f = empty($_POST['f2f']) ? NULL : secure($_POST['f2f']);

                    $query = "INSERT INTO anuncios(usuario, id, user, fecha, provincia, localidad, moneda, cantidad, comision, operacion, p2p, f2f)
                    VALUES('$usuario', '$id', '$user', now(), '$provincia', '$localidad', '$currency', '$quantity', '$fee', '$operation', '$p2p', '$f2f')";

                    $ejecutar = mysqli_query($conexion, $query);
                    if($ejecutar){
                        echo '<script type="text/javascript">';
                        echo 'setTimeout(function () {';
                        echo 'swal("¡Anuncio publicado!","Ya podés verlo en la sección de anuncios generales","success").then( function(val) {';
                        echo 'if (val == true) window.location.href = \'https://librecripto.com/market\';';
                        echo '});';
                        echo '}, 200);  </script>';
                        require 'php/src/Exception.php';
                        require 'php/src/PHPMailer.php';
                        require 'php/src/SMTP.php';
                
                        $smtpHost = "c2410691.ferozo.com";
        $smtpUsuario = "librecripto@librecripto.com";
        $smtpClave = "Lk3209lk";  // Mi contraseña

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->IsHTML(true);
        $mail->CharSet = "utf-8";

        $mail->Host = $smtpHost;
        $mail->Username = $smtpUsuario;
        $mail->Password = $smtpClave;


        $mail->From = $smtpUsuario;
        $mail->FromName = 'LibreCripto';
        $mail->AddAddress($correo);
        $mail->AddReplyTo('no-reply@librecripto.com','no-reply');

        $mail->Subject = "¡Acabas de publicar un anuncio!";
        $mensajeHtml = nl2br($mensaje);
        $mail->Body = "
         <html>

         <body>

         <h3>¡Hola, $nombre!</h3>
                                
                        <p>¡Acabas de publicar un anuncio!</p>
                        <p>Ya está apareciendo en la sección de anuncios generales del Mercado Cripto.</p>
                        <p>Recordá que podés modificarlo o eliminarlo desde el apartado 'Mis Anuncios'.</p>
                            
                        <p>¡Muchas gracias! Con tu participación contribuis a hacer de LibreCripto un mejor ecosistema cripto ;)</p>
                            
                        <p>Saludos, <b>-El equipo de LibreCripto.</b></p>
         </body>

         </html>

        <br />";

        $mail->SMTPOptions = array(
         'ssl' => array(
         'verify_peer' => false,
         'verify_peer_name' => false,
         'allow_self_signed' => true
         )
        );

        $estadoEnvio = $mail->Send();
                        exit();
                    }else{
                        echo '<script type="text/javascript">';
                        echo 'setTimeout(function () {';
                        echo 'swal("Algo salió mal...","No se pudo publicar tu anuncio. Por favor, intentá de nuevo.","error").then( function(val) {';
                        echo 'if (val == true) window.location.href = \'https://librecripto.com/market\';';
                        echo '});';
                        echo '}, 200);  </script>';
                    }
                    
                }
            ?>
            <?php
                $consult = mysqli_query($conexion, "SELECT * FROM anuncios ORDER BY id_pub DESC");
            ?>
            <div class="publishShow" id="publishShow">
                
                    <?php
                    while($lista = mysqli_fetch_array($consult)){
                            $userid = mysqli_real_escape_string($conexion, filter_var($lista['id'], FILTER_SANITIZE_NUMBER_INT));
                            $usuariob = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id = '".mysqli_real_escape_string($conexion, $userid)."'");
                            $use = mysqli_fetch_array($usuariob);
                    ?>
                            <div class="publishContainer" id="publishPopupOpener">
                                <div class="publish">
                                    <div class="publishCUser">
                                    <?php
                                        if(filter_var($use['id'] , FILTER_SANITIZE_NUMBER_INT) == filter_var($_SESSION['id'] , FILTER_SANITIZE_NUMBER_INT)){
                                        ?>
                                        <div class="publishMyAnnounce">
                                        <p>Mi anuncio</p>
                                        </div>
                                        <?php
                                        }else{
                                        ?>
                                            <div class="publishCPic">
                                            <img class="profpicpub" src="img/profilepics/<?php echo filter_var($use['avatar'] , FILTER_SANITIZE_STRING);?>" alt="Avatar">
                                            </div>
                                            <a class="publishCTitle"><span>@</span><?php echo filter_var($use['usuario'] , FILTER_SANITIZE_STRING);?></a>
                                        <?php
                                        }
                                    ?>
                                    </div>
                                    <div class="publishCInfo">
                                        <?php 
                                        $date = $lista['fecha']; 
                                        $now = Carbon::now(new DateTimeZone('America/Argentina/Buenos_Aires'));
                                        $publishdate = Carbon::create($date, 'America/Argentina/Buenos_Aires');
                                        $publishdate->locale('es');
                                        $diff = $publishdate->diffForHumans($now, CarbonInterface::DIFF_RELATIVE_TO_NOW);
                                        ?>
                                        <p class="publishCDate">Publicado <?php echo $diff?></p> 
                                        <div class="publishCZone"><p class="publishCProv">En <?php echo filter_var($lista['provincia'] , FILTER_SANITIZE_STRING);?></p> <p class="publishCLoc"><?php echo filter_var($lista['localidad'] , FILTER_SANITIZE_STRING);?></p></div>
                                    </div>
                                    <div class="publishCDisplay">
                                        <div class="publishCOffer">
                                            <p class="publishCQuantity"><?php echo $lista['cantidad']?></p>
                                            <p class="publishCCurrency"><?php echo filter_var($lista['moneda'] , FILTER_SANITIZE_STRING);?></p>
                                        </div>
                                        <p class="publishCFee">Fee <?php echo $lista['comision']?>%</p>
                                    </div>
                                    <div class="publishCDetails">
                                        <p class="publishCOperation"><?php echo filter_var($lista['operacion'] , FILTER_SANITIZE_STRING);?></p>
                                        <div class="publishCMethod">
                                            <p class="publishCMethodAccepted"><?php if(filter_var($use['id'] , FILTER_SANITIZE_NUMBER_INT) == filter_var($_SESSION['id'] , FILTER_SANITIZE_NUMBER_INT)){ echo 'Aceptas:';}else{ echo 'Acepta:';}?></p><p class="publishCP2P"><?php echo filter_var($lista['p2p'] , FILTER_SANITIZE_STRING);?></p><p class="publishCF2F"><?php echo filter_var($lista['f2f'] , FILTER_SANITIZE_STRING);?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                    if($use['criptotop'] != filter_var('0', FILTER_SANITIZE_NUMBER_INT)) {?>
                                        <div class="publishCriptoTop">
                                            <p class="publishCriptoTopShow">Cripto<span>Top</span></p>
                                        </div>
                                <?php } ?>
                            
                    
                                <div class="publishOverlay">
                                    <div class="publishannounce">
                                        <a href="#"class="btn-cerrar-popup"><i class="fas fa-times"></i></a>
                                        <?php
                                        if(filter_var($use['id'] , FILTER_SANITIZE_NUMBER_INT) == filter_var($_SESSION['id'] , FILTER_SANITIZE_NUMBER_INT)){
                                        ?>
                                        <div class="publishMyAnnounceNotice">
                                        <p>Así verán tu anuncio los demás usuarios. <a href="https://librecripto.com/myannouncements?user=<?php echo mysqli_real_escape_string($conexion, $use['user'])?>">Editar</a></p>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                        <div class="publishDfirsttwo">
                                            <div class="publishDUser">
                                                <div class="publishDPic">
                                                <img class="profpicDpub" src="img/profilepics/<?php echo filter_var($use['avatar'] , FILTER_SANITIZE_STRING);?>" alt="Avatar">
                                                </div>
                                                <div class="publishDUserProfile">
                                                <p class="publishDTitle"><span>@</span><?php echo filter_var($use['usuario'] , FILTER_SANITIZE_STRING);?></p>
                                                <li class="publishDdiviser">
                                                    <a><i class="fas fa-chevron-right "></i></a>
                                                    <a href="https://librecripto.com/userprofile?user=<?php echo filter_var($use['user'] , FILTER_SANITIZE_NUMBER_INT);?>" class="publishDProfile">Ver perfil</a>
                                                </li>
                                                </div>
                                                <?php 
                                                    if($use['criptotop'] != filter_var('0', FILTER_SANITIZE_NUMBER_INT)) {?>
                                                        <div class="publishDCriptoTop">
                                                            <div class="publishDcriptotopmedalshow">
                                                                <img class="publishDcriptotopmedal" src= "img/criptotopmedal.png" alt="Usuario Cripto Top"></img>
                                                            </div>
                                                            <!--<p class="publishDCriptoTopShow">Este usuario es Cripto<span>Top</span>, lo que significa que se caracteriza por su buena atención y su capacidad de venta.</p>-->
                                                        </div>
                                                <?php } ?>
                                            </div>
                                            <div class="publishDInfo">
                                                <p class="publishDDate">Publicado el <?php echo date('d/m/Y', strtotime($date))?> a las <?php echo date('G:i', strtotime($date))?></p> 
                                                <div class="publishDZone"><p class="publishDProv">En <?php echo filter_var($lista['provincia'] , FILTER_SANITIZE_STRING);?> <p class="publishDLoc"><?php echo filter_var($lista['localidad'] , FILTER_SANITIZE_STRING);?></p></div>
                                            </div>
                                        </div>
                                        <div class="publishDsecondthree">
                                            <p class="publishDOperation"><?php echo filter_var($lista['operacion'] , FILTER_SANITIZE_STRING);?></p>
                                            <div class="publishDOffer">
                                                <p class="publishDQuantity"><?php echo $lista['cantidad']?></p>
                                                <p class="publishDCurrency"><?php echo filter_var($lista['moneda'] , FILTER_SANITIZE_STRING);?></p>
                                            </div>
                                            <p class="publishDFee">Fee <?php echo $lista['comision']?>%</p>
                                        </div>
                                        <div class="publishDthirdone">
                                            <span>Métodos aceptados: </span><div class="publishDPayment"><li class="publishDP2P"><?php echo filter_var($lista['p2p'] , FILTER_SANITIZE_STRING);?></li><li class="publishDF2F"><?php echo filter_var($lista['f2f'] , FILTER_SANITIZE_STRING);?></li></div>
                                        </div>
                                        <div class="publishDcontactbutton">
                                            <a href="https://librecripto.com/chat?user=<?php echo filter_var($use['user'] , FILTER_SANITIZE_NUMBER_INT);?>">Contactar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php } ?>
            </div>
            <div class="bsbuttoncontainer">
                <button id="btn-publish-popup" class="btnpublish btn-publish-popup">Publicar un anuncio</button>
            </div>
    </section>
</main>
<?php include_once 'includes/templates/footermarket.php'; ?>