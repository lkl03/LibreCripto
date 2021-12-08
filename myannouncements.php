<?php
session_start();
require_once 'php/conexionverify.php';

?>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/usersidebar.css">
</head>
<?php 
$title = "Mis Anuncios | LibreCripto";
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
    
if(isset($_GET['user'])){
    $user = filter_var($_GET['user'], (FILTER_SANITIZE_NUMBER_INT));

    $myuser = mysqli_query($conexion, "SELECT * FROM usuarios WHERE user = '".mysqli_real_escape_string($conexion, $user)."' ");
    $usef = mysqli_fetch_array($myuser);

    if(filter_var($_SESSION['user'] , FILTER_SANITIZE_NUMBER_INT) != filter_var($user , FILTER_SANITIZE_NUMBER_INT)) {
    echo '<script type="text/javascript">';
    echo 'setTimeout(function () {';
    echo 'swal("Ups!","No deberías estar en esta página","error").then( function(val) {';
    echo 'if (val == true) window.location.href = \'https://librecripto.com/acceso\';';
    echo '});';
    echo '}, 200);  </script>';
    session_destroy();
    die();
    }
}
?>
<main>
<section class="seccion2 BackNar">
        <h2 class="titleAccount">Mis Anuncios</h2>
</section>
<div class="usersidebar">
        <div class="page-wrapper chiller-theme">
            <a id="show-sidebar" class="btn btn-sm btn-dark mya" href="#">
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
                                <span onclick="window.location.href='https://librecripto.com/mydashboard?user=<?php echo filter_var($_SESSION['user'] , FILTER_SANITIZE_NUMBER_INT);?>'">Panel de Usuario</span>
                                </a>
                                <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                    <a href="https://librecripto.com/myannouncements?user=<?php echo filter_var($_SESSION['user'] , FILTER_SANITIZE_NUMBER_INT);?>">Mis Anuncios
                                    </a>
                                    </li>
                                    <li>
                                    <a href="https://librecripto.com/mychats?user=<?php echo filter_var($_SESSION['user'] , FILTER_SANITIZE_NUMBER_INT);?>">Mis Chats</a>
                                    </li>
                                    <li>
                                    <a href="https://librecripto.com/myoperations?user=<?php echo filter_var($_SESSION['user'] , FILTER_SANITIZE_NUMBER_INT);?>">Mis Operaciones</a>
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
<section class="seccion contenedor">
        <!--<h3 class="titlePublish">Anuncios activos</h3>-->
        <?php
            $consult = mysqli_query($conexion, "SELECT * FROM anuncios WHERE user = '".mysqli_real_escape_string($conexion, $user)."' ORDER BY id_pub DESC");
        ?>
        <div class="publishmShow">
            <?php
            while($lista = mysqli_fetch_array($consult)){
                    $userid = mysqli_real_escape_string($conexion, filter_var($lista['id'], FILTER_SANITIZE_NUMBER_INT));
                    $usuariob = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id = '".mysqli_real_escape_string($conexion, $userid)."'");
                    $use = mysqli_fetch_array($usuariob);
                    $idpub = mysqli_real_escape_string($conexion, $lista['id_pub']);
            ?>
                    <div class="publishContainer">
                        <div class="publish">
                            <div class="publishCInfo">
                                <?php $date = $lista['fecha']; ?>
                                <p class="publishCDate">Publicado el <?php echo date('d/m/Y', strtotime($date))?> a las <?php echo date('G:i', strtotime($date))?></p> 
                                <div class="publishCZone"><p class="publishCProv">En <?php echo filter_var($lista['provincia'] , FILTER_SANITIZE_STRING);?></p> <p class="publishCLoc"><?php echo filter_var($lista['localidad'] , FILTER_SANITIZE_STRING);?></p></div>
                            </div>
                            <div class="publishPDisplay">
                                <div class="publishCOffer">
                                    <p class="publishCQuantity"><?php echo $lista['cantidad']?></p>
                                    <p class="publishCCurrency"><?php echo filter_var($lista['moneda'] , FILTER_SANITIZE_STRING);?></p>
                                </div>
                                <p class="publishCFee">Fee <?php echo $lista['comision']?>%</p>
                            </div>
                            <div class="publishPDetails">
                                <p class="publishCOperation"><?php echo filter_var($lista['operacion'] , FILTER_SANITIZE_STRING);?></p>
                                <div class="publishCMethod">
                                    <p class="publishCMethodAccepted">Aceptas:</p><p class="publishCP2P"><?php echo filter_var($lista['p2p'] , FILTER_SANITIZE_STRING);?></p><p class="publishCF2F"><?php echo filter_var($lista['f2f'] , FILTER_SANITIZE_STRING);?></p>
                                </div>
                            </div>
                        </div>
                        <div class="overlay" id="overlay">
                            <div class="publishannouncer" id="publishannouncer">
                                <h3>Editar mi anuncio</h3>
                                <form name="publishform" id="publishform" class="publishform"  method="POST" action="" onsubmit="return validateForm()">
                                    <div name="publish" class="contenedor-inputs">
                                        <div class="thirdone">
                                            <div class="locationtitle modified">
                                                <p>Ubicación</p>
                                            </div>
                                            <div class="location">
                                                <div class="locationselector modified">
                                                    <div class="loc1">
                                                        <p>Provincia</p>
                                                        <select name="provincia" id="editprovincia" disabled>
                                                            <option selected><?php echo filter_var($lista['provincia'] , FILTER_SANITIZE_STRING);?></option>
                                                        </select>
                                                    </div>
                                                    <div class="loc2">
                                                        <p>Localidad</p>
                                                        <select name="localidad" id="editlocalidad" disabled> 
                                                            <option selected><?php echo filter_var($lista['localidad'] , FILTER_SANITIZE_STRING);?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="secondthree">
                                            <div class="currency">
                                                <p>Moneda</p>
                                                <div class="currencyselector">
                                                    <select name="currency" id="currency" onchange="show_moneda();">
                                                        <option value="<?php echo filter_var($lista['moneda'] , FILTER_SANITIZE_STRING);?>" selected><?php echo filter_var($lista['moneda'] , FILTER_SANITIZE_STRING);?> <?php echo '[Seleccionado]';?></option>   
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
                                                    <input type="hidden" id="currencyselected" name="currencyselected" value="<?php echo filter_var($lista['moneda'] , FILTER_SANITIZE_STRING);?>"></input>
                                                </div>
                                            </div>
                                            <div class="quantfeecontainer">
                                                <div class="quantity">
                                                    <p>Cantidad</p>
                                                    <div class="quantityselector">
                                                        <input type="number" name="quantity" id="quantIndicator" value="<?php echo $lista['cantidad'];?>" step="0.1" min="0">
                                                    </div>
                                                </div>
                                                <div class="fee">
                                                    <div class="feeptitle modified">
                                                        <p>Porcentaje de Comisión</p>
                                                    </div>
                                                    <div class="feeselector">
                                                        <input type="number" name="fee" id="feeIndicator" value="<?php echo $lista['comision'];?>" step="0.1" min="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="firsttwo">
                                            <div class="operationcheck">
                                                <div class="operationtitle modified">
                                                    <p>Elegir Operación</p>
                                                </div>
                                                <input type="radio" id="checkCompra" name="operation" value="Compra">
                                                <label for="checkCompra">Comprar</label>

                                                <input type="radio" id="checkVenta" name="operation" value="Venta">
                                                <label for="checkVenta">Vender</label>
                                                <p class= "textmodified">Actualmente: <span><?php echo filter_var($lista['operacion'] , FILTER_SANITIZE_STRING);?></span></p>
                                            </div>
                                            <div class="methodcheck">
                                                <div class="methodtitle modified">
                                                    <p>Elegir Método</p>
                                                </div>
                                                <input type="checkbox" id="checkP2P" name="p2p" value="" onClick="P2P(this)">
                                                <label for="checkP2P">P2P</label>

                                                <input type="checkbox" id="checkF2F" name="f2f" value=""onClick="F2F(this)">
                                                <label for="checkF2F">F2F</label>
                                                <p class = "textmodified">Actualmente utilizas: <span><?php echo filter_var($lista['p2p'] , FILTER_SANITIZE_STRING);?></span> <span><?php echo filter_var($lista['f2f'] , FILTER_SANITIZE_STRING);?></span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="actionbuttons">
                                        <a href="#" id="btn-cerrar-popup" class="btn-volver">Volver</a>
                                        <input type="submit" id="confirmar" name="confirmar" class="btn-confirm" value="Actualizar">
                                    </div>
                                    <script type="text/javascript">
                                    function validateForm() {
                                        var currency = document.forms["publishform"]["currency"].value;
                                        var quantity = document.forms["publishform"]["quantity"].value;
                                        var fee = document.forms["publishform"]["fee"].value;
                                        var operation = document.forms["publishform"]["operation"].value;
                                        var p2p = document.forms["publishform"]["p2p"].value;
                                        var f2f = document.forms["publishform"]["f2f"].value;
                                        if (currency == " " && quantity == "0" && fee == "" || (operation != "Compra" && operation != "Venta") || (p2p == "" && f2f == "")) {
                                            setTimeout(function () {
                                            swal("¡Ups!","Algunos campos parecen estar vacíos. Es necesario que completes todas las opciones para poder editar tu anuncio.","error", {button: "Intentar de nuevo",})
                                            }, 200);
                                            return false;
                                        }
                                    }
                                    </script>
                                </form>
                            </div>
                        </div>
                        <?php 
                            if(isset($_POST['confirmar'])){
                                function secure($value){
                                    include 'php/conexion_be.php';
                                    $value = trim($value);
                                    $value = stripslashes($value);
                                    $value = htmlspecialchars($value);
                                    $value = mysqli_real_escape_string($conexion, $value);
                                    return $value;
                                }
                                $currency = secure($_POST['currencyselected']);
                                $quantity = mysqli_real_escape_string($conexion, $_POST['quantity']);
                                $fee = mysqli_real_escape_string($conexion, $_POST['fee']);
                                $operation = empty($_POST['operation']) ? NULL : secure($_POST['operation']);
                                $p2p = empty($_POST['p2p']) ? NULL : secure($_POST['p2p']);
                                $f2f = empty($_POST['f2f']) ? NULL : secure($_POST['f2f']);
                                $updquery = mysqli_query($conexion, "UPDATE anuncios SET moneda = '$currency', cantidad = '$quantity', comision = '$fee', operacion = '$operation', p2p = '$p2p', f2f = '$f2f' WHERE id_pub = '".filter_var($lista['id_pub'] , FILTER_SANITIZE_NUMBER_INT)."'");
                                if($updquery){
                                    echo '<script type="text/javascript">';
                                    echo 'setTimeout(function () {';
                                    echo 'swal("¡Anuncio editado!","Ya podes verlo publicado con los cambios realizados.","success").then( function(val) {';
                                    echo 'if (val == true) window.location.href = \'https://librecripto.com/market\';';
                                    echo '});';
                                    echo '}, 200);  </script>';
                                    exit();
                                }else{
                                    echo '<script type="text/javascript">';
                                    echo 'setTimeout(function () {';
                                    echo 'swal("Algo salió mal...","No se pudo editar tu anuncio. Por favor, intentá de nuevo.","error").then( function(val) {';
                                    echo 'if (val == true) window.location.href = \'https://librecripto.com/market\';';
                                    echo '});';
                                    echo '}, 200);  </script>';
                                }
                                
                            }
                        ?>
                        <div class="publishPModify" id="modifyButton">
                            <p>Editar</p><i class="fa fa-magic" aria-hidden="true"></i>
                        </div>
                        <div class="publishPDelete">
                        <?php
                                    //$valuemoneda = $lista['moneda'];
                                    //$valuecantidad = $lista['cantidad'];
                                    //$idpub = $lista['id_pub'];
                        ?>
                            <input type="submit" id="delete" name="delete" class="deleteButton" value="Eliminar" onclick="cargarData(<?php echo filter_var($idpub , FILTER_SANITIZE_NUMBER_INT); ?>);"><i class="fa fa-trash" aria-hidden="true"></i>
                        </div>
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script type="text/javascript">
                                function cargarData(id) {
                                    var url="deleteannounce.php";
                                    swal({
                                        title: '¡Cuidado!',
                                        text: '¿Estás seguro de querer eliminar tu anuncio?',
                                        icon: 'warning',
                                        buttons:{
                                            cancel: "No, volver",
                                            confirm: "Sí, eliminar",
                                        }
                                    }).then((result) => {
                                        if (result) {
                                            $.ajax({
                                                type: 'POST',
                                                url:url,
                                                data: 'id='+id,
                                                success:function(){
                                                    swal({
                                                        title: '¡Anuncio eliminado!',
                                                        text: '¿Querés publicar uno nuevo?',
                                                        icon: 'success',
                                                        button: 'Continuar',
                                                    }).then((value) => {
                                                        window.location.replace("https://librecripto.com/market");
                                                    });
                                                }
                                            });
                                        }

                                    });
                                };
                            </script>
                    </div>
            <?php }?>
        </div>
</section>
<section class= "seccion2 contenedor">
  <div class="userprofilebackto">
    <a href="market.php">Volver al Mercado</a>
  </div>
</section>
</main>
<?php include_once 'includes/templates/footernone.php'; ?>