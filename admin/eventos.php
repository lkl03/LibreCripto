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
                <h1>Eventos</h1>
            </div>
            </div>
        </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
            <!-- Timelime example  -->
            <div class="row">
                <?php
                    $consult = mysqli_query($connect, "SELECT * FROM eventos ORDER BY eventodate DESC");
                    while($lista = mysqli_fetch_array($consult)){
                    $evento = $lista['evento'];
                    $creador = $lista['eventocreador'];
                    $prioridad = $lista['eventopriority'];
                ?>
                <div class="col-md-12">
                    <!-- The time line -->
                    <div class="timeline">
                    <!-- timeline time label -->
                    <div class="time-label">
                        <span class="bg-green"><?php echo $lista['eventodate']; ?></span>
                    </div>
                    <!-- /.timeline-label -->
                    <!-- timeline item -->
                    <div>
                        <i class="far fa-calendar bg-blue"></i>
                        <div class="timeline-item">
                        <span class="time"><i class="fas fa-clock"></i> <?php echo $lista['eventodate']; ?></span>
                        <?php
                            if($prioridad == '1'){ 
                            ?>
                            <a class="btn btn-warning btn-xs">Prioritario</a>
                            <?php
                            }
                        ?> 
                        <h3 class="timeline-header"><a href="#"><?php echo $lista['eventocreador']; ?></a> publicó un evento</h3>
                        <div class="timeline-body">
                        <?php echo $lista['eventotext']; ?>
                        </div>
                        <?php
                        if($creador == $_SESSION['nombre']){ 
                        ?>
                        <div class="timeline-footer">
                            <!--
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat">Modificar</button>
                            <div class="modal fade bd-example-modal-xl" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Editar evento</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                        <label for="eventotextchanger" class="col-form-label">Modificar evento</label>
                                            <textarea class="form-control" id="message-text" maxlenght="200" placeholder="<?php echo $lista['eventotext'];?>" id="eventotextchanger" name="eventotextchanger"></textarea>
                                        </div>
                                        <p class="col-form-label">¿Es prioritario?</p>
                                        <div class="form-group">
                                            <label for="eventopriorityno" class="col-form-label">No</label>
                                            <input type="radio" class="form-check-input" id="eventopriorityno" name="eventoprioritychanger" value="0">
                                        </div>
                                        <div class="form-group">
                                            <label for="eventopriorityyes" class="col-form-label">Sí</label>
                                            <input type="radio" class="form-check-input" id="eventopriorityyes" name="eventoprioritychanger" value="1">
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="eventochanger">Modificar</button>
                                        <?php
                                        //if(isset($_POST['eventochanger'])){
                                            //$eventotextup = $_POST['eventotextchanger'];
                                            //$eventopriorityup = empty($_POST['eventoprioritychanger']) ? NULL : $_POST['eventoprioritychanger'];
                                            //if($eventotextup != ''){
                                                //$sqlup = mysqli_query($connect, "UPDATE eventos SET eventotext = '$eventotextup', eventopriority = '$eventopriorityup' WHERE evento = '".$lista['evento']."'");
                                                //if($sqlup){
                                                //echo '<script type="text/javascript">';
                                                //echo 'window.location.href = \'eventos.php?id='.$_SESSION['id'].'\';';
                                                //echo '</script>';
                                            //}else{
                                                //echo "<script type='text/javascript'>";
                                                //echo "toastr.error('Ocurrió un error, intentá de nuevo.')";
                                                //echo "</script>";
                                            //}
                                            //}else{
                                            //echo "<script type='text/javascript'>";
                                            //echo "toastr.error('Revisá si hay algún campo vacío e intentá de nuevo.')";
                                            //echo "</script>";
                                            //}
                                        //}
                                        ?>
                                    </form>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
                                    </div>
                                </div>
                                </div>
                            </div>--> 
                            <a class="btn btn-danger btn-sm" onclick="cargarData(<?php echo $evento; ?>);">Eliminar</a>
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script type="text/javascript">
                                function cargarData(id) {
                                    var url="deleteevento.php";
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
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    <!-- END timeline item -->
            </div>
            <!-- /.col -->
            <div class="col-md-12">
                <div class="card card-danger collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">Agregar un evento</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <textarea class="form-control" rows="3" name="eventotext" placeholder="Describir evento..."></textarea>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="eventopriority" name="eventopriority" value="1">
                                <label class="form-check-label" for="eventopriority">Prioritario</label>
                            </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" name="eventoadder">Agregar</button>
                            </div>
                            <?php
                                      if(isset($_POST['eventoadder'])){
                                        $eventocreador = $_SESSION['nombre'];
                                        $eventotext = $_POST['eventotext'];
                                        $eventopriority = empty($_POST['eventopriority']) ? NULL : $_POST['eventopriority'];
                                        if($eventotext != ''){
                                            $sql = mysqli_query($connect, "INSERT INTO eventos(eventocreador, eventotext, eventodate, eventopriority) VALUES('$eventocreador','$eventotext', now(), '$eventopriority')");
                                            if($sql){
                                            echo '<script type="text/javascript">';
                                            echo 'window.location.href = \'eventos.php?id='.$_SESSION['id'].'\';';
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
                </div>
            </div>
        </div>
        </section>
        <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
include_once 'templates/footeradm.php';
?>