<?php
include_once 'connect.php';
include_once '../../php/conexion_be.php';

$sql = "SELECT fecha_reg, COUNT(*) AS resultado FROM usuarios GROUP BY DATE(fecha_reg) ORDER BY fecha_reg";
$resultado = mysqli_query($conexion, $sql);

$arreglo_registros = array();
while ($registro_dia = mysqli_fetch_assoc($resultado)){
    $fecha = $registro_dia['fecha_reg'];
    $registro['fecha'] = date('Y-m-d', strtotime($fecha));
    $registro['cantidad'] = $registro_dia['resultado'];

    $arreglo_registros[] = $registro;
}

echo json_encode($arreglo_registros);

?>
