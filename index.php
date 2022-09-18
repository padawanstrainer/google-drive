<?php 
include( 'config/setup.php' );
$parametro = $_POST['buscar'] ?? NULL;
$busqueda =  $_POST ?? [ ];
if( isset( $busqueda['buscar'] ) ) unset( $busqueda['buscar'] );
?><!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/base.css">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" media="screen and (max-width: 500px)" href="assets/css/mobile.css">
  <title>Castor Draib | Free file storage</title>
</head>
<body>
  <header>
    <a href='javascript:void(0)' id="menu-open"></a>
    <h1><a href='/'>Castor<span>Draib</span></a></h1>

    <?php if( IS_LOGGED ): ?>
    <form method="post" action="/buscar" id="form-buscador">
      <input type="text" id="buscador" name="buscar" placeholder="Buscar en Castor Draib" value="<?php echo $parametro; ?>" autocomplete="off" /><a href="javascript:void(0)" class='icon' id="btn-avanzado">Busqueda avanzada</a>
      <div id="form-avanzado">
        <a href='javascript:void(0)' class='icon close' id="cerrar-avanzado"></a>
        <!-- div>
          <span for="propietario">Propietario</span>
          <select id="propietario" name="propietario" onchange="show_owner(this)">
            <option value="any">Cualquier usuario</option>
            <option value="mine">Mios</option>
            <option value="other">De otras personas</option>
            <option value="">Persona especifica</option>
          </select>
          <input type="text" id="owner-user" disabled /> 
        </!-->
        <div>
          <span>Ubicación</span>
          <label>
            <input type="checkbox" name="ubicacion[]" value='mi unidad' id="mi_unidad" checked /> Mi unidad
          </label>
          <label>
            <input type="checkbox" name="ubicacion[]" id="papelera" value="papelera" /> Papelera
          </label>
          <label>
            <input type="checkbox" name="ubicacion[]" id="destacados" value="destacados" /> Destacados
          </label>
        </div>
        <div>
          <span>Fechas</span>
          <label>
            Inicio
            <input type="date" name="date-min" id="date-min" max="<?php echo date( 'Y-m-d' ); ?>" />
          </label>
          <label>
            Fin
            <input type="date" name="date-max" id="date-max" max="<?php echo date( 'Y-m-d' ); ?>" />
          </label>
        </div>
        <div class='buttons'>
          <button type="submit">Buscar</button>
        </div>
      </div>
      <button type="submit">Buscar</button>
    </form>
    <ul>
      <li><a href='#' id="darkmode" class='darkmode icon'>Modo oscuro</a></li>
      <li><a href='#' id="apps" class='apps icon'>Menu Herramientas</a></li>
      <li id="user-config">
          <a href='#'>
            <img src='/users/<?php echo $_SESSION['AVATAR']; ?>' alt='user avatar'>
            <span>Configuración user</span>
          </a>
      </li>
    </ul>
    <?php endif; ?>
  </header>
  <?php if( IS_LOGGED ): 
    switch( $seccion ):
      case 'perfil': include( 'modulos/perfil.php' ); break;
      default: include( 'modulos/file_browser.php' );
    endswitch;
  else: 
    switch( $seccion ):
      case 'registro': include( 'modulos/registro.php' ); break;
      case 'recuperar': include( 'modulos/recuperar.php' ); break;
      default: include( 'modulos/login.php' );
    endswitch;
  endif; ?>
</body>
</html>