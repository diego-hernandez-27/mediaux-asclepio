<?php
$conexion = new mysqli("localhost", "root", "", "asclepio");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$usuario = trim($_POST['usuario']);
$nombre = trim($_POST['nombre']);
$apellido_paterno = trim($_POST['apellido_paterno']);
$apellido_materno = trim($_POST['apellido_materno']);
$correo = trim($_POST['correo']);
$telefono = trim($_POST['telefono']);
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$contrasena = $_POST['contrasena'];
$calle = trim($_POST['calle']);
$numero = trim($_POST['numero']);
$colonia = trim($_POST['colonia']);
$ciudad = trim($_POST['ciudad']);
$estado = trim($_POST['estado']);
$codigo_postal = trim($_POST['codigo_postal']);

$error = [];

// Verificar si correo ya existe
$verificar_correo = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ?");
$verificar_correo->bind_param("s", $correo);
$verificar_correo->execute();
$verificar_correo->store_result();
if ($verificar_correo->num_rows > 0) {
    $error[] = "El correo ya está registrado.";
}
$verificar_correo->close();

// Verificar si usuario ya existe (columna usuario, no nombre)
$verificar_usuario = $conexion->prepare("SELECT id FROM usuarios WHERE usuario = ?");
$verificar_usuario->bind_param("s", $usuario);
$verificar_usuario->execute();
$verificar_usuario->store_result();
if ($verificar_usuario->num_rows > 0) {
    $error[] = "El nombre de usuario ya está registrado.";
}
$verificar_usuario->close();

if (!empty($error)) {
    // Armar query string con datos para que se mantengan en el formulario
    $params = http_build_query([
        'error' => implode(" ", $error),
        'usuario' => $usuario,
        'nombre' => $nombre,
        'apellido_paterno' => $apellido_paterno,
        'apellido_materno' => $apellido_materno,
        'correo' => $correo,
        'telefono' => $telefono,
        'fecha_nacimiento' => $fecha_nacimiento,
        'calle' => $calle,
        'numero' => $numero,
        'colonia' => $colonia,
        'ciudad' => $ciudad,
        'estado' => $estado,
        'codigo_postal' => $codigo_postal
    ]);
    header("Location: ../registro.php?$params");
    exit;
}

// Encriptar la contraseña
$hash = password_hash($contrasena, PASSWORD_DEFAULT);

// Insertar en tabla usuarios (asegúrate que los nombres de columnas coincidan)
$stmt = $conexion->prepare("INSERT INTO usuarios (usuario, nombre, apellido_paterno, apellido_materno, correo, telefono, fecha_nacimiento, contrasena) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $usuario, $nombre, $apellido_paterno, $apellido_materno, $correo, $telefono, $fecha_nacimiento, $hash);
if (!$stmt->execute()) {
    die("Error al registrar usuario.");
}
$usuario_id = $stmt->insert_id;
$stmt->close();

// Insertar dirección
$stmt_dir = $conexion->prepare("INSERT INTO direcciones (usuario_id, calle, numero, colonia, ciudad, estado, codigo_postal) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt_dir->bind_param("issssss", $usuario_id, $calle, $numero, $colonia, $ciudad, $estado, $codigo_postal);
$stmt_dir->execute();
$stmt_dir->close();

$conexion->close();

// Redirigir a login tras éxito
header("Location: ../login.php");
exit;
?>
