<?php
require_once __DIR__ . '/../controllers/ClientController.php';

Flight::route('GET /api/clients', ['ClientController', 'getAll']);
Flight::route('GET /api/clients/@id', ['ClientController', 'getById']);
Flight::route('POST /api/clients', ['ClientController', 'create']);
Flight::route('PUT /api/clients/@id', ['ClientController', 'update']);
Flight::route('DELETE /api/clients/@id', ['ClientController', 'delete']);

// Serve HTML page
Flight::route('GET /clients', function() {
    echo file_get_contents(__DIR__ . '/../../public/clients.html');
});
?>