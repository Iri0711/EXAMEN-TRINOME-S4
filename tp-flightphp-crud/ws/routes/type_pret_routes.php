<?php
require_once __DIR__ . '/../controllers/Type_PretController.php';

Flight::route('GET /type_prets', ['Type_PretController', 'getAll']);
Flight::route('GET /type_prets/@id', ['Type_PretController', 'getById']);
Flight::route('POST /type_prets', ['Type_PretController', 'create']);
Flight::route('PUT /type_prets/@id', ['Type_PretController', 'update']);
Flight::route('DELETE /type_prets/@id', ['Type_PretController', 'delete']);