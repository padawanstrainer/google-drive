<?php 
define( 'DS', DIRECTORY_SEPARATOR );
define( 'ROOT', dirname( __DIR__ ) );
define( 'CONFIG', ROOT . DS . 'config' );

define( 'DEFAULT_ORDER_BY', 1 ); //esto ordena por NOMBRE ASC

require CONFIG . DS . 'funciones.php';

$limite_storage = 15; //siempre en megas...

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
$consulta_size = "SELECT SUM(TAMANIO) AS TOTAL FROM recursos WHERE FKUSUARIO=? AND ELIMINADO != 2"; /* 0 es mostrar en la grilla, así que cuenta... 1 es papelera, qe todavía ocupa espacio en disco... 2 borrado definitivo */
$stmt= $conexion->prepare($consulta_size);
$stmt->execute([$uid]);
$size = $stmt->fetch(PDO::FETCH_ASSOC);
$total_megas = round($size['TOTAL'] / 1024 / 1024,2);



