<?php 
    session_start();
$title = "Registro | LibreCripto";
    include_once 'includes/templates/headeraccess.php'; 

    if(isset($_SESSION['user'])){
      echo "<script> window.location='https://librecripto.com'; </script>";
    }

?>

    <main class="Access">
        <section class="seccion2 contenedor firstAcceso">
            <h1 class="titlePage">¡Bienvenid@!</h1>
            <li class="acceso">
                <a><i class="fas fa-chevron-right "></i></a>
                <a><i class="fas fa-chevron-right "></i></a>
                <p class="textAcceso">Estás a un paso de acceder al mundo cripto.</p>
            </li>
        </section>
        <section class="seccion2 contenedor">
                <div class="contenedor__todo">
                    <div class="caja__trasera registro">
                        <div class="caja__trasera-login">
                            <h3>¿Ya sos usuario?</h3>
                            <p>Accedé con tu correo y contraseña</p>
                            <a href="acceso.php" id="btn__iniciar-sesion">Iniciar Sesión</a>
                        </div>
                    </div>
                    <!-- Formulario de login y registro -->
                    <div class="contenedor__login-register registro">
                        <!--Registro-->
                        <form action="php/registro_usuario_be.php" method="POST" class="formulario__register" autocomplete="off">
                            <h2>Registrarse</h2>
                            <div class="form-control">
                                <input type="text" placeholder="Nombre" name="nombre" pattern="[A-Za-z]{1,50}" maxlength="50">
                                <span class="form-control__message">Solo tu nombre, no es necesario el apellido.</span>
                            </div>
                            <div class="form-control">
                                <input type="text" placeholder="Usuario" pattern="^[a-zA-Z0-9-_]{4,16}$" maxlength="16" name="usuario">
                                <span class="form-control__message">Podes usar letras, y guiones bajos, hasta 16 caracteres.</span>
                            </div>
                            <div class="form-control">
                                <input type="email" placeholder="Email" name="correo" maxlength="100">
                                <span class="form-control__message">Asegurate de tener acceso a este correo.</span>
                            </div>
                            <div class="form-control">
                                <input type="text" placeholder="Teléfono (opcional)" name="telefono">
                                <span class="form-control__message">Recordá incluir el código de área, por ej: 011-1111-1111</span>
                            </div>
                            <div class="form-control">
                                <div class="input-group">
                                    <input type="password" placeholder="Contraseña" id="password" minlength="4" maxlength="16" name="pass">

                                    <div class="input-group-append">
                                        <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye icon"></span> </button>
                                    </div>
                                </div>
                                <span class="form-control__message">Entre 4 y 16 caracteres.</span>
                            </div>
                            <div class="check">
                                <input type="checkbox">
                                <p>Estoy de acuerdo con los <a href="https://librecripto.com/terminos-y-condiciones" target="_blank">Términos y Condiciones</a> y acepto la <a href="https://librecripto.com/politica-de-privacidad" target="_blank">Política de Privacidad</a> del sitio.</p>
                            </div>
                            <button class="Registrarse">Registrarse</button>
                        </form>
                    </div>
                </div>
        </section>
    </main>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2486691799966384"
     crossorigin="anonymous"></script>
<!-- 2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2486691799966384"
     data-ad-slot="6572543051"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<?php include_once 'includes/templates/footeraccess.php'; ?>