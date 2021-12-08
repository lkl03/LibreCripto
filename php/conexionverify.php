<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/usersidebar.css">
</head>
<?php
require 'Carbon/autoload.php';
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonInterface;

include_once 'conexion_be.php';

$id = $_SESSION['id'];
$lastsession = $_SESSION['lastsession'];
$now = Carbon::now(new DateTimeZone('America/Argentina/Buenos_Aires'));
$lastsessiondate = Carbon::create($lastsession, 'America/Argentina/Buenos_Aires');
$lastsessiondate->locale('es');
$diff = $lastsessiondate->diffInMinutes($now, CarbonInterface::DIFF_RELATIVE_TO_NOW);
$limit = 45;
if($diff > $limit){
$upd = mysqli_query($conexion, "UPDATE usuarios SET status = 'Offline' WHERE id=$id");
if($upd){
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () {';
        echo 'swal("Ups!","Debes iniciar sesión para estar aquí.","warning").then( function(val) {';
        echo 'if (val == true) window.location.href = \'acceso\';';
        echo '});';
        echo '}, 200);  </script>';
        session_destroy();
}
}
?>