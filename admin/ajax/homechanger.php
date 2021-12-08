<?php
include '../php/connect.php';	

$id=$_POST["id"];
mysqli_query($connect, "UPDATE management SET homemensaje = '$id'");
?>