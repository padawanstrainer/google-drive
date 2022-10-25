<nav>
    <div class='nav-header'>
      <a href='javascript:void(0)' class='nav-header-close'></a>
      <h2>Main menu</h2>
    </div>
    <ul>
      <li id="new-elements"><a href='#' class='new'>Nuevo</a></li>
      <li class='subitems expanded' onclick="this.classList.toggle('expanded')">
        <a href='/' class='my-drive selected'>Mi unidad</a>
        <ul id="directory-structure">
        </ul>
      </li>
      <li id="shared"><a href='#' class='shared'>Compartidos conmigo</a></li>
      <li><a href='#' class='recent'>Recientes</a></li>
      <li><a href='#' class='stars'>Destacados</a></li>
      <li><a href='/?folder=papelera' class='bin'>Papelera</a></li>
      <li class='divider'>
        <a href='#' class='cloud'>Almacenamiento</a>
        <div>
          <span class='usage' data-width="50"><?php echo $total_megas; ?>Mb de <?php echo $limite_storage; ?>Mb utilizado(s)</span>
          <a href='#' class='buy'>Comprar almacenamiento</a>
        </div>
      </li>
    </ul>
  </nav>

  <main>
    <div class='header-tools'>
      <h2><a href='#'>Carpeta actual</a></h2>
      <a href='javascript:void(0)' class='icon move hidden'>Mover</a>
      <a href='javascript:void(0)' class='icon delete hidden'>Borrar</a>
      <a href='javascript:void(0)' class='icon download hidden'>Download</a>
      <a href='#' class='icon toggle tabla'>Toggle grilla</a>
      <a href='#' class='icon file-info'>File info</a>
    </div>
    <section id="sugeridos">
      <h3>Sugerido</h3>
      <ul>
        <li style='background-image: url("/storage/osito.png")'>
          <div>
            <span>Nombre archivo</span>
            <span>Motivo de muestra</span>
          </div>
        </li>
        <li>
          <div>
            <span>Nombre archivo</span>
            <span>Motivo de muestra</span>
          </div>
        </li>
        <li>
          <div>
            <span>Nombre archivo</span>
            <span>Motivo de muestra</span>
          </div>
        </li>
        <li>
          <div>
            <span>Nombre archivo</span>
            <span>Motivo de muestra</span>
          </div>
        </li>
      </ul>
    </section>

    <section id="files">
      <?php
        if( isset($_GET['folder'] ) ){
          $busqueda['folder'] = $_GET['folder'];
        }
        $recursos = getDirectory(DEFAULT_ORDER_BY,$parametro,$busqueda);
        include 'modulos/ver_tabla.php' ;
      ?>
    </section>

  </main>

  <script>
    const directorios = <?php echo json_encode(getFolderList( ));
    ?>;
  </script>
  <script src="/assets/js/dom.js"></script>
  <script src="/assets/js/funciones.js"></script>
  <script src="/assets/js/keyboard.js"></script>
  <script src="/assets/js/app.js"></script>