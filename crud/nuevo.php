<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Nuevo Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <style>
    body, html {
      height: 100%;
      background-color: #f8f9fa;
    }
    .bg-form {
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
              <div class="col-md-6 p-5">
                <div class="mb-4">
                  <i class="fas fa-user-plus fa-2x me-2 text-info"></i>
                  <span class="h2 fw-bold">Nuevo Usuario</span>
                </div>

                <form action="crear.php" method="POST" autocomplete="off">
                  <div class="row">
                    <div class="col-md-12 mb-3">
                      <input type="text" name="usuario" class="form-control" placeholder="Usuario" required />
                    </div>
                    <div class="col-md-6 mb-3">
                      <input type="text" name="nombre" class="form-control" placeholder="Nombre" required />
                    </div>
                    <div class="col-md-6 mb-3">
                      <input type="text" name="apellido_paterno" class="form-control" placeholder="Apellido paterno" required />
                    </div>
                    <div class="col-md-6 mb-3">
                      <input type="text" name="apellido_materno" class="form-control" placeholder="Apellido materno" />
                    </div>
                    <div class="col-md-6 mb-3">
                      <input type="email" name="correo" class="form-control" placeholder="Correo electrónico" required />
                    </div>
                    <div class="col-md-6 mb-3">
                      <input type="tel" name="telefono" class="form-control" placeholder="Teléfono" />
                    </div>
                    <div class="col-md-6 mb-3">
                      <input type="date" name="fecha_nacimiento" class="form-control" placeholder="Fecha de nacimiento" required />
                    </div>
                    <div class="col-md-12 mb-3">
                      <input type="password" name="contrasena" class="form-control" placeholder="Contraseña" required />
                    </div>

                    <hr class="my-3" />

                    <div class="col-md-12">
                      <h6 class="text-muted mb-3">Dirección</h6>
                    </div>

                    <div class="col-md-8 mb-3">
                      <input type="text" name="calle" class="form-control" placeholder="Calle" />
                    </div>
                    <div class="col-md-4 mb-3">
                      <input type="text" name="numero" class="form-control" placeholder="Número" />
                    </div>
                    <div class="col-md-6 mb-3">
                      <input type="text" name="colonia" class="form-control" placeholder="Colonia" />
                    </div>
                    <div class="col-md-6 mb-3">
                      <input type="text" name="ciudad" class="form-control" placeholder="Ciudad" />
                    </div>
                    <div class="col-md-6 mb-3">
                      <input type="text" name="estado" class="form-control" placeholder="Estado" />
                    </div>
                    <div class="col-md-6 mb-3">
                      <input type="text" name="codigo_postal" class="form-control" placeholder="Código Postal" />
                    </div>

                    <div class="col-md-6 mb-3">
                      <label for="rol" class="form-label">Rol del usuario</label>
                      <select name="rol" id="rol" class="form-select" required>
                        <option value="usuario" selected>Usuario</option>
                        <option value="admin">Administrador</option>
                      </select>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-info w-100 mt-3">
                    <i class="fas fa-user-plus"></i> Crear Usuario
                  </button>
                </form>
              </div>

              <div class="col-md-6 bg-form text-white d-flex flex-column align-items-center justify-content-center rounded-end">
                <i class="fas fa-user-circle fa-6x mb-4"></i>
                <h2 class="fw-bold">Nuevo Usuario</h2>
                <p class="lead text-center px-5">Llena el formulario para registrar un nuevo usuario con toda su información.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
