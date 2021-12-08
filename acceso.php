<?php 
    session_start();
$title = "Iniciar sesión | LibreCripto";
    include_once 'includes/templates/headeraccess.php'; 

    if(isset($_SESSION['user'])){
      echo "<script> window.location='https://librecripto.com'; </script>";
    }
?>

    <main class="Access">
        <section class="seccion2 contenedor firstAcceso">
            <h1 class="titlePage">¡Hola de nuevo!</h1>
            <li class="acceso">
                <a><i class="fas fa-chevron-right "></i></a>
                <a><i class="fas fa-chevron-right "></i></a>
                <p class="textAcceso">Inicia sesión fácilmente con tu correo y contraseña.</p>
            </li>
        </section>
        <section class="seccion2 contenedor">
                <div class="contenedor__todo">
                    <div class="caja__trasera acceso">
                        <div class="caja__trasera-register">
                            <h3>¿Todavía no tenes tu cuenta?</h3>
                            <p>Registrate sencillamente para poder acceder</p>
                            <a href="https://librecripto.com/registro" id="btn__registrarse">Registrarse</a>
                        </div>
                    </div>
                    <!-- Formulario de login y registro -->
                    <div class="contenedor__login-register">
                        <!--Login-->
                        <form action="php/login_usuario_be.php" method="POST" class="formulario__login" id="formulario__login">
                            <h2>Iniciar Sesión</h2>
                            <input type="text" placeholder="Correo Electrónico" name="correo">
                            <div class="input-group">
                                <input type="password" placeholder="Contraseña" id="passwordLog" minlength="4" maxlength="16" name="pass">
                                <div class="input-group-append">
                                    <button id="show_passwordLog" class="btn btn-primaryLog" type="button" onclick="mostrarPasswordLog()"> <span class="fa fa-eye icon"></span> </button>
                                </div>
                            </div>
                            <button class="Entrar">Entrar</button>
                            <a class="forgot" href="https://librecripto.com/passwordreset">¿Olvidaste tu contraseña?</a>
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