<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: nuevo.php");
    exit;
}

$conexion = new mysqli("localhost", "root", "", "asclepio");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recibir y sanitizar datos
$usuario = trim($_POST['usuario']);
$nombre = trim($_POST['nombre']);
$apellido_paterno = trim($_POST['apellido_paterno']);
$apellido_materno = trim($_POST['apellido_materno'] ?? '');
$correo = trim($_POST['correo']);
$telefono = trim($_POST['telefono'] ?? '');
$fecha_nacimiento = trim($_POST['fecha_nacimiento']);
$contrasena = $_POST['contrasena'];
$rol = $_POST['rol'];

// Datos dirección
$calle = trim($_POST['calle'] ?? '');
$numero = trim($_POST['numero'] ?? '');
$colonia = trim($_POST['colonia'] ?? '');
$ciudad = trim($_POST['ciudad'] ?? '');
$estado = trim($_POST['estado'] ?? '');
$codigo_postal = trim($_POST['codigo_postal'] ?? '');

// Validar datos mínimos
if (empty($usuario) || empty($nombre) || empty($apellido_paterno) || empty($correo) || empty($fecha_nacimiento) || empty($contrasena) || empty($rol)) {
    die("Faltan datos obligatorios.");
}

// Hashear la contraseña
$contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

// Insertar usuario
$stmt = $conexion->prepare("INSERT INTO usuarios (usuario, nombre, apellido_paterno, apellido_materno, correo, telefono, fecha_nacimiento, contrasena, rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssss", $usuario, $nombre, $apellido_paterno, $apellido_materno, $correo, $telefono, $fecha_nacimiento, $contrasena_hash, $rol);

if (!$stmt->execute()) {
    die("Error al insertar usuario: " . $stmt->error);
}

$usuario_id = $stmt->insert_id; // id del usuario creado
$stmt->close();

// Insertar dirección solo si hay al menos calle o colonia o ciudad o algo
if ($calle || $numero || $colonia || $ciudad || $estado || $codigo_postal) {
    $stmtDir = $conexion->prepare("INSERT INTO direcciones (usuario_id, calle, numero, colonia, ciudad, estado, codigo_postal) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmtDir->bind_param("issssss", $usuario_id, $calle, $numero, $colonia, $ciudad, $estado, $codigo_postal);
    if (!$stmtDir->execute()) {
        die("Error al insertar dirección: " . $stmtDir->error);
    }
    $stmtDir->close();
}

$conexion->close();

// Redirigir al panel o página de usuarios
header("Location: index.php?mensaje=Usuario creado correctamente");
exit;
