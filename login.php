<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mediaux - Iniciar Sesión</title>
  <link rel="stylesheet" href="css/login.css" />
</head>
<body>
  <div class="header">
    <div class="logo-title">
      <img src="img/logo.png" alt="Logo Mediaux" class="logo">
      <h1>MEDIAUX</h1>
    </div>
  </div>

  <div class="login-container">
    <div class="monster-container">
      <img src="img/idle/1.png" id="monster" alt="logo" />
    </div>

    <div class="login-card">
      <h2>Iniciar Sesión</h2>
      <form class="formulario" method="POST" action="funciones/login.php">
        <?php if (isset($_GET['error'])): ?>
          <div class="error-message">
            <?= htmlspecialchars($_GET['error']) ?>
          </div>
        <?php endif; ?>

        <label for="usuario_o_correo">Usuario o correo</label>
        <input type="text" name="usuario_o_correo" id="usuario_o_correo" placeholder="usuario@correo.com" required
          value="<?= htmlspecialchars($_GET['usuario_o_correo'] ?? '') ?>" />

        <label for="contrasena">Contraseña</label>
        <input type="password" name="contrasena" id="contrasena" placeholder="********" required />

        <button type="submit" class="btn-login">Ingresar</button>

        <div class="enlace-registro">
          <a href="#">¿Olvidaste tu contraseña?</a>
        </div>

        <div class="enlace-registro">
          ¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a>
        </div>
      </form>
    </div>
  </div>

  <script src="js/login.js"></script>
</body>
</html>
