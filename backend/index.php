<?php
// Autoload Composer packages
require __DIR__ . '/vendor/autoload.php';

// CRITICAL: CORS Headers for Vue.js connection
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Accept, Authorization");

// Handle preflight OPTIONS request from Axios
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

// Initialize Router
$router = new \Bramus\Router\Router();

// Group all /api routes together
$router->mount('/api', function() use ($router) {
    
    // Test Route: GET /api/menus
    $router->get('/menus', function() {
        header('Content-Type: application/json');
        echo json_encode([
            "data" => [
                ["id_menu" => 1, "nama_item" => "Iced Ceremonial Matcha", "deskripsi" => "Premium", "harga" => 45000, "pax" => 1]
            ]
        ]);
    });

    // Target Route: POST /api/staff/login
    $router->post('/staff/login', function() {
        header('Content-Type: application/json');
        
        // Axios sends JSON payloads, so we must decode php://input
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        // TODO: Replace this with your actual database OOP query
        if ($username === 'admin' && $password === 'admin123') {
            echo json_encode([
                'status' => 'success',
                'data' => [
                    'staff' => [
                        'nama_staff' => 'Admin Utama'
                    ]
                ]
            ]);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Kredensial tidak valid']);
        }
    });

});

// Execute the routing
$router->run();