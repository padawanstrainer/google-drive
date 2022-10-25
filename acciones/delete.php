<?php 
if( $_SERVER['REQUEST_METHOD'] != 'POST' ){
  die( header("Location: /" ) );
} 

include( "../config/setup.php");

$folder = $_POST['folder'];
$files = json_decode( $_POST['items'] );
$preguntitas = [];
$reemplazos = [ ];

$reemplazos[] = $folder == 'papelera' ? 2 : 1;
$reemplazos[] = $_SESSION['ID'];

foreach( $files as $f ){
  $preguntitas[] = '?';
  $reemplazos[] = $f;
}
$signos = implode(', ', $preguntitas );

$consulta = "UPDATE recursos SET ELIMINADO=? WHERE FKUSUARIO=? AND URL IN( $signos )";

$stmt= $conexion->prepare($consulta);
$stmt->execute( $reemplazos );

echo json_encode( [ 'status' => 'ok' ] );