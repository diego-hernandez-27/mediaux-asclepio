<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$conexion = new mysqli("localhost", "root", "", "asclepio");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recibir datos y sanitizar/validar
$id = intval($_POST['id']);
$usuario = trim($_POST['usuario']);
$nombre = trim($_POST['nombre']);
$apellido_paterno = trim($_POST['apellido_paterno']);
$apellido_materno = trim($_POST['apellido_materno']);
$correo = trim($_POST['correo']);
$telefono = trim($_POST['telefono']);
$fecha_nacimiento = $_POST['fecha_nacimiento']; // Puedes validar la fecha
$rol = $_POST['rol'] === 'admin' ? 'admin' : 'usuario';

// Dirección
$calle = trim($_POST['calle']);
$numero = trim($_POST['numero']);
$colonia = trim($_POST['colonia']);
$ciudad = trim($_POST['ciudad']);
$estado = trim($_POST['estado']);
$codigo_postal = trim($_POST['codigo_postal']);

// Actualizar usuario SIN contraseña primero
$stmt = $conexion->prepare("UPDATE usuarios SET usuario = ?, nombre = ?, apellido_paterno = ?, apellido_materno = ?, correo = ?, telefono = ?, fecha_nacimiento = ?, rol = ? WHERE id = ?");
$stmt->bind_param("ssssssssi", $usuario, $nombre, $apellido_paterno, $apellido_materno, $correo, $telefono, $fecha_nacimiento, $rol, $id);

if (!$stmt->execute()) {
    $error = $stmt->error;
    $stmt->close();
    $conexion->close();
    header("Location: editar.php?id=$id&error=" . urlencode("Error al actualizar usuario: $error"));
    exit;
}
$stmt->close();

// Actualizar contraseña solo si se envió y no está vacía
if (!empty($_POST['contrasena'])) {
    $contrasena_hash = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $stmt = $conexion->prepare("UPDATE usuarios SET contrasena = ? WHERE id = ?");
    $stmt->bind_param("si", $contrasena_hash, $id);
    if (!$stmt->execute()) {
        $error = $stmt->error;
        $stmt->close();
        $conexion->close();
        header("Location: editar.php?id=$id&error=" . urlencode("Error al actualizar contraseña: $error"));
        exit;
    }
    $stmt->close();
}

// Dirección
$stmt = $conexion->prepare("SELECT id FROM direcciones WHERE usuario_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($direccion_id);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conexion->prepare("UPDATE direcciones SET calle = ?, numero = ?, colonia = ?, ciudad = ?, estado = ?, codigo_postal = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $calle, $numero, $colonia, $ciudad, $estado, $codigo_postal, $direccion_id);
    if (!$stmt->execute()) {
        $error = $stmt->error;
        $stmt->close();
        $conexion->close();
        header("Location: editar.php?id=$id&error=" . urlencode("Error al actualizar dirección: $error"));
        exit;
    }
    $stmt->close();
} else {
    if ($calle || $numero || $colonia || $ciudad || $estado || $codigo_postal) {
        $stmt->close();
        $stmt = $conexion->prepare("INSERT INTO direcciones (usuario_id, calle, numero, colonia, ciudad, estado, codigo_postal) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssss", $id, $calle, $numero, $colonia, $ciudad, $estado, $codigo_postal);
        if (!$stmt->execute()) {
            $error = $stmt->error;
            $stmt->close();
            $conexion->close();
            header("Location: editar.php?id=$id&error=" . urlencode("Error al insertar dirección: $error"));
            exit;
        }
        $stmt->close();
    }
}

$conexion->close();
header("Location: index.php?mensaje=Usuario actualizado correctamente");
exit;
