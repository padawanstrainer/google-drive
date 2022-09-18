<?php
if( $_SERVER['REQUEST_METHOD'] != 'POST' ){
  die( header("Location: /" ) );
} 
include( "../config/setup.php");
$id = $_SESSION['ID'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$clave = trim($_POST['clave']);

$_SESSION['NOMBRE'] = $nombre;
$_SESSION['APELLIDO'] = $apellido;
$_SESSION['EMAIL'] = $email;

$valores = [ $nombre, $apellido, $email ];
$consulta = "UPDATE usuarios SET NOMBRE=?, APELLIDO=?, EMAIL=?";
if( !empty($clave) ){
  $consulta.= ", PASSWORD=SHA1(?)"; 
  $valores[] = $clave;
}
if( $_FILES['avatar']['size'] > 0 ){
  $extension = pathinfo( $_FILES['avatar']['name'], PATHINFO_EXTENSION );
  $nombre_foto = $id.'_'.uniqid().'.'.$extension;

  $consulta.= ", AVATAR=?"; 
  $valores[] = $nombre_foto;
  $_SESSION['AVATAR'] = $nombre_foto;
  move_uploaded_file( $_FILES['avatar']['tmp_name'] , "../users/$nombre_foto" );

  //TODO: REDIMENSIONAR LAS FOTOS CON GD...
}
$consulta.= " WHERE ID=?";
$valores[] = $id;

$stmt= $conexion->prepare($consulta);
$stmt->execute($valores);

header("Location: /");