<?php
session_start();

$conexion = new mysqli("localhost", "root", "", "asclepio");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$usuario_o_correo = trim($_POST['usuario_o_correo']);
$contrasena = $_POST['contrasena'];

// Consulta para buscar por usuario o correo y obtener también el rol
$stmt = $conexion->prepare("SELECT id, usuario, correo, contrasena, rol FROM usuarios WHERE usuario = ? OR correo = ?");
$stmt->bind_param("ss", $usuario_o_correo, $usuario_o_correo);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $usuario, $correo, $hash_contrasena, $rol);
    $stmt->fetch();

    if (password_verify($contrasena, $hash_contrasena)) {
        // Credenciales válidas
        $_SESSION['id'] = $id;
        $_SESSION['usuario'] = $usuario;
        $_SESSION['correo'] = $correo;
        $_SESSION['rol'] = $rol;

        if ($rol === 'admin') {
            header("Location: ../crud/index.php");
        } else {
            header("Location: ../menu.html");
        }
        exit;
    } else {
        $error = "Contraseña incorrecta.";
    }
} else {
    $error = "Usuario o correo no registrado.";
}

$stmt->close();
$conexion->close();

// Redirigir de nuevo al login con mensaje de error y mantener el input llenado
header("Location: ../login.php?error=" . urlencode($error) . "&usuario_o_correo=" . urlencode($usuario_o_correo));
exit;
?>
