<div id="grid">
  <ul>
    <?php foreach( $recursos as $r ):
      $archivo = preg_match( "/image/i", $r['TIPO_MIME'] ) ? $r['URL'] : "_default.png" ;
      ?>
      <li style='background-image: url("/storage/<?php echo $archivo; ?>")' data-file='<?php echo $r['URL']; ?>'   data-name='<?php echo $r['NOMBRE']; ?>' data-folder="<?php echo $r['ES_DIRECTORIO']; ?>">
        <div>
          <span><?php echo $r['NOMBRE'].' - XXXXX - '. $r['ELIMINADO']; ?></span>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
</div>