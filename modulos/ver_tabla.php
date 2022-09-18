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
        <td><span<?php echo $style; ?>><?php echo $r['NOMBRE']; ?></span></td>
        <td><?php echo $r['USUARIO']; ?></td>
        <td><?php echo $r['FECHA_MODIFICADO']; ?></td>
      </tr>
      <?php endforeach; ?>
    <!--
      <tr>
        <td><span class='folder'>Filename</span></td>
        <td>Yo</td>
        <td>12 sept 2022</td>
      </tr>
      <tr>
        <td><span class='rar'>Filename</span></td>
        <td>Yo</td>
        <td>12 sept 2022</td>
      </tr>
      <tr>
        <td><span style='background-image: url("/storage/osito.png")'>Osito</span></td>
        <td>Yo</td>
        <td>12 sept 2022</td>
      </tr>
    -->
    </tbody>
  </table>