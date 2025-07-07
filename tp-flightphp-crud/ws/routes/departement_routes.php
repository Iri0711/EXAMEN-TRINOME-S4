<?php
require_once __DIR__ . '/../controllers/DepartementController.php';

Flight::route('GET /departements', ['DepartementController', 'getAll']);
Flight::route('GET /departements/@id', ['DepartementController', 'getById']);
Flight::route('POST /departements', ['DepartementController', 'create']);
Flight::route('PUT /departements/@id', ['DepartementController', 'update']);
Flight::route('DELETE /departements/@id', ['DepartementController', 'delete']);