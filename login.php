<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Profesional</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <style>
    body, html {
      height: 100%;
    }
    .bg-login {
      background-color: #0dcaf0;
    }
  </style>
</head>
<body>
  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-10">
          <div class="card shadow-lg border-0 rounded-4">
            <div class="row g-0">
              
              <!-- Formulario de login -->
              <div class="col-md-6 p-5">
                <div class="mb-4">
                  <i class="fas fa-user-shield fa-2x me-2 text-info"></i>
                  <span class="h1 fw-bold">Mediaux</span>
                </div>
                <h3 class="mb-4">Iniciar sesión</h3>
                <form action="funciones/login.php" method="POST">
                <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger py-2 text-center">
                    <?= htmlspecialchars($_GET['error']) ?>
                </div>
                <?php endif; ?>

                <div class="form-floating mb-3">
                    <input
                    type="text"
                    name="usuario_o_correo"
                    class="form-control"
                    id="usuario_o_correo"
                    placeholder="Usuario o correo"
                    required
                    value="<?= isset($_GET['usuario_o_correo']) ? htmlspecialchars($_GET['usuario_o_correo']) : '' ?>"
                    />
                    <label for="usuario_o_correo">Usuario o correo</label>
                </div>
                <div class="form-floating mb-4">
                    <input type="password" name="contrasena" class="form-control" id="password" placeholder="Contraseña" required />
                    <label for="password">Contraseña</label>
                </div>
                <button type="submit" class="btn btn-info w-100 mb-3">Ingresar</button>
                <div class="text-end mb-3">
                    <a href="#" class="text-muted small">¿Olvidaste tu contraseña?</a>
                </div>
                <div class="text-center">
                    <span class="small">¿No tienes cuenta? <a href="registro.php" class="link-info">Regístrate aquí</a></span>
                </div>
                </form>

              </div>
 
              <!-- Imagen o texto decorativo -->
              <div class="col-md-6 bg-login text-white d-flex flex-column align-items-center justify-content-center rounded-end">
                <i class="fas fa-lock fa-6x mb-4"></i>
                <h2 class="fw-bold">Bienvenido</h2>
                <p class="lead text-center px-5">Accede a tu panel de control de forma segura y rápida</p>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
