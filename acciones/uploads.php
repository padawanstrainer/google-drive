<?php 
if( $_SERVER['REQUEST_METHOD'] != 'POST' ){
  die( header("Location: /" ) );
} 
include( "../config/setup.php");

$id = $_SESSION['ID'];
$name = $_FILES['archivo']['name'];
$lastM = round( $_POST['lastM'] / 1000 );
$fecha_modificado = date( "Y-m-d H:i:s", $lastM ); 
$ext = pathinfo($name, PATHINFO_EXTENSION);
$url = $id.'_'.uniqid( ).'.'.$ext; 
$upload_size = $_FILES['archivo']['size'];

$megas = ( $upload_size + $size['TOTAL'] ) / 1024 / 1024;
if( $megas > $limite_storage ){
  echo json_encode( ['status' => false, 'message' => 'Storage superado' ] );
  die( );
}

$tmp_name = $_FILES['archivo']['tmp_name'];
$type = $_FILES['archivo']['type'];
$consulta = "INSERT INTO recursos SET NOMBRE=?, URL=?, TAMANIO=?, FECHA_ALTA=NOW(),TIPO_MIME=?,FKUSUARIO=?,ES_DIRECTORIO='0', FECHA_MODIFICADO=?, VISIBILIDAD='privado'";
$stmt= $conexion->prepare($consulta);
$stmt->execute([$name, $url, $upload_size, $type, $id, $fecha_modificado]);

move_uploaded_file($tmp_name, "../storage/$url");
echo json_encode( ['status' => true ] );