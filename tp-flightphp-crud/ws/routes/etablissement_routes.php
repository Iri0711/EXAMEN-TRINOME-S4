<?php
require_once __DIR__ . '/../controllers/EtablissementController.php';

// API Routes
Flight::route('GET /api/etablissements', ['EtablissementController', 'getAll']);
Flight::route('GET /api/etablissements/@id', ['EtablissementController', 'getById']);
Flight::route('POST /api/etablissements', ['EtablissementController', 'create']);
Flight::route('PUT /api/etablissements/@id', ['EtablissementController', 'update']);
Flight::route('DELETE /api/etablissements/@id', ['EtablissementController', 'delete']);

// Serve HTML page
Flight::route('GET /etablissements', function() {
    echo file_get_contents(__DIR__ . '/../../public/etablissements.html');
});
?>