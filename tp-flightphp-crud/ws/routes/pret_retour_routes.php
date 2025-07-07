<?php
require_once __DIR__ . '/../controllers/Pret_RetourController.php';

Flight::route('GET /api/pret_retours', ['Pret_RetourController', 'getAll']);
Flight::route('GET /api/pret_retours/@id', ['Pret_RetourController', 'getById']);
Flight::route('POST /api/pret_retours', ['Pret_RetourController', 'create']);
Flight::route('PUT /api/pret_retours/@id', ['Pret_RetourController', 'update']);
Flight::route('DELETE /api/pret_retours/@id', ['Pret_RetourController', 'delete']);
Flight::route('POST /api/pret_retours/calculate', ['Pret_RetourController', 'calculateInterests']);

// Serve HTML page
Flight::route('GET /interets', function() {
    echo file_get_contents(__DIR__ . '/../../public/interets.html');
});
?>