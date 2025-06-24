

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registro Profesional</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <style>
    body, html {
      height: 100%;
    }
    .bg-register {
      background-color: #0dcaf0;
    }
  </style>
</head>
<body>
  <section class="vh-100 overflow-auto">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center">
        <div class="col-lg-10">
          <div class="card shadow-lg border-0 rounded-4">
            <div class="row g-0">
              
              <!-- Formulario -->
              <div class="col-md-6 p-5">
                <div class="mb-4">
                  <i class="fas fa-user-plus fa-2x me-2 text-info"></i>
                  <span class="h2 fw-bold">Registro</span>
                </div>
                <form action="funciones/registro.php" method="POST">
                    <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger py-2 text-center">
                        <?= htmlspecialchars($_GET['error']) ?>
                    </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <input type="text" name="usuario" class="form-control" placeholder="Usuario" required
                                value="<?= htmlspecialchars($_GET['usuario'] ?? '') ?>" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" name="nombre" class="form-control" placeholder="Nombre" required
                                value="<?= htmlspecialchars($_GET['nombre'] ?? '') ?>" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" name="apellido_paterno" class="form-control" placeholder="Apellido paterno" required
                                value="<?= htmlspecialchars($_GET['apellido_paterno'] ?? '') ?>" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" name="apellido_materno" class="form-control" placeholder="Apellido materno"
                                value="<?= htmlspecialchars($_GET['apellido_materno'] ?? '') ?>" />
                        </div>
                        <div class="col-md-6 mb-3">
                          <input type="email" name="correo" class="form-control" placeholder="Correo electrónico" required
                            pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                            title="Debe ser un correo electrónico válido, como ejemplo@dominio.com"
                            value="<?= htmlspecialchars($_GET['correo'] ?? '') ?>" />
                        </div>
                        
                        <div class="col-md-6 mb-3">
                          <input type="text" name="telefono" class="form-control" placeholder="Teléfono"
                            pattern="^\d{10}$"
                            maxlength="10"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            title="Máximo 10 dígitos numéricos"
                            value="<?= htmlspecialchars($_GET['telefono'] ?? '') ?>" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="date" name="fecha_nacimiento" class="form-control" placeholder="Fecha de nacimiento" required
                              max="<?= date('Y-m-d', strtotime('-1 day')) ?>"
                              value="<?= htmlspecialchars($_GET['fecha_nacimiento'] ?? '') ?>" />
                        </div>
                        <div class="col-md-12 mb-3">
                          <input type="password" name="contrasena" class="form-control" placeholder="Contraseña" required
                            pattern="^(?=.*[a-z])(?=.*[A-Z]).{7,}$"
                            title="Debe contener al menos una mayúscula, una minúscula y mínimo 7 caracteres." />
                        </div>
                        <hr class="my-3">
                        <div class="col-md-12">
                            <h6 class="text-muted mb-3">Dirección</h6>
                        </div>
                        <div class="col-md-8 mb-3">
                            <input type="text" name="calle" class="form-control" placeholder="Calle"
                                value="<?= htmlspecialchars($_GET['calle'] ?? '') ?>" />
                        </div>
                        <div class="col-md-4 mb-3">
                          <input type="text" name="numero" class="form-control" placeholder="Número"
                            inputmode="numeric"
                            pattern="^\d{1,5}$"
                            maxlength="5"
                            title="Solo números (máximo 5 dígitos)"
                            value="<?= htmlspecialchars($_GET['numero'] ?? '') ?>" />
                        </div>

                        <div class="col-md-6 mb-3">
                            <input type="text" name="colonia" class="form-control" placeholder="Colonia"
                                value="<?= htmlspecialchars($_GET['colonia'] ?? '') ?>" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" name="ciudad" class="form-control" placeholder="Ciudad"
                                value="<?= htmlspecialchars($_GET['ciudad'] ?? '') ?>" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" name="estado" class="form-control" placeholder="Estado"
                                value="<?= htmlspecialchars($_GET['estado'] ?? '') ?>" />
                        </div>
                       
                        <div class="col-md-6 mb-3">
                          <input type="text" name="codigo_postal" class="form-control" placeholder="Código Postal"
                            pattern="^\d{5}$"
                            maxlength="5"
                            title="Debe contener exactamente 5 dígitos numéricos"
                            value="<?= htmlspecialchars($_GET['codigo_postal'] ?? '') ?>" />
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info w-100 mt-3">Registrarse</button>
                    <div class="text-center mt-3">
                        ¿Ya tienes una cuenta? <a href="login.php" class="link-info">Inicia sesión</a>
                    </div>
                </form>

              </div>

              <!-- Imagen / Lado derecho -->
              <div class="col-md-6 bg-register text-white d-flex flex-column align-items-center justify-content-center rounded-end">
                <i class="fas fa-user-circle fa-6x mb-4"></i>
                <h2 class="fw-bold">Bienvenido</h2>
                <p class="lead text-center px-5">Completa tu registro para empezar a disfrutar de nuestros servicios</p>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script>
  document.addEventListener("DOMContentLoaded", () => {
    const soloNumeros = (input) => {
      input.addEventListener("input", () => {
        input.value = input.value.replace(/\D/g, ""); // Elimina cualquier caracter no numérico
      });
    };

    soloNumeros(document.querySelector('input[name="telefono"]'));
        soloNumeros(document.querySelector('input[name="numero"]'));
    soloNumeros(document.querySelector('input[name="codigo_postal"]'));
  });
</script>
</body>
</html>
