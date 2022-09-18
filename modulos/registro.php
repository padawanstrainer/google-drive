<form method="post" action="/post-registro" class='form'>
  <h2>Registro</h2>

  <div>
    <label for="email">Email</label>
    <input type="email" name="email" id="email" required autocomplete="off" />
  </div>

  <div>
    <label for="clave">Clave</label>
    <input type="password" name="clave" required />
  </div>

  <div class='buttons'>
    <button type="submit">Registrar</button>
  </div>

  <p class='foot-note'>¿Ya estas registrado? Accedé <a href='/'>desde acá</a></p>
</form>