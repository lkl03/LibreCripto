<?php
session_start();
?>
<head>
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
</head>
<?php 
  include_once 'templates/headerun.php';
?>
<?php



    if(!isset($_SESSION['correo'])){
        echo "<script> window.location='login.php'; </script>";
        die();
    }else{
      include_once 'templates/headerbar.php';
      include_once 'templates/sidebar.php';
    }

    include 'php/connect.php';
    
    if(isset($_GET['id'])){
        $id = filter_var($_GET['id'], (FILTER_SANITIZE_NUMBER_INT));

        $myuser = mysqli_query($connect, "SELECT * FROM usuarios WHERE id = '$id' ");
        $use = mysqli_fetch_array($myuser);

        if($_SESSION['id'] != $id) {
          $status = "Offline";
          $sql = mysqli_query($connect, "UPDATE usuarios SET status = '$status' WHERE id='".$_SESSION['id']."'");
          echo "<script type='text/javascript'>";
          echo "toastr.error('No deberías estar en esta página.')";
          echo "</script>";
          session_destroy();
          exit();
        }
    }

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Usuarios</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Usuarios registrados</h3>
              </div>
              <!-- /.card-header -->
              <?php
              $userdbconsult = mysqli_query($connect, "SELECT * FROM usuarios ORDER BY id DESC");
              ?>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Pass</th>
                    <th>Foto Perfil</th>
                    <th>Rol</th>
                    <th>Status</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  while($lista = mysqli_fetch_array($userdbconsult)){
                  ?>
                  <tr>
                    <td><?php echo $lista['id']; ?></td>
                    <td><?php echo $lista['nombre']; ?></td>
                    <td><?php echo $lista['correo']; ?></td>
                    <td><?php echo $lista['pass']; ?></td>
                    <td><?php echo $lista['fotoperfil']; ?></td>
                    <td><?php echo $lista['rol']; ?></td>
                    <td><?php echo $lista['status']; ?></td>
                  </tr>
                  <?php
                  }
                  ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Pass</th>
                    <th>Foto Perfil</th>
                    <th>Rol</th>
                    <th>Status</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <?php
                          if($use['rol'] === 'CEO'){
                        ?>
                          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Agregar usuario</button>
                          <div class="modal fade bd-example-modal-xl" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-xl" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Agregar nuevo usuario al equipo</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                      <label for="nombre" class="col-form-label">Nombre</label>
                                      <input type="text" maxlenght="50" name="nombre" id="nombre">
                                    </div>
                                    <div class="form-group">
                                      <label for="correo" class="col-form-label">Correo</label>
                                      <input type="email" maxlenght="50" name="correo" id="correo">
                                    </div>
                                    <div class="form-group">
                                      <label for="pass" class="col-form-label">Contraseña</label>
                                      <input type="password" maxlenght="150" name="pass" id="pass">
                                    </div>
                                    <div class="form-group">
                                      <label for="rol" class="col-form-label">Rol</label>
                                      <input type="text" maxlenght="255" name="rol" id="rol">
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="useradder">Agregar</button>
                                    <?php
                                      if(isset($_POST['useradder'])){
                                        $nombre = $_POST['nombre'];
                                        $correo = $_POST['correo'];
                                        $passw = $_POST['pass'];
                                        $rol = $_POST['rol'];
                                        $status = "Registrado";
                                        //Encriptado de contraseña
                                        $pass = hash('sha512', $passw);
                                        if($nombre != '' && $correo != '' && $pass != '' && $rol != ''){
                                          $sql = mysqli_query($connect, "INSERT INTO usuarios(nombre, correo, pass, fotoperfil, fechacreacion, rol, status) VALUES('$nombre','$correo', '$pass', 'avatar4.png', now(), '$rol', '$status')");
                                          if($sql){
                                            echo '<script type="text/javascript">';
                                            echo 'window.location.href = \'usuariosadmin.php?id='.$_SESSION['id'].'\';';
                                            echo '</script>';
                                            require 'php/src/Exception.php';
                                                require 'php/src/PHPMailer.php';
                                                require 'php/src/SMTP.php';
                                                  
                                                $smtpHost = "c2410691.ferozo.com";
        $smtpUsuario = "info@librecripto.com";
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

        $mail->Subject = "Nueva cuenta de administrador creada";
        $mensajeHtml = nl2br($mensaje);
        $mail->Body = "
         <html>

         <body>

         <h3>Hola, $nombre.</h3>
                                            <p>Se generó una cuenta a tu nombre con el rol de $rol. Con los siguientes datos podrás acceder a la zona de administración de LibreCripto.</p>
                                            <p>Correo:</p> <h3>$correo</h3>
                                            <p>Contraseña:</p> <h3>$passw</h3>
                                            
                                            <p>Accedé desde https://librecripto.com/admin/login.php</p>

                                            <p><b>-El equipo de LibreCripto.</b></p>
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
                                          }else{
                                            echo "<script type='text/javascript'>";
                                            echo "toastr.error('Ocurrió un error, intentá de nuevo.')";
                                            echo "</script>";
                                          }
                                        }else{
                                          echo "<script type='text/javascript'>";
                                          echo "toastr.error('Revisá si hay algún campo vacío e intentá de nuevo.')";
                                          echo "</script>";
                                        }
                                      }
                                    ?>
                                  </form>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal2" data-whatever="@fat">Eliminar usuario</button>
                          <div class="modal fade bd-example-modal-xl" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-xl" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Eliminar usuario del equipo</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                      <label for="nombreus" class="col-form-label">Nombre del usuario a eliminar</label>
                                      <input type="text" maxlenght="50" name="nombreus" id="nombreus">
                                    </div>
                                    <div class="form-group">
                                      <label for="correous" class="col-form-label">Correo del usuario a eliminar</label>
                                      <input type="email" maxlenght="50" name="correous" id="correous">
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="userdeleter">Eliminar</button>
                                    <?php
                                      if(isset($_POST['userdeleter'])){
                                        $nombreus = $_POST['nombreus'];
                                        $correous = $_POST['correous'];
                                        //Encriptado de contraseña
                                        if($nombreus != '' && $correous != ''){
                                          $sql = mysqli_query($connect, "DELETE FROM usuarios WHERE nombre = '$nombreus' AND correo = '$correous'");
                                          if($sql){
                                            echo '<script type="text/javascript">';
                                            echo 'window.location.href = \'usuariosadmin.php?id='.$_SESSION['id'].'\';';
                                            echo '</script>';
                                            require 'php/src/Exception.php';
                                                require 'php/src/PHPMailer.php';
                                                require 'php/src/SMTP.php';
                                                  
                                                $smtpHost = "c2410691.ferozo.com";
        $smtpUsuario = "info@librecripto.com";
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
        $mail->AddAddress($correous);
        $mail->AddReplyTo('no-reply@librecripto.com','no-reply');

        $mail->Subject = "Cuenta de administrador eliminada";
        $mensajeHtml = nl2br($mensaje);
        $mail->Body = "
         <html>

         <body>

         <h3>Hola, $nombreus.</h3>
                                            <p>Tu acceso a la zona de administración de LibreCripto ha sido revocado.</p>
                                            
                                            <p>Si crees que esto ha sido un error por favor contactanos a la brevedad.</p>

                                            <p><b>-El equipo de LibreCripto.</b></p>
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
                                          }else{
                                            echo "<script type='text/javascript'>";
                                            echo "toastr.error('Ocurrió un error, intentá de nuevo.')";
                                            echo "</script>";
                                          }
                                        }else{
                                          echo "<script type='text/javascript'>";
                                          echo "toastr.error('Revisá si hay algún campo vacío e intentá de nuevo.')";
                                          echo "</script>";
                                        }
                                      }
                                    ?>
                                  </form>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        <?php
                          }
                    ?>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
include_once 'templates/footerun.php';
?>