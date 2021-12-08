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
            <h1>Anuncios</h1>
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
                <h3 class="card-title">Anuncios activos</h3>
              </div>
              <!-- /.card-header -->
              <?php
              include '../php/conexion_be.php';
              $userdbconsult = mysqli_query($conexion, "SELECT usuarios.nombre, usuarios.correo, anuncios.* FROM usuarios INNER JOIN anuncios ON usuarios.user = anuncios.user ORDER BY id_pub DESC");
              ?>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID PUB</th>
                    <th>Usuario</th>
                    <th>ID</th>
                    <th>User</th>
                    <th>Fecha</th>
                    <th>Provincia</th>
                    <th>Localidad</th>
                    <th>Moneda</th>
                    <th>Cantidad</th>
                    <th>Comisión</th>
                    <th>Operación</th>
                    <th>P2P</th>
                    <th>F2F</th>
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
                    <td><?php echo $lista['id_pub']; ?></td>
                    <td><?php echo $lista['usuario']; ?></td>
                    <td><?php echo $lista['id']; ?></td>
                    <td><?php echo $lista['user']; ?></td>
                    <td><?php echo $lista['fecha']; ?></td>
                    <td><?php echo $lista['provincia']; ?></td>
                    <td><?php echo $lista['localidad']; ?></td>
                    <td><?php echo $lista['moneda']; ?></td>
                    <td><?php echo $lista['cantidad']; ?></td>
                    <td><?php echo $lista['comision']; ?></td>
                    <td><?php echo $lista['operacion']; ?></td>
                    <td><?php echo $lista['p2p']; ?></td>
                    <td><?php echo $lista['f2f']; ?></td>
                    <?php
                    if($use['rol'] === 'CEO'){
                    ?>
                      <td>
                        <div class="row" style="justify-content: space-evenly">
                          <button type="button" class="btn btn-danger" style="flex-basis: 25%" data-toggle="modal" data-target="#exampleModal2<?php echo $lista['id_pub'];?>" data-whatever="<?php echo $lista['id_pub'];?>"><i class="far fa-trash-alt"></i></button>
                          <div class="modal fade bd-example-modal-xl" id="exampleModal2<?php echo $lista['id_pub'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Eliminar anuncio</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                      <label for="idx" class="col-form-label">ID de anuncio a eliminar</label>
                                      <input type="text" class="form-control" id="idx" readonly value="<?php echo $lista['id_pub'];?>" name="idx"></in>
                                    </div>
                                    <div class="form-group">
                                      <input type="hidden" class="form-control" id="fechax" value="<?php echo $lista['fecha'];?>" name="fechax"></in>
                                    </div>
                                    <div class="form-group">
                                      <input type="hidden" class="form-control" id="provinciax" value="<?php echo $lista['provincia'];?>" name="provinciax"></in>
                                    </div>
                                    <div class="form-group">
                                      <input type="hidden" class="form-control" id="localidadx" value="<?php echo $lista['localidad'];?>" name="localidadx"></in>
                                    </div>
                                    <div class="form-group">
                                      <input type="hidden" class="form-control" id="monedax" value="<?php echo $lista['moneda'];?>" name="monedax"></in>
                                    </div>
                                    <div class="form-group">
                                      <input type="hidden" class="form-control" id="cantidadx" value="<?php echo $lista['cantidad'];?>" name="cantidadx"></in>
                                    </div>
                                    <div class="form-group">
                                      <input type="hidden" class="form-control" id="comisionx" value="<?php echo $lista['comision'];?>" name="comisionx"></in>
                                    </div>
                                    <div class="form-group">
                                      <input type="hidden" class="form-control" id="operacionx" value="<?php echo $lista['operacion'];?>" name="operacionx"></in>
                                    </div>
                                    <div class="form-group">
                                      <input type="hidden" class="form-control" id="p2px" value="<?php echo $lista['p2p'];?>" name="p2px"></in>
                                    </div>
                                    <div class="form-group">
                                      <input type="hidden" class="form-control" id="f2fx" value="<?php echo $lista['f2f'];?>" name="f2fx"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="nombrex" class="col-form-label">Nombre del usuario que publicó el anuncio a eliminar</label>
                                      <input type="text" class="form-control" id="nombrex" readonly value="<?php echo $lista['nombre'];?>" name="nombrex"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="correox" class="col-form-label">Correo del usuario que publicó el anuncio a eliminar</label>
                                      <input type="text" class="form-control" id="correox" readonly value="<?php echo $lista['correo'];?>" name="correox"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="razon" class="col-form-label">Motivo de la eliminación del anuncio</label>
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
                                        $idx = $_POST['idx'];
                                        $fechax = $_POST['fechax'];
                                        $provinciax = $_POST['provinciax'];
                                        $localidadx = $_POST['localidadx'];
                                        $monedax = $_POST['monedax'];
                                        $cantidadx = $_POST['cantidadx'];
                                        $comisionx = $_POST['comisionx'];
                                        $operacionx = $_POST['operacionx'];
                                        $p2px = $_POST['p2px'];
                                        $f2fx = $_POST['f2fx'];
                                        $nombrex = $_POST['nombrex'];
                                        $correox = $_POST['correox'];
                                        $razon = $_POST['razon'];
                                        //Encriptado de contraseña
                                        if($usercontrax != ''){
                                          if($_SESSION['pass'] === $usercontraxpass){
                                            if($razon != ''){
                                              $sqld = mysqli_query($conexion, "DELETE FROM anuncios WHERE id_pub = '$idx'");
                                              if($sqld){
                                                echo '<script type="text/javascript">';
                                                echo 'window.location.href = \'anuncios.php?id='.$_SESSION['id'].'\';';
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

        $mail->Subject = "Aviso de anuncio eliminado";
        $mensajeHtml = nl2br($mensaje);
        $mail->Body = "
         <html>

         <body>

         <h3>Hola, $nombrex.</h3>
                                                <p>Hemos eliminado uno de tus anuncios de LibreCripto.</p>
                                                <p>El anuncio eliminado es el publicado en la fecha '$fechax', en la provincia de '$provinciax', en la localidad de '$localidadx', donde ofrecias una '$operacionx' con la cantidad de '$cantidadx' en moneda '$monedax', con un fee del '$comisionx' y con el/los método/s '$p2px' '$f2fx'</p>
                                                <p>La eliminación se debe a:</p> 
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
                          <button type="button" class="btn btn-warning" style="flex-basis: 25%" data-toggle="modal" data-target="#exampleModal<?php echo $lista['id'];?>" data-whatever="<?php echo $lista['id'];?>"><i class="fas fa-edit"></i></button>
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
                                      <label for="id" class="col-form-label">ID de anuncio a modificar</label>
                                      <input type="text" class="form-control" id="id" readonly value="<?php echo $lista['id_pub'];?>" name="id"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="fecha" class="col-form-label">Fecha de publicación del anuncio a modificar</label>
                                      <input type="text" class="form-control" id="fecha" readonly value="<?php echo $lista['fecha'];?>" name="fecha"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="provincia" class="col-form-label">Provincia del anuncio a modificar</label>
                                      <input type="text" class="form-control" id="provincia" value="<?php echo $lista['provincia'];?>" name="provincia"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="localidad" class="col-form-label">Localidad del anuncio a modificar</label>
                                      <input type="text" class="form-control" id="localidad" value="<?php echo $lista['localidad'];?>" name="localidad"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="moneda" class="col-form-label">Moneda del anuncio a modificar</label>
                                      <input type="text" class="form-control" id="moneda" value="<?php echo $lista['moneda'];?>" name="moneda"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="cantidad" class="col-form-label">Cantidad del anuncio a modificar</label>
                                      <input type="text" class="form-control" id="cantidad" value="<?php echo $lista['cantidad'];?>" name="cantidad"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="comision" class="col-form-label">Comisión del anuncio a modificar</label>
                                      <input type="text" class="form-control" id="comision" value="<?php echo $lista['comision'];?>" name="comision"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="operacion" class="col-form-label">Operación del anuncio a modificar</label>
                                      <input type="text" class="form-control" id="operacion" value="<?php echo $lista['operacion'];?>" name="operacion"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="p2p" class="col-form-label">P2P del anuncio a modificar</label>
                                      <input type="text" class="form-control" id="p2p" value="<?php echo $lista['p2p'];?>" name="p2p"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="f2f" class="col-form-label">F2F del anuncio a modificar</label>
                                      <input type="text" class="form-control" id="f2f" value="<?php echo $lista['f2f'];?>" name="f2f"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="nombrex" class="col-form-label">Nombre del usuario que publicó el anuncio a eliminar</label>
                                      <input type="text" class="form-control" id="nombre" readonly value="<?php echo $lista['nombre'];?>" name="nombre"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="correox" class="col-form-label">Correo del usuario que publicó el anuncio a eliminar</label>
                                      <input type="text" class="form-control" id="correo" readonly value="<?php echo $lista['correo'];?>" name="correo"></in>
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
                                        $fecha = $_POST['fecha'];
                                        $provincia = $_POST['provincia'];
                                        $localidad = $_POST['localidad'];
                                        $moneda = $_POST['moneda'];
                                        $cantidad = $_POST['cantidad'];
                                        $comision = $_POST['comision'];
                                        $operacion = $_POST['operacion'];
                                        $p2p = $_POST['p2p'];
                                        $f2f = $_POST['f2f'];
                                        $nombre = $_POST['nombre'];
                                        $correo = $_POST['correo'];
                                        if($usercontra != ''){
                                          if($_SESSION['pass'] === $usercontrapass){
                                                $sql = mysqli_query($conexion, "UPDATE anuncios SET provincia = '$provincia', localidad = '$localidad', moneda = '$moneda', cantidad = '$cantidad', comision = '$comision', operacion = '$operacion', p2p = '$p2p', f2f = '$f2f' WHERE id_pub = '$id'");
                                                if($sql){
                                                  echo '<script type="text/javascript">';
                                                  echo 'window.location.href = \'anuncios.php?id='.$_SESSION['id'].'\';';
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

        $mail->Subject = "Datos de anuncio modificados";
        $mensajeHtml = nl2br($mensaje);
        $mail->Body = "
         <html>

         <body>

         <h3>Hola, $nombre.</h3>
                                                  <p>De acuerdo con tu solicitud, hemos modificado algunos datos de uno de tus anuncios publicados.</p>
                                                  <p>El anuncio modificado es el publicado el</p> <h3>$fecha</h3>
                                                  <p>Provincia:</p> <h3>$provincia</h3>
                                                  <p>Localidad:</p> <h3>$localidad</h3>
                                                  <p>Moneda:</p> <h3>$moneda</h3>
                                                  <p>Cantidad:</p> <h3>$cantidad</h3>
                                                  <p>Comisión:</p> <h3>$comision</h3>
                                                  <p>Operación:</p> <h3>$operacion</h3>
                                                  <p>Método/s:</p> <h3>$p2p</h3> <h3>$f2f</h3>
                                                  
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
                    <th>ID PUB</th>
                    <th>Usuario</th>
                    <th>ID</th>
                    <th>User</th>
                    <th>Fecha</th>
                    <th>Provincia</th>
                    <th>Localidad</th>
                    <th>Moneda</th>
                    <th>Cantidad</th>
                    <th>Comisión</th>
                    <th>Operación</th>
                    <th>P2P</th>
                    <th>F2F</th>
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