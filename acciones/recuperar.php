<?php 
if( $_SERVER['REQUEST_METHOD'] != 'POST' ){
  die( header("Location: /" ) );
} 
include( "../config/setup.php");

$email = $_POST['email'];

$consulta = "SELECT ID, IFNULL(NOMBRE, SUBSTRING_INDEX(EMAIL,'@', 1)) AS NOMBRE, MOTIVO_BAJA FROM usuarios WHERE EMAIL=?";
$stmt= $conexion->prepare($consulta);
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$url  = 'recuperar';
if( ! $user ){
  $_SESSION['error'] = "Usuario inexistente";
}else{
  if( !empty($user['MOTIVO_BAJA']) ){
    if( $user['MOTIVO_BAJA'] == 'drive' ):
      $_SESSION['error'] = "Cuenta suspendida";
    else:
      $_SESSION['error'] = "Cuenta desactivada";
    endif;
  }else{
    $id_user = $user['ID'];
    $nombre = $user['NOMBRE'];

    //estos campos son para la tabla
    $clave_nueva = uniqid();
    $fecha_alta = date('Y-m-d H:i:s');

    //El token es solo para el mail
    $token = md5(strrev(sha1("$email $clave_nueva $fecha_alta")));
    $email_hasheado = md5($email);

    //inserto en la tabla de recuperar claves
    $consulta = "INSERT INTO recuperar VALUES( ?, ?, ?) ON DUPLICATE KEY UPDATE FECHA_ALTA=?, NUEVA_CLAVE=?";
    $stmt= $conexion->prepare($consulta);
    $stmt->execute([$email, $fecha_alta, $clave_nueva, $fecha_alta, $clave_nueva]);

    $uri = $dominio."/post-confirmar?sal=$token&pimienta=$email_hasheado";

    $correo = <<<MAIL
      <h2>Hola, $nombre</h2>
      <p>Te está llegando este correo porque pediste recuperar tu clave en CastorDraib, tu clave nueva es <code>$clave_nueva</code>, pero antes tenes confirmar el cambio, haciendo click en <a href='$uri'>este enlace</a>, o copiando todo el código a continuación en tu navegador: <br />
      <code>$uri</code></p>
MAIL;

    $headers = "MIME-Version: 1.0\r\n";
    $headers.= "Content-type: text/html; charset=utf-8\r\n";   
    $headers.= "To: $nombre <$email>\r\n";
    $headers.= "From: CDraib <mensajes@cdraib.com>\r\n";  
    
    if( ENV == 'prod' ):
      mail( $email, "Recuperar clave de CDraib", $correo, $headers );
    else:
      echo $correo;
    endif;

    //envio de mail...
    $url = '';
    die( );
  }
}

header("Location: /$url");