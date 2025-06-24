<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

require_once '../conexion.php';

$usuario = $_SESSION['usuario'];

// Obtener el ID del usuario
$sql_id = "SELECT id FROM usuarios WHERE usuario = ?";
$stmt = $conexion->prepare($sql_id);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$stmt->bind_result($id_usuario);
$stmt->fetch();
$stmt->close();

if (!$id_usuario) {
    die("Usuario no encontrado.");
}

// Obtener los datos del formulario
$nombre = $_POST['nombre'] ?? '';
$apellido_paterno = $_POST['apellido_paterno'] ?? '';
$apellido_materno = $_POST['apellido_materno'] ?? '';
$fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$calle = $_POST['calle'] ?? '';
$numero = $_POST['numero'] ?? '';
$colonia = $_POST['colonia'] ?? '';
$ciudad = $_POST['ciudad'] ?? '';
$estado = $_POST['estado'] ?? '';
$codigo_postal = $_POST['codigo_postal'] ?? '';

// **Faltaban estas variables:**
$usuario_nuevo = $_POST['usuario'] ?? $usuario;  // Si no se cambia, se queda igual
$correo = $_POST['correo'] ?? '';

// Actualizar datos en la tabla usuarios
$sql_usuarios = "UPDATE usuarios 
    SET nombre = ?, apellido_paterno = ?, apellido_materno = ?, fecha_nacimiento = ?, telefono = ?, usuario = ?, correo = ? 
    WHERE id = ?";
$stmt = $conexion->prepare($sql_usuarios);
$stmt->bind_param("sssssssi", $nombre, $apellido_paterno, $apellido_materno, $fecha_nacimiento, $telefono, $usuario_nuevo, $correo, $id_usuario);
$stmt->execute();
$stmt->close();

// Verificar si ya hay dirección para este usuario
$sql_check = "SELECT COUNT(*) FROM direcciones WHERE usuario_id = ?";
$stmt = $conexion->prepare($sql_check);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count > 0) {
    // Si ya existe dirección, actualizamos
    $sql_direccion = "UPDATE direcciones SET calle = ?, numero = ?, colonia = ?, ciudad = ?, estado = ?, codigo_postal = ? WHERE usuario_id = ?";
    $stmt = $conexion->prepare($sql_direccion);
    $stmt->bind_param("ssssssi", $calle, $numero, $colonia, $ciudad, $estado, $codigo_postal, $id_usuario);
} else {
    // Si no existe, insertamos nueva dirección
    $sql_direccion = "INSERT INTO direcciones (usuario_id, calle, numero, colonia, ciudad, estado, codigo_postal) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql_direccion);
    $stmt->bind_param("issssss", $id_usuario, $calle, $numero, $colonia, $ciudad, $estado, $codigo_postal);
}
$stmt->execute();
$stmt->close();

$conexion->close();

// Actualizar sesión si cambió el usuario
$_SESSION['usuario'] = $usuario_nuevo;

// Redirigir al perfil
header('Location: ../perfil.php');
exit;
?>
