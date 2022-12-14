<table>
    <thead>
      <tr>
        <th>Nombre <a href='javascript:void(0)' class='sort' onclick="ordenar(1)">ordenar</a></th>
        <th>Propietario <a href='javascript:void(0)' class='sort' onclick="ordenar(2)">ordenar</a></th>
        <th>Última modificación <a href='javascript:void(0)' class='sort' onclick="ordenar(3)">ordenar</a></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach( $recursos as $r ):
      $style = '';
      if( preg_match("/image/i", $r['TIPO_MIME'] ) ){
        $nombre_archivo = $r['URL'];
        $style = " style='background-image: url(/storage/$nombre_archivo)'";
      }elseif( preg_match("/application/i", $r['TIPO_MIME'] ) ){
        $style = " class='rar'";
      }elseif( $r['ES_DIRECTORIO'] == 1 ){
        $style = " class='folder'";
      }else{
        $style = " style='background-image: url(/storage/_default.png)'";
      }
    ?>
      <tr data-file='<?php echo $r['URL']; ?>' data-name='<?php echo $r['NOMBRE']; ?>' data-folder="<?php echo $r['ES_DIRECTORIO']; ?>">
        <td><span<?php echo $style; ?>>
          <?php //if( $r['ES_DIRECTORIO'] == 1 ) echo "<a href='?folder=$r[ID]'>"; ?>
          <?php echo $r['NOMBRE']; ?>
          <?php //if( $r['ES_DIRECTORIO'] == 1 ) echo "</a>"; ?>
        </span></td>
        <td><?php echo $r['USUARIO']; ?></td>
        <td><?php echo $r['FECHA_MODIFICADO']; ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>