<?php
session_start();
require_once 'php/conexionverify.php';
?>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
</head>
<?php 
$title = "Chat | LibreCripto";
include 'php/conexion_be.php';	
$user = filter_var($_GET['user'], (FILTER_SANITIZE_NUMBER_INT));
$myuser = mysqli_query($conexion, "SELECT * FROM usuarios WHERE user = '".mysqli_real_escape_string($conexion, $user)."' ");
$use = mysqli_fetch_array($myuser);
if($_SESSION['user'] == $user){
    echo "<script> window.location='https://librecripto.com/mychats?user=".mysqli_real_escape_string($conexion, $user)."'; </script>";
    exit();
}
if(!isset($_SESSION['user'])){
    include_once 'includes/templates/headeraccess.php';
    echo '<script type="text/javascript">';
    echo 'setTimeout(function () {';
    echo 'swal("Ups!","Debes iniciar sesión para estar aquí.","warning").then( function(val) {';
    echo 'if (val == true) window.location.href = \'https://librecripto.com/acceso\';';
    echo '});';
    echo '}, 200);  </script>';
    session_destroy();
    die();
}else{
    include_once 'includes/templates/headerlogged.php';
}

?>
<main>
        <?php
        include 'php/conexion_be.php';
          $user_id = mysqli_real_escape_string($conexion, $_GET['user']);
          $sql = mysqli_query($conexion, "SELECT * FROM usuarios WHERE user = '".mysqli_real_escape_string($conexion, $user_id)."'");
          if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
          }else{
    echo "<script> window.location='https://librecripto.com/mychats?user=".mysqli_real_escape_string($conexion, $user)."'; </script>";
          }
$incoming_id = mysqli_real_escape_string($conexion, $row['user']);
          $opsearch = "SELECT * FROM messages WHERE (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$user})";
          $excopsearch = mysqli_query($conexion, $opsearch);
          if(mysqli_num_rows($excopsearch) > 1){
              echo "<p class='opadviser'>¿Tenes una operación con este usuario?</p>";
              echo "<a href='https://librecripto.com/myoperations?user='".mysqli_real_escape_string($conexion, $user)."' class='opgotobutton'>Ir a confirmar operación</a>";
          }
        ?>
  <div class="chat-wrapper">
    <section class="chat-area">
      <header>

        <a href="https://librecripto.com/mychats?user=<?php echo filter_var($_SESSION['user'] , FILTER_SANITIZE_NUMBER_INT);?>" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <a href="https://librecripto.com/userprofile?user=<?php echo filter_var($row['user'] , FILTER_SANITIZE_NUMBER_INT);?>"><img src="img/profilepics/<?php echo filter_var($row['avatar'] , FILTER_SANITIZE_STRING);?>" alt="avatar_usuario"></a>
        <div class="details">
          <span>@<?php echo filter_var($row['usuario'] , FILTER_SANITIZE_STRING);?></span>
          <p><?php echo filter_var($row['status'] , FILTER_SANITIZE_STRING); ?></p>
        </div>
      </header>
      <div class="chat-box">

      </div>
      <form action="#" class="typing-area">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo filter_var($user_id , FILTER_SANITIZE_NUMBER_INT); ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Enviar mensaje a @<?php echo filter_var($row['usuario'] , FILTER_SANITIZE_STRING);?>" autocomplete="off">
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

  <script src="js/chat.js"></script>

</main>
<?php include_once 'includes/templates/footernone.php'; ?>