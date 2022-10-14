<?php 
if( ! $_SERVER['REQUEST_METHOD'] == 'POST' ){
  echo json_encode([ 'status' => false, 'message' => 'Error en la petición' ]);
  die( );
}

if( ! isset($_POST['archivos'] ) ){
  echo json_encode([ 'status' => false, 'message' => 'No se han recibido archivos' ]);
  die( );
}

if( count($_POST['archivos'] ) == 0 ){
  echo json_encode([ 'status' => false, 'message' => 'No se han recibido archivos' ]);
  die( );
}

require '../config/setup.php';
$idUsuario = $_SESSION['ID'];

$parametros = [];
$reemplazos = [];

$consulta = "SELECT URL, NOMBRE, ES_DIRECTORIO FROM recursos WHERE URL IN ( ";
foreach($_POST['archivos'] as $file ){
  $parametros[] = '?';
  $reemplazos[] = $file;
}
$consulta.= implode( ",", $parametros );

$consulta .= " ) AND FKUSUARIO=?";
$reemplazos[] =  $idUsuario;


$stmt = $conexion->prepare( $consulta );
$stmt->execute($reemplazos);


$download_name = "zip-".date('Ymd_His').'.zip';

//acá creamos el zip
$zip = new ZipArchive;
$respuesta = $zip->open( $download_name, ZipArchive::CREATE );
//$files = [];

if($respuesta){
  foreach( $stmt->fetchAll(PDO::FETCH_ASSOC) as $f ){
    if( $f['ES_DIRECTORIO'] == 1 ){
      //aca tengo que revisar el directorio.....
      $zip->addEmptyDir($f['NOMBRE']);
      addFolderToZip($zip, $f['URL'], $f['NOMBRE'].'/' );
    }else{
      $zip->addFile( dirname(__DIR__). "/storage/$f[URL]", $f['NOMBRE'] );
    }
  }

  $zip->close();
}

header("Content-type: application/zip");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: 0");
header("Content-Disposition: attachment; filename=$download_name");
readfile("$download_name");
unlink($download_name);