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
            <h1>Chats</h1>
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
                <h3 class="card-title">Chats activos</h3>
              </div>
              <!-- /.card-header -->
              <?php
              include '../php/conexion_be.php';
              $userdbconsult = mysqli_query($conexion, "SELECT chats.*, usuarios.correo, usuarios.nombre, usuarios.usuario FROM chats INNER JOIN usuarios ON chats.incoming_msg_id = usuarios.user ORDER BY chatid DESC");
              $userdbconsult2 = mysqli_query($conexion, "SELECT chats.*, usuarios.correo, usuarios.nombre, usuarios.usuario FROM chats INNER JOIN usuarios ON chats.outgoing_msg_id = usuarios.user ORDER BY chatid DESC");
              ?>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Chat ID</th>
                    <th>Incoming MSG ID</th>
                    <th>Outgoing MSG ID</th>
                    <th>MSG Date</th>
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
                    $lista2 = mysqli_fetch_array($userdbconsult2)
                  ?>
                  <tr>
                    <td><?php echo $lista['chatid']; ?></td>
                    <td><?php echo $lista['incoming_msg_id']; ?></td>
                    <td><?php echo $lista['outgoing_msg_id']; ?></td>
                    <td><?php echo $lista['msgdate']; ?></td>
                    <?php
                    if($use['rol'] === 'CEO'){
                    ?>
                      <td>
                        <div class="row" style="justify-content: space-evenly">
                          <button type="button" class="btn btn-danger" style="flex-basis: 25%" data-toggle="modal" data-target="#exampleModal2<?php echo $lista['chatid'];?>" data-whatever="<?php echo $lista['chatid'];?>"><i class="far fa-trash-alt"></i></button>
                          <div class="modal fade bd-example-modal-xl" id="exampleModal2<?php echo $lista['chatid'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                      <label for="idx" class="col-form-label">ID de chat a eliminar</label>
                                      <input type="text" class="form-control" id="idx" readonly value="<?php echo $lista['chatid'];?>" name="idx"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="nombrex" class="col-form-label">Nombre del usuario que inició el chat</label>
                                      <input type="text" class="form-control" id="nombrex" readonly value="<?php echo $lista2['nombre'];?>" name="nombrex"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="usuariox" class="col-form-label">Nombre de usuario que inició el chat</label>
                                      <input type="text" class="form-control" id="usuariox" readonly value="<?php echo $lista2['usuario'];?>" name="usuariox"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="correox" class="col-form-label">Correo del usuario que inició el chat</label>
                                      <input type="text" class="form-control" id="correox" readonly value="<?php echo $lista2['correo'];?>" name="correox"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="nombrex" class="col-form-label">Nombre del usuario que recibió el chat</label>
                                      <input type="text" class="form-control" id="nombrex" readonly value="<?php echo $lista['nombre'];?>" name="nombredos"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="usuariox" class="col-form-label">Nombre de usuario que recibió el chat</label>
                                      <input type="text" class="form-control" id="usuariox" readonly value="<?php echo $lista['usuario'];?>" name="usuariodos"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="correox" class="col-form-label">Correo del usuario que recibió el chat</label>
                                      <input type="text" class="form-control" id="correox" readonly value="<?php echo $lista['correo'];?>" name="correodos"></in>
                                    </div>
                                    <div class="form-group">
                                      <label for="razon" class="col-form-label">Motivo de la eliminación del chat</label>
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
                                        $nombrex = $_POST['nombrex'];
                                        $usuariox = $_POST['usuariox'];
                                        $correox = $_POST['correox'];
                                        $nombredos = $_POST['nombredos'];
                                        $usuariodos = $_POST['usuariodos'];
                                        $correodos = $_POST['correodos'];
                                        $razon = $_POST['razon'];
                                        //Encriptado de contraseña
                                        if($usercontrax != ''){
                                          if($_SESSION['pass'] === $usercontraxpass){
                                            if($razon != ''){
                                              $sqld = mysqli_query($conexion, "DELETE FROM chats WHERE chatid = '$idx'");
                                              $sqld2 = mysqli_query($conexion, "DELETE FROM messages WHERE chatid = '$idx'");
                                              if($sqld2){
                                                echo '<script type="text/javascript">';
                                                echo 'window.location.href = \'chats.php?id='.$_SESSION['id'].'\';';
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

        $mail->Subject = "Aviso de chat eliminado";
        $mensajeHtml = nl2br($mensaje);
        $mail->Body = "
         <html>

         <body>

         <h3>Hola, $nombrex.</h3>
                                                <p>Hemos eliminado tu conversación con @$usuariodos.</p>
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
        $mail->AddAddress($correodos);
        $mail->AddReplyTo('no-reply@librecripto.com','no-reply');

        $mail->Subject = "Aviso de chat eliminado";
        $mensajeHtml = nl2br($mensaje);
        $mail->Body = "
         <html>

         <body>

         <h3>Hola, $nombredos.</h3>
                                                <p>Hemos eliminado tu conversación con @$usuariox.</p>
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
                    <th>Chat ID</th>
                    <th>Incoming MSG ID</th>
                    <th>Outgoing MSG ID</th>
                    <th>MSG Date</th>
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