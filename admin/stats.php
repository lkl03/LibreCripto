<?php
session_start();
?>
<head>
  <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
</head>
<?php 
  include_once 'templates/headerstats.php';
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
  <div class="content-wrapper" style="height: auto !important">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Estadísticas</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Usuarios Registrados</h3>

              <div class="card-tools pull-right">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" style="margin: 0px"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body chart-responsive" style="">
              <div class="chart" id="line-chart" style="height: 300px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"><svg height="300" version="1.1" width="560" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="overflow: hidden; position: relative; left: -0.5px;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.3.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><text x="49.546875" y="261" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan></text><path fill="none" stroke="#aaaaaa" d="M62.046875,261H535" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="49.546875" y="202" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">5,000</tspan></text><path fill="none" stroke="#aaaaaa" d="M62.046875,202H535" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="49.546875" y="143" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">10,000</tspan></text><path fill="none" stroke="#aaaaaa" d="M62.046875,143H535" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="49.546875" y="84" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">15,000</tspan></text><path fill="none" stroke="#aaaaaa" d="M62.046875,84H535" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="49.546875" y="25" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">20,000</tspan></text><path fill="none" stroke="#aaaaaa" d="M62.046875,25H535" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="448.224882290401" y="273.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2013</tspan></text><text x="237.89578903402187" y="273.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2012</tspan></text><path fill="none" stroke="#3c8dbc" d="M62.046875,229.5412C75.26427703523694,229.2108,101.6990811057108,231.53245,114.91648314094775,228.2196C128.1338851761847,224.90675000000002,154.56868924665855,204.50514644808743,167.7860912818955,203.0384C180.85982590370594,201.58759644808742,207.00729514732686,219.34895,220.0810297691373,216.5494C233.15476439094775,213.74984999999998,259.30223363456867,183.43358661202186,272.3759682563791,180.642C285.59337029161605,177.81973661202184,312.02817436208994,191.15875,325.2455763973269,194.094C338.46297843256383,197.02925,364.89778250303766,218.06921420765025,378.1151845382746,204.124C391.18891916008505,190.33036420765026,417.336388403706,91.8402361878453,430.41012302551644,83.1386C443.3401902339004,74.5325861878453,469.20032465066834,125.20556758241756,482.1303918590523,134.89339999999999C495.3477938942892,144.79651758241758,521.7825979647631,154.85015,535,161.50240000000002" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><circle cx="62.046875" cy="229.5412" r="4" fill="#3c8dbc" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="114.91648314094775" cy="228.2196" r="4" fill="#3c8dbc" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="167.7860912818955" cy="203.0384" r="4" fill="#3c8dbc" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="220.0810297691373" cy="216.5494" r="4" fill="#3c8dbc" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="272.3759682563791" cy="180.642" r="4" fill="#3c8dbc" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="325.2455763973269" cy="194.094" r="4" fill="#3c8dbc" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="378.1151845382746" cy="204.124" r="4" fill="#3c8dbc" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="430.41012302551644" cy="83.1386" r="4" fill="#3c8dbc" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="482.1303918590523" cy="134.89339999999999" r="4" fill="#3c8dbc" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="535" cy="161.50240000000002" r="4" fill="#3c8dbc" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle></svg><div class="morris-hover morris-default-style" style="left: 229.353px; top: 113px; display: none;"><div class="morris-hover-row-label">2012 Q1</div><div class="morris-hover-point" style="color: #3c8dbc">
  Item 1:
  6,810
</div></div></div>
            </div>
            <!-- /.box-body -->
          </div>
            <!-- row -->
            <div class="row">
                <div class="col-12">
                    <!-- jQuery Knob -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                            <i class="far fa-chart-bar"></i>
                            General
                            </h3>

                            <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" style="margin: 0px">
                                <i class="fas fa-minus"></i>
                            </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                            <?php
                            include_once '../php/conexion_be.php';
                            $allusers = mysqli_query($conexion, "SELECT id FROM usuarios");
                            $allusersrow = mysqli_num_rows($allusers);
                            $onlineusers = mysqli_query($conexion, "SELECT id FROM usuarios WHERE status='Online'");
                            $onlineusersrow = mysqli_num_rows($onlineusers);
                            $allanuncios = mysqli_query($conexion, "SELECT id_pub FROM anuncios");
                            $allanunciosrow = mysqli_num_rows($allanuncios);
                            $allops = mysqli_query($conexion, "SELECT SUM(operations) as total_ops FROM usuarios");
                            $allopsrow = mysqli_fetch_assoc($allops);
                            ?>
                            <div class="col-6 col-md-3 text-center">
                                <div style="display:inline;width:90px;height:90px;"><canvas width="90" height="90"></canvas><input type="text" class="knob" value="<?php echo $allusersrow; ?>" data-min="0" data-max="<?php echo $allusersrow; ?>" data-width="90" data-height="90" data-fgcolor="#3c8dbc" style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background: none; font: bold 18px Arial; text-align: center; color: rgb(60, 141, 188); padding: 0px; appearance: none;"></div>

                                <div class="knob-label">Usuarios registrados</div>
                            </div>
                            <!-- ./col -->
                            <div class="col-6 col-md-3 text-center">
                                <div style="display:inline;width:90px;height:90px;"><canvas width="90" height="90"></canvas><input type="text" class="knob" value="<?php echo $onlineusersrow; ?>" data-min="0" data-max="<?php echo $allusersrow; ?>" data-width="90" data-height="90" data-fgcolor="#f56954" style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background: none; font: bold 18px Arial; text-align: center; color: rgb(245, 105, 84); padding: 0px; appearance: none;"></div>

                                <div class="knob-label">Usuarios online</div>
                            </div>
                            <!-- ./col -->
                            <div class="col-6 col-md-3 text-center">
                                <div style="display:inline;width:90px;height:90px;"><canvas width="90" height="90"></canvas><input type="text" class="knob" value="<?php echo $allanunciosrow; ?>" data-min="0" data-max="<?php echo $allanunciosrow; ?>" data-width="90" data-height="90" data-fgcolor="#00a65a" style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background: none; font: bold 18px Arial; text-align: center; color: rgb(0, 166, 90); padding: 0px; appearance: none;"></div>

                                <div class="knob-label">Anuncios activos</div>
                            </div>
                            <!-- ./col -->
                            <div class="col-6 col-md-3 text-center">
                                <div style="display:inline;width:90px;height:90px;"><canvas width="90" height="90"></canvas><input type="text" class="knob" value="<?php echo $allopsrow['total_ops']; ?>" data-min="0" data-max="<?php echo $allopsrow['total_ops']; ?>" data-width="90" data-height="90" data-fgcolor="#00c0ef" style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background: none; font: bold 18px Arial; text-align: center; color: rgb(0, 192, 239); padding: 0px; appearance: none;"></div>

                                <div class="knob-label">Operaciones concretadas</div>
                            </div>
                            <!-- ./col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="row" style="justify-content: flex-end">
                <div class="col-md-12">
                        <!-- USERS LIST -->
                        <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Últimos registrados</h3>

                            <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" style="margin: 0px">
                                <i class="fas fa-minus"></i>
                            </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0" style="display: block;">
                        <ul class="users-list clearfix">
                        <?php
                        $userdbconsult = mysqli_query($conexion, "SELECT * FROM usuarios ORDER BY id DESC LIMIT 8");
                        while($lista = mysqli_fetch_array($userdbconsult)){
                            $date = $lista['fecha_reg']; 
                            $now = Carbon::now(new DateTimeZone('America/Argentina/Buenos_Aires'));
                            $publishdate = Carbon::create($date, 'America/Argentina/Buenos_Aires');
                            $publishdate->locale('es');
                            $diff = $publishdate->diffForHumans($now, CarbonInterface::DIFF_RELATIVE_TO_NOW);
                        ?>
                        <li>
                            <img src="https://librecripto.com/img/profilepics/<?php echo $lista['avatar']; ?>" style="height: 70.5; width: 70.5;" alt="User Image">
                            <p class="users-list-name">@<?php echo $lista['usuario']; ?></p>
                            <span class="users-list-date"><?php echo $diff; ?></span>
                        </li>
                        <?php
                        }
                        ?>
                        </ul>
                            <!-- /.users-list -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer text-center" style="display: block;">
                            <a href="usuarios.php?id=<?php echo $_SESSION['id'];?>">Ver todos los usuarios</a>
                        </div>
                        <!-- /.card-footer -->
                        </div>
                        <!--/.card -->
                </div>
                <!--<div class="col-md-6">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Distribución de anuncios</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            </div>
                        </div>
                        <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                            <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 423px;" width="423" height="250" class="chartjs-render-monitor"></canvas>
                        </div>
                        /.card-body -->
                    <!--</div>
                </div>-->
                <!--<div class="col-md-6">
                    <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Chats activos</h3>

                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                        </div>-->
                        <!-- /.card-tools -->
                    <!--</div>-->
                    <!-- /.card-header -->
                    <!--<div class="card-body">
                        <div class="inner">
                            <h3>44</h3>
                        </div>
                    </div>-->
                    <!-- /.card-body -->
                    <!--</div>-->
                    <!-- /.card -->
                <!--</div>-->
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box bg-success">
                    <span class="info-box-icon"><i class="fas fa-globe-americas"></i></span>
                    <?php
                    $loc = mysqli_query($conexion, "SELECT provincia, COUNT(provincia) AS total FROM anuncios GROUP BY provincia ORDER BY total DESC");
                    $aloc = mysqli_fetch_assoc($loc);
                    $locmin = mysqli_query($conexion, "SELECT provincia, COUNT(provincia) AS total FROM anuncios GROUP BY provincia ORDER BY total ASC");
                    $alocmin = mysqli_fetch_assoc($locmin);
                    $anuncmax = $aloc['total'];
                    $anuncmin = $alocmin['total'];
                    $diferencia = ($anuncmax) - ($anuncmin);
                    ?>
                    <div class="info-box-content">
                        <span class="info-box-text">Mayor cantidad de anuncios publicados en</span>
                        <span class="info-box-number"><?php echo $aloc['provincia']; ?></span>

                        
                        <span class="progress-description">
                        (<?php echo $anuncmax; ?> anuncios publicados) 
                        </span>
                        <div class="progress">
                        </div>
                        <div class="progress-bar"></div>
                        <span class="progress-description">
                        +<?php echo $diferencia; ?> vs. <?php echo $alocmin['provincia']; ?> (provincia con menos anuncios publicados)
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box bg-info">
                    <span class="info-box-icon"><i class="fas fa-comments"></i></span>
                    <?php
                    $allchats = mysqli_query($conexion, "SELECT chatid FROM chats");
                    $allchatsrow = mysqli_num_rows($allchats);
                    ?>
                    <div class="info-box-content">
                        <span class="info-box-text">Chats activos</span>
                        <span class="info-box-number"><?php echo $allchatsrow; ?></span> 

                        <div class="progress">
                        <div class="progress-bar"></div>
                        </div>
                    </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box bg-warning">
                    <span class="info-box-icon"><i class="fas fa-question"></i></i></span>
                    <?php
                    $allsolct = mysqli_query($connect, "SELECT solicitud FROM criptotop WHERE estado= 'enviada'");
                    $allsolctrow = mysqli_num_rows($allsolct);
                    $allsolsug = mysqli_query($connect, "SELECT contacto FROM contactos WHERE motivo= 'Sugerencias' AND solved= '0'");
                    $allsolsugrow = mysqli_num_rows($allsolsug);
                    $allsolemp = mysqli_query($connect, "SELECT contacto FROM contactos WHERE motivo= 'Empleo' AND solved= '0'");
                    $allsolemprow = mysqli_num_rows($allsolemp);
                    $allsolpus = mysqli_query($connect, "SELECT contacto FROM contactos WHERE motivo= 'Problemas con usuarios' AND solved= '0'");
                    $allsolpusrow = mysqli_num_rows($allsolpus);
                    $allsolpcu = mysqli_query($connect, "SELECT contacto FROM contactos WHERE motivo= 'Problemas con tu cuenta' AND solved= '0'");
                    $allsolpcurow = mysqli_num_rows($allsolpcu);
                    $totalsol = ($allsolctrow) + ($allsolsugrow) + ($allsolemprow) + ($allsolpusrow) + ($allsolpcurow);
                    ?>
                    <div class="info-box-content">
                        <span class="info-box-text">Solicitudes por responder</span>
                        <span class="info-box-number"><?php echo $totalsol; ?></span>

                        <div class="progress">
                        <div class="progress-bar"></div>
                        </div>
                    </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
include_once 'templates/footerstats.php';
?>