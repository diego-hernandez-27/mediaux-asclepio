<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$conexion = new mysqli("localhost", "root", "", "asclepio");
$usuarios = [];

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$filtro = isset($_GET['buscar']) ? "%" . trim($_GET['buscar']) . "%" : "%";
$stmt = $conexion->prepare("SELECT id, usuario, nombre, apellido_paterno, apellido_materno, correo, rol FROM usuarios WHERE usuario LIKE ? OR correo LIKE ? OR nombre LIKE ?");
$stmt->bind_param("sss", $filtro, $filtro, $filtro);
$stmt->execute();
$resultado = $stmt->get_result();
while ($fila = $resultado->fetch_assoc()) {
    $usuarios[] = $fila;
}
$stmt->close();
$conexion->close();

// Id o usuario actual para comparar
$usuario_actual = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Panel de Administración</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
    }
    .table-container {
      max-height: 70vh;
      overflow-y: auto;
    }
    /* Estilo especial para el usuario actual */
    .usuario-actual {
      background-color: #d1e7dd !important; /* verde claro */
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-info px-4">
    <a class="navbar-brand" href="#"><i class="fas fa-users-cog me-2"></i>Panel Admin</a>
    <div class="ms-auto">
      <span class="text-white me-3">Hola, <?= htmlspecialchars($usuario_actual) ?></span>
      <a href="../logout.php" class="btn btn-light btn-sm"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
    </div>
  </nav>

  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="fw-bold">Usuarios Registrados</h2>

      <form class="d-flex" method="GET">
        <input class="form-control me-2" type="search" name="buscar" placeholder="Buscar usuario o correo" value="<?= isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : '' ?>">
        <button class="btn btn-outline-info" type="submit"><i class="fas fa-search"></i></button>
      </form>

      <a href="nuevo.php" class="btn btn-success">
        <i class="fas fa-user-plus"></i> Nuevo Usuario
      </a>
    </div>

    <div class="table-responsive table-container shadow-sm bg-white p-3 rounded">
      <table class="table table-hover align-middle text-center">
        <thead class="table-info">
          <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($usuarios)): ?>
            <tr>
              <td colspan="6" class="text-muted">No se encontraron usuarios.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($usuarios as $u): ?>
              <?php
                $claseFila = ($u['usuario'] === $usuario_actual) ? 'usuario-actual' : '';
              ?>
              <tr class="<?= $claseFila ?>">
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['usuario']) ?></td>
                <td><?= htmlspecialchars($u['nombre'] . ' ' . $u['apellido_paterno'] . ' ' . $u['apellido_materno']) ?></td>
                <td><?= htmlspecialchars($u['correo']) ?></td>
                <td><span class="badge bg-<?= $u['rol'] === 'admin' ? 'danger' : 'secondary' ?>"><?= $u['rol'] ?></span></td>
                <td>
                  <a href="editar.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                  <?php if ($u['usuario'] !== $usuario_actual): ?>
                    <a href="eliminar.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?')"><i class="fas fa-trash-alt"></i></a>
                  <?php else: ?>
                    <button class="btn btn-sm btn-danger" disabled title="No puedes eliminarte a ti mismo">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
