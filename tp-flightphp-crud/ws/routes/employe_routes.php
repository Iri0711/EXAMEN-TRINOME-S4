<?php
require_once __DIR__ . '/../controllers/EmployeController.php';

Flight::route('GET /ws/employees', ['EmployeController', 'getAll']);
Flight::route('GET /ws/employees/@id', ['EmployeController', 'getById']);
Flight::route('POST /ws/employees', ['EmployeController', 'create']);
Flight::route('PUT /ws/employees/@id', ['EmployeController', 'update']);
Flight::route('DELETE /ws/employees/@id', ['EmployeController', 'delete']);