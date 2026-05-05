<?php
/**
 * Helix Cloud Sync API
 * Guarda y entrega la configuración de presets y snapshots en formato JSON.
 */

// Permitir peticiones desde cualquier origen (CORS) para que el HTML local pueda conectar
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Manejar peticiones OPTIONS (Pre-flight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

$file = 'helix_config.json';

// --- GUARDAR DATOS (POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    
    // Validar que sea un JSON válido antes de guardar
    $data = json_decode($json);
    if ($data === null) {
        http_response_code(400);
        echo json_encode(["error" => "JSON inválido"]);
        exit;
    }

    if (file_put_contents($file, $json)) {
        echo json_encode(["status" => "success", "message" => "Configuración guardada en el servidor"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "No se pudo escribir el archivo en el servidor. Revisa los permisos de carpeta."]);
    }
} 

// --- LEER DATOS (GET) ---
else {
    if (file_exists($file)) {
        echo file_get_contents($file);
    } else {
        // Valores por defecto si el archivo no existe aún
        echo json_encode([
            "presets" => [],
            "snapshots" => [],
            "customActions" => []
        ]);
    }
}
