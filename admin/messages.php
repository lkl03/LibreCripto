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
            <h1>Mensajes</h1>
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
                <h3 class="card-title">Mensajes enviados</h3>
              </div>
              <!-- /.card-header -->
              <?php
              include '../php/conexion_be.php';
              $userdbconsult = mysqli_query($conexion, "SELECT * FROM messages ORDER BY msg_id DESC");
              ?>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Message ID</th>
                    <th>Chat ID</th>
                    <th>Incoming MSG ID</th>
                    <th>Outgoing MSG ID</th>
                    <th>Message</th>
                    <th>MSG Date</th>
                    <?php
                    //if($use['rol'] === 'CEO'){
                    ?>
                    <!--<th>Administrar</th>-->
                    <?php
                    //}
                    ?>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  while($lista = mysqli_fetch_array($userdbconsult)){
                  ?>
                  <tr>
                    <td><?php echo $lista['msg_id']; ?></td>
                    <td><?php echo $lista['chatid']; ?></td>
                    <td><?php echo $lista['incoming_msg_id']; ?></td>
                    <td><?php echo $lista['outgoing_msg_id']; ?></td>
                    <td><?php echo $lista['msg']; ?></td>
                    <td><?php echo $lista['msgdate']; ?></td>
                  </tr>
                  <?php
                  }
                  ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Message ID</th>
                    <th>Chat ID</th>
                    <th>Incoming MSG ID</th>
                    <th>Outgoing MSG ID</th>
                    <th>Message</th>
                    <th>MSG Date</th>
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