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
            <h1>Novedades</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-6">
                    <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Novedades</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1" class=""></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2" class=""></li>
                        </ol>
                        <?php
                        $nwid = mysqli_query($connect, "SELECT * FROM novedades ORDER BY novedad DESC");
                        $nw = mysqli_fetch_array($nwid);
                        $id = $nw['novedad'];
                        $mensid = mysqli_query($connect, "SELECT * FROM mensajes ORDER BY mensaje DESC");
                        $mens = mysqli_fetch_array($mensid);
                        $nw1 = mysqli_query($connect, "SELECT * FROM novedades WHERE novedad = '1'");
                        $anw1 = mysqli_fetch_array($nw1);
                        $nw2 = mysqli_query($connect, "SELECT * FROM novedades WHERE novedad = '2'");
                        $anw2 = mysqli_fetch_array($nw2);
                        $nw3 = mysqli_query($connect, "SELECT * FROM novedades WHERE novedad = '3'");
                        $anw3 = mysqli_fetch_array($nw3);
                        ?>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                            <img class="d-block w-100" src="img/<?php echo $anw1['novedadpic']?>" alt="First slide">
                                <div class="card-img-overlay d-flex flex-column justify-content-end">
                                    <h5 class="card-title text-primary text-white"><?php echo $anw1['novedadtitle']?></h5>
                                    <p class="card-text text-white pb-2 pt-1"><?php echo $anw1['novedadtext'] ?></p>
                                    <a href="#" class="text-white"><?php echo $anw1['novedaddate']?></a>
                                </div>
                            </div>
                            <div class="carousel-item">
                            <img class="d-block w-100" src="img/<?php echo $anw2['novedadpic']?>" alt="Second slide">
                                <div class="card-img-overlay d-flex flex-column justify-content-end">
                                    <h5 class="card-title text-primary text-white"><?php echo $anw2['novedadtitle']?></h5>
                                    <p class="card-text text-white pb-2 pt-1"><?php echo $anw2['novedadtext'] ?></p>
                                    <a href="#" class="text-white"><?php echo $anw2['novedaddate']?></a>
                                </div>
                            </div>
                            <div class="carousel-item">
                            <img class="d-block w-100" src="img/<?php echo $anw3['novedadpic']?>" alt="Third slide">
                                <div class="card-img-overlay d-flex flex-column justify-content-end">
                                    <h5 class="card-title text-primary text-white"><?php echo $anw3['novedadtitle']?></h5>
                                    <p class="card-text text-white pb-2 pt-1"><?php echo $anw3['novedadtext'] ?></p>
                                    <a href="#" class="text-white"><?php echo $anw3['novedaddate']?></a>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-custom-icon" aria-hidden="true">
                            <i class="fas fa-chevron-left"></i>
                            </span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-custom-icon" aria-hidden="true">
                            <i class="fas fa-chevron-right"></i>
                            </span>
                            <span class="sr-only">Next</span>
                        </a>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <?php
                          if($use['rol'] === 'CEO'){
                        ?>
                          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Modificar</button>
                          <div class="modal fade bd-example-modal-xl" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-xl" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Nuevo mensaje de bienvenida</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                      <label for="novedadtitle" class="col-form-label">Título de la novedad</label>
                                      <textarea class="form-control" id="novedadtitle" maxlenght="200" placeholder="<?php echo $nw['novedadtitle'];?>" name="novedadtitle"></textarea>
                                    </div>
                                    <div class="form-group">
                                      <label for="novedad" class="col-form-label">Texto de la novedad</label>
                                      <textarea class="form-control" id="novedad" maxlenght="500" placeholder="<?php echo $nw['novedadtitle'];?>" name="novedadtext"></textarea>
                                    </div>
                                    <div class="form-group">
                                      <label for="imagen">Imagen de la novedad</label>
                                      <div class="input-group">
                                        <div class="custom-file">
                                          <input type="file" class="custom-file-input" id="imagen" name="imagen">
                                          <label class="custom-file-label" for="imagen">Seleccionar imagen...</label>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label>Novedad a cambiar</label>
                                      <select class="form-control" name="novedad">
                                        <option value="1">Novedad 1</option>
                                        <option value="2">Novedad 2</option>
                                        <option value="3">Novedad 3</option>
                                      </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="novedadchanger">Modificar</button>
                                    <?php
                                      if(isset($_POST['novedadchanger'])){
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
                    <!-- /.card -->
        </div>
        <div class="col-md-6">
                <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">
                    <i class="fas fa-bullhorn"></i>
                    Mensajes Destacados
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <?php
                      $consult = mysqli_query($connect, "SELECT * FROM mensajes ORDER BY mensaje ASC");
                      while($lista = mysqli_fetch_array($consult)){
                        $mensaje = $lista['mensaje'];
                    ?>
                    <div class="callout callout-info">
                    <h5><?php echo $lista['mensajetitle'];?></h5>

                    <p><?php echo $lista['mensajetext'];?></p>
                    
                    <div style="text-align:end;">
                    <?php
                      if($use['rol'] === 'CEO'){
                    ?>
                      <span class="badge bg-danger" style="cursor:pointer;" onclick="cargarData(<?php echo $mensaje; ?>);"><i class="fas fa-trash"></i></span>
                      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script type="text/javascript">
                                function cargarData(id) {
                                    var url="deletemensaje.php";
                                    $.ajax({
                                      type: 'POST',
                                      url:url,
                                      data: 'id='+id,
                                      success:function(){
                                        location.reload();
                                      }
                                    });
                                };
                        </script>
                    </div>
                    </div>
                    <?php
                      }
                    }     
                    ?>
                </div>
                <!-- /.card-body -->
                <?php
                          if($use['rol'] === 'CEO'){
                        ?>
                          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal2" data-whatever="@fat">Agregar</button>
                          <div class="modal fade bd-example-modal-xl" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-xl" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Nuevo mensaje destacado</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                      <label for="mensajetitle" class="col-form-label">Título del mensaje</label>
                                      <textarea class="form-control" id="mensajetitle" maxlenght="200" placeholder="<?php echo $mens['mensajetitle'];?>" name="mensajetitle"></textarea>
                                    </div>
                                    <div class="form-group">
                                      <label for="mensajetext" class="col-form-label">Texto del mensaje</label>
                                      <textarea class="form-control" id="mensajetext" maxlenght="500" placeholder="<?php echo $mens['mensajetext'];?>" name="mensajetext"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="mensajeadd">Agregar</button>
                                    <?php
                                      if(isset($_POST['mensajeadd'])){
                                        $mensajetitle = $_POST['mensajetitle'];
                                        $mensajetext = $_POST['mensajetext'];
                                        if($mensajetitle != '' && $mensajetext != ''){
                                          $sqlm = mysqli_query($connect, "INSERT INTO mensajes(mensajetitle, mensajetext) VALUES('$mensajetitle', '$mensajetext')");
                                          if($sqlm){
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
                <!-- /.card -->
        </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
include_once 'templates/footeredit.php';
?>