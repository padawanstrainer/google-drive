<?php 
if( $_SERVER['REQUEST_METHOD'] != 'POST' ){
  die( header("Location: /" ) );
} 
include( "../config/setup.php");

$email = $_POST['email'];
$clave = $_POST['clave'];

$consulta = "SELECT ID, NOMBRE, APELLIDO, IFNULL( CONCAT( NOMBRE, ' ', APELLIDO ), SUBSTRING_INDEX(EMAIL,'@', 1 )) AS NOMBRE_PARSEADO, EMAIL, IFNULL(AVATAR,'_default.png') AS AVATAR, FECHA_BAJA, MOTIVO_BAJA FROM usuarios WHERE EMAIL=? AND PASSWORD=SHA1(?)";
$stmt= $conexion->prepare($consulta);
$stmt->execute([$email, $clave]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if( ! $user ){
  $_SESSION['error'] = "Mal usuario o clave";
}else{
  if( !empty($user['MOTIVO_BAJA']) ){
    if( $user['MOTIVO_BAJA'] == 'drive' ):
      $_SESSION['error'] = "Cuenta suspendida";
    else:
      $_SESSION['error'] = "Cuenta desactivada";
    endif;
  }else{
    $_SESSION = $user;
  }
}

header("Location: /");