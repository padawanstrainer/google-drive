<form class='form' action="/post-perfil" method="post" enctype="multipart/form-data">
  <h2>Editar tu perfil</h2>
  <div>
    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" name="nombre" value="<?php echo $_SESSION['NOMBRE']; ?>" autocomplete="off" />
  </div>
  <div>
    <label for="apellido">Apellido</label>
    <input type="text" id="apellido" name="apellido" value="<?php echo $_SESSION['APELLIDO']; ?>" autocomplete="off" />
  </div>
  <div>
    <label for="avatar">Avatar</label>
    <input type="file" id="avatar" name="avatar" accept="image/*" />
  </div>
  <div>
    <label for="email">Email</label>
    <input type="text" id="email" name="email" value="<?php echo $_SESSION['EMAIL']; ?>" autocomplete="off" />
  </div>
  <div>
    <label for="clave">Clave</label>
    <input type="password" id="clave" name="clave" placeholder="****" />
  </div>
  <div class='buttons'>
    <a href='/'>Volver a tu Draib</a>
    <button type="submit">Actualizar</button>
  </div>
</form>