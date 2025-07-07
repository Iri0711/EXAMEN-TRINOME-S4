<?php
require_once __DIR__ . '/../models/Etablissement.php';
require_once __DIR__ . '/../helpers/Utils.php';

class EtablissementController {
    public static function getAll() {
        $etablissements = Etablissement::getAll();
        Flight::json($etablissements);
    }

    public static function getById($id) {
        $etablissement = Etablissement::getById($id);
        Flight::json($etablissement);
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