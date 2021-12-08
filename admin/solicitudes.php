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
            <h1>Solicitudes CriptoTop</h1>
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
                <h3 class="card-title">Solicitudes de usuarios para ser Cripto Top</h3>
              </div>
              <!-- ./card-header -->
              <?php
              include 'php/connect.php';
              $userdbconsult = mysqli_query($connect, "SELECT * FROM criptotop WHERE estado = 'enviada' ORDER BY solicitud DESC");
              ?>
              <div class="card-body">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Solicitud</th>
                      <th>ID Solicitante</th>
                      <th>Nombre Solicitante</th>
                      <th>Usuario Solicitante</th>
                      <th>Correo Solicitante</th>
                      <th>Estado Solicitud</th>
                      <th>Fecha Solicitud</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  while($lista = mysqli_fetch_array($userdbconsult)){
                    $solicitud = $lista['solicitud'];
                    $userid = $lista['idsol'];
                    $nm = $lista['nombresol'];
                    $us = $lista['usuariosol'];
                    $cr = $lista['correosol'];
                  ?>
                  <tr>
                    <tr data-widget="expandable-table" aria-expanded="false">
                      <td><?php echo $lista['solicitud']; ?></td>
                      <td><?php echo $lista['idsol']; ?></td>
                      <td><?php echo $lista['nombresol']; ?></td>
                      <td><?php echo $lista['usuariosol']; ?></td>
                      <td><?php echo $lista['correosol']; ?></td>
                      <td><?php echo $lista['estado']; ?></td>
                      <td><?php echo $lista['fecha']; ?></td>
                    </tr>
                    <tr class="expandable-body d-none">
                      <td colspan="5">
                        <div class="row" style="display: none;">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-block bg-success" onclick="cargarData('<?php echo $solicitud; ?>', '<?php echo $userid; ?>', '<?php echo $nm; ?>', '<?php echo $us; ?>', '<?php echo $cr; ?>');"><i class="fas fa-check"></i> Aprobar</button>
                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script type="text/javascript">
                                function cargarData(id, userid, nm, us, cr) {
                                        var url="approvesol.php";
                                        $.ajax({
                                          type: 'POST',
                                          url:url,
                                          data:{id: id, userid: userid, nm: nm, us: us, cr: cr},
                                          success:function(){
                                            location.reload();
                                          }
                                        });
                                    };
                                </script>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-block bg-danger" data-toggle="modal" data-target="#exampleModal2<?php echo $lista['solicitud'];?>" data-whatever="<?php echo $lista['solicitud'];?>"><i class="fas fa-times"></i> Rechazar</button>
                                <div class="modal fade bd-example-modal-xl" id="exampleModal2<?php echo $lista['solicitud'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Rechazar solicitud</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="" method="POST" enctype="multipart/form-data">
                                          <div class="form-group">
                                            <input type="hidden" class="form-control" id="usersol" maxlenght="11" name="usersol" value="<?php echo $lista['solicitud']?>">
                                          </div>
                                          <div class="form-group">
                                            <input type="hidden" class="form-control" id="usernombre" maxlenght="50" name="usernombre" value="<?php echo $lista['nombresol']?>">
                                          </div>
                                          <div class="form-group">
                                            <input type="hidden" class="form-control" id="userusuario" maxlenght="16" name="userusuario" value="<?php echo $lista['usuariosol']?>">
                                          </div>
                                          <div class="form-group">
                                            <input type="hidden" class="form-control" id="usercorreo" maxlenght="100" name="usercorreo" value="<?php echo $lista['correosol']?>">
                                          </div>
                                          <div class="form-group">
                                            <label for="razon" class="col-form-label">Motivo del rechazo de la solicitud</label>
                                            <textarea class="form-control" id="razon" maxlenght="500" name="razon"></textarea>
                                          </div>
                                          <div class="form-group">
                                            <label for="usercontrax" class="col-form-label">Escribir su contraseña para confirmar rechazo</label>
                                            <input type="password" class="form-control" id="usercontrax" maxlenght="150" name="usercontrax">
                                          </div>
                                          <button type="submit" class="btn btn-primary" name="rechazarsol">Rechazar</button>
                                          <?php
                                            if(isset($_POST['rechazarsol'])){
                                              $usercontrax = $_POST['usercontrax'];
                                              $usercontraxpass = hash('sha512', $usercontrax);
                                              $usersol = $_POST['usersol'];
                                              $usernombre = $_POST['usernombre'];
                                              $userusuario = $_POST['userusuario'];
                                              $usercorreo = $_POST['usercorreo'];
                                              $idx = $_POST['idx'];
                                              $razon = $_POST['razon'];
                                              //Encriptado de contraseña
                                              if($usercontrax != ''){
                                                if($_SESSION['pass'] === $usercontraxpass){
                                                  if($razon != ''){
                                                    $sqld = mysqli_query($connect, "UPDATE criptotop SET estado = 'rechazada' WHERE solicitud = '$usersol'");
                                                    if($sqld){
                                                      echo '<script type="text/javascript">';
                                                      echo 'window.location.href = \'solicitudes.php?id='.$_SESSION['id'].'\';';
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
        $mail->AddAddress($usercorreo);
        $mail->AddReplyTo('no-reply@librecripto.com','no-reply');

        $mail->Subject = "Solicitud para CriptoTop rechazada";
        $mensajeHtml = nl2br($mensaje);
        $mail->Body = "
         <html>

         <body>

         <h3>Hola, $usernombre.</h3>
                                                      <p>Tu solicitud para ser CriptoTop ha sido rechazada.</p>
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
                                                    echo "toastr.error('El motivo del rechazo no puede quedar vacío.')";
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
                            <div class="col-md-4">
                                <button type="button" class="btn btn-block bg-info"><i class="fas fa-search"></i> <a href="usuarios.php?id=<?php echo $_SESSION['id']?>">Ver estadísticas de usuario</a></button>
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