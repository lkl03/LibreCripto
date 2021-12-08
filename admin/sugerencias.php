<?php
session_start();
?>
<head>
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
</head>
<?php 
  include_once 'templates/headeradm.php';
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
            <h1>Sugerencias</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
    <div class="row">
          <div class="col-12">
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Mensajes de usuarios por sugerencias para LibreCripto</h3>
              </div>
              <!-- ./card-header -->
              <?php
              include 'php/connect.php';
              $userdbconsult = mysqli_query($connect, "SELECT * FROM contactos WHERE motivo = 'Sugerencias' AND solved = '0' ORDER BY contacto ASC");
              ?>
              <div class="card-body">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Contacto</th>
                      <th>Fecha de Contacto</th>
                      <th>Nombre del Contactante</th>
                      <th>Correo del Contactante</th>
                      <th>Motivo del Contactante</th>
                      <th>Mensaje</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  while($lista = mysqli_fetch_array($userdbconsult)){
                    $contacto = $lista['contacto'];
                    $fecha = $lista['fechacontacto'];
                    $nombre = $lista['nombre'];
                    $correo = $lista['correo'];
                    $motivo = $lista['motivo'];
                    $mensaje = $lista['mensaje'];
                  ?>
                    <tr data-widget="expandable-table" aria-expanded="false">
                      <td><?php echo $lista['contacto']; ?></td>
                      <td><?php echo $lista['fechacontacto']; ?></td>
                      <td><?php echo $lista['nombre']; ?></td>
                      <td><?php echo $lista['correo']; ?></td>
                      <td><?php echo $lista['motivo']; ?></td>
                      <td><?php echo $lista['mensaje']; ?></td>
                    </tr>
                    <tr class="expandable-body d-none">
                      <td colspan="5">
                        <div class="row" style="display: none;">
                          <div class="col-md-12">
                            <button type="button" class="btn btn-block bg-info" data-toggle="modal" data-target="#exampleModal2<?php echo $lista['contacto'];?>" data-whatever="<?php echo $lista['contacto'];?>"><i class="fas fa-reply"></i> Responder</button>
                            <div class="modal fade bd-example-modal-xl" id="exampleModal2<?php echo $lista['contacto'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Responder mensaje</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="" method="POST" enctype="multipart/form-data">
                                          <div class="form-group">
                                            <input type="hidden" class="form-control" id="usercontact" maxlenght="11" name="usercontact" value="<?php echo $lista['contacto']?>">
                                          </div>
                                          <div class="form-group">
                                            <input type="hidden" class="form-control" id="usermotivo" maxlenght="100" name="usermotivo" value="<?php echo $lista['motivo']?>">
                                          </div>
                                          <div class="form-group">
                                            <input type="hidden" class="form-control" id="usernombre" maxlenght="50" name="usernombre" value="<?php echo $lista['nombre']?>">
                                          </div>
                                          <div class="form-group">
                                            <input type="hidden" class="form-control" id="usercorreo" maxlenght="100" name="usercorreo" value="<?php echo $lista['correo']?>">
                                          </div>
                                          <div class="form-group">
                                            <label for="response" class="col-form-label">Respuesta</label>
                                            <textarea class="form-control" id="response" placeholder= "No incluir ni 'Hola' ni agradecimientos por el contacto: se envían por default con el email" maxlenght="2000" name="response"></textarea>
                                          </div>
                                          <div class="form-group">
                                            <label for="usercontrax" class="col-form-label">Escribir su contraseña para enviar respuesta</label>
                                            <input type="password" class="form-control" id="usercontrax" maxlenght="150" name="usercontrax">
                                          </div>
                                          <button type="submit" class="btn btn-primary" name="rechazarsol">Responder</button>
                                          <?php
                                            if(isset($_POST['rechazarsol'])){
                                              $usercontrax = $_POST['usercontrax'];
                                              $usercontraxpass = hash('sha512', $usercontrax);
                                              $usercontact = $_POST['usercontact'];
                                              $usermotivo = $_POST['usermotivo'];
                                              $usernombre = $_POST['usernombre'];
                                              $usercorreo = $_POST['usercorreo'];
                                              $idx = $_POST['idx'];
                                              $response = $_POST['response'];
                                              //Encriptado de contraseña
                                              if($usercontrax != ''){
                                                if($_SESSION['pass'] === $usercontraxpass){
                                                  if($response != ''){
                                                    $sqld = mysqli_query($connect, "UPDATE contactos SET solved = '1' WHERE contacto = '$usercontact'");
                                                    if($sqld){
                                                      echo '<script type="text/javascript">';
                                                      echo 'window.location.href = \'sugerencias.php?id='.$_SESSION['id'].'\';';
                                                      echo '</script>';
                                                      require 'php/src/Exception.php';
                                                require 'php/src/PHPMailer.php';
                                                require 'php/src/SMTP.php';
                                                  
                                                $smtpHost = "c2410691.ferozo.com";
        $smtpUsuario = "contacto@librecripto.com";
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
        $mail->AddAddress($usercorreo);
        $mail->AddReplyTo('contacto@librecripto.com','contacto-librecripto');

        $mail->Subject = "RE: '$usermotivo'";
        $mensajeHtml = nl2br($mensaje);
        $mail->Body = "
         <html>

         <body>

         <h3>Hola, $usernombre.</h3>
                                                      <p>Gracias por ponerte en contacto con nosotros :)</p>

                                                      <p>$response</p>
                                                        
                                                      <p>Si tenés algo mas para decirnos, por favor no dudes en volver a contactarnos ;)</p>

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
                                                    echo "toastr.error('La respuesta no puede quedar vacía.')";
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
                        </div>
                      </td>
                    </tr>
                    <?php
                  }
                  ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
include_once 'templates/footeradm.php';
?>