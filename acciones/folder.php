<?php 
if( $_SERVER['REQUEST_METHOD'] != 'POST' ){
  die( header("Location: /" ) );
} 
include( "../config/setup.php");

$id = $_SESSION['ID'];
$name = $_POST['carpeta'];
$parent = $_POST['folder'];
$url = uniqid( );
$size = 0;

$consulta = "INSERT INTO recursos SET NOMBRE=?, URL=?, TAMANIO=?, FECHA_ALTA=NOW(),FKUSUARIO=?,ES_DIRECTORIO='1', FKPARENT=NULLIF(?,''), VISIBILIDAD='privado'";
$stmt= $conexion->prepare($consulta);
$stmt->execute([$name, $url, $size,  $id, $parent]);

$redirect = empty($parent) ? "" : "?folder=$parent";
header("Location: /$redirect");