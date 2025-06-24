<?php
header('Content-Type: application/json');

// Simular una base de datos en memoria
$favorites = [];

// Obtener el método HTTP
$method = $_SERVER['REQUEST_METHOD'];

try {
    switch ($method) {
        case 'POST':
            // Simular agregar favorito
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'] ?? null;
            if ($id) {
                $favorites[$id] = true;
                echo json_encode(['success' => true, 'message' => 'Favorito agregado']);
            } else {
                throw new Exception('ID requerido');
            }
            break;

        case 'DELETE':
            // Simular eliminar favorito
            $id = $_GET['id'] ?? null;
            if ($id && isset($favorites[$id])) {
                unset($favorites[$id]);
                echo json_encode(['success' => true, 'message' => 'Favorito eliminado']);
            } else {
                throw new Exception('ID no encontrado');
            }
            break;

        default:
            throw new Exception('Método no permitido');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
