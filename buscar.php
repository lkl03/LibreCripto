<?php
require 'php/Carbon/autoload.php';
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonInterface;
session_start();
//Archivo de conexión a la base de datos
require('php/conexion_be.php');

//Variable de búsqueda
$consultaBusqueda = $_POST['valorBusqueda'];

//Filtro anti-XSS
$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/");
$caracteres_buenos = array("& lt;", "& gt;", "& quot;", "& #x27;", "& #x2F;", "& #060;", "& #062;", "& #039;", "& #047;");
$consultaBusqueda = str_replace($caracteres_malos, $caracteres_buenos, $consultaBusqueda);

//Variable vacía (para evitar los E_NOTICE)
$mensaje = "";

//Comprueba si $consultaBusqueda está seteado
if (isset($consultaBusqueda)) {

	//Selecciona todo de la tabla mmv001 
	//donde el nombre sea igual a $consultaBusqueda, 
	//o el apellido sea igual a $consultaBusqueda, 
	//o $consultaBusqueda sea igual a nombre + (espacio) + apellido
	$consulta = mysqli_query($conexion, "SELECT * FROM anuncios
	WHERE
    usuario COLLATE UTF8MB4_SPANISH_CI LIKE '%$consultaBusqueda%'
    OR provincia COLLATE UTF8MB4_SPANISH_CI LIKE '%$consultaBusqueda%' 
	OR localidad COLLATE UTF8MB4_SPANISH_CI LIKE '%$consultaBusqueda%'
    OR moneda COLLATE UTF8MB4_SPANISH_CI LIKE '%$consultaBusqueda%'
    OR operacion COLLATE UTF8MB4_SPANISH_CI LIKE '%$consultaBusqueda%'
    OR p2p COLLATE UTF8MB4_SPANISH_CI LIKE '%$consultaBusqueda%'
    OR f2f COLLATE UTF8MB4_SPANISH_CI LIKE '%$consultaBusqueda%'
	OR CONCAT(provincia,' ',localidad) COLLATE UTF8MB4_SPANISH_CI LIKE '%$consultaBusqueda%'
    OR CONCAT(usuario,' ',provincia,' ',localidad,' ',moneda,' ',operacion,' ',p2p,' ',f2f) COLLATE UTF8MB4_SPANISH_CI LIKE '%$consultaBusqueda%'
	");

	//Obtiene la cantidad de filas que hay en la consulta
	$filas = mysqli_num_rows($consulta);

	//Si no existe ninguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
	if ($filas === 0) {
		$mensaje = "<p>No hay ningún anuncio que coincida con los filtros de búsqueda indicados</p>";
        echo $mensaje;
	} else {
		//Si existe alguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
		echo '<p class="resultadoBusquedaText"><span>'.$filas.'</span> anuncio/s encontrado/s coincide/n con la búsqueda de "<span>'.$consultaBusqueda.'</span>"</p>';
        

		//La variable $resultado contiene el array que se genera en la consulta, así que obtenemos los datos y los mostramos en un bucle
		while($resultados = mysqli_fetch_array($consulta)) {
            $pubid = $resultados['id_pub'];
            $usuario = $resultados['usuario'];
			$provincia = $resultados['provincia'];
			$localidad = $resultados['localidad'];
            $moneda = $resultados['moneda'];
            $operacion = $resultados['operacion'];
            $p2p = $resultados['p2p'];
            $f2f = $resultados['f2f'];
            $id = $resultados['id'];
            $userid = mysqli_real_escape_string($conexion, $resultados['id']);
            $usuariob = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id = '$userid'");
            $use = mysqli_fetch_array($usuariob);

			//Output
            ?>
            <div class="publishContainer filter">
                <div class="publish">
                    <div class="publishCUser">
                        <?php
                        if($id == $_SESSION['id']){
                        ?>
                            <div class="publishMyAnnounce">
                                <p>Mi anuncio</p>
                            </div>
                        <?php
                        }else{
                        ?>
                            <div class="publishCPic">
                                <img class="profpicpub" src="img/profilepics/<?php echo $use['avatar']?>" alt="Avatar">
                            </div>
                            <a class="publishCTitle"><span>@</span><?php echo $use['usuario']?></a>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="publishCInfo">
                        <?php 
                            $date = $resultados['fecha']; 
                            $now = Carbon::now(new DateTimeZone('America/Argentina/Buenos_Aires'));
                            $publishdate = Carbon::create($date, 'America/Argentina/Buenos_Aires');
                            $publishdate->locale('es');
                            $diff = $publishdate->diffForHumans($now, CarbonInterface::DIFF_RELATIVE_TO_NOW);
                        ?>
                        <p class="publishCDate">Publicado <?php echo $diff?></p> 
                        <div class="publishCZone"><p class="publishCProv">En <?php echo $resultados['provincia']?></p> <p class="publishCLoc"><?php echo $resultados['localidad']?></p></div>
                    </div>
                    <div class="publishCDisplay">
                        <div class="publishCOffer">
                            <p class="publishCQuantity"><?php echo $resultados['cantidad']?></p>
                            <p class="publishCCurrency"><?php echo $resultados['moneda']?></p>
                        </div>
                        <p class="publishCFee">Fee <?php echo $resultados['comision']?>%</p>
                    </div>
                    <div class="publishCDetails">
                        <p class="publishCOperation"><?php echo $resultados['operacion']?></p>
                        <div class="publishCMethod">
                            <p class="publishCMethodAccepted"><?php if($use['id'] == $_SESSION['id']){ echo 'Aceptas:';}else{ echo 'Acepta:';}?></p><p class="publishCP2P"><?php echo $resultados['p2p']?></p><p class="publishCF2F"><?php echo $resultados['f2f']?></p>
                        </div>
                    </div>
                    <?php 
                        if($use['criptotop'] != 0) {?>
                            <div class="publishCriptoTop">
                                <p class="publishCriptoTopShow">Cripto<span>Top</span></p>
                            </div>
                    <?php } ?>
                    <?php
                        if($use['id'] != $_SESSION['id']){
                            ?>
                            <div class="publishDcontactbutton filter">
                                <a href="chat.php?user=<?php echo $use['user']?>">Contactar</a>
                            </div>
                            <?php
                        } 
                    ?>
                </div>
            </div>
        <?php
		};//Fin while $resultados

	}; //Fin else $filas

};//Fin isset $consultaBusqueda

//Devolvemos el mensaje que tomará jQuery
exit();
?>