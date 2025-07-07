<?php
require_once __DIR__.'/../controllers/DepartementController.php';

// API Routes
Flight::route('GET /api/departements', ['DepartementController', 'getAll']);
Flight::route('GET /api/departements/@id', ['DepartementController', 'getById']);
Flight::route('POST /api/departements', ['DepartementController', 'create']);
Flight::route('PUT /api/departements/@id', ['DepartementController', 'update']);
Flight::route('DELETE /api/departements/@id', ['DepartementController', 'delete']);

// Route pour servir le HTML
Flight::route('GET /departements.html', function() {
    echo file_get_contents(__DIR__.'/../../public/departements.html');
});