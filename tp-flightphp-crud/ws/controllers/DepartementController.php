<?php
require_once __DIR__ . '/../models/Departement.php';
require_once __DIR__ . '/../helpers/Utils.php';

class DepartementController {
    public static function getAll() {
        $departements = Departement::getAll();
        Flight::json($departements);
    }

    public static function getById($id) {
        $departement = Departement::getById($id);
        Flight::json($departement);
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = Departement::create($data);
        Flight::json(['message' => 'Département ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        Departement::update($id, $data);
        Flight::json(['message' => 'Département modifié']);
    }

    public static function delete($id) {
        Departement::delete($id);
        Flight::json(['message' => 'Département supprimé']);
    }
}