<?php
if( $_SERVER['REQUEST_METHOD'] != 'POST' ){
  die( header("Location: /" ) );
} 
include( "../config/setup.php");

$email = $_POST['email'];
$clave = $_POST['clave'];

$consulta = "INSERT INTO usuarios SET EMAIL=?, PASSWORD=SHA1(?), FECHA_ALTA=NOW( )";
$stmt= $conexion->prepare($consulta);
$stmt->execute([$email, $clave]);

header("Location: /");