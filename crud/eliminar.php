<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php?error=ID de usuario no válido");
    exit;
}

$id = intval($_GET['id']);

$conexion = new mysqli("localhost", "root", "", "asclepio");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Preparar la consulta para eliminar el usuario
$stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $stmt->close();
    $conexion->close();
    header("Location: index.php?mensaje=Usuario eliminado correctamente");
    exit;
} else {
    $error = $stmt->error;
    $stmt->close();
    $conexion->close();
    header("Location: index.php?error=" . urlencode("Error al eliminar usuario: $error"));
    exit;
}
