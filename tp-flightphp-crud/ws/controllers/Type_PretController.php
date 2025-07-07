<?php
require_once __DIR__ . '/../models/Type_Pret.php';
require_once __DIR__ . '/../helpers/Utils.php';

class Type_PretController {
    public static function getAll() {
        $typePrets = Type_Pret::getAll();
        Flight::json($typePrets);
    }

    public static function getById($id) {
        $typePret = Type_Pret::getById($id);
        Flight::json($typePret);
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = Type_Pret::create($data);
        Flight::json(['message' => 'Type Prêt ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        Type_Pret::update($id, $data);
        Flight::json(['message' => 'Type Prêt modifié']);
    }

    public static function delete($id) {
        Type_Pret::delete($id);
        Flight::json(['message' => 'Type Prêt supprimé']);
    }
}