<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/koneksi.php'; // <-- Load koneksi database di sini

header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Accept, Authorization");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

$router = new \Bramus\Router\Router();

$router->mount('/api', function() use ($router, $pdo) { // <-- Ambil variabel $pdo ke dalam scope router
    
    // Ambil data menu LIVE dari database
    $router->get('/menus', function() use ($pdo) {
        header('Content-Type: application/json');
        
        try {
            // Sesuaikan nama tabel Anda (misal: 'menu' atau 'menus')
            $stmt = $pdo->query('SELECT id_menu, nama_item, deskripsi, harga, pax FROM menu');
            $menus = $stmt->fetchAll();
            
            // Return data dalam format JSON yang siap dibaca oleh Vue
            echo json_encode($menus);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Gagal mengambil data database: ' . $e->getMessage()]);
        }
    });

    // Rute staff login tetap sama atau sesuaikan dengan query SELECT ke tabel staff
    $router->post('/staff/login', function() use ($pdo) {
        // ... logika login staff ...
    });
});

$router->run();