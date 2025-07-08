<?php
require_once __DIR__ . '/../models/Etablissement.php';
require_once __DIR__ . '/../helpers/Utils.php';

header('Access-Control-Allow-Origin: *'); // Allow all origins (restrict in production)
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

class EtablissementController {
    public static function getAll() {
        try {
            $etablissements = EtablissementFond::getAll();
            Flight::json($etablissements);
        } catch (Exception $e) {
            error_log('Error in getAll: ' . $e->getMessage());
            http_response_code(500);
            Flight::json(['error' => 'Server error occurred']);
        }
    }
    public static function getById($id) {
        try {
            $etablissement = Etablissement::getById($id);
            Flight::json($etablissement);
        } catch (Exception $e) {
            error_log('Error in getById: ' . $e->getMessage());
            http_response_code(500);
            Flight::json(['error' => 'Server error occurred']);
        }
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = Etablissement::create($data);
        Flight::json(['message' => 'Établissement ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        Etablissement::update($id, $data);
        Flight::json(['message' => 'Établissement modifié']);
    }

    public static function delete($id) {
        Etablissement::delete($id);
        Flight::json(['message' => 'Établissement supprimé']);
    }
}