<?php
require_once __DIR__ . '/../controllers/UserController.php';

Flight::route('GET /api/users', ['UserController', 'getAll']);
Flight::route('GET /api/users/@id', ['UserController', 'getById']);
Flight::route('POST /api/users', ['UserController', 'create']);
Flight::route('PUT /api/users/@id', ['UserController', 'update']);
Flight::route('DELETE /api/users/@id', ['UserController', 'delete']);

// Serve HTML page
Flight::route('GET /users', function() {
    echo file_get_contents(__DIR__ . '/../../public/users.html');
});
?>