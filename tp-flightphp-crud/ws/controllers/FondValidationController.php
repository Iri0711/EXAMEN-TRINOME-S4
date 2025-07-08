<?php

require_once __DIR__ . '/../models/FondValidation.php';
require_once __DIR__ . '/../helpers/Utils.php';

header('Access-Control-Allow-Origin: *'); // Allow all origins (restrict in production)
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');     

class FondValidationController {
    public static function getAll() {
        $fonds = FondValidation::getAll();
        Flight::json($fonds);
    }

    public static function getById($id) {
        $fond = FondValidation::getById($id);
        Flight::json($fond);
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = FondValidation::create($data);
        Flight::json(['message' => 'Fonds validé', 'id' => $id]);
    }   

}