<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Asclepio - Registro</title>
  <link rel="stylesheet" href="css/registro.css" />
</head>
<body class="registro-page">
  <div class="header">
    <div class="logo-title">
      <img src="img/logo.png" alt="Logo Asclepio" class="logo">
      <h1>ASCLEPIO</h1>
    </div>
  </div>

  <div class="registro-container">
    <div class="registro-card">
      <form class="formulario" action="funciones/registro.php" method="POST">
        <h2>Registro de Usuario</h2>

        <?php if (isset($_GET['error'])): ?>
        <div class="alerta-error">
          <?= htmlspecialchars($_GET['error']) ?>
        </div>
        <?php endif; ?>

        <div class="seccion">
          <h3>Información Personal</h3>
          <div class="row">
            <div class="col-4">
              <label for="usuario">Usuario</label>
              <input type="text" id="usuario" name="usuario" required value="<?= htmlspecialchars($_GET['usuario'] ?? '') ?>">
            </div>
            <div class="col-4">
              <label for="nombre">Nombre</label>
              <input type="text" id="nombre" name="nombre" required value="<?= htmlspecialchars($_GET['nombre'] ?? '') ?>">
            </div>
            <div class="col-4">
              <label for="apellido_paterno">Apellido paterno</label>
              <input type="text" id="apellido_paterno" name="apellido_paterno" required value="<?= htmlspecialchars($_GET['apellido_paterno'] ?? '') ?>">
            </div>
          </div>
          <div class="row">
            <div class="col-4">
              <label for="apellido_materno">Apellido materno</label>
              <input type="text" id="apellido_materno" name="apellido_materno" value="<?= htmlspecialchars($_GET['apellido_materno'] ?? '') ?>">
            </div>
            <div class="col-4">
              <label for="correo">Correo electrónico</label>
              <input type="email" id="correo" name="correo" required
                pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                title="Debe ser un correo electrónico válido"
                value="<?= htmlspecialchars($_GET['correo'] ?? '') ?>">
            </div>
            <div class="col-4">
              <label for="telefono">Teléfono</label>
              <input type="tel" id="telefono" name="telefono" maxlength="10"
                pattern="^\d{10}$"
                title="Máximo 10 dígitos"
                value="<?= htmlspecialchars($_GET['telefono'] ?? '') ?>">
            </div>
          </div>
          <div class="row">
            <div class="col-4">
              <label for="fecha_nacimiento">Fecha de nacimiento</label>
              <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required
                max="<?= date('Y-m-d', strtotime('-1 day')) ?>"
                value="<?= htmlspecialchars($_GET['fecha_nacimiento'] ?? '') ?>">
            </div>
          </div>
        </div>

        <div class="seccion">
          <h3>Dirección</h3>
          <div class="row">
            <div class="col-8">
              <label for="calle">Calle</label>
              <input type="text" id="calle" name="calle" value="<?= htmlspecialchars($_GET['calle'] ?? '') ?>">
            </div>
            <div class="col-4">
              <label for="numero">Número</label>
              <input type="text" id="numero" name="numero" maxlength="5"
                pattern="^\d{1,5}$"
                title="Máximo 5 dígitos"
                value="<?= htmlspecialchars($_GET['numero'] ?? '') ?>">
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <label for="colonia">Colonia</label>
              <input type="text" id="colonia" name="colonia" value="<?= htmlspecialchars($_GET['colonia'] ?? '') ?>">
            </div>
            <div class="col-6">
              <label for="ciudad">Ciudad</label>
              <input type="text" id="ciudad" name="ciudad" value="<?= htmlspecialchars($_GET['ciudad'] ?? '') ?>">
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <label for="estado">Estado</label>
              <input type="text" id="estado" name="estado" value="<?= htmlspecialchars($_GET['estado'] ?? '') ?>">
            </div>
            <div class="col-6">
              <label for="codigo_postal">Código Postal</label>
              <input type="text" id="codigo_postal" name="codigo_postal" maxlength="5"
                pattern="^\d{5}$"
                title="Exactamente 5 dígitos"
                value="<?= htmlspecialchars($_GET['codigo_postal'] ?? '') ?>">
            </div>
          </div>
        </div>

        <div class="seccion">
          <h3>Contraseña</h3>
          <div class="row">
            <div class="col-6">
              <label for="contrasena">Contraseña</label>
              <input type="password" id="contrasena" name="contrasena" required
                pattern="^(?=.*[a-z])(?=.*[A-Z]).{7,}$"
                title="Debe tener al menos una mayúscula, una minúscula y mínimo 7 caracteres">
            </div>
            <div class="col-6">
              <label for="confirmar">Confirmar Contraseña</label>
              <input type="password" id="confirmar" name="confirmar" required>
            </div>
          </div>
        </div>

        <button type="submit">Registrarse</button>
        <div class="enlace-login">
          ¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const soloNumeros = (input) => {
        input.addEventListener("input", () => {
          input.value = input.value.replace(/\D/g, "");
        });
      };

      soloNumeros(document.querySelector("#telefono"));
      soloNumeros(document.querySelector("#numero"));
      soloNumeros(document.querySelector("#codigo_postal"));
    });
  </script>
</body>
</html>
