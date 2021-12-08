<?php
include 'php/connect.php';
$id = $_SESSION['id'];
$rid = mysqli_query($connect, "SELECT * FROM usuarios WHERE id='$id'");
$arid = mysqli_fetch_array($rid);
$nid = $arid['id'];
?>
  
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="https://librecripto.com" class="brand-link">
      <img src="https://librecripto.com/img/logo.svg" alt="LibreCripto Logo" class="" style="opacity: 1">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="img/<?php echo $arid['fotoperfil'];?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $arid['nombre'];?></a>
          <a href="#" class="d-block"><?php echo $arid['rol'];?></a>
          <a href="#"><i class="fa fa-circle text-success"></i>Online</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-header">MAIN</li>
          <li class="nav-item">
            <a href="home.php?id=<?php echo $_SESSION['id'];?>" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>Home</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="news.php?id=<?php echo $_SESSION['id'];?>" class="nav-link">
              <i class="nav-icon fas fa-newspaper"></i>
              <p>Novedades</p>
            </a>
          </li>
          <li class="nav-header">INFO</li>
          <li class="nav-item">
            <a href="stats.php?id=<?php echo $_SESSION['id'];?>" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Data
              </p>
            </a>
          </li>
          <!--
          <li class="nav-item">
            <a href="../widgets.html" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Widgets
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          -->
          <li class="nav-item">
            <a href="eventos.php?id=<?php echo $_SESSION['id'];?>" class="nav-link">
              <i class="nav-icon fas fa-calendar-check"></i>
              <p>
                Eventos
              </p>
            </a>
          </li>
          <li class="nav-header">ADMINISTRAR</li>
          <?php
          if($arid['rol'] == 'CEO'){
          ?>
          <li class="nav-item">
              <a href="usuariosadmin.php?id=<?php echo $_SESSION['id'];?>" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Usuarios</p>
              </a>
          </li>
          <?php
          }
          ?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Bases de datos
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="usuarios.php?id=<?php echo $_SESSION['id'];?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Usuarios</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="anuncios.php?id=<?php echo $_SESSION['id'];?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Anuncios</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="operaciones.php?id=<?php echo $_SESSION['id'];?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Operaciones</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="chats.php?id=<?php echo $_SESSION['id'];?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Chats</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="messages.php?id=<?php echo $_SESSION['id'];?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Mensajes</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Contacto
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="solicitudes.php?id=<?php echo $_SESSION['id'];?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Solicitudes CriptoTop</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="ayuda.php?id=<?php echo $_SESSION['id'];?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ayuda</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="sugerencias.php?id=<?php echo $_SESSION['id'];?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sugerencias</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="empleo.php?id=<?php echo $_SESSION['id'];?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Empleo</p>
                </a>
              </li>
            </ul>
          </li>
          <!--<li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                Correo
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../mailbox/mailbox.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inbox</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../mailbox/compose.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Compose</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../mailbox/read-mail.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Read</p>
                </a>
              </li>
            </ul>
          </li>-->
          <li class="nav-header">DEVELOPER</li>
          <li class="nav-item">
            <a href="https://adminlte.io/docs/3.1/" class="nav-link">
              <i class="nav-icon fas fa-code-branch"></i>
              <p>GitHub</p>
            </a>
          </li>
          <li class="nav-header">MEDIA</li>
          <li class="nav-item">
            <a href="https://www.facebook.com/libre_cripto" target="_blank" class="nav-link">
              <i class="nav-icon fas fa-thumbs-up"></i>
              <p>Facebook</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="https://twitter.com/libre_cripto" target="_blank" class="nav-link">
              <i class="nav-icon fas fa-hashtag"></i>
              <p>Twitter</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="https://www.instagram.com/libre_cripto/" target="_blank" class="nav-link">
              <i class="nav-icon fas fa-heart"></i>
              <p>Instagram</p>
            </a>
          </li>
          <li class="nav-header">PERSONAL</li>
          <li class="nav-item">
            <a href="profile.php?id=<?php echo $_SESSION['id'];?>" class="nav-link">
              <i class="nav-icon fas fa-user-astronaut"></i>
              <p>Mi Cuenta</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>