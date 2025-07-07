<?php
require_once __DIR__ . '/../controllers/Type_PretController.php';

Flight::route('GET /api/type_prets', ['Type_PretController', 'getAll']);
Flight::route('GET /api/type_prets/@id', ['Type_PretController', 'getById']);
Flight::route('POST /api/type_prets', ['Type_PretController', 'create']);
Flight::route('PUT /api/type_prets/@id', ['Type_PretController', 'update']);
Flight::route('DELETE /api/type_prets/@id', ['Type_PretController', 'delete']);

// Serve HTML page
Flight::route('GET /prets', function() {
    echo file_get_contents(__DIR__ . '/../../public/prets.html');
});
?>