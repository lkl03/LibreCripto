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
  <div class="content-wrapper" style="height: auto !important">
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
              include '../php/conexion_be.php';
              $userdbconsult = mysqli_query($conexion, "SELECT * FROM usuarios ORDER BY id DESC");
              ?>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Pass</th>
                    <th>Fecha_Reg</th>
                    <th>Avatar</th>
                    <th>CriptoTop</th>
                    <th>Codigo Verif</th>
                    <th>Confirmed Email</th>
                    <th>Token</th>
                    <th>Status</th>
                    <th>Operaciones</th>
                    <?php
                    if($use['rol'] === 'CEO'){
                    ?>
                    <th>Administrar</th>
                    <?php
                    }
                    ?>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  while($lista = mysqli_fetch_array($userdbconsult)){
                  ?>
                  <tr>
                    <td><?php echo $lista['id']; ?></td>
                    <td><?php echo $lista['user']; ?></td>
                    <td><?php echo $lista['nombre']; ?></td>
                    <td><?php echo $lista['usuario']; ?></td>
                    <td><?php echo $lista['correo']; ?></td>
                    <td><?php echo $lista['telefono']; ?></td>
                    <td><?php echo $lista['pass']; ?></td>
                    <td><?php echo $lista['fecha_reg']; ?></td>
                    <td><?php echo $lista['avatar']; ?></td>
                    <td><?php echo $lista['criptotop']; ?></td>
                    <td><?php echo $lista['codigoverif']; ?></td>
                    <td><?php echo $lista['confirmedemail']; ?></td>
                    <td><?php echo $lista['token']; ?></td>
                    <td><?php echo $lista['status']; ?></td>
                    <td><?php echo $lista['operations']; ?></td>
                    <?php
                    if($use['rol'] === 'CEO'){
                    ?>
                      <td>
                        <div class="row" style="justify-content: space-evenly">
                          <button type="button" class="btn btn-danger" style="flex-basis: 25%" data-toggle="modal" data-target="#exampleModal2<?php echo $lista['id'];?>" data-whatever="<?php echo $lista['id'];?>"><i class="fas fa-user-times"></i></button>
                          <div class="modal fade bd-example-modal-xl" id="exampleModal2<?php echo $lista['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Eliminar usuario</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                      <label for="idx" class="col-form-label">ID de usuario a eliminar</label>
                                      <input type="text" class="form-control" id="idx" readonly value="<?php echo $lista['id'];?>" name="idx"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="nombrex" class="col-form-label">Nombre del usuario a eliminar</label>
                                      <input type="text" class="form-control" id="nombrex" readonly value="<?php echo $lista['nombre'];?>" name="nombrex"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="usuariox" class="col-form-label">Nombre de usuario a eliminar</label>
                                      <input type="text" class="form-control" id="usuariox" readonly value="<?php echo $lista['usuario'];?>" name="usuariox"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="correox" class="col-form-label">Correo del usuario a eliminar</label>
                                      <input type="text" class="form-control" id="correox" readonly value="<?php echo $lista['correo'];?>" name="correox"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="razon" class="col-form-label">Motivo de la eliminación del usuario</label>
                                      <textarea class="form-control" id="razon" maxlenght="500" name="razon"></textarea>
                                    </div>
                                    <div class="form-group">
                                      <label for="usercontrax" class="col-form-label">Escribir su contraseña para confirmar eliminación</label>
                                      <input type="password" class="form-control" id="usercontrax" maxlenght="150" name="usercontrax">
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="userdeleter">Eliminar</button>
                                    <?php
                                      if(isset($_POST['userdeleter'])){
                                        $usercontrax = $_POST['usercontrax'];
                                        $usercontraxpass = hash('sha512', $usercontrax);
                                        $nombrex = $_POST['nombrex'];
                                        $usuariox = $_POST['usuariox'];
                                        $correox = $_POST['correox'];
                                        $idx = $_POST['idx'];
                                        $razon = $_POST['razon'];
                                        //Encriptado de contraseña
                                        if($usercontrax != ''){
                                          if($_SESSION['pass'] === $usercontraxpass){
                                            if($razon != ''){
                                              $sqld = mysqli_query($conexion, "DELETE FROM usuarios WHERE id = '$idx'");
                                              if($sqld){
                                                echo '<script type="text/javascript">';
                                                echo 'window.location.href = \'usuarios.php?id='.$_SESSION['id'].'\';';
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
        $mail->AddAddress($correox);
        $mail->AddReplyTo('no-reply@librecripto.com','no-reply');

        $mail->Subject = "Aviso de cuenta eliminada";
        $mensajeHtml = nl2br($mensaje);
        $mail->Body = "
         <html>

         <body>

         <h3>Hola, $nombrex.</h3>
                                                <p>Hemos eliminado tu cuenta @$usuariox de LibreCripto.</p>
                                                <p>Esto se debe a:</p> 
                                                <p>'$razon'</p>
                                                  
                                                <p>Si crees que esto ha sido un error por favor contactanos a la brevedad.</p>

                                                <p><b>Atentamente -El equipo de LibreCripto.</b></p>
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
                                              echo "toastr.error('El motivo de la eliminación no puede quedar vacío.')";
                                              echo "</script>";
                                            }
                                          }else{
                                            echo "<script type='text/javascript'>";
                                            echo "toastr.error('Las contraseñas no coinciden. Intentá de nuevo.')";
                                            echo "</script>";
                                          }
                                        }else{
                                          echo "<script type='text/javascript'>";
                                          echo "toastr.error('Debes ingresar tu contraseña para poder confirmar los cambios.')";
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
                          <button type="button" class="btn btn-warning" style="flex-basis: 25%" data-toggle="modal" data-target="#exampleModal<?php echo $lista['id'];?>" data-whatever="<?php echo $lista['id'];?>"><i class="fas fa-user-edit"></i></button>
                          <div class="modal fade bd-example-modal-xl" id="exampleModal<?php echo $lista['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Modificar datos de usuario</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                      <label for="id" class="col-form-label">ID de usuario</label>
                                      <input type="text" class="form-control" id="id" readonly value="<?php echo $lista['id'];?>" name="id"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="user" class="col-form-label">Código identificador de usuario</label>
                                      <input type="text" class="form-control" id="user" disabled placeholder="<?php echo $lista['user'];?>" name="user">
                                    </div>
                                    <div class="form-group">
                                      <label for="nombre" class="col-form-label">Nombre del usuario</label>
                                      <input type="text" class="form-control" id="nombre" maxlenght="50" value="<?php echo $lista['nombre'];?>" name="nombre">
                                    </div>
                                    <div style="display:grid;">
                                      <label for="usuario" class="col-form-label">Nombre de usuario</label>
                                      <div class="input-group mb-3">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text">@</span>
                                          </div>
                                          <input type="text" class="form-control" id="usuario" pattern="^[a-zA-Z0-9\_]{4,16}$" maxlength="16" value="<?php echo $lista['usuario'];?>" name="usuario">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label for="correo" class="col-form-label">Correo de usuario</label>
                                      <input type="email" class="form-control" id="correo" maxlenght="50" value="<?php echo $lista['correo'];?>" name="correo">
                                    </div>
                                    <div class="form-group">
                                      <label for="telefono" class="col-form-label">Teléfono de usuario</label>
                                      <input type="text" class="form-control" id="telefono" maxlenght="50" value="<?php echo $lista['telefono'];?>" name="telefono">
                                    </div>
                                    <div class="form-group">
                                      <label for="pass" class="col-form-label">Contraseña de usuario (Hash sha512)</label>
                                      <input type="text" autocomplete="off" class="form-control" maxlenght="150" value="<?php echo hash('sha512', $lista['pass']);?>" id="pass" name="pass">
                                    </div>
                                    <div class="form-group">
                                      <label for="fecha" class="col-form-label">Fecha de registro de usuario</label>
                                      <input type="text" class="form-control" id="fecha" disabled maxlenght="50" placeholder="<?php echo $lista['fecha_reg'];?>" name="fecha">
                                    </div>
                                    <div class="form-group">
                                      <label for="avatar" class="col-form-label">Avatar de usuario</label>
                                      <input type="text" class="form-control" id="avatar" disabled maxlenght="200" placeholder="<?php echo $lista['avatar'];?>" name="avatar">
                                    </div>
                                    <div class="form-group">
                                      <label for="criptotop" class="col-form-label">¿Es CriptoTop? (0=NO / 1=SI)</label>
                                      <input type="text" class="form-control" id="criptotop" disabled maxlenght="11" placeholder="<?php echo $lista['criptotop'];?>" name="criptotop">
                                    </div>
                                    <div class="form-group">
                                      <label for="codigoverif" class="col-form-label">Código de verificación al registrarse</label>
                                      <input type="text" class="form-control" id="codigoverif" disabled maxlenght="64" placeholder="<?php echo $lista['codigoverif'];?>" name="codigoverif">
                                    </div>
                                    <div class="form-group">
                                      <label for="confirmedemail" class="col-form-label">¿Confirmó su email? (0=NO / 1=SI)</label>
                                      <input type="text" class="form-control" id="confirmedemail" disabled maxlenght="11" placeholder="<?php echo $lista['confirmedemail'];?>" name="confirmedemail">
                                    </div>
                                    <div class="form-group">
                                      <label for="token" class="col-form-label">Token de reestablecimiento de contraseña</label>
                                      <input type="text" class="form-control" id="token" disabled maxlenght="255" placeholder="<?php echo $lista['token'];?>" name="token">
                                    </div>
                                    <div class="form-group">
                                      <label for="status" class="col-form-label">¿Cómo se encuentra el usuario?</label>
                                      <input type="text" class="form-control" id="status" disabled maxlenght="255" placeholder="<?php echo $lista['status'];?>" name="status">
                                    </div>
                                    <div class="form-group">
                                      <label for="operations" class="col-form-label">Cantidad de operaciones concretadas por el usuario</label>
                                      <input type="text" class="form-control" id="operations" disabled maxlenght="11" placeholder="<?php echo $lista['operations'];?>" name="operations">
                                    </div>
                                    <div class="form-group">
                                      <label for="usercontra" class="col-form-label">Escribir su contraseña para confirmar cambios</label>
                                      <input type="password" class="form-control" id="usercontra" maxlenght="150" name="usercontra">
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="userediter">Modificar</button>
                                    <?php
                                      if(isset($_POST['userediter'])){
                                        $usercontra = $_POST['usercontra'];
                                        $usercontrapass = hash('sha512', $usercontra);
                                        $id = $_POST['id'];
                                        $nombre = $_POST['nombre'];
                                        $usuario = $_POST['usuario'];
                                        $correo = $_POST['correo'];
                                        $telefono = $_POST['telefono'];
                                        $passw = $_POST['pass'];
                                        //Encriptado de contraseña
                                        $pass = hash('sha512', $passw);
                                        if($usercontra != ''){
                                          if($_SESSION['pass'] === $usercontrapass){
                                                $sql = mysqli_query($conexion, "UPDATE usuarios SET nombre = '$nombre', usuario = '$usuario', correo = '$correo', telefono = '$telefono', pass = '$pass' WHERE id = '$id'");
                                                if($sql){
                                                  echo '<script type="text/javascript">';
                                                  echo 'window.location.href = \'usuarios.php?id='.$_SESSION['id'].'\';';
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

        $mail->Subject = "Datos de cuenta modificados";
        $mensajeHtml = nl2br($mensaje);
        $mail->Body = "
         <html>

         <body>

         <h3>Hola, $nombre.</h3>
                                                  <p>De acuerdo con tu solicitud, hemos modificado algunos datos de tu cuenta:</p>
                                                  <p>Nombre:</p> <h3>$nombre</h3>
                                                  <p>Nombre de usuario:</p> <h3>@$usuario</h3>
                                                  <p>Correo electrónico:</p> <h3>$correo</h3>
                                                  <p>Teléfono:</p> <h3>$telefono</h3>
                                                  <p>Contraseña:</p> <h3>$passw</h3>
                                                  
                                                  <p>Si crees que esto ha sido un error por favor contactanos a la brevedad.</p>

                                                  <p><b>Atentamente -El equipo de LibreCripto.</b></p>
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
                                            echo "toastr.error('Las contraseñas no coinciden. Intentá de nuevo.')";
                                            echo "</script>";
                                          }
                                        }else{
                                          echo "<script type='text/javascript'>";
                                          echo "toastr.error('Debes ingresar tu contraseña para poder confirmar los cambios.')";
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
                        </div>
                      </td>
                    <?php
                    }
                    ?>
                  </tr>
                  <?php
                  }
                  ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Pass</th>
                    <th>Fecha_Reg</th>
                    <th>Avatar</th>
                    <th>CriptoTop</th>
                    <th>Codigo Verif</th>
                    <th>Confirmed Email</th>
                    <th>Token</th>
                    <th>Status</th>
                    <th>Operaciones</th>
                    <?php
                    if($use['rol'] === 'CEO'){
                    ?>
                    <th>Administrar</th>
                    <?php
                    }
                    ?>
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
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
include_once 'templates/footerun.php';
?>