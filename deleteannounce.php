<?php
include 'php/conexion_be.php';	

$id=$_POST["id"];
mysqli_query($conexion, "DELETE FROM anuncios WHERE id_pub=$id");
?>