<?php 
include('../config/setup.php' );
$orden = $_POST['orden'] ?? 1;
$filtros = json_decode( $_POST['filtros'] ?? '[]' , true );
$parametro = null;
if( isset($filtros['buscador'] ) ){
  $parametro = $filtros['buscador'];
  unset( $filtros['buscador'] );
}
$recursos = getDirectory( $orden, $parametro, $filtros );

$formato = $_POST['formato'];
$file = $formato == 'grilla' ? 'ver_grilla.php' : 'ver_tabla.php';

include("../modulos/$file");