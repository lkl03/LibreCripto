<?php
session_start();
?>
<head>
  <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
</head>
<?php 
  include_once 'templates/headeradm.php';
?>
<?php
require '../php/Carbon/autoload.php';
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonInterface;


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
            <h1>Editar perfil</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Modificar</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="" method="post">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputFile">Cambiar email</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="email" name="correo" class="form-control" id="exampleInputEmail1" placeholder="Email">
                      </div>
                      <div class="input-group-append">
                        <button type="submit" name="useremailchanger" class="input-group-text">Cambiar</button>
                      </div>
                    </div>
                  </div>
                  <?php
                    $idx = $_SESSION['id'];
                    if(isset($_POST['useremailchanger'])){
                      $correo = $_POST['correo'];
                      if(!empty($correo)){
                        $comprobationemail = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM usuarios WHERE correo = '$correo' AND id != '$idx'"));
                        if($comprobationemail == 0 && $correo != $use['correo']){
                          $sql = mysqli_query($connect, "UPDATE usuarios SET correo = '$correo' WHERE id = $idx");
                          if($sql){
                            echo "<script type='text/javascript'>";
                            echo "toastr.success('Email actualizado exitosamente.')";
                            echo "</script>";
                          }else{
                            echo "<script type='text/javascript'>";
                            echo "toastr.error('Ocurrió un error, intentá de nuevo.')";
                            echo "</script>";
                          }
                        }else{
                          echo "<script type='text/javascript'>";
                          echo "toastr.error('Ese correo ya se encuentra registrado, intentá de nuevo.')";
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
                <form action="" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="exampleInputFile">Cambiar foto de perfil</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="fotoperfil" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Seleccionar archivo...</label>
                      </div>
                      <div class="input-group-append">
                        <button type="submit" name="subirfoto" class="input-group-text">Subir</button>
                        <?php
                          if(isset($_POST['subirfoto'])){
                            $type = 'jpg';
                            $rfoto = $_FILES['fotoperfil']['tmp_name'];
                            $name = 'fotoperfil'.$idx.'.'.$type;
                            if(is_uploaded_file($rfoto)){
                                $destino = 'img/'.$name;
                                $nombrea = $name;
                                copy($rfoto, $destino);
                            }else{
                                $nombrea = $use['fotoperfil'];
                            }
                                $sqlp = mysqli_query($connect, "UPDATE usuarios SET fotoperfil = '$nombrea' WHERE id = $idx");
                                if($sqlp){
                                  echo "<script type='text/javascript'>";
                                  echo "toastr.success('Foto de perfil actualizada exitosamente.')";
                                  echo "</script>";
                                }else{
                                  echo "<script type='text/javascript'>";
                                  echo "toastr.error('Ocurrió un error, intentá de nuevo.')";
                                  echo "</script>";
                                }
                          }
                      ?>
                      </div>
                    </div>
                  </form>
                  </div>
                </div>
              </form>
              <?php
                if(isset($_POST['userinfomodifier'])){
                  $novedadtitle = $_POST['novedadtitle'];
                  $novedadtext = $_POST['novedadtext'];
                  $novedad = $_POST['novedad'];
                  $type = 'jpg';
                  $rfoto = $_FILES['imagen']['tmp_name'];
                  $name = 'novedad'.$id.'.'.$type;
                        
                  if(is_uploaded_file($rfoto)){
                    $destino = 'img/'.$name;
                    $nombrea = $name;
                    copy($rfoto, $destino);
                  }else{
                    $nombrea = $use['imagen'];
                  }
                  if($novedadtitle != '' && $novedadtext != '' && $nombrea != ''){
                    $sql = mysqli_query($connect, "UPDATE novedades SET novedadtitle = '$novedadtitle', novedadtext = '$novedadtext', novedadpic= '$nombrea', novedaddate = now() WHERE novedad = '$novedad'");
                    if($sql){
                      echo '<script type="text/javascript">';
                      echo 'window.location.href = \'news.php?id='.$_SESSION['id'].'\';';
                      echo '</script>';
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
              <form action="" method="post">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Contraseña actual</label>
                    <input type="password" class="form-control" name="passActual" id="exampleInputPassword1" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Cambiar contraseña</label>
                    <input type="password" class="form-control" name="pass1" id="exampleInputPassword1" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword2">Repetir nueva contraseña</label>
                    <input type="password" class="form-control" name= "pass2" id="exampleInputPassword2" placeholder="Repeat password">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="passchanger">Modificar contraseña</button>
                </div>
              </form>
              <?php 
                        if(isset($_POST['passchanger'])){
                                $passActual = ($_POST['passActual']);
                                $pass1 = ($_POST['pass1']);
                                $pass2 = ($_POST['pass2']);

                                $passActual = hash('sha512', $passActual);
                                $pass1 = hash('sha512', $pass1);
                                $pass2 = hash('sha512', $pass2);

                                if(!empty($_POST['passActual']) && !empty($_POST['pass1']) && !empty($_POST['pass2'])){
                                  $sqlA = mysqli_query($connect, "SELECT pass FROM usuarios WHERE id = '$id'");
                                  $rowA = mysqli_fetch_array($sqlA);
  
                                  if($rowA['pass'] == $passActual) {
  
                                      if($pass1 == $pass2) {
                                              $update = mysqli_query($connect, "UPDATE usuarios SET pass = '$pass1' WHERE id = '$id'");
                                              if($update) {   
                                                echo "<script type='text/javascript'>";
                                                echo "toastr.success('Contraseña actualizada exitosamente.')";
                                                echo "</script>";                  
                                          }
                                      }else {
                                        echo "<script type='text/javascript'>";
                                        echo "toastr.error('Las nuevas contraseñas no coinciden, intentá de nuevo.')";
                                        echo "</script>"; 
                                      }
                                  }else {
                                    echo "<script type='text/javascript'>";
                                    echo "toastr.error('La contraseña actual es incorrecta, intentá nuevamente.')";
                                    echo "</script>"; 
                                  }
                                }else{
                                  echo "<script type='text/javascript'>";
                                  echo "toastr.error('Revisá si hay algún campo vacío e intentá de nuevo.')";
                                  echo "</script>";
                                }


                        }
              ?>

        </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
include_once 'templates/footeredit.php';
?>