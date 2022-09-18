<form method="post" action="/post-recuperar" class='form'>
  <h2>Autentificate</h2>
  <?php 
  if( isset($_SESSION['error']) ){
    echo "<p class='error'>$_SESSION[error]</p>";
    unset( $_SESSION['error'] );
  }
  ?>
  <div>
    <label for="email">Email</label>
    <input type="email" name="email" id="email" required autocomplete="off" />
  </div>

  <div class='buttons'>
    <button type="submit">Solicitar clave</button>
  </div>

  <p class='foot-note'>¿Ya estas registrado? Accedé <a href='/'>desde acá</a></p>
</form>