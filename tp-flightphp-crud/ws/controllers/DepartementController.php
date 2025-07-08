<?php
require_once __DIR__ . '/../models/Departement.php';
require_once __DIR__ . '/../helpers/Utils.php';

class DepartementController {
    public static function getAll() {
        $departements = Departement::getAll();
        Flight::json(['success'=>true,'message' => 'Département ajouté', 'data' => $departements]);
    }

    public static function getById($id) {
        $departement = Departement::getById($id);
        Flight::json($departement);
    }

    public static function create() {
        error_log("DAPE");
        $data = Flight::request()->data;
        $id = Departement::create($data);
        Flight::json(['success'=>true,'message' => 'Département ajouté', 'id' => $id]);
    }

    public static function update($id) {
        error_log("UPDATE");
        $data = Flight::request()->data;
        error_log(json_encode(Flight::request()->data));
        Departement::update($id, $data);
        Flight::json(['success'=>true,'message' => 'Département modifié']);
    }

    public static function delete($id) {
        Departement::delete($id);
        Flight::json(['success'=>true,'message' => 'Département supprimé']);
    }
}