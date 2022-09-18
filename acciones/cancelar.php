<?php 
include('../config/setup.php');
$id = $_SESSION['ID'];

$consulta = "UPDATE usuarios SET FECHA_BAJA=NOW(), MOTIVO_BAJA='usuario' WHERE ID=?";
$stmt= $conexion->prepare($consulta);
$stmt->execute([$id]);

session_destroy();
header("Location: /");