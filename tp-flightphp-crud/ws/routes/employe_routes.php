<?php
require_once __DIR__ . '/../controllers/EmployeController.php';

Flight::route('GET /api/employees', ['EmployeController', 'getAll']);
Flight::route('GET /api/employees/@id', ['EmployeController', 'getById']);
Flight::route('POST /api/employees', ['EmployeController', 'create']);
Flight::route('PUT /api/employees/@id', ['EmployeController', 'update']);
Flight::route('DELETE /api/employees/@id', ['EmployeController', 'delete']);

// Serve HTML page
Flight::route('GET /employes', function() {
    echo file_get_contents(__DIR__ . '/../../public/employees.html');
});
?>