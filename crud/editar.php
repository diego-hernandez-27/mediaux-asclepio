<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$conexion = new mysqli("localhost", "root", "", "asclepio");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

// 1. Obtener datos del usuario
$stmt = $conexion->prepare("SELECT usuario, nombre, apellido_paterno, apellido_materno, correo, telefono, fecha_nacimiento, rol FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultUser = $stmt->get_result();
if ($resultUser->num_rows === 0) {
    $stmt->close();
    $conexion->close();
    header("Location: index.php");
    exit;
}
$usuario = $resultUser->fetch_assoc();
$stmt->close();

// 2. Obtener datos de la dirección (si existe)
$stmtDir = $conexion->prepare("SELECT calle, numero, colonia, ciudad, estado, codigo_postal FROM direcciones WHERE usuario_id = ?");
$stmtDir->bind_param("i", $id);
$stmtDir->execute();
$resultDir = $stmtDir->get_result();
$direccion = $resultDir->fetch_assoc() ?? [
    'calle' => '',
    'numero' => '',
    'colonia' => '',
    'ciudad' => '',
    'estado' => '',
    'codigo_postal' => ''
];
$stmtDir->close();

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Editar Usuario</title>
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
                  <i class="fas fa-user-edit fa-2x me-2 text-info"></i>
                  <span class="h2 fw-bold">Editar Usuario</span>
                </div>

                <form action="actualizar.php" method="POST" autocomplete="off">
                  <input type="hidden" name="id" value="<?= $id ?>" />

                  <div class="row">
                    <div class="col-md-12 mb-3">
                      <input type="text" name="usuario" class="form-control" placeholder="Usuario" required value="<?= htmlspecialchars($usuario['usuario']) ?>" />
                    </div>
                    <div class="col-md-6 mb-3">
                      <input type="text" name="nombre" class="form-control" placeholder="Nombre" required value="<?= htmlspecialchars($usuario['nombre']) ?>" />
                    </div>
                    <div class="col-md-6 mb-3">
                      <input type="text" name="apellido_paterno" class="form-control" placeholder="Apellido paterno" required value="<?= htmlspecialchars($usuario['apellido_paterno']) ?>" />
                    </div>
                    <div class="col-md-6 mb-3">
                      <input type="text" name="apellido_materno" class="form-control" placeholder="Apellido materno" value="<?= htmlspecialchars($usuario['apellido_materno']) ?>" />
                    </div>
                    <div class="col-md-6 mb-3">
                      <input type="email" name="correo" class="form-control" placeholder="Correo electrónico" required value="<?= htmlspecialchars($usuario['correo']) ?>" />
                    </div>
                    <div class="col-md-6 mb-3">
                      <input type="tel" name="telefono" class="form-control" placeholder="Teléfono" value="<?= htmlspecialchars($usuario['telefono']) ?>" />
                    </div>
                    <div class="col-md-6 mb-3">
                      <input type="date" name="fecha_nacimiento" class="form-control" placeholder="Fecha de nacimiento" required value="<?= htmlspecialchars($usuario['fecha_nacimiento']) ?>" />
                    </div>
                    <div class="col-md-12 mb-3">
                      <small class="text-muted">Dejar vacío para no cambiar la contraseña</small>
                      <input type="password" name="contrasena" class="form-control" placeholder="Nueva contraseña (opcional)" />
                    </div>

                    <hr class="my-3" />

                    <div class="col-md-12">
                      <h6 class="text-muted mb-3">Dirección</h6>
                    </div>

                    <div class="col-md-8 mb-3">
                      <input type="text" name="calle" class="form-control" placeholder="Calle" value="<?= htmlspecialchars($direccion['calle']) ?>" />
                    </div>
                    <div class="col-md-4 mb-3">
                      <input type="text" name="numero" class="form-control" placeholder="Número" value="<?= htmlspecialchars($direccion['numero']) ?>" />
                    </div>
                    <div class="col-md-6 mb-3">
                      <input type="text" name="colonia" class="form-control" placeholder="Colonia" value="<?= htmlspecialchars($direccion['colonia']) ?>" />
                    </div>
                    <div class="col-md-6 mb-3">
                      <input type="text" name="ciudad" class="form-control" placeholder="Ciudad" value="<?= htmlspecialchars($direccion['ciudad']) ?>" />
                    </div>
                    <div class="col-md-6 mb-3">
                      <input type="text" name="estado" class="form-control" placeholder="Estado" value="<?= htmlspecialchars($direccion['estado']) ?>" />
                    </div>
                    <div class="col-md-6 mb-3">
                      <input type="text" name="codigo_postal" class="form-control" placeholder="Código Postal" value="<?= htmlspecialchars($direccion['codigo_postal']) ?>" />
                    </div>

                    <div class="col-md-6 mb-3">
                      <label for="rol" class="form-label">Rol del usuario</label>
                      <select name="rol" id="rol" class="form-select" required>
                        <option value="usuario" <?= $usuario['rol'] === 'usuario' ? 'selected' : '' ?>>Usuario</option>
                        <option value="admin" <?= $usuario['rol'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                      </select>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-info w-100 mt-3">
                    <i class="fas fa-save"></i> Actualizar Usuario
                  </button>
                </form>
              </div>

              <div class="col-md-6 bg-form text-white d-flex flex-column align-items-center justify-content-center rounded-end">
                <i class="fas fa-user-edit fa-6x mb-4"></i>
                <h2 class="fw-bold">Editar Usuario</h2>
                <p class="lead text-center px-5">Modifica los datos del usuario y guarda los cambios.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
