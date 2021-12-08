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
    
    if(isset($_SESSION['correo'])){
        $id = filter_var($_SESSION['id'] , FILTER_SANITIZE_NUMBER_INT);
echo "<script> window.location='home.php?id=".mysqli_real_escape_string($connect, $id)."'; </script>";
    }

?>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-primary">
    <div class="card-header text-center" style="background-color: #343434;">
      <a href="https://librecripto.com" class="brand-link">
        <img src="https://librecripto.com/img/logo.svg" alt="LibreCripto Logo" class="">
      </a>    
    </div>
    <div class="card-body">
      <p class="login-box-msg">Ingresá tus datos de usuario para acceder a la sección de administración</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Correo Electrónico" name="correo">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Contraseña" name="pass">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" name="loginbutton" class="btn btn-success btn-block">Iniciar Sesión</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <?php
      if(isset($_POST['loginbutton'])){
        include 'php/connect.php';
        $correo = $_POST['correo'];
        $pass = $_POST['pass'];
        $pass = hash('sha512', $pass);
        $status = "Online";
        if($correo != '' && $pass != ''){

          $validar_login = mysqli_query($connect, "SELECT * FROM usuarios WHERE correo='$correo' and pass='$pass'");

          if(mysqli_num_rows($validar_login) > 0){
              while($row=mysqli_fetch_array($validar_login)){
                  if($correo = $row['correo'] && $pass = $row['pass']){
                      $_SESSION['correo'] = $row['correo'];
                      $_SESSION['id'] = $row['id'];
                      $_SESSION['fotoperfil'] = $row['fotoperfil'];
                      $_SESSION['pass'] = $row['pass'];
                      $_SESSION['nombre'] = $row['nombre'];
                      $_SESSION['rol'] = $row['rol'];
                      $_SESSION['nombre'] = $row['nombre'];
                  }
                  $sql2 = mysqli_query($connect, "UPDATE usuarios SET status = '$status' WHERE id='".$row['id']."'");
              }
                      $id = filter_var($_SESSION['id'] , FILTER_SANITIZE_NUMBER_INT);
echo "<script> window.location='home.php?id=".mysqli_real_escape_string($connect, $id)."'; </script>";
          }else{
            echo "<script type='text/javascript'>";
            echo "toastr.error('Los datos de correo o contraseña son incorrectos.')";
            echo "</script>";
          }
        }else{
          echo "<script type='text/javascript'>";
          echo "toastr.error('Ingresá tu correo y contraseña para poder iniciar sesión.')";
          echo "</script>";
        }
      }
      ?>
    </div>
    <!-- /.card-body -->
  </div>
</div>
<!-- /.login-box -->