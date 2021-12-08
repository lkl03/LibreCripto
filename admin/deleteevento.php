<?php
include 'php/connect.php';	

$id=$_POST["id"];
mysqli_query($connect, "DELETE FROM eventos WHERE evento=$id");
?>