<?php
require_once __DIR__ . '/../controllers/UserController.php';

Flight::route('GET /users', ['UserController', 'getAll']);
Flight::route('GET /users/@id', ['UserController', 'getById']);
Flight::route('POST /users', ['UserController', 'create']);
Flight::route('PUT /users/@id', ['UserController', 'update']);
Flight::route('DELETE /users/@id', ['UserController', 'delete']);