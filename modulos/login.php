<form method="post" action="/post-login" class='form'>
  <h2>Autentificate</h2>
  <?php 
  if( isset($_SESSION['error']) ){
    echo "<p class='error'>$_SESSION[error]</p>";
    unset( $_SESSION['error'] );
  }
  if( isset($_SESSION['ok']) ){
    echo "<p class='ok'>$_SESSION[ok]</p>";
    unset( $_SESSION['ok'] );
  }
  ?>
  <div>
    <label for="email">Email</label>
    <input type="email" name="email" id="email" required autocomplete="off" />
  </div>

  <div>
    <label for="clave">Clave</label>
    <input type="password" name="clave" required />
  </div>

  <div class='buttons'>
    <a href='/registro'>Registrarme</a>
    <button type="submit">Acceder</button>
  </div>

  <p class='foot-note'>¿Olvidaste tu contraseña? Recuperala <a href='/recuperar'>haciendo click acá</a></p>
</form>