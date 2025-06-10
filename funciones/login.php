<?php
session_start();

$conexion = new mysqli("localhost", "root", "", "asclepio");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$usuario_o_correo = trim($_POST['usuario_o_correo']);
$contrasena = $_POST['contrasena'];

// Consulta para buscar por usuario o correo
$stmt = $conexion->prepare("SELECT id, usuario, correo, contrasena FROM usuarios WHERE usuario = ? OR correo = ?");
$stmt->bind_param("ss", $usuario_o_correo, $usuario_o_correo);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 1) {
    $stmt->bind_result($id, $usuario, $correo, $hash_contrasena);
    $stmt->fetch();

    if (password_verify($contrasena, $hash_contrasena)) {
        // Credenciales válidas
        $_SESSION['id'] = $id;
        $_SESSION['usuario'] = $usuario;
        $_SESSION['correo'] = $correo;

        header("Location: ../index.php");
        exit;
    } else {
        $error = "Contraseña incorrecta.";
    }
} else {
    $error = "Usuario o correo no registrado.";
}

$stmt->close();
$conexion->close();

header("Location: ../login.php?error=" . urlencode($error) . "&usuario_o_correo=" . urlencode($usuario_o_correo));
exit;
?>
