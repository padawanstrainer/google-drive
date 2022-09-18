<nav>
    <div class='nav-header'>
      <a href='javascript:void(0)' class='nav-header-close'></a>
      <h2>Main menu</h2>
    </div>
    <ul>
      <li id="new-elements"><a href='#' class='new'>Nuevo</a></li>
      <li class='subitems expanded' onclick="this.classList.toggle('expanded')">
        <a href='#' class='my-drive selected'>Mi unidad</a>
        <ul>
          <li class='subitems expanded' style="--data-level: 1">
            <a href='#' class='folder'>Carpeta 1</a>
            <ul>
              <li class='subitems expanded'>
                <a href='#' class='folder' style="--data-level: 2">SubCarpeta 1</a>
                <ul>
                  <li>
                    <a href='#' class='folder' style="--data-level: 3">SubSubCarpeta 1</a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li><a href='#' class='folder'>Carpeta 2</a></li>
        </ul>
      </li>
      <li><a href='#' class='shared'>Compartidos conmigo</a></li>
      <li><a href='#' class='recent'>Recientes</a></li>
      <li><a href='#' class='stars'>Destacados</a></li>
      <li><a href='#' class='bin'>Papelera</a></li>
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
      <a href='javascript:void(0)' class='icon download'>Download</a>
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
        $recursos = getDirectory(1,$parametro,$busqueda);
        include 'modulos/ver_tabla.php' ;
      ?>
    </section>

  </main>
  <script src="/assets/js/dom.js"></script>
  <script src="/assets/js/funciones.js"></script>
  <script src="/assets/js/app.js"></script>