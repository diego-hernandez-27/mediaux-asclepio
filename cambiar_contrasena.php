<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

require_once 'conexion.php';

$usuario = $_SESSION['usuario'];
$mensaje = '';
$mensaje_tipo = ''; // "error" o "success"

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contrasena_actual = $_POST['contrasena_actual'] ?? '';
    $nueva_contrasena = $_POST['nueva_contrasena'] ?? '';
    $confirmar_contrasena = $_POST['confirmar_contrasena'] ?? '';

    if (!$contrasena_actual || !$nueva_contrasena || !$confirmar_contrasena) {
        $mensaje = "Por favor, completa todos los campos.";
        $mensaje_tipo = "error";
    } elseif ($nueva_contrasena !== $confirmar_contrasena) {
        $mensaje = "La nueva contraseña y la confirmación no coinciden.";
        $mensaje_tipo = "error";
    } elseif (strlen($nueva_contrasena) < 6) {
        $mensaje = "La nueva contraseña debe tener al menos 8 caracteres.";
        $mensaje_tipo = "error";
    } else {
        // Obtener hash de la contraseña actual
        $sql = "SELECT contrasena FROM usuarios WHERE usuario = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->bind_result($hash_actual);
        $stmt->fetch();
        $stmt->close();
// DEBUG - Mostrar el hash para verificar
//var_dump($usuario, $hash_actual);
//exit; // Detener ejecución para ver los datos
        if (!$hash_actual) {
    $mensaje = "Usuario no encontrado.";
    $mensaje_tipo = "error";
} elseif (!password_verify($contrasena_actual, $hash_actual)) {
    $mensaje = "La contraseña actual es incorrecta.";
    $mensaje_tipo = "error";
} else {
    $hash_nueva = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
    $sql_update = "UPDATE usuarios SET contrasena = ? WHERE usuario = ?";
    $stmt = $conexion->prepare($sql_update);
    $stmt->bind_param("ss", $hash_nueva, $usuario);
    if ($stmt->execute()) {
        header('Location: perfil.php');
        exit;
    } else {
        $mensaje = "Error al actualizar la contraseña.";
        $mensaje_tipo = "error";
    }
    $stmt->close();
}

    }
}
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Asclepio - Cambiar Contraseña</title>
    <link rel="stylesheet" href="css/perfil.css" />
</head>
<body>
    <div class="header">
        <div class="logo-title">
            <img src="img/logo.png" alt="Logo Asclepio" class="logo">
            <h1>ASCLEPIO</h1>
        </div>
        <div class="back-button">
            <a href="perfil.php" class="btn-back">← Volver al Perfil</a>
        </div>
    </div>

    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-header" style="justify-content: center;">
                <h2 style="color:#4c88a2;">Cambiar Contraseña</h2>
            </div>
            <div class="profile-sections">
                <form method="POST" action="">
                    <div class="section">
                        <div class="info-grid" style="max-width: 500px; margin: auto;">
                            <div class="info-item" style="flex-direction: column; align-items: flex-start;">
                                <label for="contrasena_actual">Contraseña Actual:</label>
                                <input
                                    type="password"
                                    id="contrasena_actual"
                                    name="contrasena_actual"
                                    class="perfil-input"
                                    required
                                />
                            </div>
                            <div class="info-item" style="flex-direction: column; align-items: flex-start;">
                                <label for="nueva_contrasena">Nueva Contraseña:</label>
                                <input
                                    type="password"
                                    id="nueva_contrasena"
                                    name="nueva_contrasena"
                                    class="perfil-input"
                                    minlength="7"
                                    required
                                />
                            </div>
                            <div class="info-item" style="flex-direction: column; align-items: flex-start;">
                                <label for="confirmar_contrasena">Confirmar Nueva Contraseña:</label>
                                <input
                                    type="password"
                                    id="confirmar_contrasena"
                                    name="confirmar_contrasena"
                                    class="perfil-input"
                                    minlength="7"
                                    required
                                />
                            </div>
                        </div>
                    </div>

                    <div class="section" style="text-align: center;">
                        <button type="submit" class="action-btn edit-btn" style="max-width: 300px; width: 100%;">
                            💾 Guardar Cambios
                        </button>
                    </div>
                </form>

                <?php if ($mensaje): ?>
                    <div class="section" style="max-width: 500px; margin: auto;">
                        <p style="color: <?= $mensaje_tipo === 'success' ? '#4CAF50' : '#f44336' ?>; font-weight: 600; text-align:center;">
                            <?= htmlspecialchars($mensaje) ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
