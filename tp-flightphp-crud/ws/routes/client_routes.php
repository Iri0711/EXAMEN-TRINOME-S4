<?php
require_once __DIR__ . '/../controllers/ClientController.php';

Flight::route('GET /ws/clients', ['ClientController', 'getAll']);
Flight::route('GET /ws/clients/@id', ['ClientController', 'getById']);
Flight::route('POST /ws/clients', ['ClientController', 'create']);
Flight::route('PUT /ws/clients/@id', ['ClientController', 'update']);
Flight::route('DELETE /ws/clients/@id', ['ClientController', 'delete']);