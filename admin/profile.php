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
    }

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Mi Cuenta</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="col-md-12">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header text-white" style="background: #fe9416 center center;">
                <h3 class="widget-user-username text-right"><?php echo $use['nombre']?></h3>
                <h5 class="widget-user-desc text-right"><?php echo $use['rol']?></h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle" src="img/<?php echo $use['fotoperfil']?> " alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <!-- /.col -->
                  <div class="col-sm-12 border-right">
                    <div class="description-block">
                      <?php
                      $date = $use['fechacreacion']; 
                      $now = Carbon::now(new DateTimeZone('America/Argentina/Buenos_Aires'));
                      $publishdate = Carbon::create($date, 'America/Argentina/Buenos_Aires');
                      $publishdate->locale('es');
                      $diff = $publishdate->diffForHumans($now, CarbonInterface::DIFF_RELATIVE_TO_NOW);
                      ?>
                      <span class="description-text">ACTIVO DESDE</span>
                      <h5 class="description-header"><?php echo $diff?></h5>
                    </div>
                    <!-- /.description-block -->
                  </div>
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.widget-user -->
    </div>
    <div class="container-fluid row">
      <div class="col-md-4">
        <div class="card card-info">
                  <div class="card-header">
                    <h3 class="card-title">Compartir un mensaje</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <?php
                    $msg = mysqli_query($connect, "SELECT * FROM sharemessage WHERE mensajeiduser = '$id' ORDER BY mensaje DESC");
                    $msgarr = mysqli_fetch_array($msg);
                    if($msgarr != NULL){
                    $dt = $msgarr['mensajefecha']; 
                    $nw = Carbon::now(new DateTimeZone('America/Argentina/Buenos_Aires'));
                    $msgdt = Carbon::create($dt, 'America/Argentina/Buenos_Aires');
                    $msgdt->locale('es');
                    $dif = $msgdt->diffForHumans($nw, CarbonInterface::DIFF_RELATIVE_TO_NOW);
                    ?>
                    <strong><i class="far fa-file-alt mr-1"></i> <?php echo $dif ?></strong>
                    <p class="text-muted"><?php echo $msgarr['mensajetext']?></p>
                    <?php
                    }else{
                      echo "Nada para mostrar por acá...";
                    }
                    ?>
                    <?php
                    if($_SESSION['id'] == $id){
                    ?>
                    <div class="card card-primary collapsed-card">
                      <div class="card-header">
                        <h3 class="card-title">Modificar</h3>

                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                        </div>
                        <!-- /.card-tools -->
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <form action="" method="POST">
                        <div class="col-md-12" style="margin-bottom: 2.5%">
                          <textarea class="form-control" rows="3" name="msg" placeholder="Enter ..."></textarea>
                        </div>
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-block bg-success" name="msgadd"><i class="fas fa-check"></i> Actualizar</button>
                        </div>
                        <?php
                        if(isset($_POST['msgadd'])){
                          $mensajetext = $_POST['msg'];
                          $mensajeiduser = $_SESSION['id'];
                          if($mensajetext != ''){
                              $sql = mysqli_query($connect, "INSERT INTO sharemessage(mensajetext, mensajeiduser, mensajefecha) VALUES('$mensajetext','$mensajeiduser', now())");
                              if($sql){
                              echo '<script type="text/javascript">';
                              echo 'window.location.href = \'profile.php?id='.$_SESSION['id'].'\';';
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
                        </form>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <?php
                    }
                    ?>
        </div>
                  <!-- /.card-body -->
        </div>
      </div>
      <div class="col-md-4">
        <div class="small-box bg-warning">
          <?php
          $wkn = mysqli_query($connect, "SELECT * FROM wknmessage WHERE workingiduser = '$id' ORDER BY working DESC");
          $wknarr = mysqli_fetch_array($wkn);
          ?>
                  <div class="inner">
                    <p>Trabajando en...</p>
                    <?php
                    if($wknarr != NULL){
                    ?>
                    <h3><?php echo $wknarr['workingon']?></h3> 
                    <?php
                    }else{
                    echo '¡Nada para mostrar por acá!';
                    }
                    ?>
                  </div>
                  <?php
                  if($_SESSION['id'] == $id){
                  ?>
                  <div class="icon">
                    <i class="fas fa-pencil-alt"></i>
                  </div>
                  <div class="small-box-footer">
                    Cambiar <i class="fas fa-arrow-circle-down"></i>
                    <form action="" method="post">
                    <div class="row container-fluid">
                      <div class="col-md-10">
                        <textarea class="form-control" rows="1" name="wknon" placeholder="¿En qué estás trabajando?"></textarea>
                      </div>
                      <div class="col-md-2">
                        <button type="submit" class="btn btn-block bg-success" name="wknadd"><i class="fas fa-check"></i></button>
                      </div>
                    </div>
                    <?php
                        if(isset($_POST['wknadd'])){
                          $workingon = $_POST['wknon'];
                          $workingiduser = $_SESSION['id'];
                          if($workingon != ''){
                              $sqlw = mysqli_query($connect, "INSERT INTO wknmessage(workingon, workingiduser) VALUES('$workingon','$workingiduser')");
                              if($sqlw){
                              echo '<script type="text/javascript">';
                              echo 'window.location.href = \'profile.php?id='.$_SESSION['id'].'\';';
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
                    </form>
                  </div>
                  <?php
                    }
                  ?>
        </div>
      </div>
      <div class="col-md-4">
      <div class="card card-info">
                  <div class="card-header">
                    <h3 class="card-title">Equipo</h3>
                    <?php
                    $users = mysqli_query($connect, "SELECT * FROM usuarios");
                    $rowusers = mysqli_num_rows($users);
                    ?>
                    <div class="card-tools">
                      <span class="badge badge-danger"><?php echo $rowusers?> Miembros</span>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <ul class="users-list clearfix">
                    <?php
                    $userdbconsult = mysqli_query($connect, "SELECT * FROM usuarios ORDER BY id ASC");
                    while($lista = mysqli_fetch_array($userdbconsult)){
                    ?>
                      <li>
                        <img src="img/<?php echo $lista['fotoperfil'] ?>" style="height: 70.5; width: 70.5;" alt="User Image">
                        <a class="users-list-name" href="profile.php?id=<?php echo $lista['id']?>"><?php echo $lista['nombre'] ?></a>
                        <span class="users-list-date"><?php echo $lista['rol'] ?></span>
                      </li>
                    <?php
                    }
                    ?>
                    </ul>
                    <!-- /.users-list -->
                  </div>
                  <!-- /.card-body -->
                  <!-- /.card-footer -->
        </div>
      </div>
    </div>
    <?php
    if($_SESSION['id'] == $id){
    ?>
    <div class="col-md-12">
      <a href="editprofile.php?id=<?php echo $_SESSION['id']?>" class="btn btn-block bg-primary"><i class="fas fa-user-edit"></i> Editar perfil</a>
    </div>
    <?php
    }
    ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
include_once 'templates/footeradm.php';
?>