<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

require_once 'conexion.php';

$usuario = $_SESSION['usuario'];

$sql = "SELECT u.nombre, u.apellido_paterno, u.apellido_materno, u.correo, u.telefono, u.fecha_nacimiento,
               d.calle, d.numero, d.colonia, d.ciudad, d.estado, d.codigo_postal
        FROM usuarios u
        LEFT JOIN direcciones d ON u.id = d.usuario_id
        WHERE u.usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();
$datos = $result->fetch_assoc();
$stmt->close();
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="css/perfil.css">
</head>
<body>
    <div class="header">
        <div class="logo-title">
            <img src="img/logo.png" alt="Logo Asclepio" class="logo">
            <h1>ASCLEPIO</h1>
        </div>
        <div class="back-button">
            <a href="perfil.php" class="btn-back">← Cancelar</a>
        </div>
    </div>

    <form class="profile-container" method="POST" action="funciones/actualizar_perfil.php">
        <div class="profile-card">
           

            <div class="profile-sections">
                <!-- Información Personal -->
<!-- Información Personal -->
<div class="section">
    <h3>📋 Información Personal</h3>
    <div class="info-grid">
        <div class="info-item">
    <label for="usuario">Usuario:</label>
    <input type="text" name="usuario" id="usuario" class="perfil-input" value="<?= htmlspecialchars($usuario) ?>">
</div>
<div class="info-item">
    <label for="correo">Correo:</label>
    <input type="email" name="correo" id="correo" class="perfil-input" value="<?= htmlspecialchars($datos['correo']) ?>">
</div>

        <div class="info-item">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="perfil-input" value="<?= htmlspecialchars($datos['nombre']) ?>">
        </div>
        <div class="info-item">
            <label for="apellido_paterno">Apellido Paterno:</label>
            <input type="text" name="apellido_paterno" id="apellido_paterno" class="perfil-input" value="<?= htmlspecialchars($datos['apellido_paterno']) ?>">
        </div>
        <div class="info-item">
            <label for="apellido_materno">Apellido Materno:</label>
            <input type="text" name="apellido_materno" id="apellido_materno" class="perfil-input" value="<?= htmlspecialchars($datos['apellido_materno']) ?>">
        </div>
        <div class="info-item">
            <label for="fecha_nacimiento">Fecha de nacimiento:</label>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="perfil-input" value="<?= htmlspecialchars($datos['fecha_nacimiento']) ?>">
        </div>
        <div class="info-item">
            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" class="perfil-input" value="<?= htmlspecialchars($datos['telefono']) ?>">
        </div>
    </div>
</div>

<!-- Dirección -->
<div class="section">
    <h3>📍 Dirección</h3>
    <div class="info-grid">
        <div class="info-item">
            <label for="calle">Calle:</label>
            <input type="text" name="calle" id="calle" class="perfil-input" value="<?= htmlspecialchars($datos['calle']) ?>">
        </div>
        <div class="info-item">
            <label for="numero">Número:</label>
            <input type="text" name="numero" id="numero" class="perfil-input" value="<?= htmlspecialchars($datos['numero']) ?>">
        </div>
        <div class="info-item">
            <label for="colonia">Colonia:</label>
            <input type="text" name="colonia" id="colonia" class="perfil-input" value="<?= htmlspecialchars($datos['colonia']) ?>">
        </div>
        <div class="info-item">
            <label for="ciudad">Ciudad:</label>
            <input type="text" name="ciudad" id="ciudad" class="perfil-input" value="<?= htmlspecialchars($datos['ciudad']) ?>">
        </div>
        <div class="info-item">
            <label for="estado">Estado:</label>
            <input type="text" name="estado" id="estado" class="perfil-input" value="<?= htmlspecialchars($datos['estado']) ?>">
        </div>
        <div class="info-item">
            <label for="codigo_postal">Código Postal:</label>
            <input type="text" name="codigo_postal" id="codigo_postal" class="perfil-input" value="<?= htmlspecialchars($datos['codigo_postal']) ?>">
        </div>
    </div>
</div>



                <div class="section">
                    <div class="actions-grid">
                        <button type="submit" class="action-btn edit-btn">
                            <span>💾</span>
                            Guardar Cambios
                        </button>
                        <a href="perfil.php" class="action-btn logout-btn">
                            <span>✖️</span>
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
    <script src="js/perfil.js"></script>

</html>
