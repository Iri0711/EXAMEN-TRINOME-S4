<?php
require_once __DIR__ . '/../controllers/ClientController.php';

Flight::route('GET /clients', function() {
    ClientController::getAll();
});

Flight::route('GET /clients/@id', function($id) {
    ClientController::getById($id);
});

Flight::route('POST /clients', function() {
    ClientController::create();
});

// Flight::route('PUT /clients/@id', function($id) {
//     ClientController::update($id);
// });

// Flight::route('DELETE /clients/@id', function($id) {
//     ClientController::delete($id);
// });