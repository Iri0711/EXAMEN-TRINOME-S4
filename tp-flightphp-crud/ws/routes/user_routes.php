<?php
require_once __DIR__ . '/../controllers/UserController.php';

Flight::route('GET /ws/users', ['UserController', 'getAll']);
Flight::route('GET /ws/users/@id', ['UserController', 'getById']);
Flight::route('POST /ws/users', ['UserController', 'create']);
Flight::route('PUT /ws/users/@id', ['UserController', 'update']);
Flight::route('DELETE /ws/users/@id', ['UserController', 'delete']);