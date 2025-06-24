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
    <title>Asclepio - Perfil de Usuario</title>
    <link rel="stylesheet" href="css/perfil.css">
</head>
<body>
    <div class="header">
        <div class="logo-title">
            <img src="img/logo.png" alt="Logo Asclepio" class="logo">
            <h1>ASCLEPIO</h1>
        </div>
        <div class="back-button">
            <a href="menu.php" class="btn-back">← Volver al Menú</a>
        </div>
    </div>

    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    <img src="https://i.imgur.com/4ZQeZsK.png" alt="Avatar" class="avatar">
                    <div class="avatar-overlay">
                        <span>📷</span>
                    </div>
                </div>
                <div class="profile-info">
                    <h2 id="user-name"><?= htmlspecialchars($_SESSION['usuario']) ?></h2>
                    <p id="user-email"><?= htmlspecialchars($datos['correo']) ?></p>
                    <span class="status-badge">Activo</span>
                </div>
            </div>

            <div class="profile-sections">
                <!-- Información Personal -->
                <div class="section">
                    <h3>📋 Información Personal</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Nombre completo:</label>
                            <span id="full-name"><?= htmlspecialchars($datos['nombre'] . ' ' . $datos['apellido_paterno'] . ' ' . $datos['apellido_materno']) ?></span>
                        </div>
                        <div class="info-item">
                            <label>Fecha de nacimiento:</label>
                            <span id="birth-date"><?= htmlspecialchars($datos['fecha_nacimiento']) ?></span>
                        </div>
                        <div class="info-item">
                            <label>Teléfono:</label>
                            <span id="phone"><?= htmlspecialchars($datos['telefono']) ?></span>
                        </div>
                        
                    </div>
                </div>

                <!-- Dirección -->
                <div class="section">
                    <h3>📍 Dirección</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Calle:</label>
                            <span id="street"><?= htmlspecialchars($datos['calle']) ?></span>
                        </div>
                        <div class="info-item">
                            <label>Número:</label>
                            <span id="number"><?= htmlspecialchars($datos['numero']) ?></span>
                        </div>
                        <div class="info-item">
                            <label>Colonia:</label>
                            <span id="colony"><?= htmlspecialchars($datos['colonia']) ?></span>
                        </div>
                        <div class="info-item">
                            <span id="city"><?= htmlspecialchars($datos['ciudad']) ?></span>
                            <span id="city">Ciudad de México</span>
                        </div>
                        <div class="info-item">
                            <label>Estado:</label>
                            <span id="state"><?= htmlspecialchars($datos['estado']) ?></span>
                        </div>
                        <div class="info-item">
                            <label>Código Postal:</label>
                            <span id="zip"><?= htmlspecialchars($datos['codigo_postal']) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas -->
                <div class="section">
                    <h3>📊 Estadísticas</h3>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-number">12</div>
                            <div class="stat-label">Citas realizadas</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">5</div>
                            <div class="stat-label">Hospitales visitados</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">8</div>
                            <div class="stat-label">Doctores consultados</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">3</div>
                            <div class="stat-label">Especialidades</div>
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="section">
                    <h3>⚙️ Acciones</h3>
                    <div class="actions-grid">
                        <a href="editar_perfil.php" class="action-btn edit-btn">
                            <span>✏️</span>
                            Editar Perfil
                        </a>
                        <a href="cambiar_contrasena.php" class="action-btn password-btn">
                            <span>🔒</span>
                            Cambiar Contraseña
                        </a>
                        <a href="logout.php" class="action-btn logout-btn">
                            <span>🚪</span>
                            Cerrar Sesión
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/perfil.js"></script>
</body>
</html> 