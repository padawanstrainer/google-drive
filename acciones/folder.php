<?php 
if( $_SERVER['REQUEST_METHOD'] != 'POST' ){
  die( header("Location: /" ) );
} 
include( "../config/setup.php");

$id = $_SESSION['ID'];
$name = $_POST['carpeta'];
$url = uniqid( ); 
$size = 0;

$consulta = "INSERT INTO recursos SET NOMBRE=?, URL=?, TAMANIO=?, FECHA_ALTA=NOW(),FKUSUARIO=?,ES_DIRECTORIO='1',VISIBILIDAD='privado'";
$stmt= $conexion->prepare($consulta);
$stmt->execute([$name, $url, $size,  $id]);

header("Location: /");