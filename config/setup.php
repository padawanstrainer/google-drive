<?php 
$limite_storage = 5; //siempre en megas...

$dsn = 'mysql:dbname=twitch_drive;host=localhost';
$usuario = 'root';
$clave = '';
try{
  $conexion = new PDO( $dsn, $usuario, $clave, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]  );
}catch(PDOException $e){
  echo 'Falló la conexión: ' . $e->getMessage();
}

date_default_timezone_set("America/Argentina/Buenos_Aires");

session_start( );
define( 'IS_LOGGED', isset( $_SESSION['ID'] ));
define( 'ENV', 'dev' );

$http = $_SERVER['REQUEST_SCHEME'];
$dominio = $http .'://' . $_SERVER['HTTP_HOST'];


$seccion = $_GET['s'] ?? 'listado';

$uid = $_SESSION['ID'] ?? 0;
$consulta_size = "SELECT SUM(TAMANIO) AS TOTAL FROM recursos WHERE FKUSUARIO=?";
$stmt= $conexion->prepare($consulta_size);
$stmt->execute([$uid]);
$size = $stmt->fetch(PDO::FETCH_ASSOC);
$total_megas = round($size['TOTAL'] / 1024 / 1024,2);



function getDirectory( $order = 1, $parametro = NULL, $avanzados = NULL ){
  global $conexion;
  $id = $_SESSION['ID'];
  if( $order == 3 ){
    $orderby = 'FECHA_MODIFICADO DESC';
  }elseif( $order == 2 ){
    $orderby = 'USUARIO ASC';
  }else{
    $orderby = 'NOMBRE ASC';   
  }

  $recursos = [];
  $values = [];
  $values[] = $id;

  $consulta = "SELECT r.*, IF( u.ID = $id, 'Yo', IFNULL( CONCAT( u.NOMBRE, ' ' , u.APELLIDO ), SUBSTRING_INDEX( EMAIL, '@', 1 ) ) ) AS USUARIO FROM recursos AS r JOIN usuarios AS u ON u.ID = r.FKUSUARIO WHERE FKUSUARIO=? ";

  if( !is_null($parametro) && !empty($parametro)){
    $consulta.= " AND r.NOMBRE LIKE ? ";
    $values[] = "%$parametro%";
  }

  if( isset($avanzados['date-max'] ) && ! empty($avanzados['date-max'] ) ){
    $consulta .= " AND FECHA_MODIFICADO <= ?";
    $values[] = $avanzados["date-max"]." 23:59:59";
  }

  if( isset($avanzados['date-min'] ) && ! empty($avanzados['date-min'] )){
    $consulta .= " AND FECHA_MODIFICADO >= ?";
    $values[] = $avanzados["date-min"]." 00:00:00";
  }

  if( isset($_POST['ubicacion'] ) ){
    $consulta .= " AND ( "; 
    $opciones = [];
    if( in_array( 'papelera', $_POST['ubicacion'] ) ){
      $opciones[] = " ELIMINADO = '1' ";
    }
    if( in_array( 'destacados', $_POST['ubicacion'] ) ){
      $opciones[] = " DESTACADO = '1' ";
    }
    if( in_array( 'mi unidad', $_POST['ubicacion'] ) ){
      $opciones[] = " ELIMINADO = '0' ";
    } 
    $consulta .= implode( " OR " , $opciones ); 
    $consulta.= " ) ";
  }

  $consulta .= " ORDER BY ES_DIRECTORIO DESC, $orderby";

  $stmt= $conexion->prepare($consulta);
  $stmt->execute($values);

  while( $r = $stmt->fetch(PDO::FETCH_ASSOC) ){
    $recursos[] = $r;
  }
  return $recursos;
}