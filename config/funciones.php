<?php 
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
  $es_papelera = false;

  $consulta = "SELECT r.*, IF( u.ID = $id, 'Yo', IFNULL( CONCAT( u.NOMBRE, ' ' , u.APELLIDO ), SUBSTRING_INDEX( EMAIL, '@', 1 ) ) ) AS USUARIO FROM recursos AS r JOIN usuarios AS u ON u.ID = r.FKUSUARIO WHERE FKUSUARIO=? ";

  if( isset($avanzados['folder']) && !empty($avanzados['folder']) ){
    if( $avanzados['folder'] == 'papelera' ){
      $es_papelera = true;
      $consulta .= " AND ELIMINADO = '1' ";
    }else{
      $consulta.= " AND FKPARENT = (SELECT ID FROM recursos WHERE URL = ? )";
      $values[] = $avanzados['folder'];
    }
  }else{
    $consulta.= " AND FKPARENT IS NULL ";
  }


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
  }else if( ! $es_papelera ){
    $consulta .= " AND ELIMINADO = '0' ";
  }

  $consulta .= " ORDER BY ES_DIRECTORIO DESC, $orderby";
  $stmt= $conexion->prepare($consulta);
  $stmt->execute($values);

  while( $r = $stmt->fetch(PDO::FETCH_ASSOC) ){
    $recursos[] = $r;
  }
  return $recursos;
}

function getFolderChildren( $id ){
  global $conexion;
  $consulta = "SELECT ID, NOMBRE, URL, FKPARENT FROM recursos WHERE FKUSUARIO = ? AND ES_DIRECTORIO = 1 AND ELIMINADO = 0 AND FKPARENT= ? ORDER BY NOMBRE";
  $stmt = $conexion->prepare($consulta);
  $stmt->execute([ $_SESSION['ID'], $id ]);

  $listado = [];
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC) ){
    $id = $r['ID'];
    $r['HIJOS'] = getFolderChildren( $id );
    $listado[$id] = $r;  
  }
  return $listado;
}

function getFolderList( ){
  global $conexion;
  $consulta = "SELECT ID, NOMBRE, URL, FKPARENT FROM recursos WHERE FKUSUARIO = ? AND ES_DIRECTORIO = 1 AND ELIMINADO = 0 AND FKPARENT IS NULL ORDER BY NOMBRE";
  $stmt = $conexion->prepare($consulta);
  $stmt->execute([ $_SESSION['ID'] ]);
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC) ){
    $id = $r['ID'];
    $r['HIJOS'] = getFolderChildren( $id );
    $directorios[$id] = $r;
  }

  return $directorios;
}


//$path es una ruta adentro de los recursos del zip
function addFolderToZip( $zip, $url, $path ){
  global $conexion;

  $idUsuario = $_SESSION['ID'] ?? 0;
  $consulta = "SELECT NOMBRE, URL, ES_DIRECTORIO FROM recursos WHERE ELIMINADO='0' AND FKPARENT=(SELECT ID FROM recursos WHERE URL = ? ) AND FKUSUARIO= ?";
  $stmt = $conexion->prepare($consulta);
  $stmt->execute([ $url, $idUsuario ]);
  foreach( $stmt->fetchAll(PDO::FETCH_ASSOC) as $a ){
    if( $a['ES_DIRECTORIO'] == 1 ){
        //si es true es una sub-sub-sub-sub-carpeta
        addFolderToZip( $zip, $a['URL'], $path.$a['NOMBRE'].'/' );
    }else{
      $zip->addFile( dirname(__DIR__). "/storage/$a[URL]", $path . $a['NOMBRE'] );
    }
  }
}