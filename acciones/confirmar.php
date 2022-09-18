<?php 
include('../config/setup.php');
if(
   !isset($_GET['sal'] ) ||
   !isset($_GET['pimienta'] )
 ){
  $_SESSION['error'] = "Parámetros invalidos";
  die( header("Location: /recuperar") ) ;
}

$er = "[a-f0-9]{32}";
if(
  !preg_match("/$er/", $_GET['sal'] ) ||
  !preg_match("/$er/", $_GET['pimienta'] )
){
 $_SESSION['error'] = "Parámetros invalidos";
 die( header("Location: /recuperar") ) ;
}

$token = $_GET['sal'];
$email_hasheado = $_GET['pimienta'];

$consulta = "SELECT * FROM recuperar WHERE MD5(EMAIL)=?";
$stmt= $conexion->prepare($consulta);
$stmt->execute([$email_hasheado]);
$datos = $stmt->fetch(PDO::FETCH_ASSOC);
if( ! $datos ){
  $_SESSION['error'] = "No hay solicitudes pendientes para este email";
  die( header("Location: /recuperar") ) ;
}


$email = $datos['EMAIL'];
$clave_nueva = $datos['NUEVA_CLAVE'];
$fecha_alta = $datos['FECHA_ALTA'];

$retoken = md5(strrev(sha1("$email $clave_nueva $fecha_alta")));
if( $retoken != $token ){
  $_SESSION['error'] = "Token inválido.";
  die( header("Location: /recuperar") ) ;
}

$update = "UPDATE usuarios SET PASSWORD=SHA1(?) WHERE EMAIL=?";
$stmt= $conexion->prepare($update);
$stmt->execute([$clave_nueva, $email]);


$delete = "DELETE FROM recuperar WHERE EMAIL=?";
$stmt= $conexion->prepare($delete);
$stmt->execute([$email]);

$_SESSION['ok'] = "Ya podés entrar con tu clave nueva";
header("Location: /");